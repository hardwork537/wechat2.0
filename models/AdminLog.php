<?php

class AdminLog extends  BaseModel
{
    public $id;
    public $userAccname;
    public $userId = 0;
    public $adminRoleId;
    public $model = '';
    public $cityId;
    public $message;
    public $time;
    public $ip;
    const ROLEID_ALL = 1;//超级管理员
    const ROLEID_CITY = 2;//城市管理员
    const ROLEID_KEFU = 3;//客服
    const ROLEID_XIAOSOU = 4; //销售
    const ROLEID_BIANJI = 5; //楼盘编辑 对应admin_user 里的5
    const ROLEID_COM = 9;//公司 对应VipLogEnterprise里的1
    const ROLEID_AREA = 6;//区域 对应VipLogEnterprise里的2
    const ROLEID_SHOP = 7;//门店 对应VipLogEnterprise里的3
    const ROLEID_REALTOR = 8; //经纪人 对应VipLogEnterprise里的7


    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'alId' => 'id',
            'userAccname' => 'userAccname', 
            'userId' => 'userId', 
            'adminRoleId' => 'adminRoleId', 
            'alModel' => 'model',
            'cityId' => 'cityId', 
            'alMessage' => 'message',
            'alTime' => 'time',
            'alIp' => 'ip'
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

    public function getLogList($con, $size=15, $offset=0,$conArray){
        //去焦点通取数据
        if(in_array($conArray["adminRoleId"], array(9,6,7))){
            $roleMap = array(9=>VipLogEnterprise::LOG_ENT_TYPE,6=>VipLogEnterprise::LOG_AREA_TYPE,7=>VipLogEnterprise::LOG_AGENT_TYPE);
            $con .= " AND type=".$roleMap[$conArray["adminRoleId"]];
            if($conArray["userAccname"]){
                $con .= " AND accname='".$conArray["userAccname"]."'";
            }
            if($conArray["cityId"]){
                $con .= " AND cityId=".$conArray["cityId"];
            }
            $result["total"] = VipLogEnterprise::count($con);
            $list = VipLogEnterprise::find([
                "conditions"=>$con,
                "order" => "id desc",
                "limit" => [
                    'number' => $size,
                    'offset' => $offset
                ],
                "columns"=>"accname as userAccname,message,time"
            ])->toArray();
        }elseif($conArray["adminRoleId"] == 8){
            //经纪人
            if($conArray["userAccname"]){
                $rs = VipAccount::instance()->getAccountByStatus($conArray["userAccname"], VipAccount::STATUS_VALID)->toArray();//根据账号获取经纪人id
                if($rs){
                    $realId = $rs["toId"];
                    $con .= " AND realId = ".$realId;
                }else{
                    $con .= " AND realId = 0 ";
                }
            }

            $rs = RefreshLog::query()
                ->columns(" realId, houseId, houseType, isAuto, time")
                ->where($con)
                ->join('Realtor', 'RefreshLog.realId = Realtor.id and Realtor.cityId='.$conArray["cityId"], 'Realtor')
                ->limit($size, $offset)
                ->order("time desc")
                ->execute()
                ->toArray();
            $list = array();

            $count = RefreshLog::query()
                ->columns(" count(*) as num")
                ->where($con)
                ->join('Realtor', 'RefreshLog.realId = Realtor.id and Realtor.cityId='.$conArray["cityId"], 'Realtor')
                ->execute()
                ->toArray();
            $result["total"] = $count[0]['num'];
            foreach($rs as $k=>$v){
                $rs = VipAccount::findFirst("toId=".$v["realId"]." AND to=".VipAccount::ROLE_REALTOR);
                if($rs){
                    $list[$k]["userAccname"] = $rs->name;
                }
                $rs = Realtor::findFirst("id=".$v["realId"]);
                if($rs){
                    $list[$k]["zhName"] = $rs->name;
                }
                if($v["isAuto"] == RefreshLog::REFRESH_MANUL){
                    $message = "手动刷新";
                }else{
                    $message = "定时刷新";
                }
                if($v["houseType"]==22 || $v["houseType"]==21 ){
                    $list[$k]["message"] = $message." 出售房源";
                }else{
                    $list[$k]["message"] = $message." 出租房源";
                }
                $list[$k]["time"] = date("y-m-d H:i:s", $v["time"]);
            }
        }else{
            //admin日志
            if($conArray["cityId"]){
                $con .= " AND cityId in (".$conArray["cityId"].",999)";
            }
            if($conArray["adminRoleId"]){
                $con .= " AND adminRoleId=".$conArray["adminRoleId"];
            }
            if($conArray["userAccname"]){
                $con .= " AND userAccname='".$conArray["userAccname"]."'";
            }
            $result["total"] = AdminLog::count($con);
            $list = AdminLog::find([
                "conditions"=>$con,
                "order" => "id desc",
                "limit" => [
                    'number' => $size,
                    'offset' => $offset
                ]
            ])->toArray();
            if(empty($list)) return array();
            foreach($list as $k=>$v){
                if(in_array($v["adminRoleId"], array(1,2,3,4,5)) ){
                    $rs = AdminUser::findFirst("id=".$v["userId"],0)->toArray();
                    $list[$k]["zhName"] = $rs["name"]?$rs["name"]:"";
                }
            }
        }
        $result['list'] = $list;
        return $result;
    }


    /*
     * @desc 添加一条新的log
     * @param $arrParam array
     * addminRoleId 1=>'超级管理员',2=>'城市管理员',3=>'客服',4=>'销售',5=>'编辑',6=>'区域',7=>'门店',8=>'经纪人',9=>'公司'
     * */
    public function add($arrParam){
        $arrInsert['userAccname'] = $arrParam["userAccname"]?$arrParam["userAccname"]:"system";
        $arrInsert['userId']      = $arrParam["userId"]?$arrParam["userId"]:0;
        $arrInsert['adminRoleId'] = $arrParam["adminRoleId"]?$arrParam["adminRoleId"]:0;
        $arrInsert['model']       = $arrParam["model"]?$arrParam["model"]:"admin";
        $arrInsert['cityId']      = $arrParam["cityId"]?$arrParam["cityId"]:0;
        $arrInsert['message']     = $arrParam["message"]?$arrParam["message"]:'';
        $arrInsert['time']        = date("Y-m-d H:i:s",time());
        $arrInsert['ip']          = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
        $this->create($arrInsert);
        $intInsertId = $this->insertId();
        if ( $intInsertId <= 0 ) {
            return false;
        }
        return $intInsertId;
    }

}
