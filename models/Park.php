<?php

/**
 * @abstract 小区基础model(删除所有属性park前缀)
 * @author Eirc xuminwan@sohu-inc.com
 *
 */
class Park extends BaseModel {

    public $id;
    public $regId;
    public $distId;
    public $cityId;
    public $name;
    public $alias;
    public $pinyin;
    public $pinyinAbbr;
    public $address;
    public $postcode = '';
    public $X;
    public $Y;
    public $BdX = 0;
    public $BdY = 0;
    public $type;
    public $buildType = 0;
    public $buildYear;
    public $landArea;
    public $GFA;
    public $FAR;
    public $GR;
    public $RR = '';
    public $buildings = 0;
    public $houses;
    public $pCount;
    public $pFix = 0;
    public $fee;
    public $tags = '';
    public $picId = 0;
    public $status = self::STATUS_VALID;
    public $saleCount = 0;
    public $saleValid = 0;
    public $update;
    public $picExt = '';
    public $rentCount = 0;
    public $rentValid = 0;
    public $salePrice = 0;
    public $salePriceIncrease = 0;
    public $source = self::SOURCE_SECONDARY_PARK;
    public $allowWgPhoto = self::ALLOW_WAIGUAN_YES;
    public $allowHxPhoto = self::ALLOW_HUXING_YES;

    //小区来源
    const SOURCE_NEW_PARK = 1;       //新房小区
    const SOURCE_SECONDARY_PARK = 2; //二手房小区
    //数据状态  status
    const STATUS_VALID = 1;
    const STATUS_INVALID = 0;
    const STATUS_DELETE = -1;
    //是否允许经纪人上传外观图
    const ALLOW_WAIGUAN_YES = 1;   //允许
    const ALLOW_WAIGUAN_NO = 2;   //不允许
    //是否允许经纪人上传户型图
    const ALLOW_HUXING_YES = 1; //允许
    const ALLOW_HUXING_NO = 2; //不允许

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if (preg_match('/^\d{1,10}$/', $id == 0) || $id > 4294967295) {
            return false;
        }
        $this->id = $id;
    }

    public function getRegId() {
        return $this->regId;
    }

    public function setRegId($regId) {
        if (preg_match('/^\d{1,10}$/', $regId == 0) || $regId > 4294967295) {
            return false;
        }
        $this->regId = $regId;
    }

    public function getDistId() {
        return $this->distId;
    }

    public function setDistId($distId) {
        if (preg_match('/^\d{1,10}$/', $distId == 0) || $distId > 4294967295) {
            return false;
        }
        $this->distId = $distId;
    }

    public function getCityId() {
        return $this->cityId;
    }

    public function setCityId($cityId) {
        if (preg_match('/^\d{1,10}$/', $cityId == 0) || $cityId > 4294967295) {
            return false;
        }
        $this->cityId = $cityId;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        if ($name == '' || mb_strlen($name, 'utf8') > 50) {
            return false;
        }
        $this->name = $name;
    }

    public function getAlias() {
        return $this->alias;
    }

    public function setAlias($alias) {
        if ($alias == '' || mb_strlen($alias, 'utf8') > 150) {
            return false;
        }
        $this->alias = $alias;
    }

    public function getPinyin() {
        return $this->pinyin;
    }

    public function setPinyin($pinyin) {
        if ($pinyin == '' || mb_strlen($pinyin, 'utf8') > 50) {
            return false;
        }
        $this->pinyin = $pinyin;
    }

    public function getPinyinAbbr() {
        return $this->pinyinAbbr;
    }

    public function setPinyinAbbr($pinyinAbbr) {
        if ($pinyinAbbr == '' || mb_strlen($pinyinAbbr, 'utf8') > 50) {
            return false;
        }
        $this->pinyinAbbr = $pinyinAbbr;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        if ($address == '' || mb_strlen($address, 'utf8') > 50) {
            return false;
        }
        $this->address = $address;
    }

    public function getPostcode() {
        return $this->postcode;
    }

    public function setPostcode($postcode) {
        if ($postcode == '' || mb_strlen($postcode, 'utf8') > 6) {
            return false;
        }
        $this->postcode = $postcode;
    }

    public function getX() {
        return $this->X;
    }

    public function setX($X) {
        if ($X == '' || mb_strlen($X, 'utf8') > 50) {
            return false;
        }
        $this->X = $X;
    }

    public function getY() {
        return $this->Y;
    }

    public function setY($Y) {
        if ($Y == '' || mb_strlen($Y, 'utf8') > 50) {
            return false;
        }
        $this->Y = $Y;
    }

    public function getLonLat() {
        return $this->lonLat;
    }

    public function setLonLat($lonLat) {
        if ($lonLat == '' || mb_strlen(lonLat, 'utf8') > 30) {
            return false;
        }
        $this->lonLat = $lonLat;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        if (preg_match('/^\d{1,3}$/', $type == 0) || $type > 255) {
            return false;
        }
        $this->type = $type;
    }

    public function getBuildType() {
        return $this->buildType;
    }

    public function setBuildType($buildType) {
        if (preg_match('/^\d{1,3}$/', $buildType == 0) || $buildType > 255) {
            return false;
        }
        $this->buildType = $buildType;
    }

    public function getBuildYear() {
        return $this->buildYear;
    }

    public function setBuildYear($buildYear) {
        $this->buildYear = $buildYear;
    }

    public function getLandArea() {
        return $this->landArea;
    }

    public function setParkLandArea($landArea) {
        if ($landArea == '' || mb_strlen($landArea, 'utf8') > 20) {
            return false;
        }
        $this->landArea = $landArea;
    }

    public function getGFA() {
        return $this->GFA;
    }

    public function setGFA($GFA) {
        if ($GFA == '' || mb_strlen($GFA, 'utf8') > 20) {
            return false;
        }
        $this->GFA = $GFA;
    }

    public function getFAR() {
        return $this->FAR;
    }

    public function setFAR($FAR) {
        if ($FAR == '' || mb_strlen($FAR, 'utf8') > 20) {
            return false;
        }
        $this->FAR = $FAR;
    }

    public function getGR() {
        return $this->GR;
    }

    public function setGR($GR) {
        if ($GR == '' || mb_strlen($GR, 'utf8') > 20) {
            return false;
        }
        $this->GR = $GR;
    }

    public function getRR() {
        return $this->RR;
    }

    public function setRR($RR) {
        if ($RR == '' || mb_strlen($RR, 'utf8') > 20) {
            return false;
        }
        $this->RR = $RR;
    }

    public function getBuildings() {
        return $this->buildings;
    }

    public function setBuildings($buildings) {
        if (preg_match('/^\d{1,5}$/', $buildings == 0) || $buildings > 65535) {
            return false;
        }
        $this->buildings = $buildings;
    }

    public function getHouses() {
        return $this->houses;
    }

    public function setHouses($houses) {
        if (preg_match('/^\d{1,5}$/', $houses == 0) || $houses > 65535) {
            return false;
        }
        $this->houses = $houses;
    }

    public function getPCount() {
        return $this->pCount;
    }

    public function setParkPCount($pCount) {
        if (preg_match('/^\d{1,5}$/', $pCount == 0) || $pCount > 65535) {
            return false;
        }
        $this->pCount = $pCount;
    }

    public function getPFix() {
        return $this->pFix;
    }

    public function setParkPFix($pFix) {
        if (preg_match('/^\d{1,5}$/', $pFix == 0) || $pFix > 65535) {
            return false;
        }
        $this->pFix = $pFix;
    }

    public function getFee() {
        return $this->fee;
    }

    public function setFee($fee) {
        if ($fee == '' || mb_strlen($fee, 'utf8') > 20) {
            return false;
        }
        $this->fee = $fee;
    }

    public function getTags() {
        return $this->tags;
    }

    public function setTags($tags) {
        if ($tags == '' || mb_strlen($tags, 'utf8') > 100) {
            return false;
        }
        $this->tags = $tags;
    }

    public function getPicId() {
        return $this->picId;
    }

    public function setPicId($picId) {
        if (preg_match('/^\d{1,10}$/', $picId == 0) || $picId > 4294967295) {
            return false;
        }
        $this->picId = $picId;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        if (preg_match('/^-?\d{1,3}$/', $status) == 0 || $status > 127 || $status < -128) {
            return false;
        }
        $this->status = $status;
    }

    public function getUpdate() {
        return $this->update;
    }

    public function setUpdate($update) {
        if (preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $update) == 0 || strtotime($update) == false) {
            return false;
        }
        $this->update = $update;
    }

    public function getSaleCount() {
        return $this->saleCount;
    }

    public function setSaleCount($saleCount) {
        if (preg_match('/^\d{1,10}$/', $saleCount == 0) || $saleCount > 4294967295) {
            return false;
        }
        $this->saleCount = $saleCount;
    }

    public function getSaleValid() {
        return $this->saleValid;
    }

    public function setSaleValid($saleValid) {
        if (preg_match('/^\d{1,10}$/', $saleValid == 0) || $saleValid > 4294967295) {
            return false;
        }
        $this->saleValid = $saleValid;
    }

    public function getPicExt() {
        return $this->picExt;
    }

    public function setPicExt($picExt) {
        if ($picExt == '' || mb_strlen($picExt, 'utf8') > 20) {
            return false;
        }
        $this->picExt = $picExt;
    }

    public function setRentCount($rentCount) {
        $this->rentCount = $rentCount;
    }

    public function getRentCount() {
        return $this->rentCount;
    }

    public function setRentValid($rentValid) {
        $this->rentValid = $rentValid;
    }

    public function getRentValid() {
        return $this->rentValid;
    }

    public function getSalePrice() {
        return $this->salePrice;
    }

    public function setSalePrice($SalePrice) {
        $this->salePrice = $SalePrice;
    }

    public function getSource() {
        return 'park';
    }

    /**
     * 获取所有小区来源
     * @return array
     */
    public static function getSourceTypes() {
        return array(
            self::SOURCE_NEW_PARK => '新房',
            self::SOURCE_SECONDARY_PARK => '二手房'
        );
    }

    /**
     * 新增小区
     * @param array $data
     * @return array
     */
    public function add($data) {
        if (empty($data)) {
            return array('status' => 1, 'info' => '参数为空！');
        }
        if ($this->isExistParkName($data["name"], $data["cityId"])) {
            return array('status' => 1, 'info' => '小区名称已经存在！');
        }

        $clsPinYin = new HanZiToPinYin();
        $pinyinShort = $clsPinYin->getPinYin(trim($data["name"]));
        $bxy = BaiduMap::instance()->getLonLat($data['X'], $data['Y']);

        $this->cityId = $data["cityId"];
        $this->distId = $data["distId"];
        $this->regId = $data["regId"];
        $this->name = $data["name"];
        $this->pinyin = $pinyinShort['full'];
        $this->pinyinAbbr = $pinyinShort['short'];
        $this->alias = $data['alias'];
        $this->fee = $data['fee'];
        $this->address = $data['address'];
        $this->type = $data['type'];
        $this->salePrice = $data['avgPrice'];
        $this->buildYear = $data['buildYear'];
        $this->GR = $data['greenRate'];
        $this->X = $data['X'];
        $this->Y = $data['Y'];
        $this->BdX = $bxy['x'];
        $this->BdY = $bxy['y'];
        $this->landArea = $data['landArea'];
        $this->GFA = $data['grossFloorArea'];
        $this->FAR = $data['floorAreaRate'];
        $this->houses = $data['houses'];
        $this->pCount = $data['pCount'];
        $this->update = date("Y-m-d H:i:s");
        $this->source = $data['source'];

        $this->begin();
        if ($this->create()) {
            $extData = $moreData = array();
            $data['周边公交'] && $moreData['周边公交'] = $data['周边公交'];
            $data['周边设施'] && $moreData['周边设施'] = $data['周边设施'];
            $data['内部设施'] && $moreData['内部设施'] = $data['内部设施'];
            $data['小区设施'] && $moreData['小区设施'] = $data['小区设施'];
            if (!empty($moreData)) {
                //添加扩展信息
                $moreInsertRet = $this->saveParkMore($this->id, $moreData);
                if (!$moreInsertRet) {
                    $this->rollback();
                    return array('status' => 1, 'info' => '添加小区失败！');
                }
            }

            if ($data['projId'] > 0 || $data['groupId'] > 0) {
                $bbsRes = $this->saveParkBbs($this->id, $data['projId'], $data['groupId']);
                if (!$bbsRes) {
                    $this->rollback();
                    return array('status' => 1, 'info' => '添加小区失败！');
                }
            }
            $arr = array(
                "cityId" => $this->cityId,
                "distId" => $this->distId,
                "regId" => $this->regId,
                "parkBuildType" => 0,
                "parkBuildYear" => $this->buildYear,
                "parkSalePrice" => $this->salePrice,
                "parkX" => $this->X,
                "parkY" => $this->Y,
                "parkHouseValidSum" => 0,
                "parkRentHouseValidSum" => 0,
                "parkName" => $this->name,
                "parkAlias" => $this->alias,
                "parkPinyin" => $this->pinyin,
                "parkPinyinAbbr" => $this->pinyinAbbr,
                "parkAddress" => $this->address,
                "parkSubwaySite" => '',
                "parkSubwayLine" => '',
                "parkSubwaySiteLine" => '',
                "parkAroundSchool" => '',
                "parkStatus" => $this->status,
                'parkId' => $this->id,
                'id' => $this->id,
            );
            $metroInfo = $this->getParkMetrInfo($this->cityId, $this->id, $this->X, $this->Y);
            if(!empty($metroInfo))
            {
                $arr['parkSubywaySite'] = $metroInfo['linestation'];
                $arr['parkSubwayLine'] = $metroInfo['line'];
                $arr['parkSubwaySiteLine'] = $metroInfo['station'];
            }
            global $sysES;
            $configs = array('hosts' => $sysES['default']['hosts'], 'index' => 'esf', 'type' => 'park');
            $esRes = Es::instance($configs)->insert($arr);

            $data['物业公司'] && $extData['物业公司'] = $data['物业公司'];
            $data['物业电话'] && $extData['物业电话'] = $data['物业电话'];
            $data['开发商'] && $extData['开发商'] = $data['开发商'];
            $data['开盘时间'] && $extData['开盘时间'] = $data['开盘时间'];
            $data['入住时间'] && $extData['入住时间'] = $data['入住时间'];
            $data['预售许可证'] && $extData['预售许可证'] = $data['预售许可证'];
            $data['产权年限'] && $extData['产权年限'] = $data['产权年限'];
            $data['400电话'] && $extData['400电话'] = $data['400电话'];

            if (!empty($extData)) {
                //添加扩展信息
                $extInsertRet = $this->saveParkExt($this->id, $extData);
                if (!$extInsertRet) {
                    $this->rollback();
                    return array('status' => 1, 'info' => '添加小区失败！');
                }
            }
            $this->commit();
            $zebRes = $this->_addZebParkNum($this->id);
            return array('status' => 0, 'info' => '添加小区成功！', 'id' => $this->id);
        }
        $this->rollback();
        return array('status' => 1, 'info' => '添加小区失败！');
    }

    /**
     * 保存 parkbbs 相关信息
     * @param int $parkId
     * @param int $projId
     * @param int $groupId
     * @return boolean
     */
    public function saveParkBbs($parkId, $projId, $groupId) {
        $rs = ParkBbs::findFirst("parkId={$parkId}");
        if ($rs) {
            //已存在
            $rs->projId = $projId;
            $rs->groupId = $groupId;
            $rs->status = ParkBbs::STATUS_VALID;
            $rs->update = date('Y-m-d H:i:s');

            if ($rs->update()) {
                return true;
            }
            return false;
        } else {
            $rs = ParkBbs::instance();
            $rs->projId = $projId;
            $rs->parkId = $parkId;
            $rs->groupId = $groupId;
            $rs->status = ParkBbs::STATUS_VALID;
            $rs->update = date('Y-m-d H:i:s');

            if ($rs->create()) {
                return true;
            }
            return false;
        }
    }

    /**
     * 修改小区
     * @param array $data
     * @return array
     */
    public function edit($parkId, $data) {


        $parkId = intval($parkId);

        if (empty($data) || !$parkId) {
            return array('status' => 1, 'info' => '参数为空！');
        }

        if ($this->isExistParkName($data["name"], $data["cityId"], $parkId)) {

            return array('status' => 1, 'info' => '小区名称已经存在！');
        }

        $clsPinYin = new HanZiToPinYin();
        $pinyinShort = $clsPinYin->getPinYin(trim($data["name"]));
        $bxy = BaiduMap::instance()->getLonLat($data['X'], $data['Y']);

        $rs = self::findFirst($parkId);
        $rs->cityId = $data["cityId"];
        $rs->distId = $data["distId"];
        $rs->regId = $data["regId"];
        $rs->name = $data["name"];
        $rs->pinyin = $pinyinShort['full'];
        $rs->pinyinAbbr = $pinyinShort['short'];
        $rs->alias = $data['alias'];
        $rs->fee = $data['fee'];
        $rs->address = $data['address'];
        $rs->type = $data['type'];
        $rs->salePrice = empty($data['avgPrice']) ? 0 : $data['avgPrice'];
        $rs->buildYear = $data['buildYear'];
        $rs->GR = $data['greenRate'];
        $rs->X = $data['X'];
        $rs->Y = $data['Y'];
        $rs->BdX = empty($bxy['x']) ? 0 : $bxy['x'];
        $rs->BdY = empty($bxy['y']) ? 0 : $bxy['y'];
        $rs->landArea = $data['landArea'];
        $rs->GFA = $data['grossFloorArea'];
        $rs->FAR = $data['floorAreaRate'];
        $rs->houses = $data['houses'];
        $rs->pCount = $data['pCount'];
        $rs->update = date("Y-m-d H:i:s");

        $this->begin();
        if ($rs->update()) {
            $arr = array(
                "id" => $rs->id,
                "data" => array(
                    "cityId" => $rs->cityId,
                    "distId" => $rs->distId,
                    "regId" => $rs->regId,
                    "parkX" => $rs->X,
                    "parkY" => $rs->Y,
                    "parkName" => $rs->name,
                    "parkAlias" => $rs->alias,
                    "parkPinyin" => $rs->pinyin,
                    "parkPinyinAbbr" => $rs->pinyinAbbr,
                    "parkAddress" => $rs->address,
                    "parkStatus" => $rs->status,
                    'parkId' => $rs->id,
                    'parkBuildType' => $rs->buildType,
                    'parkBuildYear' => $rs->buildYear,
                    'parkGR' => $rs->GR,
                    'parkFAR' => $rs->FAR,
                    'parkSalePrice' => $rs->salePrice,
                )
            );
            //小区地铁站点信息
            $metroInfo = $this->getParkMetrInfo($rs->cityId, $rs->id, $rs->X, $rs->Y);
            if(!empty($metroInfo))
            {
                $arr['data']['parkSubwaySite'] = $metroInfo['linestation'];
                $arr['data']['parkSubwayLine'] = $metroInfo['line'];
                $arr['data']['parkSubwaySiteLine'] = $metroInfo['station'];
            }
            global $sysES;
            $configs = array('hosts' => $sysES['default']['hosts'], 'index' => 'esf', 'type' => 'park');
            $res = Es::instance($configs)->update($arr);

            $extData = $moreData = array();
            $data['周边公交'] && $moreData['周边公交'] = $data['周边公交'];
            $data['周边设施'] && $moreData['周边设施'] = $data['周边设施'];
            $data['内部设施'] && $moreData['内部设施'] = $data['内部设施'];
            $data['小区设施'] && $moreData['小区设施'] = $data['小区设施'];

            if (!empty($moreData)) {
                //添加扩展信息
                $moreInsertRet = $this->saveParkMore($rs->id, $moreData);
                if (!$moreInsertRet) {
                    $this->rollback();
                    return array('status' => 1, 'info' => '修改小区失败！');
                }
            }

            if ($data['projId'] > 0 || $data['groupId'] > 0) {
                $bbsRes = $this->saveParkBbs($rs->id, $data['projId'], $data['groupId']);
                if (!$bbsRes) {
                    $this->rollback();
                    return array('status' => 1, 'info' => '修改小区失败！');
                }
            }

            $data['物业电话'] && $extData['物业电话'] = $data['物业电话'];
            $data['物业公司'] && $extData['物业公司'] = $data['物业公司'];
            $data['开发商'] && $extData['开发商'] = $data['开发商'];
            $data['物业费'] && $extData['物业费'] = $data['物业费'];
            $data['车位信息'] && $extData['车位信息'] = $data['车位信息'];
            $data['小区设施'] && $extData['小区设施'] = $data['小区设施'];
            $data['老人占比'] && $extData['老人占比'] = $data['老人占比'];
            $data['出租占比'] && $extData['出租占比'] = $data['出租占比'];
            $data['开盘时间'] && $extData['开盘时间'] = $data['开盘时间'];
            $data['入住时间'] && $extData['入住时间'] = $data['入住时间'];
            $data['预售许可证'] && $extData['预售许可证'] = $data['预售许可证'];
            $data['产权年限'] && $extData['产权年限'] = $data['产权年限'];
            $data['400电话'] && $extData['400电话'] = $data['400电话'];

            if (!empty($extData)) {
                //添加扩展信息
                $extInsertRet = $this->saveParkExt($rs->id, $extData);

                if (!$extInsertRet) {
                    $this->rollback();
                    return array('status' => 1, 'info' => '修改小区失败！');
                }
            }

            $this->commit();

            return array('status' => 0, 'info' => '修改小区成功！');
        }
        $this->rollback();
        return array('status' => 1, 'info' => '修改小区失败！');
    }

    /**
     * 保存小区扩展信息
     * @param type $parkId
     * @param type $data
     */
    private function saveParkExt($parkId, $data) {
        $parkId = intval($parkId);
        if (!$parkId || empty($data)) {
            return false;
        }

        foreach ($data as $k => $v) {
            $isExist = ParkExt::instance()->isExistExt($parkId, $k);

            if (false === $isExist) {
                //如果不存在，则新增
                $insertRet = ParkExt::instance()->add($parkId, array("name" => $k, "value" => $v));
                if (!$insertRet)
                    return false;
            }
            else {
                //如果存在，则修改
                if (true === $isExist)
                    return false;
                $updateRet = ParkExt::instance()->edit($isExist, array("name" => $k, "value" => $v));
                if (!$updateRet)
                    return false;
            }
        }

        return true;
    }

    /**
     * 保存小区描述信息
     * @param type $parkId
     * @param type $data
     */
    private function saveParkMore($parkId, $data) {
        $parkId = intval($parkId);
        if (!$parkId || empty($data)) {
            return false;
        }

        foreach ($data as $k => $v) {
            $isExist = ParkMore::instance()->isExistMore($parkId, $k);

            if (false === $isExist) {
                //如果不存在，则新增
                $insertRet = ParkMore::instance()->add($parkId, array("name" => $k, "value" => $v));
                if (!$insertRet)
                    return false;
            }
            else {
                //如果存在，则修改
                if (true === $isExist)
                    return false;
                $updateRet = ParkMore::instance()->edit($isExist, array("name" => $k, "value" => $v));
                if (!$updateRet)
                    return false;
            }
        }

        return true;
    }

    private function isExistParkName($parkName, $cityId, $parkId = 0) {
        $parkName = trim($parkName);
        if (empty($parkName)) {
            return true;
        }
        $con['conditions'] = "name='{$parkName}' and cityId={$cityId} and status=" . self::STATUS_VALID;
        $parkId > 0 && $con['conditions'] .= " and id<>{$parkId}";

        $intCount = self::count($con);
        if ($intCount > 0) {
            return true;
        }
        return false;
    }

    /**
     * 删除单条记录
     *
     * @param int $parkId
     * @return boolean
     */
    public function del($parkId) {
        $rs = self::findFirst("id=" . $parkId);
        $rs->status = self::STATUS_DELETE;

        $houseObj = new House();
        $houseNum = $houseObj->getTotalByParkId($parkId);

        if (intval($houseNum) > 0) {
            return array("status" => 1, "info" => "该小区下有房源，不能删除");
        }

        $this->begin();
        if ($rs->update()) {
            $delMore = ParkMore::instance()->del($parkId);
            if (!$delMore) {
                $this->rollback();
                return array("status" => 1, "info" => "删除失败!");
            }
            $delExt = ParkExt::instance()->del($parkId);
            if (!$delExt) {
                $this->rollback();
                return array("status" => 1, "info" => "删除失败!");
            }
            $delBbs = ParkBbs::instance()->del($parkId);
            if (!$delBbs) {
                $this->rollback();
                return array("status" => 1, "info" => "删除失败!");
            }
            $this->commit();
            return array("status" => 0, "info" => "删除成功!", 'name' => $rs->name);
        }
        $this->rollback();
        return array("status" => 1, "info" => "删除失败!");
    }

    public function columnMap() {
        return array(
            'parkId' => 'id',
            'regId' => 'regId',
            'distId' => 'distId',
            'cityId' => 'cityId',
            'parkName' => 'name',
            'parkAlias' => 'alias',
            'parkPinyin' => 'pinyin',
            'parkPinyinAbbr' => 'pinyinAbbr',
            'parkAddress' => 'address',
            'parkPostcode' => 'postcode',
            'parkX' => 'X',
            'parkY' => 'Y',
            'parkBX' => 'BdX', //请不要随便改动
            'parkBY' => 'BdY', //请不要随便改动
            'parkLonLat' => 'lonLat',
            'parkType' => 'type',
            'parkBuildType' => 'buildType',
            'parkBuildYear' => 'buildYear',
            'parkLandArea' => 'landArea',
            'parkGFA' => 'GFA',
            'parkFAR' => 'FAR',
            'parkGR' => 'GR',
            'parkRR' => 'RR',
            'parkBuildings' => 'buildings',
            'parkHouses' => 'houses',
            'parkPCount' => 'pCount',
            'parkPFix' => 'pFix',
            'parkFee' => 'fee',
            'parkTags' => 'tags',
            'parkPicId' => 'picId',
            'parkStatus' => 'status',
            'parkUpdate' => 'update',
            'parkSaleValid' => 'saleValid',
            'parkSaleCount' => 'saleCount',
            'parkPicExt' => 'picExt',
            'parkRentCount' => 'rentCount',
            'parkRentValid' => 'rentValid',
            'parkSalePrice' => 'salePrice',
            'parkSalePriceIncrease' => 'salePriceIncrease',
            'parkSource' => 'source',
            'parkAllowWgPhoto' => 'allowWgPhoto',
            'parkAllowHxPhoto' => 'allowHxPhoto'
        );
    }

    public function initialize() {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }

    /**
     * 实例化
     * @param type $cache
     * @return Park_Model
     */
    public static function instance($cache = true) {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }

    /**
     * 获取小区配置信息
     */
    public function getParkConfig($intCityID) {
        $arrBackData = $arrHouse = array();

        //获取指定城市所有小区信息
        $objRes = self::find("cityId = {$intCityID} AND status = " . self::STATUS_VALID);

        $arrHouse = $objRes->toArray();

        //获取指定城市所有板块信息
        $oCityDistrict = new CityDistrict();
        $arrDistrict = $oCityDistrict->getDistrict($intCityID);

        if (!empty($arrHouse)) {
            foreach ($arrHouse as $v) {
                if (isset($arrDistrict[$v['distId']]))
                    $arrBackData[$v['name'] . '_' . Util::FormatDistrict($arrDistrict[$v['distId']])] = $v['id'];
                if (!empty($v['alias']))
                    $arrBackData[$v['alias'] . '_' . Util::FormatDistrict($arrDistrict[$v['distId']])] = $v['id'];
            }
        }
        return $arrBackData;
    }

    /**
     * 根据小区ID获取小区的详细信息
     */
    public function getParkById($intParkID) {
        $arrCond = "id = ?1 ";
        $arrParam = array(1 => $intParkID);
        $arrPark = self::findFirst(array(
                    $arrCond,
                    "bind" => $arrParam
        ));
        if ($arrPark) {
            return $arrPark->toArray();
        } else {
            return false;
        }
    }

    /**
     * @abstract 根据小区ID批量获取小区信息
     * @author Eric xuminwan@sohu-inc.com
     * @param array $ids
     * @return array|bool
     *
     */
    public function getParkByIds($ids, $order = '') {
        if (!$ids)
            return false;
        if (is_array($ids)) {
            $arrBind = $this->bindManyParams($ids);
            $arrCond = "id in({$arrBind['cond']}) and status = 1";
            $arrParam = $arrBind['param'];
            $arrPark = self::find(array(
                        $arrCond,
                        "bind" => $arrParam,
                        "order" => $order,
                            ), 0)->toArray();
            if ($arrPark) {
                $distInfo = CDist::getForConfig($GLOBALS['CITY_ID']);
                $regInfo = CRegion::getForConfig($GLOBALS['CITY_ID']);
                foreach ($arrPark as &$park) {
                    $park['distName'] = isset($distInfo[$park['distId']]) ? $distInfo[$park['distId']]['name'] : '';
                    $park['distPinyin'] = isset($distInfo[$park['distId']]) ? $distInfo[$park['distId']]['pinyin'] : '';
                }
                unset($park);
            }
            return $arrPark;
        } else {
            return $this->getParkById($ids);
        }
    }

    /**
     * 根据小区ID和房源状态更新小区下房源数量
     * @param unknown $intParkID
     * @param unknown $intHouseStatus
     */
    public function modifyParkHouseNumberById($arrData, $strOpType = 'add') {
        if (empty($arrData))
            return false;
        if ($arrData['parkId'] == 0)
            return false;
        $arrUpdate = array();
        $objPark = self::findFirst("id = " . $arrData['parkId']);

        if ($strOpType == 'add') {
            if ($arrData['houseType'] == House::TYPE_ERSHOU) {
                $arrUpdate['saleCount'] = $objPark->saleCount + 1;
                if ($arrData['status'] == House::STATUS_ONLINE)
                    $arrUpdate['saleValid'] = $objPark->saleValid + 1;
            }
            else {
                $arrUpdate['rentCount'] = $objPark->rentCount + 1;
                if ($arrData['status'] == House::STATUS_ONLINE)
                    $arrUpdate['rentValid'] = $objPark->rentValid + 1;
            }
        }
        else {
            if ($arrData['houseType'] == House::TYPE_ERSHOU) {
                $arrUpdate['saleCount'] = $objPark->saleCount > 1 ? $objPark->saleCount - 1 : 0;
                if ($arrData['status'] == House::STATUS_ONLINE)
                    $arrUpdate['saleValid'] = $objPark->saleValid > 1 ? $objPark->saleValid - 1 : 0;
            }
            else {
                $arrUpdate['rentCount'] = $objPark->rentCount > 1 ? $objPark->rentCount - 1 : 0;
                if ($arrData['status'] == House::STATUS_ONLINE)
                    $arrUpdate['rentValid'] = $objPark->rentValid > 1 ? $objPark->rentValid - 1 : 0;
            }
        }
        try {
            return $objPark->update($arrUpdate);
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    /**
     * @abstract 根据条件获取最近3天的最多刷新小区
     * @author Eric xuminwan@sohu-inc.com
     * @param array $condition
     * @param int $length
     * @param int $limit
     */
    public function getParkRefresh3Days($condition, $length, $limit = 20) {
        if (!$condition)
            return false;
        $strCondition = 'time<=' . strtotime(date("Y-m-d") . "-1 days") . ' and time>=' . strtotime(date("Y-m-d") . "-3 days");
        $arCon = array();
        if (isset($condition['cityId']) && $condition['cityId']) {
            $strCondition .= " and cityId=" . $condition['cityId'];
            $arCon['cityId'] = $condition['cityId'];
        }
        if (isset($condition['distId']) && $condition['distId']) {
            if (is_array($condition['distId'])) {
                $strCondition .= " and distId in(" . join(',', $condition['distId']) . ')';
            } else {
                $strCondition .= " and distId=" . $condition['distId'];
            }
            $arCon['distId'] = $condition['distId'];
        }
        //$sql .= $sql_where. " group by a.house_id order by count(0) desc limit $limit";
        //需要先获取modelsManager才能获取这个服务,注意在modelsManager中是没有指定model的，需要通过from指定model
        $objHouseRefreshLog = new HouseRefreshLog();
        $arrCondition['conditions'] = $strCondition;
        $arrCondition['columns'] = 'parkId';
        $arrCondition['limit'] = $limit;
        $arrCondition['group'] = "parkId";
        $arrCondition['order'] = 'sum(refreshSum) desc';
        $arrParkId = $objHouseRefreshLog::find($arrCondition,0)->toArray();

//        $arrParkId = $this->getDI()->get('modelsManager')->createBuilder()->from('Park')
//                ->columns('Park.id')
//                ->leftJoin('RefreshLog', 'rl.parkId = Park.id', 'rl')
//                ->where($strCondition)
//                ->groupBy('Park.id')
//                ->orderBy('count(0) desc')
//                ->limit($limit)
//                ->getQuery()
//                ->execute()
//                ->toArray();
        if (count($arrParkId) < $length) {
            $strCondition = '';
            foreach ($arCon as $arKey => $arValue) {
                if ($arKey == 'distId' && is_array($arValue)) {
                    $strCondition .= " Park.distId in(" . join(',', $condition['distId']) . ') and ';
                } else {
                    $strCondition .= "{$arKey}={$arValue} and ";
                }
            }
            $besideIds = array();
            if (count($arrParkId)) {
                foreach ($arrParkId as $value) {
                    $besideIds[] = $value['parkId'];
                }
            }
            if ($besideIds) {
                //not in的方式
                $strBesideIds = implode(',', $besideIds);
                $strCondition .= "id not in({$strBesideIds}) and ";
            }
            $strCondition = rtrim($strCondition, 'and ');
            $arParkId = self::find(array(
                        $strCondition,
                        "columns" => "id as parkId",
                        "order" => "saleValid desc",
                        "limit" => $length - count($arrParkId),
                            ), 0)->toArray();
            if ($arParkId) {
                $data = array_merge($arrParkId, $arParkId);
            }
        } else {
            $data = $arrParkId;
        }
        return $data;
    }

    /**
     * @abstract 获取版块下涨跌排行前五的小区
     * @author Eric xuminwan@sohu-inc.com
     * @param int $regId
     * @return array
     *
     */
    public function getParkOrderByRegId($regId) {
        if (!$regId)
            return array();
        $arrCon = array();
        $arrCon['columns'] = "id,name,salePrice,regId,salePriceIncrease";
        $arrCon['conditions'] = "saleValid > 0 and status = 1 and regId = {$regId}";
        $arrCon['order'] = "ABS(salePriceIncrease) DESC";
        $arrCon['limit'] = 5;
        $arrPark = self::find($arrCon, 0)->toArray();
        return $arrPark;
    }

    /**
     * @abstract 获取版块下的小区总数
     * @author Eric xuminwan@sohu-inc.com
     * @param int $intRegId
     * @return array();
     *
     */
    public function getParkCountByRegId($intRegId) {
        if (!$intRegId)
            return array();
        $strCon = "regId = ?1 and status = 1";
        $arrParam = array(1 => $intRegId);
        $columns = "count(id) as parkCount";
        $parkInfo = self::find(array(
                    $strCon,
                    'columns' => $columns,
                    'bind' => $arrParam,
                        ), 0)->toArray();

        return $parkInfo;
    }

    /**
     * 根据CITY_ID获取所有指定字段的小区信息，缓存memcache，用于智能提示输入
     *
     * @param int $city_id
     * @return array
     */
    public function getAllParkInfo($city_id = 0) {
        $arrBackData = array();
        if (empty($city_id)) {
            return $arrBackData;
        }
        $key = MCDefine::SUGGEST_PARK_BY_CITY_ID_KEY . $city_id;
        $arrBackData = Mem::Instance()->Get($key);

        if (empty($arrBackData)) {
            $cityId = $city_id ? $city_id : $GLOBALS['CITY_ID'];
            $arrCondition['conditions'] = 'cityId=' . $cityId . " and status=" . self::STATUS_VALID;
            $arrCondition['order'] = 'name asc';

            $arrParkInfo = self::find($arrCondition, 0);
            $arrParkInfo = empty($arrParkInfo) ? array() : $arrParkInfo->toArray();
            if (!empty($arrParkInfo)) {
                foreach ($arrParkInfo as $park) {
                    $arrBackData[$park['id']] = $park;
                }
                Mem::Instance()->Set($key, $arrBackData, 86400);
            }
        }
        return $arrBackData;
    }

    /**
     * @abstract 获取和焦点对应的小区ID
     * @author Eric xuminwan@sohu-inc.com
     * @param string $strCondition
     * @return array
     *
     */
    public function getParkGroupId($strCondition) {
        if (!$strCondition)
            return array();
        $columns = 'pb.groupId,Park.id';
        $parkGroup = self::query()
                ->columns($columns)
                ->where($strCondition)
                ->leftJoin('parkBbs', 'pb.parkId = Park.id', 'pb')
                ->execute();
        if ($parkGroup) {
            return $parkGroup->toArray();
        } else {
            return array();
        }
    }

    /**
     * @abstract 根据相关条件获取小区
     * @author Eric xuminwan@sohu-inc.com
     * @param string $strCondition
     * @param string $columns
     * @param string $order
     * @param int $pageSize
     * @param int $offset
     *
     */
    public function getParkByCondition($strCondition, $columns = '', $order = '', $pageSize = 0, $offset = 0) {
        if (!$strCondition)
            return array();
        $arrCon = array();
        $arrCon['conditions'] = $strCondition;
        if ($columns)
            $arrCon['columns'] = $columns;
        if ($pageSize > 0)
            $arrCon['limit'] = array('number' => $pageSize, 'offset' => $offset);
        if ($order)
            $arrCon['order'] = $order;
        $arrPark = self::find($arrCon, 0)->toArray();
        return $arrPark;
    }

    /**
     * @abstract admin根据小区ID批量获取小区信息
     * @param array $ids
     * @return array|bool
     *
     */
    public function adminGetParkByIds($ids) {
        if (!$ids)
            return false;
        if (is_array($ids)) {
            $arrBind = $this->bindManyParams($ids);
            $arrCond = "id in({$arrBind['cond']}) and status = 1";
            $arrParam = $arrBind['param'];
            $rs = self::find(array(
                        $arrCond,
                        "bind" => $arrParam
                            ), 0)->toArray();
            $arrPark = array();
            foreach ($rs as $k => $v) {
                $arrPark[$v['id']] = $v;
            }
            return $arrPark;
        } else {
            return $this->getParkById($ids);
        }
    }

    /**
     * 根据条件获取小区名称
     * @param string $where
     * @return array
     */
    public function getParkNameByCondition($where = '') {
        $condition = array(
            "conditions" => $where,
            "columns" => "id,name"
        );

        $res = array();
        $parks = self::find($condition, 0)->toArray();
        foreach ($parks as $value) {
            $res[$value['id']] = $value['name'];
        }

        return $res;
    }

    public function getParkByArrId($park) {
        $arrResult = array();
        foreach ($park as $value) {
            $temp = $this->getOne(" id = $value AND status=" . self::STATUS_VALID);
            if (!empty($temp)) {
                $arrResult[$value] = $temp;
            }
        }
        return $arrResult;
    }

    /**
     * 更新统计表中 小区 数量
     * @param type $parkId
     * @param type $date
     * @return boolean
     */
    public function _addZebParkNum($parkId, $date = '') {
        $parkId = intval($parkId);
        if ($parkId < 1) {
            return false;
        }
        $date || $date = date('Y-m-d');
        $zebPark = ZebPark::instance();
        $zebPark->parkId = $parkId;
        $zebPark->date = $date;
        $zebPark->realId = 0;

        $createRes = $zebPark->create();

        return $createRes;
    }

    /**
     * 获取小区的地铁信息
     * @param int   $cityId
     * @param float $parkX
     * @param float $parkY
     * @return array
     */
    public function getParkMetrInfo($cityId, $parkId, $parkX, $parkY)
    {
        if(!$cityId || !$parkX || !$parkY)
        {
            return array();
        }
        $arrSubwayLine = array();

        //获取城市的地铁线路
        $metro = Metro::find("cityId={$cityId} and status=".Metro::STATUS_ENABLED, 0)->toArray();
        foreach($metro as $v) 
        {
            $arrSubwayLine[$v['id']] = $v['name'];
        }
        
        //获取城市的地铁站点
        $msCondition = array(
            'conditions' => "cityId={$cityId} and x<>'' and y<>'' and status=".MetroStation::STATUS_ENABLED,
            'columns'    => 'id,metroId,name,x,y'
        );
        $metroStation = MetroStation::find($msCondition, 0)->toArray();
        
        //获取城市的有效小区
        $parkCondition = array(
            'conditions' => "cityId={$cityId} and X<>'' and Y<>'' and status=".Park::STATUS_VALID,
            'columns'    => 'id,name,X,Y'
        );
        
        $str = '';
        $strLine = '';
        $arrNearestLine = array();
        $strNearestLine = "";
        	
        foreach($metroStation as $eRow) 
        {
            $distance = Utility::GetDistance($parkY, $parkX, $eRow['y'], $eRow['x']); //算法查出经纬度距离(公里)
            if($distance <= 1.5 ) 
            {
                if(!strstr($str, $eRow['name'])  ) 
                {
                    $str .= "{$eRow['name']},";
                }
                
                if(!strstr($strLine, $arrSubwayLine[$eRow['metroId']]) ) 
                {
                    $strLine .= "{$arrSubwayLine[$eRow['metroId']]},";
                }

                if($distance < 0.5 ) 
                {
                    $arrNearestLine[] = "{$arrSubwayLine[$eRow['metroId']]}兲{$eRow['name']}兲10分钟兲".intval($distance*1000);
                } 
                elseif($distance >= 0.5 && $distance < 1 ) 
                {
                    $arrNearestLine[] = "{$arrSubwayLine[$eRow['metroId']]}兲{$eRow['name']}兲20分钟兲".intval($distance*1000);
                } 
                else 
                {
                    $arrNearestLine[] = "{$arrSubwayLine[$eRow['metroId']]}兲{$eRow['name']}兲30分钟兲".intval($distance*1000);
                }
            }
        }

        $str = rtrim($str, ",");
        $strLine = rtrim($strLine, ",");
        $strNearestLine = implode(",", $arrNearestLine);

        if(!empty($str)) 
        {
            //更新 周边地铁线路
            $lineRes = $this->updateParkMetro($parkId, '周边地铁线路', $strLine); 
            //更新 周边地铁站点串
            $stationRes = $this->updateParkMetro($parkId, '周边地铁站点串', $str); 
            //更新 周边地铁站点
            $lsRes = $this->updateParkMetro($parkId, '周边地铁站点', $strNearestLine); 
            
            if($lineRes && $stationRes && $lsRes)
            {
                return array('line'=>$strLine, 'station'=>$str, 'linestation'=>$strNearestLine);
            }
            else
            {
                return array();
            }

        }
            
        return array();
    }
    
    /**
     * 更新小区的地铁信息
     * @param int    $parkId
     * @param string $name
     * @param string $value
     * @return boolean
     */
    public function updateParkMetro($parkId, $name, $value)
    {
        $rs = ParkExt::findFirst("parkId={$parkId} and name='{$name}'");

        if($rs) 
        {
            $rs->value = $value;
            $rs->length = mb_strlen($value, 'utf-8');
            $rs->status = ParkExt::STATUS_VALID;
            $rs->update = date('Y-m-d H:i:s');

            return $rs->update();
        } 
        else 
        {
            $rs = ParkExt::instance(false);

            $rs->parkId = $parkId;
            $rs->name = $name;
            $rs->value = $value;
            $rs->length = mb_strlen($value, 'utf-8');
            $rs->status = ParkExt::STATUS_VALID;
            $rs->update = date('Y-m-d H:i:s');

            return $rs->create();
        }
    }
}
