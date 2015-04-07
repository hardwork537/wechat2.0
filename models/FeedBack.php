<?php
class FeedBack extends BaseModel
{
    //经纪人类型broker_type
    const BROKER_COMPANY = 1;
    const BROKER_PERSONAL = 2;
    const PERSON = 3;	//类型为：个人


    protected $id;
    protected $content;
    protected $cityId;
    protected $authorId;
    protected $authorType;
    protected $from;
    protected $isCheck;
    protected $time;
    protected $ip;

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

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        if($content == '' || strlen($content) > 65535)
        {
            return false;
        }
        $this->content = $content;
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

    public function getAuthorId()
    {
        return $this->authorId;
    }

    public function setAuthorId($authorId)
    {
        if(preg_match('/^-?\d{1,10}$/', $authorId) == 0 || $authorId > 2147483647 || $authorId < -2147483648)
        {
            return false;
        }
        $this->authorId = $authorId;
    }

    public function getAuthorType()
    {
        return $this->authorType;
    }

    public function setAuthorType($authorType)
    {
        if(preg_match('/^-?\d{1,3}$/', $authorType) == 0 || $authorType > 127 || $authorType < -128)
        {
            return false;
        }
        $this->authorType = $authorType;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function setFrom($from)
    {
        if($from == '' || mb_strlen($from, 'utf8') > 50)
        {
            return false;
        }
        $this->from = $from;
    }

    public function getIsCheck()
    {
        return $this->isCheck;
    }

    public function setIsCheck($isCheck)
    {
        if(preg_match('/^-?\d{1,3}$/', $isCheck) == 0 || $isCheck > 127 || $isCheck < -128)
        {
            return false;
        }
        $this->isCheck = $isCheck;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $time) == 0 || strtotime($time) == false)
        {
            return false;
        }
        $this->time = $time;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function setIp($ip)
    {
        if($ip == '' || mb_strlen($ip, 'utf8') > 50)
        {
            return false;
        }
        $this->ip = $ip;
    }

    public function getSource()
    {
        return 'web_feed_back';
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
            'fbtime' => 'time',
            'ip' => 'ip'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }


    public function addFeedBack($data){
        if (!$data) return false;
        $insertData = array();
        if (!isset($data['content'])){
            return false;
        }
        else{
            $insertData['content'] =  $data['content'];
        }
        if (!isset($data['cityId'])){
            if (isset($GLOBALS['CITY_ID'])){
                $insertData['cityId'] = $GLOBALS['CITY_ID'];
            }
            else{
                return false;
            }

        }
        else{
            $insertData['cityId'] =  $data['cityId'];
        }
        if (!isset($data['authorId'])){
            return false;
        }
        else{
            $insertData['authorId'] =  $data['authorId'];
        }
        if (!isset($data['authorType'])){
            return false;
        }
        else{
            $insertData['authorType'] =  $data['authorType'];
        }
        if (isset($data['from'])){
            $insertData['from'] =  $data['from'];
        }
        if (isset($data['isCheck'])){
            $insertData['isCheck'] =  $data['isCheck'];
        }
        if (isset($data['time'])){
            $insertData['time'] =  $data['time'];
        }
        if (isset($data['ip'])){
            $insertData['ip'] =  $data['ip'];
        }
        else{
            $insertData['ip'] =  Utility::GetUserIP();
        }
        try{
            return $this->create($insertData);
        }
        catch(Exception $e){
            return false;
        }
    }
}