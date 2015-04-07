<?php

class ZebCity extends  BaseModel
{

    /**
     *
     * @var integer
     */
    public $id;
    public $cityId;
    public $info;
    public $date;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'zcId' => 'id',
            'cityId' => 'cityId', 
            'zcInfo' => 'info',
            'zcDate' => 'date'
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
