<?php
class ZebRealtor extends BaseModel
{
	public $id;
	public $realId;
	public $shopId = 0;
	public $areaId = 0;
	public $comId = 0;
	public $date;
	public $rpId = 0;
    public $isGood = 0;
	public $portEquivalent = 0;
	public $portSaleRelease = 0;
	public $portSaleRefresh = 0;
	public $portSaleBold = 0;
	public $portSaleTags = 0;
	public $portRentRelease = 0;
	public $portRentRefresh = 0;
	public $portRentBold = 0;
	public $portRentTags = 0;
	public $saleTotal = 0;
	public $saleValid = 0;
	public $saleGreat = 0;
	public $saleViolation = 0;
	public $saleBold = 0;
	public $saleTags = 0;
	public $saleRelease = 0;
	public $saleRefresh = 0;
	public $saleR00 = 0;
	public $saleR01 = 0;
	public $saleR02 = 0;
	public $saleR03 = 0;
	public $saleR04 = 0;
	public $saleR05 = 0;
	public $saleR06 = 0;
	public $saleR07 = 0;
	public $saleR08 = 0;
	public $saleR09 = 0;
	public $saleR10 = 0;
	public $saleR11 = 0;
	public $saleR12 = 0;
	public $saleR13 = 0;
	public $saleR14 = 0;
	public $saleR15 = 0;
	public $saleR16 = 0;
	public $saleR17 = 0;
	public $saleR18 = 0;
	public $saleR19 = 0;
	public $saleR20 = 0;
	public $saleR21 = 0;
	public $saleR22 = 0;
	public $saleR23 = 0;
	public $saleClick = 0;
	public $rentTotal = 0;
	public $rentValid = 0;
	public $rentGreat = 0;
	public $rentViolation = 0;
	public $rentBold = 0;
	public $rentTags = 0;
	public $rentRelease = 0;
	public $rentRefresh = 0;
	public $rentR00 = 0;
	public $rentR01 = 0;
	public $rentR02 = 0;
	public $rentR03 = 0;
	public $rentR04 = 0;
	public $rentR05 = 0;
	public $rentR06 = 0;
	public $rentR07 = 0;
	public $rentR08 = 0;
	public $rentR09 = 0;
	public $rentR10 = 0;
	public $rentR11 = 0;
	public $rentR12 = 0;
	public $rentR13 = 0;
	public $rentR14 = 0;
	public $rentR15 = 0;
	public $rentR16 = 0;
	public $rentR17 = 0;
	public $rentR18 = 0;
	public $rentR19 = 0;
	public $rentR20 = 0;
	public $rentR21 = 0;
	public $rentR22 = 0;
	public $rentR23 = 0;
	public $rentClick = 0;
	public $loginCount = 0;
	public $scoreIn = 0;
	public $scoreOut = 0;
	public $zrUpdate;
    public $cityId = 0;
    public $distId = 0;
    public $regId = 0;
    public $saleBoldTotal = 0;
    public $saleTagsTotal = 0;
    public $saleRefreshTotal = 0;
    public $rentBoldTotal = 0;
    public $rentTagsTotal = 0;
    public $rentRefreshTotal = 0;
    
    private $strTabName =  'zeb_realtor_m';
    
    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'zrId' 				=> 'id',
            'realId' 			=> 'realId',
            'shopId' 			=> 'shopId',
            'cityId'            => 'cityId',
            'distId'            => 'distId',
            'regId'             => 'regId',
            'areaId' 			=> 'areaId',
            'comId' 			=> 'comId',
            'zrDate' 			=> 'date',
            'rpId'				=> 'rpId',
            'zrPortEquivalent'	=> 'portEquivalent',
            'zrPortSaleRelease' => 'portSaleRelease',
            'zrPortSaleRefresh' => 'portSaleRefresh',
            'zrPortSaleBold' 	=> 'portSaleBold',
            'zrPortSaleTags' 	=> 'portSaleTags',
            'zrPortRentRelease' => 'portRentRelease',
        	'zrPortRentRefresh' => 'portRentRefresh',
        	'zrPortRentBold' 	=> 'portRentBold',
        	'zrPortRentTags' 	=> 'portRentTags',
        	'zrSaleTotal' 		=> 'saleTotal',
        	'zrSaleValid' 		=> 'saleValid',
        	'zrSaleGreat' 		=> 'saleGreat',
        	'zrSaleViolation' 	=> 'saleViolation',
        	'zrSaleBold' 		=> 'saleBold',
        	'zrSaleTags' 		=> 'saleTags',
        	'zrSaleRelease' 	=> 'saleRelease',
        	'zrSaleRefresh' 	=> 'saleRefresh',
        	'zrSaleR00' 		=> 'saleR00',
        	'zrSaleR01' 		=> 'saleR01',
        	'zrSaleR02' 		=> 'saleR02',
        	'zrSaleR03' 		=> 'saleR03',
        	'zrSaleR04' 		=> 'saleR04',
        	'zrSaleR05' 		=> 'saleR05',
        	'zrSaleR06' 		=> 'saleR06',
        	'zrSaleR07' 		=> 'saleR07',
        	'zrSaleR08' 		=> 'saleR08',
        	'zrSaleR09' 		=> 'saleR09',
        	'zrSaleR10' 		=> 'saleR10',
        	'zrSaleR11' 		=> 'saleR11',
        	'zrSaleR12' 		=> 'saleR12',
        	'zrSaleR13' 		=> 'saleR13',
        	'zrSaleR14' 		=> 'saleR14',
        	'zrSaleR15' 		=> 'saleR15',
        	'zrSaleR16' 		=> 'saleR16',
        	'zrSaleR17' 		=> 'saleR17',
        	'zrSaleR18' 		=> 'saleR18',
        	'zrSaleR19' 		=> 'saleR19',
        	'zrSaleR20' 		=> 'saleR20',
        	'zrSaleR21' 		=> 'saleR21',
        	'zrSaleR22' 		=> 'saleR22',
        	'zrSaleR23' 		=> 'saleR23',
        	'zrSaleClick' 		=> 'saleClick',
        	'zrRentTotal' 		=> 'rentTotal',
        	'zrRentValid' 		=> 'rentValid',
        	'zrRentGreat' 		=> 'rentGreat',
        	'zrRentViolation' 	=> 'rentViolation',
        	'zrRentBold' 		=> 'rentBold',
        	'zrRentTags' 		=> 'rentTags',
        	'zrRentRelease' 	=> 'rentRelease',
        	'zrRentRefresh' 	=> 'rentRefresh',
        	'zrRentR00' 		=> 'rentR00',
        	'zrRentR01' 		=> 'rentR01',
        	'zrRentR02' 		=> 'rentR02',
        	'zrRentR03' 		=> 'rentR03',
        	'zrRentR04' 		=> 'rentR04',
        	'zrRentR05' 		=> 'rentR05',
        	'zrRentR06' 		=> 'rentR06',
        	'zrRentR07'			=> 'rentR07',
        	'zrRentR08' 		=> 'rentR08',
        	'zrRentR09' 		=> 'rentR09',
        	'zrRentR10' 		=> 'rentR10',
        	'zrRentR11' 		=> 'rentR11',
        	'zrRentR12' 		=> 'rentR12',
        	'zrRentR13' 		=> 'rentR13',
        	'zrRentR14' 		=> 'rentR14',
        	'zrRentR15' 		=> 'rentR15',
        	'zrRentR16' 		=> 'rentR16',
        	'zrRentR17' 		=> 'rentR17',
        	'zrRentR18' 		=> 'rentR18',
        	'zrRentR19' 		=> 'rentR19',
        	'zrRentR20' 		=> 'rentR20',
        	'zrRentR21' 		=> 'rentR21',
        	'zrRentR22' 		=> 'rentR22',
        	'zrRentR23' 		=> 'rentR23',
        	'zrRentClick' 		=> 'rentClick',
        	'zrLoginCount' 		=> 'loginCount',
        	'zrScoreIn' 		=> 'scoreIn',
        	'zrScoreOut' 		=> 'scoreOut',
        	'zrUpdate'			=> 'zrUpdate',//请不要改动，以免sql解析出错
            'zrIsGood'          => 'isGood',
            'zrSaleBoldTotal'   => 'saleBoldTotal',
            'zrSaleTagsTotal'   => 'saleTagsTotal',
            'zrSaleRefreshTotal'=> 'saleRefreshTotal',
            'zrRentBoldTotal'   => 'rentBoldTotal',
            'zrRentTagsTotal'   => 'rentTagsTotal',
            'zrRentRefreshTotal'=> 'rentRefreshTotal'
        );
    }

	public function initialize()
	{
		$this->setConn("esf");
	}

    public function getSource()
    {
    	if( strlen($this->strTabName) == 13 )
    		return $this->strTabName.date('Ym');
    	else
    		return $this->strTabName;
    }
    
    public function setSource($strDate)
    {
        $this->strTabName = 'zeb_realtor_m'.$strDate;
    }

	/**
	 * 实例化
	 * @param type $cache
	 * @return CmsArticleLabel_Model
	 */

	public static function instance($cache = true)
	{
		return parent::_instance(__CLASS__, $cache);
		return new self;
	}

	/**
	 * 获得关联后的数据 关联门店名称门店帐号
	 * @param array $condition 搜索条件
	 * @param str $order 排序
	 * @param int $offset 起始位置
	 * @param int $size 返回大小
	 * @param str $select 返回的字段
	 */
	public function getAllSearch($intType, $intPage, $intMaxPerPage,$intMonth)
	{
		$arrZebRealtor = parent::getAll("realId={$GLOBALS['client']['realId']}","date desc",$intPage,$intMaxPerPage,
        'date,portEquivalent,saleRelease,portSaleRelease,portSaleBold,portSaleTags,loginCount,rentRelease,portRentRelease,portRentBold,portRentTags,portSaleRefresh,portRentRefresh,saleRefresh,rentRefresh');
		
		include_once dirname(__FILE__).'/../config/'.$GLOBALS['client']['cityPinyinAbbr'].'.config.inc.php';
		
		$arrRealtor = RealtorPort::instance()->getAccountByRealId($GLOBALS['client']['realId']);
		
		if(!empty($arrZebRealtor))
		{
			foreach($arrZebRealtor as $strKey => $arrVal)
			{
				$intDay = date('d',strtotime($arrVal['date']));
				$arrZebHouse = ZebHouse::instance()->getBedRoomInfoByRealID($intDay,$intMonth,$intType);
				if(!empty($arrZebHouse))
				{
					foreach($arrZebHouse as $strK => $strVal)
					{
						if( strstr($strK,'release') )
						{
							$arrZebRealtor[$strKey]['bedroom']['release'][$strK] = $strVal;
						}
						elseif( strstr($strK,'refresh') )
						{
							$arrZebRealtor[$strKey]['bedroom']['refresh'][$strK] = $strVal;
						}
						elseif( strstr($strK,'click') )
						{
							$arrZebRealtor[$strKey]['bedroom']['click'][$strK] = $strVal;
						}
						elseif( $strK == 'portSaleTags' && $intType == House::TYPE_SALE )
						{
						    $arrVal['portSaleTags'] += (int)$arrRealtor->saleTagsExtra;
						}
						elseif( $strK == 'portRentTags' && $intType == House::TYPE_RENT )
						{
						    $arrVal['portSaleTags'] += (int)$arrRealtor->rentTags;
						}
						else 
						{
							$arrZebRealtor[$strKey][$strK] = $strVal;
						}
					}
					
				}
			}
		}
		return $arrZebRealtor;
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
	
	/**
	 * 
	 * @param unknown $intID	公司、区域、门店、经纪人ID
	 * @param unknown $intType	账号类型
	 * @param unknown $strData	刷新时间，默认今天
	 */
	public function getRealtorRefreshCountByDate($intID,$strCondition,$intHouseType = House::TYPE_SALE,$intOffset=0,$intLimit=0,$selectDate = '')
	{
		if(empty($intID))	return array();
		
		$strColumn = '';
		if( $intHouseType == House::TYPE_SALE )
		{
			$strColumn = 'r.name, r.mobile,ZebRealtor.date,ZebRealtor.saleR00,ZebRealtor.saleR01,ZebRealtor.saleR02,ZebRealtor.saleR03,ZebRealtor.saleR04,ZebRealtor.saleR05';
			$strColumn.= ',ZebRealtor.saleR06,ZebRealtor.saleR07,ZebRealtor.saleR08,ZebRealtor.saleR09,ZebRealtor.saleR10,ZebRealtor.saleR11,ZebRealtor.saleR12,ZebRealtor.saleR13';
			$strColumn.= ',ZebRealtor.saleR14,ZebRealtor.saleR15,ZebRealtor.saleR16,ZebRealtor.saleR17,ZebRealtor.saleR18,ZebRealtor.saleR19,ZebRealtor.saleR20,ZebRealtor.saleR21';
			$strColumn.= ',ZebRealtor.saleR22,ZebRealtor.saleR23,(ZebRealtor.saleR00+ZebRealtor.saleR01+ZebRealtor.saleR02+ZebRealtor.saleR03+ZebRealtor.saleR04+ZebRealtor.saleR05+ZebRealtor.saleR06+ZebRealtor.saleR07+ZebRealtor.saleR08) as before09';
			$strColumn.= ',ZebRealtor.portSaleRefresh as portRefresh,ZebRealtor.saleRefresh as Refresh';
		}
		else 
		{
			$strColumn = 'r.name, r.mobile,ZebRealtor.date,ZebRealtor.rentR00,ZebRealtor.rentR01,ZebRealtor.rentR02,ZebRealtor.rentR03,ZebRealtor.rentR04,ZebRealtor.rentR05';
			$strColumn.= ',ZebRealtor.rentR06,ZebRealtor.rentR07,ZebRealtor.rentR08,ZebRealtor.rentR09,ZebRealtor.rentR10,ZebRealtor.rentR11,ZebRealtor.rentR12,ZebRealtor.rentR13';
			$strColumn.= ',ZebRealtor.rentR14,ZebRealtor.rentR15,ZebRealtor.rentR16,ZebRealtor.rentR17,ZebRealtor.rentR18,ZebRealtor.rentR19,ZebRealtor.rentR20,ZebRealtor.rentR21';
			$strColumn.= ',ZebRealtor.rentR22,ZebRealtor.rentR23,(ZebRealtor.rentR00+ZebRealtor.rentR01+ZebRealtor.rentR02+ZebRealtor.rentR03+ZebRealtor.rentR04+ZebRealtor.rentR05+ZebRealtor.rentR06+ZebRealtor.rentR07+ZebRealtor.rentR08) as before09';
			$strColumn.= ',ZebRealtor.portRentRefresh as portRefresh,ZebRealtor.rentRefresh as Refresh';
		}
		
		$arrZebRealtor = self::query();
		$arrZebRealtor->columns($strColumn);
		$arrZebRealtor->leftJoin('Realtor', 'r.id = ZebRealtor.realId', 'r');
		$arrZebRealtor->where($strCondition);
	 	if($intLimit > 0)
	 	{
            if($intOffset > 0)
            {
                $arrZebRealtor->limit($intOffset,$intLimit);
            }
            else
            {
                $arrZebRealtor->limit($intLimit);
            }
        }
		return $arrZebRealtor->execute()->toArray();
	}
    
    /**
     * 根据经纪人id、日期获取所需统计信息
     * @param int|array $realIds
     * @param string    $fromDate
     * @param string    $toDate
     * @param string    $columns
     * @return array
     */
    public function getDataByRealId($realIds, $fromDate = '', $toDate = '', $columns = '')
    {
        if(empty($realIds) || (!$fromDate && !$toDate))
        {
            return array();
        }
        if($fromDate && $toDate)
        {
            if($fromDate > $toDate)
            {
                return array();
            }
            $where = "date>='{$fromDate}' and date<='{$toDate}'";
        }
        else
        {
            $where = $fromDate ? "date='{$fromDate}'" : "date='{$toDate}'"; 
        }
        if(is_array($realIds))
        {
            $arrBind = $this->bindManyParams($realIds);
            $arrCond = $where  . " and realId in({$arrBind['cond']})";
            $arrParam = $arrBind['param'];
            $condition = array(
                $arrCond,
                "bind" => $arrParam,
            );
        }
        else
        {
            $condition = array('conditions'=>$where." and realId={$realIds}");
        }
        $columns && $condition['columns'] = $columns;
        $arrData  = self::find($condition,0)->toArray();
        $arrRdata=array();
        foreach($arrData as $value)
        {
        	$arrRdata[$value['realId']][$value['date']] = $value;
        }
        return $arrRdata;
    }
    
    /**
     *
     * @param unknown $intID	公司、区域、门店、经纪人ID
     * @param unknown $intType	账号类型
     * @param unknown $strData	刷新时间，默认今天
     */
    public function getRealtorByCondition($strCondition,$intHouseType = House::TYPE_SALE,$intOffset=0,$intLimit=0,$strColumn='')
    {
    	if( empty($strColumn) )
    	{
	    	if( $intHouseType == House::TYPE_SALE )
	    	{
	    		$strColumn.= 'r.id,r.name, va.name as accname,shop.name as shop_name,shop.accname as shop_accname,ZebRealtor.portEquivalent,ZebRealtor.portSaleRelease as portRelease,ZebRealtor.portSaleRefresh as portRefresh';
	    		$strColumn.= ',ZebRealtor.portSaleBold as portBold,ZebRealtor.portSaleTags as portTags,ZebRealtor.saleValid as valid';
	    		$strColumn.= ',ZebRealtor.saleRelease as release,ZebRealtor.saleTotal as total,ZebRealtor.areaId,ZebRealtor.comId,ZebRealtor.date';
	    		$strColumn.= ',ZebRealtor.saleBold as bold,ZebRealtor.saleTags as tags,ZebRealtor.saleRefresh as refresh,ZebRealtor.saleClick as click,ZebRealtor.loginCount';
	    	}
	    	else
	    	{
	    		$strColumn.= 'r.id,r.name, va.name as accname,shop.name as shop_name,shop.accname as shop_accname,ZebRealtor.portEquivalent,ZebRealtor.portRentRelease as portRelease,ZebRealtor.portRentRefresh as portRefresh';
	    		$strColumn.= ',ZebRealtor.portRentBold as portBold,ZebRealtor.portRentTags as portTags,ZebRealtor.rentValid as valid';
	    		$strColumn.= ',ZebRealtor.rentRelease as release,ZebRealtor.rentTotal as total,ZebRealtor.areaId,ZebRealtor.comId,ZebRealtor.date';
	    		$strColumn.= ',ZebRealtor.rentBold as bold,ZebRealtor.rentTags as tags,ZebRealtor.rentRefresh as refresh,ZebRealtor.rentClick as click,ZebRealtor.loginCount';
	    	}
    	}
    	$arrZebRealtor = self::query();
    	$arrZebRealtor->columns($strColumn);
    	$arrZebRealtor->leftJoin('Realtor', 'r.id = ZebRealtor.realId', 'r');
    	$arrZebRealtor->leftJoin('VipAccount', 'va.toId = ZebRealtor.realId and va.to='.VipAccount::ROLE_REALTOR, 'va');
    	$arrZebRealtor->leftJoin('Shop', 'shop.id = ZebRealtor.shopId', 'shop');
    	$arrZebRealtor->where($strCondition);
    	
    	if($intLimit > 0)
    	{
    		if($intOffset > 0)
    		{
    			$arrZebRealtor->limit($intOffset,$intLimit);
    		}
    		else
    		{
    			$arrZebRealtor->limit($intLimit);
    		}
    	}
    	return $arrZebRealtor->execute()->toArray();
    }
	
	/**
	 * 写入统计数据
	 *
	 * @param int $intRealtorId
	 * @param array $arrData
	 * @param str $strDate
	 * @return int|bool
	 */
    public function addZebRealtor($intRealtorId, $arrData, $strDate = ''){
		$strDate = empty($strDate) ? date('Y-m-d') : $strDate;
		$arrRealtor = Realtor::Instance()->getOne('id='.$intRealtorId);
		if (empty($arrRealtor)) {
			return false;
		}

		//统计房源信息
		$arrZr = array();
		$strDay = date('d', strtotime($strDate));
		$intMonth = intval(date('m', strtotime($strDate)));
		$clsZebHouse = new ZebHouse();
		$arrZebHouse = $clsZebHouse->getSelectData("ZebHouse", "sum(1) as saleTotal,sum(d{$strDay}Release) as saleValid,sum(if(houseCreate>'".date('Y-m-d 00:00:00')."',d{$strDay}Release,0)) as saleRelease,sum(d{$strDay}Refresh) as saleRefresh,sum(d{$strDay}Click) as saleClick,sum(d{$strDay}Bold) as saleBold,sum(d{$strDay}Tags) as saleTags", "houseType in(".House::TYPE_XINFANG.",".House::TYPE_CIXIN.",".House::TYPE_ERSHOU.") and realId=".$intRealtorId." and month=".$intMonth, array());
		$arrZr['saleTotal'] = intval($arrZebHouse[0]['saleTotal']);
		$arrZr['saleValid'] = intval($arrZebHouse[0]['saleValid']);
		$arrZr['saleRelease'] = intval($arrZebHouse[0]['saleRelease']);
		$arrZr['saleRefresh'] = intval($arrZebHouse[0]['saleRefresh']);
		$arrZr['saleClick'] = intval($arrZebHouse[0]['saleClick']);
		$arrZr['saleBold'] = intval($arrZebHouse[0]['saleBold']);
		$arrZr['saleTags'] = intval($arrZebHouse[0]['saleTags']);
		$arrZebHouse = $clsZebHouse->getSelectData("ZebHouse", "sum(1) as rentTotal,sum(d{$strDay}Release) as rentValid,sum(if(houseCreate>'".date('Y-m-d 00:00:00')."',d{$strDay}Release,0)) as rentRelease,sum(d{$strDay}Refresh) as rentRefresh,sum(d{$strDay}Click) as rentClick,sum(d{$strDay}Bold) as rentBold,sum(d{$strDay}Tags) as rentTags", "houseType in(".House::TYPE_ZHENGZU.",".House::TYPE_HEZU.") and realId=".$intRealtorId." and month=".$intMonth, array());
		$arrZr['rentTotal'] = intval($arrZebHouse[0]['rentTotal']);
		$arrZr['rentValid'] = intval($arrZebHouse[0]['rentValid']);
		$arrZr['rentRelease'] = intval($arrZebHouse[0]['rentRelease']);
		$arrZr['rentRefresh'] = intval($arrZebHouse[0]['rentRefresh']);
		$arrZr['rentClick'] = intval($arrZebHouse[0]['rentClick']);
		$arrZr['rentBold'] = intval($arrZebHouse[0]['rentBold']);
		$arrZr['rentTags'] = intval($arrZebHouse[0]['rentTags']);
		unset($arrZebHouse, $clsZebHouse);

		//获取经纪人端口数量
		$objRealtorPort = new RealtorPort();
		$arrRes = $objRealtorPort->getAccountByRealId($intRealtorId);
		$arrRes = !empty($arrRes) ? $arrRes->toArray() : array();
		$arrZr['rpId'] = !empty($arrRes['id']) ? intval($arrRes['id']) : 0;
		$arrZr['portSaleRelease'] = !empty($arrRes['saleRelease']) ? intval($arrRes['saleRelease']) : 0;
		$arrZr['portSaleRefresh'] = !empty($arrRes['saleRefresh']) ? intval($arrRes['saleRefresh']) : 0;
		$arrZr['portSaleBold'] = !empty($arrRes['saleBold']) ? intval($arrRes['saleBold']) : 0;
		$arrZr['portSaleTags'] = !empty($arrRes['saleTags']) || !empty($arrRes['saleTagsExtra']) ? intval($arrRes['saleTags'])+intval($arrRes['saleTagsExtra']) : 0;
		$arrZr['portRentRelease'] = !empty($arrRes['rentRelease']) ? intval($arrRes['rentRelease']) : 0;
		$arrZr['portRentRefresh'] = !empty($arrRes['rentRefresh']) ? intval($arrRes['rentRefresh']) : 0;
		$arrZr['portRentBold'] = !empty($arrRes['rentBold']) ? intval($arrRes['rentBold']) : 0;
		$arrZr['portRentTags'] = !empty($arrRes['rentTags']) ? intval($arrRes['rentTags']) : 0;
		$objPortCity = new PortCity();
		$arrPort = !empty($arrRes['portId']) ? $objPortCity->getOne("id = ".$arrRes['portId']) : array();
		$arrZr['portEquivalent'] = !empty($arrPort['equivalent']) ? intval($arrRes['num']*$arrPort['equivalent']) : 0;
		unset($arrAccount, $objRealtorPort, $arrRes, $objPortCity, $arrPort);

		$arrZr['realId'] = $intRealtorId;
		$arrZr['shopId'] = intval($arrRealtor['shopId']);
		$arrZr['regId'] = intval($arrRealtor['regId']);
		$arrZr['distId'] = intval($arrRealtor['distId']);
		$arrZr['cityId'] = intval($arrRealtor['cityId']);
		$arrZr['areaId'] = intval($arrRealtor['areaId']);
		$arrZr['comId'] = intval($arrRealtor['comId']);
		$arrZr['date'] = empty($strDate) ? date('Y-m-d') : $strDate;
		$arrZr['zrUpdate'] = date('Y-m-d H:i:s', time());
		isset($arrData['loginCount']) && $arrZr['loginCount'] = $arrData['loginCount'];
		
		//刷新时间段统计
		if( !empty($arrData) )
		{
			foreach( $arrData as $strKey => $strVal)
			{
				$arrZr[$strKey] = (int)$strVal;
			}
		}
		
		$res = self::create($arrZr);
		unset($arrZr, $arrRealtor, $arrData);
		return empty($res) ? false : $res;
    }
	
	/**
	 * 更新统计数据
	 *
	 * @param int $intRealtorId
	 * @param array $arrData
	 * @param str $strDate
	 * @return int|bool
	 */
    public function modZebRealtor($intRealtorId, $arrData, $strDate = ''){
		$strDate = empty($strDate) ? date('Y-m-d') : $strDate;
		$objZeb = self::findfirst("realId=".$intRealtorId." and date='".$strDate."'");
		if (empty($objZeb)) return $this->addZebRealtor($intRealtorId, $arrData, $strDate);

		//统计房源信息
		$arrZr = array();
		$strDay = date('d', strtotime($strDate));
		$intMonth = intval(date('m', strtotime($strDate)));
		$clsZebHouse = new ZebHouse();
		$arrZebHouse = $clsZebHouse->getSelectData("ZebHouse", "sum(1) as saleTotal,sum(d{$strDay}Release) as saleValid,sum(if(houseCreate>'".date('Y-m-d 00:00:00')."',d{$strDay}Release,0)) as saleRelease,sum(d{$strDay}Refresh) as saleRefresh,sum(d{$strDay}Click) as saleClick,sum(d{$strDay}Bold) as saleBold,sum(d{$strDay}Tags) as saleTags", "houseType in(".House::TYPE_XINFANG.",".House::TYPE_CIXIN.",".House::TYPE_ERSHOU.") and realId=".$intRealtorId." and month=".$intMonth, array());
		$arrZr['saleTotal'] = intval($arrZebHouse[0]['saleTotal']);
		$arrZr['saleValid'] = intval($arrZebHouse[0]['saleValid']);
		$arrZr['saleRelease'] = intval($arrZebHouse[0]['saleRelease']);
		$arrZr['saleRefresh'] = intval($arrZebHouse[0]['saleRefresh']);
		$arrZr['saleClick'] = intval($arrZebHouse[0]['saleClick']);
		$arrZr['saleBold'] = intval($arrZebHouse[0]['saleBold']);
		$arrZr['saleTags'] = intval($arrZebHouse[0]['saleTags']);
		$arrZebHouse = $clsZebHouse->getSelectData("ZebHouse", "sum(1) as rentTotal,sum(d{$strDay}Release) as rentValid,sum(if(houseCreate>'".date('Y-m-d 00:00:00')."',d{$strDay}Release,0)) as rentRelease,sum(d{$strDay}Refresh) as rentRefresh,sum(d{$strDay}Click) as rentClick,sum(d{$strDay}Bold) as rentBold,sum(d{$strDay}Tags) as rentTags", "houseType in(".House::TYPE_ZHENGZU.",".House::TYPE_HEZU.") and realId=".$intRealtorId." and month=".$intMonth, array());
		$arrZr['rentTotal'] = intval($arrZebHouse[0]['rentTotal']);
		$arrZr['rentValid'] = intval($arrZebHouse[0]['rentValid']);
		$arrZr['rentRelease'] = intval($arrZebHouse[0]['rentRelease']);
		$arrZr['rentRefresh'] = intval($arrZebHouse[0]['rentRefresh']);
		$arrZr['rentClick'] = intval($arrZebHouse[0]['rentClick']);
		$arrZr['rentBold'] = intval($arrZebHouse[0]['rentBold']);
		$arrZr['rentTags'] = intval($arrZebHouse[0]['rentTags']);
		unset($arrZebHouse, $clsZebHouse);

		//获取经纪人端口数量
		$objRealtorPort = new RealtorPort();
		$arrRes = $objRealtorPort->getAccountByRealId($intRealtorId);
		$arrRes = !empty($arrRes) ? $arrRes->toArray() : array();
		$arrZr['rpId'] = !empty($arrRes['id']) ? intval($arrRes['id']) : 0;
		$arrZr['portSaleRelease'] = !empty($arrRes['saleRelease']) ? intval($arrRes['saleRelease']) : 0;
		$arrZr['portSaleRefresh'] = !empty($arrRes['saleRefresh']) ? intval($arrRes['saleRefresh']) : 0;
		$arrZr['portSaleBold'] = !empty($arrRes['saleBold']) ? intval($arrRes['saleBold']) : 0;
		$arrZr['portSaleTags'] = !empty($arrRes['saleTags']) || !empty($arrRes['saleTagsExtra']) ? intval($arrRes['saleTags'])+intval($arrRes['saleTagsExtra']) : 0;
		$arrZr['portRentRelease'] = !empty($arrRes['rentRelease']) ? intval($arrRes['rentRelease']) : 0;
		$arrZr['portRentRefresh'] = !empty($arrRes['rentRefresh']) ? intval($arrRes['rentRefresh']) : 0;
		$arrZr['portRentBold'] = !empty($arrRes['rentBold']) ? intval($arrRes['rentBold']) : 0;
		$arrZr['portRentTags'] = !empty($arrRes['rentTags']) ? intval($arrRes['rentTags']) : 0;
		$objPortCity = new PortCity();
		if(!empty($arrRes['portId']))
			$arrPort = $objPortCity->getOne("id = ".$arrRes['portId']);
		else 
			$arrPort = array();
		$arrZr['portEquivalent'] = !empty($arrPort['equivalent']) ? intval($arrRes['num']*$arrPort['equivalent']) : 0;
		unset($arrAccount, $objRealtorPort, $arrRes, $objPortCity, $arrPort);

		$arrZr['zrUpdate'] = date('Y-m-d H:i:s', time());
		
		//生产上发现有些shopId为空，特此加入以下内容
		$arrRealtor = Realtor::Instance()->getOne('id='.$intRealtorId);
		if(empty($objZeb->shopId))   $arrZr['shopId'] = intval($arrRealtor['shopId']);
		if(empty($objZeb->regId))    $arrZr['regId'] = intval($arrRealtor['regId']);
		if(empty($objZeb->distId))   $arrZr['distId'] = intval($arrRealtor['distId']);
		if(empty($objZeb->cityId))   $arrZr['cityId'] = intval($arrRealtor['cityId']);
		if(empty($objZeb->areaId))   $arrZr['areaId'] = intval($arrRealtor['areaId']);
		if(empty($objZeb->comId))    $arrZr['comId'] = intval($arrRealtor['comId']);
		
		//刷新时间段统计
		if( !empty($arrData) )
		{
			foreach( $arrData as $strKey => $strVal)
			{
				$arrZr[$strKey] = (int)$strVal;
			}
		}
		
		$res = $objZeb->update($arrZr);
		unset($objZeb, $arrData, $arrZr);
		return empty($res) ? false : $res;
    }

    //获取经纪人一个时间段的统计,在同一个月
    public function getRealtorTotal($con, $size, $offset){
        $rs = ZebRealtor::find(
            [
                "conditions" => $con,
                "order" => "realId desc",
                "group" => "realId",
                "limit"      => array(
                    "number" => $size,
                    "offset" => $offset
                ),
                "columns"    => "SUM(saleValid) as saleValid, SUM(saleBold) as saleBold, SUM(saleTags) as saleTags, SUM(saleRefresh) as saleRefresh, SUM(rentValid) as rentValid, SUM(rentBold) as rentBold, SUM(rentTags) as rentTags, SUM(rentRefresh) as rentRefresh,
                                SUM(saleRelease) as saleRelease, SUM(rentRelease) as rentRelease,SUM(saleClick) as saleClick, SUM(rentClick) as rentClick, SUM(portSaleRelease) as portSaleRelease , SUM(portSaleBold) as portSaleBold, SUM(portSaleTags) as portSaleTags, SUM(portSaleRefresh) as portSaleRefresh,
                                SUM(portRentRelease) as portRentRelease, SUM(portRentBold) as portRentBold, SUM(portRentTags) as portRentTags, SUM(portRentRefresh) as portRentRefresh, realId, portEquivalent, date"
            ])->toArray();
        return $rs;
    }
    public function getRealtorTotalCount($con){
        $rs = ZebRealtor::count(
            [
                "conditions" => $con,
                "group" => "realId",

            ])->toArray();
        return count($rs);
    }
    //获取经纪人一个时间段的统计的平均数
    public function getRealtorTotalAvg($con, $size, $offset){
        $rs = ZebRealtor::find(
            [
                "conditions" => $con,
                "order" => "realId desc",
                "group" => "realId",
                "limit"      => array(
                    "number" => $size,
                    "offset" => $offset
                ),
                "columns"    => "floor(AVG(saleValid)) as saleValid, floor(AVG(saleBold)) as saleBold, floor(AVG(saleTags)) as saleTags, floor(AVG(saleRefresh)) as saleRefresh, floor(AVG(rentValid)) as rentValid, floor(AVG(rentBold)) as rentBold, floor(AVG(rentTags)) as rentTags, floor(AVG(rentRefresh)) as rentRefresh,
                                floor(AVG(saleRelease)) as saleRelease, floor(AVG(rentRelease)) as rentRelease, floor(AVG(saleClick)) as saleClick, floor(AVG(rentClick)) as rentClick, floor(AVG(portSaleRelease)) as portSaleRelease, floor(AVG(portSaleBold)) as portSaleBold, floor(AVG(portSaleTags)) as portSaleTags,
                                 floor(AVG(portSaleRefresh)) as portSaleRefresh, floor(AVG(portRentRelease)) as portRentRelease, floor(AVG(portRentBold)) as portRentBold, floor(AVG(portRentTags)) as portRentTags, floor(AVG(portRentRefresh)) as portRentRefresh, realId, portEquivalent"
            ])->toArray();
        return $rs;
    }

    //跨一个月查询
    public function getRealtorTotalTwoMonth($con, $size, $offset, $startMonth, $endMonth){
        if($startMonth ==$endMonth ){
            return $this->getRealtorTotal($con, $size, $offset);
        }
        $con = str_replace("date", "zrDate", $con );
        $columns = "SUM(t.zrSaleValid) as saleValid, SUM(t.zrSaleBold) as saleBold, SUM(t.zrSaleTags) as saleTags, SUM(t.zrSaleRefresh) as saleRefresh, SUM(t.zrRentValid) as rentValid, SUM(t.zrRentBold) as rentBold, SUM(t.zrRentTags) as rentTags,
         SUM(t.zrRentRefresh) as rentRefresh,SUM(t.zrSaleRelease) as saleRelease, SUM(t.zrRentRelease) as rentRelease,SUM(t.zrSaleClick) as saleClick, SUM(t.zrRentClick) as rentClick, SUM(t.zrPortSaleRelease) as portSaleRelease, SUM(t.zrPortSaleBold) as portSaleBold,
          SUM(t.zrPortSaleTags) as portSaleTags ,SUM(t.zrPortSaleRefresh) as portSaleRefresh, SUM(t.zrPortRentRelease) as portRentRelease, SUM(t.zrPortRentBold) as portRentBold, SUM(t.zrPortRentTags) as portRentTags, SUM(t.zrPortRentRefresh) as portRentRefresh, t.realId, t.zrPortEquivalent as portEquivalent";
        $sql = "SELECT $columns FROM (SELECT * from zeb_realtor_m".$startMonth." where $con UNION ALL SELECT * from zeb_realtor_m".$endMonth." where $con) t GROUP BY realId ORDER BY t.realId desc LIMIT $offset, $size ";
        $rs = $this->fetchAll($sql);
        return $rs;
    }

    public function getRealtorTotalCountTwoMonth($con, $startMonth, $endMonth){
        if($startMonth ==$endMonth ){
            return $this->getRealtorTotalCount($con);
        }
        $con = str_replace("date", "zrDate", $con );
        $sql = "SELECT count(*) FROM (SELECT * from zeb_realtor_m".$startMonth." where $con UNION ALL SELECT * from zeb_realtor_m".$endMonth." where $con) t GROUP BY realId ";
        $rs = $this->fetchAll($sql);
        return count($rs);
    }
    public function getRealtorTotalAvgTwoMonth($con, $size, $offset, $startMonth, $endMonth){
        if($startMonth ==$endMonth ){
            return $this->getRealtorTotalAvg($con, $size, $offset);
        }
        $con = str_replace("date", "zrDate", $con );
        $columns = "floor(AVG(t.zrSaleValid)) as saleValid, floor(AVG(t.zrSaleBold)) as saleBold, floor(AVG(t.zrSaleTags)) as saleTags, floor(AVG(t.zrSaleRefresh)) as saleRefresh, floor(AVG(t.zrRentValid)) as rentValid, floor(AVG(t.zrRentBold)) as rentBold, floor(AVG(t.zrRentTags)) as rentTags, floor(AVG(t.zrRentRefresh)) as rentRefresh,
                                floor(AVG(t.zrSaleRelease)) as saleRelease, floor(AVG(t.zrRentRelease)) as rentRelease, floor(AVG(t.zrSaleClick)) as saleClick, floor(AVG(t.zrRentClick)) as rentClick, floor(AVG(t.zrPortSaleRelease)) as portSaleRelease, floor(AVG(t.zrPortSaleBold)) as portSaleBold,
                                floor(AVG(t.zrPortSaleTags)) as portSaleTags, floor(AVG(t.zrPortSaleRefresh)) as portSaleRefresh, floor(AVG(t.zrPortRentRelease)) as portRentRelease, floor(AVG(t.zrPortRentBold)) as portRentBold, floor(AVG(t.zrPortRentTags)) as portRentTags, floor(AVG(t.zrPortRentRefresh)) as portRentRefresh, t.realId, t.zrPortEquivalent as portEquivalent";
        $sql = "SELECT $columns FROM (SELECT * from zeb_realtor_m".$startMonth." where $con UNION ALL SELECT * from zeb_realtor_m".$endMonth." where $con) t GROUP BY realId ORDER BY t.realId desc LIMIT $offset, $size ";
        return $this->fetchAll($sql);
    }
    
}
