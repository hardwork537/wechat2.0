<?php

class CmsBlockProp extends BaseModel
{
    protected $id;
    protected $blockId;
    protected $title;
    protected $houseId;
    protected $distId;
    protected $regId;
    protected $priceMin;
    protected $priceMax;
    protected $areaMin;
    protected $areaMax;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setHouseid($houseId)
    {
        $this->houseId = $houseId;
    }

    public function setDistrictid($districtId)
    {
        $this->districtId = $districtId;
    }

    public function setRegionid($regionId)
    {
        $this->regionId = $regionId;
    }

    public function setPricemin($priceMin)
    {
        $this->priceMin = $priceMin;
    }

    public function setPricemax($priceMax)
    {
        $this->priceMax = $priceMax;
    }

    public function setAreamin($areaMin)
    {
        $this->areaMin = $areaMin;
    }

    public function setAreamax($areaMax)
    {
        $this->areaMax = $areaMax;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getHouseid()
    {
        return $this->houseId;
    }

    public function getDistrictid()
    {
        return $this->districtId;
    }

    public function getRegionid()
    {
        return $this->regionId;
    }

    public function getPricemin()
    {
        return $this->priceMin;
    }

    public function getPricemax()
    {
        return $this->priceMax;
    }

    public function getAreamin()
    {
        return $this->areaMin;
    }

    public function getAreamax()
    {
        return $this->areaMax;
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'bpId'       => 'id', 
            'blockId'    => 'blockId',
            'bpTitle'    => 'title', 
            'bpHouseId'  => 'houseId', 
            'distId'     => 'districtId', 
            'regId'      => 'regionId', 
            'bpPriceMin' => 'priceMin', 
            'bpPriceMax' => 'priceMax', 
            'bpAreaMin'  => 'areaMin', 
            'bpAreaMax'  => 'areaMax'
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
     * @return CmsBlockProp_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }

}
