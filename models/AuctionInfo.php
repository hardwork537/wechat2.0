<?php

class AuctionInfo extends BaseModel
{


    public $aiId;
    public $realId;
    public $parkId;
    public $aiPrice;
    public $aiCreateTime;
    public $aiCreateMonth;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'aiId' => 'id',
            'realId' => 'realId', 
            'parkId' => 'parkId', 
            'aiPrice' => 'price',
            'aiCreateTime' => 'createTime',
            'aiCreateMonth' => 'createMonth'
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
     * @return \AuctionInfo
     */
    public static function instance ($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self();
    }
}
