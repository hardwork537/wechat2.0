<?php

class Orders extends BaseModel {

    protected $id;
    protected $to;
    protected $cityId;
    protected $comId;
    protected $areaId;
    protected $shopId;
    protected $realId = 0;
    protected $contract = '';
    protected $signingDate;
    protected $startDate;
    protected $expiryDate;
    protected $amount;
    protected $remark = '';
    protected $status = 1;
    protected $updateTime;
    protected $salesId = 0;
    protected $csId = 0;

    //订单对象
    const TO_COMPANY = 1;   //公司
    const TO_AREA = 3;   //区域
    const TO_SHOP = 5;   //门店
    const TO_REALTOR = 7;   //个人
    //订单状态
    const STATUS_DISABLED = 0;  //失效
    const STATUS_ENABLED = 1;  //有效
    const STATUS_COMPLETED = 3;  //完成
    const STATUS_DELETE = -1; //删除

    public function getOrderId() {
        return $this->orderId;
    }

    public function setOrderId($orderId) {
        if (preg_match('/^\d{1,10}$/', $orderId == 0) || $orderId > 4294967295) {
            return false;
        }
        $this->orderId = $orderId;
    }

    public function getCityId() {
        return $this->cityId;
    }

    public function setCityId($cityId) {
        if (preg_match('/^\d{1,10}$/', $cityId == 0) || $cityId > 4294967295) {
            return false;
        }
        $this->cityId = $cityId;
    }

    public function getOrderPA() {
        return $this->orderPA;
    }

    public function setOrderPA($orderPA) {
        if (preg_match('/^\d{1,3}$/', $orderPA == 0) || $orderPA > 255) {
            return false;
        }
        $this->orderPA = $orderPA;
    }

    public function getOrderPAId() {
        return $this->orderPAId;
    }

    public function setOrderPAId($orderPAId) {
        if (preg_match('/^\d{1,10}$/', $orderPAId == 0) || $orderPAId > 4294967295) {
            return false;
        }
        $this->orderPAId = $orderPAId;
    }

    public function getOrderContract() {
        return $this->orderContract;
    }

    public function setOrderContract($orderContract) {
        if ($orderContract == '' || mb_strlen($orderContract, 'utf8') > 50) {
            return false;
        }
        $this->orderContract = $orderContract;
    }

    public function getOrderSigningDate() {
        return $this->orderSigningDate;
    }

    public function setOrderSigningDate($orderSigningDate) {
        $this->orderSigningDate = $orderSigningDate;
    }

    public function getOrderStartDate() {
        return $this->orderStartDate;
    }

    public function setOrderStartDate($orderStartDate) {
        $this->orderStartDate = $orderStartDate;
    }

    public function getOrderExpiryDate() {
        return $this->orderExpiryDate;
    }

    public function setOrderExpiryDate($orderExpiryDate) {
        $this->orderExpiryDate = $orderExpiryDate;
    }

    public function getOrderAmount() {
        return $this->orderAmount;
    }

    public function setOrderAmount($orderAmount) {
        if (preg_match('/^\d{1,10}$/', $orderAmount == 0) || $orderAmount > 4294967295) {
            return false;
        }
        $this->orderAmount = $orderAmount;
    }

    public function getOrderRemark() {
        return $this->orderRemark;
    }

    public function setOrderRemark($orderRemark) {
        if ($orderRemark == '' || mb_strlen($orderRemark, 'utf8') > 250) {
            return false;
        }
        $this->orderRemark = $orderRemark;
    }

    public function getOrderStatus() {
        return $this->orderStatus;
    }

    public function setOrderStatus($orderStatus) {
        if (preg_match('/^-?\d{1,3}$/', $orderStatus) == 0 || $orderStatus > 127 || $orderStatus < -128) {
            return false;
        }
        $this->orderStatus = $orderStatus;
    }

    public function getSource() {
        return 'orders';
    }

    public function columnMap() {
        return array(
            'orderId' => 'id',
            'orderTo' => 'to',
            'cityId' => 'cityId',
            'comId' => 'comId',
            'areaId' => 'areaId',
            'shopId' => 'shopId',
            'realId' => 'realId',
            'orderContract' => 'contract',
            'orderSigningDate' => 'signingDate',
            'orderStartDate' => 'startDate',
            'orderExpiryDate' => 'expiryDate',
            'orderAmount' => 'amount',
            'orderRemark' => 'remark',
            'orderStatus' => 'status',
            'orderUpdate' => 'updateTime',
            'orderSalesId' => 'salesId',
            'orderCSId' => 'csId',
        );
    }

    public function initialize() {
        $this->setConn("esf");
    }

    /**
     * 实例化
     * @param type $cache
     * @return Order_Model
     */
    public static function instance($cache = true) {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }

    public function add($arr) {
        $cityId = intval($arr["cityId"]);
        $to = intval($arr["to"]);
        $accname = $arr["accname"];

        $account = VipAccount::findFirst("to={$to} and name='{$accname}'");
        
        if ($account) {
            $toid = $account->toId;
            if (self::TO_COMPANY == $to) {
                $company = Company::findFirst($toid);
                $comId = $toid;
                $areaId = 0;
                $shopId = 0;
                $realId = 0;
            } else if (self::TO_REALTOR == $to) {
                $realtor = Realtor::findFirst($toid);
                $comId = $realtor->comId ?:0 ;
                $areaId = $realtor->areaId?:0;
                $shopId = $realtor->shopId?:0;
                $realId = $realtor->id;
            }
        } else {
            return false;
        }

        foreach ($arr['contract'] as $k => $ct) {
            $rsimg = OrderImage::instance(false);
            $rs = self::instance(false);
            $rs->to = $to;
            $rs->cityId = $cityId;
            $rs->updateTime = date("Y-m-d H:i:s");
            $rs->comId = $comId;
            $rs->areaId = $areaId;
            $rs->shopId = $shopId;
            $rs->realId = $realId;
            $rs->amount = sprintf(" %.2f", $arr['amount'][$k]);
            $rs->contract = $ct;
            
            if ($rs->save()) {
                $rsimg->add($rs->id, $arr['files']['tmp_name'][$k]);
            } else {
                return false;
            }
        }
        return  true;
    }

    public function edit($id, $arr) {
        $rs = self::findFirst($id);
        $rsimg = OrderImage::instance(false);
        $rs->updateTime = date("Y-m-d H:i:s");
        $rs->amount = sprintf(" %.2f", $arr['amount']);
        $rs->contract = $arr['contract'];

        if ($rs->update()) {
            if ($arr['files']['tmp_name']) {
                return $rsimg->edit($rs->id, $arr['files']['tmp_name']);
            }
            return true;
        } else {
            return false;
        }
    }
    
    public function del($id) {
        $rs = self::findFirst($id);
        $rsimg = OrderImage::instance(false);
        $rs->updateTime = date("Y-m-d H:i:s");
        $rs->status = -1;
        if ($rs->update()) {
            return true;
        } else {
            return false;
        }
    }

}
