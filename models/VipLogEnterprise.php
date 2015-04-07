<?php
/**
 * @abstract 企业版操作日志表
 * @author litingwei litingwei@sohu-inc.com
 * @since  2014年10月10日19:18:14
 */
class VipLogEnterprise extends BaseModel
{
	
	const LOG_ENT_TYPE=1;//公司帐号
	const LOG_AREA_TYPE=2;//区域帐号
	const LOG_AGENT_TYPE=3;//门店帐号 
	
	const LOG_ACTION_ADD=1;//添加日志
	const LOG_ACTION_UPDATE=2;//修改日志
	const LOG_ACTION_DEL=3;//删除日志
	const LOG_ACTION_OTHER=4;//其它日志
	const LOG_ACTION_OPEN = 5;//启用日志
	const LOG_ACTION_STOP = 6;//停止日志
	
	
	public $id;
	public $accname;
	public $type;
	public $message;
	public $actionType;
	public $time;
	public $ip = null;
	public $realId = 0;
	public $comId = 0;
    public $cityId;

	public function getSource()
	{
		return 'vip_log_enterprise';
	}
	
	public function columnMap()
	{
		return array(
				'leId' => 'id',
				'leAccname' => 'accname',
				'leType' => 'type',
				'leMessage' => 'message',
				'leActionType' => 'actionType',
				'leTime' => 'time',
				'leIp' => 'ip',
				'realId' => 'realId',
				'comId' => 'comId',
                "cityId"    => "cityId"
		);
	}

	public function initialize()
	{
		$this->setReadConnectionService('esfSlave');
		$this->setWriteConnectionService('esfMaster');
	}
	
	/**
	 * 实例化对象
	 *
	 * @param type $cache
	 * @return \Area_Model
	 */
	public static function instance ($cache = true)
	{
		return parent::_instance(__CLASS__, $cache);
		return new self();
	}
}
