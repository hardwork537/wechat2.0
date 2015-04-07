<?php

class CmsGoodNews extends BaseModel
{
    public $id;
    public $cityId;
    public $newsType;
    public $newsId;
    public $newsClick;
    public $newsUpdate;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'cityId' => 'cityId', 
            'newsType' => 'newsType', 
            'newsId' => 'newsId', 
            'newsClick' => 'newsClick', 
            'newsUpdate' => 'newsUpdate'
        );
    }
    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    public static function instance ($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self();
    }

}
