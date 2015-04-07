<?php
/**
 * Created by PhpStorm.
 * User: Moon
 * Date: 8/21/14
 * Time: 8:01 PM
 */
class NewsAdmin extends BaseModel
{
    //内容类型 注（修改时请相应修改getContentType方法）
    const CONTENT_TXT			 = 1;//文字
    const CONTENT_IMAGE			 = 2;//图片
    const CONTENT_IMAGE_TXT		 = 3;//图文
    const ALL_SEARCH_WORD		 = 27; //二手房首页：大家都在搜
    const INDEX_HOTWORD_SALE  = 11; //首页首屏：买房（检索热词）
    const INDEX_HOTWORD_RENT 	 = 12; //首页首屏：租房（检索热词）
    const HOT_AREA_SALE			 = 19; //首页首屏：买房（热点区域）
    const HOT_AREA_RENT			 = 20; //首页首屏：租房（热点区域）
    const INDEX_ZUFANG_SPECIAL	 = 22; //租房首页 租房专题
    const INDEX_ZUFANG_NOTICE	 = 23; //租房首页 租房须知
    const INDEX_CENTER_BRAND	 = 14; //首页中屏：品牌专区

    protected $newsId;
    protected $cityId;
    protected $newsType;
    protected $contentType;
    protected $newsInfo;
    protected $newsTitle;
    protected $newsUrl;
    protected $imageUrl;
    protected $newSort;
    protected $createTime;

    public function getNewsId()
    {
        return $this->newsId;
    }

    public function setNewsId($newsId)
    {
        if(preg_match('/^\d{1,10}$/', $newsId == 0) || $newsId > 4294967295)
        {
            return false;
        }
        $this->newsId = $newsId;
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

    public function getNewsType()
    {
        return $this->newsType;
    }

    public function setNewsType($newsType)
    {
        if(preg_match('/^\d{1,10}$/', $newsType == 0) || $newsType > 127 || $newsType < -128)
        {
            return false;
        }
        $this->newsType = $newsType;
    }

    public function getContentType()
    {
        return $this->contentType;
    }

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    public function getNewsInfo()
    {
        return $this->newsInfo;
    }

    public function setNewsInfo($newsInfo)
    {
        if($newsInfo == '')
        {
            return false;
        }
        $this->newsInfo = $newsInfo;
    }

    public function getNewsTitle()
    {
        return $this->newsTitle;
    }

    public function setNewsTitle($newsTitle)
    {
        if($newsTitle == '' )
        {
            return false;
        }
        $this->newsTitle = $newsTitle;
    }

    public function getNewsUrl()
    {
        return $this->newsUrl;
    }

    public function setNewsUrl($newsUrl)
    {
        if($newsUrl == '')
        {
            return false;
        }
        $this->newsUrl = $newsUrl;
    }

    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    public function setImageUrl($imageUrl)
    {
        if($imageUrl == '')
        {
            return false;
        }
        $this->imageUrl = $imageUrl;
    }

    public function setNewSort($newSort){
        if(preg_match('/^\d{1,10}$/', $newSort == 0) || $newSort > 127 || $newSort < -128)
        {
            return false;
        }
        $this->newSort = $newSort;
    }

    public function getNewSort($newSort){
        return $this->newSort;
    }

    public function setCreateTime($createTime){
        if(preg_match('/^\d{1,10}$/', $createTime == 0) || $createTime > 4294967295)
        {
            return false;
        }
        $this->createTime = $createTime;
    }

    public function getCreateTime(){
        return $this->createTime;
    }

    public function getSource()
    {
        return 'cms_news';
    }

    public function columnMap()
    {
        return array(
            'newsId'    =>  'id',
            'cityId' => 'cityId',
            'newsType' => 'type',
            'newsContentType' => 'contentType',
            'newsAbstract' => 'abstract',
            'newsTitle' => 'title',
            'newsUrl' => 'url',
            'newsImageUrl' => 'imageUrl',
            'newsWeight' => 'weight',
            'newCreateTime' => 'createTime',
            'newsTitlePrefix' => 'titleprefix',
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
}