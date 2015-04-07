<?php
/**
 * @abstract 经纪人刷新时段统计表
 * @author Raul
 * @since  date 2014/9/20
 */
class VipHourRefreshLog extends BaseModel
{
	protected $id;
    protected $comId;
    protected $shopId;
    protected $realId;
    protected $type;
    protected $time8;
    protected $time9;
    protected $time10;
    protected $time11;
    protected $time12;
    protected $time13;
    protected $time14;
    protected $time15;
    protected $time16;
    protected $time17;
    protected $time18;
    protected $time19;
    protected $time20;
    protected $time21;
    protected $time22;
    protected $time23;
    protected $unrefresh;
    protected $recordTime;

    public function columnMap ()
    {
        return array(
        		'vhrlId'			=> 'id',
        		'comId'				=> 'comId',
        		'shopId'			=> 'shopId',
        		'realId'			=> 'realId',
        		'houseType'			=> 'houseType',
        		'vhrlTime8'			=> 'time8',
        		'vhrlTime9'			=> 'time9',
        		'vhrlTime10'		=> 'time10',
        		'vhrlTime11'		=> 'time11',
        		'vhrlTime12'		=> 'time12',
        		'vhrlTime13'		=> 'time13',
        		'vhrlTime14'		=> 'time14',
        		'vhrlTime15'		=> 'time15',
        		'vhrlTime16'		=> 'time16',
        		'vhrlTime17'		=> 'time17',
        		'vhrlTime18'		=> 'time18',
        		'vhrlTime19'		=> 'time19',
        		'vhrlTime20'		=> 'time20',
        		'vhrlTime21'		=> 'time21',
        		'vhrlTime22'		=> 'time22',
        		'vhrlTime23'		=> 'time23',
        		'vhrlUnrefresh'		=> 'unrefresh',
        		'vhrlRecordTime'	=> 'recordTime',
        );
    }

    public function getSource()
    {
    	return 'vip_hour_refresh_log';
    }
    
	public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    
    /**
     * 取得经纪人历史房源刷新时段数据统计
     * @param unknown $intRealtorID
     * @param string $unit_type  1:出售 2:出租
     * @return Ambigous <multitype:, unknown>
     */
    public function getHistoryHourFlushByRealtorId($intRealtorID, $intHouseType = House::TYPE_SALE)
    {
    	if($intHouseType)
    		$strCondition = House::TYPE_CIXIN .',' .House::TYPE_ERSHOU;
    	else 
    		$strCondition = House::TYPE_ZHENGZU . ',' . House::TYPE_HEZU;
    	
    	$objDataList = self::find("realId IN ( {$intRealtorID} ) and houseType in ($strCondition)");
    	$arrDataList = $returnData = array(); 
    	if( empty($objDataList) )
    		return $arrDataList;
    	else 
    		$arrDataList = $objDataList->toArray();
    	
    	foreach ($arrDataList as $data)
    	{
    		//2:出售 1:出租 与页面上post的type值一致
    		$strHouseType = '';
    		if( $data['houseType'] == House::TYPE_CIXIN ||  $data['houseType'] == House::TYPE_ERSHOU )
    			$strHouseType = House::TYPE_SALE;
    		else
    			$strHouseType = House::TYPE_RENT;
    		
    		$returnData[date("Y-m-d",strtotime($data['recordTime']))][$strHouseType] = $data;
    	}
    	unset($arrDataList);
    	return $returnData;
    }
}
