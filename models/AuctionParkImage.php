<?php

class AuctionParkImage extends BaseModel
{
    public $id;
    public $parkId;
    public $realId;
    public $imgId;
    public $imgExt;
    public $status;
    public $reason;
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
            'imgId' => 'imgId',
            'imgExt' => 'imgExt',
            'apStatus' => 'status',
            'apReason' => 'reason',
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
