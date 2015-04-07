<?php

class CmsPropRealtor extends BaseModel
{
    protected $id;
    protected $propId;
    protected $cityId;
    protected $houseId;
    protected $realId;
    protected $weight = 0;
    protected $isAdd = self::ADD_NO;
    protected $recommendReason = '';
    protected $addTime;
    
    const ADD_NO = 1;     //未添加到选题
    const ADD_YES  = 2;   //已添加到选题
    
    
    /**
     * 添加推荐房源
     * @param array $data
     * @return boolean
     */
    public function add($data)
    {
        if(empty($data))
        {
            return false;
        }
        $rs = self::instance();
        $rs->propId = $data['id'];
        $rs->houseId = $data['houseId'];
        $rs->realId = $data['realId'];
        $rs->recommendReason = $data['recommendReason'];
        $rs->cityId = $data['cityId'];
        $rs->weight = $data['weight'];
        $rs->addTime = time();

        if($rs->create())
        {
            return true;
        }
        return false;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCityid($cityId)
    {
        $this->cityId = $cityId;
    }

    public function setHouseid($houseId)
    {
        $this->houseId = $houseId;
    }

    public function setIsadd($isAdd)
    {
        $this->isAdd = $isAdd;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function setRecommendreason($recommendReason)
    {
        $this->recommendReason = $recommendReason;
    }

    public function setAddtime($addTime)
    {
        $this->addTime = $addTime;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCityid()
    {
        return $this->cityId;
    }

    public function getHouseid()
    {
        return $this->houseId;
    }

    public function getIsadd()
    {
        return $this->isAdd;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getRecommendreason()
    {
        return $this->recommendReason;
    }

    public function getAddtime()
    {
        return $this->addTime;
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'prId'                => 'id', 
            'propId'              => 'propId',
            'cityId'              => 'cityId', 
            'houseId'             => 'houseId', 
            'realId'              => 'realId', 
            'prIsAdd'             => 'isAdd', 
            'prWeight'            => 'weight', 
            'prRecommendReason'   => 'recommendReason', 
            'prAddTime'           => 'addTime'
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
     * @return CmsPropRecommend_Model
     */
    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
}
