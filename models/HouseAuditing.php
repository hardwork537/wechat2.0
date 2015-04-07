<?php
class HouseAuditing extends BaseModel
{

	//审核状态status    0:待审核  1:审核过  -1:违规 -2:驳回
	const HOUSE_VERING = 0;
	const HOUSE_VERED = 1;
	const HOUSE_VERNO = -1;
    const HOUSE_BOHUI = -2;


    //审核类型 haType 默认值0  1经纪人  2个人 3房源图片审核   4高清房源审核
    const AUDITTYPE_MOREN = 0;
    const AUDITTYPE_JINGJIREN =1;
    const AUDITTYPE_GEREN=2;
    const AUDITTYPE_PIC = 3;
    const AUDITTYPE_HD = 4;

    public static $haFailure = [
        "1"  => "该房源价格不真实",
        "2"  => "房源与小区不符",
        "3"  => "图片不符合要求",
        "4"  => "图片带有外站logo",
        "5"  => "图片有明显PS痕迹",
        "6"  => "图片未上传完整",
        "7"  => "图片有拼接痕迹",
        "8"  => "拼图角度错误",
        "9"  => "整套房源风格不一致",
        "10" => "虚假房源",
        "11" => "图片上传位置错误",
        "12" => "其他",
        "97" => "带有敏感词信息",
        "98" => "房源标题重复"
    ];
	
    protected $id;
    protected $houseId;
    protected $name = '';
    protected $remark = '';
    protected $failure = 0;
    protected $status = 0;
    protected $updateTime;
    protected $type;

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

    public function getHouseId()
    {
        return $this->houseId;
    }

    public function setHouseId($houseId)
    {
        if(preg_match('/^\d{1,10}$/', $houseId == 0) || $houseId > 4294967295)
        {
            return false;
        }
        $this->houseId = $houseId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if($name == '' || mb_strlen($name, 'utf8') > 10)
        {
            return false;
        }
        $this->name = $name;
    }

    public function getRemark()
    {
        return $this->remark;
    }

    public function setRemark($remark)
    {
        if($remark == '' || mb_strlen($remark, 'utf8') > 150)
        {
            return false;
        }
        $this->remark = $remark;
    }

    public function getFailure()
    {
        return $this->failure;
    }

    public function setFailure($failure)
    {
        if(preg_match('/^-?\d{1,3}$/', $failure) == 0 || $failure > 127 || $failure < -128)
        {
            return false;
        }
        $this->failure = $failure;
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
        return $this->updateTime;
    }

    public function setUpdate($update)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $update) == 0 || strtotime($update) == false)
        {
            return false;
        }
        $this->updateTime = $update;
    }

    public function getSource()
    {
        return 'house_auditing';
    }

    public function columnMap()
    {
        return array(
            'haId' => 'id',
            'houseId' => 'houseId',
            'haName' => 'name',
            'haRemark' => 'remark',
            'haFailure' => 'failure',
            'haStatus' => 'status',
            'haUpdate' => 'updateTime',
            'haType'   => 'type'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    
    public function addByHouseID( $arrData )
    {
    	if( empty($arrData) )	return false;
    	
    	$arrInsert = array();
    	$arrInsert['houseId']	=	$arrData['houseId'];
    	$arrInsert['failure']	=	isset($arrData['failure'])	?	$arrData['failure']	:	0;
    	if(isset($arrData['failure']))
    	{
    		$arrInsert['status'] = self::HOUSE_VERNO;
    	}
        elseif(isset($arrData['status']))
        {
            $arrInsert['status']  =  $arrData['status'];
        }
        else
        {
            $arrInsert['status']  =  0;
        }
        $arrInsert['type']         =   isset($arrData['type'])	?	$arrData['type']	:	self::AUDITTYPE_MOREN;
    	$arrInsert['updateTime']	=	date('Y-m-d H:i:s');
        $arrInsert['name']     =   isset($arrData['author'])  ?  $arrData['author']   :   "";
        $arrInsert['remark']   =    isset($arrData['remark'])  ?  $arrData['remark']   :   "";

    	try 
    	{
    		return self::create($arrInsert);
    	}
    	catch (Exception $ex)
    	{
    		return false;
    	}
    }
    
    /**
     * 根据房源ID更新房源审核信息
     *
     * @param int $intHouseId
     * @param array $arrUpdate
     * @param int $intType
     * @return int|bool
     */
    public function modifyUnitById($intHouseId, $arrUpdate) {
    	if ( empty($intHouseId) || empty($arrUpdate) ) {
    		return false;
    	}
    	$where = "";
    	$intHouseId = is_array($intHouseId) ? array_values($intHouseId) : array(intval($intHouseId));
    	for($i=0;$i<count($intHouseId);$i++){
    		if($i == count($intHouseId)-1){
    			$where.= "houseId=".$intHouseId[$i];
    		}else{
    			$where.= "houseId=".$intHouseId[$i]." or ";
    		}
    	}
        if(isset($arrUpdate['status'])) {
			$arrUpdate['haStatus']  = $arrUpdate['status'];
			unset($arrUpdate['status']);
		}
    	$success = $this->updateAll($where, $arrUpdate);
    	return $success;
    }

    /**
     * 实例化对象
     *
     * @param type $cache
     * @return HouseAuding_Model
     */
    public static function instance ($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self();
    }

    /*
     * 根据房源id 更新审核信息，存在更新，不存在添加
     * @param int $houseId
     * @param array $arrUpdate
     * @param array $auditingType  审核类型
     * @return int|bool
     * */
    public function updateOrAddById($houseId, $arrUpdate, $auditingInfo=array()){
        if(empty($auditingInfo)) return array('status'=>1, 'info'=>'操作失败！');
        $this->begin();
        $auditingInfo['houseUpdate'] = date("Y-m-d H:i:s",time());
        $updateHouseStatus = House::instance()->modifyUnitById(array($houseId), $auditingInfo);
        if($updateHouseStatus)
        {
            $isExit    = self::findFirst("houseId = {$houseId}");
            if($isExit)
            {
                $isExit ->failure	=	isset($arrUpdate['weigui_reason'])	?	$arrUpdate['weigui_reason']	:	0;
                if(isset($arrUpdate['status']))
                {
                    $isExit ->status = $arrUpdate['status'];
                }else{
                    $isExit ->status	=	isset($arrUpdate['weigui_reason'])	?	self::HOUSE_VERNO	:	0;
                }
                $isExit ->updateTime	=	date('Y-m-d H:i:s');
                $isExit ->name     =    isset($arrUpdate['author'])  ?  $arrUpdate['author']   :   "";
                $isExit ->remark     =    isset($arrUpdate['remark'])  ?  $arrUpdate['remark']   :   "";
                $isExit ->type     =    isset($arrUpdate['type'])  ?  $arrUpdate['type']   :   self::AUDITTYPE_MOREN;
                if(!$isExit->update())
                {
                    $this->rollback();
                    return array('status'=>1, 'info'=>'操作失败！');
                }

            }else{
                if(!$this->addByHouseID($arrUpdate))
                {
                    $this->rollback();
                    return array('status'=>1, 'info'=>'操作失败！');
                }
            }
            //更新ES start
            global $sysES;
            $params = $sysES['default'];
            $params['index'] = 'esf';
            $params['type'] = 'house';
            $client = new Es($params);
            $auditingInfo['failure'] = isset($arrUpdate['weigui_reason'])	?	$arrUpdate['weigui_reason']	:	0;
            $intFlag = $client->update(array('id' => $houseId, 'data' => $client->houseFormat($auditingInfo)));
            if( $intFlag === false )
            {
                $this->rollback();return array('status'=>1, 'info'=>'更新索引失败！');
            }
            //更新ES end
            $this->commit();
            return array('status'=>0, 'info'=>'操作成功！');
        }else{
            $this->rollback();
            return array('status'=>1, 'info'=>'操作失败！');
        }

    }

    /**
     * @abstract 根据房源ID批量获取审核信息
     * @param array $ids
     * @return array|bool
     *
     */
    public function getInfoByIds($ids)
    {
        if(!$ids) return false;
        if(is_array($ids))
        {
            $arrBind = $this->bindManyParams($ids);
            $arrCond = "houseId in({$arrBind['cond']}) ";
            $arrParam = $arrBind['param'];
            $arrInfo  = self::find(array(
                $arrCond,
                "bind" => $arrParam
            ),0)->toArray();

            if(is_array($arrInfo)){
                foreach($arrInfo as $value){
                    $result[$value['houseId']] = $value;
                }
                return $result;
            }
            return array();
        }
        else
        {
            return array();
        }
    }

    public function getTop($where, $houseType, $start=0, $intTopnum=10) 
    {
    	$size = $intTopnum+1;
    	$where .= " and h.status =".House::STATUS_ONLINE;
    	if($houseType == 1)
    	{
    		$where .= " and h.type in (".House::TYPE_CIXIN.", ".House::TYPE_ERSHOU.")";
    	}
    	else 
    	{
    		$where .= " and h.type in (".House::TYPE_HEZU.", ".House::TYPE_ZHENGZU.")";
    	}
    	$where .= " and failure = 0 GROUP BY h.parkId  Order by sum Desc limit ".$start.", ".$size; 	

    	$objCount = self::query()
    	->columns('h.parkId, COUNT(h.id) AS sum')
    	->where($where)
    	->leftJoin('House', 'h.id = HouseAuditing.houseId', 'h')
    	->execute();
    	
    	try 
    	{
    		$arr = $objCount->toArray();
    		if(empty($arr))
    		{
    			unset($arr);
    			$arr = false;
    		}
    	}
    	catch(Exception $e)
    	{
    		$arr = false;
    	}
    	return $arr;
    }



    //根据条件获取房源
    public function getHouseInfoByWhere($condition, $size=0, $offset=0, $order="a.houseUpdate"){
        $limit = $size ? "limit $offset, $size":'';
        $sql = "SELECT a.*, b.haUpdate,b.haFailure,b.haName
                FROM house a left JOIN house_auditing b ON a.houseId = b.houseId
                WHERE ".$condition." order by  $order desc ". $limit;
        $res = $this->fetchAll($sql);
        return $res;
    }

    public function getHouseInfoByWhereCount($condition){
        $sql = "SELECT count(*) as num
                FROM house a left JOIN house_auditing b ON a.houseId = b.houseId
                WHERE ".$condition;
        $res = $this->fetchone($sql);
        return $res['num'];
    }


}  