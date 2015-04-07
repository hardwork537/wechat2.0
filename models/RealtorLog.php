<?php
/**
 * @abstract 微信日志类
 * @author By jackchen
 * @date 2014-09-01
 */
class RealtorLog extends BaseModel
{

    const LOGTYPE_FLUSH_COMMON = 1;	/*手动刷新*/
    const LOGTYPE_FLUSH_GOOD = 2;	/*一键刷新高清房源*/
    const LOGTYPE_UPDOWN = 3;		/*上下架房源*/
    const LOGTYPE_DOWN_WEIGUI = 4;	/*一键下架违规房源*/
    const LOGTYPE_SHARE = 5;		/*进入房源分享列表页面*/
    const LOGTYPE_CHECK_DABIAO = 6; /*检查是否达标*/
    const LOGTYPE_REPROT = 7;		/*高清房源报表*/
    const LOGTYPE_FLUSH_SUCCESS = 8; /*刷新成功*/
    const LOGTYPE_UPDOWN_SUCCESS = 9; /*上下架成功*/
    const LOGTYPE_SHARE_CLICK = 10;   /*分享房源按钮点击量*/
    const LOGTYPE_GHOUSE_CLICK = 11;   /*参与活动*/

    protected $logId;
    protected $realId;
    protected $logType;
    protected $logTime;

    public static function getInstance( $cache=true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self();
    }

    public function getLogId()
    {
        return $this->logId;
    }

    public function setLogId($logId)
    {
        if(preg_match('/^\d{1,10}$/', $logId == 0) || $logId > 4294967295)
        {
            return false;
        }
        $this->logId = $logId;
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

    public function getLogType()
    {
        return $this->logType;
    }

    public function setLogType($logType)
    {
        if(preg_match('/^\d{1,3}$/', $logType == 0) || $logType > 255)
        {
            return false;
        }
        $this->logType = $logType;
    }

    public function getLogTime()
    {
        return $this->logTime;
    }

    public function setLogTime($logTime)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $logTime) == 0 || strtotime($logTime) == false)
        {
            return false;
        }
        $this->logTime = $logTime;
    }

    public function getSource()
    {
        return 'weixin_realtor_log';
    }

    public function columnMap()
    {
        return array(
            'logId' => 'logId',
            'realId' => 'realId',
            'logType' => 'logType',
            'logTime' => 'logTime'
        );
    }

    /**
     * 保存经纪人和微信账号的绑定关系
     * @param array $arrData
     * @return boolean
     */
    public  function InsertLog($arr)
    {
        $rs = self::getInstance();
        $rs->realId = $arr["realId"];
        $rs->logType = $arr["logType"];
        $rs->logTime = date('Y-m-d H:i:s');

        if ($rs->create()) {
            return true;
        }
        return false;
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
}