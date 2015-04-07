<?php

class CmsPropRecommend extends BaseModel
{
    protected $id;
    protected $propId;
    protected $cityId;
    protected $houseId;
    protected $status = self::STATUS_PENDING;
    protected $addFrom = self::FROM_MANUAL;
    protected $weight = 0;
    protected $recommendReason = '';
    protected $rejectReason = '';
    protected $addTime;
    
    const STATUS_PENDING = 1;   //未审核
    const STATUS_PASSED  = 2;   //审核通过
    const STATUS_REJECT  = 3;   //驳回
    
    //添加来源
    const FROM_MANUAL = 1;  //手动添加
    const FROM_LIST   = 2;  //列表中添加
    
    public static function getAllStatus() 
    {
        return array(
            self::STATUS_PENDING => '未审核',
            self::STATUS_PASSED  => '审核通过',
            self::STATUS_REJECT  => '已驳回'
        );
    }
    
    /**
     * 添加推荐房源
     * @param array $data
     * @return boolean
     */
    public function add($data)
    {
        if(empty($data))
        {
            return false;
        }
        $rs = self::instance();
        $rs->propId = $data['id'];
        $rs->houseId = $data['houseId'];
        $rs->recommendReason = $data['recommendReason'];
        $rs->cityId = $data['cityId'];
        $rs->weight = $data['weight'];
        $rs->addTime = time();

        if($rs->create())
        {
            return true;
        }
        return false;
    }
    
    /**
     * 从列表中添加房源
     * @param int   $propId
     * @param array $houseIds
     * @param array $reasons
     * @return boolean
     */
    public function addList($propId, $houseIds, $reasons)
    {
        if(empty($houseIds) || !$propId)
        {
            return array('status'=>1, 'info'=>'请选择要添加的房源');
        }
        $addHouseId = implode(',', $houseIds);
        $where = "propId={$propId} and houseId in({$addHouseId})";
        $propRecommend = self::find(array('conditions'=>$where, 'columns'=>'propId,houseId'), 0)->toArray();
        if(!empty($propRecommend))
        {
            $existId = array();
            foreach($propRecommend as $v)
            {
                in_array($v['houseId'], $existId) || $existId[] = $v['houseId'];
            }
            $info = "房源".  implode(',', $existId)."已添加过";
            return array('status'=>1, 'info'=>$info);
        }
        $propInfo = CmsProp::findFirst($propId, 0)->toArray();
        if(empty($propInfo))
        {
            return array('status'=>1, 'info'=>'文章不存在');
        }
        
        $this->begin();
        foreach($houseIds as $houseId)
        {
            $rs = self::instance(false);
            $rs->propId = $propId;
            $rs->houseId = $houseId;
            $rs->cityId = $propInfo['cityId'];
            $rs->recommendReason = $reasons[$houseId];
            $rs->addTime = time();
            $rs->addFrom = self::FROM_LIST;
            
            if(!$rs->create())
            {
                $this->rollback();
                return array('status'=>1, 'info'=>'添加失败');
            }
        }
        $propRealtor = CmsPropRealtor::find("propId={$propId} and houseId in({$addHouseId})");
        foreach($propRealtor as $prop)
        {
            $prop->isAdd = CmsPropRealtor::ADD_YES;
            if(!$prop->update())
            {
                $this->rollback();
                return array('status'=>1, 'info'=>'添加失败');
            }
        }
        
        $this->commit();
        return array('status'=>0, 'info'=>'添加成功');
    }


    /**
     * 根据文章和房源删除记录
     * @param array $data
     * @return boolean
     */
    public function del($data)
    {
        if(empty($data))
        {
            return false;
        }
        $rs =  self::findFirst("propId={$data['propId']} and houseId={$data['houseId']}");
        if(!$rs)
        {
            return false;
        }
        if(!$rs->delete())
        {
            return false;
        }
        return true;
    }
    
    /**
     * 审核房源
     * @param int    $propId
     * @param int    $houseId
     * @param string $action
     * @param array  $data
     * @return boolean
     */
    public function audit($propId, $houseId, $action, $data = array())
    {
        if(!$propId || !$houseId || !$action || !in_array($action, array('pass', 'revoke')))
        {
            return false;
        }
        $rs = self::findFirst("propId={$propId} and houseId={$houseId}");
        if(!$rs)
        {
            return false;
        }
        $this->begin();
        
        if(self::FROM_LIST == $rs->addFrom)
        {
            $gbookData = array();
            
            $gbookData['houseId'] = $houseId;
            $gbookData['hosueType'] = Gbook::HOUSE_TYPE_SALE;
            $gbookData['cityId'] = $rs->cityId;
            $gbookData['author'] = $data['author'];
            $gbookData['authorId'] = $data['userId'];
            $gbookData['authorType'] = Gbook::USER_TYPE_ADMIN;
            $gbookData['time'] = date('Y-m-d H:i:s');
            $gbookData['status'] = Gbook::STATUS_NORMAL;
            $gbookData['ip'] = Utility::GetUserIP();
            
            $propRealtor = CmsPropRealtor::findFirst("propId={$propId} and houseId={$houseId}");
            if($propRealtor)
            {
                $gbookData['realtorId'] = $propRealtor->realId;
                $realtor = Realtor::findFirst($propRealtor->realId);
                $gbookData['type'] = $realtor->type;
            }
            else
            {
                $gbookData['realtorId'] = 0;
                $gbookData['type'] = 0;
            }
        }
        
        if('pass' == $action)
        {           
            if(self::FROM_LIST == $rs->addFrom)
            {
                //发送通知
                $gbookData['content'] = "恭喜啦！编号为{$houseId}的房源通过导购房源审核了，此房源将在导购文章中出现，点击量将会得到很大提升，敬请关注";
                $gbook = new Gbook;
                if(!$gbook->create($gbookData))
                {
                    $this->rollback();
                    return false;
                }
            }           
            $rs->status = self::STATUS_PASSED;
        }
        elseif('revoke' == $action)
        {
            if(self::FROM_LIST == $rs->addFrom)
            {
                //发送通知
                $gbookData['content'] = "亲，你的房源{$houseId}没有通过审核呢，原因：{$data['rejectReason']}。亲等待下期或看看其他导购吧~ 祝多多开单";
                $gbook = new Gbook;
                if(!$gbook->create($gbookData))
                {
                    $this->rollback();
                    return false;
                }
            } 
            $rs->status = self::STATUS_REJECT;
            $rs->rejectReason = $data['rejectReason'];
        }
        if($rs->update())
        {
            $this->commit();
            return true;
        }
        $this->rollback();
        return false;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCityid($cityId)
    {
        $this->cityId = $cityId;
    }

    public function setHouseid($houseId)
    {
        $this->houseId = $houseId;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function setRecommendreason($recommendReason)
    {
        $this->recommendReason = $recommendReason;
    }

    public function setRejectreason($rejectReason)
    {
        $this->rejectReason = $rejectReason;
    }

    public function setAddtime($addTime)
    {
        $this->addTime = $addTime;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCityid()
    {
        return $this->cityId;
    }

    public function getHouseid()
    {
        return $this->houseId;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getRecommendreason()
    {
        return $this->recommendReason;
    }

    public function getRejectreason()
    {
        return $this->rejectReason;
    }

    public function getAddtime()
    {
        return $this->addTime;
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'prId'                => 'id', 
            'propId'              => 'propId',
            'cityId'              => 'cityId', 
            'houseId'             => 'houseId', 
            'prStatus'            => 'status', 
            'prAddFrom'           => 'addFrom',
            'prWeight'            => 'weight', 
            'prRecommendReason'   => 'recommendReason', 
            'prRejectReason'      => 'rejectReason', 
            'prAddTime'           => 'addTime'
        );
    }
    
    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }

    /**
     * 实例化
     * @param type $cache
     * @return CmsPropRecommend_Model
     */
    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
}
