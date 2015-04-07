<?php
class Sale extends BaseModel
{

    public $saleId;
    public $houseId;
    public $saleType = 0;
    public $price = 0;
    public $unit = 0;
    public $title;
    public $features = '';
    public $address = '';
    public $facility = '';
    public $parkName = '';
    public $qualityImgID = '';
    public $status = 1;
    public $update;
    public $refreshCount = 0;
    public $refreshTime;

    public function getSaleId()
    {
        return $this->saleId;
    }

    public function setSaleId($saleId)
    {
        if(preg_match('/^\d{1,10}$/', $saleId == 0) || $saleId > 4294967295)
        {
            return false;
        }
        $this->saleId = $saleId;
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

    public function getSaleType()
    {
        return $this->saleType;
    }

    public function setSaleType($saleType)
    {
        if(preg_match('/^\d{1,3}$/', $saleType == 0) || $saleType > 255)
        {
            return false;
        }
        $this->saleType = $saleType;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        if(preg_match('/^\d{1,10}$/', $price == 0) || $price > 4294967295)
        {
            return false;
        }
        $this->price = $price;
    }

    public function getUnit()
    {
        return $this->unit;
    }

    public function setUnit($unit)
    {
        if(preg_match('/^\d{1,10}$/', $unit == 0) || $unit > 4294967295)
        {
            return false;
        }
        $this->unit = $unit;
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

    public function getUpdate()
    {
        return $this->update;
    }

    public function setUpdate($saleUpdate)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $saleUpdate) == 0 || strtotime($saleUpdate) == false)
        {
            return false;
        }
        $this->update = $saleUpdate;
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
        return 'house_sale';
    }

    public function columnMap()
    {
        return array(
            'saleId' => 'saleId',
            'houseId' => 'houseId',
            'saleType' => 'saleType',
            'salePrice' => 'price',
            'saleUnit' => 'unit',
            'saleTitle' => 'title',
            'saleFeatures' => 'features',
            'saleAddress' => 'address',
            'saleFacility' => 'facility',
            'saleParkName' => 'parkName',
            'saleQualityImgID' => 'qualityImgID',
            'saleStatus' => 'status',
            'saleUpdate' => 'update',
            'saleRefreshCount' => 'refreshCount',
            'saleRefreshTime' => 'refreshTime'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    
    /**
     * 获取指定房源的出售表的信息
     *
     * @param int $houseId
     * @return array()
     */
    public function getSaleById($houseId)
    {
    	if( empty($houseId) ){
    		return false;
    	}
    	return self::findfirst( " houseId=".$houseId );
    }

    /**
     * @abstract 获取指定房源ids的出售表的信息
     * @param array $ids
     * @return array|bool
     *
     */
    public function getSaleByIds($ids, $columns = '')
    {
        if(!$ids) return false;
        if(is_array($ids))
        {
            $arrBind = $this->bindManyParams($ids);
            $arrCond = "houseId in({$arrBind['cond']})";
            $arrParam = $arrBind['param'];
            $condition = array(
                $arrCond,
                "bind" => $arrParam
            );
        }
        else
        {
            $condition = array(
                'conditions' => "houseId={$ids}"
            );
        }
        $columns && $condition['columns'] = $columns;
        $arrHouse = self::find($condition, 0)->toArray();
        
        $returnData = array();
        foreach($arrHouse as $v)
        {
            $returnData[$v['houseId']] = $v;
        }
        
        return $returnData;
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
			->leftJoin('House', 'h.id = Sale.houseId', 'h')
			->execute()
			->getFirst();
		return $objCount->cnt > 0 ? true : false;
	}
	
	/**
	 * 获取指定经纪人名下所有的有效发布标签数量
	 *
	 * @param int $realId
	 * @return int
	 */
	public function getTagTotal($realId)
	{
		$sum = 0;
		//考虑发布，下架，违规三种状态
		$strCondition = "h.realId = ".$realId;
		$strCondition .= " AND h.status IN(".House::STATUS_ONLINE.",".House::STATUS_OFFLINE/*.",".House::STATUS_VIOLATION*/.")";
		$arrSale = self::query()
			->columns('features')
			->where($strCondition)
			->leftJoin('House', 'h.id = Sale.houseId', 'h')
			->execute();
		$arrSale = empty($arrSale) ? array() : $arrSale->toArray();
		if ( !empty($arrSale) )
		{
			$clsRealtor = new Realtor();
			$arrRealtorInfo = $clsRealtor->getRealtorById($realId);
			$arrSignCity = HouseSign::Instance()->getHouseSignByCityId($arrRealtorInfo->cityId, House::TYPE_ERSHOU, false);
			foreach ( $arrSale as $sale )
			{
				if( !empty($sale['features']) )
				{
					$arrAllTag = explode(',', $sale['features']);
					$arrWithOutAutoTag = array_intersect($arrAllTag, $arrSignCity);
					$arrWithOutAutoTag = array_slice($arrWithOutAutoTag, 0, 3);//截取3个手动标签
					$sum += count($arrWithOutAutoTag);
				}
				unset($arrAllTag);
				unset($arrWithOutAutoTag);
			}
		}   
		return $sum;
	}
	
	/**
	 * 获取指定经纪人名下还可设置的标签数量
	 *
	 * @param int $realId
	 * @return int
	 */
	public function getTagValid($realId)
	{
		//获取经纪人端口数量
		$objRealtorPort = new RealtorPort();
		$objRes = $objRealtorPort->getAccountByRealId($realId);
		if (empty($objRes)) return 0;

		//获取还可设置的标签数量
		$total = $this->getTagTotal($realId);
		$valid = $objRes->saleTags + $objRes->saleTagsExtra - $total;

		return $valid;
	}
	
	/**
	 * 设置房源标签
	 *
	 * @param int $intHouseId
	 * @return bool
	 */
	public function setTag($intHouseId,$Sign){
		if ( ! is_numeric($intHouseId) || $intHouseId <= 0  ) 
		{
			return false;
		}
		$db = $this->getDi()->getShared('esfMaster');
		$param[0] = "saleFeatures"; 
		$values[0] = $Sign;
		$success = $db->update(
				'house_sale',  
				$param,
				$values,
				"houseId=".$intHouseId
		);
		return $success;
	}
    
    /**
     * 获取经纪人当日房源操作数量
     *
     * @param int $intBrokerId 经纪人ID
     * @param int $intActionType 操作类型
     * @param int $intUnitType 房源类型
     * @return int
     */
    public function getSaleRefreshCountCount( $arrHouseId ) 
    {
    	if( empty($arrHouseId) )	return false;
    	
    	$intCount = 0;
    	foreach ($arrHouseId as $val)
    	{
    		$arrCount = self::findFirst("houseId = ".$val);
    		$intCount += $arrCount->saleRefreshCount;
    	}
    	return $intCount;
    }
	
	/**
	 * 根据房源Id更新房源信息
	 *
	 * @param int $intSaleId 单条房源Id
	 * @param array $arrData
	 * @return int|bool
	 */
	public function modifySaleById($intSaleId, $arrData) {
		//总价
		if ( isset($arrData['price']) ) {
			$arrUpdate['price'] = $arrData['price'];
		}
        //刷新时间
        if ( isset($arrData['refreshTime']) ) {
            $arrUpdate['refreshTime'] = $arrData['refreshTime'];
        }
		//单价
		if ( isset($arrData['unit']) ) {
			$arrUpdate['unit'] = $arrData['unit'];
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
		//配套设施
		if ( isset($arrData['facility']) ) {
			$arrUpdate['facility'] = $arrData['facility'];
			$arrUpdate['facility'] = empty($arrUpdate['facility']) ? new Phalcon\Db\RawValue("''") : $arrUpdate['facility'];
		}
		//特色房源
		if ( isset($arrData['sign']) ) {
			$arrUpdate['features'] = $arrData['sign'];
		}
		//高清房源ID
		if( isset($arrData['qualityImgID']) )
		{
			$arrUpdate['qualityImgID'] = $arrData['qualityImgID'];
		}
		
		//根据房源属性添加自动标签
		$arrSignDel = array('');
		$arrSign = empty($arrData['sign']) ? array() : $arrData['sign'];
		$arrSign = is_array($arrSign) ? $arrSign : explode(',', $arrData['sign']);
		$arrAutoSign = array_intersect($arrSign, $GLOBALS['SALE_AUTO_TAG']);//已选自动标签
		$arrSign = array_slice($arrSign, 0, 3);
		$arrFacility = empty($arrData['facility']) ? array() : explode(',', $arrData['facility']);
		if (isset($arrData['lookTime']) && $arrData['lookTime'] == 1) $arrSign[] = $GLOBALS['SALE_AUTO_TAG']['1'];//随时看房
		elseif (isset($arrData['lookTime'])) $arrSignDel[] = $GLOBALS['SALE_AUTO_TAG']['1'];
		if (isset($arrData['orientation']) && $arrData['orientation'] == 2) $arrSign[] = $GLOBALS['SALE_AUTO_TAG']['2'];//南北通透
		elseif (isset($arrData['orientation'])) $arrSignDel[] = $GLOBALS['SALE_AUTO_TAG']['2'];
		if (isset($arrData['orientation']) && $arrData['orientation'] == 4) $arrSign[] = $GLOBALS['SALE_AUTO_TAG']['3'];//双朝南
		elseif (isset($arrData['orientation'])) $arrSignDel[] = $GLOBALS['SALE_AUTO_TAG']['3'];
		if (isset($arrData['propertyType']) && $arrData['propertyType'] == 5) $arrSign[] = $GLOBALS['SALE_AUTO_TAG']['4'];//商住两用
		elseif (isset($arrData['propertyType'])) $arrSignDel[] = $GLOBALS['SALE_AUTO_TAG']['4'];
		if (isset($arrData['bedRoom']) && $arrData['bedRoom'] == 99) $arrSign[] = $GLOBALS['SALE_AUTO_TAG']['5'];//复式
		elseif (isset($arrData['bedRoom'])) $arrSignDel[] = $GLOBALS['SALE_AUTO_TAG']['5'];
		if (in_array('5', $arrFacility)) $arrSign[] = $GLOBALS['SALE_AUTO_TAG']['6'];//地下室
		elseif (isset($arrData['facility'])) $arrSignDel[] = $GLOBALS['SALE_AUTO_TAG']['6'];
		if (in_array('6', $arrFacility)) $arrSign[] = $GLOBALS['SALE_AUTO_TAG']['7'];//带花园
		elseif (isset($arrData['facility'])) $arrSignDel[] = $GLOBALS['SALE_AUTO_TAG']['7'];
		if (in_array('4', $arrFacility)) $arrSign[] = $GLOBALS['SALE_AUTO_TAG']['8'];//有车位
		elseif (isset($arrData['facility'])) $arrSignDel[] = $GLOBALS['SALE_AUTO_TAG']['8'];
		if (isset($arrData['houseType']) && $arrData['houseType'] == House::TYPE_ERSHOU && isset($arrData['buildYear']) && $arrData['buildYear'] >= date('Y', time()) - 5 && $arrData['buildYear'] <= date('Y', time()) - 1) $arrSign[] = $GLOBALS['SALE_AUTO_TAG']['10'];//次新房（新房无此标签）
		elseif (isset($arrData['buildYear'])) $arrSignDel[] = $GLOBALS['SALE_AUTO_TAG']['10'];
		$arrSign = array_unique(array_diff($arrSign, $arrSignDel));//数组去重去空
		$arrUpdate['features'] = trim(implode(',', $arrSign+$arrAutoSign), ',');
		if (isset($arrData['sign']) && empty($arrUpdate['features'])) $arrUpdate['features'] = new Phalcon\Db\RawValue("''");//用于清空房源手动标签
		unset($arrSign);
		unset($arrFacility);

		$objSaleUpdate = self::findfirst("houseId = ".$intSaleId);
		if( empty($objSaleUpdate) )	return false;
		return $objSaleUpdate->update($arrUpdate);
	}
	
	/**
	 * 根据房源ID修改房源
	 *
	 * @param int $intUnitId
	 * @param array $arrData
	 * @return bool|int
	 */
	public function modifyUnitById($intUnitId, $arrData) {
		return $this->modifySaleById($intUnitId, $arrData);
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
			//更新Sale表房源刷新数量
			$objSale = self::findFirst("houseId = {$intHouseId['houseId']}");
			$objSale->refreshCount = $objSale ? (int)$objSale->saleRefreshCount + 1 : 0;
			$objSale->refreshTime = date('Y-m-d H:i:s', time());
			$intFlag = $objSale->update();
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
			$intFlag = $objES->update(array('id'=> $intHouseId['houseId'],'houseId'=> $intHouseId['houseId'],'data'=>array('houseRefreshTime'=> time())));
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
		
		//高清房源ID
		if( isset($arrData['qualityImgID']) )
		{
			$arrInsert['qualityImgID'] = $arrData['qualityImgID'];
		}
		//房源单价
		if( isset($arrData['unit']) )
		{
			$arrInsert['unit'] = $arrData['unit'];
		}
		//房源售价
		if( isset($arrData['price']) )
		{
			$arrInsert['price'] = $arrData['price'];
		}
		//房源ID
		if( isset($arrData['houseId']) )
		{
			$arrInsert['houseId'] = stripslashes($arrData['houseId']);
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
		//配套设施
		if ( isset($arrData['facility']) )
		{
			$arrInsert['facility'] = $arrData['facility'];
		}
		//特色房源
		if ( isset($arrData['sign']) ) {
			$arrInsert['features'] = is_array($arrData['sign']) ? implode(',', $arrData['sign']) : $arrData['sign'];
		}
		//刷新时间
		if( isset($arrData['refreshTime']) )
		{
			$arrInsert['refreshTime'] = $arrData['refreshTime'];
		}
		
		//根据房源属性添加自动标签
		$arrSign = empty($arrData['sign']) ? array() : $arrData['sign'];
		$arrSign = is_array($arrSign) ? $arrSign : explode(',', $arrSign);
		$arrSign = array_slice($arrSign, 0, 3);
		$arrFacility = empty($arrData['facility']) ? array() : explode(',', $arrData['facility']);
		if (isset($arrData['lookTime']) && $arrData['lookTime'] == 1) $arrSign[] = $GLOBALS['SALE_AUTO_TAG']['1'];//随时看房
		if (isset($arrData['orientation']) && $arrData['orientation'] == 2) $arrSign[] = $GLOBALS['SALE_AUTO_TAG']['2'];//南北通透
		if (isset($arrData['orientation']) && $arrData['orientation'] == 4) $arrSign[] = $GLOBALS['SALE_AUTO_TAG']['3'];//双朝南
		if (isset($arrData['propertyType']) && $arrData['propertyType'] == 5) $arrSign[] = $GLOBALS['SALE_AUTO_TAG']['4'];//商住两用
		if (isset($arrData['bedRoom']) && $arrData['bedRoom'] == 99) $arrSign[] = $GLOBALS['SALE_AUTO_TAG']['5'];//复式
		if (in_array('5', $arrFacility)) $arrSign[] = $GLOBALS['SALE_AUTO_TAG']['6'];//地下室
		if (in_array('6', $arrFacility)) $arrSign[] = $GLOBALS['SALE_AUTO_TAG']['7'];//带花园
		if (in_array('4', $arrFacility)) $arrSign[] = $GLOBALS['SALE_AUTO_TAG']['8'];//有车位
		if (isset($arrData['houseType']) && $arrData['houseType'] == House::TYPE_ERSHOU && isset($arrData['buildYear']) && $arrData['buildYear'] >= date('Y', time()) - 5 && $arrData['buildYear'] <= date('Y', time()) - 1) $arrSign[] = $GLOBALS['SALE_AUTO_TAG']['10'];//次新房（新房无此标签）
		$arrInsert['features'] = trim(implode(',', $arrSign), ',');
		unset($arrSign);
		unset($arrFacility);

		return self::create($arrInsert);
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
            //更新Sale表房源刷新数量
            $objSale = self::findFirst("houseId = {$intHouseId['id']}");
            $objSale->refreshCount = (int)$objSale->saleRefreshCount + 1;
            $objSale->refreshTime = date('Y-m-d H:i:s', time());
            $intFlag = $objSale->update();
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
            $intFlag = $objRefreshLog->addLog($arrdata);
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
		$intNum = intval($objRes->saleRelease);
		//构建查询条件
		$strCondition = "h.realId='".$intRealtorId."'";
		$strCondition .= " AND h.status = ".House::STATUS_ONLINE;
		$strCondition .= " AND h.roleType=".House::ROLE_REALTOR;
		$arrUnit = Sale::query()
			->columns("h.id")
			->where($strCondition)
			->leftJoin('House', 'h.id = Sale.houseId', 'h')
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
		$intNum = intval($objRes->saleBold);
		//构建查询条件
		$strCondition = "h.realId='".$intRealtorId."'";
		$strCondition .= " AND h.status = ".House::STATUS_ONLINE;
		$strCondition .= " AND h.roleType=".House::ROLE_REALTOR;
		$strCondition .= " AND h.fine=".House::FINE_YES;
		$arrUnit = Sale::query()
			->columns("h.id")
			->where($strCondition)
			->leftJoin('House', 'h.id = Sale.houseId', 'h')
			->execute();
		$arrUnit = empty($arrUnit) ? array() : $arrUnit->toArray();
		$intUse = count($arrUnit);
		$intReturn = $intNum-$intUse;
		if($intReturn<0) $intReturn=0;
		return $intReturn;
	}
	
	/**
	 * @abstract 根据相关条件获取sale信息
	 * @author Eric xuminwan@sohu-inc.com
	 * @param string $strCondition
	 * @param string $columns
	 * @param string $order
	 * @param int $pageSize
	 * @param int $offset
	 *
	 */
	public function getSaleByCondition($strCondition, $columns = '', $order = '', $pageSize = 0, $offset = 0)
	{
		if(!$strCondition) return array();
		$arrCon = array();
		$arrCon['conditions'] = $strCondition;
		if($columns) $arrCon['columns'] = $columns;
		if($pageSize > 0) $arrCon['limit'] = array('number'=>$pageSize, 'offset'=>$offset);
		if($order) $arrCon['order'] = $order;
		$arrSale = self::find($arrCon,0)->toArray();
		return $arrSale;
	}

    /**
     * 实例化
     * @param type $cache
     * @return Sale_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
}
