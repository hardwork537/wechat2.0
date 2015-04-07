<?php
/* 
writen by pingwang 2014/9/18 afternoon :)——working hard for unkown beatuiful future
 */
class Enterprisenotice extends BaseModel
{
    protected $id;
    protected $type;
    protected $text;
    protected $pictureId;
    protected $pictureExt;
    protected $time;
    protected $person;
    protected $cityId;
    protected $adurl;
    
    public function columnMap()
    {
        return array(
            'noticeId'                => 'id',
            'noticeType'              => 'type',
            'noticeText'              => 'text',
            'noticePictureId'         => 'pictureId',
            'noticePictureExt'        => 'pictureExt',
            'noticeTime'              => 'time',
            'noticePerson'            => 'person',
            'noticeCityId'            => 'cityId',
            'noticeAdurl'             => 'adurl',
        );  
    }
    static public $NOTICETYPE=array(
        1 => "公司公告",
        2 => "区域公告",
        3 => "门店公告",
        4 => "经纪人公告",
    );
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
        if(preg_match('/^\d{1,10}$/', $type == 0) || $type > 4294967295)
        {
            return false;
        }
        $this->type = $type;
    }
    public function getPictureId()
    {
        return $this->pictureId;
    }

    public function setPictureId($pictureId)
    {
        if($pictureId == '' || mb_strlen($pictureId, 'utf8') > 500)
        {
            return false;
        }
        $this->pictureId = $pictureId;
    }
        public function getPictureExt()
    {
        return $this->pictureExt;
    }

    public function setPictureExt($pictureExt)
    {
        if($pictureExt == '' || mb_strlen($pictureExt, 'utf8') > 500)
        {
            return false;
        }
        $this->pictureExt = $pictureExt;
    }
    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time)
    {
        if($time == '' || mb_strlen($time, 'utf8') > 500)
        {
            return false;
        }
        $this->time = $time;
    }
        public function getPerson()
    {
        return $this->person;
    }

    public function setPerson($person)
    {
        if($person == '' || mb_strlen($person, 'utf8') > 500)
        {
            return false;
        }
        $this->person = $person;
    }
        public function getAdurl()
    {
        return $this->adurl;
    }

    public function setAdurl($adurl)
    {
        if($adurl == '' || mb_strlen($adurl, 'utf8') > 500)
        {
            return false;
        }
        $this->adurl = $adurl;
    }
        public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        if($text == '' || mb_strlen($text, 'utf8') > 500)
        {
            return false;
        }
        $this->text = $text;
    }
    public function getCityId()
    {
        return $this->cityId;
    }

    public function setCityId($cityId)
    {
        if(preg_match('/^\d{1,10}$/', $cityId== 0) || $cityId > 4294967295)
        {
            return false;
        }
        $this->cityId = $cityId;
    }

    public function getSource()
    {
    	return 'vip_enterprise_notice';
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

        if(empty($data))
        {
            return array('status'=>1, 'info'=>'参数为空！');
        }
        
        $this->type = intval($data['type']);
        $this->cityId = intval($data["cityId"]);
        $this->text = $data["text"];
        $this->pictureId = $data["pictureId"];
        $this->pictureExt = $data["pictureExt"];
        $this->time = date("Y-m-d");
        $this->person = $data["person"];
        $this->adurl = $data["adurl"];

        if($this->create())
        {
           
            return array('status'=>0, 'info'=>'添加公告成功！');
        }
        return array('status'=>-1, 'info'=>'添加公告失败！');
    }
     public function edit($id,$data)
    {
        
       
        if(empty($data))
        {
            return array('status'=>1, 'info'=>'参数为空！');
        }
        $id = intval($id);
        $rs = self::findfirst($id);

        $rs->text = $data["text"];
        $rs->pictureId = $data["pictureId"];
        $rs->pictureExt = $data["pictureExt"];
        $rs->time = date("Y-m-d H:i:s");
        $rs->person = $data["person"];
        $rs->adurl = $data["adurl"];
 
        if( $rs->update())
        {
             return true;
        }
        return FALSE;
    }
    
    
}
