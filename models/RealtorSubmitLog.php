<?php
/**
 * @abstract 经纪人个人信息提交日志表
 * @author litingwei litingwei@sohu-inc.com
 * @since  2015年1月7日11:06:16
 */
class RealtorSubmitLog extends BaseModel
{
	//提交之前认证状态
	const CETIFICATION_NO = 1;
	const CETIFICATION_NOT = 2;

	public $id;
	public $realId;
	public $type;
	public $operateTime;

	public function getSource()
	{
		return 'realtor_submit_log';
	}

	public function columnMap()
	{
		return array(
				'rsId' => 'id',
				'realId' => 'realId',
				'rsType' => 'type',
				'rsOperateTime' => 'operateTime'
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
	 * @return RealtorInformationAuditing_Model
	 */

	public static function instance($cache = true)
	{
		return parent::_instance(__CLASS__, $cache);
		return new self;
	}
}