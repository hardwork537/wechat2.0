<?php

class CrmSaleTrackWeek extends BaseModel
{

    /**
     *
     * @var integer
     */
    public $userId;

    /**
     *
     * @var integer
     */
    public $cityId;

    /**
     *
     * @var integer
     */
    public $crmTeamId;

    /**
     *
     * @var integer
     */
    public $activeRealtorNum;

    /**
     *
     * @var integer
     */
    public $superRealtorNum;

    /**
     *
     * @var integer
     */
    public $payRealtorNum;

    /**
     *
     * @var integer
     */
    public $addWeek;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'userId' => 'userId', 
            'cityId' => 'cityId', 
            'crmTeamId' => 'crmTeamId', 
            'csActiveRealtorNum' => 'activeRealtorNum',
            'csSuperRealtorNum' => 'superRealtorNum',
            'csPayRealtorNum' => 'payRealtorNum',
            'csAddWeek' => 'addWeek'
        );
    }

    public static function instance ($cache = true)
    {
        return BaseModel::_instance(__CLASS__, $cache);
        return new self();
    }
    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    /**
     * 获取周统计表头
     * @param type $count_week
     * @return type
     */
    public function getWeekTitleList($count_week=4){
        for($i=$count_week;$i>0;$i--){
            $data['title'][] = date("Y\WW",time()-($i * 7 * 86400));
            $data['value'][] = date("YW",time()-($i * 7 * 86400));
        }
        return $data;
    }

    /**
     * 获取销售周统计数据
     * @param type $count_week 周数
     * @param type $offset
     * @param type $size
     * @return boolean
     */
    public function getWeeksData($con=array(), $offset=0, $size=0, $count_week=4){

        $count_week = intval($count_week);
        $time_from = date("YW",time()-(($count_week+1)*7 * 86400));
        $time_to = date("YW",time()-7*86400);
        $con  .= " AND addWeek >= '{$time_from}' AND addWeek <= '{$time_to}'";

        $rs = $this->find([
            "conditions" => $con,
            "limit" => [
                'number' => $size,
                'offset' => $offset
            ],
            'order'   => "userId desc",
            'group'   => "userId",
            "columns"    => "userId,crmTeamId, GROUP_CONCAT(addWeek) concataddWeek ,GROUP_CONCAT(superRealtorNum) concatSuperRealtorNum, GROUP_CONCAT(payRealtorNum) concatPayRealtorNum,GROUP_CONCAT(activeRealtorNum) concatActiveRealtorNum "
        ])->toArray();
        return $rs;

    }


    //插入新的数据
    public function add($time_week){
        $sql= "insert into crm_sale_track_week (userId,crmTeamId,cityId,csAddWeek,csSuperRealtorNum,csPayRealtorNum,csActiveRealtorNum) "
            . "(SELECT userId,crmTeamId,cityId,csAddWeek,SUM(csSuperRealtorNum) csSuperRealtorNum,SUM(csPayRealtorNum) csPayRealtorNum ,SUM(csActiveRealtorNum) csActiveRealtorNum"
            . " FROM `crm_sale_track_day` WHERE `csAddWeek` = {$time_week}  GROUP BY userId,csAddWeek)";
        $rs = $this->execute($sql);
        return $rs;
    }

}
