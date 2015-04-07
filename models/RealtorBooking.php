<?php

class RealtorBooking extends BaseModel
{
    protected $id;
    protected $realId;
    protected $comId;
    protected $orderId;
    protected $portId;
    protected $saleRelease;
    protected $saleRefresh;
    protected $saleBold;
    protected $saleTags;
    protected $rentRelease;
    protected $rentRefresh;
    protected $rentBold;
    protected $rentTags;
    protected $startDate;
    protected $expiryDate;
    protected $status;
    protected $updateTime;
    protected $salesId = 0;
    protected $CSId = 0;
    
    //状态
    const STATUS_DISABLED  = 0;  //失效
    const STATUS_ENABLED   = 1;  //有效
    const STATUS_COMPLETED = 3;  //完成
    const STATUS_DELETE    = -1; //删除
    
    public function setRbid($rbId)
    {
        $this->id = $rbId;
    }

    public function setRealid($realId)
    {
        $this->realId = $realId;
    }

    public function setComid($comId)
    {
        $this->comId = $comId;
    }

    public function setOrderid($orderId)
    {
        $this->orderId = $orderId;
    }

    public function setPortid($portId)
    {
        $this->portId = $portId;
    }

    public function setRbsalerelease($rbSaleRelease)
    {
        $this->saleRelease = $rbSaleRelease;
    }

    public function setRbsalerefresh($rbSaleRefresh)
    {
        $this->saleRefresh = $rbSaleRefresh;
    }

    public function setRbsalebold($rbSaleBold)
    {
        $this->saleBold = $rbSaleBold;
    }

    public function setRbsaletags($rbSaleTags)
    {
        $this->saleTags = $rbSaleTags;
    }

    public function setRbrentrelease($rbRentRelease)
    {
        $this->rentRelease = $rbRentRelease;
    }

    public function setRbrentrefresh($rbRentRefresh)
    {
        $this->rentRefresh = $rbRentRefresh;
    }

    public function setRbrentbold($rbRentBold)
    {
        $this->rentBold = $rbRentBold;
    }

    public function setRbrenttags($rbRentTags)
    {
        $this->rentTags = $rbRentTags;
    }

    public function setRbstartdate($rbStartDate)
    {
        $this->startDate = $rbStartDate;
    }

    public function setRbexpirydate($rbExpiryDate)
    {
        $this->expiryDate = $rbExpiryDate;
    }

    public function setRbstatus($rbStatus)
    {
        $this->status = $rbStatus;
    }

    public function setRbupdate($rbUpdate)
    {
        $this->updateTime = $rbUpdate;
    }

    public function setRbsalesid($rbSalesId)
    {
        $this->salesId = $rbSalesId;
    }

    public function setRbcsid($rbCSId)
    {
        $this->CSId = $rbCSId;
    }

    public function getRbid()
    {
        return $this->id;
    }

    public function getRealid()
    {
        return $this->realId;
    }

    public function getComid()
    {
        return $this->comId;
    }

    public function getOrderid()
    {
        return $this->orderId;
    }

    public function getPortid()
    {
        return $this->portId;
    }

    public function getRbsalerelease()
    {
        return $this->saleRelease;
    }

    public function getRbsalerefresh()
    {
        return $this->saleRefresh;
    }

    public function getRbsalebold()
    {
        return $this->saleBold;
    }

    public function getRbsaletags()
    {
        return $this->saleTags;
    }

    public function getRbrentrelease()
    {
        return $this->rentRelease;
    }

    public function getRbrentrefresh()
    {
        return $this->rentRefresh;
    }

    public function getRbrentbold()
    {
        return $this->rentBold;
    }

    public function getRbrenttags()
    {
        return $this->rentTags;
    }

    public function getRbstartdate()
    {
        return $this->startDate;
    }

    public function getRbexpirydate()
    {
        return $this->expiryDate;
    }

    public function getRbstatus()
    {
        return $this->status;
    }

    public function getRbupdate()
    {
        return $this->updateTime;
    }

    public function getRbsalesid()
    {
        return $this->salesId;
    }

    public function getRbcsid()
    {
        return $this->CSId;
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'rbId'          => 'id', 
            'realId'        => 'realId', 
            'comId'         => 'comId', 
            'orderId'       => 'orderId', 
            'portId'        => 'portId', 
            'rbSaleRelease' => 'saleRelease', 
            'rbSaleRefresh' => 'saleRefresh', 
            'rbSaleBold'    => 'saleBold', 
            'rbSaleTags'    => 'saleTags', 
            'rbRentRelease' => 'rentRelease', 
            'rbRentRefresh' => 'rentRefresh', 
            'rbRentBold'    => 'rentBold', 
            'rbRentTags'    => 'rentTags', 
            'rbStartDate'   => 'startDate', 
            'rbExpiryDate'  => 'expiryDate', 
            'rbStatus'      => 'status', 
            'rbUpdate'      => 'updateTime', 
            'rbSalesId'     => 'salesId', 
            'rbCSId'        => 'CSId'
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
     * @return RealtorBooking_Model
     */
    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
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
                    $arrRport[$id]['salePortNum'] = $port['type'] == 'sale' ? $port['equivalent'] : 0;
                    $arrRport[$id]['rentPortNum'] = $port['type'] == 'rent' ? $port['equivalent'] : 0;
                }                  
            }
        }
        
		return $arrRport;
	}
}
