<?php
/**
 * @abstract 端口配置
 * @author By jackchen
 * @date 2014-09-16
 */
class PortCity extends BaseModel
{
    /**
     * 端口房源类型状态
     * 出售：10 出租：01  出售/出租：11
     */
    const STATUS_Sale = '10';
    const STATUS_Rent = '01';
    const STATUS_All = '11';

    protected $id;
    protected $portId;
    protected $cityId;
    protected $type;
    protected $esfRelease;
    protected $esfRefresh;
    protected $esfBold;
    protected $esfTags;
    protected $rentRelease;
    protected $rentRefresh;
    protected $rentBold;
    protected $rentTags;
    protected $price;
    protected $equivalent = 0;
    protected $gift = '';
    protected $remark = '';
    protected $isSend = self::SENG_CLOSE;
    protected $status;
    protected $update;
    
    //状态
    const STATUS_ENABLED  = 1;   //启用
    const STATUS_DISABLED = 0;   //未启
    const STATUS_WASTED   = -1;  //废弃
    
    //端口类型
    const TYPE_SALE = 1;   //出售 
    const TYPE_RENT = 2;   //出租
    
    //是否开启赠送
    const SEND_OPEN  = 1;  //开启
    const SENG_CLOSE = 2;  //关闭
       
    /**
     * 获取所有端口类型
     * @return array
     */
    public static function getAllTypes()
    {
        return array(
            self::TYPE_SALE => '出售',
            self::TYPE_RENT => '出租'
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

        $rs = self::instance();
        $rs->portId = $data["portId"];
        $rs->cityId = $data["cityId"];
        $rs->type = $data["type"];
        $rs->esfRelease = $data['esfRelease'];
        $rs->esfBold = $data['esfBold'];
        $rs->esfTags = $data['esfTag'];
        $rs->esfRefresh = $data['esfRefresh'];
        $rs->rentRelease = $data['rentRelease'];
        $rs->rentBold = $data['rentBold'];
        $rs->rentTags = $data['rentTag'];
        $rs->rentRefresh = $data['rentRefresh'];
        $data['refreshSend'] > 0 && $rs->gift = json_encode(array("refreshSend"=>$data['refreshSend']));
        $rs->price = $data['price'];
        $rs->status = self::STATUS_ENABLED;
        $rs->update = date("Y-m-d H:i:s");
        
        if($rs->create()) 
        {
            return array('status'=>0, 'info'=>'添加端口类型成功！');  
        }
        return array('status'=>1, 'info'=>'添加端口类型失败！');  
    }
    
    /**
     * 修改端口字典
     * @param int   $id
     * @param array $data
     * @return array
     */
    public function edit($id, $data) 
    {
        if(!$id || empty($data)) 
        {
            return array('status'=>1, 'info'=>'参数为空！');
        }

        $rs = self::findfirst("id={$id}");
        if(!$rs)
        {
            return array('status'=>1, 'info'=>'端口类型不存在！');
        }
        $rs->portId = $data["portId"];
        $rs->cityId = $data["cityId"];
        $rs->type = $data["type"];
        $rs->esfRelease = $data['esfRelease'];
        $rs->esfBold = $data['esfBold'];
        $rs->esfTags = $data['esfTag'];
        $rs->esfRefresh = $data['esfRefresh'];
        $rs->rentRelease = $data['rentRelease'];
        $rs->rentBold = $data['rentBold'];
        $rs->rentTags = $data['rentTag'];
        $rs->rentRefresh = $data['rentRefresh'];
        $data['refreshSend'] > 0 && $rs->gift = json_encode(array("refreshSend"=>$data['refreshSend']));
        $rs->price = $data['price'];
        $rs->update = date("Y-m-d H:i:s");
        
        if($rs->update()) 
        {
            return array('status'=>0, 'info'=>'修改端口类型成功！');  
        }
        return array('status'=>1, 'info'=>'修改端口类型失败！');  
    }
    
    /**
     * 删除端口类型
     * @param int $id
     * @return array
     */
    public function del($id)
    {
        $id = intval($id);
        if($id < 1)
        {
            return array('status'=>1, 'info'=>'非法操作！');
        }
        $rs = self::findfirst("id={$id}");
        if(!$rs)
        {
            return array('status'=>1, 'info'=>'端口类型不存在！');
        }
        $rs->status = self::STATUS_WASTED;
        $rs->update = date("Y-m-d H:i:s");
        
        if($rs->update()) 
        {
            return array('status'=>0, 'info'=>'删除端口类型成功！');  
        }
        return array('status'=>1, 'info'=>'删除端口类型失败！');  
    }
    
    /**
     * 开启或关闭赠送功能
     * @param int    $cityId
     * @param string $type
     * @return array
     */
    public function display($cityId, $type = 'open')
    {
        $cityId = intval($cityId);
        if('open' == $type) 
        {
            $isSend = self::SEND_OPEN;
        }
        elseif('close' == $type)
        {
            $isSend = self::SENG_CLOSE;
        }
        else
        {
            return array('status'=>1, 'info'=>'非法操作！');
        }
        
        $portCitys = self::find("cityId={$cityId}");
        if(!$portCitys)
        {
            return array('status'=>1, 'info'=>'该城市暂无端口类型！');
        }
        else
        {
            $this->begin();
            foreach($portCitys as $port)
            {
                $port->isSend = $isSend;
                if(!$port->update())
                {
                    $this->rollback();
                    return array('status'=>1, 'info'=>'操作失败！');
                }
            }
        }
        
        $this->commit();
        return array('status'=>0, 'info'=>'操作成功！');
    }
    
    /**
     * 获取有效端口
     * @param int    $cityId
     * @param string $pcType
     * @param int    $portType
     * @return array
     */
    public function getPortForOptionByCityId($cityId, $pcType = '', $portType = 0)
    {
        $where = "PortCity.status=".self::STATUS_ENABLED;
        $cityId > 0 && $where .= " and PortCity.cityId={$cityId}";
        $pcType && $where .= " and PortCity.type='{$pcType}'";
        
        $onWhere = 'port.id = PortCity.portId';
        $portType > 0 && $onWhere .= " and port.type={$portType}";
        
        $ports = $this->getDI()->get('modelsManager')->createBuilder()->from('PortCity')
    	->columns('PortCity.id,port.name')
    	->join('Port', $onWhere, 'port')
    	->where($where)
    	->getQuery()
    	->execute()
    	->toArray();
        
        
        $res = array();
        if(!empty($ports))
        {
            foreach($ports as $value)
            {
                $res[$value['id']] = $value['name'];
            }
        }
        
        return $res;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if(preg_match('/^\d{1,10}$/', $id == 0) || $id > 4294967295)
        {
            return false;
        }
        $this->id = $id;
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

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getNewRelease()
    {
        return $this->newRelease;
    }

    public function setNewRelease($newRelease)
    {
        if(preg_match('/^\d{1,5}$/', $newRelease == 0) || $newRelease > 65535)
        {
            return false;
        }
        $this->newRelease = $newRelease;
    }

    public function getNewRefresh()
    {
        return $this->newRefresh;
    }

    public function setNewRefresh($newRefresh)
    {
        if(preg_match('/^\d{1,5}$/', $newRefresh == 0) || $newRefresh > 65535)
        {
            return false;
        }
        $this->newRefresh = $newRefresh;
    }

    public function getNewBold()
    {
        return $this->newBold;
    }

    public function setNewBold($newBold)
    {
        if(preg_match('/^\d{1,5}$/', $newBold == 0) || $newBold > 65535)
        {
            return false;
        }
        $this->newBold = $newBold;
    }

    public function getNewTags()
    {
        return $this->newTags;
    }

    public function setNewTags($newTags)
    {
        if(preg_match('/^\d{1,5}$/', $newTags == 0) || $newTags > 65535)
        {
            return false;
        }
        $this->newTags = $newTags;
    }

    public function getEsfRelease()
    {
        return $this->esfRelease;
    }

    public function setEsfRelease($esfRelease)
    {
        if(preg_match('/^\d{1,5}$/', $esfRelease == 0) || $esfRelease > 65535)
        {
            return false;
        }
        $this->esfRelease = $esfRelease;
    }

    public function getEsfRefresh()
    {
        return $this->esfRefresh;
    }

    public function setEsfRefresh($esfRefresh)
    {
        if(preg_match('/^\d{1,5}$/', $esfRefresh == 0) || $esfRefresh > 65535)
        {
            return false;
        }
        $this->esfRefresh = $esfRefresh;
    }

    public function getEsfBold()
    {
        return $this->esfBold;
    }

    public function setEsfBold($esfBold)
    {
        if(preg_match('/^\d{1,5}$/', $esfBold == 0) || $esfBold > 65535)
        {
            return false;
        }
        $this->esfBold = $esfBold;
    }

    public function getEsfTags()
    {
        return $this->esfTags;
    }

    public function setEsfTags($esfTags)
    {
        if(preg_match('/^\d{1,5}$/', $esfTags == 0) || $esfTags > 65535)
        {
            return false;
        }
        $this->esfTags = $esfTags;
    }

    public function getRentRelease()
    {
        return $this->rentRelease;
    }

    public function setRentRelease($rentRelease)
    {
        if(preg_match('/^\d{1,5}$/', $rentRelease == 0) || $rentRelease > 65535)
        {
            return false;
        }
        $this->rentRelease = $rentRelease;
    }

    public function getRentRefresh()
    {
        return $this->rentRefresh;
    }

    public function setRentRefresh($rentRefresh)
    {
        if(preg_match('/^\d{1,5}$/', $rentRefresh == 0) || $rentRefresh > 65535)
        {
            return false;
        }
        $this->rentRefresh = $rentRefresh;
    }

    public function getRentBold()
    {
        return $this->rentBold;
    }

    public function setRentBold($rentBold)
    {
        if(preg_match('/^\d{1,5}$/', $rentBold == 0) || $rentBold > 65535)
        {
            return false;
        }
        $this->rentBold = $rentBold;
    }

    public function getRentTags()
    {
        return $this->rentTags;
    }

    public function setRentTags($rentTags)
    {
        if(preg_match('/^\d{1,5}$/', $rentTags == 0) || $rentTags > 65535)
        {
            return false;
        }
        $this->rentTags = $rentTags;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        if(preg_match('/^\d{1,10}$/', $price == 0) || $price > 4294967295)
        {
            return false;
        }
        $this->price = $price;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        if(preg_match('/^-?\d{1,3}$/', $status) == 0 || $status > 127 || $status < -128)
        {
            return false;
        }
        $this->status = $status;
    }

    public function getUpdate()
    {
        return $this->update;
    }

    public function setUpdate($update)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $update) == 0 || strtotime($update) == false)
        {
            return false;
        }
        $this->update = $update;
    }

    public function getSource()
    {
        return 'port_city';
    }

    public function columnMap()
    {
        return array(
            'pcId'          => 'id',
            'portId'        => 'portId',
            'cityId'        => 'cityId',
            'pcType'        => 'type',
            'pcSaleRelease'  => 'esfRelease',
            'pcSaleRefresh'  => 'esfRefresh',
            'pcSaleBold'     => 'esfBold',
            'pcSaleTags'     => 'esfTags',
            'pcRentRelease' => 'rentRelease',
            'pcRentRefresh' => 'rentRefresh',
            'pcRentBold'    => 'rentBold',
            'pcRentTags'    => 'rentTags',
            'pcPrice'       => 'price',
            'pcEquivalent'  => 'equivalent',
            'pcGift'        => 'gift',
            'pcRemark'      => 'remark',
            //'pcRefreshSend' => 'refreshSend',
            'pcIsSend'      => 'isSend',
            'pcStatus'      => 'status',
            'pcUpdate'      => 'update'
        );
    }

    public function initialize()
    {
        $this->setConn('esf');
    }

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self();
    }



    /**
     * 根据端口ID获取数据
     *
     * @param int $to
     * @param int $toId
     * @return object
     */
    public function getPortById($portid) {
        if ( empty($portid)) {
            return false;
        }
        $arrCond  = "portId = ?1";
        $arrParam = array(1 => $portid);
        $arrRes   = self::findFirst(array(
            $arrCond,
            "bind" => $arrParam
        ));
        return $arrRes;
    }
    
    /**
     * @abstract 批量获取端口
     * @param array|int  $portIds 
     * @param string     $columns
     * @return array
     * 
     */
    public function getPortByIds($portIds, $columns = '')
	{
		if(empty($portIds)) 
            return array();
		if(is_array($portIds))
		{
			$arrBind = $this->bindManyParams($portIds);
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
                'conditions' => "id={$portIds}"
            );
		}
        $columns && $condition['columns'] = $columns;
        $arrPort  = self::find($condition, 0)->toArray();
		$arrRport = array();
		foreach($arrPort as $value)
		{
			$arrRport[$value['id']] = $value;
		}
		return $arrRport;
	}
    
    /**
     * 取某个城市所有端口信息
     * @param int    $cityId
     * @param int    $offset
     * @param int    $limit
     * @param string $type
     * @param bolean $needNum
     * @return array
     */
    public function getAllPortByCityId($cityId, $offset, $limit, $type = '', $needNum = true)
    {
        $cityId = intval($cityId);
        $offset = intval($offset);
        $limit = intval($limit);
        
        $allColumns = $this->columnMap();      
        $columns = array('p.name');
        foreach($allColumns as $v)
        {
            //不返回 update 字段
            'update' != $v && $columns[] = 'PortCity.'.$v;
        }

        $where = "PortCity.cityId={$cityId} and PortCity.status=".self::STATUS_ENABLED;
        
        $onWhere = "p.id = PortCity.portId";
        $type && $onWhere .= " and p.type=".Port::TYPE_PAY;
        
    	$ports = self::query()
    	->columns($columns)
    	->where($where)
        ->orderBy('PortCity.id desc')
        ->limit($limit, $offset)
    	->join('Port', $onWhere, 'p')
    	->execute();
        
        if($ports)
    	{
            if($needNum)
            {
                $portNum = self::query()
                    ->where($where)
                    ->columns('count(*) as num')
                    ->join('Port', $onWhere, 'p')
                    ->execute()
                    ->toArray();
                
                return array('data'=>$ports->toArray(), 'num'=> intval($portNum[0]['num']));
            }
    		return array('data'=>$ports->toArray());
    	}
    	else
    	{
    		return array('data'=>array(), 'num'=>0);
    	}
    }
    
    /**
     * 根据pcId获取信息
     * @param int|array $pcIds
     * @param string    $columns
     * @param int       $status
     * @return array
     */
    public function getPortsByIds($pcIds, $columns = '', $status = self::STATUS_ENABLED)
    {
        if(empty($pcIds))
        {
            return array();
        }
        if(is_array($pcIds))
        {
            $arrBind = $this->bindManyParams($pcIds);
            $arrCond = "id in({$arrBind['cond']}) and status={$status}";
            $arrParam = $arrBind['param'];
            $condition = array(
                $arrCond,
                "bind" => $arrParam,
            );
        }
        else
        {
            $condition = array('conditions'=>"id={$pcIds} and status={$status}");
        }
        $columns && $condition['columns'] = $columns;
        $arrData  = self::find($condition,0)->toArray();
        $arrRdata = array();
        foreach($arrData as $value)
        {
        	$arrRdata[$value['id']] = $value;
        }
        return $arrRdata;
    }

    /**
     * 获取端口数量
     * @param array $pcIds
     * @return array
     */
    public function getPortNumByIds($pcIds)
    {
        if(empty($pcIds))
        {
            return array();
        }
        $portId = implode(',', $pcIds);
        $condition = array(
            'conditions' => "id in({$portId})",
            'columns'    => 'id,type,equivalent'
        );
        $portInfo = self::find($condition, 0)->toArray();
        $data = array();
        foreach($portInfo as $v)
        {
            $data[$v['id']]['sale'] = self::STATUS_Sale == $v['type'] ? intval($v['equivalent']) : 0;
            $data[$v['id']]['rent'] = self::STATUS_Rent == $v['type'] ? intval($v['equivalent']) : 0;
        }
        
        return $data;
    }
}