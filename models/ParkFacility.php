<?php
class ParkFacility extends BaseModel
{
    protected $id;
    protected $parkId;
    protected $type;
    protected $name;
    protected $desc;
    protected $lindId;
    protected $xY;
    protected $lonLat;
    protected $distance;
    protected $walkTime;
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

    public function getParkId()
    {
        return $this->parkId;
    }

    public function setParkId($parkId)
    {
        if(preg_match('/^\d{1,10}$/', $parkId == 0) || $parkId > 4294967295)
        {
            return false;
        }
        $this->parkId = $parkId;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        if(preg_match('/^\d{1,3}$/', $type == 0) || $type > 255)
        {
            return false;
        }
        $this->type = $type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if($name == '' || mb_strlen($name, 'utf8') > 50)
        {
            return false;
        }
        $this->name = $name;
    }

    public function getDesc()
    {
        return $this->desc;
    }

    public function setDesc($desc)
    {
        if($desc == '' || mb_strlen($desc, 'utf8') > 250)
        {
            return false;
        }
        $this->desc = $desc;
    }

    public function getLindId()
    {
        return $this->lindId;
    }

    public function setLindId($lindId)
    {
        if(preg_match('/^\d{1,10}$/', $lindId == 0) || $lindId > 4294967295)
        {
            return false;
        }
        $this->lindId = $lindId;
    }

    public function getXY()
    {
        return $this->xY;
    }

    public function setXY($xY)
    {
        if($xY == '' || mb_strlen($xY, 'utf8') > 50)
        {
            return false;
        }
        $this->xY = $xY;
    }

    public function getLonLat()
    {
        return $this->lonLat;
    }

    public function setLonLat($lonLat)
    {
        if($lonLat == '' || mb_strlen($lonLat, 'utf8') > 30)
        {
            return false;
        }
        $this->lonLat = $lonLat;
    }

    public function getDistance()
    {
        return $this->distance;
    }

    public function setDistance($distance)
    {
        if($distance == '' || mb_strlen($distance, 'utf8') > 30)
        {
            return false;
        }
        $this->distance = $distance;
    }

    public function getWalkTime()
    {
        return $this->walkTime;
    }

    public function setWalkTime($walkTime)
    {
        if(preg_match('/^\d{1,3}$/', $walkTime == 0) || $walkTime > 255)
        {
            return false;
        }
        $this->walkTime = $walkTime;
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
        return 'park_facility';
    }

    public function columnMap()
    {
        return array(
            'pfId' => 'id',
            'parkId' => 'parkId',
            'pfType' => 'type',
            'pfName' => 'name',
            'pfDesc' => 'desc',
            'pfLindId' => 'lindId',
            'pfXY' => 'xY',
            'pfLonLat' => 'lonLat',
            'pfDistance' => 'distance',
            'pfWalkTime' => 'walkTime',
            'pfStatus' => 'status',
            'pfUpdate' => 'update'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
}