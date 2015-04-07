<?php
/**
 * @abstract 房源点击日志表
 * @author jackchen
 * @since  2014-09-18
 */
class HouseClickLog extends BaseModel
{
	public $id;
	public $realId;
	public $houseId;
	public $type;
	public $quality;
	public $time;

	public function columnMap()
	{
		return array(
   			'hcId' => 'id',
			'realId' => 'realId',
			'houseId' => 'houseId',
			'houseType' => 'type',
			'houseQuality' => 'quality',
			'time' => 'time'
		);
	}
	
	public function initialize()
	{
		$this->setReadConnectionService('esfSlave');
		$this->setWriteConnectionService('esfMaster');
	}

    public function getSource()
    {
        return 'web_house_clicklog';
    }


    /**
     * 根据经纪人ID,房源ID 获取房源点击量   -- 单日统计
     * @auth jackchen
     * @param int $realId
     * @param int $houseId
     * @return int $count
     */
    public function  getDayClickLog($realId,$houseId)
    {
        if(empty($realId) || empty($houseId)){
            return false;
        }
        $time = date('Y-m-d');
        $con['conditions'] = "realId=".$realId." and houseId=".$houseId." and DATE_FORMAT(time,'%Y-%m-%d') = '".$time."'";
        $con['columns'] = "id";
        $arrData = self::find($con);
        return $arrData->count();
    }

    /**
     * 根据经纪人ID,房源ID 获取房源点击量   -- 单周统计
     * @auth jackchen
     * @param int $realId
     * @param int $houseId
     * @return int $count
     */
    public function  getWeekClickLog($realId,$houseId)
    {
        if(empty($realId) || empty($houseId)){
            return false;
        }
        $time = date('Y-m-d', strtotime('-7 days'));
        $strtime = " and DATE_FORMAT(time,'%Y-%m-%d') >= '".$time."'";
        $con['conditions'] = "realId=".$realId." and houseId=".$houseId.$strtime;
        $con['columns'] = "id";
        $arrData = self::find($con);
        return $arrData->count();
    }

    /**
     * 根据经纪人ID,房源ID 获取房源点击量   -- 单月统计
     * @auth jackchen
     * @param int $realId
     * @param int $houseId
     * @return int $count
     */
    public function  getMonthClickLog($realId,$houseId)
    {
        if(empty($realId) || empty($houseId)){
            return false;
        }
        $time = date('Y-m');
        $con['conditions'] = "realId=".$realId." and houseId=".$houseId." and DATE_FORMAT(time,'%Y-%m') = '".$time."'";
        $con['columns'] = "id";
        $arrData = self::find($con);
        return $arrData->count();
    }

    /**
     * 根据经纪人ID,房源ID 获取房源点击量   -- 昨日统计
     * @auth jackchen
     * @param int $realId
     * @param int $houseId
     * @return int $count
     */
    public function  getYesterdayClickLog($realId,$houseId)
    {
        if(empty($realId) || empty($houseId)){
            return false;
        }
        $time = date('Y-m-d', strtotime("-1 day"));
        $con['conditions'] = "realId=".$realId." and houseId=".$houseId." and DATE_FORMAT(time,'%Y-%m-%d') = '".$time."'";
        $con['columns'] = "id";
        $arrData = self::find($con);
        return $arrData->count();
    }

    /**
     * 根据经纪人ID,房源ID 获取房源点击量   -- 全部统计
     * @auth jackchen
     * @param int $realId
     * @param int $houseId
     * @return int $count
     */
    public function  getTotalClickLog($realId,$houseId)
    {
        if(empty($realId) || empty($houseId)){
            return false;
        }
        $time = date('Y-m-d', strtotime("-1 day"));
        $con['conditions'] = "realId=".$realId." and houseId=".$houseId;
        $con['columns'] = "id";
        $arrData = self::find($con);
        return $arrData->count();
    }

}
