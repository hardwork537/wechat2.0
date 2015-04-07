<?php
class School extends BaseModel
{
    protected $id;
    protected $regId;
    protected $distId;
    protected $cityId;
    protected $name;
    protected $alias;
    protected $pinyin;
    protected $pinyinAbbr;
    protected $address;
    protected $postcode;
    protected $tel;
    protected $fax;
    protected $x;
    protected $y;
    protected $bx;
    protected $by;
    protected $type;
    protected $property;
    protected $level;
    protected $features=0;
    protected $picId=0;
    protected $rank;
    protected $status;
    protected $update;

    public function getSchoolId()
    {
        return $this->id;
    }

    public function setSchoolId($schoolId)
    {
        if(preg_match('/^\d{1,10}$/', $schoolId == 0) || $schoolId > 4294967295)
        {
            return false;
        }
        $this->id = $schoolId;
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

    public function getSchoolName()
    {
        return $this->schoolName;
    }

    public function setSchoolName($schoolName)
    {
        if($schoolName == '' || mb_strlen($schoolName, 'utf8') > 50)
        {
            return false;
        }
        $this->schoolName = $schoolName;
    }

    public function getSchoolAlias()
    {
        return $this->schoolAlias;
    }

    public function setSchoolAlias($schoolAlias)
    {
        if($schoolAlias == '' || mb_strlen($schoolAlias, 'utf8') > 150)
        {
            return false;
        }
        $this->schoolAlias = $schoolAlias;
    }

    public function getSchoolPinyin()
    {
        return $this->schoolPinyin;
    }

    public function setSchoolPinyin($schoolPinyin)
    {
        if($schoolPinyin == '' || mb_strlen($schoolPinyin, 'utf8') > 150)
        {
            return false;
        }
        $this->schoolPinyin = $schoolPinyin;
    }

    public function getSchoolPinyinAbbr()
    {
        return $this->schoolPinyinAbbr;
    }

    public function setSchoolPinyinAbbr($schoolPinyinAbbr)
    {
        if($schoolPinyinAbbr == '' || mb_strlen($schoolPinyinAbbr, 'utf8') > 50)
        {
            return false;
        }
        $this->schoolPinyinAbbr = $schoolPinyinAbbr;
    }

    public function getSchoolAddress()
    {
        return $this->schoolAddress;
    }

    public function setSchoolAddress($schoolAddress)
    {
        if($schoolAddress == '' || mb_strlen($schoolAddress, 'utf8') > 150)
        {
            return false;
        }
        $this->schoolAddress = $schoolAddress;
    }

    public function getSchoolPostcode()
    {
        return $this->schoolPostcode;
    }

    public function setSchoolPostcode($schoolPostcode)
    {
        if($schoolPostcode == '' || mb_strlen($schoolPostcode, 'utf8') > 6)
        {
            return false;
        }
        $this->schoolPostcode = $schoolPostcode;
    }

    public function getSchoolTel()
    {
        return $this->schoolTel;
    }

    public function setSchoolTel($schoolTel)
    {
        if($schoolTel == '' || mb_strlen($schoolTel, 'utf8') > 30)
        {
            return false;
        }
        $this->schoolTel = $schoolTel;
    }

    public function getSchoolFax()
    {
        return $this->schoolFax;
    }

    public function setSchoolFax($schoolFax)
    {
        if($schoolFax == '' || mb_strlen($schoolFax, 'utf8') > 30)
        {
            return false;
        }
        $this->schoolFax = $schoolFax;
    }

    public function getSchoolX()
    {
        return $this->schoolX;
    }
    public function getSchoolY()
    {
        return $this->schoolY;
    }
    public function setSchoolX($schoolX)
    {
        if($schoolX == '' || mb_strlen($schoolX, 'utf8') > 50)
        {
            return false;
        }
        $this->schoolX = $schoolX;
    }
    public function setSchoolY($schoolY)
    {
        if($schoolY == '' || mb_strlen($schoolY, 'utf8') > 50)
        {
            return false;
        }
        $this->schoolY = $schoolY;
    }

    public function getSchoolLonLat()
    {
        return $this->schoolLonLat;
    }

    public function setSchoolLonLat($schoolLonLat)
    {
        if($schoolLonLat == '' || mb_strlen($schoolLonLat, 'utf8') > 30)
        {
            return false;
        }
        $this->schoolLonLat = $schoolLonLat;
    }

    public function getSchoolType()
    {
        return $this->schoolType;
    }

    public function setSchoolType($schoolType)
    {
        if(preg_match('/^\d{1,3}$/', $schoolType == 0) || $schoolType > 255)
        {
            return false;
        }
        $this->schoolType = $schoolType;
    }

    public function getSchoolProperty()
    {
        return $this->schoolProperty;
    }

    public function setSchoolProperty($schoolProperty)
    {
        if($schoolProperty == '' || mb_strlen($schoolProperty, 'utf8') > 30)
        {
            return false;
        }
        $this->schoolProperty = $schoolProperty;
    }

    public function getSchoolLevel()
    {
        return $this->schoolLevel;
    }

    public function setSchoolLevel($schoolLevel)
    {
        if($schoolLevel == '' || mb_strlen($schoolLevel, 'utf8') > 30)
        {
            return false;
        }
        $this->schoolLevel = $schoolLevel;
    }

    public function getSchoolFeatures()
    {
        return $this->schoolFeatures;
    }

    public function setSchoolFeatures($schoolFeatures)
    {
        if($schoolFeatures == '' || mb_strlen($schoolFeatures, 'utf8') > 30)
        {
            return false;
        }
        $this->schoolFeatures = $schoolFeatures;
    }

    public function getSchoolPicId()
    {
        return $this->schoolPicId;
    }

    public function setSchoolPicId($schoolPicId)
    {
        if(preg_match('/^\d{1,10}$/', $schoolPicId == 0) || $schoolPicId > 4294967295)
        {
            return false;
        }
        $this->schoolPicId = $schoolPicId;
    }

    public function getSchoolRank()
    {
        return $this->schoolRank;
    }

    public function setSchoolRank($schoolRank)
    {
        if(preg_match('/^\d{1,10}$/', $schoolRank == 0) || $schoolRank > 4294967295)
        {
            return false;
        }
        $this->schoolRank = $schoolRank;
    }

    public function getSchoolStatus()
    {
        return $this->schoolStatus;
    }

    public function setSchoolStatus($schoolStatus)
    {
        if(preg_match('/^-?\d{1,3}$/', $schoolStatus) == 0 || $schoolStatus > 127 || $schoolStatus < -128)
        {
            return false;
        }
        $this->schoolStatus = $schoolStatus;
    }

    public function getSchoolUpdate()
    {
        return $this->schoolUpdate;
    }

    public function setSchoolUpdate($schoolUpdate)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $schoolUpdate) == 0 || strtotime($schoolUpdate) == false)
        {
            return false;
        }
        $this->schoolUpdate = $schoolUpdate;
    }

    public function getSource()
    {
        return 'school';
    }

    public function columnMap()
    {
        return array(
            'schoolId' => 'id',
            'regId' => 'regId',
            'distId' => 'distId',
            'cityId' => 'cityId',
            'schoolName' => 'name',
            'schoolAlias' => 'alias',
            'schoolPinyin' => 'pinyin',
            'schoolPinyinAbbr' => 'pinyinAbbr',
            'schoolAddress' => 'address',
            'schoolPostcode' => 'postcode',
            'schoolTel' => 'tel',
            'schoolFax' => 'fax',
            'schoolX' => 'x',
            'schoolY' => 'y',
            'schoolBX' => 'bx',
            'schoolBY' => 'by',
            'schoolType' => 'type',
            'schoolProperty' => 'property',
            'schoolLevel' => 'level',
            'schoolFeatures' => 'features',
            'schoolPicId' => 'picId',
            'schoolRank' => 'rank',
            'schoolStatus' => 'status',
            'schoolUpdate' => 'update'
        );
    }
    /**
     * 实例化
     * @param type $cache
     * @return School_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    /**
     * 新增学校字典
     * @param array $data
     * @return array
     */
    public function add($data)
    {

        if(empty($data))
        {
            return array('status'=>1, 'info'=>'参数为空！');
        }
        if($this->isExistSchoolName($data["name"], $data["cityId"]))
        {
            return array('status'=>1, 'info'=>'学校已经存在！');
        }

        $bxy = BaiduMap::instance()->getLonLat($data['x'],$data['y']);

        $this->name = $data['name'];
        $this->cityId = $data["cityId"];
        $this->distId = $data["distId"];
        $this->regId = $data["regId"];
        $this->alias = $data["alias"];
        $this->pinyin = $data["pinyin"];
        $this->pinyinAbbr = $data["pinyinAbbr"];
        $this->address = $data["address"];
        $this->postcode = $data["postcode"];
        $this->tel = $data["tel"];
        $this->fax = $data["fax"];
        $this->type = $data["type"];
        $this->property = $data["property"];
        $this->level = $data["level"];
        $this->x = $data['x'];
        $this->y = $data['y'];
		$this->bx = $bxy['x'];
        $this->by = $bxy['y'];
        $this->lonLat=$data['lonLat'];
        $this->rank = $data["rank"];
        $this->status = $data["status"];
        $this->update = date("Y-m-d H:i:s");


        if($this->create())
        {
          
            return array('status'=>0, 'info'=>'添加学校成功！');
        }
        return array('status'=>-1, 'info'=>'添加学校失败！');
    }

    /**
     * 编辑学校信息
     *
     * @param unknown $cityId
     * @param unknown $arr
     * @return boolean
     */
    public function edit($id, $data)
    {
        $id = intval($id);
        $rs = self::findfirst($id);
		$bxy = BaiduMap::instance()->getLonLat($data['x'],$data['y']);
        $rs->name = $data['name'];
        $rs->cityId = $data["cityId"];
        $rs->distId = $data["distId"];
        $rs->regId = $data["regId"];
        $rs->alias = $data["alias"];
        $rs->pinyin = $data["pinyin"];
        $rs->pinyinAbbr = $data["pinyinAbbr"];
        $rs->address = $data["address"];
        $rs->postcode = $data["postcode"];
        $rs->tel = $data["tel"];
        $rs->fax = $data["fax"];
        $rs->type = $data["type"];
        $rs->property = $data["property"];
        $rs->level = $data["level"];
        $rs->x = $data['x'];
        $rs->y = $data['y'];
		$rs->bx = $bxy['x'];
        $rs->by = $bxy['y'];
        $rs->lonLat=$data['lonLat'];
        $rs->rank = $data["rank"];
        $rs->status = $data["status"];
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
     * 获取城市学校配置
     *
     * @return array
     */
    public function getForConfig() {
        //从MC中加载常量配置
        $data = Mem::Instance()->Get(MCDefine::SCHOOL_CONFIG_CITYID.$GLOBALS['CITY_ID']);
        if ( !empty($data) ) return $data;
        //获取失败或缓存失效，从DB获取并缓存至MC
        $arrCondition['conditions'] = "cityId=".$GLOBALS['CITY_ID'];
        $arrCondition['columns'] = 'id,name';
        $arrSchool = self::find($arrCondition,0)->toArray();
        if (!$arrSchool) return array();
        $return = array();
        foreach ( $arrSchool as $school ) {
            $return[$school['id']] = $school['name'];
        }
        if ( !empty($return) )
            Mem::Instance()->Set(MCDefine::SCHOOL_CONFIG_CITYID.$GLOBALS['CITY_ID'], $return, 3600);
        return $return;
    }
        /**
     * 判断学校是否无效
     * @param int $id
     * @param int $cityId
     * @return boolean
     */
    private function isDisableSchool($id, $cityId)
    {
        $Id = intval($id);
        $cityId = intval($cityId);

        $con['conditions'] = "id={$id} and cityId={$cityId} and status=1";

        $intCount = School::count($con);
        if($intCount > 0)
        {
            return false;
        }
        return true;
    }
    /**
     * 学校是否已存在
     * @param string $name
     * @param int    $cityId
     * @param int    $id
     * @return boolean
     */
    private function isExistSchoolName($name, $cityId, $id=0)
    {
        $name = trim($name);
        if(empty($name))
        {
            return true;
        }
        $con['conditions'] = "name='{$name}' and cityId={$cityId} and status=1";
        $id > 0 && $con['conditions'] .= " and id<>{$id}";

        $intCount = self::count($con);
        if($intCount > 0)
        {
            return true;
        }
        return false;
    }


    /**
     * 根据相关条件获取学校信息
     * @author jackchen
     * @param string $strCondition
     * @param string $columns
     * @param string $order
     * @param int $pageSize
     * @param int $offset
     * @return array
     */
    public function getSchoolByCondition($strCondition, $columns = '', $order = '', $pageSize = 0, $offset = 0)
    {
        if(!$strCondition) return array();
        $arrCon = array();
        $arrCon['conditions'] = $strCondition;
        if($columns) $arrCon['columns'] = $columns;
        if($pageSize > 0) $arrCon['limit'] = array('number'=>$pageSize, 'offset'=>$offset);
        if($order) $arrCon['order'] = $order;
        $arrPark = self::find($arrCon,0)->toArray();
        return $arrPark;
    }


}