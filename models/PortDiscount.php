<?php
class PortDiscount extends BaseModel
{
    protected $id;
    protected $portId;
    protected $cityId;
    protected $comId;
    protected $value;
    protected $price;
    protected $status;
    protected $uate;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if(preg_match('/^\d{1,10}$/', $id == 0) || $id > 4294967295)
        {
            return false;
        }
        $this->id = $id;
    }

    public function getPortId()
    {
        return $this->portId;
    }

    public function setPortId($portId)
    {
        if(preg_match('/^\d{1,10}$/', $portId == 0) || $portId > 4294967295)
        {
            return false;
        }
        $this->portId = $portId;
    }

    public function getCityId()
    {
        return $this->cityId;
    }

    public function setCityId($cityId)
    {
        if(preg_match('/^\d{1,10}$/', $cityId == 0) || $cityId > 4294967295)
        {
            return false;
        }
        $this->cityId = $cityId;
    }

    public function getComId()
    {
        return $this->comId;
    }

    public function setComId($comId)
    {
        if(preg_match('/^\d{1,10}$/', $comId == 0) || $comId > 4294967295)
        {
            return false;
        }
        $this->comId = $comId;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        if(preg_match('/^\d{1,3}$/', $value == 0) || $value > 255)
        {
            return false;
        }
        $this->value = $value;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        if(preg_match('/^\d{1,10}$/', $price == 0) || $price > 4294967295)
        {
            return false;
        }
        $this->price = $price;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        if(preg_match('/^-?\d{1,3}$/', $status) == 0 || $status > 127 || $status < -128)
        {
            return false;
        }
        $this->status = $status;
    }

    public function getUate()
    {
        return $this->uate;
    }

    public function setUate($uate)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $uate) == 0 || strtotime($uate) == false)
        {
            return false;
        }
        $this->uate = $uate;
    }

    public function getSource()
    {
        return 'port_discount';
    }

    public function columnMap()
    {
        return array(
            'pdId' => 'id',
            'portId' => 'portId',
            'cityId' => 'cityId',
            'comId' => 'comId',
            'pdValue' => 'value',
            'pdPrice' => 'price',
            'pdStatus' => 'status',
            'pdUpdate' => 'uate'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
}