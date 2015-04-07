<?php
class Comment extends BaseModel{
    protected  $id;
    protected  $content;
    protected  $cityId;
    protected  $authorId;
    protected  $authorType;
    protected  $from;
    protected  $isCheck;
    protected  $time;
    protected  $ip;
    protected  $status;

    //数据状态  status
    const STATUS_VALID = 1;
    const STATUS_INVALID = 0;
    const STATUS_DELETE = -1;

    
    public static function instance($cache = true) {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
    public function initialize(){
        $this->setReadConnectionService('webSlave');
        $this->setWriteConnectionService('webMaster');
    }
   
    public function getSource()
    {
        return 'feed_back';
    }

    public function columnMap()
    {
        return array(
            'fbId' => 'id',
            'fbContent' => 'content',
            'cityId' => 'cityId',
            'authorId' => 'authorId',
            'authorType' => 'authorType',
            'fbFrom' => 'from',
            'isCheck' => 'isCheck',
            'time' => 'time',
            'ip' => 'ip',
            'fbStatus'=>'status'
        );
    }
   
    public function getfbId(){
        return $this->id;
    }
    public function setfbId($fbId){
        if(preg_match('/^\d{1,10}$/', $fbId == 0) || $fbId > 4294967295)
        {
            return false;
        }
        $this->id = $fbId;
    }
    
    public function getfbContent(){
        return $this->content;
    }
    public function setfbContent($fbContent)
    {
        if($fbContent == '' || mb_strlen($fbContent, 'utf8') > 50)
        {
            return false;
        }
        $this->content = $fbContent;
    }
    
    public function getcityId(){
        return $this->cityId;
    }
    public function setcityId($cityId){
        if(preg_match('/^\d{1,10}$/', $cityId == 0) || $cityId > 4294967295)
        {
            return false;
        }
        $this->cityId = $cityId;
    }
    
    public function getauthorId(){
        return $this->authorId;
    }
    public function setauthorId($authorId){
        if(preg_match('/^\d{1,10}$/', $authorId == 0) || $authorId > 4294967295)
        {
            return false;
        }
        $this->authorId = $authorId;
    }
    
    public function getauthorType(){
        return $this->authorType;
    }
    public function setauthorType($authorType){
        if(preg_match('/^\d{1,10}$/', $authorType == 0) || $authorType > 4294967295)
        {
            return false;
        }
        $this->authorType = $authorType;
    }
    
    public function getfbFrom(){
        return $this->from;
    }
    public function setfbFrom($fbFrom)
    {
        if($fbFrom == '' || mb_strlen($fbFrom, 'utf8') > 50)
        {
            return false;
        }
        $this->from = $fbFrom;
    }
    
    public function gettime(){
        return $this->time;
    }
    public function settime($time){
        if(preg_match('/^\d{1,10}$/', $time == 0) || $time > 4294967295)
        {
            return false;
        }
        $this->time = $time;
    }
    
    public function getip(){
        return $this->ip;
    }
    public function setip($ip)
    {
        if($ip == '' || mb_strlen($ip, 'utf8') > 50)
        {
            return false;
        }
        $this->ip = $ip;
    }
    public function del($fbId)
    {
        $rs = self::findFirst("id=".$fbId);
        $rs->status = self::STATUS_DELETE;

        if($rs->update())
            return array("status"=>0, "info"=>"删除失败!");
    
    }


}