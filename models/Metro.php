<?php
class Metro extends BaseModel
{
    protected $id;
    protected $cityId;
    protected $name;
    protected $alias = '';
    protected $status = self::STATUS_ENABLED;
    protected $update;
    protected $weight = 0;

    const STATUS_ENABLED  = 1;   //启用
    const STATUS_DISABLED = 0;   //未启
    const STATUS_WASTED   = - 1; //废弃

    public function getMetroId()
    {
        return $this->metroId;
    }

    public function setMetroId($metroId)
    {
        if(preg_match('/^\d{1,10}$/', $metroId == 0) || $metroId > 4294967295)
        {
            return false;
        }
        $this->metroId = $metroId;
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

    public function getMetroName()
    {
        return $this->metroName;
    }

    public function setMetroName($metroName)
    {
        if($metroName == '' || mb_strlen($metroName, 'utf8') > 50)
        {
            return false;
        }
        $this->metroName = $metroName;
    }

    public function getMetroAlias()
    {
        return $this->metroAlias;
    }

    public function setMetroAlias($metroAlias)
    {
        if($metroAlias == '' || mb_strlen($metroAlias, 'utf8') > 50)
        {
            return false;
        }
        $this->metroAlias = $metroAlias;
    }

    public function getMetroSeq()
    {
        return $this->metroSeq;
    }

    public function getMetroStatus()
    {
        return $this->metroStatus;
    }

    public function setMetroStatus($metroStatus)
    {
        if(preg_match('/^-?\d{1,3}$/', $metroStatus) == 0 || $metroStatus > 127 || $metroStatus < -128)
        {
            return false;
        }
        $this->metroStatus = $metroStatus;
    }

    public function getMetroUpdate()
    {
        return $this->metroUpdate;
    }

    public function setMetroUpdate($metroUpdate)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $metroUpdate) == 0 || strtotime($metroUpdate) == false)
        {
            return false;
        }
        $this->metroUpdate = $metroUpdate;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        if(preg_match('/^\d{1,10}$/', $weight == 0) || $weight > 127 || $weight < -128)
        {
            return false;
        }
        $this->weight = $weight;
    }

    public function getSource()
    {
        return 'metro';
    }

    /**
     * 新增轨交字典
     * @param array $data
     * @return array
     */
    public function add($data)
    {
        if(empty($data))
        {
            return array('status'=>1, 'info'=>'参数为空！');
        }
        if($this->isExistMetroName($data["metroName"], $data["cityId"]))
        {
            return array('status'=>1, 'info'=>'轨道线路已经存在！');
        }

        $rs = self::instance();
        $rs->cityId = $data["cityId"];
        $rs->name = $data["metroName"];
        $rs->weight = $data["weight"];
        $rs->update = date("Y-m-d H:i:s");

        if($rs->create())
        {
            return array('status'=>0, 'info'=>'添加轨交成功！');
        }
        return array('status'=>1, 'info'=>'添加轨交失败！');
    }

    /**
     * 编辑轨交信息
     *
     * @param int   $id
     * @param array $data
     * @return array
     */
    public function edit($id, $data)
    {
        if(empty($data))
        {
            return array('status'=>1, 'info'=>'参数为空！');
        }
        if($this->isExistMetroName($data["metroName"], $data["cityId"], $id))
        {
            return array('status'=>1, 'info'=>'轨交线路已经存在！');
        }

        $rs = self::findfirst($id);
        $rs->cityId = $data["cityId"];
        $rs->name = $data["metroName"];
        $rs->weight = $data["weight"];
        $rs->update = date("Y-m-d H:i:s");

        if ($rs->update()) {
            return array('status'=>0, 'info'=>'轨交修改成功！');
        }
        return array('status'=>1, 'info'=>'轨交修改失败！');
    }

    private function isExistMetroName($metroName, $cityId, $metroId=0)
    {
        $metroName = trim($metroName);
        if(empty($metroName))
        {
            return true;
        }
        $con['conditions'] = "name='{$metroName}' and cityId={$cityId} and status=" . self::STATUS_ENABLED;
        $metroId > 0 && $con['conditions'] .= " and id<>{$metroId}";

        $intCount = self::count($con);
        if($intCount > 0)
        {
                return true;
        }
        return false;
    }

    public function columnMap()
    {
        return array(
            'metroId'     => 'id',
            'cityId'      => 'cityId',
            'metroName'   => 'name',
            'metroAlias'  => 'alias',
            'metroStatus' => 'status',
            'metroUpdate' => 'update',
            'metroWeight' => 'weight',
        );
    }

    public function initialize()
    {
        $this->setConn('esf');
    }

    /**
     * 实例化
     * @param type $cache
     * @return Metro_Model
     */
    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
    /**
     * 获取所有轨道线路信息，并返回以城市id为键名的数组
     *
     * @return unknown
     */
    public function getAllMetro($city_id)
    {
        $city_id = empty($city_id)? 1: $city_id;
        $key = MCDefine::LINEDATA_ONE_CITY.$city_id;
        $arrData = Mem::Instance()->Get($key);
        if ( !empty($arrData) ) return $arrData;

        $arrCondition['conditions'] = 'cityId='.$city_id;
        $arrCondition['order'] = 'weight asc';
        $arrData = self::find($arrCondition,0)->toArray();
        $tmp = array();
        foreach($arrData as &$value)
        {
            $tmp[$value['id']] = $value;
        }
        Mem::Instance()->Set($key, $tmp, 86400); //考虑到这个大部分页面用到，而且数据量不大所以缓存了一天
        return $tmp;
    }

    /**
     * 获取所有有效轨道线路信息，key为metroId，value为metroName
     * @param type $city_id
     * @return type
     */
    public function getLinesForOption($city_id)
    {
        $city_id = intval($city_id);
        $condition = array(
            'conditions' => 'cityId='.$city_id.' and status='.self::STATUS_ENABLED,
            'order'      => 'weight asc, id asc'
        );
        $lines = self::find($condition)->toArray();

        $tmp = array();
        foreach($lines as $line)
        {
            $tmp[$line['id']] = $line['name'];
        }

        return $tmp;
    }
}