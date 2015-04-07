<?php
/* 
writen by pingwang 2014/9/14 sunday afternoon :)——working hard for unkown beatuiful future
 */

class CmsNews extends BaseModel
{
    protected $id;
    protected $cityId;
    protected $type;
    protected $contentType;
    protected $abstract;
    protected $title;
    protected $url;
    protected $imageUrl;
    protected $weight;
    protected $createTime;
    protected $titlePrefix;


    const ALL_SEARCH_WORD		 = 27; //二手房首页：大家都在搜
    const INDEX_HOTWORD_SALE    = 11; //首页首屏：买房（检索热词）
    const INDEX_HOTWORD_RENT 	 = 12; //首页首屏：租房（检索热词）
    const HOT_AREA_SALE			 = 19; //首页首屏：买房（热点区域）
    const HOT_AREA_RENT			 = 20; //首页首屏：租房（热点区域）
    const INDEX_ZUFANG_SPECIAL	 = 22; //租房首页 租房专题
    const INDEX_ZUFANG_NOTICE	 = 23; //租房首页 租房须知
    const INDEX_CENTER_BRAND	 = 14; //首页中屏：品牌专区

    public static $newsTitleType = [
        19=>'二手房首页：热门城区',
        11=>'二手房首页：热门搜索',
        27=>'二手房首页：大家都在搜',
        2=>"二手房买卖合同",
        3=>"房屋租赁合同",
        12=>'租房：热门搜索',
        20=>'租房：热门区域',
        22=>'租房：租房专题',
        23=>'租房：租房须知',
        14=>'二手房：品牌专区'
    ];

    public static $newsContentType = [
        1=>'文字',
        2=>'图片',
        3=>'图文'
    ];

//    //news type
  //  const HOT_AREA_SALE        = 1; //热门城区
    const INDEX_HOT_WORD_SALE  = 11; //热门搜索
    const INDEX_SUBJECT        = 22; //专题
    const INDEX_FLASH          = 4; //广告轮播
  //  const ALL_SEARCH_WORD      = 5; //大家都在搜
    const NEWS_ERSHOUFANGHETONG = 2; //二手房合同
    const NEWS_FANGWUZULIN      = 3; //租房合同


    //content type
    const CONTENT_TXT	       = 1;//文字
    const CONTENT_IMAGE	       = 2;//图片
    const CONTENT_IMAGE_TXT    = 3;//图文
    

    public function columnMap()
    {
        return array(
            'newsId'              => 'id',
            'cityId'              => 'cityId',
            'newsType'            => 'type',
            'newsContentType'     => 'contentType',
            'newsTitle'           =>'title',
            'newsAbstract'        => 'abstract',
            'newsUrl'             => 'url',
            'newsImageUrl'        => 'imageUrl',
            'newsWeight'          => 'weight',
            'newCreateTime'       => 'createTime',
            'newsTitlePrefix'     => 'titlePrefix'
        );  
    }   
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
        public function getContentType()
    {
        return $this->contentType;
    }

    public function setContetnType($contentType)
    {
        if(preg_match('/^\d{1,10}$/', $contentType == 0) || $contentType > 4294967295)
        {
            return false;
        }
        $this->type = $contentType;
    }
    public function getInfo()
    {
        return $this->abstract;
    }

    public function setInfo($info)
    {
        if($info == '' || mb_strlen($info, 'utf8') > 500)
        {
            return false;
        }
        $this->abstract = $info;
    }

        public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        if($title == '' || mb_strlen($title, 'utf8') > 200)
        {
            return false;
        }
        $this->title = $title;
    }
        public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        if($url == '' || mb_strlen($url, 'utf8') > 500)
        {
            return false;
        }
        $this->url = $url;
    }
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    public function setImageUrl($imageUrl)
    {
        if($imageUrl == '' || mb_strlen($imageUrl, 'utf8') > 500)
        {
            return false;
        }
        $this->imageUrl = $imageUrl;
    }
    
    public function getSort()
    {
        return $this->weight;
    }

    public function setSort($sort)
    {
        if(preg_match('/^\d{1,10}$/', $sort == 0) || $sort > 4294967295)
        {
            return false;
        }
        $this->weight = $sort;
    }
    public function getSource()
    {
        return 'cms_news';
    }
 
    /**
     * 修改新闻信息
     * @param array $data
     * @return array
     */
    public function edit($newsId, $data) 
    {
        $newsId = intval($newsId);
        if(empty($data) || !$newsId) 
        {
            return array('status'=>1, 'info'=>'参数为空！');
        }
        $rs = self::findFirst($newsId);
        $rs->cityId = $data["cityId"];
        $rs->type = $data["type"];
        $rs->contentType = $data['contentType'];
        $rs->abstract = $data['abstract'];
        $rs->title = $data['title'];
        $rs->titlePrefix = $data['titlePrefix'];
        $rs->url = $data['url'];
        $rs->imageUrl = $data['imageUrl'];
        $rs->weight = $data['weight'];
        if($rs->update()) 
            return array('status'=>0, 'info'=>'修改成功！');  
        else
            return array('status'=>1, 'info'=>'修改失败！');  
    }
    
    
    /**
     * 删除单条记录
     *
     * @param int $newsId   
     * @return boolean         
     */
    public function del($newsId)
    {
        $rs = self::findFirst($newsId);
        if ($rs->delete()) {
            return array('status'=>0,'info'=>'删除成功');
        }
        return array('status'=>1,'info'=>'删除失败');
    }
    
    

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    
    /**
     * 实例化
     * @param type $cache
     * @return Park_Model
     */

    public static function instance($cache = true) 
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }

    /*
     * @desc 添加新闻
     * */
    public function addNews( $arrData )
    {
        if( empty($arrData) )	return false;
        $arrData['createTime'] = date("Y-m-d H:i:s");
        try
        {
            return self::create($arrData);
        }
        catch (Exception $ex)
        {
            return false;
        }
    }
    
    
}
