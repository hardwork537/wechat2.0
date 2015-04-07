<?php
class ParkRank extends BaseModel
{
    protected $id;
    protected $parkId;
    protected $name;
    protected $value;
    protected $rank;
    protected $status;
    protected $update;

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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if($name == '' || mb_strlen($name, 'utf8') > 20)
        {
            return false;
        }
        $this->name = $name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        if($value == '' || mb_strlen($value, 'utf8') > 20)
        {
            return false;
        }
        $this->value = $value;
    }

    public function getRank()
    {
        return $this->rank;
    }

    public function setRank($rank)
    {
        if(preg_match('/^\d{1,10}$/', $rank == 0) || $rank > 4294967295)
        {
            return false;
        }
        $this->rank = $rank;
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
        return 'park_rank';
    }

    public function columnMap()
    {
        return array(
            'prId' => 'id',
            'parkId' => 'parkId',
            'prName' => 'name',
            'prValue' => 'value',
            'prRank' => 'rank',
            'prStatus' => 'status',
            'prUpdate' => 'update'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    
    /**
     * @abstract 根据小区ID获取小区的配套排名 
     * @author Eric xuminwan@sohu-inc.com
     * @param int $intParkId
     * @param int $intRank
     * @return array
     * 
     */
    public function getRankByParkId($intParkId, $intRank = 0)
    {
    	if(!$intParkId) return array();
    	$arrCon['conditions'] = "parkId = {$intParkId} and status = 1";
    	if($intRank > 0) $arrCon['conditions'] .= " and rank >= {$intRank}";
    	$arrRank = self::find($arrCon,0)->toArray();
    	return $arrRank;
    }
    
    /**
     * @abstract 获取同板块中配套/交通排名靠前的小区
     * @author Eric xuminwan@sohu-inc.com
     * @param int $intParkId
     * @param int $intRegId
     * @param int $rankType 1:配套  2:交通 
     * @return array
     *
     */
    public function getRankByRegId($intParkId, $intRegId, $rankLimit, $rankType = 1)
    {
    	if(!($intParkId && $intRegId && $rankType && $rankLimit)) return array();
    	$columns = "ParkRank.rank,park.id,park.name";
    	$strCondition = "park.regId = {$intRegId} and ParkRank.status = 1";
    	if($rankType == 1)
    	{
    		$strCondition .= " and ParkRank.name = 'assortRank'";
    	}
    	else
    	{
    		$strCondition .= " and ParkRank.name = 'trafficRank'";
    	}
    	$order = "ParkRank.rank";
    	$rankInfo = self::query()
    	->columns($columns)
    	->where($strCondition)
    	->leftJoin('park', 'park.id = ParkRank.parkId', 'park')
    	->limit($rankLimit)
    	->orderBy($order)
    	->execute();
    	if($rankInfo)
    	{
    		return $rankInfo->toArray();
    	}
    	return array();
    }
}