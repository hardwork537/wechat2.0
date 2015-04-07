<?php
class OrderSource extends BaseModel
{
    protected $id;
    protected $type;
    protected $typeId;
    protected $to;
    protected $toId;
    protected $linkId;
    protected $rank;
    protected $amount;
    protected $createDate;
    protected $startDate;
    protected $expiryDate;
    protected $status;
    protected $update;

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

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        if(preg_match('/^\d{1,5}$/', $type == 0) || $type > 65535)
        {
            return false;
        }
        $this->type = $type;
    }

    public function getTypeId()
    {
        return $this->typeId;
    }

    public function setTypeId($typeId)
    {
        if(preg_match('/^\d{1,10}$/', $typeId == 0) || $typeId > 4294967295)
        {
            return false;
        }
        $this->typeId = $typeId;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function setTo($to)
    {
        if(preg_match('/^\d{1,3}$/', $to == 0) || $to > 255)
        {
            return false;
        }
        $this->to = $to;
    }

    public function getToId()
    {
        return $this->toId;
    }

    public function setToId($toId)
    {
        if(preg_match('/^\d{1,10}$/', $toId == 0) || $toId > 4294967295)
        {
            return false;
        }
        $this->toId = $toId;
    }

    public function getLinkId()
    {
        return $this->linkId;
    }

    public function setLinkId($linkId)
    {
        if(preg_match('/^\d{1,10}$/', $linkId == 0) || $linkId > 4294967295)
        {
            return false;
        }
        $this->linkId = $linkId;
    }

    public function getRank()
    {
        return $this->rank;
    }

    public function setRank($rank)
    {
        if(preg_match('/^\d{1,10}$/', $rank == 0) || $rank > 4294967295)
        {
            return false;
        }
        $this->rank = $rank;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        if(preg_match('/^\d{1,10}$/', $amount == 0) || $amount > 4294967295)
        {
            return false;
        }
        $this->amount = $amount;
    }

    public function getCreateDate()
    {
        return $this->createDate;
    }

    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    public function setExpiryDate($expiryDate)
    {
        $this->expiryDate = $expiryDate;
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

    public function getUpdate()
    {
        return $this->update;
    }

    public function setUpdate($update)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $update) == 0 || strtotime($update) == false)
        {
            return false;
        }
        $this->update = $update;
    }

    public function getSource()
    {
        return 'order_source';
    }

    public function columnMap()
    {
        return array(
            'osId' => 'id',
            'osType' => 'type',
            'osTypeId' => 'typeId',
            'osTo' => 'to',
            'osToId' => 'toId',
            'osLinkId' => 'linkId',
            'osRank' => 'rank',
            'osAmount' => 'amount',
            'osCreateDate' => 'createDate',
            'osStartDate' => 'startDate',
            'osExpiryDate' => 'expiryDate',
            'osStatus' => 'status',
            'osUpdate' => 'update'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
}