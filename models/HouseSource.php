<?php
class HouseSource extends BaseModel
{
    public $id;
    public $houseId;
    public $from = '';
    public $fromId = 0;
    public $linkId = 0;
    public $linkUrl = '';
    public $status;
    public $update;
    
    const HOUSE_FROM_WEB = 1;	//网站
    const HOUSE_FROM_VIP = 2;   //焦点通
    const HOUSE_FROM_INTERFACE = 3;		//接口
    const HOUSE_FROM_THIRD_PARTY = 4;	//第三方
    const HOUSE_FROM_COOPERATION = 5;	//合作
    const HOUSE_FROM_CATCH  = 9;		//抓取
    
    const HOUSE_STATUS_FAIL = 0;	//失败
    const HOUSE_STATUS_SUCCESS = 1;	//成功
    const HOUSE_STATUS_WEIGUI = -1;	//违规

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if(preg_match('/^\d{1,10}$/', $id == 0) || $id > 4294967295)
        {
            return false;
        }
        $this->id = $id;
    }

    public function getHouseId()
    {
        return $this->houseId;
    }

    public function setHouseId($houseId)
    {
        if(preg_match('/^\d{1,10}$/', $houseId == 0) || $houseId > 4294967295)
        {
            return false;
        }
        $this->houseId = $houseId;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function setFrom($from)
    {
        if(preg_match('/^\d{1,3}$/', $from == 0) || $from > 255)
        {
            return false;
        }
        $this->from = $from;
    }

    public function getFromId()
    {
        return $this->fromId;
    }

    public function setFromId($fromId)
    {
        if(preg_match('/^\d{1,10}$/', $fromId == 0) || $fromId > 4294967295)
        {
            return false;
        }
        $this->fromId = $fromId;
    }

    public function getLinkId()
    {
        return $this->linkId;
    }

    public function setLinkId($linkId)
    {
        if($linkId == '' || mb_strlen($linkId, 'utf8') > 50)
        {
            return false;
        }
        $this->linkId = $linkId;
    }

    public function getLinkUrl()
    {
        return $this->linkUrl;
    }

    public function setLinkUrl($linkUrl)
    {
        if($linkUrl == '' || mb_strlen($linkUrl, 'utf8') > 150)
        {
            return false;
        }
        $this->linkUrl = $linkUrl;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        if(preg_match('/^-?\d{1,3}$/', $status) == 0 || $status > 127 || $status < -128)
        {
            return false;
        }
        $this->status = $status;
    }

    public function getUpdate()
    {
        return $this->update;
    }

    public function setUpdate($update)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $update) == 0 || strtotime($update) == false)
        {
            return false;
        }
        $this->update = $update;
    }

    public function getSource()
    {
        return 'house_source';
    }

    public function columnMap()
    {
        return array(
            'hsId' => 'id',
            'houseId' => 'houseId',
            'hsFrom' => 'from',
            'hsFromId' => 'fromId',
            'hsLinkId' => 'linkId',
            'hsLinkUrl' => 'linkUrl',
            'hsStatus' => 'status',
            'hsUpdate' => 'update'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    
    /**
     * 添加房源来源表
     * @param unknown $arrDate
     * @param intval $intFrom
     */
    public function addHouseSource( $arrData, $intFrom = HouseSource::HOUSE_FROM_INTERFACE )
    {
    	if( empty($arrData) )	return false;
    	
    	$objHouseSource = new HouseSource();
    	
    	$objHouseSource->from 		= 	$intFrom;
    	$objHouseSource->fromId 	= 	isset( $arrData['hsFromId'] ) ? $arrData['hsFromId'] : 0;
    	$objHouseSource->linkId 	= 	isset( $arrData['hsLinkId'] ) ? $arrData['hsLinkId'] : $arrData['houseId'] ;
    	$objHouseSource->linkUrl 	= 	isset( $arrData['hsLinkUrl'] ) ? $arrData['hsLinkUrl'] : '' ;
    	$objHouseSource->status 	= 	$arrData['status'];
    	$objHouseSource->houseId 	= 	$arrData['houseId'];
    	$objHouseSource->update 	= 	date('Y-m-d H:i:s');
    	
    	try 
    	{
    		return $objHouseSource->create();
    	}
    	catch (Exception $ex)
    	{
    		return false;
    	}
    }
}