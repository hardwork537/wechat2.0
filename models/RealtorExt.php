<?php
class RealtorExt extends BaseModel
{
    const STATUS_VALID =1;
    const STATUS_NOVALID =0;
    const STATUS_DELETE =-1;
    protected $id;
    protected $alId;
    protected $name;
    protected $value = '';
    protected $length = 0;
    protected $status = 1;
    protected $update;

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

    public function getAlId()
    {
        return $this->alId;
    }

    public function setAlId($alId)
    {
        if(preg_match('/^\d{1,10}$/', $alId == 0) || $alId > 4294967295)
        {
            return false;
        }
        $this->alId = $alId;
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
        return 'realtor_ext';
    }

    public function columnMap()
    {
        return array(
            'reId' => 'id',
            'realId' => 'alId',
            'reName' => 'name',
            'reValue' => 'value',
            'reLength' => 'length',
            'reStatus' => 'status',
            'reUpdate' => 'update'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    
    /**
     * 实例化
     * @param type $cache
     * @return RealtorExt_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
    
    /*
         * 获取小区扩展信息
         * by Moon
         */
    public function getRealtorExtByIdName($realId,$name){
        if (!$realId) return false;
        $arrCondition['conditions'] = "status = ".self::STATUS_VALID." and alId=:realId: and name=:name:";
        $arrCondition['bind'] = array(
            "realId"    =>  $realId,
            'name'  =>  $name
        );
        return self::findFirst($arrCondition,0)->toArray();
    }
    
    /**
     * 根据经纪人id获取门店扩展信息
     * @param type $realIds
     * @param type $columns
     * @return type
     */
    public function getRealExtByIds($realIds, $columns = '', $name = '门店信息')
    {
        if(empty($realIds))
        {
            return array();
        }
		if(is_array($realIds))
		{
			$arrBind = $this->bindManyParams($realIds);
			$arrCond = "alId in({$arrBind['cond']}) and name='{$name}' and status=".self::STATUS_VALID;
			$arrParam = $arrBind['param'];
            $condition = array(
					$arrCond,
					"bind" => $arrParam,
			);           
		}
		else
		{		
			$condition['conditions'] = "alId={$realIds} and name='{$name}' and status=".self::STATUS_VALID;
		}
        $columns && $condition['columns'] = $columns;
        $arrRealtor  = self::find($condition, 0)->toArray();
		$arrRrealtor = array();
		foreach($arrRealtor as $value)
		{
			$arrRrealtor[$value['alId']] = $value;
		}
		return $arrRrealtor;
    }
    
    /**
     * 
     * @param type $name
     * @param type $columns
     * @return type
     */
    public function getRealExtByName($name, $value, $columns = '')
    {
        if(!$name || !$value)
        {
            return array();
        }
        $condition = array(
            'conditions' => "name='{$name}' and value='{$value}' and status=".self::STATUS_VALID
        );
        $columns && $condition['columns'] = $columns;
        $arrRealtor  = self::find($condition, 0)->toArray();
		$arrRrealtor = array();
        
		foreach($arrRealtor as $value)
		{
			$arrRrealtor[$value['alId']] = $value;
		}
		return $arrRrealtor;
    }
    
    /**
     * 修改或添加经纪人扩展信息
     * @param int    $realId
     * @param string $name
     * @param string $value
     * @param int    $status
     * @return boolean
     */
    public function updateRealExtById($realId, $name, $value, $status = self::STATUS_VALID)
    {
        $rs = self::findfirst("alId={$realId} and name='{$name}'");
        if($rs)
        {
            //如果存在，则进行修改
            $rs->value = $value;
            $rs->length = mb_strlen($value, 'utf-8');
            $rs->status = $status;
            $rs->update = date('Y-m-d H:i:s');
            if($rs->update())
            {
                return true;
            }
            return false;
        }
        else
        {
            $rs = self::instance();
            $rs->alId = $realId;
            $rs->name = $name;
            $rs->value = $value;
            $rs->length = mb_strlen($value, 'utf-8');
            $rs->status = $status;
            if($rs->create())
            {
                return true;
            }
            return false;
        }
    }
}