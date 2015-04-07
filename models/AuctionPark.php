<?php

class AuctionPark extends BaseModel
{

    public $apId;
    public $parkId;
    public $apPrice;
    public $apDeposit;
    public $apHot;
    public $apDesc;
    public $apMonth;
    public $apUpdatetime;
    public $apCreatetime;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'apId' => 'id',
            'parkId' => 'parkId', 
            'apPrice' => 'price',
            'apDeposit' => 'deposit',
            'apHot' => 'hot',
            'apDesc' => 'desc',
            'apMonth' => 'month',
            'apUpdatetime' => 'updatetime',
            'apCreatetime' => 'createtime'
        );
    }
    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    /**
     * 实例化对象
     *
     * @param type $cache
     * @return \AuctionPark
     */
    public static function instance ($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self();
    }

}
