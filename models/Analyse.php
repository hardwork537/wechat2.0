<?php
/**
 * @服务器日志统计
 * @author flash
 * @since  date 2014/10/6
 */
class Analyse extends BaseModel
{
	public $id;
    public $houseType = 0;
    public $cityId;
    public $distId = 0;
    public $regId = 0;
    public $parkId = 0;
    public $housePrice = 0;
    public $houseBA = 0;
    public $houseBedRoom = 0;
    public $houseBuildType = 0;
    public $logTime;
    
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

    public function getHouseType()
    {
        return $this->houseType;
    }

    public function setHouseType($houseType)
    {
        if(preg_match('/^\d{1,3}$/', $houseType == 0) || $houseType > 255)
        {
            return false;
        }
        $this->houseType = $houseType;
    }

    public function getCityId()
    {
        return $this->cityId;
    }

    public function setCityId($cityId)
    {
        if(preg_match('/^\d{1,10}$/', $cityId == 0) || $cityId > 4294967295)
        {
            return false;
        }
        $this->cityId = $cityId; 
    }

    public function getDistId()
    {
        return $this->distId;
    }

    public function setDistId($distId)
    {
        if(preg_match('/^\d{1,10}$/', $distId == 0) || $distId > 4294967295)
        {
            return false;
        }
        $this->distId = $distId;
    }

    public function getRegId()
    {
        return $this->regId;
    }

    public function setRegId($regId)
    {
        if(preg_match('/^\d{1,10}$/', $regId == 0) || $regId > 4294967295)
        {
            return false;
        }
        $this->regId = $regId;
    }

    public function getParkId()
    {
        return $this->parkId;
    }

    public function setParkId($parkId)
    {
        if(preg_match('/^\d{1,10}$/', $parkId == 0) || $parkId > 4294967295)
        {
            return false;
        }
        $this->parkId = $parkId;
    }

    public function columnMap ()
    {
        return array(
			'aId'			    =>'id',
			'houseType'			=>'houseType',
			'cityId'			=>'cityId',
			'distId'		    =>'distId',
			'regId'			    =>'regId',
			'parkId'			=>'parkId',
			'housePrice'		=>'housePrice',
			'houseBA'	        =>'houseBA',
			'houseBedRoom'		=>'houseBedRoom',
			'houseBuildType'	=>'houseBuildType',
			'logTime'			=>'logTime',
        );
    }

    public function getSource()
    {
    	return 'vip_analyse';
    }
    
	public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
}