<?php

class Community extends BaseModel
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $cityId;

    /**
     *
     * @var integer
     */
    protected $userId;

    /**
     *
     * @var string
     */
    protected $title;

    /**
     *
     * @var string
     */
    protected $author;

    /**
     *
     * @var string
     */
    protected $sourceName;

    /**
     *
     * @var string
     */
    protected $intro;

    /**
     *
     * @var integer
     */
    protected $imageId;

    /**
     *
     * @var string
     */
    protected $imageExt;

    /**
     *
     * @var integer
     */
    protected $createTime;

    /**
     *
     * @var integer
     */
    protected $modifyTime;

    /**
     *
     * @var integer
     */
    protected $publishTime;

    /**
     *
     * @var integer
     */
    protected $revokeTime;

    /**
     *
     * @var integer
     */
    protected $pv;

    /**
     *
     * @var integer
     */
    protected $status;

    const STATUS_PENDING = 1;   //待发布
    const STATUS_PUBLISH = 2;   //已发布
    const STATUS_REVOKE  = 3;   //撤回

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field cityId
     *
     * @param integer $cityId
     * @return $this
     */
    public function setCityid($cityId)
    {
        $this->cityId = $cityId;

        return $this;
    }

    /**
     * Method to set the value of field userId
     *
     * @param integer $userId
     * @return $this
     */
    public function setUserid($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Method to set the value of field title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Method to set the value of field author
     *
     * @param string $author
     * @return $this
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Method to set the value of field sourceName
     *
     * @param string $sourceName
     * @return $this
     */
    public function setSourcename($sourceName)
    {
        $this->sourceName = $sourceName;

        return $this;
    }

    /**
     * Method to set the value of field intro
     *
     * @param string $intro
     * @return $this
     */
    public function setIntro($intro)
    {
        $this->intro = $intro;

        return $this;
    }

    /**
     * Method to set the value of field imageId
     *
     * @param integer $imageId
     * @return $this
     */
    public function setImageid($imageId)
    {
        $this->imageId = $imageId;

        return $this;
    }

    /**
     * Method to set the value of field imageExt
     *
     * @param string $imageExt
     * @return $this
     */
    public function setImageext($imageExt)
    {
        $this->imageExt = $imageExt;

        return $this;
    }

    /**
     * Method to set the value of field createTime
     *
     * @param integer $createTime
     * @return $this
     */
    public function setCreatetime($createTime)
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * Method to set the value of field modifyTime
     *
     * @param integer $modifyTime
     * @return $this
     */
    public function setModifytime($modifyTime)
    {
        $this->modifyTime = $modifyTime;

        return $this;
    }

    /**
     * Method to set the value of field publishTime
     *
     * @param integer $publishTime
     * @return $this
     */
    public function setPublishtime($publishTime)
    {
        $this->publishTime = $publishTime;

        return $this;
    }

    /**
     * Method to set the value of field revokeTime
     *
     * @param integer $revokeTime
     * @return $this
     */
    public function setRevoketime($revokeTime)
    {
        $this->revokeTime = $revokeTime;

        return $this;
    }

    /**
     * Method to set the value of field pv
     *
     * @param integer $pv
     * @return $this
     */
    public function setPv($pv)
    {
        $this->pv = $pv;

        return $this;
    }

    /**
     * Method to set the value of field status
     *
     * @param integer $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field cityId
     *
     * @return integer
     */
    public function getCityid()
    {
        return $this->cityId;
    }

    /**
     * Returns the value of field userId
     *
     * @return integer
     */
    public function getUserid()
    {
        return $this->userId;
    }

    /**
     * Returns the value of field title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the value of field author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Returns the value of field sourceName
     *
     * @return string
     */
    public function getSourcename()
    {
        return $this->sourceName;
    }

    /**
     * Returns the value of field intro
     *
     * @return string
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * Returns the value of field imageId
     *
     * @return integer
     */
    public function getImageid()
    {
        return $this->imageId;
    }

    /**
     * Returns the value of field imageExt
     *
     * @return string
     */
    public function getImageext()
    {
        return $this->imageExt;
    }

    /**
     * Returns the value of field createTime
     *
     * @return integer
     */
    public function getCreatetime()
    {
        return $this->createTime;
    }

    /**
     * Returns the value of field modifyTime
     *
     * @return integer
     */
    public function getModifytime()
    {
        return $this->modifyTime;
    }

    /**
     * Returns the value of field publishTime
     *
     * @return integer
     */
    public function getPublishtime()
    {
        return $this->publishTime;
    }

    /**
     * Returns the value of field revokeTime
     *
     * @return integer
     */
    public function getRevoketime()
    {
        return $this->revokeTime;
    }

    /**
     * Returns the value of field pv
     *
     * @return integer
     */
    public function getPv()
    {
        return $this->pv;
    }

    /**
     * Returns the value of field status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return Community[]
     */
    public static function find($parameters = array())
    {
        return parent::find($parameters);
    }

    /**
     * @return Community
     */
    public static function findFirst($parameters = array())
    {
        return parent::findFirst($parameters);
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'cityId' => 'cityId', 
            'userId' => 'userId', 
            'title' => 'title', 
            'author' => 'author', 
            'sourceName' => 'sourceName', 
            'intro' => 'intro', 
            'imageId' => 'imageId', 
            'imageExt' => 'imageExt', 
            'createTime' => 'createTime', 
            'modifyTime' => 'modifyTime', 
            'publishTime' => 'publishTime', 
            'revokeTime' => 'revokeTime', 
            'pv' => 'pv', 
            'status' => 'status'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('cmsSlave');
        $this->setWriteConnectionService('cmsMaster');
    }

    public function getHouseNewsList($param){
        return self::find($param,0)->toArray();
    }

}
