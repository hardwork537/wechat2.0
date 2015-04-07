<?php
/**
 * @abstract 微信服务号操作类
 * @author By jackchen
 * @date 2014-09-01
 */
class RealtorWeixin extends BaseModel
{
    const STATUS_BIND = 1;      //绑定
    const STATUS_UNBIND = 0;    //解除绑定

    protected $id;
    protected $weixinId;
    protected $realId;
    protected $bindTime;
    protected $status;

    public static function getInstance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self();
    }

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

    public function getWeixinId()
    {
        return $this->weixinId;
    }

    public function setWeixinId($weixinId)
    {
        if($weixinId == '' || mb_strlen($weixinId, 'utf8') > 50)
        {
            return false;
        }
        $this->weixinId = $weixinId;
    }

    public function getRealId()
    {
        return $this->realId;
    }

    public function setRealId($realId)
    {
        if(preg_match('/^\d{1,10}$/', $realId == 0) || $realId > 4294967295)
        {
            return false;
        }
        $this->realId = $realId;
    }

    public function getBindTime()
    {
        return $this->bindTime;
    }

    public function setBindTime($bindTime)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $bindTime) == 0 || strtotime($bindTime) == false)
        {
            return false;
        }
        $this->bindTime = $bindTime;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        if(preg_match('/^\d{1,3}$/', $status == 0) || $status > 255)
        {
            return false;
        }
        $this->status = $status;
    }

    public function getSource()
    {
        return 'weixin_realtor';
    }

    public function columnMap()
    {
        return array(
            'rwId' => 'id',
            'weixinId' => 'weixinId',
            'realId' => 'realId',
            'bindTime' => 'bindTime',
            'status' => 'status'
        );
    }

    /**
     * 根据微信提供的openid获取绑定信息
     *
     * @param int $weixinId 微信提供的openid
     * @return  boolean|array   $data
     */
    public function getBrokerIdByOpenId($weixinId)
    {
        if(!$weixinId){
            return false;
        }
        $arrCond  = "weixinId = ?1";
        $weixinId = Utility::filterSubject($weixinId);
        $arrParam = array(1=>$weixinId);
        $data = self::findFirst(
            array(
                $arrCond,
                "bind" => $arrParam
            ),0
        );
        return $data;
    }

    /**
     * 保存经纪人和微信账号的绑定关系
     * @param int $openid
     * @param int $broker_id
     * @return boolean
     */
    public function Insert($openid, $broker_id)
    {
        $openid = Utility::filterSubject($openid);
        if(preg_match('/^\d{1,20}$/', $broker_id) == 0)
        {
            return false;
        }

        $rs = self::getInstance();
        $rs->weixinId = $openid;
        $rs->realId =  $broker_id;
        $rs->bindTime = date('Y-m-d H:i:s');
        $rs->status = self::STATUS_BIND;

        if ($rs->create()) {
            return true;
        }
        return false;
    }

    /**
     * 取消微信账号和经纪人账号的绑定
     * @param string $weixinId
     * @return boolean $intFlag
     */
    public function cancelRelationBind($weixinId)
    {
        if(empty($weixinId)){
            return false;
        }
        $weixinId = Utility::filterSubject($weixinId);
        $arrCond  = "weixinId = ?1";
        $arrParam = array(1=>$weixinId);
        $objRealtorWeixin  = self::findFirst(
            array(
                $arrCond,
                "bind" => $arrParam
            )
        );
        $objRealtorWeixin->bindTime = date('Y-m-d H:i:s');
        $objRealtorWeixin->status = RealtorWeixin::STATUS_UNBIND;
        $intFlag = $objRealtorWeixin->update();
        if( !$intFlag )
        {
           return false;
        }
        return $intFlag;
    }


    /**
     * 微信账号和经纪人账号的绑定
     * @param string $weixinId
     * @return boolean $intFlag
     */
    public function  RelationBind($weixinId,$realId)
    {
        if(empty($weixinId)){
            return false;
        }
        $weixinId = Utility::filterSubject($weixinId);
        $arrCond  = "weixinId = ?1";
        $arrParam = array(1=>$weixinId);
        $objRealtorWeixin  = self::findFirst(
            array(
                $arrCond,
                "bind" => $arrParam
            )
        );
        $objRealtorWeixin->bindTime = date('Y-m-d H:i:s');
        $objRealtorWeixin->realId = $realId;
        $objRealtorWeixin->status = RealtorWeixin::STATUS_BIND;
        $intFlag = $objRealtorWeixin->update();
        if( !$intFlag )
        {
            return false;
        }
        return $intFlag;
    }


    /**
     * 记录登陆日志
     * @param int $vaId
     * * @param int $realId
     * * @param int $shopId
     * * @param int $comId
     * @return boolean
     */
    public function addLog($vaId,$realId,$shopId,$comId)
    {
        $clsLogDaily = new VipLogDaily();
        $clsLogDaily->begin();
        $objLogDaily = $clsLogDaily::findFirst(array("vaId=".$vaId." AND date='".date('Y-m-d', time())."'"));
        $loginData = array(
            'vaId'   => $vaId,
            'realId' => $realId,
            'shopId' => $shopId,
            'comId'  => $comId,
            'date'   => date('Y-m-d', time()),
            'loginTime'  => date('Y-m-d H:i:s', time()),
            'logWeixin'  => empty($objLogDaily) ? 1 : ($objLogDaily->logWeixin+1)
        );
        if (empty($objLogDaily))
        {
            $result = $clsLogDaily->create($loginData);
        }
        else
        {
            $result = $objLogDaily->update($loginData);
        }
        if ($result)
        {
            $clsLogDaily->commit();
            return true;
        }
        else
        {
            $clsLogDaily->rollback();
            return false;
        }
    }



    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
}