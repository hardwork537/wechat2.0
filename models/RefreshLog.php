<?php
/**
 * @abstract 刷新log
 * @author Eric xuminwan@sohu-inc.com
 * @since  2014年8月29日20:03:29
 */
class RefreshLog extends BaseModel
{
	public $id;
	public $time;
	public $realId;
	public $houseType;
	public $houseQuality;
	public $houseId;
	public $operationType = 0; //目前该字段用于区分是否是专营小区房源刷新
	public $isAuto;
	public $parkId;
	public $shopId =0;
	public $areaId=0;
	public $comId=0;
	
	const REFRESH_AUTO 	= 1;	//定时刷新
	const REFRESH_MANUL = 0;	//手动刷新
	
	const OP_PARK = 1;     //专营小区房源刷新
	const OP_HOUSE = 0;    //普通端口房源刷新

	public function columnMap()
	{
		return array(
   			'rlId' => 'id',
			'rlTime' => 'time',
			'realId' => 'realId',
			'houseType' => 'houseType',
            'houseQuality'=>'houseQuality',
			'houseId' => 'houseId',
			'rlOperationType' => 'operationType',
			'rlIsAuto' => 'isAuto',
			'parkId' => 'parkId',
			'shopId' => 'shopId',
			'areaId' => 'areaId',
			'comId' => 'comId',
		);
	}
	
	public static function instance ($cache = true)
	{
		return parent::_instance(__CLASS__, $cache);
		return new self();
	}
	
	public function initialize()
	{
		$this->setReadConnectionService('esfSlave');
		$this->setWriteConnectionService('esfMaster');
	}

    public function getSource()
    {
        return 'vip_refresh_log';
    }
	
	/**
	 * 添加刷新日志 
	 * @param unknown $arrData
	 */
	public function addRefreshLog( $arrData, $intHouseId )
	{
		if( empty($arrData) || empty($intHouseId) )	return false;
		
		$objPark = House::findFirst("id = {$intHouseId}");
		
		$arrInsert = array();
		$arrInsert['time']		=	time();
		$arrInsert['realId']	=	$arrData['realId'];
		$arrInsert['houseType']	=	$arrData['houseType'];
		$arrInsert['houseId']	=	$intHouseId;
		$arrInsert['isAuto']	=	isset($arrData['isAuto'])	?	$arrData['isAuto']	:	self::REFRESH_MANUL;
		$arrInsert['parkId']	=	$objPark->parkId;
		$arrInsert['shopId']	=	isset($arrData['shopId']) ? $arrData['shopId'] : 0;
		$arrInsert['areaId']	=	isset($arrData['areaId']) ? $arrData['areaId'] : 0;
		$arrInsert['comId']		=	isset($arrData['comId']) ? $arrData['comId'] : 0;
		
		return self::create($arrInsert);
	}
	
	/**
	 * 获取经纪人已刷新数量
	 * @param unknown $realId
	 * @param unknown $houseType
	 * @param unknown $strStratTime
	 * @param string $queue
	 * @param string $master
	 * @return unknown|number
	 */
	public function getUsedFlush($realId,$houseType,$strStratTime='',$queue = true,$intHouseID = '')
	{
		if(empty($strStratTime))
		{
			$intBtime = strtotime(date('Y-m-d'));
		}
		else
		{
			$intBtime = strtotime($strStratTime);
		}
		$where = " realId = $realId  and time >= $intBtime"; 
		if ($houseType == House::TYPE_SALE)
		{
		    $where .= " and houseType in (".House::TYPE_XINFANG.", ".House::TYPE_ERSHOU.", ".House::TYPE_CIXIN.")";
		}
		else 
		{
			$where .= " and houseType in (".House::TYPE_HEZU.", ".House::TYPE_ZHENGZU.")";
		}
		//默认为获取手动刷新数（用于计算刷新可用数）
		if($queue)
		{
			$where .= " and isAuto = " . self::REFRESH_MANUL;
		}
		if(!empty($intHouseID))
		{
			$where .= " and houseId = {$intHouseID} ";
		}
// 		$db = $this->getDi()->getShared('esfMaster');
// 		$arr = $db->fetchOne("SELECT count(*) as sum FROM vip_refresh_log where ".$where);
// 		return (int)$arr['sum'];
        return (int)self::count($where);
	}


    /**
     * 添加刷新日志  -- 批量
     * @auth jackchen
     * @param array $arrData
     * @return boolean
     */
    public function addLog( $arrData)
    {
        if( empty($arrData))	return false;
        $fileds = array(1=>'rlTime',2=>'realId',3=>'houseType',4=>'houseQuality',5=>'houseId',6=>'rlIsAuto',7=>'parkId',8=>'shopId',9=>'areaId',10=>'comId');
        $values = array(1=>time(),2=>$arrData['realId'],3=>$arrData['houseType'],4=>$arrData['houseQuality'],5=>$arrData['houseId'],6=>$arrData['isAuto'],7=>$arrData['parkId'],8=>$arrData['shopId'],9=>$arrData['areaId'],10=>$arrData['comId']);

        return self::insertAll($values,$fileds);
    }

    
    /**
     * @todo 取得经纪人当日房源刷新时段数据统计
     * @author lostsun@sohu-inc.com
     * @param array $broker_ids
     * @return array
     */
    public function getHourFlushByRealtorIds($intRealtorIDs, $intHouseType = 1)
    {
    	if( empty($intRealtorIDs)) return false;
    	
    	if( !is_array($intRealtorIDs))	return false;
    	
    	$strRealtorIDs = '';
    	foreach ($intRealtorIDs as $strVal)
    	{
    		$strRealtorIDs .= ',' . $strVal ;
    	}
    	
    	$nowtime = time();
    	$countTime = strtotime(date("Y-m-d H:10:00",$nowtime));
    	
    	//如果没有数据或者数据过期  则创建数据
    	$dayZeroTime = strtotime(date("Y-m-d 00:00:00",$nowtime));
    	if($nowtime>$countTime){
    		$endTime = strtotime(date("Y-m-d H:00:00",$nowtime));
    	}
    	else
    	{
    		$endTime = strtotime(date("Y-m-d H:00:00",strtotime("-1 hours",$nowtime)));
    	}
    	
    	if($intHouseType)
    		$strCondition = House::TYPE_CIXIN .',' .House::TYPE_ERSHOU;
    	else
    		$strCondition = House::TYPE_ZHENGZU . ',' . House::TYPE_HEZU;
    	
    	$objDataList = self::find("realId in (" . trim($strRealtorIDs,',') . ") and time >= {$dayZeroTime} and time <={$endTime}");
		$arrDataList = $objDataList->toArray();
    	
		$time9 = strtotime(date("Y-m-d 09:00:00",$nowtime));
    	$time10 = strtotime(date("Y-m-d 10:00:00",$nowtime));
    	$time11 = strtotime(date("Y-m-d 11:00:00",$nowtime));
    	$time12 = strtotime(date("Y-m-d 12:00:00",$nowtime));
    	$time13 = strtotime(date("Y-m-d 13:00:00",$nowtime));
    	$time14 = strtotime(date("Y-m-d 14:00:00",$nowtime));
    	$time15 = strtotime(date("Y-m-d 15:00:00",$nowtime));
    	$time16 = strtotime(date("Y-m-d 16:00:00",$nowtime));
    	$time17 = strtotime(date("Y-m-d 17:00:00",$nowtime));
    	$time18 = strtotime(date("Y-m-d 18:00:00",$nowtime));
    	$time19 = strtotime(date("Y-m-d 19:00:00",$nowtime));
    	$time20 = strtotime(date("Y-m-d 20:00:00",$nowtime));
    	$time21 = strtotime(date("Y-m-d 21:00:00",$nowtime));
    	$time22 = strtotime(date("Y-m-d 22:00:00",$nowtime));
    	$time23 = strtotime(date("Y-m-d 23:00:00",$nowtime));
    			
    	$brokerList = array();
    	$rtime = 0;
    	foreach ($arrDataList as $v)
    	{
    		//1:出售 2:出租 与页面上post的type值一致
    		$strHouseType = '';
    		if( $v['houseType'] == House::TYPE_CIXIN ||  $v['houseType'] == House::TYPE_ERSHOU )
    			$strHouseType = House::TYPE_SALE;
    		else
    			$strHouseType = House::TYPE_RENT;
    		
    		$rtime = intval($v['time']);
    		$brokerList[$v['realId']]['lasttime'] = $nowtime;
    		if($rtime>=$dayZeroTime && $rtime<$time9)
    		{
    			$brokerList[$v['realId']][$strHouseType]['t8'] = intval($brokerList[$v['realId']][$strHouseType]['t8'])+1;
    		}
    		elseif($rtime>=$time9 && $rtime<$time10){
    			$brokerList[$v['realId']][$strHouseType]['t9'] = intval($brokerList[$v['realId']][$strHouseType]['t9'])+1;
    		}
    		elseif($rtime>=$time10 && $rtime<$time11)
    		{
    			$brokerList[$v['realId']][$strHouseType]['t10'] = intval($brokerList[$v['realId']][$strHouseType]['t10'])+1;
    		}
    		elseif($rtime>=$time11 && $rtime<$time12)
    		{
    			$brokerList[$v['realId']][$strHouseType]['t11'] = intval($brokerList[$v['realId']][$strHouseType]['t11'])+1;
    		}
    		elseif($rtime>=$time12 && $rtime<$time13)
    		{
    			$brokerList[$v['realId']][$strHouseType]['t12'] = intval($brokerList[$v['realId']][$strHouseType]['t12'])+1;
    		}
    		elseif($rtime>=$time13 && $rtime<$time14)
    		{
    			$brokerList[$v['realId']][$strHouseType]['t13'] = intval($brokerList[$v['realId']][$strHouseType]['t13'])+1;
    		}
    		elseif($rtime>=$time14 && $rtime<$time15)
    		{
    			$brokerList[$v['realId']][$strHouseType]['t14'] = intval($brokerList[$v['realId']][$strHouseType]['t14'])+1;
    		}
    		elseif($rtime>=$time15 && $rtime<$time16)
    		{
    			$brokerList[$v['realId']][$strHouseType]['t15'] = intval($brokerList[$v['realId']][$strHouseType]['t15'])+1;
    		}
    		elseif($rtime>=$time16 && $rtime<$time17)
    		{
    			$brokerList[$v['realId']][$strHouseType]['t16'] = intval($brokerList[$v['realId']][$strHouseType]['t16'])+1;
    		}
    		elseif($rtime>=$time17 && $rtime<$time18)
    		{
    			$brokerList[$v['realId']][$strHouseType]['t17'] = intval($brokerList[$v['realId']][$strHouseType]['t17'])+1;
    		}
    		elseif($rtime>=$time18 && $rtime<$time19)
    		{
    			$brokerList[$v['realId']][$strHouseType]['t18'] = intval($brokerList[$v['realId']][$strHouseType]['t18'])+1;
    		}
    		elseif($rtime>=$time19 && $rtime<$time20)
    		{
    			$brokerList[$v['realId']][$strHouseType]['t19'] = intval($brokerList[$v['realId']][$strHouseType]['t19'])+1;
    		}
    		elseif($rtime>=$time20 && $rtime<$time21)
    		{
    			$brokerList[$v['realId']][$strHouseType]['t20'] = intval($brokerList[$v['realId']][$strHouseType]['t20'])+1;
    		}
    		elseif($rtime>=$time21 && $rtime<$time22)
    		{
    			$brokerList[$v['realId']][$strHouseType]['t21'] = intval($brokerList[$v['realId']][$strHouseType]['t21'])+1;
    		}
    		elseif($rtime>=$time22 && $rtime<$time23)
    		{
    			$brokerList[$v['realId']][$strHouseType]['t22'] = intval($brokerList[$v['realId']][$strHouseType]['t22'])+1;
    		}
    	}
    	$arrFlushList = array();
    	foreach($brokerList as $broker_id => $arrfresh)
    	{
    		$arrfresh['sale_sum'] = intval(array_sum($arrfresh[1]));
    		$arrfresh['rent_sum'] = intval(array_sum($arrfresh[2]));
    		$arrFlushList[$broker_id] = $arrfresh;
    	}
    	return $arrFlushList;
    }
	
	/**
	 * 根据经纪人ID获取当日刷新数量
	 *
	 * @param int $intRealtorId
	 * @return int
	 */
	/*public function getFlushCountByRealtorId($intRealtorId, $type = House::TYPE_SALE)
	{
		$strHouseType = '';
		if( $type == House::TYPE_SALE )
			$strHouseType = House::TYPE_XINFANG . ',' . House::TYPE_ERSHOU;
		else
			$strHouseType = House::TYPE_ZHENGZU;
		
		
		$strCond = "realId='".$intRealtorId."'";
		$strCond .= " AND houseType IN ({$strHouseType})";
		$strCond .= " AND time>='".strtotime(date('Y-m-d'))."'";
		return self::count(array($strCond));
	}*/
	
	/**
	 * 根据经纪人ID获取当日刷新数量 (批量)
	 *
	 * @param arr $intRealtorId
	 * @return int
	 */
	public function getFlushCountByRealId($arrRealtorId)
	{
		if(empty($arrRealtorId)) return array();
		
		$arrRefreshLog = array();
		foreach($arrRealtorId as $strVal)
		{
			$strCond = "houseId = $strVal";
			$strCond .= " AND time>='".strtotime(date('Y-m-d'))."'";
			
			$arrRefreshLog[$strVal] = self::count(array($strCond));
		}
		return $arrRefreshLog;
	}
	
	/**
	 * 根据房源ID判断今日是否已刷新
	 * @param unknown $arrHouseIDs
	 * @return multitype:|multitype:number
	 */
	public function isTodayRefresh($arrHouseIDs)
	{
		$arrBackData = array();
		if(empty($arrHouseIDs)) return $arrBackData;
		 
		$arrHouse = self::getAll(" realId = {$GLOBALS['client']['realId']} and  houseId in (".implode(',', $arrHouseIDs).")");
		if ( !empty($arrHouse) )
		{
			foreach ( $arrHouse as $strVal )
			{
				if( strtotime(date('Y-m-d')) <= $strVal['time'] )
				{
					$arrBackData[$strVal['houseId']] = 1;
				}
			}
		}
		return $arrBackData;
	}

	/**
	 * 根据经纪人ID、房源类型获取今日已刷新房源ID（主要是房源列表用，因为当天发布的房源刷新时间等于发布时间，直接查ES会有问题）
	 * @param unknown $intRealID
	 * @param unknown $intHouseType
	 */
	public function getTodayRefreshByRealID($intRealID,$intHouseType = House::TYPE_SALE)
	{
		if(empty($intRealID))	return array();
		
		$strHouseType = '';
		if( $intHouseType == House::TYPE_SALE )
			$strHouseType = House::TYPE_XINFANG . ',' . House::TYPE_ERSHOU;
		else
			$strHouseType = House::TYPE_ZHENGZU;
		
		$objHouse = self::find("realId={$intRealID} and houseType in ( {$strHouseType} ) and time >='".strtotime(date('Y-m-d'))."' group by houseId");
		$arrHouse = $objHouse ? $objHouse->toArray() : array();
		if(!empty($arrHouse))
		{
			foreach($arrHouse as $strKey => $strVal)
			{
				$arrData[] = $strVal['houseId'];
			}
		}
		return $arrData;
	}
}
