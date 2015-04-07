<?php
class Blacklist extends BaseModel
{
    protected $id;
    protected $operator;
    protected $addTime;
    protected $tel;
    protected $deleteTime;
    protected $reason;
    
    public function getBlacklistId()
    {
        return $this->id;
    }

    public function setBlacklistId($blacklistId)
    {
        if(preg_match('/^\d{1,10}$/', $blacklistId == 0) || $blacklistId > 4294967295)
        {
            return false;
        }
        $this->id = $blacklistId;
    }
    public function setOperator($operator)
    {
        if($operator == '' || mb_strlen($operator, 'utf8') > 50)
        {
            return false;
        }
        $this->operator = $operator;
    }

    public function getOperator()
    {
        return $this->operator;
    }
    public function setTel($tel)
    {
        if($tel == '' || mb_strlen($tel, 'utf8') > 50)
        {
            return false;
        }
        $this->tel = $tel;
    }

    public function getTel()
    {
        return $this->tel;
    }
    public function setReason($reason)
    {
        if($reason == '' || mb_strlen($reason, 'utf8') > 50)
        {
            return false;
        }
        $this->reason = $reason;
    }

    public function getReason()
    {
        return $this->reason;
    }
    public function getSource()
    {
        return 'blacklist';
    }
    
    public function columnMap()
    {
        return array(
            'blId'               => 'id',
            'blOperator'         => 'operator',
            'blAddTime'          => 'addTime',
            'blTel'              => 'tel',
            'blDeleteTime'       => 'deleteTime',
            'blReason'           => 'reason'
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
    
    public function add($data) 
    {
        if( empty($data) )	return false;
        $data['addTime'] = date("Y-m-d H:i:s");
        
        try
        {
            return self::create($data);
        }
        catch (Exception $ex)
        {
            return false;
        }
    }
    public function del($id)
    {
        $rs = self::findFirst($id);
        if ($rs->delete()) {
            return array('status'=>0,'info'=>'删除成功');
        }
        return array('status'=>1,'info'=>'删除失败');
    }
}

