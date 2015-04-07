<?php

class AuctionParkOplog extends BaseModel
{
    public $id;
    public $parkId;
    public $opId;
    public $opValue;
    public $time;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'alId' => 'id',
            'parkId' => 'parkId',
            'alOpId' => 'opId',
            'alOpValue' => 'opValue',
            'alTime' => 'time',
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

}
