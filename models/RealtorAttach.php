<?php
class RealtorAttach extends BaseModel
{
	/**
	 * 审核状态
	 * 0.审核失败 1.有效	-1.删除
	 *
	 */
	const STATUS_FALSE = 0;
	const STATUS_TRUE = 1;
	const STATUS_DELETE = -1;
	
	/**
	 * 附件类型
	 * 1、头像 2、名片 3、身份证
	 */
	const TYPE_HEAD = 1;
	const TYPE_BZCARD = 2;
	const TYPE_IDCARD = 3;
		
    protected $id;
    protected $realId;
    protected $imgId;
    protected $type;
    protected $desc = '';
    protected $meta = '';
    protected $status = 1;
    protected $update;
    protected $imgExt;

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

    public function getRealId()
    {
        return $this->realId;
    }

    public function setRealId($realId)
    {
        if(preg_match('/^\d{1,10}$/', $realId == 0) || $realId > 4294967295)
        {
            return false;
        }
        $this->realId = $realId;
    }

    public function getImgId()
    {
        return $this->imgId;
    }

    public function setImgId($imgId)
    {
        if(preg_match('/^\d{1,10}$/', $imgId == 0) || $imgId > 4294967295)
        {
            return false;
        }
        $this->imgId = $imgId;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        if(preg_match('/^\d{1,3}$/', $type == 0) || $type > 255)
        {
            return false;
        }
        $this->type = $type;
    }

    public function getDesc()
    {
        return $this->desc;
    }

    public function setDesc($desc)
    {
        if($desc == '' || mb_strlen($desc, 'utf8') > 50)
        {
            return false;
        }
        $this->desc = $desc;
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function setMeta($meta)
    {
        if($meta == '' || mb_strlen($meta, 'utf8') > 250)
        {
            return false;
        }
        $this->meta = $meta;
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

    public function getImgExt()
    {
        return $this->imgExt;
    }

    public function setImgExt($imgExt)
    {
        if(!in_array($imgExt, array('jpg','jpeg','gif','png')))
        {
            return false;
        }
        $this->imgExt = $imgExt;
    }

    public function getSource()
    {
        return 'realtor_attach';
    }

    public function columnMap()
    {
        return array(
            'raId' => 'id',
            'realId' => 'realId',
            'imgId' => 'imgId',
            'raType' => 'type',
            'raDesc' => 'desc',
            'raMeta' => 'meta',
            'raStatus' => 'status',
            'raUpdate' => 'update',
            'imgExt'    =>  'imgExt'
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
     * @return Realtor_Attach
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
    
    /**
     * 根据经纪人id，获取指定经纪人的信息
     *
     * @return object
     */
    public function getAttachById($RealId,$Status,$Type){
    	if ( empty($RealId) ) {
    		return false;
    	}
    	$arrCond  = "realId = ?1 AND status = ?2 AND type = ?3";
    	$arrParam = array(1 => $RealId,2 => $Status,3 => $Type);
    	$arrRes   = self::findFirst(array(
    			$arrCond,
    			"bind" => $arrParam
    	));
    	return $arrRes;
    }
    
    /**
     * 根据经纪人id获取附件信息
     * @param int|array $realIds
     * @param int       $type
     * @param string    $columns
     * @param int       $status
     * @return array
     */
    public function getAttachByRealIds($realIds, $type, $columns = '', $status = self::STATUS_TRUE)
    {
        if(empty($realIds))
        {
            return array();
        }
        if(is_array($realIds))
        {
            $arrBind = $this->bindManyParams($realIds);
            $arrCond = "realId in({$arrBind['cond']}) and type={$type}";
            $arrCond .= false === $status ? " and status<>".self::STATUS_DELETE : " and status={$status}";
            $arrParam = $arrBind['param'];
            $condition = array(
                $arrCond,
                "bind" => $arrParam,
            );
        }
        else
        {
            $where = "realId={$realIds} and type={$type}";
            $where .= false === $status ? " and status<>".self::STATUS_DELETE : " and status={$status}";
            $condition = array('conditions'=>$where);
        }
        $columns && $condition['columns'] = $columns;
        $arrAttach  = self::find($condition,0)->toArray();
        $arrRattach = array();
        foreach($arrAttach as $value)
        {
        	$arrRattach[$value['realId']] = $value;
        }
        return $arrRattach;
    }
}