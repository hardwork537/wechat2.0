<?php
class Rent extends BaseModel
{
	//是否标签 is_flag 字段：0: 否 ，1:急 2:免 3:急 免
	const RENT_NOTAG = 0;
	const RENT_JITAG = 1;
	const RENT_FREETAG = 2;
	const RENT_ALLTAG = 3;
	//出租方式 rent_type 
	const RENT_TYPE_ALL = 2; //整租
	const RENT_TYPE_TOGETHER = 1; //合租

    public $rentId;
    public $houseId;
    public $type = 0;
    public $typeTo = 0;
    public $price = 0;
    public $currency = 0;
    public $payment = 0;
    public $title;
    public $features = '';
    public $facility = '';
    public $facilityExtra = '';
    public $parkName;
    public $address = '';
    public $status = 0;
    public $rentUpdate;
    public $refreshCount = 0;
    public $refreshTime;

    public function getRentId()
    {
        return $this->rentId;
    }

    public function setRentId($rentId)
    {
        if(preg_match('/^\d{1,10}$/', $rentId == 0) || $rentId > 4294967295)
        {
            return false;
        }
        $this->rentId = $rentId;
    }

    public function getHouseId()
    {
        return $this->houseId;
    }

    public function setHouseId($houseId)
    {
        if(preg_match('/^\d{1,10}$/', $houseId == 0) || $houseId > 4294967295)
        {
            return false;
        }
        $this->houseId = $houseId;
    }

    public function getRentType()
    {
        return $this->rentType;
    }

    public function setRentType($rentType)
    {
        if(preg_match('/^\d{1,3}$/', $rentType == 0) || $rentType > 255)
        {
            return false;
        }
        $this->rentType = $rentType;
    }

    public function getRentTypeTo()
    {
        return $this->typeTo;
    }

    public function setRentTypeTo($rentTypeTo)
    {
        if(preg_match('/^\d{1,3}$/', $rentTypeTo == 0) || $rentTypeTo > 255)
        {
            return false;
        }
        $this->typeTo = $rentTypeTo;
    }

    public function getRentPrice()
    {
        return $this->price;
    }

    public function setRentPrice($rentPrice)
    {
        if(preg_match('/^\d{1,10}$/', $rentPrice == 0) || $rentPrice > 4294967295)
        {
            return false;
        }
        $this->price = $rentPrice;
    }

    public function getRentCurrency()
    {
        return $this->currency;
    }

    public function setRentCurrency($rentCurrency)
    {
        if(preg_match('/^\d{1,3}$/', $rentCurrency == 0) || $rentCurrency > 255)
        {
            return false;
        }
        $this->currency = $rentCurrency;
    }

    public function getRentPayment()
    {
        return $this->payment;
    }

    public function setRentPayment($rentPayment)
    {
        if(preg_match('/^\d{1,3}$/', $rentPayment == 0) || $rentPayment > 255)
        {
            return false;
        }
        $this->payment = $rentPayment;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        if($title == '' || mb_strlen($title, 'utf8') > 50)
        {
            return false;
        }
        $this->title = $title;
    }

    public function getFeatures()
    {
        return $this->features;
    }

    public function setFeatures($features)
    {
        if($features == '' || mb_strlen($features, 'utf8') > 50)
        {
            return false;
        }
        $this->features = $features;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        if($address == '' || mb_strlen($address, 'utf8') > 50)
        {
            return false;
        }
        $this->address = $address;
    }

    public function getFacility()
    {
        return $this->facility;
    }

    public function setFacility($facility)
    {
        if($facility == '' || mb_strlen($facility, 'utf8') > 50)
        {
            return false;
        }
        $this->facility = $facility;
    }

    public function getParkName()
    {
        return $this->parkName;
    }

    public function setParkName($parkName)
    {
        if($parkName == '' || mb_strlen($parkName, 'utf8') > 50)
        {
            return false;
        }
        $this->parkName = $parkName;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($saleStatus)
    {
        if(preg_match('/^-?\d{1,3}$/', $saleStatus) == 0 || $saleStatus > 127 || $saleStatus < -128)
        {
            return false;
        }
        $this->status = $saleStatus;
    }

    public function getRentUpdate()
    {
        return $this->rentUpdate;
    }

    public function setRentUpdate($rentUpdate)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $rentUpdate) == 0 || strtotime($rentUpdate) == false)
        {
            return false;
        }
        $this->rentUpdate = $rentUpdate;
    }

    public function getRefreshCount()
    {
        return $this->refreshCount;
    }

    public function setRefreshCount($saleRefreshCount)
    {
        if(preg_match('/^\d{1,10}$/', $saleRefreshCount == 0) || $saleRefreshCount > 4294967295)
        {
            return false;
        }
        $this->refreshCount = $saleRefreshCount;
    }

    public function getRefreshTime()
    {
        return $this->refreshTime;
    }

    public function setRefreshTime($saleRefreshTime)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $saleRefreshTime) == 0 || strtotime($saleRefreshTime) == false)
        {
            return false;
        }
        $this->refreshTime = $saleRefreshTime;
    }

    public function getSource()
    {
        return 'house_rent';
    }

    public function columnMap()
    {
        return array(
            'rentId' => 'rentId',
            'houseId' => 'houseId',
            'rentType' => 'type',  
            'rentTypeTo' => 'typeTo',
            'rentPrice' => 'price',
            'rentCurrency' => 'currency',
            'rentPayment' => 'payment',
            'rentTitle' => 'title',
            'rentFeatures' => 'features',
            'rentFacility' => 'facility',
            'rentFacilityExtra' => 'facilityExtra',
            'rentParkName' => 'parkName',
            'rentAddress' => 'address',
            'rentStatus' => 'status',
            'rentUpdate' => 'rentUpdate',//不能改为update，否则会影响sql解析
            'rentRefreshCount' => 'refreshCount',
            'rentRefreshTime' => 'refreshTime'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }

    public function onConstruct()
    {
		\Phalcon\Mvc\Model::setup(array(
			'notNullValidations' => false
		));
    }
	
	/**
	 * 检查指定经纪人是否存在指定标题的房源
	 *
	 * @param int $intRealId 经纪人ID
	 * @param string $strTitle 房源标题
	 * @param int $intHouseId 房源ID
	 * @return bool
	 */
	public function isExistTitle($intRealId, $strTitle, $intHouseId = 0) {
		$strCondition = "h.realId = ".$intRealId;
		$strCondition .= " AND title = '".$strTitle."'";
		$strCondition .= " AND h.status IN(".House::STATUS_ONLINE.",".House::STATUS_OFFLINE.")";
		//构建查询条件
		if ( !empty($intHouseId) ) {
			$strCondition .= " AND h.id != ".$intHouseId;
		}
		$objCount = self::query()
			->columns('COUNT(h.id) AS cnt')
			->where($strCondition)
			->leftJoin('House', 'h.id = Rent.houseId', 'h')
			->execute()
			->getFirst();
		return $objCount->cnt > 0 ? true : false;
	}
	
	/**
	 * 根据房源Id更新房源信息
	 *
	 * @param int $intRentId 单条房源Id
	 * @param array $arrData
	 * @return int|bool
	 */
	public function modifyRentById($intRentId, $arrData) {
		//租金
		if ( isset($arrData['price']) ) {
			$arrUpdate['price'] = $arrData['price'];
		}
		if ( isset($arrData['rentPrice']) ) {
			$arrUpdate['price'] = $arrData['rentPrice'];
		}
		//房源标题
		if ( isset($arrData['title']) ) {
			$arrUpdate['title'] = stripslashes($arrData['title']);
		}
		//小区名称
		if ( isset($arrData['parkName']) ) {
			$arrUpdate['parkName'] = $arrData['parkName'];
		}
		//小区地址
		if ( isset($arrData['address']) ) {
			$arrUpdate['address'] = $arrData['address'];
		}
		//房屋配置
		if ( isset($arrData['facility']) )
		{
			$arrUpdate['facility'] = $arrData['facility'];
			$arrUpdate['facility'] = empty($arrUpdate['facility']) ? new Phalcon\Db\RawValue("''") : $arrUpdate['facility'];
		}
		//基本设施
		if ( isset($arrData['facilityExtra']) )
		{
			$arrUpdate['facilityExtra'] = $arrData['facilityExtra'];
			$arrUpdate['facilityExtra'] = empty($arrUpdate['facilityExtra']) ? new Phalcon\Db\RawValue("''") : $arrUpdate['facilityExtra'];
		}
		//特色房源
		if ( isset($arrData['sign']) ) {
			$arrData['sign'] = is_array($arrData['sign']) ? implode(',', $arrData['sign']) : $arrData['sign'];
			$arrUpdate['features'] = empty($arrData['sign']) ? new Phalcon\Db\RawValue("''") : $arrData['sign'];
		}
		//租金单位
		if( isset($arrData['currency']) )
		{
			$arrUpdate['currency'] = $arrData['currency'];
		}
		if( isset($arrData['rentCurrency']) )
		{
			$arrUpdate['currency'] = $arrData['rentCurrency'];
		}
		//租金支付方式
		if( isset($arrData['payment']) )
		{
			$arrUpdate['payment'] = !empty($GLOBALS['SITE_CONFIG']['PRICE_TYPE'][$arrData['payment']]) ? $GLOBALS['SITE_CONFIG']['PRICE_TYPE'][$arrData['payment']] : 1;
		}
		if( isset($arrData['rentPayment']) )
		{
			$arrUpdate['payment'] = $arrData['rentPayment'];
		}
		//出租方式
		if( isset($arrData['rentType']) )
		{
			$arrUpdate['type'] = $arrData['rentType'];
		}
		//合租类型
		if( isset($arrData['rentTypeTo']) && $arrData['rentType'] == 1 )
		{
			$arrUpdate['typeTo'] = $arrData['rentTypeTo'];
		}

		$objRentUpdate = self::findfirst("houseId = ".$intRentId);
		return $objRentUpdate->update($arrUpdate);
	}
	
	/**
	 * 根据房源ID修改房源
	 *
	 * @param int $intUnitId
	 * @param array $arrData
	 * @return bool|int
	 */
	public function modifyUnitById($intUnitId, $arrData) {
		return $this->modifyRentById($intUnitId, $arrData);
	}
	
	/**
	 * 刷新房源
	 * @param unknown $arrHouseID
	 * @return boolean
	 */
	public function flushHouseById( $arrHouseID,$arrRefreshLogData )
	{
		if( empty($arrHouseID) )	return false;
		
		foreach ($arrHouseID as $intHouseId)
		{
			//更新Rent表房源刷新数量
			$objRent = self::findFirst("houseId = {$intHouseId['houseId']}");
			$objRent->refreshCount = (int)$objRent->rentRefreshCount + 1;
			$objRent->refreshTime = date('Y-m-d H:i:s', time());
			$objRent->type = (int)$arrRefreshLogData['houseType'] == 10 ? 0 : 1;
			$intFlag = $objRent->update();
			if( !$intFlag )
			{
				return false;
			}
			
			//记录刷新日志
			$objRefreshLog = new RefreshLog();
			$intFlag = $objRefreshLog->addLog( $arrRefreshLogData );
			if( !$intFlag )
			{
				return false;
			}
			
			//更新ES刷新时间
			global $sysES;
			$objES = new Es($sysES['default']);
			$intFlag = $objES->update (array('id'=> $intHouseId['houseId'],'houseId'=> $intHouseId['houseId'],'data'=>array('houseRefreshTime'=> time())));
			if( !$intFlag )
			{
				return false;
			}
			unset($intFlag);
		}
		return true;
	}
	
	/**
	 * 新增房源扩展属性
	 *
	 * @param array $arrData
	 * @return int|bool
	 */
	public function addUnit( $arrData )
	{
		if( empty($arrData) )	return false;
		
		//房源状态
		if( isset($arrData['status']))
		{
			$arrInsert['status'] = $arrData['status'];
		}
		//租金
		if( isset($arrData['price']) )
		{
			$arrInsert['price'] = $arrData['price'];
		}
		if ( isset($arrData['rentPrice']) )
		{
			$arrInsert['price'] = $arrData['rentPrice'];
		}
		//房源ID
		if( isset($arrData['houseId']))
		{
			$arrInsert['houseId'] = $arrData['houseId'];
		}
		//房源标题
		if ( isset($arrData['title']) )
		{
			$arrInsert['title'] = stripslashes($arrData['title']);
		}
		//小区名称
		if ( isset($arrData['parkName']) )
		{
			$arrInsert['parkName'] = $arrData['parkName'];
		}
		//小区地址
		if ( isset($arrData['address']) )
		{
			$arrInsert['address'] = $arrData['address'];
		}
		//房屋配置
		if ( isset($arrData['facility']) )
		{
			$arrInsert['facility'] = $arrData['facility'];
		}
		//基本设施
		if ( isset($arrData['facilityExtra']) )
		{
			$arrInsert['facilityExtra'] = $arrData['facilityExtra'];
		}
		//特色房源
		if ( isset($arrData['sign']) ) {
			$arrData['sign'] = is_array($arrData['sign']) ? implode(',', $arrData['sign']) : $arrData['sign'];
			$arrInsert['features'] = $arrData['sign'];
		}
		//租金单位
		if( isset($arrData['currency']) )
		{
			$arrInsert['currency'] = $arrData['currency'];
		}
		if( isset($arrData['rentCurrency']) )
		{
			$arrInsert['currency'] = $arrData['rentCurrency'];
		}
		//租金支付方式
		if( isset($arrData['payment']) )
		{
			$arrInsert['payment'] = !empty($GLOBALS['SITE_CONFIG']['PRICE_TYPE'][$arrData['payment']]) ? $GLOBALS['SITE_CONFIG']['PRICE_TYPE'][$arrData['payment']] : 1;
		}
		if( isset($arrData['rentPayment']) )
		{
			$arrInsert['payment'] = $arrData['rentPayment'];
		}
		//出租方式
		if( isset($arrData['rentType']) )
		{
			$arrInsert['type'] = $arrData['rentType'];
		}
		//合租类型
		if( isset($arrData['rentTypeTo']) && $arrData['rentType'] == 1 )
		{
			$arrInsert['typeTo'] = $arrData['rentTypeTo'];
		}
		//刷新时间
		if( isset($arrData['refreshTime']) )
		{
			$arrInsert['refreshTime'] = $arrData['refreshTime'];
		}

        return self::create($arrInsert);
	}
	
	/**
	 * 获取指定经纪人名下所有的有效发布标签（急、免）数量
	 *
	 * @param int $realId
	 * @return int
	 */
	public function getTagTotal($realId)
	{
		$sum = 0;
		$clsHouse = new House();
		$whereRent = " realId= ".$realId." and status = ".House::STATUS_ONLINE." and type in (".House::TYPE_HEZU.", ".House::TYPE_ZHENGZU.") and tags > 0";
		$arrRent = $clsHouse->getAll($whereRent,'','','','tags');
		if ( !empty($arrRent) ) {
			foreach ( $arrRent as $rent ) {
				if ( $rent['tags'] == self::RENT_ALLTAG ) {
					$sum += 2;
				} else {
					$sum += 1;
				}
			}
		}
		return $sum;
	}
	
	/**
	 * 获取指定经纪人名下还可设置的标签(急、免)数量
	 *
	 * @param int $realId
	 * @return int
	 */
	public function getTagValid($realId)
	{
		//获取经纪人端口信息
		$objRealtorPort = new RealtorPort();
		$objRes = $objRealtorPort->getAccountByRealId($realId);
		if (empty($objRes)) return 0;

		//获取还可设置的标签数量
		$total = $this->getTagTotal($realId);
		$valid = $objRes->rentTags - $total;

		return $valid;
	}
	
	/**
	 * 获取指定经纪人名下还可设置的特色标签数量
	 * @param int $realId 经纪人ID
	 * @return int
	 */
	public function getSignValid($realId){
		//获取经纪人端口信息
		$objRealtorPort = new RealtorPort();
		$objRes = $objRealtorPort->getAccountByRealId($realId);

		//获取还可设置的特色标签数量
		$valid = empty($objRes->rentTagsExtra) ? 0 : $objRes->rentTagsExtra;

		return $valid;
	}

    /**
     * 获取指定房源的出租表的信息
     *
     * @param int $houseId
     * @return array()
     */
    public function getRentById($houseId)
    {
        if( empty($houseId) ){
            return false;
        }
        return self::findfirst( " houseId=".$houseId );
    }

    /**
     * @abstract 获取指定房源ids的出租表的信息
     * @param array $ids
     * @return array|bool
     *
     */
    public function getRentByIds($ids)
    {
        if(!$ids) return false;
        if(is_array($ids))
        {
            $arrBind = $this->bindManyParams($ids);
            $arrCond = "houseId in({$arrBind['cond']})";
            $arrParam = $arrBind['param'];
            $arrPark  = self::find(array(
                $arrCond,
                "bind" => $arrParam
            ),0)->toArray();
            return $arrPark;
        }
        else
        {
            $rentInfo = $this->getRentById($ids);
            if($rentInfo)
            {
            	return $rentInfo->toArray();
            }
            else
            {
            	return $this->getRentById($ids);
            }
        	
        }
    }


    /**
     * 刷新房源  -- 房源数据
     * @auth jackchen
     * @param array $arrHouse
     * @return boolean
     */
    public function flushHouseByIds($arrHouse)
    {
        if( empty($arrHouse) )	return false;

        foreach ($arrHouse as $intHouseId)
        {
            //更新Rent表房源刷新数量
            $objRent = self::findFirst("houseId = {$intHouseId['id']}");
            $objRent->refreshCount = (int)$objRent->saleRefreshCount + 1;
            $objRent->refreshTime = date('Y-m-d H:i:s', time());
            $intFlag = $objRent->update();
            if( !$intFlag )
            {
                return false;
            }

            //记录刷新日志
            $objRefreshLog = new RefreshLog();
            $arrdata = array();
            $arrdata['time']		=	time();
            $arrdata['realId']	=	$intHouseId['realId'];
            $arrdata['houseType']	=	$intHouseId['type'];
            $arrdata['houseQuality']	=	$intHouseId['quality'];
            $arrdata['houseId']	=	$intHouseId['id'];
            $arrdata['isAuto']	=RefreshLog::REFRESH_MANUL;
            $arrdata['parkId']	=	$intHouseId['parkId'];
            $arrdata['shopId']	=	isset($intHouseId['shopId']) ? $intHouseId['shopId'] : 0;
            $arrdata['areaId']	=	isset($intHouseId['areaId']) ? $intHouseId['areaId'] : 0;
            $arrdata['comId']	=	isset($intHouseId['comId']) ? $intHouseId['comId'] : 0;
            $intFlag = $objRefreshLog->addLog($arrdata);;
            if( !$intFlag )
            {
                return false;
            }

            //更新ES刷新时间
            global $sysES;
            $params = $sysES['default'];
            $params['index'] = 'esf';
            $params['type'] = 'house';
            $client = new Es($params);
            $intFlag = $client->update (array('id'=> $intHouseId['id'],'houseId'=> $intHouseId['id'],'data'=>array('houseRefreshTime'=> time())));
            if( !$intFlag )
            {
                return false;
            }
            unset($intFlag);
        }
        return true;
    }

	/**
	 * 获取经纪人发布房源剩余端口数量
	 * @author qiyaguo@sohu-inc.com
	 * @param int $intRealtorId
	 * @return int
	 */
	public function getLeftOnlineByRealtor($intRealtorId){
		$clsRealtorPort = new RealtorPort();
		$objRes = $clsRealtorPort->getAccountByRealId($intRealtorId);
		if (empty($objRes)) return false;
		$intNum = intval($objRes->rentRelease);
		//构建查询条件
		$strCondition = "h.realId='".$intRealtorId."'";
		$strCondition .= " AND h.status = ".House::STATUS_ONLINE;
		$strCondition .= " AND h.roleType=".House::ROLE_REALTOR;
		$arrUnit = Rent::query()
			->columns("h.id")
			->where($strCondition)
			->leftJoin('House', 'h.id = Rent.houseId', 'h')
			->execute();
		$arrUnit = empty($arrUnit) ? array() : $arrUnit->toArray();
		$intUse = count($arrUnit);
		$intReturn = $intNum-$intUse;
		if($intReturn<0) $intReturn=0;
		return $intReturn;
	}

	/**
	 * 获取经纪人精品房源剩余端口数量
	 * @author qiyaguo@sohu-inc.com
	 * @param int $intRealtorId
	 * @return int
	 */
	public function getLeftRecommendByRealtor($intRealtorId){
		$clsRealtorPort = new RealtorPort();
		$objRes = $clsRealtorPort->getAccountByRealId($intRealtorId);
		if (empty($objRes)) return false;
		$intNum = intval($objRes->rentBold);
		//构建查询条件
		$strCondition = "h.realId='".$intRealtorId."'";
		$strCondition .= " AND h.status = ".House::STATUS_ONLINE;
		$strCondition .= " AND h.roleType=".House::ROLE_REALTOR;
		$strCondition .= " AND h.fine=".House::FINE_YES;
		$arrUnit = Rent::query()
			->columns("h.id")
			->where($strCondition)
			->leftJoin('House', 'h.id = Rent.houseId', 'h')
			->execute();
		$arrUnit = empty($arrUnit) ? array() : $arrUnit->toArray();
		$intUse = count($arrUnit);
		$intReturn = $intNum-$intUse;
		if($intReturn<0) $intReturn=0;
		return $intReturn;
	}

    /**
     * 实例化
     * @param type $cache
     * @return Rent_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }


}
