<?php

class RealtorSuspected extends BaseModel
{

    protected $id;
    protected $phone;
    protected $operateTime;
    protected $operateName;
    protected $operateType;
    protected $addNum;
    protected $editNum;
    protected $delNum;
    protected $message;
    protected $status;

    //状态  0:删除 1:疑似经纪人 2.黑名单
    const  STATUS_OK = 1;
    const  STATUS_ERROR = 0;
    const  STATUS_BLACK = 2;

    public function setRsid($rsId)
    {
        $this->id = $rsId;
        return $this;
    }

    public function setRsphone($rsPhone)
    {
        $this->rsPhone = $rsPhone;
        return $this;
    }

    public function setRsoperatetime($rsOperateTime)
    {
        $this->rsOperateTime = $rsOperateTime;
        return $this;
    }

    public function setRsoperatename($rsOperateName)
    {
        $this->rsOperateName = $rsOperateName;
        return $this;
    }

    public function setRsoperatetype($rsOperateType)
    {
        $this->rsOperateType = $rsOperateType;
        return $this;
    }

    public function setRsaddnum($rsAddNum)
    {
        $this->rsAddNum = $rsAddNum;
        return $this;
    }

    public function setRseditnum($rsEditNum)
    {
        $this->rsEditNum = $rsEditNum;
        return $this;
    }

    public function setRsdelnum($rsDelNum)
    {
        $this->rsDelNum = $rsDelNum;
        return $this;
    }

    public function setRsmessage($rsMessage)
    {
        $this->rsMessage = $rsMessage;
        return $this;
    }

    public function setRsstatus($rsStatus)
    {
        $this->rsStatus = $rsStatus;
        return $this;
    }

    public function getRsid()
    {
        return $this->id;
    }

    public function getRsphone()
    {
        return $this->rsPhone;
    }

    public function getRsoperatetime()
    {
        return $this->rsOperateTime;
    }

    public function getRsoperatename()
    {
        return $this->rsOperateName;
    }

    public function getRsoperatetype()
    {
        return $this->rsOperateType;
    }

    public function getRsaddnum()
    {
        return $this->rsAddNum;
    }

    public function getRseditnum()
    {
        return $this->rsEditNum;
    }

    public function getRsdelnum()
    {
        return $this->rsDelNum;
    }

    public function getRsmessage()
    {
        return $this->rsMessage;
    }

    public function getRsstatus()
    {
        return $this->rsStatus;
    }

    public function columnMap()
    {
        return array(

            'rsPhone' => 'phone',
            'rsOperateTime' => 'operateTime',
            'rsOperateName' => 'operateName',
            'rsOperateType' => 'operateType',
            //'rsAddNum' => 'addNum',
            //'rsEditNum' => 'editNum',
           // 'rsDelNum' => 'delNum',
            'rsMessage' => 'message',
            'rsStatus' => 'status',
            'rsExt'=>'ext'
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

    public function add($arr){

        $is_exit = self::findFirst("phone=".$arr['phone']);
        if($is_exit){
            if($is_exit->status==RealtorSuspected::STATUS_ERROR){//如果存在，且处于删除状态，重新置为疑似经纪人
                $is_exit->status=$arr['status'];
                $is_exit->message=$arr['message'];
                if($is_exit->update()){
                    return array("status"=>true,"info"=>"添加成功");
                }
                return array("status"=>false,"info"=>"添加失败");
            }elseif($is_exit->status==RealtorSuspected::STATUS_OK){
                return array("status"=>false,"info"=>"该手机已是疑似经纪人");
            }else{
                return array("status"=>false,"info"=>"该手机已在黑名单中");
            }
        }
        $arrInsert = $arr;
        $arrInsert['operateTime']= date("Y-m-d H:i:s");
        $arrInsert['status']   = isset($arrInsert['status'])?$arrInsert['status']:1;

        try
        {
            if(self::create($arrInsert))
                return array("status"=>true,"info"=>"添加成功");
            else
                return array("status"=>false,"info"=>"添加失败");
        }
        catch (Exception $ex)
        {
            return array("status"=>false,"info"=>"添加失败");
        }
    }

    public function del($phone, $status=self::STATUS_ERROR){
        if (!$phone) return false;
        $obj = self::findFirst("phone = $phone");
        $obj->status=$status;
        $obj->operateTime=date("Y-m-d H:i:s");
        if ($obj->update()){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * @abstract 根据手机号判断是否为黑名单or疑似经纪人 
     * @author Eric xuminwan@sohu-inc.com
     * @param string $phone
     * @return array
     * 
     */
    public function getSuspectedByPhone($phone)
    {
    	if(!$phone) return array();
    	$arrParam['conditions'] = 'phone = ?1';
    	$arrParam['bind'] = array(1=>$phone);
    	return self::findFirst($arrParam,0)->toArray();
    }


}
