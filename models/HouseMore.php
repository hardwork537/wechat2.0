<?php
class HouseMore extends BaseModel
{
    public $id;
    public $houseId;
    public $name = '';
    public $text = '';
    public $length = 0;
    public $status;
    public $update;
    
    const HOUSE_MORE_STAUTS_FAILURE = 0;		//失效
    const HOUSE_MORE_STAUTS_EFFECTIVITY = 1;	//有效
    const HOUSE_MORE_STAUTS_DELETE = -1;		//删除

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if(preg_match('/^\d{1,10}$/', $id == 0) || $id > 4294967295)
        {
            return false;
        }
        $this->id = $id;
    }

    public function getHouseId()
    {
        return $this->houseId;
    }

    public function setHouseId($houseId)
    {
        if(preg_match('/^\d{1,10}$/', $houseId == 0) || $houseId > 4294967295)
        {
            return false;
        }
        $this->houseId = $houseId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if($name == '' || mb_strlen($name, 'utf8') > 50)
        {
            return false;
        }
        $this->name = $name;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        if($text == '' || strlen($text) > 65535)
        {
            return false;
        }
        $this->text = $text;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        if(preg_match('/^\d{1,5}$/', $length == 0) || $length > 65535)
        {
            return false;
        }
        $this->length = $length;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        if(preg_match('/^-?\d{1,3}$/', $status) == 0 || $status > 127 || $status < -128)
        {
            return false;
        }
        $this->status = $status;
    }

    public function getUpdate()
    {
        return $this->update;
    }

    public function setUpdate($update)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $update) == 0 || strtotime($update) == false)
        {
            return false;
        }
        $this->update = $update;
    }

    public function getSource()
    {
        return 'house_more';
    }

    public function columnMap()
    {
        return array(
            'hmId' => 'id',
            'houseId' => 'houseId',
            'hmName' => 'name',
            'hmText' => 'text',
            'hmLength' => 'length',
            'hmStatus' => 'status',
            'hmUpdate' => 'update'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    
    /**
     * 添加房源描述
     * @param unknown $arrDate
     */
    public function addHouseDesc( $arrData )
    {
    	if( empty($arrData) ) return false;
    	
    	$arrInsert = array();
    	$arrInsert['houseId']	=	$arrData['houseId'];
    	$arrInsert['name']		=	isset( $arrData['hmName'] ) ? $arrData['hmName'] : 'description';
    	$arrInsert['text']		=	isset( $arrData['description']) ? $arrData['description'] : new Phalcon\Db\RawValue("''");
    	$arrInsert['length']	=	isset( $arrData['description']) ? mb_strlen( Utility::filterSubject($arrData['description'],true) ,'utf-8') : 0;
    	$arrInsert['status']	=	self::HOUSE_MORE_STAUTS_EFFECTIVITY;
    	$arrInsert['update']	=	date('Y-m-d H:i:s');
    	
    	try 
    	{
    		return self::create($arrInsert);
    	}
    	catch (Exception $ex)
    	{
    		return false;
    	}
    }
    
    /**
     * 修改房源描述
     * @param unknown $arrDate
     */
    public function modifyHouseDesc( $intHouseId, $arrData )
    {

    	if( empty($arrData) ) return false;
    	
    	$arrUpdate = array();
    	$arrUpdate['name']		=	empty( $arrData['hmName'] ) ? 'description' : $arrData['hmName'];
    	$arrUpdate['text']		=	empty( $arrData['description']) ? new Phalcon\Db\RawValue("''") : $arrData['description'];
    	$arrUpdate['length']	=	empty( $arrData['description']) ? 0 : mb_strlen( Utility::filterSubject($arrData['description'],true) ,'utf-8');
    	$arrUpdate['status']	=	self::HOUSE_MORE_STAUTS_EFFECTIVITY;
    	$arrUpdate['update']	=	date('Y-m-d H:i:s');
    	
    	$objHouseMore = self::findFirst("houseId = ".$intHouseId." AND name = 'description'");
    	if ($objHouseMore) {
			$intFlag = $objHouseMore->update($arrUpdate);
    	} else {
			$arrData['houseId']	=	$intHouseId;
			$intFlag = $this->addHouseDesc($arrData);
		}
    	return $intFlag;
    }

    /**
     * 获取指定房源的扩展信息
     *
     * @param int|array $ids 数组为获取多条信息
     * @return array
     * by Moon
     */
    public function getUnitExtById($ids) {
        if (!$ids) return array();
        $arrCondition['conditions'] = 'name="description"';
        if (is_numeric($ids)){
            $arrCondition['conditions'] .= " and houseId=".$ids;
        }
        else if (!is_array($ids)){
            return array();
        }
        else{
            $arrCondition['conditions'] .= ' and houseId in ('.join(',', $ids).")";
        }
        $return = self::find($arrCondition,0)->toArray();
        if (!$return) return array();
        $arrBackData = array();
        foreach ( $return as $value) {
            $value['houseDescription'] = stripcslashes($value['text']);
            $arrBackData[$value['houseId']] = $value;
        }

        if(is_numeric($ids)) return reset($arrBackData);
        return $arrBackData;
    }
}
