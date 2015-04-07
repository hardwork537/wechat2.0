<?php
class SchoolPicture extends BaseModel
{
    protected $schoolId;
    protected $imgId;
    protected $picType;
    protected $picDesc;
    protected $picMeta;
    protected $picSeq;
    protected $picStatus;
    protected $picUpdate;

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

    public function getImgId()
    {
        return $this->imgId;
    }

    public function setImgId($imgId)
    {
        if(preg_match('/^\d{1,10}$/', $imgId == 0) || $imgId > 4294967295)
        {
            return false;
        }
        $this->imgId = $imgId;
    }

    public function getPicType()
    {
        return $this->picType;
    }

    public function setPicType($picType)
    {
        if(preg_match('/^\d{1,3}$/', $picType == 0) || $picType > 255)
        {
            return false;
        }
        $this->picType = $picType;
    }

    public function getPicDesc()
    {
        return $this->picDesc;
    }

    public function setPicDesc($picDesc)
    {
        if($picDesc == '' || mb_strlen($picDesc, 'utf8') > 50)
        {
            return false;
        }
        $this->picDesc = $picDesc;
    }

    public function getPicMeta()
    {
        return $this->picMeta;
    }

    public function setPicMeta($picMeta)
    {
        if($picMeta == '' || mb_strlen($picMeta, 'utf8') > 250)
        {
            return false;
        }
        $this->picMeta = $picMeta;
    }

    public function getPicSeq()
    {
        return $this->picSeq;
    }

    public function setPicSeq($picSeq)
    {
        if(preg_match('/^\d{1,10}$/', $picSeq == 0) || $picSeq > 4294967295)
        {
            return false;
        }
        $this->picSeq = $picSeq;
    }

    public function getPicStatus()
    {
        return $this->picStatus;
    }

    public function setPicStatus($picStatus)
    {
        if(preg_match('/^-?\d{1,3}$/', $picStatus) == 0 || $picStatus > 127 || $picStatus < -128)
        {
            return false;
        }
        $this->picStatus = $picStatus;
    }

    public function getPicUpdate()
    {
        return $this->picUpdate;
    }

    public function setPicUpdate($picUpdate)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $picUpdate) == 0 || strtotime($picUpdate) == false)
        {
            return false;
        }
        $this->picUpdate = $picUpdate;
    }

    public function getSource()
    {
        return 'school_picture';
    }

    public function columnMap()
    {
        return array(
            'schoolId' => 'schoolId',
            'imgId' => 'imgId',
            'picType' => 'picType',
            'picDesc' => 'picDesc',
            'picMeta' => 'picMeta',
            'picSeq' => 'picSeq',
            'picStatus' => 'picStatus',
            'picUpdate' => 'picUpdate'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
}