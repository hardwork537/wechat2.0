<?php
class Port extends BaseModel
{
    protected $id;
    protected $name;
    protected $type;
    protected $unit;
    protected $period;
    protected $price;
    protected $status;
    protected $update;
    
    const PRICE_DEFAULT = 38; //全国默认价格
    
    //状态
    const STATUS_ENABLED  = 1;   //启用
    const STATUS_DISABLED = 0;   //未启
    const STATUS_WASTED   = -1;  //废弃
    
    //端口分类
    const TYPE_FREE = 1; //免费
    const TYPE_PAY  = 2; //付费
    
    //计费单位
    const UNIT_YEAR  = 1;  //年
    const UNIT_MONTH = 2;  //月
    const UNIT_WEEK  = 3;  //周
    const UNIT_DAY   = 4;  //天
    
    //计费周期
    const PERIOD_YEAR =  1; //年
    const PERIOD_MONTH = 2; //月
    
    /**
     * 获取所有的 端口分类
     * @return array
     */
    public static function getAllTypes()
    {
        return array(
            self::TYPE_FREE => '免费',
            self::TYPE_PAY  => '付费'
        );
    }
    
    /**
     * 获取所有的 计费单位
     * @return array
     */
    public static function getAllUnits()
    {
        return array(
            self::UNIT_YEAR  => '年',
            self::UNIT_MONTH => '月',
            self::UNIT_WEEK  => '周',
            self::UNIT_DAY   => '天'
        );
    }
    
    /**
     * 获取所有的计费周期
     * @return array
     */
    public static function getAllPeriods()
    {
        return array(
            self::PERIOD_YEAR  => '年',
            self::PERIOD_MONTH => '月'
        );
    }
    
    /**
     * 新增端口字典
     * @param array $data
     * @return array
     */
    public function add($data) 
    {
        if(empty($data)) 
        {
            return array('status'=>1, 'info'=>'参数为空！');
        }
        if($this->isExistPortName($data["portName"])) 
        {
            return array('status'=>1, 'info'=>'端口名称已经存在！');
        }
        if(self::TYPE_FREE == $data['type'])
        {
            $freeNum = self::count("type=".self::TYPE_FREE." and status<>".self::STATUS_WASTED);
            if($freeNum > 0)
            {
                return array('status'=>1, 'info'=>'免费端口已经存在！');
            }
            $data['price'] = 0;
        }
        
        $rs = self::instance();
        $rs->name = $data["portName"];
        $rs->type = $data["type"];
        $rs->unit = $data["unit"];
        $rs->period = $data['period'];
        $rs->price = $data['price'];
        $rs->status = self::STATUS_ENABLED;
        $rs->update = date("Y-m-d H:i:s");
        
        if($rs->create()) 
        {
            return array('status'=>0, 'info'=>'添加端口成功！');  
        }
        return array('status'=>1, 'info'=>'添加端口失败！');  
    }
    
    /**
     * 编辑端口信息
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
        if($this->isExistPortName($data["portName"], $id)) 
        {
            return array('status'=>1, 'info'=>'端口名称已经存在！');
        }
        
        $rs = self::findfirst($id);
        $rs->name = $data["portName"];
        $rs->type = $data["type"];
        $rs->unit = $data["unit"];
        $rs->period = $data['period'];
        $rs->price = $data['price'];
        $rs->status = $data['status'];
        $rs->update = date("Y-m-d H:i:s");

        if ($rs->update()) {
            return array('status'=>0, 'info'=>'端口修改成功！');
        }
        return array('status'=>1, 'info'=>'端口修改失败！');
    }
    
    public function isExistPortName($portName, $portId=0) 
    {
        $portName = trim($portName);
        if(empty($portName))
        {
            return true;
        }
        $con['conditions'] = "name='{$portName}' and status=" . self::STATUS_ENABLED;
        $portId > 0 && $con['conditions'] .= " and id<>{$portId}";
                
        $intCount = self::count($con);
        if($intCount > 0) 
        {
            return true;
        }
        return false;
    }
    
    /**
     * @abstract 批量获取端口信息
     * @param array $ids 
     * @return array|bool
     * 
     */
	public function getPortByIds($ids, $columns = '')
	{
		if(!$ids) return false;
		if(is_array($ids))
		{
			$arrBind = $this->bindManyParams($ids);
			$arrCond = "id in({$arrBind['cond']})";
			$arrParam = $arrBind['param'];
            $condition = array(
					$arrCond,
					"bind" => $arrParam,
			);
            $columns && $condition['columns'] = $columns;
			$arrPort  = self::find($condition, 0)->toArray();
		}
		else
		{
			$arrPort = self::find($condition, 0)->toArray();
            $arrPort = array($arrPort);
		}
		$arrRport = array();
		foreach($arrPort as $value)
		{
			$arrRport[$value['id']] = $value;
		}
		return $arrRport;
	}
    
    /**
     * 删除单条记录
     *
     * @param int $portId   
     * @return array         
     */
    public function del($portId)
    {
        $rs = self::findFirst("id=".$portId);
        if(!$rs)
        {
            return array('status'=>1, 'info'=>'该端口不存在！');
        }
        $this->begin();
        $rs->status = self::STATUS_WASTED;
        $rs->update = date("Y-m-d H:i:s");
        if($rs->update()) 
        {
            $portCitys = PortCity::find("portId={$portId} and status=".PortCity::STATUS_ENABLED);
            if($portCitys)
            {
                foreach($portCitys as $portCity)
                {
                    $portCity->status = PortCity::STATUS_WASTED;
                    if(!$portCity->update())
                    {
                        $this->rollback();
                        return array('status'=>1, 'info'=>'删除失败！');
                    }
                }
                $this->commit();
                return array('status'=>0, 'info'=>'删除成功！');
            }
            else
            {
                $this->commit();
                return array('status'=>0, 'info'=>'删除成功！');
            }
        }
        
        $this->rollback();
        return array('status'=>1, 'info'=>'删除失败！');
    }
    
    /**
     * 获取开启端口
     * @param int $type
     * @return array
     */
    public function getPortForOption($type = self::TYPE_PAY)
    {
        $ports = self::find("type={$type} and status=".self::STATUS_ENABLED, 0)->toArray();
        $ret = array();
        foreach($ports as $value)
        {
            $ret[$value['id']] = $value['name'];
        }
        
        return $ret;
    }
    
    public function getPortId()
    {
        return $this->portId;
    }

    public function setPortId($portId)
    {
        if(preg_match('/^\d{1,10}$/', $portId == 0) || $portId > 4294967295)
        {
            return false;
        }
        $this->portId = $portId;
    }

    public function getPortName()
    {
        return $this->portName;
    }

    public function setPortName($portName)
    {
        if($portName == '' || mb_strlen($portName, 'utf8') > 50)
        {
            return false;
        }
        $this->portName = $portName;
    }

    public function getPortType()
    {
        return $this->portType;
    }

    public function setPortType($portType)
    {
        if(preg_match('/^\d{1,3}$/', $portType == 0) || $portType > 255)
        {
            return false;
        }
        $this->portType = $portType;
    }

    public function getPortUnit()
    {
        return $this->portUnit;
    }

    public function setPortUnit($portUnit)
    {
        if(preg_match('/^\d{1,3}$/', $portUnit == 0) || $portUnit > 255)
        {
            return false;
        }
        $this->portUnit = $portUnit;
    }

    public function getPortPeriod()
    {
        return $this->portPeriod;
    }

    public function setPortPeriod($portPeriod)
    {
        if(preg_match('/^\d{1,3}$/', $portPeriod == 0) || $portPeriod > 255)
        {
            return false;
        }
        $this->portPeriod = $portPeriod;
    }

    public function getPortPrice()
    {
        return $this->portPrice;
    }

    public function setPortPrice($portPrice)
    {
        if(preg_match('/^\d{1,10}$/', $portPrice == 0) || $portPrice > 4294967295)
        {
            return false;
        }
        $this->portPrice = $portPrice;
    }

    public function getPortStatus()
    {
        return $this->portStatus;
    }

    public function setPortStatus($portStatus)
    {
        if(preg_match('/^-?\d{1,3}$/', $portStatus) == 0 || $portStatus > 127 || $portStatus < -128)
        {
            return false;
        }
        $this->portStatus = $portStatus;
    }

    public function getPortUpdate()
    {
        return $this->portUpdate;
    }

    public function setPortUpdate($portUpdate)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $portUpdate) == 0 || strtotime($portUpdate) == false)
        {
            return false;
        }
        $this->portUpdate = $portUpdate;
    }

    public function getSource()
    {
        return 'port';
    }

    public function columnMap()
    {
        return array(
            'portId'     => 'id',
            'portName'   => 'name',
            'portType'   => 'type',
            'portUnit'   => 'unit',
            'portPeriod' => 'period',
            'portPrice'  => 'price',
            'portStatus' => 'status',
            'portUpdate' => 'update'
        );
    }

   public function initialize()
    {
        $this->setConn("esf");
    }
    
	/**
     * 实例化对象
     * @param type $cache
     * @return Port_Model
     */
    public static function instance($cache = true) 
    {
        return parent::_instance(__CLASS__, $cache);
    }
    
}