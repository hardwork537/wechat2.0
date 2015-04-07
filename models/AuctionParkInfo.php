<?php

class AuctionParkInfo extends BaseModel
{
    public $id;
    public $parkId;
    public $realId;
    public $name;
    public $value;
    public $status;
    public $arUpdate;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'apId' => 'id',
            'parkId' => 'parkId', 
            'realId' => 'realId',
            'apName' => 'name',
            'apValue' => 'value',
            'apStatus' => 'status',
            'apUpdate' => 'apUpdate',
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
