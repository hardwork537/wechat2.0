<?php
/**
 * @abstract crm资源分配表
 * @author Raul
 * @since  2014-09-23
 */
class Crmallocation extends BaseModel
{

    /**
     *
     * 11:城区
     * 12:板块
     * 13:小区/楼盘
     * 21:公司
     * 22:区域
     * 23:门店
     * 24:经纪人
     */
    const DISTRICT = 11;
    const REGION   = 12;
    const PARK	   = 13;
    const COMPANY  = 21;
    const AREA     = 22;
    const SHOP     = 23;
    const REALTOR  = 24;
	
	const STATUS_INVALID  	=  0;
	const STATUS_VALID 		=  1;
	const STATUS_DELETE		= -1;
	
	public $id;
	public $type;
	public $typeId;
	public $toId1 = 0;
	public $toId2 = 0;
	public $toId3 = 0;
	public $weight  = 0;
	public $expiryDate;
	public $status = self::STATUS_INVALID;
	public $update;

    public function columnMap()
    {
        return array(
            'caId' 			=> 'id',
            'caType' 		=> 'type',
            'caTypeId'		=>'typeId',
            'caToId1'		=>'toId1',
            'caToId2' 		=> 'toId2',
            'caToId3' 		=> 'toId3',
            'caWeight' 		=> 'weight',
            'caExpiryDate' 	=> 'expiryDate',
            'caStatus' 		=> 'status',
            'caUpdate' 		=> 'update',
        );
    }

    public function getSource()
    {
    	return 'crm_allocation';
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    
    /**
     * 实例化对象
     *
     * @param type $cache
     * @return \Area_Model
     */
    public static function instance ($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self();
    }

    //根据销售id获取经纪人数量/门店数量
    public function getRealtorCountBySale($type=self::REALTOR){

        if($type == self::REALTOR){
            $sql = "SELECT count( DISTINCT a.caTypeId) as num  ,a.caToId1 as toId1  FROM crm_allocation  a LEFT JOIN  realtor b ON a.CaTypeId = b.realId WHERE a.caType=".$type." and b.realStatus!=".Realtor::STATUS_DELETE." group by a.caToId1";
            $rs = $this->fetchAll($sql);
            //var_dump($rs);
        }elseif($type == self::SHOP){
            $sql = "SELECT count( DISTINCT a.caTypeId) as num  ,a.caToId1 as toId1  FROM crm_allocation  a LEFT JOIN  shop b ON a.CaTypeId = b.shopId WHERE a.caType=".$type." and b.shopStatus!=".Shop::STATUS_DELETE." group by a.caToId1";
            $rs = $this->fetchAll($sql);
        }else{
            return array();
        }

        $data = array();
        foreach($rs as $k=>$v){
            $data[$v['toId1']] = $v['num'];
        }
        return $data;
    }

    //获取在用经纪人数
    public function getActiveRealtor($userId, $realStatus, $cityId=1){
        $sql = "SELECT count( DISTINCT b.realId) as num from crm_allocation a left JOIN realtor b ON a.caTypeId = b.realId WHERE a.caType= ".self::REALTOR." AND b.realStatus in ($realStatus) AND a.caToId1=".$userId." AND b.cityId=$cityId" ;
        $res = $this->fetchOne($sql);
        return $res;
    }

    //获取优质经纪人数
    public function getQualityRealtor($userId){
        $sql = "SELECT count( DISTINCT b.realId) as num from crm_allocation a left JOIN zeb_realtor_m".date("Ym",time()-86400)." b ON a.caTypeId = b.realId WHERE a.caType= ".self::REALTOR." AND b.zrIsGood =1 AND a.caToId1=".$userId." AND b.zrDate = ".date("Y-m-d",time()-86400);
        $res = $this->fetchOne($sql);
        return $res;
    }
    
    /**
     * @abstract 批量获取销售、客服信息
     * @param int        $type 
     * @param array|int  $typeIds 
     * @param string     $columns
     * @return array
     * 
     */
	public function getAllocationByToIds($type, $typeIds, $columns = '', $status = self::STATUS_VALID)
	{

		if(empty($typeIds)) 
            return array();
		if(is_array($typeIds))
		{
			$arrBind = $this->bindManyParams($typeIds);
			$arrCond = "typeId in({$arrBind['cond']}) and type={$type} and status={$status}";
			$arrParam = $arrBind['param'];
            $condition = array(
					$arrCond,
					"bind" => $arrParam,
			);   
         
		}
		else
		{
            $condition['conditions'] = "typeId={$typeIds} and type={$type} and status={$status}";
		}

        
        $columns && $condition['columns'] = $columns;	

        $arrAllocation  = self::find($condition, 0)->toArray();

		$arrRallocation = array();

		foreach($arrAllocation as $value)
		{
			$arrRallocation[$value['typeId']] = $value;
		}
		return $arrRallocation;
	}
    
    /**
     * 根据条件获取资源
     * @param string $where
     * @param string $columns
     * @param string $order
     * @param int    $offset
     * @param int    $limit
     * @return array
     */
    public function getAllocationByCondition($where, $columns = '', $order = '', $offset = 0, $limit = 0)
    {
        if(!$where)
        {
            return array();
        }
        $condition = array(
            'conditions' => $where
        );
        $order && $condition['order'] = $order;
        $limit > 0 && $condition['limit'] = array('offset'=>$offset, 'number'=>$limit);
        $columns && $condition['columns'] = $columns;
        
        $res = self::find($condition, 0)->toArray();
        $data = array();
        foreach($res as $v)
        {
            $data[$v['typeId']] = $v;
        }
        
        return $data;
    }
    
    /**
     * 添加销售、客服
     * @param int $type
     * @param int $typeId
     * @param int $saleId
     * @param int $CSId
     * @return boolean
     */
    public function addAllocation($type, $typeId, $saleId = false, $CSId = false)
    {
        $where = "type={$type} and typeId={$typeId}";
        $num = self::count($where);
        if($num > 0)
        {
            $allocations = self::find($where);
            foreach($allocations as $allocation)
            {              
                false !== $saleId && $allocation->toId1 = $saleId;
                false !== $CSId && $allocation->toId2 = $CSId;
                $allocation->status = self::STATUS_VALID;
                $allocation->update = date('Y-m-d H:i:s');
                if(!$allocation->update())
                {
                    return false;
                }              
            }      
            return true;
        }
        else
        {
            $allocation = self::instance(false);
            $allocation->type = $type;
            $allocation->typeId = $typeId;
            false !== $saleId && $allocation->toId1 = $saleId;
            false !== $CSId && $allocation->toId2 = $CSId;
            $allocation->status = self::STATUS_VALID;
            if($allocation->create())
            {
                return true;
            }
            return false;
        }
    }
}