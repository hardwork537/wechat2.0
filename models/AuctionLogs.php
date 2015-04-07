<?php

class AuctionLogs extends BaseModel
{

    public $alId;
    public $realId;
    public $alType;
    public $alContent;
    public $alTime;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'alId' => 'id',
            'realId' => 'realId', 
            'alType' => 'type',
            'alContent' => 'content',
            'alTime' => 'time'
        );
    }

}
