<?php
class ParkBbs extends BaseModel
{
    protected $id;
    protected $parkId;
    protected $projId;
    protected $groupId;
    protected $status;
    protected $update;
    
    //数据状态  status
    const STATUS_VALID   = 1;  //有效
    const STATUS_INVALID = 0;  //失效
    const STATUS_DELETE  = -1; //删除

    public function getSource()
    {
        return 'park_bbs';
    }
    
    public function columnMap()
    {
        return array(
            'pbId'     => 'id',
            'parkId'   => 'parkId',
            'pbProjId'   => 'projId',
            'pbGroupId'  => 'groupId',
            'pbStatus' => 'status',
            'pbUpdate' => 'update'
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
     * @return ParkExt_Model
     */

    public static function instance($cache = true) 
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
    
    /**
     * @abstract 获取论坛信息 By parkId
     * @author Erix xuminwan@sohu-inc.com
     * @param  int $intParkId
     * @return array
     * 
     */
    public function getBbsByParkId($intParkId)
    {
    	if(!$intParkId) return array();
    	$strCond = "status = 1 and parkId = ?1";
    	$arrParam = array(1=>$intParkId);
  	 	$arrBbs = self::findFirst(array(
    			$strCond,
    			'bind'=>$arrParam,
    	),0)->toArray();
    	return $arrBbs;
    }
    
    /**
     * 删除小区论坛信息
     * @param int $parkId
     * @return boolean
     */
    public function del($parkId)
    {
        $parkId = intval($parkId);
        if(!$parkId)
        {
            return false;
        }
        $mores = $this->find(array("conditions"=>"parkId={$parkId}"));
        if($mores)
        {
            foreach($mores as $more)
            {
                $more->status = self::STATUS_DELETE;              
                $delRet = $more->update();
                if(!$delRet)
                    return false;
            }
        }
        else
        {
            return true;
        }
        
        return true;
    }


    public function getAllParkAvgPrice($cityId=1){
        $key = MCDefine::FOCUS_AVG_PRICE_CITY_ID_KEY.$cityId;
        $info = Mem::Instance()->Get($key);
        $info = false;
        if ($info) return json_decode($info, true);
        $mPark = new Park();
        $builder = $mPark->getModelsManager()->createBuilder();
        $builder->from("Park")->innerJoin("ParkBbs","Park.id=parkBbs.parkId","parkBbs")
            ->where("Park.cityId=:cityId:",array(
                "cityId"    =>  $cityId,
            ))
            ->andWhere("parkBbs.groupId>0")
            ->andWhere("Park.status=:status:",array(
                "status"    =>  Park::STATUS_VALID
            ))
            ->columns("Park.salePrice,parkBbs.groupId");
        $info = $builder->getQuery()->execute()->toArray();
        Mem::Instance()->Set($key, json_encode($info), 60*60*24);
        return $info;
    }
}