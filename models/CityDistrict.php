<?php

class CityDistrict extends BaseModel
{
    protected $id;

    protected $cityId;

    protected $name;

    protected $abbr;

    protected $pinyin;

    protected $maxPrice = 0;

    protected $X;

    protected $Y;

    protected $BX;

    protected $BY;

    protected $status;

    protected $update;

    protected $distWeight;

    protected $avgPrice = 0;

    protected $increase = 0;

    protected $weight = 0;

    const STATUS_ENABLED = 1; // 启用中
    const STATUS_DISABLED = 0; // 未启用
    const STATUS_WASTED = - 1; // 废弃

    public function getid ()
    {
        return $this->id;
    }

    public function setId ($id)
    {
        if (preg_match('/^\d{1,10}$/', $id == 0) || $id > 4294967295)
        {
            return false;
        }
        $this->id = $id;
    }

    public function getCityId ()
    {
        return $this->cityId;
    }

    public function setCityId ($cityId)
    {
        if (preg_match('/^\d{1,10}$/', $cityId == 0) || $cityId > 4294967295)
        {
            return false;
        }
        $this->cityId = $cityId;
    }

    public function getDistName ()
    {
        return $this->name;
    }

    public function setDistName ($distName)
    {
        if ($distName == '' || mb_strlen($distName, 'utf8') > 50)
        {
            return false;
        }
        $this->name = $distName;
    }

    public function getDistAbbr ()
    {
        return $this->abbr;
    }

    public function setDistAbbr ($distAbbr)
    {
        if ($distAbbr == '' || mb_strlen($distAbbr, 'utf8') > 10)
        {
            return false;
        }
        $this->abbr = $distAbbr;
    }

    public function getDistPinyin ()
    {
        return $this->pinyin;
    }

    public function setDistPinyin ($distPinyin)
    {
        if ($distPinyin == '' || mb_strlen($distPinyin, 'utf8') > 50)
        {
            return false;
        }
        $this->pinyin = $distPinyin;
    }

    public function getDistMaxPrice ()
    {
        return $this->maxPrice;
    }

    public function setDistMaxPrice ($distMaxPrice)
    {
        if (preg_match('/^\d{1,10}$/', $distMaxPrice == 0) || $distMaxPrice > 4294967295)
        {
            return false;
        }
        $this->maxPrice = $distMaxPrice;
    }

    public function getDistXY ()
    {
        return $this->xY;
    }

    public function setDistXY ($distXY)
    {
        if ($distXY == '' || mb_strlen($distXY, 'utf8') > 50)
        {
            return false;
        }
        $this->xY = $distXY;
    }

    public function getDistLonLat ()
    {
        return $this->lonLat;
    }

    public function setDistLonLat ($distLonLat)
    {
        if ($distLonLat == '' || mb_strlen($distLonLat, 'utf8') > 50)
        {
            return false;
        }
        $this->lonLat = $distLonLat;
    }

    public function getDistStatus ()
    {
        return $this->status;
    }

    public function setDistStatus ($distStatus)
    {
        if (preg_match('/^-?\d{1,3}$/', $distStatus) == 0 || $distStatus > 127 || $distStatus < - 128)
        {
            return false;
        }
        $this->status = $distStatus;
    }

    public function getDistUpdate ()
    {
        return $this->update;
    }

    public function setDistUpdate ($distUpdate)
    {
        if (preg_match( '/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $distUpdate) == 0 || strtotime($distUpdate) == false)
        {
            return false;
        }
        $this->update = $distUpdate;
    }

    public function getSource ()
    {
        return 'city_district';
    }

    public function __set ($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->{$name} = $value;
        }
    }

    public function __get ($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }
        return false;
    }

    public function columnMap ()
    {
        return array(
            'distId' => 'id',
            'cityId' => 'cityId',
            'distName' => 'name',
            'distAbbr' => 'abbr',
            'distPinyin' => 'pinyin',
            'distMaxPrice' => 'maxPrice',
            'distX' => 'X',
            'distBX' => 'BX',
            'distY' => 'Y',
            'distBY' => 'BY',
            'distLonLat' => 'lonLat',
            'distStatus' => 'status',
            'distUpdate' => 'update',
            'distWeight'    =>  'weight',
        	'distAvgPrice' => 'avgPrice',
        	'distIncrease' => 'increase',
        );
    }

    public function initialize ()
    {
        $this->setConn('esf');
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

    /**
     * 根据城市Id获城区信息
     * 不传cityID则获取所有城市的城区信息
     */
   public function getDistrict( $intCityID )
    {
    	if(!$intCityID) return false;

    	$arrBackData = array();

        $strCond = "cityId = {$intCityID} and status = 1";

        $objRes = self::find($strCond);

		 if ( !empty($objRes) )
		 {

		 	foreach ( $objRes->toArray() as $district )
		 	{
		 		$arrBackData[$district['id']] = $district['name'];
         	}
		 }
        return $arrBackData;
    }

    /**
     * @abstract 根据城区Id获城区信息
     * @author Eric xuminwan@sohu-inc.com
     * @param int $distId
     *
     */
    public function getDistrictById($distId)
    {
    	if(!$distId) return false;
    	$arrCond  = "id = ?1 and status = ".self::STATUS_ENABLED;
    	$arrParam = array(1=>$distId);
    	$arrDistrict = self::findFirst(
    			array(
    					$arrCond,
    					"bind" => $arrParam
    			),0
    	)->toArray();
    	return $arrDistrict;
    }

    /**
     * @abstract 根据城市Id获城区信息
     * @author Eric xuminwan@sohu-inc.com
     * @param int $intCityId
     *
     */
    public function getDistrictByCityId($intCityId)
    {
    	if(!$intCityId) return false;
    	$arrCond  = "cityId = ?1 and status = ".self::STATUS_ENABLED;
    	$arrParam = array(1=>$intCityId);
    	$arrDistrict = self::find(
    			array(
    					$arrCond,
    					"bind" => $arrParam
    				 )
    			)->toArray();
    	$arrDist=array();
    	foreach ($arrDistrict as $value)
    	{
    		$arrDist[$value['id']]=$value;
    	}
    	return $arrDist;
    }

    /**
     * 添加城区
     *
     * @param array $arr
     * @return boolean
     */
    public function add ($arr)
    {
		$bxy = BaiduMap::instance()->getLonLat($arr["X"],$arr["Y"]);
		$this->BX = $bxy['x'];
        $this->BY = $bxy['y'];
        $this->cityId = $arr["cityId"];
        $this->name = $arr["name"];
        $this->abbr = $arr["abbr"];
        $this->pinyin = $arr["pinyin"];
		$this->weight = $arr["weight"];
        $this->X= intval($arr["X"]);
        $this->Y= intval($arr["Y"]);
        $this->status = intval($arr["status"]);
        $this->weight = intval($arr["weight"]);
        $this->update = date("Y-m-d H:i:s");

        if ($this->create()) {
            return true;
        }
        return false;
    }

    /**
     * 编辑城区信息
     *
     * @param unknown $cityId
     * @param unknown $arr
     * @return boolean
     */
    public function edit ($distId, $arr)
    {
        $distId = intval($distId);
		$bxy = BaiduMap::instance()->getLonLat($arr["X"],$arr["Y"]);
        $rs = self::findfirst($distId);
        $rs->cityId = $arr["cityId"];
        $rs->name = $arr["name"];
        $rs->abbr = $arr["abbr"];
        $rs->pinyin = $arr["pinyin"];
		$rs->weight = $arr["weight"];
        $rs->X = floatval($arr["X"]);
        $rs->Y = floatval($arr["Y"]);
		$rs->BX = $bxy['x'];
        $rs->BY = $bxy['y'];
        $rs->status = intval($arr["status"]);
        $rs->weight = intval($arr["weight"]);
        $rs->update = date("Y-m-d H:i:s");

        if ($rs->save()) {
            return true;
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
	 * 获取城区联动数据
	 *
	 * @return string
	 */
	public function getLinkAge($intCityID = 0) {
		if (empty($intCityID)) return "";
		$arrDistrict = $this->getDistrict($intCityID);
		return json_encode($arrDistrict);
	}

    /**
     * 根据板块名称获取区域信息
     * @param int   $cityId
     * @param array $distNames
     * @return array
     */
    public function getDistByNames($cityId, $distNames) {
        $return = array();
        if(!$cityId || empty($distNames))
        {
            return array();
        }
        $name = "'" . implode("','", $distNames) . "'";
        $where = "cityId={$cityId} and name in ({$name})";
        $rs = self::find($where, 0)->toArray();
        foreach($rs as $v)
        {
            $return[$v['id']] = $v;
        }

        return $return;
    }
    
    /**
     * 根据区域id获取信息
     * @param int|array $distIds
     * @param string    $columns
     * @param int       $status
     * @return array
     */
    public function getDistByIds($distIds, $columns = '', $status = self::STATUS_ENABLED)
    {
        if(empty($distIds))
        {
            return array();
        }
        if(is_array($distIds))
        {
            $arrBind = $this->bindManyParams($distIds);
            $arrCond = "id in({$arrBind['cond']}) and status={$status}";
            $arrParam = $arrBind['param'];
            $condition = array(
                $arrCond,
                "bind" => $arrParam,
            );
        }
        else
        {
            $condition = array('conditions'=>"id={$distIds} and status={$status}");
        }
        $columns && $condition['columns'] = $columns;
        $arrDist  = self::find($condition,0)->toArray();
        $arrRdist = array();
        foreach($arrDist as $value)
        {
        	$arrRdist[$value['id']] = $value;
        }
        return $arrRdist;
    }

}
