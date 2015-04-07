<?php
use Elasticsearch\Endpoints\Indices\Refresh;
/**
 * @abstract 焦点通－刷新
 * @author Raul
 * @since  date 2014/10/10
 */
class VipRefreshQueue extends BaseModel
{
    public $id;
    public $housetype;
    public $houseId;
    public $realId;
    public $shopId;
    public $comId;
    public $cityId;
    public $refreshDate;
    public $refreshTime;
    public $refreshCount;
    public $refreshTimeScheme;
    public $refreshCountScheme;
    public $refreshDays;
    
    const UNIT_TYPE_SALE = 2;		//出售
    const UNIT_TYPE_RENT = 1;		//出租
    
    const OP_PARK = 1;      //专营小区房源定时刷新
    const OP_HOUSE = 0;     //普通端口房源定时刷新
    
    public static function instance ($cache = true)
    {
    	return parent::_instance(__CLASS__, $cache);
    	return new self();
    }
    
    public function getSource()
    {
        return 'vip_refresh_queue';
    }

    public function columnMap()
    {
        return array(
            'rqId' 					=> 'id',
            'housetype' 			=> 'housetype',
            'houseId' 				=> 'houseId',
            'realId' 				=> 'realId',
            'shopId' 				=> 'shopId',
            'comId' 				=> 'comId',
            'cityId' 				=> 'cityId',
        	'rqRefreshDate' 		=> 'refreshDate',
        	'rqRefreshTime'			=> 'refreshTime',
        	'rqRefreshCount'		=> 'refreshCount',
        	'rqRefreshTimeScheme'	=> 'refreshTimeScheme',
        	'rqRefreshCountScheme'	=> 'refreshCountScheme',
        	'rqRefreshDays'			=> 'refreshDays',
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    
    /**
     * 检测定时刷新房源合法性
     * @param unknown $intHouseType 房源类型（出租|出售）
     * @param unknown $arrHouseIDs	房源id数组
     */
    public function checkHouse($intHouseType, $strHouseIDs)
    {
    	global $sysES;
    	$params = $sysES['default'];
    	$params['index'] = 'esf';
    	$params['type'] = 'house';
    	$client = new Es($params);
    	
    	$arrHouseIDs = explode(',', trim($strHouseIDs,','));
    	if(!is_array($arrHouseIDs))
    	{
    		$arrHouseIDs = array($strHouseIDs);
    	}
    	
    	$conditions = array(
    		'realId' => $GLOBALS['client']['realId'],
    		'houseId'=> array('in' => $arrHouseIDs)
    	);
    	
    	$strLocation = '';
    	if($intHouseType == House::TYPE_SALE)
    		$strLocation = '/sale/list/';
    	else
    		$strLocation = '/rent/list/';
    		
    	//检测房源是否是经纪人本人的房源 并且是发布
    	$searchParam['where'] = $conditions;
    	$arrHouse = $client->search($searchParam);
    	if(!empty($arrHouse))
    	{
	    	foreach ($arrHouse['data'] as $arrData)
	    	{
	    		if($arrData['realId'] != $GLOBALS['client']['realId'] || $arrData['status'] != House::STATUS_ONLINE)
	    		{
	    			Utility::MsgBox("操作有误，ID为:{$arrData['houseId']} 的房源可能已下架！",$strLocation);exit;
	    			exit;
	    		}
	    	}
    	}
    	else
    	{
    		Utility::MsgBox("操作有误，房源不存在！",$strLocation);exit;
    		exit;
    	}	
    }
    
    /**
     * 获取指定经纪人刷新队列中的所有的房源Id
     *
     * @param int $broker_id
     * @param int $unit_type
     * @return array
     */
    public function getRefreshHouseList($intRealID, $intHouseType = House::TYPE_SALE)
    {
    	$arrBackData = array();
    	if ( empty($intRealID) ) {
    		return $arrBackData;
    	}
    	
    	$arrVipRefreshQueueList = self::query()
    	->where("realId = $intRealID and housetype = $intHouseType ")
    	->execute()
    	->toArray();
    	
    	if ( !empty($arrVipRefreshQueueList) )
    	{
    	    $strTime = time();
    		foreach ( $arrVipRefreshQueueList as $k => $strVal )
    		{
    		    //这里减去一天是因为保存的是日期，如果减去2天则会把当天的刷新过滤掉，例：2014-12-15 定时2天，如果减去2天则15号那天会被过滤掉
    		    $intDay = (($strVal['refreshDays'] - 1) * 86400) + (strtotime($strVal['refreshDate']));
    		    if( $strTime <= $intDay )
    		    {
    		        if( $strTime < strtotime($strVal['refreshDate']))
    		        {
    		            if( $strVal['refreshDays'] == 1  )
    		            {
    		                $arrTimes = explode(',', $strVal['refreshTime']);
    		                foreach($arrTimes as $val)
    		                {
    		                    if( $strTime <= strtotime(date('Y-m-d').' '.$val))
    		                    {
    		                        $arrBackData[] = $strVal['houseId'];
    		                    }
    		                }
    		            }
    		            else
    		            {
    		                if( strtotime(date('Y-m-d',$strTime)) == $intDay )
    		                {//如果是定时刷新有效期的最后一天，则对每个时间点进行判断
    		                    $arrTimes = explode(',', $strVal['refreshTimeScheme']);
    		                    foreach($arrTimes as $val)
    		                    {
    		                        if( $strTime <= strtotime(date('Y-m-d').' '.$val))
    		                        {
    		                            $arrBackData[] = $strVal['houseId'];
    		                        }
    		                    }
    		                }
    		                else
    		                {
    		                    $arrBackData[] = $strVal['houseId'];
    		                }
    		            }
    		        }
    		        elseif( $strTime >= strtotime($strVal['refreshDate'])  )
    		        {
    		            if( strtotime(date('Y-m-d',$strTime)) == $intDay )
    		            {
    		                $arrTimes = explode(',', $strVal['refreshTimeScheme']);
    		                foreach($arrTimes as $val)
    		                {
    		                    if( $strTime <= strtotime(date('Y-m-d').' '.$val))
    		                    {
    		                        $arrBackData[] = $strVal['houseId'];
    		                    }
    		                }
    		            }
    		            else
    		            {
    		                $arrBackData[] = $strVal['houseId'];
    		            }
    		        }
    		    }
    		}
    	}
    	return $arrBackData;
    }
    
    /**
     * 根据经纪人获取可用出售房源的刷新次数
     * 根据经纪人获取当日开始以后7天的  正在定时数量 剩余的刷新数量
     * @param int $broker_id  经纪人id
     * @param bool $queque    是否刷新标识
     * @param boole  $master false默认读取从库，true 读取主库
     * @return array array(
     *                      '2012-08-01'=>array('used_times'=>xxx, 'surplus_times'=>xxx),//日期=>array('used_times'=>正在定时数量值, 'surplus_times'=>剩余刷新数量值)
     *                      '2012-08-02'=>array('used_times'=>xxx, 'surplus_times'=>xxx),
     *                      ...
     *                    )
     */
    public function getRefreshTimesValueByRealId($intRealID,$intHouseType)
    {
    	$objRealtorPort = RealtorPort::findFirst("realId = $intRealID and status =".RealtorPort::STATUS_ENABLED);
    	
    	$intMaxRefresh = 0;
    	$strHouseType = '';
    	if( $intHouseType == House::TYPE_SALE)
    	{
    		$intMaxRefresh = $objRealtorPort ? $objRealtorPort->saleRefresh : 0;
    		$strHouseType = House::TYPE_SALE;
    	}
    	else 
    	{
    		$intMaxRefresh = $objRealtorPort ? $objRealtorPort->rentRefresh : 0;
    		$strHouseType = House::TYPE_RENT;
    	}
    	
    	//获取今日已刷日志
    	$intUsedFlush = RefreshLog::instance()->getUsedFlush($intRealID,$strHouseType, date('Y-m-d'),false);
    	
    	//需要去掉当日定时的数量
    	$arrRefreshQueeNum = $this->getRealtorRefreshQueueNum($intRealID,$intHouseType);
    	
    	$arrSurplusFlush = array();
    	$intCount = 1; 	//该参数用于“查看定时情况”列表样式的显示，无其它作用
    	//剩余的刷新数量
    	foreach ($arrRefreshQueeNum as $strDate => $num)
    	{
    		if( date('Y-m-d') == $strDate)
    		{
    			$arrSurplusFlush[$strDate]['used_times'] = $num;
    			$arrSurplusFlush[$strDate]['surplus_times'] = ($intMaxRefresh > 0) ? ($intMaxRefresh - $intUsedFlush - $num) : 0;
    			$arrSurplusFlush[$strDate]['count'] = $intCount++;
    		}
    		else
    		{
    			$arrSurplusFlush[$strDate]['used_times'] = $num;
    			$arrSurplusFlush[$strDate]['surplus_times'] = ($intMaxRefresh > 0) ? ($intMaxRefresh - $num) : 0;
    			$arrSurplusFlush[$strDate]['count'] = $intCount++;
    		}
    		$arrSurplusFlush[$strDate]['surplus_times'] = ($arrSurplusFlush[$strDate]['surplus_times'] >= 0) ? $arrSurplusFlush[$strDate]['surplus_times'] : 0;
    	}
    	unset($intCount);
    	return $arrSurplusFlush;
    }
    
    /**
     * 获取经纪人每日刷新队列数据总量
     *
     * @param int $intRealID 经纪人Id
     * @param string  经纪人对应的城市拼音
     * @param int unit_type 房源类型
     * @param int day_num 初始化多少天内的时间
     * @param bool  $master 是否读取主库，true 读取主库，默认为从库
     * @return int
     */
    public function getRealtorRefreshQueueNum($intRealID, $intHouseType = House::TYPE_SALE)
    {
    	$arrNum = array();
    	$day_num = 7;
    	for( $i = 0; $i < $day_num; $i++ )
    	{
    		$arrNum[date("Y-m-d", time()+86400*$i)] = 0;
    	}
    
    	//将刷新队列中的数据压入$day_num天队列数量
    	$strWhere = "realId = $intRealID and housetype = $intHouseType";
    	if ( !empty($arrNum) )
    	{
    		foreach ( $arrNum as $d => $n )
    		{
    			$arrNum[$d] = $this->getRefreshCount($strWhere,$d);
    		}
    	}
    	return $arrNum;
    }
    
    /**
     * 获取刷新的房源列表
     *
     * @return array $arrUnit
     */
    public function getHouseForRefresh($intRealID,$intHouseType, $order = array(),$strHouseIDs = '' )
    {
    	if(empty($intRealID))	return array();
    	
    	$arrUnit = array();
    	$arrCondition = array(
			'realId' => $GLOBALS['client']['realId'],
    		'houseVerification' => array("not in" => array(House::HOUSE_VERNO)),
		);
    	
    	if( $intHouseType == House::TYPE_SALE )
    	{
    		$clsHouse = new SaleLib();
    		$strDomain = _DEFAULT_DOMAIN_;
    	}
    	else
    	{
    		$clsHouse = new RentLib();
    		$strDomain = _ZU_DOMAIN_;
    	}
    	
    	$arrHouseIDs = explode(',', $strHouseIDs);
    	$arrUnitTmp = $clsHouse->getVIPUnitList($arrCondition,0,1000,$order,true);
    	
    	//根据城市获取不同的标签，用于判断是否有手动标签
    	if( $intHouseType == House::TYPE_SALE )
    		$strHouseType = 'Sale';
    	else 
    		$strHouseType = 'Rent';
    	$objSign = HouseSign::instance()->getUnitTag($GLOBALS['client']['cityId'] ,$strHouseType);
    	$arrSignTmp = $objSign ? $objSign->toArray() : array();
    	$arrSign = array();
    	if(!empty($arrSignTmp))
    	{
	    	foreach($arrSignTmp as $strVal)
	    	{
	    		$arrSign[] = $strVal['name'];
	    	}
    	}
    	
    	if(!empty($arrUnitTmp))
    	{
    		include_once dirname(__FILE__).'/../config/'.$GLOBALS['client']['cityPinyinAbbr'].'.config.inc.php';
    		unset($arrUnitTmp['unit_total']);
    		foreach ($arrUnitTmp as $key => $data)
    		{
    			$arrTags = array();
    			if( $intHouseType == House::TYPE_SALE )
    			{
	    			$arrFreature = array_diff(explode(',', $data['features']), $GLOBALS['SALE_AUTO_TAG']);//去除自动标签
	    			$arrTags = array_intersect($arrSign,$arrFreature);//和各城市的房源标签是否有交集
    			}
    			elseif( $intHouseType == House::TYPE_RENT )
    			{
    				//出售的标签在houseRent里
    				$objRent = Rent::instance()->findFirst("houseId={$data['id']}");
    				$arrRent = $objRent ? $objRent->toArray() : array();
    				if(!empty($arrRent))
    				{
    					if(!empty($arrRent['features']))
    					{
    						$arrTags = explode(',' ,$arrRent['features']);
    					}
    				}
    			}
    			
    			//根据不同的住宅类型进行显示
    			$strFloor = '';
    			if( $data['propertyType'] == 1 || $data['propertyType'] == 3 || $data['propertyType'] == 5 || $data['propertyType'] == 6 )
    			{
    				$strFloor = $data['floor'].'/'.$data['floorMax'].'层';
    			}
    			else
    			{
    				$strFloor = $GLOBALS['LIVE_TYPE'][$data['propertyType']];
    			}
    			if(empty($strFloor))
    			{
    				$strFloor = '-';
    			}
    			
    			//ES中保存的刷新时间为发布前5天，这里需要与房源列表保持一致
    			$strRefreshTime = '';
    			if( empty($data['house_refreshTime'] ))
    			{
    				$strRefreshTime = '尚未刷新';
    			}
    			elseif( strtotime($data['house_refreshTime']) == (strtotime($data['house_create']) - 86400*5) )
    			{
    				$strRefreshTime = '尚未刷新';
    			}
    			elseif( strtotime($data['house_refreshTime']) == strtotime($data['house_create']) )
    			{
    			    $strRefreshTime = '尚未刷新';
    			}
    			else
    			{
    				$strRefreshTime = $data['house_refreshTime'];
    			}
    			
    			$arrUnit[$key]['parkName'] = $data['parkName'];
    			$arrUnit[$key]['id'] = $data['id'];
    			$arrUnit[$key]['bA'] = $data['bA'];
    			$arrUnit[$key]['price'] = $data['price'];
    			$arrUnit[$key]['floor'] = $strFloor;
    			$arrUnit[$key]['bedRoom'] = (isset($GLOBALS['UNIT_BEDROOM'][$data['bedRoom']]) ? $GLOBALS['UNIT_BEDROOM'][$data['bedRoom']] : '').(isset($GLOBALS['UNIT_LIVING_ROOM'][$data['livingRoom']]) ? $GLOBALS['UNIT_LIVING_ROOM'][$data['livingRoom']] : '').(isset($GLOBALS['UNIT_BATHROOM'][$data['bathRoom']]) ? $GLOBALS['UNIT_BATHROOM'][$data['bathRoom']] : '');
    			$arrUnit[$key]['decoration'] = isset($GLOBALS['UNIT_FITMENT'][$data['decoration']]) ? $GLOBALS['UNIT_FITMENT'][$data['decoration']] : '';
    			$arrUnit[$key]['url'] = 'http://'.$GLOBALS['client']['cityPinyinAbbr'].$strDomain.'/view/'.$data['id'].'.html';
    			$arrUnit[$key]['sign'] = !empty($data['features']) ? count($arrTags) : 0 ;	//是否存在手动标签
    			$arrUnit[$key]['quality'] = isset($data['quality']) ? $data['quality'] : 1;	//高清标签
    			$arrUnit[$key]['house_create'] = $data['house_create'];
//     			$arrUnit[$key]['house_refreshTime'] = !empty($data['house_refreshTime']) ? $data['house_refreshTime'] : '尚未刷新';
    			$arrUnit[$key]['house_refreshTime'] = $strRefreshTime;
    			$arrUnit[$key]['is_checked'] = in_array($data['id'], $arrHouseIDs) ? 'checked' : '';
    			$arrUnit[$key]['currency'] = (isset($data['currency']) && $data['currency'] == 1) ? '元/月' : '元/㎡/天';
    		}
    	}
    	return $arrUnit;
    }
    
    /**
     * Add By Raul
     * 
     * 创建单条刷新队列
     * 数据字典：
     * rqRefreshDate 		刷新时间，保存当前时间后一天时间，如当前时间 2014-10-16 保存数据为 2014-10-17 主要用于取队列脚本执行时的判断
     * rqRefreshTime		今日刷新时间点
     * rqRefreshCount		今日刷新时间点次数，用于计算可用刷新数 （可用刷新数 ＝ 刷新总数－刷新日志表中手动刷新 － rqRefreshCount）
     * rqRefreshTimeScheme  定时刷新方案时间点，根据rqRefreshDays（有效期天数） + rqRefreshDate（刷新时间）判断是否执行
     * rqRefreshCountScheme 定时刷新方案时间点次数
     * rqRefreshDays		定时刷新方案有效期
     * 
     * @param unknown $arrData
     * @param unknown $strMsg
     * @return boolean
     */
    public function addToRefreshList($arrData,&$strMsg)
    {
    	$strNowDate = date('Y-m-d');
    	$intNowHour = intval(date('H'));
    	$intNowMinute = intval(date('i'));
    
    	if ( empty($arrData['housetype']) || empty($arrData['houseId']) )
    	{
    		$strMsg = '参数有误';
    		return false;
    	}
    	
    	if ( !is_array($arrData['houseId']) )
    	{
    		$arrData['houseId'] = array($arrData['houseId']);
    	}
    
    	$intTimeOutNum 		= 0;//超时的时间点数量
    	$intRepeatNum 		= 0;//重复的时间点数量
    	$intExcessNumToday	= 0;//超限的时间点数量(今日)
    	$intExcessNumScheme = 0;//超限的时间点数量(方案)
    	$strDate 			= date('Y-m-d',time() + 86400);
    	$arrQueue			= array();//将今日定时写入队列，次日及往后的数据在执行脚本中写入
    	
    	//获取今日已手动刷新数量
    	$maxRefresh = $intUseFlush = 0;
    	
    	if ( $arrData['housetype'] == House::TYPE_SALE )
    	{
    		$intUseFlush = RefreshLog::instance()->getUsedFlush($GLOBALS['client']['realId'], House::TYPE_SALE, date('Y-m-d'),false);
    		$objRealtorPort = RealtorPort::instance()->getAccountByRealId($GLOBALS['client']['realId']);
    		$maxRefresh = $objRealtorPort ? $objRealtorPort->saleRefresh : 0;
    		//获取今日定时刷新次数(已刷掉的会自动扣除）
    		$intTimimgRefreshCount = self::getTodayTimingRefreshCount($GLOBALS['client']['realId'],House::TYPE_SALE);
    	}
    	else
    	{
    		$intUseFlush = RefreshLog::instance()->getUsedFlush($GLOBALS['client']['realId'],House::TYPE_RENT, date('Y-m-d'),false);
    		$objRealtorPort = RealtorPort::instance()->getAccountByRealId($GLOBALS['client']['realId']);
    		$maxRefresh = $objRealtorPort ? $objRealtorPort->rentRefresh : 0;
    		//获取今日定时刷新次数(已刷掉的会自动扣除）
    		$intTimimgRefreshCount = self::getTodayTimingRefreshCount($GLOBALS['client']['realId'],House::TYPE_RENT);
    	}
    	
    	//对端口为0或者可刷新数为0的用户进行校验
    	if( $maxRefresh == 0 || $intUseFlush + $intTimimgRefreshCount >= $maxRefresh )
    	{
    		$strMsg = '没有足够的刷新数';
    		return false;
    	}
    	
    	$insertSql = "INSERT into vip_refresh_queue(`housetype`,`houseId`,`realId`,`shopId`,`comId`,`cityId`,`rqRefreshDate`,`rqRefreshTime`,`rqRefreshCount`,`rqRefreshTimeScheme`,`rqRefreshCountScheme`,`rqRefreshDays`) VALUES";
    	$strSQL = $strDelHouseID = '';
    	$isReturn = true;
    	if(!empty($arrData['refreshTime']))
    	{
    		$arrTimes = explode(',', $arrData['refreshTime'][$strDate]['times']);
    		
    		//去掉重复时间点
    		$intRepeatPre = count($arrTimes);
    		$arrTimes = array_unique($arrTimes);
    		$intRepeatFont = count($arrTimes);
    		if($intRepeatPre > $intRepeatFont)
    		{
    			$intRepeatNum += $intRepeatPre - $intRepeatFont;
    		}
    		//去除重复后的定时刷新方案
    		$strRefreshScheme = implode(',', $arrTimes);
    		 
    		$intTodayTotalCount 	= 1; //今日定时方案总数
    		$intTomorrowTotalCount 	= 1; //次日定时方案总数
    		
    		foreach ( $arrData['houseId'] as $strHouseID ) 
    		{
    			$intCount = $intTomorrowCount = 0;
    			$strTimes = $strTomorrowTimes = '';
    			
    			//今日方案
    			foreach($arrTimes as $strVal)
    			{
    				$intHour = intval(date('H', strtotime($strVal)));
    				$intMinute = intval(date('i', strtotime($strVal)));
    				if($intNowHour > $intHour || ($intNowHour == $intHour && $intNowMinute > $intMinute))
    				{//过滤今日过期时间点
    					$intTimeOutNum++;
    				}
    				else
    				{//今日是否超限［总数－已刷新数-时间点总数］
    					$intTodayNum = ($maxRefresh - $intUseFlush - $intTimimgRefreshCount) - $intTodayTotalCount;				
    					if( $intTodayNum < 0)
    					{
    						$intExcessNumToday++;
    					}
    					else
    					{
    						$strTimes .= empty($strTimes) ? $strVal : ',' .$strVal;
    						$intCount++;
    						$intTodayTotalCount++;
    					}
    				}
    			}
    			
    			//明日方案
    			foreach($arrTimes as $strVal)
    			{//次日是否超限[总数－时间点总数]
    				$intSchemeNum = $maxRefresh - $intTomorrowTotalCount;				
    				if( $intSchemeNum < 0)
    				{
    					$intExcessNumScheme++;
    				}
    				else 
    				{
    					$strTomorrowTimes .= empty($strTomorrowTimes) ? $strVal : ',' .$strVal;
    					$intTomorrowCount++;
    					$intTomorrowTotalCount++;
    				}
    			}
    			
    			//1.只将今日定时时间点写入队列，次日及往后的数据在每日零晨定时脚本中写入
    			$objVipRefreshQueue = $this->findFirst("houseId={$strHouseID}");
    			$arrVipRefreshQueue = $objVipRefreshQueue ? $objVipRefreshQueue->toArray() : array();
    			if(!empty($arrVipRefreshQueue))
    			{
    				//今日已设置过定时刷新，再次写入队列时需去除上回设置队列时写入的时间点
    				$arrRefreshTimes = explode(',', $arrVipRefreshQueue['refreshTime']);
    				$arrTodayRefreshTimes = explode(',', $strTimes);
    				$arrQueueTimes = array_diff($arrTodayRefreshTimes,$arrRefreshTimes);
    				
    				//今日已设置过定时刷新
    				$arrQueue[] = array(
    						'houseId'				=> $strHouseID,
    						'toDayRefreshTime'		=> implode(',', $arrQueueTimes),
    						'toDayRefreshTimeCount'	=> count($arrQueueTimes),
    				);
    			}
    			else 
    			{
    				//今日未设置过定时刷新
	    			$arrQueue[] = array(
	    				'houseId'				=> $strHouseID,
	    				'toDayRefreshTime'		=> $strTimes,
	    				'toDayRefreshTimeCount'	=> $intCount,
	    			);
    			}
    			
    			//添加新方案时需要删除的房源
    			$strDelHouseID .= empty($strDelHouseID) ? $strHouseID : ',' . $strHouseID;
    			
    			if( $arrData['days'] == 0 )
    			{
    				if($intExcessNumToday > 0)	continue;
    				$strSQL .= " ({$arrData['housetype']}, {$strHouseID}, {$arrData['realId']}, {$arrData['shopId']}, {$arrData['comId']}, {$arrData['cityId']},'{$strDate}','{$strTimes}',{$intCount},'',0,{$arrData['days']}),";
    			}
    			else 
    			{
    				if($intExcessNumScheme > 0 && $intExcessNumToday > 0)	continue;
    				if(empty($strTomorrowTimes) && empty($intTomorrowCount))//如果明日刷新方案为空，则将方案有效期改为生成方案当日
    				{
    					$strSQL .= " ({$arrData['housetype']}, {$strHouseID}, {$arrData['realId']}, {$arrData['shopId']}, {$arrData['comId']}, {$arrData['cityId']},'{$strDate}','{$strTimes}',{$intCount},'{$strTomorrowTimes}',{$intTomorrowCount},0),";
    				}
    				else
    				{
    					$strSQL .= " ({$arrData['housetype']}, {$strHouseID}, {$arrData['realId']}, {$arrData['shopId']}, {$arrData['comId']}, {$arrData['cityId']},'{$strDate}','{$strTimes}',{$intCount},'{$strTomorrowTimes}',{$intTomorrowCount},{$arrData['days']}),";
    				}
    			}
    			$isReturn = false;
    		}
    	}
    	
    	if ( $isReturn )
    	{
    		$strMsg = "未提交有效的定时数据";
    		return false;
    	}
    	
		//通过权限验证后，删除当前的队列 调整为 先清除现有队列数据
		$this->begin();
		$strWhere = "housetype={$arrData['housetype']} and realId={$GLOBALS['client']['realId']} and houseId in ({$strDelHouseID})";
		$boolFlag = $this->deleteAll($strWhere);
		if ( $boolFlag === false )
		{
			$this->rollback();
			$strMsg = "清除队列失败";
			return false;
		}
		unset($boolFlag);

    	if(!empty($strSQL))
    	{
    		$boolFlag = $this->execute($insertSql.trim($strSQL,','));
    		if ( $boolFlag === false )
    		{
    			$this->rollback();
    			$strMsg = "未设置定时队列";
    			return false;
    		}
    	}
    	$this->commit();
    	
    	//写入队列（将写入队列移出事务，否则可能会出现事务还未提交，但是已写进队列并在脚本中执行查询，导致数据不一致）
    	$arrCurlData = array();
    	foreach ( $arrQueue as $arrQueueVal )
    	{
    		//用于写入日志表记录
    		$objHouse = House::findFirst("id={$arrQueueVal['houseId']}");
    		$intParkId = $objHouse ? $objHouse->parkId : 0;
    		$intQuality = $objHouse ? $objHouse->quality : 0;
    		$arrTimes = explode(',', $arrQueueVal['toDayRefreshTime']);
    		foreach($arrTimes as $strVal )
    		{
    			$intDelayRefreshTime = strtotime(date('Y-m-d').' '.$strVal)-time();
    			if ($intDelayRefreshTime < 0 )	$intDelayRefreshTime = 0;
// 			    $intFlag = Quene::Instance()->Put('refresh', array('action' => 'refresh', 'houseId' => $arrQueueVal['houseId'],'realId' => $GLOBALS['client']['realId'], 'refreshDate' => date('Y-m-d'), 'refreshTime' => strtotime(date('Y-m-d').' '.$strVal),'houseType' => $arrData['housetype'],'parkId' => $intParkId,'quality' => $intQuality,'shopId' => $GLOBALS['client']['shopId'],'areaId' => $GLOBALS['client']['areaId'],'comId' => $GLOBALS['client']['comId']),array('delay' => $intDelayRefreshTime));
// 			    if ( $intFlag == false )
// 			    {
// 			    	$this->rollback();
// 			    	$strMsg = '更新队列失败.';
// 			    	return false;
//			    }
    			$arrCurlData[] = array(
    				'houseId'		=> $arrQueueVal['houseId'],
    				'realId'		=> $GLOBALS['client']['realId'],
    				'refreshDate'	=> date('Y-m-d'),
    				'refreshTime'	=> strtotime(date('Y-m-d').' '.$strVal),
    				'houseType'		=> $arrData['housetype'],
    				'parkId'		=> !empty($intParkId)  ? $intParkId  : 0,
    				'houseQuality'	=> !empty($intQuality) ? $intQuality : 1,
    				'shopId'		=> isset($GLOBALS['client']['shopId']) ? $GLOBALS['client']['shopId'] : 0,
    				'areaId'		=> isset($GLOBALS['client']['areaId']) ? $GLOBALS['client']['areaId'] : 0,
    				'comId'			=> isset($GLOBALS['client']['comId'])  ? $GLOBALS['client']['comId']  : 0,
    				'delayTime'		=> $intDelayRefreshTime
    			);
    		}
    	}
    	$strCurlDate['queue'] = base64_encode(json_encode($arrCurlData));
    	
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, 'http://vip.esf.focus.cn/refreshCurl.php');
    	curl_setopt($ch, CURLOPT_POST, true);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, 'queue='.$strCurlDate['queue']);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 1);
    	curl_exec($ch);
    	curl_close($ch);
    	unset($arrQueue,$arrData,$strSQL,$arrCurlData);
    	
    	$strAlert = "";
    	if($intRepeatNum > 0 || $intTimeOutNum > 0 || $intExcessNumToday > 0 || $intExcessNumScheme > 0)
    	{
    		$strAlert .= '系统已自动过滤掉了';
    		if( $intExcessNumToday > 0 )
    		{
    			$strAlert .= '今日超限时间点'.$intExcessNumToday.'次；';
    		}
    		if( $intTimeOutNum > 0 )
    		{
    			$strAlert .= '今日过期时间点'.$intTimeOutNum.'次；';
    		}
    		if( $intExcessNumScheme > 0 )
    		{
    			$strAlert .= '明日超限时间点'.$intExcessNumScheme.'次；';
    		}
    		$strAlert .= '';
    		if( $intRepeatNum > 0 )
    		{
    			$strAlert .= '重复时间点'.$intRepeatNum.'次；';
    		}
    	}
    	$strMsg = "【定时成功】{$strAlert}";
    	return true;
    }
    
    /**
     * 获取今日/明日刷新队列中已预约的刷新数
     * $strDate 默认为今日刷新队列数
     * 			$strDate不为空则指定天数(例：2014-10-10）
     * @param unknown $strDate		
     * @param unknown $strWhere
     * @return number
     */
    public function getRefreshCount($strWhere,$strDate = '')
    {
    	if(empty($strDate))	
    		$intTime = strtotime(date('Y-m-d'));
    	else 
    		$intTime = strtotime($strDate);
    	
    	$db = $this->getDi()->getShared('esfMaster');
    	$arr = $db->fetchAll("SELECT rqRefreshDate,rqRefreshDays,rqRefreshTime,rqRefreshTimeScheme FROM vip_refresh_queue where ".$strWhere);
    	
    	$strTime = time();
    	$intRefreshQueueCount = 0;
    	if(!empty($arr))
    	{
    		$arrTimes = array();
    		foreach ($arr as $strVal)
    		{
    			$intDay = (($strVal['rqRefreshDays'] - 1) * 86400) + (strtotime($strVal['rqRefreshDate']));
    			if( $intTime < strtotime($strVal['rqRefreshDate']) )
    			{
    				$arrTimes = explode(',', $strVal['rqRefreshTime']);
    				foreach($arrTimes as $val)
    				{
    					if( $strTime <= strtotime(date('Y-m-d').' '.$val))
    					{
    						$intRefreshQueueCount += 1;
    					}
    				}
    			}
    			elseif( $intTime >= strtotime($strVal['rqRefreshDate']) && $intTime < $intDay )
    			{
    				$arrTimes = explode(',', $strVal['rqRefreshTimeScheme']);
    				foreach($arrTimes as $val)
    				{
    					if( $strTime <= strtotime(date('Y-m-d').' '.$val))
    					{
    						$intRefreshQueueCount += 1;
    					}
    				}
    			}
    		}
    	}
    	return $intRefreshQueueCount;
    }
    
    /**
     * 根据房源ID获取是否正在定时
     * @param unknown $arrHouseID
     * @return multitype:
     */
    public function isTimingRefresh($arrHouseIDs,$strRealId = '')
    {
        $intRealId = empty($strRealId) ? $GLOBALS['client']['realId'] : $strRealId;
        
    	$arrBackData = array();
    	if(empty($arrHouseIDs)) return $arrBackData;
    	
    	$arrHouse = self::getAll(" realId = {$intRealId} and  houseId in (".implode(',', $arrHouseIDs).")");
    	if ( !empty($arrHouse) )
    	{
    		$strTime = time();
    		foreach ( $arrHouse as $strVal )
    		{
    			//这里减去一天是因为保存的是日期，如果减去2天则会把当天的刷新过滤掉，例：2014-12-15 定时2天，如果减去2天则15号那天会被过滤掉
				$intDay = (($strVal['refreshDays'] - 1) * 86400) + (strtotime($strVal['refreshDate']));
				if( $strTime <= $intDay )
				{
					if( $strTime < strtotime($strVal['refreshDate']))
					{
						if( $strVal['refreshDays'] == 1  )
						{
							$arrTimes = explode(',', $strVal['refreshTime']);
							foreach($arrTimes as $val)
							{
								if( $strTime <= strtotime(date('Y-m-d').' '.$val))
								{
									$arrBackData[$strVal['houseId']] = 1;
								}
							}
						}
						else 
						{
							if( strtotime(date('Y-m-d',$strTime)) == $intDay )
							{//如果是定时刷新有效期的最后一天，则对每个时间点进行判断
								$arrTimes = explode(',', $strVal['refreshTimeScheme']);
								foreach($arrTimes as $val)
								{
									if( $strTime <= strtotime(date('Y-m-d').' '.$val))
									{
										$arrBackData[$strVal['houseId']] = 1;
									}
								}
							}
							else
							{
								$arrBackData[$strVal['houseId']] = 1;
							}
						}
					}
					elseif( $strTime >= strtotime($strVal['refreshDate'])  )
					{
						if( strtotime(date('Y-m-d',$strTime)) == $intDay )
						{
							$arrTimes = explode(',', $strVal['refreshTimeScheme']);
							foreach($arrTimes as $val)
							{
								if( $strTime <= strtotime(date('Y-m-d').' '.$val))
								{
									$arrBackData[$strVal['houseId']] = 1;
								}
							}
						}
						else
						{
							$arrBackData[$strVal['houseId']] = 1;
						}
					}
				}
    		}
    	}
    	return $arrBackData;
    }

    /**
     * 根据房源ID和经纪人ID获取是否正在定时
     * @param unknown $arrHouseID,$realId
     * @return multitype:
     */
    public function isTimingRefreshByRealId($arrHouseIDs, $realId)
    {
    	$arrBackData = array();
    	if(empty($arrHouseIDs)) return $arrBackData;
    	 
    	$arrHouse = self::getAll(" realId = {$realId} and  houseId in (".implode(',', $arrHouseIDs).")");
    	if ( !empty($arrHouse) )
    	{
    		foreach ( $arrHouse as $strVal )
    		{
    			$intDay = (($strVal['refreshDays'] - 2) * 86400) + (strtotime($strVal['refreshDate']));
    			if( strtotime(date('Y-m-d')) <= $intDay )
    			{
    				$arrBackData[$strVal['houseId']] = 1;
    			}
    		}
    	}
    	return $arrBackData;
    }


    /**
     * 用于房源列表“今日定时”数量统计，“今日定时”每刷新掉一个之后数量需要递减
     * 用当前时间去匹配vip_refresh_queue中指定经纪人下房源的定时记录
     * 小于当前时间的不统计（认为定时已刷新）
     * 大于当前时间的统计（认为定时未刷新）
     */
    public function getTodayTimingRefreshCount($intRealId,$intHouseType = House::TYPE_SALE)
    {
    	$objVipRefreshQueue = self::find([
    			"conditions"=> "realId={$intRealId} and housetype = {$intHouseType}",
    			"columns"	=> "refreshDate,refreshTime,refreshTimeScheme,refreshDays"
        ]);
    	$arrVipRefreshQueue = $objVipRefreshQueue ? $objVipRefreshQueue->toArray() : array();
    	$intTimingRefreshCount = 0;
    	if(!empty($arrVipRefreshQueue))
    	{
    		$strTime = time();
    		foreach($arrVipRefreshQueue as $arrVal)
    		{ 
    			$intDay = (($arrVal['refreshDays'] - 1) * 86400) + (strtotime($arrVal['refreshDate']));
    			if( $strTime < strtotime($arrVal['refreshDate']) )
    			{
    				//取产生队列当天的刷新时间点进行统计
    				$arrRefreshTimes = explode(',', $arrVal['refreshTime']);
    				if(!empty($arrRefreshTimes))
    				{
    					foreach($arrRefreshTimes as $strVal)
    					{
    						if( $strTime <= strtotime(date('Y-m-d').' '.$strVal))
    						{
    							$intTimingRefreshCount++;
    						}
    					}
    				}
    			}
    			if( $strTime >= strtotime($arrVal['refreshDate']) && $strTime < $intDay )
    			{
    				//取队列方案的刷新时间点进行统计
    				$arrRefreshTimes = explode(',', $arrVal['refreshTimeScheme']);
    				if(!empty($arrRefreshTimes))
    				{
    					foreach($arrRefreshTimes as $strVal)
    					{
    						if( $strTime <= strtotime(date('Y-m-d').' '.$strVal))
    						{
    							$intTimingRefreshCount++;
    						}
    					}
    				}
    			}
    		}	
    	}
    	return $intTimingRefreshCount;
    }
}
