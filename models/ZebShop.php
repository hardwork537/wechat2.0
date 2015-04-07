<?php

class ZebShop extends BaseModel
{

    public $id;
    public $shopId;
    public $cityId = 0;
    public $distId = 0;
    public $regId = 0;
    public $areaId = 0;
    public $comId = 0;
    public $date;
    public $realtorTotal = 0;
    public $realtorS1 = 0;
    public $realtorS2 = 0;
    public $realtorS3 = 0;
    public $realtorS4 = 0;
    public $realtorS5 = 0;
    public $realtorS6 = 0;
    public $realtorS7 = 0;
    public $realtorS8 = 0;
    public $realtorS9 = 0;
    public $realtorFree = 0;
    public $realtorFreeH = 0;
    public $realtorPaid = 0;
    public $realtorPaidH = 0;
    public $realtorHC = 0;
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
    public $saleClick = 0;
    public $rentTotal = 0;
    public $rentValid = 0;
    public $rentGreat = 0;
    public $rentViolation = 0;
    public $rentBold = 0;
    public $rentTags = 0;
    public $rentRelease = 0;
    public $rentRefresh = 0;
    public $rentClick = 0;
    public $loginNum = 0;
    public $zsUpdate = 0;
    public $saleBoldTotal = 0;
    public $saleTagsTotal = 0;
    public $saleRefreshTotal = 0;
    public $rentBoldTotal = 0;
    public $rentTagsTotal = 0;
    public $rentRefreshTotal = 0;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'zsId' => 'id',
            'shopId' => 'shopId', 
            'cityId' => 'cityId', 
            'distId' => 'distId', 
            'regId' => 'regId', 
            'areaId' => 'areaId', 
            'comId' => 'comId', 
            'zsDate' => 'date',
            'zsRealtorTotal' => 'realtorTotal',
            'zsRealtorS1' => 'realtorS1',
            'zsRealtorS2' => 'realtorS2',
            'zsRealtorS3' => 'realtorS3',
            'zsRealtorS4' => 'realtorS4',
            'zsRealtorS5' => 'realtorS5',
            'zsRealtorS6' => 'realtorS6',
            'zsRealtorS7' => 'realtorS7',
            'zsRealtorS8' => 'realtorS8',
            'zsRealtorS9' => 'realtorS9',
            'zsRealtorFree' => 'realtorFree',
            'zsRealtorFreeH' => 'realtorFreeH',
            'zsRealtorPaid' => 'realtorPaid',
            'zsRealtorPaidH' => 'realtorPaidH',
            'zsRealtorHC' => 'realtorHC',
            'zsPortEquivalent' => 'portEquivalent',
            'zsPortSaleRelease' => 'portSaleRelease',
            'zsPortSaleRefresh' => 'portSaleRefresh',
            'zsPortSaleBold' => 'portSaleBold',
            'zsPortSaleTags' => 'portSaleTags',
            'zsPortRentRelease' => 'portRentRelease',
            'zsPortRentRefresh' => 'portRentRefresh',
            'zsPortRentBold' => 'portRentBold',
            'zsPortRentTags' => 'portRentTags',
            'zsSaleTotal' => 'saleTotal',
            'zsSaleValid' => 'saleValid',
            'zsSaleGreat' => 'saleGreat',
            'zsSaleViolation' => 'saleViolation',
            'zsSaleBold' => 'saleBold',
            'zsSaleTags' => 'saleTags',
            'zsSaleRelease' => 'saleRelease',
            'zsSaleRefresh' => 'saleRefresh',
            'zsSaleClick' => 'saleClick',
            'zsRentTotal' => 'rentTotal',
            'zsRentValid' => 'rentValid',
            'zsRentGreat' => 'rentGreat',
            'zsRentViolation' => 'rentViolation',
            'zsRentBold' => 'rentBold',
            'zsRentTags' => 'rentTags',
            'zsRentRelease' => 'rentRelease',
            'zsRentRefresh' => 'rentRefresh',
            'zsRentClick' => 'rentClick',
            'zsLoginNum' => 'loginNum',
            'zsUpdate' => 'zsUpdate',
            'zsSaleBoldTotal'=>'saleBoldTotal',
            'zsSaleTagsTotal'=>'saleTagsTotal',
            'zsSaleRefreshTotal'=>'saleRefreshTotal',
            'zsRentBoldTotal'=>'rentBoldTotal',
            'zsRentTagsTotal'=>'rentTagsTotal',
            'zsRentRefreshTotal'=>'rentRefreshTotal'
        );
    }
    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
	
	/**
	 * 写入统计数据
	 *
	 * @param int $intShopId
	 * @param array $arrData
	 * @param str $strDate
	 * @return int|bool
	 */
    public function addZebShop($intShopId, $arrData, $strDate = ''){
		$strDate = empty($strDate) ? date('Y-m-d') : $strDate;
		$arrShop = Shop::Instance()->getOne('id='.$intShopId);
		if (empty($arrShop)) {
			return false;
		}

		//统计房源信息
		$arrZs = array();
		$strDay = date('d', strtotime($strDate));
		$intMonth = intval(date('m', strtotime($strDate)));
		$clsZebHouse = new ZebHouse();
		$arrZebHouse = $clsZebHouse->getSelectData("ZebHouse", "sum(1) as saleTotal,sum(d{$strDay}Release) as saleValid,sum(if(houseCreate>'".date('Y-m-d 00:00:00')."',d{$strDay}Release,0)) as saleRelease,sum(d{$strDay}Refresh) as saleRefresh,sum(d{$strDay}Click) as saleClick,sum(d{$strDay}Bold) as saleBold,sum(d{$strDay}Tags) as saleTags", "houseType in(".House::TYPE_XINFANG.",".House::TYPE_CIXIN.",".House::TYPE_ERSHOU.") and shopId=".$intShopId." and month=".$intMonth, array());
		$arrZs['saleTotal'] = intval($arrZebHouse[0]['saleTotal']);
		$arrZs['saleValid'] = intval($arrZebHouse[0]['saleValid']);
		$arrZs['saleRelease'] = intval($arrZebHouse[0]['saleRelease']);
		$arrZs['saleRefresh'] = intval($arrZebHouse[0]['saleRefresh']);
		$arrZs['saleClick'] = intval($arrZebHouse[0]['saleClick']);
		$arrZs['saleBold'] = intval($arrZebHouse[0]['saleBold']);
		$arrZs['saleTags'] = intval($arrZebHouse[0]['saleTags']);
		$arrZebHouse = $clsZebHouse->getSelectData("ZebHouse", "sum(1) as rentTotal,sum(d{$strDay}Release) as rentValid,sum(if(houseCreate>'".date('Y-m-d 00:00:00')."',d{$strDay}Release,0)) as rentRelease,sum(d{$strDay}Refresh) as rentRefresh,sum(d{$strDay}Click) as rentClick,sum(d{$strDay}Bold) as rentBold,sum(d{$strDay}Tags) as rentTags", "houseType in(".House::TYPE_ZHENGZU.",".House::TYPE_HEZU.") and shopId=".$intShopId." and month=".$intMonth, array());
		$arrZs['rentTotal'] = intval($arrZebHouse[0]['rentTotal']);
		$arrZs['rentValid'] = intval($arrZebHouse[0]['rentValid']);
		$arrZs['rentRelease'] = intval($arrZebHouse[0]['rentRelease']);
		$arrZs['rentRefresh'] = intval($arrZebHouse[0]['rentRefresh']);
		$arrZs['rentClick'] = intval($arrZebHouse[0]['rentClick']);
		$arrZs['rentBold'] = intval($arrZebHouse[0]['rentBold']);
		$arrZs['rentTags'] = intval($arrZebHouse[0]['rentTags']);
		unset($arrZebHouse, $clsZebHouse);

		//统计经纪人信息
		$arrZs['realtorTotal'] = $arrZs['portEquivalent'] = $arrZs['loginNum'] = $arrZs['portSaleRelease'] = $arrZs['portSaleRefresh'] = $arrZs['portSaleBold'] = $arrZs['portSaleTags'] = $arrZs['portRentRelease'] = $arrZs['portRentRefresh'] = $arrZs['portRentBold'] = $arrZs['portRentTags'] = 0;
		$arrRealtor = Realtor::Instance()->getAll('shopId='.$intShopId.' and status='.Realtor::STATUS_OPEN);
		foreach ($arrRealtor as $item) {
			$arrZs['realtorTotal'] += 1;
			//获取经纪人端口数量
			$objRealtorPort = new RealtorPort();
			$arrRes = $objRealtorPort->getAccountByRealId($item['id']);
			if (!empty($arrRes)) {
				$arrRes = $arrRes->toArray();
				$arrZs['portSaleRelease'] += !empty($arrRes['saleRelease']) ? intval($arrRes['saleRelease']) : 0;
				$arrZs['portSaleRefresh'] += !empty($arrRes['saleRefresh']) ? intval($arrRes['saleRefresh']) : 0;
				$arrZs['portSaleBold'] += !empty($arrRes['saleBold']) ? intval($arrRes['saleBold']) : 0;
				$arrZs['portSaleTags'] += !empty($arrRes['saleTags']) ? intval($arrRes['saleTags']) : 0;
				$arrZs['portRentRelease'] += !empty($arrRes['rentRelease']) ? intval($arrRes['rentRelease']) : 0;
				$arrZs['portRentRefresh'] += !empty($arrRes['rentRefresh']) ? intval($arrRes['rentRefresh']) : 0;
				$arrZs['portRentBold'] += !empty($arrRes['rentBold']) ? intval($arrRes['rentBold']) : 0;
				$arrZs['portRentTags'] += !empty($arrRes['rentTags']) ? intval($arrRes['rentTags']) : 0;
				$objPortCity = new PortCity();
				$arrPort = $objPortCity->getOne(" id = ".$arrRes['portId']);
				$arrZs['portEquivalent'] += !empty($arrPort['equivalent']) ? intval($arrRes['num']*$arrPort['equivalent']) : 0;
			}
		}
		unset($arrRealtor, $item, $arrAccount, $objRealtorPort, $arrRes, $objPortCity, $arrPort);

		isset($arrData['loginCount']) && $arrZs['loginNum'] = $arrData['loginCount'];
		$arrZs['shopId'] = $intShopId;
		$arrZs['regId'] = intval($arrShop['regId']);
		$arrZs['distId'] = intval($arrShop['distId']);
		$arrZs['cityId'] = intval($arrShop['cityId']);
		$arrZs['areaId'] = intval($arrShop['areaId']);
		$arrZs['comId'] = intval($arrShop['comId']);
		$arrZs['date'] = empty($strDate) ? date('Y-m-d') : $strDate;
		$arrZs['zsUpdate'] = date('Y-m-d H:i:s', time());
		$res = self::create($arrZs);
		unset($arrZs, $arrShop, $arrData);
		return empty($res) ? false : $res;
    }
	
	/**
	 * 更新统计数据
	 *
	 * @param int $intShopId
	 * @param array $arrData
	 * @param str $strDate
	 * @return int|bool
	 */
    public function modZebShop($intShopId, $arrData, $strDate = ''){
		$strDate = empty($strDate) ? date('Y-m-d') : $strDate;
		$objZeb = self::findfirst("shopId=".$intShopId." and date='".$strDate."'");
		if (empty($objZeb)) return $this->addZebShop($intShopId, $arrData, $strDate);

		//统计房源信息
		$arrZs = array();
		$strDay = date('d', strtotime($strDate));
		$intMonth = intval(date('m', strtotime($strDate)));
		$clsZebHouse = new ZebHouse();
		$arrZebHouse = $clsZebHouse->getSelectData("ZebHouse", "sum(1) as saleTotal,sum(d{$strDay}Release) as saleValid,sum(if(houseCreate>'".date('Y-m-d 00:00:00')."',d{$strDay}Release,0)) as saleRelease,sum(d{$strDay}Refresh) as saleRefresh,sum(d{$strDay}Click) as saleClick,sum(d{$strDay}Bold) as saleBold,sum(d{$strDay}Tags) as saleTags", "houseType in(".House::TYPE_XINFANG.",".House::TYPE_CIXIN.",".House::TYPE_ERSHOU.") and shopId=".$intShopId." and month=".$intMonth, array());
		$arrZs['saleTotal'] = intval($arrZebHouse[0]['saleTotal']);
		$arrZs['saleValid'] = intval($arrZebHouse[0]['saleValid']);
		$arrZs['saleRelease'] = intval($arrZebHouse[0]['saleRelease']);
		$arrZs['saleRefresh'] = intval($arrZebHouse[0]['saleRefresh']);
		$arrZs['saleClick'] = intval($arrZebHouse[0]['saleClick']);
		$arrZs['saleBold'] = intval($arrZebHouse[0]['saleBold']);
		$arrZs['saleTags'] = intval($arrZebHouse[0]['saleTags']);
		$arrZebHouse = $clsZebHouse->getSelectData("ZebHouse", "sum(1) as rentTotal,sum(d{$strDay}Release) as rentValid,sum(if(houseCreate>'".date('Y-m-d 00:00:00')."',d{$strDay}Release,0)) as rentRelease,sum(d{$strDay}Refresh) as rentRefresh,sum(d{$strDay}Click) as rentClick,sum(d{$strDay}Bold) as rentBold,sum(d{$strDay}Tags) as rentTags", "houseType in(".House::TYPE_ZHENGZU.",".House::TYPE_HEZU.") and shopId=".$intShopId." and month=".$intMonth, array());
		$arrZs['rentTotal'] = intval($arrZebHouse[0]['rentTotal']);
		$arrZs['rentValid'] = intval($arrZebHouse[0]['rentValid']);
		$arrZs['rentRelease'] = intval($arrZebHouse[0]['rentRelease']);
		$arrZs['rentRefresh'] = intval($arrZebHouse[0]['rentRefresh']);
		$arrZs['rentClick'] = intval($arrZebHouse[0]['rentClick']);
		$arrZs['rentBold'] = intval($arrZebHouse[0]['rentBold']);
		$arrZs['rentTags'] = intval($arrZebHouse[0]['rentTags']);
		unset($arrZebHouse, $clsZebHouse);

		//统计经纪人信息
		$arrZs['realtorTotal'] = $arrZs['portEquivalent'] = $arrZs['loginNum'] = $arrZs['portSaleRelease'] = $arrZs['portSaleRefresh'] = $arrZs['portSaleBold'] = $arrZs['portSaleTags'] = $arrZs['portRentRelease'] = $arrZs['portRentRefresh'] = $arrZs['portRentBold'] = $arrZs['portRentTags'] = 0;
		$arrRealtor = Realtor::Instance()->getAll('shopId='.$intShopId.' and status='.Realtor::STATUS_OPEN);
		foreach ($arrRealtor as $item) {
			$arrZs['realtorTotal'] += 1;
			//获取经纪人端口数量
			$objRealtorPort = new RealtorPort();
			$arrRes = $objRealtorPort->getAccountByRealId($item['id']);
			if (!empty($arrRes)) {
				$arrRes = $arrRes->toArray();
				$arrZs['portSaleRelease'] += !empty($arrRes['saleRelease']) ? intval($arrRes['saleRelease']) : 0;
				$arrZs['portSaleRefresh'] += !empty($arrRes['saleRefresh']) ? intval($arrRes['saleRefresh']) : 0;
				$arrZs['portSaleBold'] += !empty($arrRes['saleBold']) ? intval($arrRes['saleBold']) : 0;
				$arrZs['portSaleTags'] += !empty($arrRes['saleTags']) ? intval($arrRes['saleTags']) : 0;
				$arrZs['portRentRelease'] += !empty($arrRes['rentRelease']) ? intval($arrRes['rentRelease']) : 0;
				$arrZs['portRentRefresh'] += !empty($arrRes['rentRefresh']) ? intval($arrRes['rentRefresh']) : 0;
				$arrZs['portRentBold'] += !empty($arrRes['rentBold']) ? intval($arrRes['rentBold']) : 0;
				$arrZs['portRentTags'] += !empty($arrRes['rentTags']) ? intval($arrRes['rentTags']) : 0;
				$objPortCity = new PortCity();
				$arrPort = $objPortCity->getOne(" id = ".$arrRes['portId']);
				$arrZs['portEquivalent'] += !empty($arrPort['equivalent']) ? intval($arrRes['num']*$arrPort['equivalent']) : 0;
			}
		}
		unset($arrRealtor, $item, $arrAccount, $objRealtorPort, $arrRes, $objPortCity, $arrPort);

		$arrZs['zsUpdate'] = date('Y-m-d H:i:s', time());
		$res = $objZeb->update($arrZs);
		unset($objZeb, $arrData, $arrZs);
		return empty($res) ? false : $res;
    }
	
	/**
	 * 获得关联后的数据 关联门店名称门店帐号
	 * @param array $condition 搜索条件
	 * @param str $order 排序
	 * @param str $group 分组
	 * @param int $offset 起始位置
	 * @param int $size 返回大小
	 * @param str $select 返回的字段
	 * @param int $type 初始化类型 1售 2租
	 * @param int $city_id 城市id  解决admin系统超管cookie中的城市id为0
	 */
	public function getAllSearch($condition, $order='', $group='', $offset='', $size='', $select='', $type=1, $city_id=0){
		if( empty($condition) ){
			return false;
		}
		$arrSearch = $this->getSelectData('ZebShop', $select, $condition, array(), array(), $order, $group, '', $offset, $size);
		if( false === $arrSearch ){
			return false;
		} elseif (empty($arrSearch)){
			return array();
		}else{
			$objShop = new Shop(); //获得门店对象
			$arrAllTop = array();
			$arrShopId = array();
			foreach($arrSearch as $intSearchKey=>$arrSearchValue){//关联行政区-热点-小区名称
				$arrShopId[] = $arrSearchValue['shopId'];
			}
			$arrShop = $objShop->getShopByIds($arrShopId);
			$objShop = null;
			$objRealtor = new Realtor();
			foreach($arrSearch as $intSearchKey=>$arrSearchValue){//关联行政区-热点-小区名称
				if(!empty($arrShop)){//信息获得成功时候才计入统计
					$arrSearchValue['shop_name'] = isset($arrShop[$arrSearchValue['shopId']]['name'])?$arrShop[$arrSearchValue['shopId']]['name']:'';
					$arrSearchValue['shop_accname'] = isset($arrShop[$arrSearchValue['shopId']]['accname'])?$arrShop[$arrSearchValue['shopId']]['accname']:'';
					$unit_sum = array();
					$unit_sum['max_unit'] 				= intval($arrSearchValue['max_unit']);
					$unit_sum['max_unit_recommend'] 	= intval($arrSearchValue['max_unit_recommend']);
					$unit_sum['max_unit_flag'] 			= intval($arrSearchValue['max_unit_flag']);
					$unit_sum['max_unit_flush'] 		= intval($arrSearchValue['max_unit_flush']);
					switch ($type){
						case 1: //出售
							if( $arrSearchValue['unit'] > $unit_sum['max_unit'] ){
								$arrSearchValue['unit'] = $unit_sum['max_unit'];
								$arrSearchValue['unit_scale'] = empty($arrSearchValue['unit'])? 0 : 1;
							}
							else{
								$arrSearchValue['unit_scale'] =empty($unit_sum['max_unit']) ? 0 :$arrSearchValue['unit']/$unit_sum['max_unit'];
							}
							if( $arrSearchValue['unit_recommend'] > $unit_sum['max_unit_recommend'] ){
								$arrSearchValue['unit_recommend'] = $unit_sum['max_unit_recommend'];
								$arrSearchValue['unit_recommend_scale'] = empty($arrSearchValue['unit_recommend'])? 0 : 1;
							}
							else{
								$arrSearchValue['unit_recommend_scale'] = empty($unit_sum['max_unit_recommend']) ? 0 :$arrSearchValue['unit_recommend']/$unit_sum['max_unit_recommend'];
							}
							if( $arrSearchValue['unit_flag'] > $unit_sum['max_unit_flag'] ){
								$arrSearchValue['unit_flag'] = $unit_sum['max_unit_flag'];
								$arrSearchValue['unit_flag_scale'] = empty($arrSearchValue['unit_flag'])? 0 : 1;
							}
							else{
								$arrSearchValue['unit_flag_scale'] = empty($unit_sum['max_unit_flag']) ? 0 :$arrSearchValue['unit_flag']/$unit_sum['max_unit_flag'];
							}
							if( $arrSearchValue['unit_flush'] > $unit_sum['max_unit_flush'] ){
								$arrSearchValue['unit_flush'] = $unit_sum['max_unit_flush'];
								$arrSearchValue['unit_flush_scale'] = empty($arrSearchValue['unit_flush'])? 0 : 1;
							}
							else{
								$arrSearchValue['unit_flush_scale'] = empty($unit_sum['max_unit_flush']) ? 0 : $arrSearchValue['unit_flush']/$unit_sum['max_unit_flush'];
							}
						break;
						case 2: //出租
							if( $arrSearchValue['unit'] > $unit_sum['max_unit'] ){
								$arrSearchValue['unit'] = $unit_sum['max_unit'];
								$arrSearchValue['unit_scale'] =empty($unit_sum['max_unit']) ? 0 :$arrSearchValue['unit']/$unit_sum['max_unit'];
							}
							else{
								$arrSearchValue['unit_scale'] = $arrSearchValue['unit']/$unit_sum['max_unit_rent'];
							}
							if( $arrSearchValue['unit_recommend'] > $unit_sum['max_unit_recommend'] ){
								$arrSearchValue['unit_recommend'] = $unit_sum['max_unit_recommend'];
								$arrSearchValue['unit_recommend_scale'] = empty($arrSearchValue['unit_recommend'])? 0 : 1;
							}
							else{
								$arrSearchValue['unit_recommend_scale'] = empty($unit_sum['max_unit_recommend']) ? 0 :$arrSearchValue['unit_recommend']/$unit_sum['max_unit_recommend'];
							}
							if( $arrSearchValue['unit_flag'] > $unit_sum['max_unit_flag'] ){
								$arrSearchValue['unit_flag'] = $unit_sum['max_unit_flag'];
								$arrSearchValue['unit_flag_scale'] = empty($arrSearchValue['unit_flag'])? 0 : 1;
							}
							else{
								$arrSearchValue['unit_flag_scale'] = empty($unit_sum['max_unit_flag']) ? 0 :$arrSearchValue['unit_flag']/$unit_sum['max_unit_flag'];
							}
							if( $arrSearchValue['unit_flush'] > $unit_sum['max_unit_flush'] ){
								$arrSearchValue['unit_flush'] = $unit_sum['max_unit_flush'];
								$arrSearchValue['unit_flush_scale'] = empty($arrSearchValue['unit_flush'])? 0 : 1;
							}
							else{
								$arrSearchValue['unit_flush_scale'] = empty($unit_sum['max_unit_flush']) ? 0 : $arrSearchValue['unit_flush']/$unit_sum['max_unit_flush'];
							}
							break;
					}
					$arrAllTop[] = $arrSearchValue;
				}
			}
			$arrSearch = null;
			return $arrAllTop;
		}
	}
    
    /**
     * 根据门店id、日期获取门店统计数据
     * @param int|array $shopIds
     * @param string    $columns
     * @param string    $date
     * @return array
     */
    public function getDataByShopId($shopIds, $columns = '', $date)
    {
        if(empty($shopIds) || !$date)
        {
            return array();
        }
        if(is_array($shopIds))
        {
            $arrBind = $this->bindManyParams($shopIds);
            $arrCond = "shopId in({$arrBind['cond']}) and date='{$date}'";
            $arrParam = $arrBind['param'];
            $condition = array(
                $arrCond,
                "bind" => $arrParam,
            );
        }
        else
        {
            $condition = array('conditions'=>"shopId={$shopIds} and date='{$date}'");
        }
        $columns && $condition['columns'] = $columns;
        $arrData  = self::find($condition,0)->toArray();
        
        $arrRdata=array();
        foreach($arrData as $value)
        {
        	$arrRdata[$value['shopId']][$value['date']] = $value;
        }
        
        return $arrRdata;
    }

    //获取经纪人一个时间段的统计
    public function getShopTotal($con, $size, $offset){
        $rs = ZebShop::find(
            [
                "conditions" => $con,
                "order" => "shopId desc",
                "group" => "shopId",
                "limit"      => array(
                    "number" => $size,
                    "offset" => $offset
                ),
                "columns"    => "SUM(saleValid) as saleValid, SUM(saleBold) as saleBold, SUM(saleTags) as saleTags, SUM(saleRefresh) as saleRefresh, SUM(rentValid) as rentValid, SUM(rentBold) as rentBold, SUM(rentTags) as rentTags, SUM(rentRefresh) as rentRefresh,
                                SUM(loginNum) as loginNum, SUM(saleRelease) as saleRelease, SUM(rentRelease) as rentRelease,SUM(saleClick) as saleClick, SUM(rentClick) as rentClick, SUM(portSaleRelease) as portSaleRelease, SUM(portSaleBold) as portSaleBold, SUM(portSaleTags) as portSaleTags,
                                SUM(portSaleRefresh) as portSaleRefresh, SUM(portRentRelease) as portRentRelease, SUM(portRentBold) as portRentBold, SUM(portRentTags) as portRentTags, SUM(portRentRefresh) as portRentRefresh, shopId, portEquivalent,realtorTotal"
            ])->toArray();
        return $rs;
    }
    public function getShopTotalCount($con){
        $rs = ZebShop::count(
            [
                "conditions" => $con,
                "group" => "shopId",

            ])->toArray();
        return count($rs);
    }
    //获取经纪人一个时间段的统计的平均数
    public function getShopTotalAvg($con, $size, $offset){
        $rs = ZebShop::find(
            [
                "conditions" => $con,
                "order" => "shopId desc",
                "group" => "shopId",
                "limit"      => array(
                    "number" => $size,
                    "offset" => $offset
                ),
                "columns"    => "floor(AVG(saleValid)) as saleValid, floor(AVG(saleBold)) as saleBold, floor(AVG(saleTags)) as saleTags, floor(AVG(saleRefresh)) as saleRefresh, floor(AVG(rentValid)) as rentValid, floor(AVG(rentBold)) as rentBold, floor(AVG(rentTags)) as rentTags, floor(AVG(rentRefresh)) as rentRefresh,
                                floor(AVG(loginNum)) as loginNum, floor(AVG(saleRelease)) as saleRelease, floor(AVG(rentRelease)) as rentRelease, floor(AVG(saleClick)) as saleClick, floor(AVG(rentClick)) as rentClick, floor(AVG(portSaleRelease)) as portSaleRelease, floor(AVG(portSaleBold)) as portSaleBold, floor(AVG(portSaleTags)) as portSaleTags,
                                floor(AVG(portSaleRefresh)) as portSaleRefresh, floor(AVG(portRentRelease)) as portRentRelease, floor(AVG(portRentBold)) as portRentBold, floor(AVG(portRentTags)) as portRentTags, floor(AVG(portRentRefresh)) as portRentRefresh, shopId, portEquivalent, realtorTotal"
            ])->toArray();
        return $rs;
    }


}
