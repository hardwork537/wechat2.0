<?php

class HouseOplog extends BaseModel
{
    public $id;
    public $houseId;
    public $op;
    public $opId;
    public $opName;
    public $opValue;
    public $status;
    public $remark;
    public $time;
    const HOUSE_REALTOR_AUDIT  = "审核房源";
    const HOUSE_PIC_AUDIT      = "审核图片";
    const HOUSE_HD_AUDIT       = "审核高清";
    const HOUSE_DEL            = "删除房源";
    const HOUSE_CREATE         = "发布房源";
    const HOUSE_OFFLINE        = "下架房源";
    const HOUSE_ONLINE         = "上架房源";

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'hlId' => 'id',
            'houseId' => 'houseId', 
            'hlOp' => 'op',
            'hlOpId' => 'opId',
            'hlOpName' => 'opName',
            'hlOpValue' => 'opValue',
            'hlStatus' => 'status',
            'hlRemark' => 'remark',
            'hlTime' => 'time'
        );
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

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }


    //根据houseId获取审核信息
    public function getInfoById($houseId){
        if(!$houseId) return array();
        return  self::findFirst([
            "conditions" => "houseId=".$houseId." AND op in ('".self::HOUSE_REALTOR_AUDIT."','".self::HOUSE_PIC_AUDIT."')",
            "order" => "time desc",
        ],0)->toArray();
    }


    /*
 * 根据房源id 更新审核信息，添加审核记录
 * @param int $houseId
 * @param array $arrUpdate
 * @param array $auditingType  审核类型
 * @return int|bool
 * */
    public function updateOrAddById($houseId, $arrUpdate, $auditingInfo=array(), $strType = 'Sale'){
        if(empty($auditingInfo)) return array('status'=>1, 'info'=>'操作失败！');
        $this->begin();
        $auditingInfo['houseUpdate'] = date("Y-m-d H:i:s",time());
        $auditingInfo['houseAuditing'] = date("Y-m-d H:i:s",time());
        $ESarr = $auditingInfo;
        if(isset($auditingInfo['roleType'])){
            unset($auditingInfo['roleType']);
        }

        if(!empty($auditingInfo) && $auditingInfo["houseStatus"] == House::STATUS_RECYCLE){
            $updateHouseStatus = House::instance()->delHouseByHouseId(array($houseId), $strType);//删除
        }else{
            $updateHouseStatus = House::instance()->modifyUnitById(array($houseId), $auditingInfo);//修改
        }

        if($updateHouseStatus)
        {
            if(!$this->addByHouseID($arrUpdate))
            {
                $this->rollback();
                return array('status'=>1, 'info'=>'操作失败1！');
            }
            //更新ES start

            global $sysES;
            $params = $sysES['default'];
            $params['index'] = 'esf';
            $params['type'] = 'house';
            $client = new Es($params);
            $ESarr['failure'] = isset($arrUpdate['opValue'])	?	$arrUpdate['opValue']	:	0;
            $intFlag = $client->update(array('id' => $houseId, 'data' => $client->houseFormat($ESarr)));
            if( $intFlag === false )
            {
                $this->rollback();return array('status'=>1, 'info'=>'房源id：'.$houseId.'更新索引失败！');
            }
            //更新ES end
            $this->commit();
            return array('status'=>0, 'info'=>'操作成功！');
        }else{
            $this->rollback();
            return array('status'=>1, 'info'=>'操作失败2！');
        }
    }
    //添加操作记录
    public function addByHouseID( $arrData )
    {
        if( empty($arrData) )	return false;
        $arrInsert = array();
        $arrInsert['houseId']	=	$arrData['houseId'];
        $arrInsert['opValue']	=	isset($arrData['opValue'])	?	$arrData['opValue']	:	0;//失败原因
        $arrInsert['status']    =   isset($arrData['hlStatus'])? $arrData['hlStatus'] : (isset($arrData['status'])? $arrData['status']:0);
        $arrInsert['op']        =   isset($arrData['type'])	?	$arrData['type']	:	self::HOUSE_REALTOR_AUDIT;
        $arrInsert['opId']      =   isset($arrData['authorId'])  ?  $arrData['authorId']   :   0;
        $arrInsert['opName']    =   isset($arrData['author'])  ?  $arrData['author']   :   "";
        $arrInsert['remark']    =   isset($arrData['remark'])  ?  $arrData['remark']   :   "";
        $arrInsert['time']	    =	date('Y-m-d H:i:s');

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
     * @abstract 根据房源ID批量获取审核信息
     * @param array $ids
     * @param string $op
     * @return array|bool
     *
     */
    public function getInfoByIds($ids, $op = "")
    {
        if(!$ids) return false;
        if(is_array($ids))
        {
            $arrBind = $this->bindManyParams($ids);
            $arrCond = "houseId in({$arrBind['cond']}) ";
            !empty($op) && $arrCond .= " and op in('".(is_array($op) ? implode("','", $op) : $op)."')";
            $arrParam = $arrBind['param'];
            $arrInfo  = self::find(array(
                $arrCond,
                "order" => 'id asc',
                "bind" => $arrParam
            ),0);
			$arrInfo = empty($arrInfo) ? array() : $arrInfo->toArray();

            if(is_array($arrInfo) && !empty($arrInfo)){
                foreach($arrInfo as $value){
                    $result[$value['houseId']] = $value;//同一房源取最新一条
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

    /*
     * 审核违规扣经纪人积分
     * @param
     * */
    public function realtorScore($houseId){
        //如果是违规，则扣积分
        $houseinfo = House::findFirst([
            "conditions"=>"id =".$houseId,
            "columns"=>"id,realId"
        ], 0)->toArray();
        if(empty($houseinfo)){
            return false;
        }
        return $intFlag = Quene::Instance()->Put('realtor', array('action' => 'score', 'type' => VipScoreDetail::PROJECT_ILLEGAL_UNIT, 'realId' =>$houseinfo['realId'], 'ids' => $houseId, 'time' => date('Y-m-d H:i:s', time())));
    }


}
