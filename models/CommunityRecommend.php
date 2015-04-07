<?php

class CommunityRecommend extends BaseModel
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
    protected $parkId;

    /**
     *
     * @var string
     */
    protected $recommendReason;

    /**
     *
     * @var integer
     */
    protected $weight;

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
     * Method to set the value of field parkId
     *
     * @param integer $parkId
     * @return $this
     */
    public function setParkid($parkId)
    {
        $this->parkId = $parkId;

        return $this;
    }

    /**
     * Method to set the value of field recommendReason
     *
     * @param string $recommendReason
     * @return $this
     */
    public function setRecommendreason($recommendReason)
    {
        $this->recommendReason = $recommendReason;

        return $this;
    }

    /**
     * Method to set the value of field weight
     *
     * @param integer $weight
     * @return $this
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

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
     * Returns the value of field parkId
     *
     * @return integer
     */
    public function getParkid()
    {
        return $this->parkId;
    }

    /**
     * Returns the value of field recommendReason
     *
     * @return string
     */
    public function getRecommendreason()
    {
        return $this->recommendReason;
    }

    /**
     * Returns the value of field weight
     *
     * @return integer
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return CommunityRecommend[]
     */
    public static function find($parameters = array())
    {
        return parent::find($parameters);
    }

    /**
     * @return CommunityRecommend
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
            'parkId' => 'parkId', 
            'recommendReason' => 'recommendReason', 
            'weight' => 'weight'
        );
    }

}
