<?php

class AuctionAgreement extends BaseModel
{
    public $aaId;
    public $realId;
    public $aaMonth;
    public $aaCreateTime;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'aaId' => 'id',
            'realId' => 'realId', 
            'aaMonth' => 'month',
            'aaCreateTime' => 'createTime'
        );
    }

}
