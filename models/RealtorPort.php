<?php

class RealtorPort extends BaseModel
{
    public $id;
    public $realId;
    public $shopId;
    public $areaId;
    public $comId;
    public $cityId;
    public $orderId;
    public $portId;
    public $num = 1;
    public $saleRelease;
    public $saleRefresh;
    public $saleBold;
    public $saleTags;
    public $saleTagsExtra = 0;
    public $rentRelease;
    public $rentRefresh;
    public $rentBold;
    public $rentTags;
    public $rentTagsExtra = 0;
    public $startDate;
    public $expiryDate;
    public $status;
    public $updateTime;
    public $salesId = 0;
    public $CSId = 0;
    public $remark = '';
    
    //订单状态
    const STATUS_DISABLED  = 0;  //失效
    const STATUS_ENABLED   = 1;  //有效
    const STATUS_COMPLETED = 3;  //完成
    const STATUS_DELETE    = -1; //删除

    public function setRpid($rpId)
    {
        $this->id = $rpId;
    }

    public function setRealid($realId)
    {
        $this->realId = $realId;
    }

    public function setShopid($shopId)
    {
        $this->shopId = $shopId;
    }

    public function setAreaid($areaId)
    {
        $this->areaId = $areaId;
    }

    public function setComid($comId)
    {
        $this->comId = $comId;
    }

    public function setCityid($cityId)
    {
        $this->cityId = $cityId;
    }

    public function setOrderid($orderId)
    {
        $this->orderId = $orderId;
    }

    public function setPortid($portId)
    {
        $this->portId = $portId;
    }

    public function setRpnum($num)
    {
        $this->num = $num;
    }

    public function setRpsalerelease($rpSaleRelease)
    {
        $this->saleRelease = $rpSaleRelease;
    }

    public function setRpsalerefresh($rpSaleRefresh)
    {
        $this->saleRefresh = $rpSaleRefresh;
    }

    public function setRpsalebold($rpSaleBold)
    {
        $this->saleBold = $rpSaleBold;
    }

    public function setRpsaletags($rpSaleTags)
    {
        $this->saleTags = $rpSaleTags;
    }

    public function setRpsaletagsextra($rpSaleTagsExtra)
    {
        $this->saleTagsExtra = $rpSaleTagsExtra;
    }

    public function setRprentrelease($rpRentRelease)
    {
        $this->rentRelease = $rpRentRelease;
    }

    public function setRprentrefresh($rpRentRefresh)
    {
        $this->rentRefresh = $rpRentRefresh;
    }

    public function setRprentbold($rpRentBold)
    {
        $this->rentBold = $rpRentBold;
    }

    public function setRprenttags($rpRentTags)
    {
        $this->rentTags = $rpRentTags;
    }

    public function setRprenttagsextra($rpRentTagsExtra)
    {
        $this->rentTagsExtra = $rpRentTagsExtra;
    }

    public function setRpstartdate($rpStartDate)
    {
        $this->startDate = $rpStartDate;
    }

    public function setRpexpirydate($rpExpiryDate)
    {
        $this->expiryDate = $rpExpiryDate;
    }

    public function setRpstatus($rpStatus)
    {
        $this->status = $rpStatus;
    }

    public function setRpupdate($rpUpdate)
    {
        $this->updateTime = $rpUpdate;
    }

    public function setRpsalesid($rpSalesId)
    {
        $this->salesId = $rpSalesId;
    }

    public function setRpcsid($rpCSId)
    {
        $this->CSId = $rpCSId;
    }

    public function setRpremark($rpRemark)
    {
        $this->remark = $rpRemark;
    }

    public function getRpid()
    {
        return $this->id;
    }

    public function getRealid()
    {
        return $this->realId;
    }

    public function getShopid()
    {
        return $this->shopId;
    }

    public function getAreaid()
    {
        return $this->areaId;
    }

    public function getComid()
    {
        return $this->comId;
    }

    public function getCityid()
    {
        return $this->cityId;
    }

    public function getOrderid()
    {
        return $this->orderId;
    }

    public function getPortid()
    {
        return $this->portId;
    }

    public function getRpnum()
    {
        return $this->num;
    }

    public function getRpsalerelease()
    {
        return $this->saleRelease;
    }

    public function getRpsalerefresh()
    {
        return $this->saleRefresh;
    }

    public function getRpsalebold()
    {
        return $this->saleBold;
    }

    public function getRpsaletags()
    {
        return $this->saleTags;
    }

    public function getRpsaletagsextra()
    {
        return $this->saleTagsExtra;
    }

    public function getRprentrelease()
    {
        return $this->rentRelease;
    }

    public function getRprentrefresh()
    {
        return $this->rentRefresh;
    }

    public function getRprentbold()
    {
        return $this->rentBold;
    }

    public function getRprenttags()
    {
        return $this->rentTags;
    }

    public function getRprenttagsextra()
    {
        return $this->rentTagsExtra;
    }

    public function getRpstartdate()
    {
        return $this->startDate;
    }

    public function getRpexpirydate()
    {
        return $this->expiryDate;
    }

    public function getRpstatus()
    {
        return $this->status;
    }

    public function getRpupdate()
    {
        return $this->updateTime;
    }

    public function getRpsalesid()
    {
        return $this->salesId;
    }

    public function getRpcsid()
    {
        return $this->CSId;
    }

    public function getRpremark()
    {
        return $this->remark;
    }

    public function getSource()
    {
        return 'realtor_port';
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'rpId'          => 'id', 
            'realId'        => 'realId', 
            'shopId'        => 'shopId', 
            'areaId'        => 'areaId', 
            'comId'         => 'comId', 
            'cityId'        => 'cityId', 
            'orderId'       => 'orderId', 
            'portId'        => 'portId', 
            'rpNum'         => 'num', 
            'rpSaleRelease' => 'saleRelease',
            'rpSaleRefresh' => 'saleRefresh',
            'rpSaleBold'    => 'saleBold',
            'rpSaleTags'    => 'saleTags',
            'rpSaleTagsExtra' => 'saleTagsExtra',
            'rpRentRelease' => 'rentRelease',
            'rpRentRefresh' => 'rentRefresh',
            'rpRentBold'    => 'rentBold',
            'rpRentTags'    => 'rentTags',
            'rpRentTagsExtra' => 'rentTagsExtra',
            'rpStartDate'   => 'startDate', 
            'rpExpiryDate'  => 'expiryDate', 
            'rpStatus'      => 'status', 
            'rpUpdate'      => 'updateTime', 
            'rpSalesId'     => 'salesId', 
            'rpCSId'        => 'CSId', 
            'rpRemark'      => 'remark'
        );
    }
    
    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }

    /**
     * 实例化
     * @param type $cache
     * @return RealtorPort_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
    
	/**
	 * 根据分配对象类型和分配对象编号获取二手房出售和出租发布、刷新、推荐、标签的总量
	 *
     * @param int $realId
	 * @return object
	 */
	public function getAccountByRealId($realId) {
		if ( empty($realId)) {
			return false;
		}
		$arrCond  = "realId = ?1 and status = ?2";
		$arrParam = array(1 => $realId, 2 => self::STATUS_ENABLED);
		$arrRes   = self::findFirst(array(
			$arrCond,
			"bind" => $arrParam
		));
		return $arrRes;
	}

    /**
     * 更新经纪人出售/出租 可发布数量
     *
     * @param object $objRealtor
     * @param int $intCost
     * @return int|bool
     */
    public function upRealtorPublicPortNum($realId,$createNum,$strActtype='online',$strUnitType='sale') {
        if ( empty($realId)) {
            return false;
        }
        $arrCond  = "realId = ?1";
        $arrParam = array(1 => $realId);
        $arrRes   = self::findFirst(array(
            $arrCond,
            "bind" => $arrParam
        ));
        $arrUpdate = array();
        if($strUnitType == 'sale')
        {
            if($strActtype == 'online')
            {
                $arrUpdate['saleRelease'] = $arrRes->saleRelease - $createNum;
            }
            else
            {
                $arrUpdate['saleRelease'] = $arrRes->saleRelease + $createNum;
            }
        }
        else
        {
            if($strActtype == 'online')
            {
                $arrUpdate['rentRelease'] = $arrRes->rentRelease - $createNum;
            }
            else
            {
                $arrUpdate['rentRelease'] = $arrRes->rentRelease + $createNum;
            }

        }
        return $arrRes->update($arrUpdate);
    }
	
	/**
	 * 扣除经纪人出租特色房源权限
	 *
	 * @param object $objRealtor
	 * @param int $intCost
	 * @return int|bool
	 */
	public function decRentTag($objRealtor, $intCost = 1) {
		$objUpdate = self::findFirst("realId = ".$objRealtor->id." AND status=".self::STATUS_ENABLED);
		return $objUpdate->update(array('rentTagsExtra' => $objUpdate->rentTagsExtra < $intCost ? 0 : $objUpdate->rentTagsExtra - $intCost));
	}

    
    /**
     * 根据门店ID获得已经启用端口数(支持批量)
     * @param array $arrId  array（id1，id2）
     * @return array array(
     * 						id1 = 端口数
     * 					)
     */
    public function getOpenPortByIdS($arrId){
    	if( empty($arrId) || !is_array($arrId) ){
    		$this->setError('传参错误');
    		return false;
    	}
    	$arrReturn = array();
        $objPortCity = new PortCity();
        
        foreach($arrId as $value)
        {
        	try 
        	{
        		$num = 0;
        		$arrPort = self::getAll("shopId = $value and status=".self::STATUS_ENABLED." group by portId", '', '', '', ' portId, count(realId) as snum');
        		foreach($arrPort as $val)
        		{
        			$arrPortCity = $objPortCity->getOne(" id = ".$val['portId']);
        			$num = $num+$val['snum']*$arrPortCity['equivalent'];
        		}
        		$arrReturn[$value] = $num;
        		unset($num);
        	}
        	catch(Exception $e)
        	{
        		
        	}
        }
    	return $arrReturn;
    }
    
    /**
     * @abstract 批量获取经纪人端口
     * @param array|int  $realIds 
     * @param string     $columns
     * @param boolean    $needNum 是否需要返回端口数
     * @return array
     * 
     */
	public function getPortByRealId($realIds, $columns = '', $needNum = true)
	{
		if(empty($realIds)) 
            return array();
		if(is_array($realIds))
		{
			$arrBind = $this->bindManyParams($realIds);
			$arrCond = "realId in({$arrBind['cond']}) and status=".self::STATUS_ENABLED;
			$arrParam = $arrBind['param'];
            $condition = array(
					$arrCond,
					"bind" => $arrParam,
			);            
		}
		else
		{
            $condition = array(
                'conditions' => "realId={$realIds} and status=".self::STATUS_ENABLED
            );
		}
        $columns && $condition['columns'] = $columns;
        $arrPort  = self::find($condition, 0)->toArray();
		$arrRport = $portIds = array();
		foreach($arrPort as $value)
		{
			$arrRport[$value['realId']] = $value;
            ($value['portId'] && !in_array($value['portId'], $portIds)) && $portIds[] = $value['portId'];
		}
        
        //获取端口数量
        if($needNum && !empty($arrRport))
        {
            if(false === strpos($columns, 'num') && $columns)
            {
                return $arrRport;
            }
            $portInfo = PortCity::instance()->getPortByIds($portIds, 'id,type,equivalent');
            foreach($portInfo as &$v)
            {
                if(PortCity::STATUS_Sale == $v['type'])
                    $v['type'] = 'sale';
                elseif(PortCity::STATUS_Rent == $v['type'])
                    $v['type'] = 'rent';
                else
                    $v['type'] = 'both';
            }
            unset($v);

            foreach($arrRport as $id=>$v)
            {
                
                if(!empty($portInfo[$v['portId']]))
                {
                    $port = $portInfo[$v['portId']];
                    $arrRport[$id]['salePortNum'] = $port['type'] == 'sale' ? $port['equivalent'] * $v['num'] : 0;
                    $arrRport[$id]['rentPortNum'] = $port['type'] == 'rent' ? $port['equivalent'] * $v['num'] : 0;
                }    
            }
        }
        
		return $arrRport;
	}
    
    /**
     * 批量延续经纪人
     * @param array  $realIds
     * @param string $date
     * @return boolean
     */
    public function delayPort($realIds, $date)
    {
        if(empty($realIds) || !$date)
        {
            return false;
        }
        $id = implode(',', $realIds);
        $ports = self::find("realId in ({$id}) and status=".self::STATUS_ENABLED);
        if(!$ports)
        {
            return false;
        }
        foreach($ports as $rs)
        {
            $rs->expiryDate = $date;
            $rs->updateTime = date('Y-m-d H:i:s');
            if(!$rs->update())
            {
                return false;
            }
        }
        
        return true;
    }
   
}
