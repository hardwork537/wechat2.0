<?php

class CrmSaleTrackDay extends BaseModel
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
     * @var string
     */
    public $createTime;

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
            'csCreateTime' => 'createTime',
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

    /*
     * 获取销售天统计数据条数
     * */
    public function getDaysDataCount($con, $count_day=7){
        $con = $this->_params_arr($con,$count_day);
        $rs = $this->find([
            "conditions" => $con,
            'order'   => "userId asc",
            'group'   => "userId",
            "columns"    => "count(*)as num"
        ])->toArray();

        return count($rs);
    }

    /**
     * 获取日统计表头
     * @param type $count_day
     * @return type
     */
    public function getDaysTitleList($count_day=7){
        for($i=$count_day;$i>0;$i--){
            $data['title'][] = date("m/d",time()-($i * 86400));
            $data['value'][] = date("Y-m-d",time()-($i * 86400));
        }
        return $data;
    }

    public function _params_arr($con, $count_day){
        $count_day = intval($count_day);
        $time_from = date("Y-m-d",time()-(($count_day+1) * 86400));
        $time_to = date("Y-m-d",time()-86400);
        $con .= " AND createTime >= '{$time_from}' AND createTime <= '{$time_to}'";
        return $con;
    }

    /**
     * 获取销售天统计数据
     * @param type $count_day 天数
     * @param type $offset
     * @param type $size
     * @return type
     */
    public function getDaysData($con, $offset=0, $size=15, $count_day=7){
        $con = $this->_params_arr($con,$count_day);
        $rs = $this->find([
            "conditions" => $con,
            "limit" => [
                'number' => $size,
                'offset' => $offset
            ],
            'order'   => "userId desc",
            'group'   => "userId",
            "columns"    => "userId,crmTeamId, GROUP_CONCAT(createTime) concatcreateTime ,GROUP_CONCAT(superRealtorNum) concatSuperRealtorNum, GROUP_CONCAT(payRealtorNum) concatPayRealtorNum,GROUP_CONCAT(activeRealtorNum) concatActiveRealtorNum "
        ])->toArray();
        return $rs;
    }

    //批量添加
    public function add($param){
        if(empty($param)) return false;
        $valSql = '';
        $createTime = date("Y-m-d",time()-86400);
        $addWeek    = date("YW",time()-86400);

        foreach($param as $v){
            $valSql .= "(".$v['userId'].",".$v['cityId'].",".$v['crmTeamId'].",".$v['activeRealtorNum'].",".$v['superRealtorNum'].",".$v['payRealtorNum'].",'".$createTime."',".$addWeek."),";
        }
        $valSql = trim($valSql,',');

        $sql = "INSERT INTO crm_sale_track_day (userId,cityId,crmTeamId ,csActiveRealtorNum, csSuperRealtorNum, csPayRealtorNum,csCreateTime,csAddWeek  ) VALUES {$valSql}";
        $rs = $this->execute($sql);
        return $rs;
    }
}
