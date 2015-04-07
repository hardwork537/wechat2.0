<?php

class CmsDynamicExt extends BaseModel
{
    protected $dynamicId;
    protected $content;


    public function setContent($content)
    {
        $this->content = $content;
    }


    public function getContent()
    {
        return $this->content;
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'dynamicId' => 'dynamicId',
            'deContent' => 'content'
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
     * @return CmsDynamic_Model
     */
    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
    public function getContents($con){
        $rs = $this->find($con)->toArray();
        if(empty($rs)) return array();
        foreach($rs as $k=>$v){
            $result[$v["dynamicId"]] = $v['content'];
        }
        return $result;
    }
}
