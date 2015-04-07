<?php
/**
 * @abstract 插入刷新队列失败记录表
 * @author Raul
 * @since  date 2014/11/17
 */
class VipRefreshQueueError extends BaseModel
{
	public $id;
	public $realId;
	public $refreshTime;
	public $houseType;
	public $houseId;
	public $shopId;
	public $comId;
	public $areaId;
	public $parkId;
	public $quality;
	
	public static function instance ($cache = true)
	{
		return parent::_instance(__CLASS__, $cache);
		return new self();
	}
	
	public function getSource()
	{
		return 'vip_refresh_queue_error';
	}
	
	public function columnMap()
	{
		return array(
				'rqId' 			=> 'id',
				'realId' 		=> 'realId',
				'refreshTime' 	=> 'refreshTime',
				'houseType' 	=> 'houseType',
				'houseId' 		=> 'houseId',
				'shopId' 		=> 'shopId',
				'comId' 		=> 'comId',
				'areaId'		=> 'areaId',
				'parkId'		=> 'parkId',
				'quality'		=> 'quality',
		);
	}
	
	public function initialize()
	{
		$this->setReadConnectionService('esfSlave');
		$this->setWriteConnectionService('esfMaster');
	}
}