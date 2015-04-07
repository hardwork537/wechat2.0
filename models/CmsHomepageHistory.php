<?php

class CmsHomepageHistory extends BaseModel
{
    protected $id;
    protected $sourceId;
    protected $cityId;
    protected $userId;
    protected $author;
    protected $modifyTime;
    protected $sourceContent;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setSourceid($sourceId)
    {
        $this->sourceId = $sourceId;
    }

    public function setCityid($cityId)
    {
        $this->cityId = $cityId;
    }

    public function setUserid($userId)
    {
        $this->userId = $userId;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function setModifytime($modifyTime)
    {
        $this->modifyTime = $modifyTime;
    }

    public function setSourcecontent($sourceContent)
    {
        $this->sourceContent = $sourceContent;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSourceid()
    {
        return $this->sourceId;
    }

    public function getCityid()
    {
        return $this->cityId;
    }

    public function getUserid()
    {
        return $this->userId;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getModifytime()
    {
        return $this->modifyTime;
    }

    public function getSourcecontent()
    {
        return $this->sourceContent;
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'hhId'            => 'id', 
            'sourceId'        => 'sourceId', 
            'cityId'          => 'cityId', 
            'userId'          => 'userId', 
            'hhAuthor'        => 'author', 
            'hhModifyTime'    => 'modifyTime', 
            'hhSourceContent' => 'sourceContent'
        );
    }
    
    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }

    /**
     * 实例化
     * @param type $cache
     * @return CmsHomepageHistory_Model
     */
    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
}
