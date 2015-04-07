<?php
/**
 * @abstract  竞拍订单表
 * @copyright Sohu-inc Team.
 * @author    Tony (tonyzhao@sohu-inc.com)
 * @date      2015-01-21 14:12:18
 */

class AuctionOrders extends BaseModel {
    
    //是否需要发票
    const INVLICE_YES = 1;   //是
    const INVLICE_NO  = 0;   //否
    
    //状态
    const STATUS_WAIT    = 1;  //待付款
    const STATUS_SUCCESS = 2;  //付款成功
    const STATUS_CANCEL  = 3;  //取消
    
	public $id;
    public $orderId;
    public $cityId;
	public $realId;
	public $parkId;
	public $parkName;
	public $money;
    public $payMoney;
    public $payPoint;
    public $isInvlice;
    public $invlice;
    public $status;
    public $desc;
    public $month;
    public $startTime;
    public $endTime;
    public $payTime;
    public $orderTime;

	public function columnMap()
    {
        return array(
            'aoId'        => 'id',
            'aoOrderId'   => 'orderId',
            'cityId'      => 'cityId',
            'realId'      => 'realId',
            'parkId'      => 'parkId',
            'parkName'    => 'parkName',
            'aoMoney'     => 'money',
            'aoPayMoney'  => 'payMoney',
            'aoPayPoint'  => 'payPoint',
            'aoIsInvlice' => 'isInvlice',
            'aoInvlice'   => 'invlice',
            'aoStatus'    => 'status',
            'aoDesc'      => 'desc',
            'aoMonth'     => 'month',
            'aoStartTime' => 'startTime',
            'aoEndTime'   => 'endTime',
            'aoPayTime'   => 'payTime',
            'aoOrderTime' => 'orderTime'
        );
    }

    public function initialize ()
    {
        $this->setConn('esf');
    }
    
    public function getSource ()
    {
        return 'auction_orders';
    }
    
    /**
     * 单例对象
     * @return type
     */
    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__,$cache);
    }
    
    /**
     * 获取支付状态
     * @param int $status
     * @return array|string
     */
    public static function getStatus($status = 0)
    {
        $statuses = array(
            self::STATUS_WAIT    => '支付中',
            self::STATUS_SUCCESS => '已支付',
            self::STATUS_CANCEL  => '已关闭'
        );
        
        return $status == 0 ? $statuses : $statuses[$status];
    }
    
    /**
     * 修改订单
     * @param int $id
     * @param array $params
     * @return array
     */
    public function editOrder($id, $data)
    {
        $id = intval($id);
        $order = self::findFirst($id);
        if(!$order)
        {
            return array('status'=>1, 'info'=>'订单不存在');
        }
        $this->begin();
        $order->desc = $data['desc'];
        $order->isInvlice = self::INVLICE_YES == $data['isInvlice'] ? self::INVLICE_YES : self::INVLICE_NO;
        if(!$order->update())
        {
            $this->rollback();
            return array('status'=>1);
        }
        //修改发票信息表 realtor_invoice
        $invoice = RealtorInvoice::findFirst("realId={$data['realId']}");
        $invoiceData = array(
            'cityId'     => intval($data['cityId']),
            'distId'     => intval($data['distId']),
            'head'       => RealtorInvoice::HEAD_COMPANY == $data['head'] ? RealtorInvoice::HEAD_COMPANY : RealtorInvoice::HEAD_PERSON,
            'cityStr'    => $data['cityName'].$data['distName'],
            'address'    => $data['address'],
            'updateTime' => date('Y-m-d H:i:s')
        );
        if(RealtorInvoice::HEAD_COMPANY == $data['head'])
        {
            $invoiceData['headName'] = $data['headName'];
        }
        if($invoice)
        {
            //已存在，则修改                
            if(!$invoice->update($invoiceData))
            {
                $this->rollback();
                return array('status'=>1);
            }
        }
        else
        {
            //不存在，则添加
            $invoice = RealtorInvoice::instance();
            
            $invoiceData['realId'] = $data['realId'];
            if(!$invoice->create($invoiceData))
            {
                $this->rollback();
                return array('status'=>1);
            }
        }
        
        $this->commit();
        return array('status'=>0);
    }
}

?>

