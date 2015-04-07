<?php

class CsLogRealtor extends BaseModel
{
    protected $id;
    protected $cityId;
    protected $operatorAccount;
    protected $operatorType;
    protected $operateIp;
    protected $realId;
    protected $comId;
    protected $actionType;
    protected $realType;
    protected $message;
    protected $operateTime;
    
    //操作类型
    const ACTION_MANUAL_OPEN     = 1; //手动开通
    const ACTION_EDIT            = 2; //修改
    const ACTION_DELETE          = 3; //删除
    const ACTION_MANUAL_STOP     = 4; //手动停止
    const ACTION_REAL_DELAY      = 5; //延续经纪人
    const ACTION_AUTO_OPEN       = 6; //自动开通
    const ACTION_AUTO_STOP       = 7; //自动停止
    const ACTION_MERGE_STOP      = 8; //合并停止
    const ACTION_MERGE_EFFECTIVE = 9; //合并有效
    
    //操作人类型
    const OPERATOR_SUPERADMIN = 1; //超级管理员
	const OPERATOR_ADMIN      = 2; //城市管理员
	const OPERATOR_CS         = 3; //客服
	const OPERATOR_SALE       = 4; //销售
	const OPERATOR_EDITOR     = 5; //楼盘编辑
    const OPERATOR_COMPANY    = 6; //公司
	const OPERATOR_SECTOR     = 7; //区域
	const OPERATOR_AGENT      = 8; //门店
	const OPERATOR_SYSTEM     = 9; //系统
    
    /**
     * 获取所有操作类型
     * @return array
     */
    public static function getAllActionTypes()
    {
        return array(
            self::ACTION_MANUAL_OPEN     => '手动开通',
            self::ACTION_EDIT            => '修改',
            self::ACTION_DELETE          => '删除',
            self::ACTION_MANUAL_STOP     => '手动停止',
            self::ACTION_REAL_DELAY      => '延续经纪人',
            self::ACTION_AUTO_OPEN       => '自动开通',
            self::ACTION_AUTO_STOP       => '自动停止',
            self::ACTION_MERGE_STOP      => '合并停止',
            self::ACTION_MERGE_EFFECTIVE => '合并有效'
        );
    }
    
    /**
     * 获取所有操作者类型
     * @return array
     */
    public static function getAllOperatorTypes()
    {
        return array(
            self::OPERATOR_SUPERADMIN => '超级管理员',
            self::OPERATOR_ADMIN      => '城市管理员',
            self::OPERATOR_CS         => '客服',
            self::OPERATOR_SALE       => '销售',
            self::OPERATOR_EDITOR     => '楼盘编辑',
            self::OPERATOR_COMPANY    => '公司',
            self::OPERATOR_SECTOR     => '区域',
            self::OPERATOR_AGENT      => '门店',
            self::OPERATOR_SYSTEM     => '系统'
        );
    }
    
    /**
     * 添加启用经纪人日志
     * @param array $userinfo
     * @param array $realInfo
     * @return boolean
     */
    public function addRealtorOpenLog($userinfo, $realInfo, $portInfo)
    {
        if(empty($userinfo) || empty($realInfo) || empty($portInfo))
        {
            return false;
        }
        $data = array();
        $port = Port::findFirst("id={$portInfo['portId']}", 0)->toArray();
        
        $this->begin();
        foreach($realInfo as $realtor)
        {
            $rs = self::instance();
            $rs->cityId = $realtor['cityId'];
            $rs->operatorAccount = $userinfo['accname'];
            $rs->operatorType = $userinfo['roleId'];
            $rs->operateIp = Utility::GetUserIP();
            $rs->realId = $realtor['id'];
            $rs->comId = $realtor['comId'];
            $rs->actionType = self::ACTION_MANUAL_OPEN;
            $rs->realType = Realtor::TYPE_COMPANY;
            $rs->operateTime = time();
            $stopTime = '0000-00-00' == $portInfo['stopTime'] ? '无限制' : $portInfo['stopTime'];
            $rs->message = "开通端口{$port['name']} 有效期至{$stopTime}";
            if(!$rs->create())
            {
                $this->rollback();
                return false;
            }
        }
        $this->commit();
        return true;
    }
    
    /**
     * 添加启用经纪人日志
     * @param array  $userinfo
     * @param array  $realInfo
     * @param string $expiryDate
     * @return boolean
     */
    public function delayRealtorPortLog($userinfo, $realIds, $expiryDate)
    {
        if(empty($userinfo) || empty($realIds) || empty($expiryDate))
        {
            return false;
        }
        $realInfo = Realtor::instance()->getRealtorByIds($realIds, 'id,comId,cityId');       
        $this->begin();
        foreach($realInfo as $realtor)
        {
            $rs = self::instance(false);
            $rs->cityId = $realtor['cityId'];
            $rs->operatorAccount = $userinfo['accname'];
            $rs->operatorType = $userinfo['roleId'];
            $rs->operateIp = Utility::GetUserIP();
            $rs->realId = $realtor['id'];
            $rs->comId = $realtor['comId'];
            $rs->actionType = self::ACTION_REAL_DELAY;
            $rs->realType = Realtor::TYPE_COMPANY;
            $rs->operateTime = time();
            $rs->message = "修改有效期至{$expiryDate}";
            if(!$rs->create())
            {
                $this->rollback();
                return false;
            }
        }
        $this->commit();
        return true;
    }
    
    /**
     * 添加启用经纪人日志
     * @param array  $userinfo
     * @param array  $portInfos
     * @return boolean
     */
    public function stopRealtorPortLog($userinfo, $portInfos)
    {
        if(empty($userinfo) || empty($portInfos))
        {
            return false;
        }
        $portIds = $realIds = $realtors = array();
        foreach($portInfos as $v)
        {
            $portIds[] = $v['portId'];
            $realIds[] = $v['realId'];
            $realtors[$v['realId']] = $v['portId'];
        }
        $realInfo = Realtor::instance()->getRealtorByIds($realIds, 'id,comId,cityId'); 
        $portInfo = PortCity::instance()->getPortByIds($portIds, 'id,type,equivalent');
        
        $this->begin();
        foreach($realInfo as $realtor)
        {
            $port = $portInfo[$realtors[$realtor['id']]];
            $num = $port['equivalent'];
            if(PortCity::STATUS_Rent == $port['type'])
            {
                $type = '出租';
            }
            elseif(PortCity::STATUS_Sale == $port['type'])
            {
                $type = '出售';
            }
            $time = date('Y年m月d日');
                
            $rs = self::instance(false);
            $rs->cityId = $realtor['cityId'];
            $rs->operatorAccount = $userinfo['accname'];
            $rs->operatorType = $userinfo['roleId'];
            $rs->operateIp = Utility::GetUserIP();
            $rs->realId = $realtor['id'];
            $rs->comId = $realtor['comId'];
            $rs->actionType = self::ACTION_MANUAL_STOP;
            $rs->realType = Realtor::TYPE_COMPANY;
            $rs->operateTime = time();
            $rs->message = "{$num}个{$type}端口<br />停止时间:{$time}";
            if(!$rs->create())
            {
                $this->rollback();
                return false;
            }
        }
        $this->commit();
        return true;
    }
    
    /**
     * 添加log日志
     * @param array $userinfo
     * @param array $data
     * @return boolean
     */
    public function addLog($userinfo, $data)
    {
        $rs = self::instance();
        
        $rs->cityId = $data['cityId'];
        $rs->operatorAccount = $userinfo['accname'];
        $rs->operatorType = $userinfo['roleId'];
        $rs->operateIp = Utility::GetUserIP();
        $rs->realId = $data['id'];
        $rs->comId = $data['comId'];
        $rs->actionType = $data['actionType'];
        $rs->realType = $data['realType'];
        $rs->operateTime = time();
        $rs->message = $data['message'];
        
        if($rs->create())
        {
            return true;
        }
        return false;      
    }
    
    public function setLrid($lrId)
    {
        $this->id = $lrId;
    }

    public function setCityid($cityId)
    {
        $this->cityId = $cityId;
    }

    public function setLroperatoraccount($lrOperatorAccount)
    {
        $this->operatorAccount = $lrOperatorAccount;
    }

    public function setLroperatortype($lrOperatorType)
    {
        $this->operatorType = $lrOperatorType;
    }

    public function setLroperateip($lrOperateIp)
    {
        $this->operateIp = $lrOperateIp;
    }

    public function setRealid($realId)
    {
        $this->realId = $realId;
    }

    public function setComid($comId)
    {
        $this->comId = $comId;
    }

    public function setLsactiontype($lsActionType)
    {
        $this->actionType = $lsActionType;
    }

    public function setRealtype($realType)
    {
        $this->realType = $realType;
    }

    public function setLrmessage($lrMessage)
    {
        $this->message = $lrMessage;
    }

    public function setLroperatetime($lrOperateTime)
    {
        $this->operateTime = $lrOperateTime;
    }

    public function getLrid()
    {
        return $this->id;
    }

    public function getCityid()
    {
        return $this->cityId;
    }

    public function getLroperatoraccount()
    {
        return $this->operatorAccount;
    }

    public function getLroperatortype()
    {
        return $this->operatorType;
    }

    public function getLroperateip()
    {
        return $this->operateIp;
    }

    public function getRealid()
    {
        return $this->realId;
    }

    public function getComid()
    {
        return $this->comId;
    }

    public function getLsactiontype()
    {
        return $this->actionType;
    }

    public function getRealtype()
    {
        return $this->realType;
    }

    public function getLrmessage()
    {
        return $this->message;
    }

    public function getLroperatetime()
    {
        return $this->operateTime;
    }
    
    public function getSource()
    {
    	return 'admin_cs_log_realtor';
    }

    public function columnMap()
    {
        return array(
            'lrId'              => 'id', 
            'cityId'            => 'cityId', 
            'lrOperatorAccount' => 'operatorAccount', 
            'lrOperatorType'    => 'operatorType', 
            'lrOperateIp'       => 'operateIp', 
            'realId'            => 'realId', 
            'comId'             => 'comId', 
            'lsActionType'      => 'actionType', 
            'realType'          => 'realType', 
            'lrMessage'         => 'message', 
            'lrOperateTime'     => 'operateTime'
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
     * @return CsLogReator_Model
     */

    public static function instance($cache = true) 
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
}
