<?php
class LimitPrice extends BaseModel
{
	const TYPE_JS	= 1;	//js触发
	const TYPE_PHP 	= 2;	//php触发
	
	protected $id;
	protected $realId;
	protected $type;
	protected $time;
	
	public function getSource()
	{
		return 'vip_limit_price';
	}
	
	public function columnMap()
	{
		return array(
			'lowerlimitId' => 'id',
			'realId' => 'realId',
			'lowerlimitType' => 'type',
			'lowerlimitTime' => 'time',
		);
	}
	
	public function initialize()
	{
		$this->setReadConnectionService('esfSlave');
		$this->setWriteConnectionService('esfMaster');
	}
	
	/**
	 * 添加触发房源均价下限统计表记录
	 * @param unknown $strRealId
	 * @param unknown $intType
	 * @return boolean
	 */
	public function addLowerLimitAvgPrice( $strRealId , $intType )
	{
		if( empty($strRealId) || empty($intType) )	return false;
		
		$arrInsert = array('time'	=> date('Y-m-d H:i:s'));
		$arrInsert['realId'] = $strRealId;
		$arrInsert['type'] = $intType;
		
		return self::create($arrInsert);
	}
}