<?php

class CmsCommunityRecommend extends BaseModel
{
    protected $id;
    protected $commId;
    protected $parkId;
    protected $recommendReason;
    protected $weight = 0;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setParkid($parkId)
    {
        $this->parkId = $parkId;
    }

    public function setRecommendreason($recommendReason)
    {
        $this->recommendReason = $recommendReason;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getParkid()
    {
        return $this->parkId;
    }

    public function getRecommendreason()
    {
        return $this->recommendReason;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'crId'              => 'id', 
            'commId'            => 'commId',
            'parkId'            => 'parkId', 
            'crRecommendReason' => 'recommendReason', 
            'crWeight'          => 'weight'
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
     * @return CmsCommunityRecomment_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
}
