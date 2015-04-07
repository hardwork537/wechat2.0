<?php
class CityRegion extends BaseModel
{
	/**
	 * 板块状态，未启用0、启用1、废弃-1
	 */
	const STATUS_OFF = 0;
	const STATUS_ON = 1;
	const STATUS_DEL = -1;

    public $id;
    public $distId;
    public $cityId;
    public $name;
    public $abbr;
    public $pinyin;
    public $pinyinAbbr;
    public $pinyinFirst;
    public $X;
    public $Y;
    public $BX;
    public $BY;
    public $status;
    public $update;
    public $weight;
    public $avgPrice = 0;
    public $increase = 0;
    public $xiaoshouId = 0;
    public $kefuId = 0;
    public $price = 0;
    public $bX = 0;
    public $bY = 0;


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

    public function getRegName()
    {
        return $this->regName;
    }

    public function setRegName($regName)
    {
        if($regName == '' || mb_strlen($regName, 'utf8') > 50)
        {
            return false;
        }
        $this->regName = $regName;
    }

    public function getRegAbbr()
    {
        return $this->regAbbr;
    }

    public function setRegAbbr($regAbbr)
    {
        if($regAbbr == '' || mb_strlen($regAbbr, 'utf8') > 10)
        {
            return false;
        }
        $this->regAbbr = $regAbbr;
    }

    public function getRegPinyin()
    {
        return $this->regPinyin;
    }

    public function setRegPinyin($regPinyin)
    {
        if($regPinyin == '' || mb_strlen($regPinyin, 'utf8') > 50)
        {
            return false;
        }
        $this->regPinyin = $regPinyin;
    }

    public function getRegPinyinAbbr()
    {
        return $this->regPinyinAbbr;
    }

    public function setRegPinyinAbbr($regPinyinAbbr)
    {
        if($regPinyinAbbr == '' || mb_strlen($regPinyinAbbr, 'utf8') > 50)
        {
            return false;
        }
        $this->regPinyinAbbr = $regPinyinAbbr;
    }

    public function getRegPinyinFirst()
    {
        return $this->regPinyinFirst;
    }

    public function setRegPinyinFirst($regPinyinFirst)
    {
        $this->regPinyinFirst = $regPinyinFirst;
    }

    public function getRegPrice()
    {
    	return $this->regPrice;
    }

    public function setRegPrice($regPrice)
    {
    	$this->regPrice = $regPrice;
    }

    public function getRegXY()
    {
        return $this->regXY;
    }

    public function setRegXY($regXY)
    {
        if($regXY == '' || mb_strlen($regXY, 'utf8') > 50)
        {
            return false;
        }
        $this->regXY = $regXY;
    }

    public function getRegLonLat()
    {
        return $this->regLonLat;
    }

    public function setRegLonLat($regLonLat)
    {
        if($regLonLat == '' || mb_strlen($regLonLat, 'utf8') > 30)
        {
            return false;
        }
        $this->regLonLat = $regLonLat;
    }

    public function getRegStatus()
    {
        return $this->regStatus;
    }

    public function setRegStatus($regStatus)
    {
        if(preg_match('/^-?\d{1,3}$/', $regStatus) == 0 || $regStatus > 127 || $regStatus < -128)
        {
            return false;
        }
        $this->regStatus = $regStatus;
    }

    public function getRegUpdate()
    {
        return $this->regUpdate;
    }

    public function setRegUpdate($regUpdate)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $regUpdate) == 0 || strtotime($regUpdate) == false)
        {
            return false;
        }
        $this->regUpdate = $regUpdate;
    }

    public function getSource()
    {
        return 'city_region';
    }

    public function columnMap()
    {
        return array(
            'regId' => 'id',
            'distId' => 'distId',
            'cityId' => 'cityId',
            'regName' => 'name',
            'regAbbr' => 'abbr',
            'regPinyin' => 'pinyin',
            'regPinyinAbbr' => 'pinyinAbbr',
            'regPinyinFirst' => 'pinyinFirst',
            'regPrice' => 'price',
            'regX' => 'X',
            'regBX' => 'BX',
            'regY' => 'Y',
            'regBY' => 'BY',
            'regLonLat' => 'lonLat',
            'RegPrice' => 'price',
            'regStatus' => 'status',
            'regUpdate' => 'update',
            'regXiaoshouId' =>  'xiaoshouId',
            'regKefuId' =>  'kefuId',
            'regWeight' =>  'weight',
        	'regAvgPrice' => 'avgPrice',
        	'regIncrease' => 'increase',
        	'regBX' => 'bX',
        	'regBY' => 'bY',
        );
    }

    /**
     * 实例化对象
     *
     * @param type $cache
     * @return \Users_Model
     */
    public static function instance ($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self();
    }

    public function initialize()
    {
       $this->setConn('esf');
    }

    /**
     * @abstract 根据版块ID获取版块信息
     * @author Eric xuminwan@sohu-inc.com
     * @param int $regId
     * @return array|bool
     *
     */
    public function getRegionById($regId)
    {
    	if(!$regId) return false;
    	$arrCond  = "id = ?1 and status = ".self::STATUS_ON;
    	$arrParam = array(1=>$regId);
    	$arrRegion = self::findFirst(array($arrCond,'bind'=>$arrParam),0)->toArray();
    	return $arrRegion;
    }

    public function getRegionAll($cityId, $status=1, $order='id desc'){
        if (!$cityId) return false;
        $arrCondition = array(
            'condition' =>  'cityId=?1 and status=?2',
            'bind'  =>  array(
                1   =>  $cityId,
                2   =>  $status,
            ),
            'order' =>  $order
        );
        return self::find($arrCondition,0)->toArray();
    }

    public function getRhRegion($cityId, $status=1, $order='id desc'){
        if (!$cityId) return false;

        $regionAllInfo = $this->getRegionAll($cityId, $status, $order);
        $return = array();
        if ($regionAllInfo){
            foreach ($regionAllInfo as $region){
                $return[$region['id']] = $region['name'];
            }
        }
        return $return;
    }

    /**
     * 根据城区ID获取该城区下的所有板块数据
     * @param int $distId
     */
    public function getRegionByDistrict($distId){
    	if(empty($distId)){
    		return false;
    	}

    	$arr = array();
    	$arrRegion = self::find(" distId=".$distId." and status=".self::STATUS_ON,0)->toArray();
    	foreach($arrRegion as $value){
    		$arr[$value['id']] = $value;
    	}
    	return $arr;
    }

    /**
     * 根据城区id取板块信息 key=>板块id，value=>板块名
     * @param int $distId
     * @return array
     */
    public function getRegionForOptionByDistId($distId)
    {
        $distId = intval($distId);
        if(!$distId)
        {
            return array();
        }
        $arr = array();
        $regions = $this->getRegionByDistrict($distId);
        foreach($regions as $regId=>$value)
        {
            $arr[$regId] = $value['name'];
        }

        return $arr;
    }


    public function getRegion($cityId) {
        if (!$cityId) $cityId = $GLOBALS['CITY_ID'];
        $arrCondition['conditions'] = 'cityId='.$cityId;
        $arrCondition['order'] = 'pinyin asc';
        return self::find($arrCondition, 0)->toArray();
    }

    /**
     * 构建区域板块多级下拉选项菜单数据(用于新版焦点通)
     *
     * @param int $intCityId
     * @return array
     * @example array(distId=>array(regId=>regName[,...]))
     */
    public function getRegionNameWithDistrict() {
    	$arrRegionTmp = $this->getAllRegion('all');
    	$arrRegion = array();
    	foreach($arrRegionTmp as $key=>&$val){
    		if( empty($arrRegion[$val['distId']]) ){
    			$arrRegion[$val['distId']] = array($key=> $val['name']);
    		}else{
    			if( empty($arrRegion[$val['distId']][$key]) ){
    				$arrRegion[$val['distId']][$key] = $val['name'];
    			}
    		}
    	}
    	return $arrRegion;
    }

    /**
     * 获取所有板块信息，并返回以区域id为键名的数组
     *
     * @return unknown   $arrHotArea
     */
    public function getAllRegion($district_id = 0)
    {
    	$arrBackData = array();

    	if (empty($district_id)) {
    		return $arrBackData;
    	}

    	$arrRegion = self::getAll('', 'pinyin asc', '','','');

    	if (!empty($arrRegion)) {
    		foreach ($arrRegion as $region) {
    			$arrBackData[$region['distId']][$region['id']] = $region;
    		}
    		if ($district_id == 'all') {
    			foreach ($arrBackData as $d_id => $h_row) {
    				foreach ($h_row as $k => $v) {
    					$arrNewBackData[$k] = $v;
    				}
    			}
    			return $arrNewBackData;
    		} else {
    			return $arrBackData[$district_id];
    		}
    	}
    	return $arrBackData;
    }





    /**
     * 添加板块
     *
     * @param array $arr
     * @return boolean
     */
    public function add ($arr)
    {
        $bxy = BaiduMap::instance()->getLonLat($arr["X"],$arr["Y"]);

	$this->cityId = $arr["cityId"];
        $this->distId = $arr["distId"];
        $this->name = $arr["name"];
        $this->abbr = $arr["abbr"];
        $this->pinyin = $arr["pinyin"];
        $this->pinyinAbbr = $arr["pinyinAbbr"];
        $this->pinyinFirst = $arr["pinyinFirst"];
       // $this->xiaoshouId = $arr["xiaoshouId"];  //忽略主表 Edit by Rady  2015-01-16
        //$this->kefuId = $arr["kefuId"];
        $this->X = $arr["X"];
        $this->Y = $arr["Y"];
		$this->BX = $bxy['x'];
        $this->BY = $bxy['y'];
        $this->status = intval($arr["status"]);
        $this->weight = intval($arr["weight"]);
        $this->update = date("Y-m-d H:i:s");

        if ($this->create()) {
            return $this->id;
        }
        return false;
    }

    /**
     * 编辑板块信息
     *
     * @param unknown $cityId
     * @param unknown $arr
     * @return boolean
     */
    public function edit ($regId, $arr)
    {
        $regId = intval($regId);
	$bxy = BaiduMap::instance()->getLonLat($arr["X"],$arr["Y"]);
        $rs = self::findfirst($regId);
        $rs->cityId = $arr["cityId"];
        $rs->distId = $arr["distId"];
        $rs->name = $arr["name"];
        $rs->abbr = $arr["abbr"];
        $rs->pinyin = $arr["pinyin"];
        $rs->pinyinAbbr = $arr["pinyinAbbr"];
        $rs->pinyinFirst = $arr["pinyinFirst"];
       // $rs->xiaoshouId = $arr["xiaoshouId"]; //忽略主表 Edit by Rady  2015-01-16
       // $rs->kefuId = $arr["kefuId"];
        $rs->X = $arr["X"];
        $rs->Y = $arr["Y"];
		$rs->BX = $bxy['x'];
        $rs->BY = $bxy['y'];
        $rs->status = intval($arr["status"]);
        $rs->weight = intval($arr["weight"]);
        $rs->update = date("Y-m-d H:i:s");

        if ($rs->update()) {
            return true;
        }
        foreach ($rs->getMessages() as $message)
        {
            echo $message;
        }

        return false;
    }

    /**
     * 删除单条记录
     *
     * @param unknown $where
     */
    public function del ($where)
    {
        $rs = self::findFirst($where);
        if ($rs && $rs->delete())
        {
            return true;
        }
        return false;
    }

    /**
     * @abstract 底部“商圈索引”版块 数据获取
     * @author Eric xuminwan@sohu-inc.com
     * @return array
     */
    public function getBottomRegionIndex($cityId)
    {
    	if(!$cityId) return false;
        $mcKey = MCDefine::BOTTEM_REGION_INDEX.$cityId;
        $return = Mem::Instance()->Get($mcKey);
        if ($return) return json_decode($return, true);
    	$arrRegionTmp = $this->getSearchConfig($cityId);
    	$arrRegion = array();
    	foreach ($arrRegionTmp as $pinyin => $data)
    	{
    		$arrRegion[strtoupper($pinyin{'0'})][$data['id']] = array(
    				'name' => $data['name'].'二手房出售',
    				'url'  => 'http://'.$GLOBALS['CITY_PY_ABBR']._DEFAULT_DOMAIN_.'/sale/'.$pinyin.'/',
    		);
    	}
        Mem::Instance()->Set($mcKey, json_encode($arrRegion), 60*60*5);
    	return $arrRegion;
    }

    /**
     * @abstract 获取板块检索HASH映射表
     * @author Eric xuminwan@sohu-inc.com
     * @return array
     *
     */
    public function getSearchConfig($cityId)
    {
    	if(!$cityId) return false;

        $mcKey = MCDefine::GET_SEARCH_CONFIG_WITH_CITY.$cityId;
        $return = Mem::Instance()->Get($mcKey);
        if ($return) return json_decode($return, true);
    	//从DB获取
    	$arrRegion = $this->getRegion($cityId);
    	if ( !empty($arrRegion) )
    	{
    		$arrBackData = array();
    		foreach ( $arrRegion as $d )
    		{
    			$arrBackData[$d['pinyin']] = array(
    					'id' => $d['id'],
    					'name' => $d['name'],
    					'pinyinFirst' => $d['pinyinFirst'],
    					'distId' => $d['distId'],
    			);
    		}
    	}
        Mem::Instance()->Set($mcKey, json_encode($arrBackData), 24*60*60);
    	return $arrBackData;
    }

    /**
     * @abstract 批量获取板块信息
     * @param array  $ids
     * @param string $columns
     * @return array
     *
     */
	public function getRegionByIds($ids, $columns = '')
	{
		if(empty($ids))
            return array();
		if(is_array($ids))
		{
			$arrBind = $this->bindManyParams($ids);
			$arrCond = "id in({$arrBind['cond']})";
			$arrParam = $arrBind['param'];
            $condition = array(
					$arrCond,
					"bind" => $arrParam,
			);            
		}
		else
		{
            $condition = array(
                'conditions' => "id={$ids}"
            );
		}
        $columns && $condition['columns'] = $columns;
        $arrRegion  = self::find($condition, 0)->toArray();
		$arrRregion = array();
		foreach($arrRegion as $value)
		{
			$arrRregion[$value['id']] = $value;
		}
		return $arrRregion;
	}

	/**
	 * 获取板块联动数据
	 * @return string
	 */
	public function getLinkAge($intCityID = 0) {
		if (empty($intCityID)) return "";
		$arrBackData = array();
		$arrRegion = $this->getRegionAll($intCityID);
		if ( !empty($arrRegion) ) {
			foreach ( $arrRegion as $r ) {
				$arrBackData[$r['distId']][$r['id']] = $r['name'];
			}
		}
		return json_encode($arrBackData);
	}

    /**
     * 根据板块名称获取板块信息
     * @param int   $cityId
     * @param array $regNames
     * @return array
     */
    public function getRegionByNames($cityId, $regNames) {
        $return = array();
        if(!$cityId || empty($regNames))
        {
            return array();
        }
        $name = "'" . implode("','", $regNames) . "'";
        $where = "cityId={$cityId} and name in ({$name})";
        $rs = self::find($where, 0)->toArray();
        foreach($rs as $v)
        {
            $return[$v['id']] = $v;
        }

        return $return;
    }
}
