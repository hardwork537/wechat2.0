<?php

/**
 * @abstract  置业专家
 * @copyright Sohu-inc Team.
 * @author    Rady (yifengcao@sohu-inc.com)
 * @date      2014-09-04 11:11:26
 * @version   1.0
 */
class Expert extends BaseModel {

    //置业专家类型
    const TYPE_DISTRICT = 1; //类型-城区
    const TYPE_AREA = 2; //类型-板块
    const TYPE_LINE = 3; //类型-线路
    const TYPE_SITE = 4; //类型-站点
    const TYPE_PARK = 5; //类型-小区
    const TYPE_SCHOOL = 6; //类型-学校
   
    //channel频道类型
    const CHANNEL_SALE = 2; //二手房(出售)
    const CHANNEL_RENT = 1; //租房(出租)
    const CHANNEL_PARK = 3; //小区专家不区分出租出售
    const CHANNEL_CLIENT = 4;
    
    //展示类型
    const SHOW_HOUSE = 1; //房源
    const SHOW_REALTOR = 2; //经纪人头像
    
    //clientType客户类型
    const CLIENT_TYPE_COMPANY = 1; //公司
    const CLIENT_TYPE_SECTOR = 2; //区域（暂时先不用）
    const CLIENT_TYPE_SHOP = 3; //门店
    const CLIENT_TYPE_REALTOR = 4; //经纪人
    
    public static $buyTypeOptions = array(
        self::TYPE_DISTRICT => '城区',
        self::TYPE_AREA => '板块',
        self::TYPE_LINE => '轨道线路',
        self::TYPE_SITE => '轨道站点',
        self::TYPE_PARK => '小区',
        self::TYPE_SCHOOL => '学校'
    );
    public static $channelOptions = array(
        self::CHANNEL_SALE => '出售',
        self::CHANNEL_RENT => '出租',
    );
    static $_site;
    public $id;
    public $cityId;
    public $clientType;
    public $clientId;
    public $channel;
    public $showType;
    public $buyType;
    public $buyId;
    public $contractNo = '';
    public $beginTime;
    public $endTime;
    public $weight = 0;
    public $createType = 0;
    public $updateTime = 0;

    public $error = "";
    
    public function getSource() {
        return 'vip_expert';
    }

    public function columnMap() {
        return array(
            'expertId' => 'id',
            'cityId' => 'cityId',
            'clientType' => 'clientType',
            'clientId' => 'clientId',
            'expertChannel' => 'channel',
            'expertShowType' => 'showType',
            'expertBuyType' => 'buyType',
            'expertBuyId' => 'buyId',
            'contractNo' => 'contractNo',
            'expertBeginTime' => 'beginTime',
            'expertEndTime' => 'endTime',
            'expertWeight' => 'weight',
            'expertCreateType' => 'createType',
            'expertUpdateTime' => 'updateTime',
        );
    }

    public function initialize() {
        $this->setConn('esf');
    }

    /**
     * 实例化对象
     *
     * @param type $cache
     * @return \Users_Model
     */
    public static function instance($cache = true, $site = null) {
        self::$_site = $site;
        return parent::_instance(__CLASS__, $cache);
        return new self();
    }

    /**
     * @abstract 根据相关条件获取置业专家信息
     * @author Eric xuminwan@sohu-inc.com
     * @param string $condition
     * @return array|bool
     *
     */
    public function getExpertByCondition($condition) {
        if (!$condition)
            return false;
        $arrExpert = self::find(array(
                    $condition,
                    'order' => 'weight',
        ));
        if ($arrExpert) {
            return $arrExpert->toArray();
        } else {
            return false;
        }
    }

    /**
     * 获取置业专家列表
     * @param unknown $where
     * @param string $order
     * @param number $offset
     * @param number $limit
     * @param string $select
     */
    public function getList($con = array(), $order = "", $offset = 0, $limit = 0, $select = "") {
        $rs = self::query();

        if (!empty($con['comId'])) {
                $realtorIdsArr = $shopIdsArr = [];
                $companyId = intval($con['comId']);
                $shopIds = Shop::find(
                                [
                                    "conditions" => "comId='{$companyId}'",
                                    "columns" => 'id'
                        ])->toArray();
                foreach ($shopIds as $v) {
                    $shopIdsArr[] = $v['id'];
                }
                if ($shopIdsArr) {
                    $shopIdsStr = "(" . implode(",", $shopIdsArr) . ")";
                }
                $realtorIds = Realtor::find(
                                [
                                    "conditions" => "comId='{$companyId}'",
                                    "columns" => 'id'
                        ])->toArray();
                foreach ($realtorIds as $v) {
                    $realtorIdsArr[] = $v['id'];
                }
                if ($realtorIdsArr) {
                    $realtorIdsStr = "(" . implode(",", $realtorIdsArr) . ")";
                }
                
                if ($shopIdsStr && $realtorIdsStr) {
                    $clientWhere = " ((clientType = '" . Expert::CLIENT_TYPE_SHOP . "' and clientId in $shopIdsStr) or (clientType = '" .
                            Expert::CLIENT_TYPE_REALTOR . "' and clientId in $realtorIdsStr))";
                    $rs->where($clientWhere);
                } else if ($shopIdsStr) {
                    $clientWhere = " (clientType = '" . Expert::CLIENT_TYPE_SHOP . "' and clientId in $shopIdsStr) ";
                    $rs->where($clientWhere);
                } else if ($realtorIdsStr) {
                    $clientWhere = " (clientType = '" . Expert::CLIENT_TYPE_REALTOR . "' and clientId in $realtorIdsStr)";
                    $rs->where($clientWhere);
                }
                if($clientWhere){
                    $rs->where($clientWhere);
                    $exIds = $rs->columns("id")->execute()->toArray();
                }else{
                    return [];
                }
                
        }
        
       // print_r($exIds);die();
        /*
         if (!empty($con['comId'])) {
             $rs->andwhere("comId='" . intval($con['comId']) . "'");
         }
         */
        $rs = self::query();
        if($exIds){
            foreach ($exIds as $v) {
                $exIdsArr[] = $v['id'];
            }
            $rs->where("id  in (".implode(",", $exIdsArr).")");
        }
         
         if (!empty($con['cityId'])) {
             $rs->andwhere("cityId='" . intval($con['cityId']) . "'");
         }
        if (!empty($con['showType'])) {
            $rs->andwhere("showType='" . $con['showType'] . "'");
        }
        if (!empty($con['channel'])) {
            $rs->andwhere("channel='" . $con['channel'] . "'");
        }
        if (!empty($con['buyType'])) {
            $rs->andwhere("buyType='" . $con['buyType'] . "'");
            if (!empty($con['buyName'])) {
                switch ($con['buyType']) {
                    case self::TYPE_DISTRICT:
                        $district = CityDistrict::findFirst("name='" . $con['buyName'] . "'");
                        $buyId = $district->id;
                        break;
                    case self::TYPE_AREA:
                        $region = CityRegion::findFirst("name='" . $con['buyName'] . "'");
                        $buyId = $region->id;
                        break;
                    case self::TYPE_LINE:
                        $metro = Metro::findFirst("name='" . $con['buyName'] . "'");
                        $buyId = $metro->id;
                        break;
                    case self::TYPE_SITE:
                        $metroStation = MetroStation::findFirst("name='" . $con['buyName'] . "'");
                        $buyId = $metroStation->id;
                        break;
                    case self::TYPE_PARK:
                        $park = Park::findFirst("name='" . $con['buyName'] . "'");
                        $buyId = $park->id;
                        break;
                    case self::TYPE_SCHOOL:
                        $school = School::findFirst("name='" . $con['buyName'] . "'");
                        $buyId = $school->id;
                        break;
                    default:
                        break;
                }
                if ($buyId) {
                    $rs->andwhere("buyId='" . $buyId . "'");
                } else {
                    return [];
                }
            }
        }
        if (!empty($con['clientType'])) {
            $rs->andwhere("clientType='" . $con['clientType'] . "'");
            if (!empty($con['clientName'])) {
                switch ($con['clientType']) {
                    case self::CLIENT_TYPE_COMPANY:
                        $company = VipAccount::findFirst("name='" . $con['clientName'] . "' and  to = '" . VipAccount::ROLE_COMPANY . "'");
                        $clientId = $company->toId;
                        break;
                    case self::CLIENT_TYPE_SHOP:
                        $shop = VipAccount::findFirst("name='" . $con['clientName'] . "' and  to = '" . VipAccount::ROLE_SHOP . "'");
                        $clientId = $shop->toId;
                        break;
                    case self::CLIENT_TYPE_REALTOR:
                        $realtor = VipAccount::findFirst("name='" . $con['clientName'] . "' and  to = '" . VipAccount::ROLE_REALTOR . "'");
                        $clientId = $realtor->toId;
                        break;
                    default:
                        break;
                }
                if ($clientId) {
                    $rs->andwhere("clientId='" . $clientId . "'");
                } else {
                    return[];
                }
            }
        }
        if (!empty($con['time'])) {
            $rs->andwhere("beginTime < '" . $con['time'] . "'");
            $rs->andwhere("endTime > '" . $con['time'] . "'");
        }

        if ($order) {
            $rs->orderBy($order);
        }

        if ($limit) {
            $rs->limit($limit, $offset);
        }
        if ($select) {
            $rs->columns($select);
        }


        return $rs->execute()->toArray();
    }

    /**
     * 添加置业专家
     *
     * @param array $arr
     * @return boolean
     */
    public function add($arr) {
        $arr['cityId'] = intval($arr['cityId']);
        $arr['clientType'] = intval($arr["clientType"]);
        $arr['clientId'] = intval($arr["clientId"]);
        $arr['buyType'] = intval($arr["buyType"]);
        $arr['buyId'] = intval($arr["buyId"]);
        $arr['showType'] = intval($arr["showType"]);
        $arr['channel'] = intval($arr["channel"]);
        $arr['contractNo'] = empty($arr["contractNo"]) ? "" : $arr["contractNo"];
        $arr['beginTime'] = $arr["beginTime"];
        $arr['endTime'] = $arr["endTime"];
        $arr['weight'] = intval($arr["weight"]);
        $arr['updateTime'] = date("Y-m-d H:i:s");
        $nums = $this->getNums($arr['buyType'], $arr['buyId'], $arr['showType'], $arr['channel'],$arr['beginTime'],$arr['endTime']);
        
        if($arr['showType']==self::SHOW_REALTOR){
            if($nums>=3){
                $this->error = "该位置置业专家位置已满,试试其他位置吧";
                return false;
            }
        }else{
            if($nums>=6){
                $this->error = "该位置置业专家位置已满,试试其他位置吧";
                return false;
            }
        }
        
        if ($this->create($arr)) {
            return true;
        }
        
    }
    
    /**
     * 获取某个位置在线的置业专家个数
     * @param type $buyType
     * @param type $buyId
     * @param type $showType
     * @param type $channel
     * @return type
     */
    public function getNums($buyType,$buyId,$showType,$channel,$beginTime,$endTime){
        $con = "buyType={$buyType} and buyId={$buyId} and showType={$showType} and channel={$channel} and ((endTime>='{$beginTime}' and beginTime <='{$endTime}') or (endTime>= '{$beginTime}' and beginTime <= '{$endTime}'))";
        return self::count($con);
    }

    /**
     * 编辑置业专家
     *
     * @param  int $cityId
     * @param array $arr
     * @return boolean
     */
    public function edit($expertId, $arr) {
        $expertId = intval($expertId);
        $rs = self::findfirst($expertId);
        $arr['cityId'] = intval($arr['cityId']);
        $arr['clientType'] = intval($arr["clientType"]);
        $arr['clientId'] = intval($arr["clientId"]);
        $arr['buyType'] = intval($arr["buyType"]);
        $arr['buyId'] = intval($arr["buyId"]);
        $arr['showType'] = intval($arr["showType"]);
        $arr['channel'] = intval($arr["channel"]);
        $arr['contractNo'] = $arr["contractNo"];
        $arr['beginTime'] = $arr["beginTime"];
        $arr['endTime'] = $arr["endTime"];
        $arr['weight'] = intval($arr["weight"]);
        $arr['updateTime'] = date("Y-m-d H:i:s");
        $nums = $this->getNums($arr['buyType'], $arr['buyId'], $arr['showType'], $arr['channel'],$arr['beginTime'],$arr['endTime']);
        
        /*if($arr['showType']==self::SHOW_REALTOR){
            if($nums>=3){
                $this->error = "该位置置业专家位置已满,试试其他位置吧";
                return false;
            }
        }else{
            if($nums>=6){
                $this->error = "该位置置业专家位置已满,试试其他位置吧";
                return false;
            }
        }*/
        if ($rs->update($arr)) {
            return true;
        }
        foreach ($rs->getMessages() as $message) {
            echo $message;
        }

        return false;
    }
    
    /**
     * 删除置业专家
     */
    public function del($expertId) {
        $rs = self::findfirst($expertId);
        return $rs->delete();
    }

    /**
     * 为公司、门店、经纪人系统中置业专家房源与置业专家头像，列表中购买位置提供链接地址。
     *
     * @return array
     */
    private function _createUrl() {
        static $urls = array();

        if ($urls === array()) {
            $urls = array(
                self::TYPE_DISTRICT => array(
                    self::CHANNEL_SALE => '/sale/{district_pinyin}/',
                    self::CHANNEL_RENT => '/rent/{district_pinyin}/',
                ),
                self::TYPE_AREA => array(
                    self::CHANNEL_SALE => '/sale/{hot_area_pinyin}/',
                    self::CHANNEL_RENT => '/rent/{hot_area_pinyin}/',
                ),
                self::TYPE_LINE => array(
                    self::CHANNEL_SALE => '/sale/sub{subway_line_id}/',
                    self::CHANNEL_RENT => '/rent/sub{subway_line_id}/',
                ),
                self::TYPE_SITE => array(
                    self::CHANNEL_SALE => '/sale/sub{subway_line_id}_{subway_site_id}/',
                    self::CHANNEL_RENT => '/rent/sub{subway_line_id}_{subway_site_id}/',
                ),
                self::TYPE_PARK => array(
                    self::CHANNEL_SALE => '/sale/x{house_id}/',
                    self::CHANNEL_RENT => '/rent/x{house_id}/',
                ),
                self::TYPE_SCHOOL => array(
                    self::CHANNEL_SALE => '/sale/sch{assort_id}_{school_id}/',
                    self::CHANNEL_RENT => '/rent/sch{assort_id}_{school_id}/',
                )
            );
        }
        return $urls;
    }

    /**
     * 扩展公司、门店、经纪人系统中置业专家房源与置业专家头像，购买位置与其链接地址信息。
     *
     * @param array $row
     * @return array
     */
    public function _extendPosition(&$row) {
        $arrAllHotarea = CityRegion::find()->toArray();
        $arrAllDistrict = CityDistrict::find()->toArray();
		$arrTmp = array();
		foreach ( $arrAllHotarea as $hotarea )
		{
			$arrTmp[$hotarea['id']]['pinyin'] = $hotarea['pinyin'];
		}
		$arrAllHotarea = $arrTmp;
		$arrTmp = array();
		foreach ( $arrAllDistrict as $district )
		{
			$arrTmp[$district['id']]['pinyin'] = $district['pinyin'];
		}
		$arrAllDistrict = $arrTmp;

        $urls = $this->_createUrl();

        $tmp = $replace = array();
        switch ($row['buyType']) {
            case self::TYPE_DISTRICT:
                $tmp = CityDistrict::findFirst("id=" . $row['buyId']);
                $row['position'] = $tmp->name;
                $replace = array('{district_pinyin}' => $arrAllDistrict[$tmp->id]['pinyin']);
                break;
            case self::TYPE_AREA:
                $tmp = CityRegion::findFirst("id=" . $row['buyId']);
                $row['position'] = $tmp->name;
                $replace = array('{hot_area_pinyin}' => $arrAllHotarea[$tmp->id]['pinyin']);
                break;
            case self::TYPE_LINE:
                $tmp = Metro::findFirst("id=" . $row['buyId']);
                $row['position'] = $tmp->name;
                $replace = array('{subway_line_id}' => $tmp->id);
                break;
            case self::TYPE_SITE:
                $tmp = MetroStation::findFirst("id=" . $row['buyId']);
                $row['position'] = $tmp->name;
                $replace = array('{subway_line_id}' => $tmp->id, '{subway_site_id}' => $tmp->metroId);
                break;
            case self::TYPE_PARK:
                $tmp = Park::findFirst("id=" . $row['buyId']);
                $row['position'] = $tmp->name;
                $replace = array('{house_id}' => $tmp->id);
                break;
            case self::TYPE_SCHOOL:
                $tmp = School::findFirst("id=" . $row['buyId']);
                $row['position'] = $tmp->name;
                $replace = array('{assort_id}' => $tmp->rank, '{school_id}' => urlencode($tmp->id));
                break;
            default:
                break;
        }

        //新版URL调整比较复杂
//     	if ( $row['buy_type'] == self::TYPE_HOUSE && $row['unit_type'] == self::UNIT_HOUSE && $row['pos'] <= 3 )
//     	{
//     		$row['url'] = FSCity::instance(self::$_site)->domain . strtr($urls[$row['buy_type']][1], $replace);
//     	}
//     	elseif ( $row['buy_type'] == self::TYPE_HOUSE && $row['unit_type'] == self::UNIT_HOUSE && $row['pos'] > 3 )
//     	{
//     		$row['url'] = FSCity::instance(self::$_site)->domain . strtr($urls[$row['buy_type']][2], $replace);
//     	}
//     	elseif (  $row['buy_type'] == self::TYPE_HOUSE )
//     	{
//     		$row['url'] = FSCity::instance(self::$_site)->domain . strtr($urls[$row['buy_type']][$row['unit_type']], $replace);
//     	}
        if ($row['channel'] == self::CHANNEL_SALE) {
            $row['url'] = "http://" . self::$_site . ".esf.focus.cn" . strtr($urls[$row['buyType']][$row['channel']], $replace);
        } elseif ($row['channel'] == self::CHANNEL_RENT) {
            $row['url'] = "http://" . self::$_site . ".zu.focus.cn" . strtr($urls[$row['buyType']][$row['channel']], $replace);
        }
//     	elseif ( $row['unit_type'] == self::UNIT_CLIENT )
//     	{
//     		$row['url'] = $row['pos'] <= 3 ? FSCity::instance(self::$_site)->domain . strtr($urls[$row['buy_type']][$row['unit_type']], $replace) : FSCity::instance(self::$_site)->zu_domain . strtr($urls[$row['buy_type']][$row['unit_type']], $replace);
//     	}

        $this->_extendCount($row);
//     	return $row;
    }

    /**
     * 扩展公司、门店、经纪人系统中置业专家房源与置业专家头像，出售发布房源&租发布房源数量
     *
     * @param array $row
     * @return array
     */
    private function _extendCount(&$row) {
        /*if ($row['clientType'] != self::CLIENT_TYPE_REALTOR) {
            return $row;
        }*/

		if($GLOBALS['client']['ent_type'] == VipAccount::ROLE_COMPANY){
			$conditions = array(
				'comId' => $GLOBALS['client']['comId'],
				'status' => House::STATUS_ONLINE
			);
		} elseif($GLOBALS['client']['ent_type'] == VipAccount::ROLE_SHOP){
			$conditions = array(
				'shopId' => $GLOBALS['client']['shopId'],
				'status' => House::STATUS_ONLINE
			);
		} else {
			$conditions = array(
				'realId' => $GLOBALS['client']['realId'],
				'status' => House::STATUS_ONLINE
			);
		}

        $type = $row['buyType'];
        switch ($type) {
            case self::TYPE_DISTRICT:
                $conditions['distId'] = $row['buyId'];
                break;
            case self::TYPE_AREA:
                $conditions['regId'] = $row['buyId'];
                break;
            case self::TYPE_LINE:
                $conditions['subwayLine'] = array("like" => "{$row['position']}");
                break;
            case self::TYPE_SITE:
                $conditions['subwaySite'] = array("like" => "{$row['position']}");
                break;
            case self::TYPE_PARK:
                $conditions['parkId'] = (int) $row['buyId'];
                break;
            case self::TYPE_SCHOOL:
                $conditions['parkAroundSchool'] = array("like" => "{$row['position']}");
                break;
            default:
                break;
        }

        global $sysES;
        $params = $sysES['default'];
        $params['index'] = 'esf';
        $params['type'] = 'house';
        $client = new Es($params);

        //出售
        $conditions['houseRoleType'] = House::ROLE_REALTOR;
        $conditions['houseType'] = array('in'=> array(House::TYPE_ERSHOU,House::TYPE_XINFANG,House::TYPE_CIXIN));
        $searchParam['where'] = $conditions;
        $arrSaleData = $client->search($searchParam);
        $row['sale_count'] = $arrSaleData['total'];
       
        //出租
        unset($conditions['houseRoleType']);
        $conditions['houseType'] = array('in'=>array(House::TYPE_ZHENGZU,House::TYPE_HEZU)) ;
        $searchParam['where'] = $conditions;
        $arrRentData = $client->search($searchParam);
        $row['rent_count'] = $arrRentData['total'];

        return $row;
    }

}
