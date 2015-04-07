<?php
/**
 * @abstract  保证金支付表
 * @copyright Sohu-inc Team.
 * @author    Tony (tonyzhao@sohu-inc.com)
 * @date      2015-01-21 14:12:18
 */

class AuctionDeposit extends BaseModel {
    
    //类型
    const TYPE_FROZEN   = 1;   //冻结中
    const TYPE_UNFREEZE = 2;   //已解冻
    const TYPE_DEDUCT   = 3;   //已扣除
    
	public $id;
    public $realId;
	public $parkId;
	public $payAmount;
	public $payType;
    public $payTime;
    public $month;

	public function columnMap()
    {
        return array(
            'adId'        => 'id',
            'realId'      => 'realId',
            'parkId'      => 'parkId',
            'adPayAmount' => 'payAmount',
            'adPayType'   => 'payType',
            'adPayTime'   => 'payTime',
            'adMonth'     => 'month'
        );
    }

    public function initialize ()
    {
        $this->setConn('esf');
    }
    
    public function getSource ()
    {
        return 'auction_deposit';
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
     * 获取状态
     * @param int $status
     * @return array|string
     */
    public static function getStatus($status = 0)
    {
        $statuses = array(
            self::TYPE_FROZEN   => '冻结中',
            self::TYPE_UNFREEZE => '已解冻',
            self::TYPE_DEDUCT   => '已扣除'
        );
        
        return $status > 0 ? $statuses[$status] : $statuses;
    }
}

?>

