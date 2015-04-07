<?php

class OperationPersonLog extends BaseModel
{

    protected $id;
    protected $houseId;
    protected $phone;
    protected $type;
    protected $cityId;
    protected $createTime;

    public function setPlid($plId)
    {
        $this->id = $plId;
        return $this;
    }
    public function setHouseid($houseId)
    {
        $this->houseId = $houseId;
        return $this;
    }
    public function setPlphone($plPhone)
    {
        $this->phone = $plPhone;
        return $this;
    }
    public function setPltype($plType)
    {
        $this->type = $plType;
        return $this;
    }

    public function setCityid($cityId)
    {
        $this->cityId = $cityId;
        return $this;
    }
    public function setPlcreatetime($plCreateTime)
    {
        $this->createTime = $plCreateTime;
        return $this;
    }

    public function getPlid()
    {
        return $this->id;
    }

    public function getHouseid()
    {
        return $this->houseId;
    }

    public function getPlphone()
    {
        return $this->phone;
    }

    public function getPltype()
    {
        return $this->type;
    }

    public function getCityid()
    {
        return $this->cityId;
    }

    public function getPlcreatetime()
    {
        return $this->createTime;
    }

    public function columnMap()
    {
        return array(
            'plId' => 'id',
            'houseId' => 'houseId', 
            'plPhone' => 'phone',
            'plType' => 'type',
            'cityId' => 'cityId', 
            'plCreateTime' => 'createTime'
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
        return new self();
    }

}
