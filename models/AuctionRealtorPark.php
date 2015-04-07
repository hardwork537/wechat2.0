<?php

class AuctionRealtorPark extends BaseModel
{
    public $id;
    public $parkId;
    public $realId;
    public $release;
    public $refresh;
    public $main;
    public $infoStatus;
    public $imageStatus;
    public $score;
    public $month;
    public $arUpdate;
    public $create;

    //数据状态status
	const STATUS_UNCHECK_INFO = 0;  //信息未审核
	const STATUS_CHECKED_INFO = 1;  //信息已审核
	const STATUS_UNCHECK_IMAGE = 0;  //图片未审核
	const STATUS_CHECKED_IMAGE = 1;  //图片已审核

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'arId' => 'id',
            'parkId' => 'parkId', 
            'realId' => 'realId',
            'arRelease' => 'release',
            'arRefresh' => 'refresh',
            'arMain' => 'main',
            'arInfoStatus' => 'infoStatus',//信息审核状态值
            'arImageStatus' => 'imageStatus',//图片审核状态值
            'arScore' => 'score',
            'arMonth' => 'month',
            'arUpdate' => 'arUpdate',
            'arCreate' => 'create',
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }

}
