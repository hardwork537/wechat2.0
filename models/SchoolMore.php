<?php
class SchoolMore extends BaseModel
{
    protected $id;
    protected $schoolId;
    protected $name;
    protected $text;
    protected $length;
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

    public function getSchoolId()
    {
        return $this->schoolId;
    }

    public function setSchoolId($schoolId)
    {
        if(preg_match('/^\d{1,10}$/', $schoolId == 0) || $schoolId > 4294967295)
        {
            return false;
        }
        $this->schoolId = $schoolId;
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

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        if($text == '' || strlen($text) > 65535)
        {
            return false;
        }
        $this->text = $text;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        if(preg_match('/^\d{1,5}$/', $length == 0) || $length > 65535)
        {
            return false;
        }
        $this->length = $length;
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
        return 'school_more';
    }

    public function columnMap()
    {
        return array(
            'smId' => 'id',
            'schoolId' => 'schoolId',
            'smName' => 'name',
            'smText' => 'text',
            'smLength' => 'length',
            'smStatus' => 'status',
            'smUpdate' => 'update'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
}