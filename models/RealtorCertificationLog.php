<?php

class RealtorCertificationLog extends BaseModel
{
    protected $id;
    protected $cityId;
    protected $realId;
    protected $source;
    protected $status;
    protected $denyId;
    protected $actionType;
    protected $operatorId;
    protected $operateIp;
    protected $operateTime;
    
    //操作类型
    const ACTION_MANUAL_OPEN = 1; //手动认证
    const ACTION_AUTO_OPEN   = 2; //自动认证
    
    //操作人类型
    const SOURCE_FROM_ADMIN = 1; //admin
	const SOURCE_FROM_VIP   = 2; //vip焦点通
    
    //认证结果
    const STATUS_PASS = 1;    //通过
    const STATUS_UNPASS = 2;  //拒绝
    
    public function setRcId($rcId)
    {
        $this->id = $rcId;
    }

    public function setCityid($cityId)
    {
        $this->cityId = $cityId;
    }

    public function setRealId($realId)
    {
        $this->realId = $realId;
    }

    public function setRcSource($rcSource)
    {
        $this->source = $rcSource;
    }

    public function setRcStatus($rcStatus)
    {
        $this->status = $rcStatus;
    }

    public function setRcDenyId($rcDenyId)
    {
        $this->denyId = $rcDenyId;
    }

    public function setRcActionType($rcActionType)
    {
        $this->actionType = $rcActionType;
    }

    public function setRcOperatorId($rcOperatorId)
    {
        $this->operatorId = $rcOperatorId;
    }

    public function setRcOperateIp($rcOperateIp)
    {
        $this->operateIp = $rcOperateIp;
    }

    public function setRcOperateTime($rcOperateTime)
    {
        $this->operateTime = $rcOperateTime;
    }
    
    public function getRcId()
    {
        return $this->id;
    }

    public function getCityid()
    {
        return $this->cityId;
    }

    public function getRealId()
    {
        return $this->realId;
    }

    public function getRcSource()
    {
        return $this->source;
    }

    public function getRcStatus()
    {
        return $this->status;
    }

    public function getRcDenyId()
    {
        return $this->denyId;
    }

    public function getRcActionType()
    {
        return $this->actionType;
    }

    public function getRcOperatorId()
    {
        return $this->operatorId;
    }

    public function getRcOperateIp()
    {
        return $this->operateIp;
    }

    public function getRcOperateTime()
    {
        return $this->operateTime;
    }
    
    public function getSource()
    {
    	return 'realtor_certification_log';
    }

    public function columnMap()
    {
        return array(
            'rcId'          => 'id', 
            'cityId'        => 'cityId', 
            'realId'        => 'realId', 
            'rcSource'      => 'source', 
            'rcStatus'      => 'status', 
            'rcDenyId'      => 'denyId', 
            'rcActionType'  => 'actionType', 
            'rcOperatorId'  => 'operatorId', 
            'rcOperateIp'   => 'operateIp', 
            'rcOperateTime' => 'operateTime',
        );
    }
    
    /**
     * 增加经纪人认证日志
     * @param type $data
     * @return boolean
     */
    public function addCertLog($data)
    {
        if(empty($data))
        {
            return false;
        }
        $tableName = $this->getSource();
        $insertSql = "INSERT INTO {$tableName}(cityId,realId,rcSource,rcStatus,rcDenyId,rcActionType,rcOperatorId,rcOperateIp,rcOperateTime) VALUES";
        $insertData = '';
        foreach($data as $value)
        {
            $cityId = intval($value['cityId']);        
            $realId = intval($value['realId']);         //被操作的经纪人
            $source = intval($value['source']);         //频道来源  1.admin  2.vip
            $status = intval($value['status']);         //认证结果  1.通过   2.拒绝
            $denyId = intval($value['denyId']);         //拒绝理由  同 realtor 表中的 denyId, 通过时默认为0
            $actionType = intval($value['actionType']); //操作类型  1.手工认证 2.自动认证
            $operatorId = intval($value['operatorId']); //操作人
            $operateIp = trim($value['operateIp']);     //操作人ip
            $operateTime = time();                      //操作时间
            $insertData .= "({$cityId},{$realId},{$source},{$status},{$denyId},{$actionType},{$operatorId},'{$operateIp}',{$operateTime}),";
        }
        
        if($insertData)
        {
            $insertSql .= rtrim($insertData, ',');
            $addRes = $this->execute($insertSql);
            
            return $addRes;
        }
        else
        {
            return false;
        }
    }
    
    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    
    /**
     * 实例化
     * @param type $cache
     * @return CsLogReator_Model
     */

    public static function instance($cache = true) 
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
}
