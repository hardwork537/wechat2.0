<?php

class HouseRefreshLog extends BaseModel
{

    /**
     *
     * @var integer
     */
    public $comId;

    /**
     *
     * @var integer
     */
    public $realId;

    /**
     *
     * @var integer
     */
    public $houseType;

    /**
     *
     * @var integer
     */
    public $houseId;

    /**
     *
     * @var integer
     */
    public $refreshSum;

    /**
     *
     * @var integer
     */
    public $time;

    /**
     *
     * @var integer
     */
    public $shopId;

    /**
     *
     * @var integer
     */
    public $parkId;

    /**
     *
     * @var integer
     */
    public $distId;

    /**
     *
     * @var integer
     */
    public $regId;

    public $cityId;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'comId' => 'comId', 
            'realId' => 'realId', 
            'houseType' => 'houseType', 
            'houseId' => 'houseId', 
            'refreshSum' => 'refreshSum', 
            'prlTime' => 'time',
            'shopId' => 'shopId', 
            'parkId' => 'parkId', 
            'distId' => 'distId', 
            'regId' => 'regId',
            'cityId'    =>  'cityId'
        );
    }

    public function getSource ()
    {
        return 'house_refresh_log';
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }

}
