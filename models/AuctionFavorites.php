<?php

class AuctionFavorites extends BaseModel
{

    public $afId;
    public $realId;
    public $parkId;

    /**
     *
     * @var string
     */
    public $afUptime;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'afId' => 'id',
            'realId' => 'realId', 
            'parkId' => 'parkId', 
            'afUptime' => 'uptime'
        );
    }

}
