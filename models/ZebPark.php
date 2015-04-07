<?php

class ZebPark extends BaseModel
{
    const isMajor = 1;
    const isNotMajor = 0;

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $parkId;

    /**
     *
     * @var integer
     */
    public $regId = 0;

    /**
     *
     * @var integer
     */
    public $distId = 0;

    /**
     *
     * @var integer
     */
    public $cityId = 0;

    /**
     *
     * @var integer
     */
    public $realId;

    /**
     *
     * @var integer
     */
    public $shopId = 0;

    /**
     *
     * @var integer
     */
    public $areaId = 0;

    /**
     *
     * @var integer
     */
    public $comId = 0;

    /**
     *
     * @var integer
     */
    public $vaId = 0;

    /**
     *
     * @var string
     */
    public $date = 0;

    /**
     *
     * @var integer
     */
    public $isMajor = 0;

    /**
     *
     * @var integer
     */
    public $saleTotal = 0;

    /**
     *
     * @var integer
     */
    public $saleValid = 0;

    /**
     *
     * @var integer
     */
    public $saleGreat = 0;

    /**
     *
     * @var integer
     */
    public $saleViolation = 0;

    /**
     *
     * @var integer
     */
    public $saleBold = 0;

    /**
     *
     * @var integer
     */
    public $saleTags = 0;

    /**
     *
     * @var integer
     */
    public $saleRelease = 0;

    /**
     *
     * @var integer
     */
    public $saleRefresh = 0;

    /**
     *
     * @var integer
     */
    public $salePrice = 0;

    /**
     *
     * @var integer
     */
    public $saleR01 = 0;

    /**
     *
     * @var integer
     */
    public $saleR02 = 0;

    /**
     *
     * @var integer
     */
    public $saleR03 = 0;

    /**
     *
     * @var integer
     */
    public $saleR04 = 0;

    /**
     *
     * @var integer
     */
    public $saleR05 = 0;
    
    /**
     *
     * @var integer
     */
    public $saleR06 = 0;

    /**
     *
     * @var integer
     */
    public $saleR07 = 0;

    /**
     *
     * @var integer
     */
    public $saleR08 = 0;

    /**
     *
     * @var integer
     */
    public $saleR09 = 0;

    /**
     *
     * @var integer
     */
    public $saleR10 = 0;

    /**
     *
     * @var integer
     */
    public $saleA01 = 0;

    /**
     *
     * @var integer
     */
    public $saleA02 = 0;

    /**
     *
     * @var integer
     */
    public $saleA03 = 0;

    /**
     *
     * @var integer
     */
    public $saleA04 = 0;

    /**
     *
     * @var integer
     */
    public $saleA05 = 0;

    /**
     *
     * @var integer
     */
    public $saleA06 = 0;

    /**
     *
     * @var integer
     */
    public $saleA07 = 0;

    /**
     *
     * @var integer
     */
    public $saleA08 = 0;

    /**
     *
     * @var integer
     */
    public $saleA09 = 0;

    /**
     *
     * @var integer
     */
    public $saleA10 = 0;

    /**
     *
     * @var integer
     */
    public $saleP01 = 0;

    /**
     *
     * @var integer
     */
    public $saleP02 = 0;

    /**
     *
     * @var integer
     */
    public $saleP03 = 0;

    /**
     *
     * @var integer
     */
    public $saleP04 = 0;

    /**
     *
     * @var integer
     */
    public $saleP05 = 0;

    /**
     *
     * @var integer
     */
    public $saleP06 = 0;

    /**
     *
     * @var integer
     */
    public $saleP07 = 0;

    /**
     *
     * @var integer
     */
    public $saleP08 = 0;

    /**
     *
     * @var integer
     */
    public $saleP09 = 0;

    /**
     *
     * @var integer
     */
    public $saleP10 = 0;

    /**
     *
     * @var integer
     */
    public $rentTotal = 0;

    /**
     *
     * @var integer
     */
    public $rentValid = 0;

    /**
     *
     * @var integer
     */
    public $rentGreat = 0;

    /**
     *
     * @var integer
     */
    public $rentViolation = 0;

    /**
     *
     * @var integer
     */
    public $rentBold = 0;

    /**
     *
     * @var integer
     */
    public $rentTags = 0;

    /**
     *
     * @var integer
     */
    public $rentRelease = 0;

    /**
     *
     * @var integer
     */
    public $rentRefresh = 0;

    /**
     *
     * @var integer
     */
    public $rentPrice = 0;

    /**
     *
     * @var integer
     */
    public $rentR01 = 0;

    /**
     *
     * @var integer
     */
    public $rentR02 = 0;

    /**
     *
     * @var integer
     */
    public $rentR03 = 0;

    /**
     *
     * @var integer
     */
    public $rentR04 = 0;

    /**
     *
     * @var integer
     */
    public $rentR05 = 0;

    /**
     *
     * @var integer
     */
    public $rentR06 = 0;

    /**
     *
     * @var integer
     */
    public $rentR07 = 0;
    
    /**
     *
     * @var integer
     */
    public $rentR08 = 0;

    /**
     *
     * @var integer
     */
    public $rentR09 = 0;

    /**
     *
     * @var integer
     */
    public $rentR10 = 0;

    /**
     *
     * @var integer
     */
    public $rentA01 = 0;

    /**
     *
     * @var integer
     */
    public $rentA02 = 0;

    /**
     *
     * @var integer
     */
    public $rentA03 = 0;

    /**
     *
     * @var integer
     */
    public $rentA04 = 0;

    /**
     *
     * @var integer
     */
    public $rentA05 = 0;

    /**
     *
     * @var integer
     */
    public $rentA06 = 0;

    /**
     *
     * @var integer
     */
    public $rentA07 = 0;

    /**
     *
     * @var integer
     */
    public $rentA08 = 0;

    /**
     *
     * @var integer
     */
    public $rentA09 = 0;

    /**
     *
     * @var integer
     */
    public $rentA10 = 0;

    /**
     *
     * @var integer
     */
    public $rentP01 = 0;

    /**
     *
     * @var integer
     */
    public $rentP02 = 0;

    /**
     *
     * @var integer
     */
    public $rentP03 = 0;

    /**
     *
     * @var integer
     */
    public $rentP04 = 0;

    /**
     *
     * @var integer
     */
    public $rentP05 = 0;

    /**
     *
     * @var integer
     */
    public $rentP06 = 0;

    /**
     *
     * @var integer
     */
    public $rentP07 = 0;

    /**
     *
     * @var integer
     */
    public $rentP08 = 0;

    /**
     *
     * @var integer
     */
    public $rentP09 = 0;

    /**
     *
     * @var integer
     */
    public $rentP10 = 0;

    /**
     *
     * @var string
     */
    public $zpUpdate;
    public $saleClick = 0;
    public $saleFineClick = 0;
    public $rentClick = 0;
    public $rentFineClick = 0;


//    public function getSource(){
//        return "zeb_park_y".date("Y");
//    }
    private $strTabName =  'zeb_park_y';
    public function getSource()
    {
        if( strlen($this->strTabName) == 10 )
            return $this->strTabName.date("Y");
        else
            return $this->strTabName;
    }
    public function setSource($strDate)
    {
        $this->strTabName = 'zeb_park_y'.$strDate;
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'zpId' => 'id',
            'parkId' => 'parkId', 
            'regId' => 'regId', 
            'distId' => 'distId', 
            'cityId' => 'cityId', 
            'realId' => 'realId', 
            'shopId' => 'shopId', 
            'areaId' => 'areaId', 
            'comId' => 'comId', 
            'vaId' => 'vaId', 
            'zpDate' => 'date',
            'zpIsMajor' => 'isMajor',
            'zpSaleTotal' => 'saleTotal',
            'zpSaleValid' => 'saleValid',
            'zpSaleGreat' => 'saleGreat',
            'zpSaleViolation' => 'saleViolation',
            'zpSaleBold' => 'saleBold',
            'zpSaleTags' => 'saleTags',
            'zpSaleFineClick'=> 'saleFineClick',
            'zpSaleClick' => 'saleClick',
            'zpSaleRelease' => 'saleRelease',
            'zpSaleRefresh' => 'saleRefresh',
            'zpSalePrice' => 'salePrice',
            'zpSaleR01' => 'saleR01',
            'zpSaleR02' => 'saleR02',
            'zpSaleR03' => 'saleR03',
            'zpSaleR04' => 'saleR04',
            'zpSaleR05' => 'saleR05',
            'zpSaleR06' => 'saleR06',
            'zpSaleR07' => 'saleR07',
            'zpSaleR08' => 'saleR08',
            'zpSaleR09' => 'saleR09',
            'zpSaleR10' => 'saleR10',
            'zpSaleA01' => 'saleA01',
            'zpSaleA02' => 'saleA02',
            'zpSaleA03' => 'saleA03',
            'zpSaleA04' => 'saleA04',
            'zpSaleA05' => 'saleA05',
            'zpSaleA06' => 'saleA06',
            'zpSaleA07' => 'saleA07',
            'zpSaleA08' => 'saleA08',
            'zpSaleA09' => 'saleA09',
            'zpSaleA10' => 'saleA10',
            'zpSaleP01' => 'saleP01',
            'zpSaleP02' => 'saleP02',
            'zpSaleP03' => 'saleP03',
            'zpSaleP04' => 'saleP04',
            'zpSaleP05' => 'saleP05',
            'zpSaleP06' => 'saleP06',
            'zpSaleP07' => 'saleP07',
            'zpSaleP08' => 'saleP08',
            'zpSaleP09' => 'saleP09',
            'zpSaleP10' => 'saleP10',
            'zpRentTotal' => 'rentTotal',
            'zpRentValid' => 'rentValid',
            'zpRentGreat' => 'rentGreat',
            'zpRentViolation' => 'rentViolation',
            'zpRentBold' => 'rentBold',
            'zpRentTags' => 'rentTags',
            'zpRentRelease' => 'rentRelease',
            'zpRentFineClick'=> 'rentFineClick',
            'zpRentClick' => 'rentClick',
            'zpRentRefresh' => 'rentRefresh',
            'zpRentPrice' => 'rentPrice',
            'zpRentR01' => 'rentR01',
            'zpRentR02' => 'rentR02',
            'zpRentR03' => 'rentR03',
            'zpRentR04' => 'rentR04',
            'zpRentR05' => 'rentR05',
            'zpRentR06' => 'rentR06',
            'zpRentR07' => 'rentR07',
            'zpRentR08' => 'rentR08',
            'zpRentR09' => 'rentR09',
            'zpRentR10' => 'rentR10',
            'zpRentA01' => 'rentA01',
            'zpRentA02' => 'rentA02',
            'zpRentA03' => 'rentA03',
            'zpRentA04' => 'rentA04',
            'zpRentA05' => 'rentA05',
            'zpRentA06' => 'rentA06',
            'zpRentA07' => 'rentA07',
            'zpRentA08' => 'rentA08',
            'zpRentA09' => 'rentA09',
            'zpRentA10' => 'rentA10',
            'zpRentP01' => 'rentP01',
            'zpRentP02' => 'rentP02',
            'zpRentP03' => 'rentP03',
            'zpRentP04' => 'rentP04',
            'zpRentP05' => 'rentP05',
            'zpRentP06' => 'rentP06',
            'zpRentP07' => 'rentP07',
            'zpRentP08' => 'rentP08',
            'zpRentP09' => 'rentP09',
            'zpRentP10' => 'rentP10',
            'zpUpdate' => 'zpUpdate'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }

	/**
	 * 获得经纪人首页 主营小区数据
	 * 缓存1天
	 *
	 * @param int $realId 经纪人id
	 * @return array
	 */
	public function getMainParkStat($realId){
		$arrMainPark = Mem::Instance()->Get(MCDefine::REALTOR_INDEX_MAIN_PARK.$realId);
		if(empty($arrMainPark))
		{
			$arrParkIds = array();
			$condition[] = 'realId='.$realId;
			//经纪人所发楼盘信息统计(昨日)
			$condition[] = "date='".date('Y-m-d', strtotime("-1 days"))."'";

			//取房源量最多的5个小区(暂时先这样，以后可能直接根据是否主营小区字段区分)
			$arrMainParkTemp  = $this->getAll($condition, 'total desc', 0, 5, 'parkId,saleValid+rentValid as total'); 

			if( !empty($arrMainParkTemp) ){
			    $arrMainPark = array();
			    foreach( $arrMainParkTemp as $info){
			        $arrMainPark[$info['parkId']] = $info;
					$arrParkIds[] = $info['parkId'];
			     }
			}

			//批量获取小区名称
			if( !empty($arrParkIds) ){
			    $arrParkData = $arrParkList = array();
			    $arrParkData = Park::Instance()->getAll("id in(".implode(',', $arrParkIds).")");
			    if( !empty($arrParkData) ) {
			        foreach ($arrParkData as $val) {
			            $arrParkList[$val['id']] = $val['name'];
			        }
			    }
			}

			if(false === $arrMainParkTemp){
			    $arrMainPark = array();
			}

			if(!empty($arrMainPark))
			{
			    $basicCon[] = "parkId in(".implode(',', $arrParkIds).")";
			    $basicCon[] = "date='".date('Y-m-d', strtotime("-1 days"))."'";

			    //小区总计

			    $objZebHouse = new ZebHouse();
			    $totalCount = $objZebHouse->getCountByIds($basicCon);
			    
			   //发布房源总数
			    $whereTotal = "parkId in(".implode(',', $arrParkIds).") and date='".date('Y-m-d', strtotime("-1 days"))."' GROUP BY parkId";
			    $arrParkTotal  = $this->getAll($whereTotal, 'total desc', 0, 5, 'parkId,sum(saleValid)+sum(rentValid) as total');
                foreach($arrParkTotal as $park)
                {
                	$total[$park['parkId']] = $park;
                }
			    
			    //经纪人发布总计
			    $basicRealtorCon = $basicCon;
			    $basicRealtorCon[] = 'realId='.$realId;
			    $totalRealtorCount =$objZebHouse->getCountByIds($basicRealtorCon);

			    //算出百分比
			    foreach($arrMainPark as $arrPark){
			        //总发布			      
		            $strUnitCount = isset($total[$arrPark['parkId']]['total'])?$total[$arrPark['parkId']]['total']:0;
			        //经纪人发布        
			        if( $strUnitCount>0 ){
			              $arrMainPark[$arrPark['parkId']]['unit_scale'] =  sprintf("%.2f",$arrPark['total']/$strUnitCount*100);
			        } 
			        else 
			        {
			              $arrMainPark[$arrPark['parkId']]['unit_scale'] = sprintf("%.2f",0.00);
			        }

			        //获得发布点击数百分比
			        $strUnitClickCount = isset($totalCount[$arrPark['parkId']]['all_click_sum'])?$totalCount[$arrPark['parkId']]['all_click_sum']:0;
			        $arrMainPark[$arrPark['parkId']]['unit_click'] = $totalRealtorCount[$arrPark['parkId']]['all_click_sum'];
			        if($strUnitClickCount>0)
			        {
			             $arrMainPark[$arrPark['parkId']]['unit_click_scale'] = sprintf("%.2f",$arrMainPark[$arrPark['parkId']]['unit_click']/$strUnitClickCount*100);
			        } 
			        else 
			        {
			             $arrMainPark[$arrPark['parkId']]['unit_click_scale'] = sprintf("%.2f",0.00);
			        }
			        //获取小区链接地址
			        $arrMainPark[$arrPark['parkId']]["url"] = "http://{$GLOBALS['client']['cityPinyinAbbr']}"._DEFAULT_DOMAIN_."/xiaoqu/{$arrPark['parkId']}/";
			        //小区名
			        $arrMainPark[$arrPark['parkId']]['parkName'] = $arrParkList[$arrPark['parkId']];
			    }
			}

			Mem::Instance()->Set(MCDefine::REALTOR_INDEX_MAIN_PARK.$realId, $arrMainPark, 86400);
		}
		return $arrMainPark;
	}

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }

    //根据条件获取小区房源统计-admin
    public function getParkStatByWhere($condition, $size=0, $offset=0, $year=0){
        if ($year==0) {
            $year = date("Y");
        }
        $limit = $size ? "limit $offset, $size":'';
        $sql = "SELECT
                SUM(b.zpSaleValid) as saleReleaseNum,SUM(b.zpRentValid) as rentReleaseNum, b.parkId, b.distId, b.regId, SUM(b.zpSaleBold) as saleBoldNum, SUM(b.zpRentBold) as rentBoldNum,
                SUM(b.zpSaleClick) as saleClickNum, SUM(b.zpSaleFineClick) as saleFineClickNum, SUM(b.zpRentClick) as rentClickNum, SUM(b.zpRentFineClick) as rentFineClickNum
                FROM  zeb_park_y".$year." b
                WHERE ".$condition." GROUP BY b.parkId $limit";
        $res = $this->fetchAll($sql);
        return $res;
    }

    public function getParkStatByWhereCount($condition, $year){
        $sql = "SELECT count(*) as num
                FROM  zeb_park_y".$year." b
                WHERE ".$condition." GROUP BY b.parkId";
        $res = $this->fetchAll($sql);
        return count($res);
    }
    
    /**
     * @abstract 获取小区的分居室均价，包含出租和出售 
     * @author Eric xuminwan@sohu-inc.com
     * @param int $parkId
     * @return array()
     * 
     */
    public function getParkHousePrice($parkId)
    {
    	if(!$parkId) return array();
    	$getTime = date('Y-m-d');
    	$arrParam['conditions'] = "parkId = ?1 and date = '{$getTime}'";
    	$arrParam['bind'] = array(1=>$parkId);
    	$arrParam['columns'] = 'saleR01,saleR02,saleR03,saleR04,saleR05,saleR06,saleR07,saleR08,saleR09,saleR10,rentR01,rentR02,rentR03,rentR04,rentR05,rentR06,rentR07,rentR08,rentR09,rentR10';
    	return self::findFirst($arrParam,0)->toArray();
    }
	
	/**
	 * 写入统计数据
	 *
	 * @param int $intParkId
	 * @param int $intRealId
	 * @param array $arrData
	 * @param str $strDate
	 * @return int|bool
	 */
    public function addZebPark($intParkId, $intRealId, $arrData, $strDate = ''){
		$strDate = empty($strDate) ? date('Y-m-d') : $strDate;
		$arrPark = Park::Instance()->getOne('id='.$intParkId);
		if (empty($arrPark)) {
			echo '小区不存在'.$intParkId."\n";
			return false;
		}
		$arrRealtor = Realtor::Instance()->getOne('id='.$intRealId);
		if (empty($arrRealtor)) {
			echo '经纪人不存在'.$intRealId."\n";
			return false;
		}

		//统计房源信息
		$arrZp = array();
		$strDay = date('d', strtotime($strDate));
		$intMonth = intval(date('m', strtotime($strDate)));
		$clsZebHouse = new ZebHouse();
		$arrZebHouse = $clsZebHouse->getSelectData("ZebHouse", "sum(1) as saleTotal,sum(d{$strDay}Release) as saleValid,sum(if(houseCreate>'".date('Y-m-d 00:00:00')."',d{$strDay}Release,0)) as saleRelease,sum(d{$strDay}Refresh) as saleRefresh,sum(d{$strDay}Click) as saleClick,sum(d{$strDay}Bold) as saleBold,sum(d{$strDay}Tags) as saleTags", "houseType in(".House::TYPE_XINFANG.",".House::TYPE_CIXIN.",".House::TYPE_ERSHOU.") and parkId=".$intParkId." and realId=".$intRealId." and month=".$intMonth, array());
		$arrZp['saleTotal'] = intval($arrZebHouse[0]['saleTotal']);
		$arrZp['saleValid'] = intval($arrZebHouse[0]['saleValid']);
		$arrZp['saleRelease'] = intval($arrZebHouse[0]['saleRelease']);
		$arrZp['saleRefresh'] = intval($arrZebHouse[0]['saleRefresh']);
		$arrZp['saleClick'] = intval($arrZebHouse[0]['saleClick']);
		$arrZp['saleBold'] = intval($arrZebHouse[0]['saleBold']);
		$arrZp['saleTags'] = intval($arrZebHouse[0]['saleTags']);
		$arrZebHouse = $clsZebHouse->getSelectData("ZebHouse", "sum(1) as rentTotal,sum(d{$strDay}Release) as rentValid,sum(if(houseCreate>'".date('Y-m-d 00:00:00')."',d{$strDay}Release,0)) as rentRelease,sum(d{$strDay}Refresh) as rentRefresh,sum(d{$strDay}Click) as rentClick,sum(d{$strDay}Bold) as rentBold,sum(d{$strDay}Tags) as rentTags", "houseType in(".House::TYPE_ZHENGZU.",".House::TYPE_HEZU.") and parkId=".$intParkId." and realId=".$intRealId." and month=".$intMonth, array());
		$arrZp['rentTotal'] = intval($arrZebHouse[0]['rentTotal']);
		$arrZp['rentValid'] = intval($arrZebHouse[0]['rentValid']);
		$arrZp['rentRelease'] = intval($arrZebHouse[0]['rentRelease']);
		$arrZp['rentRefresh'] = intval($arrZebHouse[0]['rentRefresh']);
		$arrZp['rentClick'] = intval($arrZebHouse[0]['rentClick']);
		$arrZp['rentBold'] = intval($arrZebHouse[0]['rentBold']);
		$arrZp['rentTags'] = intval($arrZebHouse[0]['rentTags']);
		unset($arrZebHouse, $clsZebHouse);

		$arrZp['parkId'] = $intParkId;
		$arrZp['regId'] = intval($arrPark['regId']);
		$arrZp['distId'] = intval($arrPark['distId']);
		$arrZp['cityId'] = intval($arrPark['cityId']);
		$arrZp['realId'] = intval($arrRealtor['id']);
		$arrZp['shopId'] = intval($arrRealtor['shopId']);
		$arrZp['areaId'] = intval($arrRealtor['areaId']);
		$arrZp['comId'] = intval($arrRealtor['comId']);
		$arrZp['date'] = empty($strDate) ? date('Y-m-d') : $strDate;
		$arrZp['zpUpdate'] = date('Y-m-d H:i:s', time());
		$res = self::create($arrZp);
		unset($arrZp, $arrPark, $arrRealtor, $arrData);
		return empty($res) ? false : $res;
    }
	
	/**
	 * 更新统计数据
	 *
	 * @param int $intParkId
	 * @param int $intRealId
	 * @param array $arrData
	 * @param str $strDate
	 * @return int|bool
	 */
    public function modZebPark($intParkId, $intRealId, $arrData, $strDate = ''){
		$strDate = empty($strDate) ? date('Y-m-d') : $strDate;
		$objZeb = self::findfirst("parkId=".$intParkId." and realId=".$intRealId." and date='".$strDate."'");
		if (empty($objZeb)) return $this->addZebPark($intParkId, $intRealId, $arrData, $strDate);

		//统计房源信息
		$arrZp = array();
		$strDay = date('d', strtotime($strDate));
		$intMonth = intval(date('m', strtotime($strDate)));
		$clsZebHouse = new ZebHouse();
		$arrZebHouse = $clsZebHouse->getSelectData("ZebHouse", "sum(1) as saleTotal,sum(d{$strDay}Release) as saleValid,sum(if(houseCreate>'".date('Y-m-d 00:00:00')."',d{$strDay}Release,0)) as saleRelease,sum(d{$strDay}Refresh) as saleRefresh,sum(d{$strDay}Click) as saleClick,sum(d{$strDay}Bold) as saleBold,sum(d{$strDay}Tags) as saleTags", "houseType in(".House::TYPE_XINFANG.",".House::TYPE_CIXIN.",".House::TYPE_ERSHOU.") and parkId=".$intParkId." and realId=".$intRealId." and month=".$intMonth, array());
		$arrZp['saleTotal'] = intval($arrZebHouse[0]['saleTotal']);
		$arrZp['saleValid'] = intval($arrZebHouse[0]['saleValid']);
		$arrZp['saleRelease'] = intval($arrZebHouse[0]['saleRelease']);
		$arrZp['saleRefresh'] = intval($arrZebHouse[0]['saleRefresh']);
		$arrZp['saleClick'] = intval($arrZebHouse[0]['saleClick']);
		$arrZp['saleBold'] = intval($arrZebHouse[0]['saleBold']);
		$arrZp['saleTags'] = intval($arrZebHouse[0]['saleTags']);
		$arrZebHouse = $clsZebHouse->getSelectData("ZebHouse", "sum(1) as rentTotal,sum(d{$strDay}Release) as rentValid,sum(if(houseCreate>'".date('Y-m-d 00:00:00')."',d{$strDay}Release,0)) as rentRelease,sum(d{$strDay}Refresh) as rentRefresh,sum(d{$strDay}Click) as rentClick,sum(d{$strDay}Bold) as rentBold,sum(d{$strDay}Tags) as rentTags", "houseType in(".House::TYPE_ZHENGZU.",".House::TYPE_HEZU.") and parkId=".$intParkId." and realId=".$intRealId." and month=".$intMonth, array());
		$arrZp['rentTotal'] = intval($arrZebHouse[0]['rentTotal']);
		$arrZp['rentValid'] = intval($arrZebHouse[0]['rentValid']);
		$arrZp['rentRelease'] = intval($arrZebHouse[0]['rentRelease']);
		$arrZp['rentRefresh'] = intval($arrZebHouse[0]['rentRefresh']);
		$arrZp['rentClick'] = intval($arrZebHouse[0]['rentClick']);
		$arrZp['rentBold'] = intval($arrZebHouse[0]['rentBold']);
		$arrZp['rentTags'] = intval($arrZebHouse[0]['rentTags']);
		unset($arrZebHouse,$clsZebHouse);

		$arrZp['zpUpdate'] = date('Y-m-d H:i:s', time());
		$res = $objZeb->update($arrZp);
		unset($objZeb, $arrData, $arrZp);
		return empty($res) ? false : $res;
    }

    public function getMainPark($arrCondition){
        $condition = $this->getConditionByParam($arrCondition);
        $condition['order'] = "saleRefresh desc";
        $condition['columns'] = "distinct parkId";
        $condition['limit'] = isset($arrCondition['limit']) ? $arrCondition['limit'] :  5;
        $info = self::find($condition)->toArray();
        if (!$info) return array();
        $arParkId = array();
        foreach ($info as $value){
            $arParkId[] = $value['parkId'];
        }

        $parkInfo = CPark::getParkByIds($arParkId);
        foreach ($info as &$value){
            $value['parkName'] = isset($parkInfo[$value['parkId']]) ? $parkInfo[$value['parkId']]['name'] : '';
            $value['salePrice'] = isset($parkInfo[$value['parkId']]) ? $parkInfo[$value['parkId']]['salePrice'] : 0;
            $value['cover'] = ImageUtility::getImgUrl('esf',$parkInfo[$value['parkId']]['picId'],
                $parkInfo[$value['parkId']]['picExt'],180,120);
        }
        unset($value);
        return $info;
    }


    //经纪人小区信息统计
    public function getReatorData($param, $year){
        $this->setSource($year);
        if($param["comId"] == 0) return false;
        if(!$param['searchTime']) return false;
        $company = Company::findfirst(" id=".$param["comId"], 0)->toArray();
        $result['comName'] = $company['abbr'];

        $rs = $this->find([
            "conditions" => "comId=".$param["comId"]." AND date='".$param['searchTime']."' AND realId>0",
            "columns"=>"realId  ,comId, parkId, distId, regId, saleTotal, saleRelease, saleRefresh, rentTotal, rentRelease, rentRefresh"
        ])->toArray();
        if(empty($rs)) return false;
        $realIds = array();
        foreach($rs as $k => $v ){
            $result["data"][$v['realId']][$v['parkId']] = $v;
            $realIds[$v['realId']] = $v['realId'];
            $parkIds[$v['parkId']] = $v['parkId'];
        }
        $parkInfo    = Park::instance()->adminGetParkByIds($parkIds);
        $realtorInfo = Realtor::instance()->getRealBaseByIds($realIds);

        foreach($result["data"] as $k=>$realtor){
            $result["data"][$k]["name"] = $realtorInfo[$k]['name'];
            $result["data"][$k]["mobile"] = $realtorInfo[$k]['mobile'];
            $result["data"][$k]["accountName"] = $realtorInfo[$k]['accountName'];
            foreach($realtor as $parkId=>$park){
                $result["data"][$k][$parkId]['name'] = $parkInfo[$parkId]['name'];
            }
        }
        return $result;

    }

}
