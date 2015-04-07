<?php
class HouseExt extends BaseModel
{
    public $id;
    public $houseId;
    public $name = '';
    public $value = '';
    public $length = 0;
    public $status;
    public $update;

    const HOUSE_EXT_STAUTS_FAILURE = 0;		//失效
    const HOUSE_EXT_STAUTS_EFFECTIVITY = 1;	//有效
    const HOUSE_EXT_STAUTS_DELETE = -1;		//删除
    
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

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        if($value == '' || mb_strlen($value, 'utf8') > 250)
        {
            return false;
        }
        $this->value = $value;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        if(preg_match('/^\d{1,3}$/', $length == 0) || $length > 255)
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
        return 'house_ext';
    }

    public function columnMap()
    {
        return array(
            'heId' => 'id',
            'houseId' => 'houseId',
            'heName' => 'name',
            'heValue' => 'value',
            'heLength' => 'length',
            'heStatus' => 'status',
            'heUpdate' => 'update'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    
    /**
     * 添加房源描述表
     * @param unknown $arrData
     */
    public function addHouseExt( $arrData )
    {
    	if( empty($arrData) )	return false;
    	 
    	$arrInsert = array();
    	$arrInsert['houseId']	=	$arrData['houseId'];
    	$arrInsert['status']	=	self::HOUSE_EXT_STAUTS_EFFECTIVITY;
    	$arrInsert['update']	=	date('Y-m-d H:i:s');
    	if(!empty($arrData['customId'])) 
    	{
    		$arrInsert['name'] = 'customId';
    		$arrInsert['value'] = $arrData['customId'];
    	}	
    	
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
     * 根据客户编号获取房源
     * @param unknown $strCustomId
     * @param unknown $intRealId
     * @return multitype:
     */
    public function getSaleByCustomId( $strCustomId , $intRealId , $intHouseType = '' )
    {
    	if( empty($strCustomId) || empty($intRealId) )		return array();
    	
    	$strCondition = "h.realId = ".$intRealId;
		$strCondition .= " AND h.status IN(".House::STATUS_ONLINE.",".House::STATUS_OFFLINE.")";
		$strCondition .= " AND name = 'customId' AND value = '" . $strCustomId . "'";

		if(!empty($intHouseType)) $strCondition .= " AND h.type = {$intHouseType}";
		
		$objHouse = self::query()
			->columns(' h.realId,h.id,h.tags ')
			->where($strCondition)
			->leftJoin('House', 'h.id = houseId', 'h')
			->execute()
			->getFirst();
		$arrHouse = array();
		if(!empty($objHouse))
		{
			$arrHouse = $objHouse->toArray();
			
		}
		return $arrHouse;
    }

    public function getSaleByHouseIdName($houseId, $name){
        if (!$houseId || !$name) return false;
        $arrCondition['conditions'] = "houseId=:houseId: and name=:name:";
        $arrCondition['bind'] = array(
            "houseId"   =>  $houseId,
            'name'  =>  $name
        );
        return self::findFirst($arrCondition, 0)->toArray();
    }

}
