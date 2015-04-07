<?php
use Aws\S3\Model\MultipartUpload\ParallelTransfer;
class House extends BaseModel
{
    //房源状态常量status
    const STATUS_ONLINE = 1; //发布
    const STATUS_OFFLINE = 2; //下架
    const STATUS_DELETE = 4; //删除
    const STATUS_RECYCLE = 5; //回收站
    const STATUS_VIOLATE = 6; //违规-- 已废弃， 请用下面 审核状态里面的违规
    const STATUS_SLEEP = 7; //休眠
	
	//房源类别houseType
	const TYPE_ZHENGZU = 10;
	const TYPE_HEZU = 11;
	const TYPE_XINFANG = 20;
	const TYPE_CIXIN = 21;
	const TYPE_ERSHOU = 22;

	//审核状态status 0:待审核 1:审核过 -1:违规
    const HOUSE_VERING = 0;
    const HOUSE_VERED = 1;
    const HOUSE_VERNO = -1;

    //是否推荐房源(精品房源)
	const FINE_YES = 1;
	const FINE_NO = 2;

    //房源类型常量type
    const TYPE_SALE = 2; //出售房源
    const TYPE_RENT = 1; //出租房源
	
	//房源类型1、中介 2、个人
	const ROLE_REALTOR = 1;
	const ROLE_SELF = 2;
    const ROLE_INDIX = 3; //独立经纪人
	
	//是否标签 tags 字段：0: 否 ，1:急 2:免 3:急 免
	const HOUSE_NOTAG = 0;
	const HOUSE_JITAG = 1;
	const HOUSE_FREETAG = 2;
	const HOUSE_ALLTAG = 3;
	
	//房源品质 quality 字段：0未知 1普通 2优质 3高清
	const QUALITY_NULL = 0;
	const QUALITY_COMMON = 1;
	const QUALITY_GOOD = 2;
	const QUALITY_HIGH = 3;

    //是否现房type_type
    const TYPE_TYPE_DEFAULT = 0; //二手房默认值
    const TYPE_TYPE_BEING = 1; //新房期房
    const TYPE_TYPE_DELIVER = 2; //新房现房
    
    const MIN_HOUSE_ID = 50000000;

    public $id;
    public $parkId = 0;
    public $regId = 0;
    public $distId = 0;
    public $cityId;
    public $hoId = 0;
    public $realId = 0;
    public $shopId = 0;
    public $areaId = 0;
    public $comId = 0;
    public $type;
    public $price = 0;
    public $unit = 0;
    public $bedRoom = 0;
    public $livingRoom = 0;
    public $bathRoom = 0;
    public $bA = 0;
    public $uA = 0;
    public $decoration = '';
    public $orientation = 0;
    public $floor = 0;
    public $floorMax = 0;
    public $buildType = 0;
    public $buildYear = 0;
    public $propertyType = 0;
    public $lookTime = 0;
    public $propertyNature = 0;
    public $picId = 0;
    public $picExt = 0;
    public $quality = 1;
    public $tags = 0;
    public $fine = 2;
    public $timing = 0;
    public $verification = 0;
    public $status = 1;
    public $tagTime = '0000-00-00 00:00:00';
    public $fineTime = '0000-00-00 00:00:00';
    public $delTime = '0000-00-00 00:00:00';
    public $create;
    public $houseUpdate;//请不要修改否则会影响columns中设置该字段
    public $xiajia = '0000-00-00 00:00:00';
    public $roleType = 1;
    public $typeType = 0;
    public $openDate = '0000-00-00';
    public $deliverDate = '0000-00-00';
    public $auditing = "0000-00-00";
    public $code = 0;
    
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

    public function getParkId()
    {
        return $this->parkId;
    }

    public function setParkId($parkId)
    {
        if(preg_match('/^\d{1,10}$/', $parkId == 0) || $parkId > 4294967295)
        {
            return false;
        }
        $this->parkId = $parkId;
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

    public function getHoId()
    {
        return $this->hoId;
    }

    public function setHoId($hoId)
    {
        if(preg_match('/^\d{1,10}$/', $hoId == 0) || $hoId > 4294967295)
        {
            return false;
        }
        $this->hoId = $hoId;
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

    public function getShopId()
    {
        return $this->shopId;
    }

    public function setShopId($shopId)
    {
        if(preg_match('/^\d{1,10}$/', $shopId == 0) || $shopId > 4294967295)
        {
            return false;
        }
        $this->shopId = $shopId;
    }

    public function getAreaId()
    {
        return $this->areaId;
    }

    public function setAreaId($areaId)
    {
        if(preg_match('/^\d{1,10}$/', $areaId == 0) || $areaId > 4294967295)
        {
            return false;
        }
        $this->areaId = $areaId;
    }

    public function getComId()
    {
        return $this->comId;
    }

    public function setComId($comId)
    {
        if(preg_match('/^\d{1,10}$/', $comId == 0) || $comId > 4294967295)
        {
            return false;
        }
        $this->comId = $comId;
    }

    public function getHouseType()
    {
        return $this->type;
    }

    public function setHouseType($houseType)
    {
        if(preg_match('/^\d{1,3}$/', $houseType == 0) || $houseType > 255)
        {
            return false;
        }
        $this->type = $houseType;
    }

    public function getHousePrice()
    {
        return $this->housePrice;
    }

    public function setHousePrice($housePrice)
    {
        if(preg_match('/^\d{1,10}$/', $housePrice == 0) || $housePrice > 4294967295)
        {
            return false;
        }
        $this->housePrice = $housePrice;
    }

    public function getHouseUnit()
    {
        return $this->houseUnit;
    }

    public function setHouseUnit($houseUnit)
    {
        if(preg_match('/^\d{1,10}$/', $houseUnit == 0) || $houseUnit > 4294967295)
        {
            return false;
        }
        $this->houseUnit = $houseUnit;
    }

    public function getHouseBedRoom()
    {
        return $this->houseBedRoom;
    }

    public function setHouseBedRoom($houseBedRoom)
    {
        if(preg_match('/^\d{1,3}$/', $houseBedRoom == 0) || $houseBedRoom > 255)
        {
            return false;
        }
        $this->houseBedRoom = $houseBedRoom;
    }

    public function getHouseLivingRoom()
    {
        return $this->houseLivingRoom;
    }

    public function setHouseLivingRoom($houseLivingRoom)
    {
        if(preg_match('/^\d{1,3}$/', $houseLivingRoom == 0) || $houseLivingRoom > 255)
        {
            return false;
        }
        $this->houseLivingRoom = $houseLivingRoom;
    }

    public function getHouseBathRoom()
    {
        return $this->houseBathRoom;
    }

    public function setHouseBathRoom($houseBathRoom)
    {
        if(preg_match('/^\d{1,3}$/', $houseBathRoom == 0) || $houseBathRoom > 255)
        {
            return false;
        }
        $this->houseBathRoom = $houseBathRoom;
    }

    public function getHouseBA()
    {
        return $this->houseBA;
    }

    public function setHouseBA($houseBA)
    {
        if(preg_match('/^\d{1,5}$/', $houseBA == 0) || $houseBA > 65535)
        {
            return false;
        }
        $this->houseBA = $houseBA;
    }

    public function getHouseUA()
    {
        return $this->houseUA;
    }

    public function setHouseUA($houseUA)
    {
        if(preg_match('/^\d{1,5}$/', $houseUA == 0) || $houseUA > 65535)
        {
            return false;
        }
        $this->houseUA = $houseUA;
    }

    public function getHouseDecoration()
    {
        return $this->houseDecoration;
    }

    public function setHouseDecoration($houseDecoration)
    {
        if(preg_match('/^\d{1,3}$/', $houseDecoration == 0) || $houseDecoration > 255)
        {
            return false;
        }
        $this->houseDecoration = $houseDecoration;
    }

    public function getHouseOrientation()
    {
        return $this->houseOrientation;
    }

    public function setHouseOrientation($houseOrientation)
    {
        if(preg_match('/^\d{1,3}$/', $houseOrientation == 0) || $houseOrientation > 255)
        {
            return false;
        }
        $this->houseOrientation = $houseOrientation;
    }

    public function getHouseFloor()
    {
        return $this->houseFloor;
    }

    public function setHouseFloor($houseFloor)
    {
        if(preg_match('/^\d{1,3}$/', $houseFloor == 0) || $houseFloor > 255)
        {
            return false;
        }
        $this->houseFloor = $houseFloor;
    }

    public function getHouseFloorMax()
    {
        return $this->houseFloorMax;
    }

    public function setHouseFloorMax($houseFloorMax)
    {
        if(preg_match('/^\d{1,3}$/', $houseFloorMax == 0) || $houseFloorMax > 255)
        {
            return false;
        }
        $this->houseFloorMax = $houseFloorMax;
    }

    public function getHouseBuildType()
    {
        return $this->houseBuildType;
    }

    public function setHouseBuildType($houseBuildType)
    {
        if(preg_match('/^\d{1,3}$/', $houseBuildType == 0) || $houseBuildType > 255)
        {
            return false;
        }
        $this->houseBuildType = $houseBuildType;
    }

    public function getHouseBuildYear()
    {
        return $this->houseBuildYear;
    }

    public function setHouseBuildYear($houseBuildYear)
    {
        if(preg_match('/^\d{1,5}$/', $houseBuildYear == 0) || $houseBuildYear > 65535)
        {
            return false;
        }
        $this->houseBuildYear = $houseBuildYear;
    }

    public function getHousePropertyType()
    {
        return $this->housePropertyType;
    }

    public function setHousePropertyType($housePropertyType)
    {
        if(preg_match('/^\d{1,3}$/', $housePropertyType == 0) || $housePropertyType > 255)
        {
            return false;
        }
        $this->housePropertyType = $housePropertyType;
    }

    public function getHouseLookTime()
    {
        return $this->houseLookTime;
    }

    public function setHouseLookTime($houseLookTime)
    {
        if(preg_match('/^\d{1,2}$/', $houseLookTime == 0) || $houseLookTime > 255)
        {
            return false;
        }
        $this->houseLookTime = $houseLookTime;
    }

    public function getHousePropertyNature()
    {
        return $this->housePropertyNature;
    }

    public function setHousePropertyNature($housePropertyNature)
    {
        if(preg_match('/^\d{1,2}$/', $housePropertyNature == 0) || $housePropertyNature > 255)
        {
            return false;
        }
        $this->housePropertyNature = $housePropertyNature;
    }

    public function getHousePicId()
    {
        return $this->housePicId;
    }

    public function setHousePicId($housePicId)
    {
        if(preg_match('/^\d{1,10}$/', $housePicId == 0) || $housePicId > 4294967295)
        {
            return false;
        }
        $this->housePicId = $housePicId;
    }

    public function getHousePicExt()
    {
        return $this->housePicExt;
    }

    public function setHousePicExt($housePicExt)
    {
        if(preg_match('/^\d{1,3}$/', $housePicExt == 0) || $housePicExt > 255)
        {
            return false;
        }
        $this->housePicExt = $housePicExt;
    }

    public function getHouseQuality()
    {
        return $this->houseQuality;
    }

    public function setHouseQuality($houseQuality)
    {
        if(preg_match('/^\d{1,3}$/', $houseQuality == 0) || $houseQuality > 255)
        {
            return false;
        }
        $this->houseQuality = $houseQuality;
    }

    public function getHouseTags()
    {
        return $this->tags; 
    }

    public function setHouseTags($houseTags)
    {
        if(preg_match('/^\d{1,3}$/', $houseTags == 0) || $houseTags > 255)
        {
            return false;
        }
        $this->tags = $houseTags;
    }

    public function getHouseFine()
    {
        return $this->houseFine;
    }

    public function setHouseFine($houseFine)
    {
        if(preg_match('/^\d{1,3}$/', $houseFine == 0) || $houseFine > 255)
        {
            return false;
        }
        $this->houseFine = $houseFine;
    }

    public function getHouseTiming()
    {
        return $this->houseTiming;
    }

    public function setHouseTiming($houseTiming)
    {
        if(preg_match('/^\d{1,3}$/', $houseTiming == 0) || $houseTiming > 255)
        {
            return false;
        }
        $this->houseTiming = $houseTiming;
    }

    public function getHouseVerification()
    {
        return $this->houseVerification;
    }

    public function setHouseVerification($houseVerification)
    {
        if(preg_match('/^-?\d{1,3}$/', $houseVerification) == 0 || $houseVerification > 127 || $houseVerification < -128)
        {
            return false;
        }
        $this->houseVerification = $houseVerification;
    }

    public function getHouseStatus()
    {
        return $this->houseStatus;
    }

    public function setHouseStatus($houseStatus)
    {
        if(preg_match('/^-?\d{1,3}$/', $houseStatus) == 0 || $houseStatus > 127 || $houseStatus < -128)
        {
            return false;
        }
        $this->houseStatus = $houseStatus;
    }

    public function getHouseDelTime()
    {
        return $this->delTime;
    }

    public function setHouseDelTime($delTime)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $delTime) == 0 || strtotime($delTime) == false)
        {
            return false;
        }
        $this->delTime = $delTime;
    }

    public function getHouseTagTime()
    {
        return $this->tagTime;
    }

    public function setHouseTagTime($tagTime)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $tagTime) == 0 || strtotime($tagTime) == false)
        {
            return false;
        }
        $this->tagTime = $tagTime;
    }

    public function getHouseFineTime()
    {
        return $this->fineTime;
    }

    public function setHouseFineTime($fineTime)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $fineTime) == 0 || strtotime($fineTime) == false)
        {
            return false;
        }
        $this->fineTime = $fineTime;
    }

    public function getHouseUpdate()
    {
        return $this->houseUpdate;
    }

    public function setHouseUpdate($houseUpdate)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $houseUpdate) == 0 || strtotime($houseUpdate) == false)
        {
            return false;
        }
        $this->houseUpdate = $houseUpdate;
    }

    public function getHouseCreate()
    {
        return $this->create;
    }

    public function setHouseCreate($create)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $create) == 0 || strtotime($create) == false)
        {
            return false;
        }
        $this->create = $create;
    }

    public function getHouseXiajia()
    {
        return $this->houseXiajia;
    }

    public function setHouseXiajia($houseXiajia)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $houseXiajia) == 0 || strtotime($houseXiajia) == false)
        {
            return false;
        }
        $this->houseXiajia = $houseXiajia;
    }

    public function getHouseRoleType()
    {
        return $this->roleType;
    }

    public function setHouseRoleType($houseRoleType)
    {

        $this->roleType = $houseRoleType;
    }
    public function getHouseTypeType()
    {
        return $this->typeType;
    }

    public function setHouseTypeType($typeType)
    {

        $this->typeType = $typeType;
    }

    public function getHouseOpenDate()
    {
        return $this->openDate;
    }

    public function setHouseOpenDate($openDate)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2}$/', $openDate) == 0 || strtotime($openDate) == false)
        {
            return false;
        }
        $this->openDate = $openDate;
    }

    public function getHouseDeliverDate()
    {
        return $this->houseDeliverDate;
    }

    public function setHouseDeliverDate($houseDeliverDate)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2}$/', $houseDeliverDate) == 0 || strtotime($houseDeliverDate) == false)
        {
            return false;
        }
        $this->houseDeliverDate = $houseDeliverDate;
    }

    public function getSource()
    {
        return 'house';
    }

    public function columnMap()
    {
        return array(
            'houseId' => 'id',
            'parkId' => 'parkId',
            'regId' => 'regId',
            'distId' => 'distId',
            'cityId' => 'cityId',
            'hoId' => 'hoId',
            'realId' => 'realId',
            'shopId' => 'shopId',
            'areaId' => 'areaId',
            'comId' => 'comId',
            'houseType' => 'type',
            'housePrice' => 'price',
            'houseUnit' => 'unit',
            'houseBedRoom' => 'bedRoom',
            'houseLivingRoom' => 'livingRoom',
            'houseBathRoom' => 'bathRoom',
            'houseBA' => 'bA',
            'houseUA' => 'uA',
            'houseDecoration' => 'decoration',
            'houseOrientation' => 'orientation',
            'houseFloor' => 'floor',
            'houseFloorMax' => 'floorMax',
            'houseBuildType' => 'buildType',
            'houseBuildYear' => 'buildYear',
            'housePropertyType' => 'propertyType',
        	'houseLookTime'	 => 'lookTime',
        	'housePropertyNature' => 'propertyNature',
            'housePicId' => 'picId',
            'housePicExt' => 'picExt',
            'houseQuality' => 'quality',
            'houseTags' => 'tags',
            'houseFine' => 'fine',
            'houseTiming' => 'timing',
            'houseVerification' => 'verification',
            'houseStatus' => 'status',
            'houseDelTime' => 'delTime',
        	'houseTagTime' => 'tagTime',
        	'houseFineTime' => 'fineTime',
            'houseUpdate' => 'houseUpdate',
            'houseCreate' => 'create',
            'houseXiajia' => 'xiajia',
            'houseRoleType' => 'roleType',
            "houseTypeType" =>  'typeType',
        	'houseOpenDate' => 'openDate',
        	'houseDeliverDate' => 'deliverDate',
        	'houseCode' => 'code',
            'houseAuditing'=>'auditing',
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster'); 
        $this->hasManyToMany(
        		'houseId',
        		'Sale',
        		'houseId',
        		'HouseExt',
        		'houseId',
        		'HouseMore',
        		'houseId'
        );
    }

    public function onConstruct()
    {
		\Phalcon\Mvc\Model::setup(array(
			'notNullValidations' => false
		));
    }
    
    /**
     * 获取指定经纪人名下所有的有效发布房源数量
     *
     */
    public function getTotal($realId,$houseType){
    	if ( empty($realId) ) {
    		return false;
    	}
    	if (empty($houseType)){
    		return false;
    	}
    	
    	$where =" status=".self::STATUS_ONLINE;
    	$where .=" and realId=".$realId;
    	if($houseType == 'Sale'){
    		$where.=" and (type=".self::TYPE_ERSHOU." or type=".self::TYPE_CIXIN." or type=".self::TYPE_XINFANG.")";
    	}else{
    		$where.=" and (type=".self::TYPE_ZHENGZU." or type=".self::TYPE_HEZU.")";
    	}
    	
        return $this->getCount($where);
    }
    
    /**
     * 获取指定小区下所有的有效发布房源数量
     *
     */
    public function getTotalByParkId($parkId,$houseType = 'all'){
    	if ( empty($parkId) ) {
    		return false;
    	}
    	if (empty($houseType)){
    		return false;
    	}
    	
    	$where =" status=".self::STATUS_ONLINE;
    	$where .=" and parkId=".$parkId;
    	if($houseType == 'Sale'){
    		$where.=" and (type=".self::TYPE_ERSHOU." or type=".self::TYPE_CIXIN." or type=".self::TYPE_XINFANG.")";
    	}elseif($houseType == 'Rent'){
    		$where.=" and (type=".self::TYPE_ZHENGZU." or type=".self::TYPE_HEZU.")";
        }else{
            $where.=" and (type=".self::TYPE_ERSHOU." or type=".self::TYPE_CIXIN." or type=".self::TYPE_XINFANG." or type=".self::TYPE_ZHENGZU." or type=".self::TYPE_HEZU.")";
        }
    	
        return $this->getCount($where);
    }
    
    /**
     * 获取指定条件下的房源信息
     *
     */
    public function getHouse($where=null,$order="",$offset=0,$limit=0,$select=""){
   
        $con = array();
    	if(!is_null($where)){
    		if(is_array($where)){
    			$con['conditions'] = implode(" and ",$where);
    		}elseif(is_object($where)){
    			$con['conditions'] = implode(" and ",(array)$where);
    		}else{
    			$con['conditions'] =$where;
    		}
    	}
        
    	$limit = intval($limit);
    	$offset = intval($offset);
    	if($limit>0){
    		$con['limit'] = array('number'=>$limit,'offset'=>$offset);
    	}
    	if(!empty($order)){
    		$con['order'] = $order;
    	}
    	if(!empty($select)){
    		$con['columns'] = $select;
    	}
        //var_dump($con);exit;
    	return self::find($con);
        
    }
	
	/**
	 * 设置房源封面图
	 *
	 * @param int $intSaleId
	 * @param int $intImageId
	 * @param string $strImageExt
	 * @return int|bool
	 */
	public function setSurfaceplot($intHouseId, $intImageId = 0, $strImageExt = '') {
		if ( empty($intImageId) || empty($strImageExt) ) {
			return false;
		}
		$arrUpdate['housePicId'] = $intImageId;
		$arrUpdate['housePicExt'] = array_search($strImageExt, $GLOBALS['HOUSE_PIC_EXT']);
		$success = $this->updateAll("houseId=".$intHouseId, $arrUpdate);
		return $success;
	}
	

	/**
	 * 根据房源ID更新房源信息
	 *
	 * @param array $intHouseId
	 * @param array $arrUpdate
	 * @return int|bool
	 */
	public function modifyUnitById($intHouseId, $arrUpdate) {
		if ( empty($intHouseId) || empty($arrUpdate) ) {
			return false;
		}
		$param = array();
		$values = array();
		$intHouseId = array_values($intHouseId);
		$where = "";
		for($i=0;$i<count($intHouseId);$i++){
			if($i == count($intHouseId)-1){
			   $where.= "houseId=".$intHouseId[$i];
			}else{
               $where.= "houseId=".$intHouseId[$i]." or ";
			}
		}
		$success = $this->updateAll($where,$arrUpdate);
		return $success;
	}
	
	/**
	 * 根据房源ID获取房源信息
	 *
	 * @param int $intUnitId
	 * @return array|bool
	 */
	public function getUnitById( $inUnitId, $houseType = 'Sale', $houseRoleType = House::ROLE_REALTOR,$verification =0)
	{
		if ( empty($inUnitId) )
		{
			return false;
		}
		if ( empty($houseType) )
		{
			return false;
		}
		$where =" id=".$inUnitId." and status in (".self::STATUS_ONLINE.",".self::STATUS_OFFLINE.")";
		if ( $houseType == 'Sale' )
		{
			$where.=" and (type=".self::TYPE_ERSHOU." or type=".self::TYPE_CIXIN." or type=".self::TYPE_XINFANG.")";
		} 
		else 
		{
			$where.=" and type in (".self::TYPE_ZHENGZU.",".self::TYPE_HEZU.")";
		}

        if($verification == 1)
        {
            $where .= " and verification > -1";
        }

        if ($houseRoleType){
            $where .= " and roleType = {$houseRoleType}";
        }


		return self::findfirst( $where );
	}
	
	/**
	 * @abstract 根据房源ID获取房源信息,包括个人房源
	 * @author Eric xuminwan@sohu-inc.com
	 * @param unknown $ids
	 * @return array|bool
	 */
	public function getUnitByIds( $ids, $houseType = 'Sale', $houseRoleType = House::ROLE_REALTOR)
	{
		if ( empty($ids) )
		{
			return false;
		}
		if ( empty($houseType) )
		{
			return false;
		}
		if (is_array($ids))
		{
			$strIds = implode(',', $ids);
			$where = "id in({$strIds}) and status in(".self::STATUS_ONLINE.",".self::STATUS_OFFLINE.")";
			if ( $houseType == 'Sale' )
			{
				$where.=" and (type=".self::TYPE_ERSHOU." or type=".self::TYPE_CIXIN." or type=".self::TYPE_XINFANG.")";
			} else {
				$where.=" and type in (".self::TYPE_ZHENGZU.",".self::TYPE_HEZU.")";
			}
            if ($houseRoleType){
                $where .=" and roleType = {$houseRoleType}";
            }

			return self::find( $where );
		}
		else
		{
			return self::getUnitById($ids);
		}
	}
	
	/**
	 * 获取指定经纪人名下所有的有效发布推荐房源数量
	 *
	 * @param int $intId
	 * @return int
	 */
	public function getRecommendTotal($intId){
		if(empty($intId)){
			return false;
		}
		$con['conditions'] = "realId=".$intId." and status=".self::STATUS_ONLINE." and fine=".self::FINE_YES;
		$con['columns'] = "id";
		$arrData = self::find($con);
		return $arrData->count();
	}
	
	/**
	 * 设置取消推荐
	 *
	 * @param int $intHouseId $arrData
	 * @return int|bool
	 */
	public function setRecommend($intHouseId,$arrData){
		if ( ! is_numeric($intHouseId) || $intHouseId <= 0  ) {
			return false;
		}
		$param = array();
		$values = array();
		foreach($arrData as $key=>$value){
			$param[] = $key;
			$values[] = $value;
		}
		$db = $this->getDi()->getShared('esfMaster');
		$success = $db->update(
				"house",
				$param,
				$values,
				"houseId=".$intHouseId
		);
		return $success;;
	}

	
	/**
	 * 设置房源标签
	 *
	 * @param int $intHouseId
	 * @return int|bool
	 */
	public function setTag($intHouseId,$Sign,$Type)
	{
		if ( ! is_numeric($intHouseId) || $intHouseId <= 0  ) 
		{
			return false;
		}
		$db = $this->getDi()->getShared('esfMaster');
		if ( $Type == 'Sale' )
		{
			if ( !empty($Sign) ) 
			{
				$intTagTime = date('Y-m-d H:i:s');
			}
			$param[]="houseTagTime";
			$values[]=$intTagTime;			
		} 
		else 
		{
			//兼容开放API
			if ( is_numeric($Sign) ) 
			{	
			    $param[]="houseTags";
			    $values[]=$Sign;			
			}
			else 
			{
				$param[]="houseTags";
				$values[]=(int)$GLOBALS['SITE_CONFIG']['FLAG_TYPE'][$Sign];
			}
		}
		$success = $db->update(
				"house",
				$param,
				$values,
				"houseId=".$intHouseId
		);
		return $success;
	}
    
    /**
     * 获取指定经纪人的发布下架房源ID
     *
     * @param int $intBrokerId
     * @return array
     */
    public function getValidHouseIdByRealtorId( $intRealId ) 
    {
    	$arrUnitId = array();
    	$arrUnit = self::find( "realId = {$intRealId} ");
    	
    	if( !empty($arrUnit) )
    	{
    		foreach ( $arrUnit->toArray() as $k => $v ) 
    		{
    			$arrUnitId[] = $v['id'];
    		}
    	}
    	unset($arrUnit);
    	return $arrUnitId;
    }

    /**
     * 获取在线房源的ID
     *
     * @param int $intBrokerId
     * @return array
     */
    public function getOnlineHouseIdByRealId( $intRealId,$HouseType  ) 
    {
    	if( empty($intRealId) && empty($HouseType) )	return false;
    	
    	if ( $HouseType == House::TYPE_ERSHOU )
    	{
    		$strHouseType = self::TYPE_ERSHOU.",".self::TYPE_CIXIN.",".self::TYPE_XINFANG;
    	}
    	else 
    	{
    		$strHouseType = self::TYPE_ZHENGZU.",".self::TYPE_HEZU;
    	}
    	
    	$arrUnitId = array();
    	$arrUnit = self::find( "realId = {$intRealId} AND status = " . House::STATUS_ONLINE. ' AND type IN (' . $strHouseType . ')' );
    	
    	if ( !empty($arrUnit) ) 
    	{
    		foreach ( $arrUnit->toArray() as $k => $v ) 
    		{
    			$arrUnitId[] = $v['id'];
    		}
    	}
    	unset($arrUnit);
    	return $arrUnitId;
    }
    
    /**
     * 删除房源
     * @param unknown $arrHouseId
     * @param unknown $strType	操作类型
     */
    public function delHouseByHouseId( $arrHouseId , $strType = 'Sale', $status = House::STATUS_RECYCLE)
    {
    	if( empty($arrHouseId) ) return false;
    	
    	//区分操作类型
    	if ( $strType == 'Sale' ) {//包括新房二手房
    		$clsUnit = new Sale();
    	} else {
    		$clsUnit = new Rent();
    	}
    	
    	foreach ($arrHouseId as $intHouseId)
    	{
	    	$this->begin();
	    	//更新House表房源状态
			$arrData = array();
	    	$arrData['status'] = $status;
	    	$arrData['tagTime'] = '0000-00-00 00:00:00';
	    	$arrData['tags'] = House::HOUSE_NOTAG;
	    	$arrData['delTime'] = date('Y-m-d H:i:s');
	    	$objHouse = House::findFirst("id = $intHouseId");
	    	$intFlag = $objHouse->update($arrData);
	    	if( !$intFlag )	
	    	{
	    		$this->rollback();
	    		return false;
	    	}
	    	
	    	//更新Sale表房源状态
	    	$arrData['features'] = new Phalcon\Db\RawValue("''");
	    	$arrData['update'] = date('Y-m-d H:i:s');
	    	$arrData['status'] = $status;
	    	$objSale = $clsUnit::findFirst("houseId = $intHouseId");
	    	$intFlag = empty($objSale) ? false : $objSale->update($arrData);
	    	if( !$intFlag )	
	    	{
	    		$this->rollback();
	    		return false;
	    	}
	    	
	    	//小区房源数、有效房源数减1
			if (!empty($objHouse->parkId)) {
				$arrParkData = array(
					'parkId'	=>	$objHouse->parkId,
					'houseType'	=>	$objHouse->type,
					'status'	=>	$objHouse->status
				);
				$objPark = new Park();
				$intFlag = $objPark->modifyParkHouseNumberById($arrParkData, 'subtraction');
				if ( $intFlag === false ) 
				{
					$this->rollback();
					return false;
				}
				unset($arrParkData);
			}
	    	
	    	//如果房源删除，取消定时刷新队列
			if(!VipRefreshQueue::Instance()->deleteAll("houseId = {$intHouseId}"))
			{
	    		$this->rollback();
	    		return false;
			}
	    	
	    	//更新ES
	    	global $sysES;
	    	$params = $sysES['default'];
	    	$params['index'] = 'esf';
	    	$params['type'] = 'house';
	    	$client = new Es($params);
			$arrData['features'] = "";
			$arrData['id'] = $arrData['houseId'] = $intHouseId; //保持ES的id值与houseId一致
			$intFlag = $client->update(array('id' => $intHouseId, 'data' => $client->houseFormat($arrData)));
	    	if( !$intFlag )
	    	{
	    		$this->rollback();
	    		return false;
	    	}

			//更新队列
			$intFlag = Quene::Instance()->Put('house', array('action' => 'delete', 'houseId' => $intHouseId, 'realId' => $objHouse->realId, 'cityId' => $objHouse->cityId, 'time' => date('Y-m-d H:i:s', time())));
			if ( $intFlag == false ) {
	    		$this->rollback();
	    		return false;
			}

	    	$this->commit();
    	}
    	return true;
    }
	
	/**
	 * 根据房源Id更新房源基本信息
	 *
	 * @param int $intHouseId 单条房源Id
	 * @param array $arrData
	 * @return int|bool
	 */
	public function modifyHouseById($intHouseId, $arrData) {
		$time = date('Y-m-d H:i:s', $GLOBALS['_NOW_TIME']);
		//房源状态
		if ( isset($arrData['status']) ) {
			$arrUpdate['status'] = $arrData['status'];
		}
		//经纪人或个人帐号Id
		if ( isset($arrData['realId']) ) {
			$arrUpdate['realId'] = $arrData['realId'];
		}
		//所属门店Id
		if ( isset($arrData['shopId']) ) {
			$arrUpdate['shopId'] = $arrData['shopId'];
		}
		//所属区域Id
		if ( isset($arrData['areaId']) ) {
			$arrUpdate['areaId'] = $arrData['areaId'];
		}
		//所属公司Id
		if ( isset($arrData['comId']) ) {
			$arrUpdate['comId'] = $arrData['comId'];
		}
		//小区Id
		if ( isset($arrData['parkId']) ) {
			$arrUpdate['parkId'] = $arrData['parkId'] == 0 ? new Phalcon\Db\RawValue("0") : $arrData['parkId'];
		}
		//所属城区Id
		if ( isset($arrData['distId']) ) {
			$arrUpdate['distId'] = $arrData['distId'] == 0 ? new Phalcon\Db\RawValue("0") : $arrData['distId'];
		}
		//所属板块Id
		if ( isset($arrData['regId']) ) {
			$arrUpdate['regId'] = $arrData['regId'] == 0 ? new Phalcon\Db\RawValue("0") : $arrData['regId'];
		}
		//室
		if ( isset($arrData['bedRoom']) ) {
			$arrUpdate['bedRoom'] = $arrData['bedRoom'];
		}
		//厅
		if ( isset($arrData['livingRoom']) ) {
			$arrUpdate['livingRoom'] = $arrData['livingRoom'];
		}
		//卫
		if ( isset($arrData['bathRoom']) ) {
			$arrUpdate['bathRoom'] = $arrData['bathRoom'];
		}
		//朝向
		if ( isset($arrData['orientation']) ) {
			$arrUpdate['orientation'] = $arrData['orientation'];
		}
		//物业类型
		if ( isset($arrData['propertyType']) ) {
			$arrUpdate['propertyType'] = $arrData['propertyType'];
		}
		//装修状况
		if ( isset($arrData['decoration']) ) {
			$arrUpdate['decoration'] = $arrData['decoration'];
		}
		//面积
		if ( isset($arrData['bA']) ) {
			$arrUpdate['bA'] = $arrData['bA'];
		}
		//总价
		if ( isset($arrData['price']) ) {
			$arrUpdate['price'] = $arrData['price'];
		}
		//单价
		if ( isset($arrData['unit']) ) {
			$arrUpdate['unit'] = $arrData['unit'];
		}
		if ( isset($arrData['bA']) && isset($arrData['price']) ) {
			$arrUpdate['unit'] = empty($arrUpdate['unit']) ? (empty($arrUpdate['bA']) ? 0 : $arrUpdate['price']/$arrUpdate['bA']) : $arrUpdate['unit'];
		}
		//第几层
		if ( isset($arrData['floor']) ) {
			$arrUpdate['floor'] = $arrData['floor'] == 0 ? new Phalcon\Db\RawValue("0") : $arrData['floor'];
		}
		//总楼层
		if ( isset($arrData['floorMax']) ) {
			$arrUpdate['floorMax'] = $arrData['floorMax'] == 0 ? new Phalcon\Db\RawValue("0") : $arrData['floorMax'];
		}
		//建筑年代
		if ( isset($arrData['buildYear']) ) {
			$arrUpdate['buildYear'] = $arrData['buildYear'];
		}
		//建筑类型
		if ( isset($arrData['buildType']) ) {
			$arrUpdate['buildType'] = $arrData['buildType'];
		}
		//封面图片ID
		if ( isset($arrData['picId']) ) {
			$arrUpdate['picId'] = $arrData['picId'];
		}
		//封面图片扩展名
		if ( isset($arrData['picExt']) ) {
			$arrPicExt = array_flip($GLOBALS['HOUSE_PIC_EXT']);
            $arrUpdate['picExt'] = isset($arrPicExt[$arrData['picExt']]) ? $arrPicExt[$arrData['picExt']] : 0 ;
		}
		//精品房源
		if ( isset($arrData['fine']) ) {
			$arrUpdate['fine'] = $arrData['fine'];
		}
		//房源标签(急、免，出租仍使用)
		if ( isset($arrData['tags']) ) {
			$arrUpdate['tags'] = $arrData['tags'];
		}
		//下架时间
		if ( isset($arrData['xiajia']) ) {
			$arrUpdate['xiajia'] = $arrData['xiajia'];
		}
		//产权类型
		if ( isset($arrData['propertyNature']) ) {
			$arrUpdate['propertyNature'] = $arrData['propertyNature'];
		}
		//创建时间
		if ( isset($arrData['create']) ) {
			$arrUpdate['create'] = $arrData['create'];
		}
		//看房时间
		if ( isset($arrData['lookTime']) ) {
			$arrUpdate['lookTime'] = $arrData['lookTime'];
		}
		$arrUpdate['houseUpdate'] = $time;
		
		//特色房源设置时间
		if ( isset($arrData['tagTime']) ) {
			$arrUpdate['tagTime'] = $arrData['tagTime'];
		} elseif ( isset($arrData['tags']) )  {
			$arrUpdate['tagTime'] = $time;
		}
		
		//精品房源设置时间
		if ( isset($arrData['fineTime']) ) {
			$arrUpdate['fineTime'] = $arrData['fineTime'];
		}
		//房源品质
		if ( isset($arrData['quality']) ) {
			$arrUpdate['quality'] = $arrData['quality'];
		}
		//房源审核
		if ( isset($arrData['verification']) ) {
			$arrUpdate['verification'] = $arrData['verification'];
		}
		//是否现房
		if ( isset($arrData['typeType']) ) {
			$arrUpdate['typeType'] = $arrData['typeType'];
		}
		//开盘时间
		if ( isset($arrData['openDate']) ) {
			$arrUpdate['openDate'] = $arrData['openDate'];
		}
		//交房时间
		if ( isset($arrData['deliverDate']) ) {
			$arrUpdate['deliverDate'] = $arrData['deliverDate'];
		}
        if (isset($arrData['houseType'])){
            $arrUpdate['type'] = $arrData['houseType'];
        }
		//房源健康指数
		////if ( isset($arrData['old_id']) ) {
		////	$arrUpdate['old_id'] = $arrData['old_id'];
		////}
		$objHouseUpdate = self::findfirst("id = ".$intHouseId);
		return $objHouseUpdate->update($arrUpdate);
	}
	
	/**
	 * 创建出售房源基本信息
	 *
	 * @param array $arrData
	 * @return int|bool
	 */
	public function addHouse(array $arrData) 
	{
		$time = date('Y-m-d H:i:s', $GLOBALS['_NOW_TIME']);
		if( empty($arrData) )	return false;
		
		//区域ID
		if( isset($arrData['areaId']) )
		{
			$arrInsert['areaId'] = $arrData['areaId'];
		}
		//房源类型
		if( isset($arrData['houseType']) )
		{
			$arrInsert['type'] = $arrData['houseType'];
		}
		//建筑面积
		if( isset($arrData['houseUA']) )
		{
			$arrInsert['uA'] = $arrData['houseUA'];
		}
		//小区Id
		if ( isset($arrData['parkId']) )
		{
			$arrInsert['parkId'] = $arrData['parkId'];
		}
		//所属板块Id
		if ( isset($arrData['regId']) )
		{
			$arrInsert['regId'] = $arrData['regId'];
		}
		//所属城区Id
		if ( isset($arrData['distId']) )
		{
			$arrInsert['distId'] = $arrData['distId'];
		}
		//所属城区Id
		if ( isset($arrData['cityId']) )
		{
			$arrInsert['cityId'] = $arrData['cityId'];
		}
		//经纪人或个人帐号Id
        if ( isset($arrData['realId']) )
        {
            $arrInsert['realId'] = $arrData['realId'];
        }
        else 
        {
        	$arrInsert['realId'] = 0;
        }
        //所属门店Id
        if ( isset($arrData['shopId']) )
        {
        	$arrInsert['shopId'] = $arrData['shopId'];
        }
        //所属公司Id
        if ( isset($arrData['comId']) )
        {
        	$arrInsert['comId'] = $arrData['comId'];
        }
	 	//房源状态
        if ( isset($arrData['status']) )
        {
            $arrInsert['status'] = $arrData['status'];
        }
		//室
	 	if ( isset($arrData['bedRoom']) )
	 	{
            $arrInsert['bedRoom'] = $arrData['bedRoom'];
        }
		//厅
		if ( isset($arrData['livingRoom']) )
		{
            $arrInsert['livingRoom'] = $arrData['livingRoom'];
        }
		//卫
		if ( isset($arrData['bathRoom']) )
		{
            $arrInsert['bathRoom'] = $arrData['bathRoom'];
        }
		//朝向
		if ( isset($arrData['orientation']) )
		{
            $arrInsert['orientation'] = $arrData['orientation'];
        }
		//建筑类型
		if ( isset($arrData['propertyType']) )
		{
            $arrInsert['propertyType'] = $arrData['propertyType'];
        }
		//装修状况
		if ( isset($arrData['decoration']) )
		{
            $arrInsert['decoration'] = $arrData['decoration'];
        }
		//面积
		if ( isset($arrData['bA']) )
		{
            $arrInsert['bA'] = $arrData['bA'];
        }
		//总价
		if ( isset($arrData['price']) )
		{
            $arrInsert['price'] = $arrData['price'];
        }
		//单价
		if ( isset($arrData['unit']) )
		{
            $arrInsert['unit'] = $arrData['unit'];
        }
        $arrInsert['unit'] = empty($arrInsert['unit']) ? (empty($arrInsert['bA']) ? 0 : $arrInsert['price']/$arrInsert['bA']) : $arrInsert['unit'];
		//第几层
		if ( isset($arrData['floor']) )
		{
            $arrInsert['floor'] = $arrData['floor'];
        }
		//总楼层
		if ( isset($arrData['floorMax']) )
		{
            $arrInsert['floorMax'] = $arrData['floorMax'];
        }
		//建筑年代
	 	if ( isset($arrData['buildYear']) )
	 	{
            $arrInsert['buildYear'] = $arrData['buildYear'];
        }
		//建筑类型
		if ( isset($arrData['buildType']) )
		{
            $arrInsert['buildType'] = $arrData['buildType'];
        }
		//封面图片ID
		if ( isset($arrData['picId']) )
		{
            $arrInsert['picId'] = $arrData['picId'];
        }
		//封面图片扩展名
		if ( isset($arrData['picExt']) && $arrData['picExt'])
		{
			$arrPicExt = array_flip($GLOBALS['HOUSE_PIC_EXT']);
            $arrInsert['picExt'] = $arrPicExt[$arrData['picExt']];
        }
		//精品房源
        if ( isset($arrData['fine']) )
        {
            $arrInsert['fine'] = $arrData['fine'];
        }
        //房源标签(急、免，出租仍使用)
        if ( isset($arrData['tags']) )
        {
            $arrInsert['tags'] = $arrData['tags'];
        }
        //下架时间
        if ( isset($arrData['xiajia']) )
        {
            $arrInsert['xiajia'] = $arrData['xiajia'];
        }
        //产权类型
        if ( isset($arrData['propertyNature']) )
        {
            $arrInsert['propertyNature'] = $arrData['propertyNature'];
        }
        //看房时间
        if ( isset($arrData['lookTime']) )
        {
            $arrInsert['lookTime'] = $arrData['lookTime'];
        }
        //特色房源设置时间
        if ( isset($arrData['tagTime']) )
        {
            $arrInsert['tagTime'] = $arrData['tagTime'];
		} elseif ( isset($arrData['tags']) )  {
			$arrInsert['tagTime'] = $time;
		}
		
		//精品房源设置时间
		if ( isset($arrData['fineTime']) ) {
			$arrInsert['fineTime'] = $arrData['fineTime'];
		}
        //高清房源
        if( isset($arrData['quality']))
        {
        	$arrInsert['quality'] = $arrData['quality'];
        }
		//房源审核
		if ( isset($arrData['verification']) ) {
			$arrInsert['verification'] = $arrData['verification'];
		} else {
			$arrInsert['verification'] = House::HOUSE_VERING;//默认待审核
		}
        
        //房主编号
        if( isset($arrData['hoId']))
        {
        	$arrInsert['hoId'] = $arrData['hoId'];
        }
        else
        {
        	$arrInsert['hoId'] = 0;
        }

        //判断是否为个人房源
        if( isset($arrData['roleType']))
        {
        	$arrInsert['roleType'] = $arrData['roleType'];
        }
		//是否现房
		if ( isset($arrData['typeType']) ) {
			$arrInsert['typeType'] = $arrData['typeType'];
		}
		//开盘时间
		if ( isset($arrData['openDate']) ) {
			$arrInsert['openDate'] = $arrData['openDate'];
		}
		//交房时间
		if ( isset($arrData['deliverDate']) ) {
			$arrInsert['deliverDate'] = $arrData['deliverDate'];
		}
        
        $arrInsert['create'] = $time;		//创建时间
        $arrInsert['houseUpdate'] = $time;		//更新时间
        try 
        {
	        if($objInsert = self::create($arrInsert)) {
	        	$insertId = $this->insertId();
				$strCode = $arrData['houseType'] == House::TYPE_ERSHOU || $arrData['houseType'] == House::TYPE_XINFANG ? 2 : 1;
				$strCode .= str_pad($arrData['cityId'],2,0,STR_PAD_LEFT).str_pad($insertId,9,0,STR_PAD_LEFT);
				if ($this->updateAll('houseId='.$insertId, array('houseCode' => $strCode))) {
					return $insertId;
				} else {
					return false;
				}
			} else {
	        	return false;
			}
        }
        catch (Exception $ex)
        {
        	return false;
        }
	}

    /**
   	 * @abstract 根据相关条件获取房源信息,需要涉及到刷新时间
     * @author Eric xuminwan@sohu-inc.com
     * @param string $strCondition
     * @param int $offset
     * @param int $intSize
     * @param string $order
     * @return array|bool
     * 
     */
	public function getHouseByCondition($strCondition,$columns='',$offset=0,$intSize=0,$order='')
	{
        //在线二手房限制
		if(strpos($strCondition,'status') === false)
		{
			$strCondition .= "and House.status = ".House::STATUS_ONLINE;

		}
   		if(strpos($strCondition,'type') === false)
		{
			$strCondition .= "and type IN (21,22)";
		}
		$strCondition = trim($strCondition,'and');
		if($intSize > 0)
		{
			$limit = $intSize.",".$offset;
		}
        else
		{
			$limit = 0;
		}
		$arrHouse = self::query()
			->columns($columns)
			->where($strCondition)
			->leftJoin('Sale', 'sale.houseId = House.id', 'sale')
            ->limit($intSize)
    		->orderBy($order)
			->execute();
		if($arrHouse)
        {
			return $arrHouse->toArray();
		}
		else
		{
			return false;
 		}
 	}
 	
 	/**
 	 * @abstract 获取置业专家的小区房源数
 	 * @author Eric xuminwan@sohu-inc.com
     * @param int $realId
     * @param int $parkId
     * @return int
     * 
 	 */
 	public function getRealtorHouseCount($realId, $parkId)
 	{
 		if(!($realId && $parkId)) return 0;
 		$strCondition = '';
 		$strCondition .= "realId = :realId: and parkId = :parkId: and type IN (21,22) and status = ".House::STATUS_ONLINE;
 		$arrParams = array('realId'=>$realId,'parkId'=>$parkId);
 		$count = self::count(array(
 			$strCondition,
 			'bind' => $arrParams,
 		));
 		return $count;
 	}
 	
 	/**
 	 * @abstract 获取小区房源户型
 	 * @author Eric xuminwan@sohu-inc.com
     * @param int $parkId
     * @return array 
 	 * 
 	 */
 	public function getParkHouseType($parkId)
 	{
 		if(!$parkId) return false;
 		$arrCondition['conditions'] = "parkId = :parkId: and type = 22 and status = ".House::STATUS_ONLINE;
 		$arrCondition['bind'] = array('parkId'=>$parkId);
 		$arrCondition['columns'] = 'distinct bedRoom';
 		$arrCondition['order'] = 'bedRoom';
 		$arrType = self::find($arrCondition,0)->toArray();
 		return $arrType;
 	}
 	
	/**
	 * 根据CustomId获取单条房源信息
	 * 因内部编号不一定唯一，所以启用RealId加以约束
	 *
	 * @param string $strCustomId
	 * @param int $intRealtorId
	 * @return array
	 */
	public function getHouseByCustomId($strCustomId, $intRealtorId, $intHouseType = self::TYPE_ERSHOU) {
		$arrHouse = self::query()
			->columns("House.*")
			->where("he.value='".$strCustomId."' AND House.realId='".$intRealtorId."' AND House.type = '".$intHouseType."' AND House.status IN(".House::STATUS_ONLINE.",".House::STATUS_OFFLINE.")")
			->leftJoin('HouseExt', "he.houseId=House.id AND he.name='customId'", 'he')
            ->limit(1)
			->execute();
		if($arrHouse)
        {
			$arrHouse = $arrHouse->toArray();
			return $arrHouse[0];
		}
		else
		{
			return false;
 		}
	}

    /**
     * @param int|array $arrIds
     * @return array
     */
    public function getAllHouseInfo($arrIds, $type = "Sale", $houseRoleType = House::ROLE_REALTOR) {
        if (!$arrIds) return array();
        $rhHouseType = array(
            House::TYPE_XINFANG =>  '新房',
            House::TYPE_CIXIN   =>  "次新房",
            House::TYPE_ERSHOU  =>  '二手房',
            House::TYPE_HEZU    =>  '合租',
            House::TYPE_ZHENGZU =>  '整租',
            );
        $boolIsNotArray = false;
        if (is_numeric($arrIds)){
            $arrIds = array($arrIds);
            $boolIsNotArray = true;
        }
        else if (!is_array($arrIds)){
            return array();
        }
        $arrHouse = CHouse::getHouseByIds($arrIds, $type, $houseRoleType);
        if (!$arrHouse) return array();

        if ($type == 'Rent'){
            $mRent = new Rent();
            $rentInfo = $mRent->getRentByIds($arrIds);
            $rhRentInfo = array();
            if ($rentInfo){
                foreach ($rentInfo as $rent){
                    $rhRentInfo[$rent['houseId']] = $rent;
                    if ($rent['type'] == 1){
                        $rhRentInfo[$rent['houseId']]['typeToName'] = $GLOBALS['RENT_TYPE_C'][$rent['typeTo']];
                    }

                }
            }
        }
        //加载扩展信息
        $mHouseMore = new HouseMore();
        $arrHouseMore = $mHouseMore->getUnitExtById($arrIds);
        //加载图片信息
        $pictureInfo = CHousePicture::getImageByHouseId($arrIds);
        $mPark = new Park();
        foreach ( $arrHouse as $v ) {
            $arrParkId[] = $v['parkId'];
        }
        if (isset($arrParkId) && $arrParkId){
            $parkInfo = $mPark->getParkByIds($arrParkId);
            $rhPark = array();
            $rhParkAd = array();
            foreach ($parkInfo as $park){
                $rhPark[$park['id']] = $park['name'];
                $rhParkAd[$park['id']] = $park['address'];
            }
        }

        foreach ( $arrIds as $k=>$houseId ) {
            if (!isset($arrHouse[$houseId])) continue;
            $v = $arrHouse[$houseId];
            $arrBackData[$k] = $v;
            $arrBackData[$k]['houseMore'] = isset($arrHouseMore[$k])? $arrHouseMore[$k]: '';
            $arrBackData[$k]['housePicture'] = isset($pictureInfo[$k])? $pictureInfo[$k]: '';
            $arrBackData[$k]['parkName'] = isset($rhPark[$v['parkId']]) ? $rhPark[$v['parkId']] : '';
            $arrBackData[$k]['parkAddress'] = isset($rhParkAd[$v['parkId']]) ? $rhParkAd[$v['parkId']] : '';
            $arrBackData[$k]['typeName'] = $rhHouseType[$v['type']];
            if ($type == 'Rent' and isset($rhRentInfo)){
                $arrBackData[$k]['typeToName'] = isset($rhRentInfo[$v['houseId']]['typeToName']) ? $rhRentInfo[$v['houseId']]['typeToName'] : '' ;
                $arrBackData[$k]['rentPrice'] = isset($rhRentInfo[$v['houseId']]) ? $rhRentInfo[$v['houseId']]['price'] : '';
                $arrBackData[$k]['currency'] = isset($rhRentInfo[$v['houseId']]) ? $rhRentInfo[$v['houseId']]['currency'] : '';
            }
        }
        return $boolIsNotArray? reset($arrBackData): $arrBackData;
    }
    
    /**
     * 根据经纪人id删除房源
     * @param type $realId
     * @return boolean
     */
    public function delHouseByRealId($realId, $houseType = '')
    {
        if(!$realId)
        {
            return false;
        }
        if('rent' == $houseType)
        {
            $type = array(self::TYPE_HEZU, self::TYPE_ZHENGZU);
        }
        elseif('sale' == $houseType)
        {
            $type = array(self::TYPE_CIXIN, self::TYPE_ERSHOU, self::TYPE_XINFANG);
        }
        else
        {
            $type = array(self::TYPE_HEZU, self::TYPE_ZHENGZU, self::TYPE_CIXIN, self::TYPE_ERSHOU, self::TYPE_XINFANG);
        }
        
        $con = "realId={$realId} and status<>".self::STATUS_DELETE." and type in(".implode(',', $type).")";
        $houses = self::find($con);
        if(!$houses)
        {
            return true;
        }
        else
        {
            foreach($houses as $house)
            {
                $house->status = self::STATUS_DELETE;
                $house->delTime = date("Y-m-d H:i:s");
                if(!$house->update())
                {
                    return false;
                }
                
                global $sysES;
                $clsEs = new Es($sysES['default']);
                $arrData = array(
                    'status'      => self::STATUS_DELETE,
                    'delTime'     => $house->delTime
                );
                $intFlag = $clsEs->update(array('id' => $house->id, 'data' => $clsEs->houseFormat($arrData)));
                if($intFlag == false) 
                {
                    return false;
                }
            }
        }
        
        return true;
    }

    /**
     * @abstract 根据相关条件获取房源数据
     * @author jackchen
     * @param string $strCondition
     * @param string $columns
     * *@param string $order
     * @param int $offset
     * @param int $limit
     * @return array|bool
     *
     */
    public function getHouseByRealtorCondition($strCondition,$columns='',$order='',$offset=0,$limit=0)
    {
        //在线二手房限制
        if(strpos($strCondition,'status') === false)
        {
            $strCondition .= "and House.status = ".House::STATUS_ONLINE;
        }

        $strCondition = trim($strCondition,'and');
        $arrHouse = self::query();
        $arrHouse->columns($columns);
        $arrHouse->where($strCondition);
        if(strpos($strCondition,'type IN (10,11)') === false)
        {
            $arrHouse->leftJoin('Sale', 'sale.houseId = House.id', 'sale');
        }
        else
        {
            $arrHouse->leftJoin('Rent', 'rent.houseId = House.id', 'rent');
        }

        if($limit > 0){
            if($offset > 0){
                $arrHouse->limit($offset.','.$limit);
            }else{
                $arrHouse->limit($limit);
            }
        }
        $arrHouse->orderBy($order);

        return $arrHouse->execute()->toArray();
    }
    
    
    /**
     * @abstract 获取个人房源
     * @author Eric xuminwan@sohu-inc.com
     * @param string $strCondition
     * @param string $columns
     * @param string $order
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function getPersonHouse($strCondition,$columns='',$order='',$offset=0,$limit=0)
    {
    	if(!$strCondition) return array();
    	if($limit > 0){
    		if($offset > 0){
    			$limit = array('number'=>$limit,'offset'=>$offset);
    		}
    	}
        $builder = self::query()
    	->where($strCondition)
    	->innerJoin('houseOwner', 'ho.id = House.hoId', 'ho')
    	->orderBy($order);
        if ($limit > 0){
            $builder->limit($limit);
        }
        $arrHouse = $builder->execute();
    	if($arrHouse)
    	{
            try{
                return $arrHouse->toArray();
            }
            catch(Exception $e){
                echo $e->getMessage();
            }

    	}
    	else
    	{
    		return array();
    	}
    }

    /** 实例化对象
     *
     * @param type $cache
     * @return \House_Model
     */
    public static function instance ($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self();
    
    }

    /**
     *批量获取房源信息
     * @param unknown_type $arrHouseId
     * @param unknown_type $houseType
     */
    public function getUnit($arrHouseId, $houseType)
    {
    	//加载房源的基本信息
    	if ( $houseType == 'Sale' ) 
    	{
    		$arrHouse = House::find(array("id IN(".implode(',', $arrHouseId).")", 'columns' => 'id,parkId as projId,bedRoom,status,livingRoom,bathRoom,picId,picExt,tags,fine,unit as price,bA as area,create as addTime,houseUpdate as modifyTime, status, verification'))->toArray();
    		$arrUnit = Sale::find(array("houseId IN(".implode(',', $arrHouseId).")", 'columns' => 'houseId,parkName,features'))->toArray();
    		foreach ( $arrUnit as $k => $v ) 
    		{
    			$arrUnitData[$v['houseId']]['parkName'] = $v['parkName'];
    			$arrUnitData[$v['houseId']]['features'] = $v['features'];
    		}
    		$arrHouseExt = HouseExt::find(array(" houseId IN (".implode(',', $arrHouseId).") AND name='customId'", 'columns' => 'houseId,value'))->toArray();
    		foreach ( $arrHouseExt as $k => $v ) 
    		{
    			$arrHouseExt[$v['houseId']] = $v['value'];
    		}
//     		$arrAudit = HouseAuditing::find(array(" houseId IN (".implode(',', $arrHouseId).")", 'columns' => 'houseId,failure'))->toArray();
//     		foreach ( $arrAudit as $k => $v )
//     		{
//     			$arrHouseAudit[$v['houseId']]['failure'] = $v['failure'];
//     		}
    	} 
    	else 
    	{
    		$arrHouse = House::find(array("id IN (".implode(',', $arrHouseId).")", 'columns' => 'id,parkId as projId,bedRoom,status,livingRoom,bathRoom,picId,picExt,tags,fine,unit as price,bA as area,create as addTime,houseUpdate as modifyTime, status'))->toArray();
    		$arrUnit = Rent::find(array("houseId IN (".implode(',', $arrHouseId).")", 'columns' => 'houseId,parkName,price,currency'))->toArray();
    		foreach ( $arrUnit as $k => $v ) 
    		{
    			$arrUnitData[$v['houseId']]['parkName'] = $v['parkName'];
    			$arrUnitData[$v['houseId']]['rentPrice'] = $v['price'];
    			$arrUnitData[$v['houseId']]['rentCurrency'] = $v['currency'];
    		}
    		$arrHouseExt = HouseExt::find(array("houseId IN (".implode(',', $arrHouseId).") AND name='customId'", 'columns' => 'houseId,value'))->toArray();
    		foreach ( $arrHouseExt as $k => $v ) 
    		{
    			$arrHouseExt[$v['houseId']] = $v['value'];
    		}
//     		$arrAudit = HouseAuditing::find(array(" houseId IN (".implode(',', $arrHouseId).")", 'columns' => 'houseId,failure'))->toArray();
//     		if(!empty($arrAudit))
//     		{
// 	    		foreach ( $arrAudit as $k => $v )
// 	    		{
// 	    			$arrHouseAudit[$v['houseId']] = $v['failure'];
// 	    		}
//     		}
    	}
    	if ( !empty($arrHouse) ) 
    	{
    		//加载房源图片数量
    		$intHouseType = $houseType == 'Sale' ? House::TYPE_ERSHOU : House::TYPE_ZHENGZU;
    		$arrHousePicture = HousePicture::find(array("houseId IN (".implode(',', $arrHouseId).")", 'columns' => 'COUNT(1) AS cnt,houseId', 'group' => 'houseId'))->toArray();
    		if ( !empty($arrHousePicture) ) 
    		{
    			foreach ( $arrHousePicture as $k => $v ) 
    			{
    				$arrHousePicture[$v['houseId']] = $v['cnt'];
    			}
    		}
			//扩展房源点击信息
			$clsZebHouse = new ZebHouse();
			$arrUnitClick = $clsZebHouse->getUnitClick($arrHouseId);
    		foreach ( $arrHouse as $k => $v ) 
    		{
    			$arrHouse[$v['id']] = $v;
    			unset($arrHouse[$k]);
    			$arrHouse[$v['id']]['projName'] = isset($arrUnitData[$v['id']]['parkName']) ? $arrUnitData[$v['id']]['parkName'] : '';
    			$arrHouse[$v['id']]['features'] = isset($arrUnitData[$v['id']]['features']) ? $arrUnitData[$v['id']]['features'] : '';
    			$arrHouse[$v['id']]['CustomId'] = isset($arrHouseExt[$v['id']]) ? $arrHouseExt[$v['id']] : '';
    			$arrHouse[$v['id']]['imageCount'] = isset($arrHousePicture[$v['id']]) ? $arrHousePicture[$v['id']] : 0;
    			$arrHouse[$v['id']]['rentPrice'] = isset($arrUnitData[$v['id']]['rentPrice']) ? $arrUnitData[$v['id']]['rentPrice'] : '';
    			$arrHouse[$v['id']]['rentCurrency'] = isset($arrUnitData[$v['id']]['rentCurrency']) ? $arrUnitData[$v['id']]['rentCurrency'] : '';
    			//$arrHouse[$v['id']]['failure'] = isset($arrHouseAudit[$v['id']]['failure']) ? $arrHouseAudit[$v['id']]['failure'] : '';
				$arrHouse[$v['id']]['clickToday'] = isset($arrUnitClick[$v['id']]['today']) ? $arrUnitClick[$v['id']]['today'] : 0;
				$arrHouse[$v['id']]['clickYesterday'] = isset($arrUnitClick[$v['id']]['yesterday']) ? $arrUnitClick[$v['id']]['yesterday'] : 0;
				$arrHouse[$v['id']]['clickTotal'] = isset($arrUnitClick[$v['id']]['month']) ? $arrUnitClick[$v['id']]['month'] : 0;
    		}  
    		unset($arrHousePicture, $arrUnitClick);
    	}
    	//重构并填充数据
    	if ( ! empty($arrHouseId) )
    	{
    		foreach ( $arrHouseId as $key => $item )
    		{
    			$arrNewHouse[$item] = isset($arrHouse[$item]) ? $arrHouse[$item] : array();
    		}
    	}
    	return $arrNewHouse;
    }


    /**
     * 获取指定经纪人名下出售/出租在线房源数量  - 统计
     * @auth jackchen
     * @param int $realId
     * @param string $houseType
     * @return int
     */
    public function  getRealtorHouseTotal($realId,$houseType='Sale'){
        if(empty($realId)){
            return false;
        }
        if ( $houseType == 'Sale' )
        {
            $where =" and type in (".self::TYPE_ERSHOU.",".self::TYPE_CIXIN.",".self::TYPE_XINFANG.")";
        } else {
            $where =" and type in (".self::TYPE_ZHENGZU.",".self::TYPE_HEZU.")";
        }
        $where .=" and verification > -1";
        $con['conditions'] = "realId=".$realId." and status=".self::STATUS_ONLINE.$where;
        $con['columns'] = "id";
        $arrData = self::find($con);
        return $arrData->count();
    }


    /**
     * 获取指定经纪人名下出售/出租，设置标签数量  - 统计
     * @auth jackchen
     * @param int $realId
     * @param string $houseType
     * @return int
     */
    public function  getRealtorHouseTagTotal($realId,$houseType='Sale'){
        if(empty($realId)){
            return false;
        }
        if ( $houseType == 'Sale' )
        {
            $where =" and type in (".self::TYPE_ERSHOU.",".self::TYPE_CIXIN.",".self::TYPE_XINFANG.")";
        } else {
            $where =" and type in (".self::TYPE_ZHENGZU.",".self::TYPE_HEZU.")";
        }
        $where .=" and verification > -1 and tags > 0";
        $con['conditions'] = "realId=".$realId.$where;
        $con['columns'] = "id";
        $arrData = self::find($con);
        return $arrData->count();
    }

    /**
     * 获取指定经纪人名下出售/出租，精品推荐  - 统计
     * @auth jackchen
     * @param int $realId
     * @param string $houseType
     * @return int
     */
    public function  getRealtorHouseFineTotal($realId,$houseType='Sale'){
        if(empty($realId)){
            return false;
        }
        if ( $houseType == 'Sale' )
        {
            $where =" and type in (".self::TYPE_ERSHOU.",".self::TYPE_CIXIN.",".self::TYPE_XINFANG.")";
        } else {
            $where =" and type in (".self::TYPE_ZHENGZU.",".self::TYPE_HEZU.")";
        }
        $where .=" and verification > -1 and fine =".House::FINE_YES;
        $con['conditions'] = "realId=".$realId.$where;
        $con['columns'] = "id";
        $arrData = self::find($con);
        return $arrData->count();
    }


    /**
     * 获取指定经纪人名下出售/出租，当日新增房源  - 统计
     * @auth jackchen
     * @param int $realId
     * @param string $houseType
     * @return int
     */
    public function  getRealtorHouseNewTotal($realId,$houseType='Sale'){
        if(empty($realId)){
            return false;
        }
        if ( $houseType == 'Sale' )
        {
            $where =" and type in (".self::TYPE_ERSHOU.",".self::TYPE_CIXIN.",".self::TYPE_XINFANG.")";
        } else {
            $where =" and type in (".self::TYPE_ZHENGZU.",".self::TYPE_HEZU.")";
        }
        $where .=" and verification > -1 and  create > ".date('Y-m-d');
        $con['conditions'] = "realId=".$realId.$where;
        $con['columns'] = "id";
        $arrData = self::find($con);
        return $arrData->count();
    }


    /**
     * @abstract 根据相关条件获取房源类型，获取经纪人下的房源列表 (单表)
     * @author jackchen
     * @param string $strCondition
     * @param string $columns
     * *@param string $order
     * @param int $offset
     * @param int $limit
     * @return array|bool
     *
     */
    public function getHouseByRealtorSaleRent($strCondition,$columns='',$order='',$offset=0,$limit=0)
    {
        //在线二手房限制
        if(strpos($strCondition,'status') === false)
        {
            $strCondition .= "and House.status = ".House::STATUS_ONLINE;
        }

        $strCondition = trim($strCondition,'and');
        $arrHouse = self::query();
        $arrHouse->columns($columns);
        $arrHouse->where($strCondition);

        if($limit > 0){
            if($offset > 0){
                $arrHouse->limit($offset.','.$limit);
            }else{
                $arrHouse->limit($limit);
            }
        }
        $arrHouse->orderBy($order);

        return $arrHouse->execute()->toArray();
    }

	/**
	 * 上架房源
	 * @param int|array $ids 数组为更新多条
	 * @return int|bool 成功返回影响条数，失败返回false
	 */
	public function onLineUnit($ids, $intTime){
		//发布
		$arrUp['houseStatus'] = House::STATUS_ONLINE;
		$arrUp['houseXiajia'] = '0000-00-00 00:00:00';

		//为审核做准备（取消），上下架不改变违规状态
		/*$arrUp['houseVerification'] = House::HOUSE_VERING;
		$arrAu['haStatus'] = HouseAuditing::HOUSE_VERING;
		$arrAu['haUpdate'] = '0000-00-00 00:00:00';*/

		$arrUp['houseUpdate'] = date('Y-m-d H:i:s', $intTime);
		$this->begin();
		if($this->modifyUnitById($ids, $arrUp)){ //刷主表
			//更新房源审核表
			/*$clsUnitAudit = new HouseAuditing();
			$intFlagAudit = $clsUnitAudit->modifyUnitById($ids, $arrAu);
			if ( $intFlagAudit === false ) 
			{
				$this->rollback();
				return false;
			}*/
			//更新该房源对应的ES数据
			global $sysES;
			$clsEs = new Es($sysES['default']);
			foreach($ids as $id)
			{
				$intFlag = $clsEs->update(array('id' => $id, 'data' => $clsEs->houseFormat($arrUp)));
				if($intFlag == false){
					$this->rollback();
					return false;
				}

				//更新队列
				$intFlag = Quene::Instance()->Put('house', array('action' => 'online', 'houseId' => $id, 'realId' => $GLOBALS['client']['realId'], 'cityId' => $GLOBALS['client']['cityId'], 'status' => $arrUp['houseStatus'], 'time' => date('Y-m-d H:i:s', time())));
				if ( $intFlag == false ) {
					$this->rollback();
					return false;
				}
			}

			$this->commit();
			return true;
		}
		$this->rollback();
		return false;
	}

	/**
	 * 下架房源
	 * @param int|array $ids 数组为更新多条
	 * @return int|bool 成功返回影响条数，失败返回false
	 */
	public function offLineUnit($ids, $intTime){
		//下架
		$arrUp['houseStatus'] = House::STATUS_OFFLINE;
		$arrUp['houseTags'] = House::HOUSE_NOTAG; //标签收回
		$arrUp['houseFine'] = House::FINE_NO; //精品房源回收
		$arrUp['houseXiajia'] = date('Y-m-d H:i:s', $intTime);
		$arrUp['houseUpdate'] = date('Y-m-d H:i:s', $intTime);
		$this->begin();
		if($this->modifyUnitById($ids, $arrUp)){ //刷主表
			//更新该房源对应的ES数据
			global $sysES;
			$clsEs = new Es($sysES['default']);
			foreach($ids as $id)
			{
				$intFlag = $clsEs->update(array('id' => $id, 'data' => $clsEs->houseFormat($arrUp)));
				if($intFlag == false){
					$this->rollback();
					return false;
				}

				//更新队列
				$intFlag = Quene::Instance()->Put('house', array('action' => 'offline', 'houseId' => $id, 'realId' => $GLOBALS['client']['realId'], 'cityId' => $GLOBALS['client']['cityId'], 'status' => $arrUp['houseStatus'], 'time' => date('Y-m-d H:i:s', time())));
				if ( $intFlag == false ) {
					$this->rollback();
					return false;
				}
			}
			
			//如果房源下架，取消定时刷新队列
			if(!VipRefreshQueue::Instance()->deleteAll(" houseId in (".implode(',', $ids).")"))
			{
				$this->rollback();
				return false;
			}

			$this->commit();
			return true;
		}
		$this->rollback();
		return false;
	}


    /**
     * 上架房源
     * @param int|array $ids 数组为更新多条
     * @return int|bool 成功返回影响条数，失败返回false
     */
    public function onLineWechatUnit($ids, $intTime,$realId,$cityId){
        //发布
        $arrUp['houseStatus'] = House::STATUS_ONLINE;
        $arrUp['houseXiajia'] = '0000-00-00 00:00:00';

        //为审核做准备（取消），上下架不改变违规状态
        /*$arrUp['houseVerification'] = House::HOUSE_VERING;
        $arrAu['haStatus'] = HouseAuditing::HOUSE_VERING;
        $arrAu['haUpdate'] = '0000-00-00 00:00:00';*/

        $arrUp['houseUpdate'] = date('Y-m-d H:i:s', $intTime);
        $this->begin();
        if($this->modifyUnitById($ids, $arrUp)){ //刷主表
            //更新房源审核表
            /*$clsUnitAudit = new HouseAuditing();
            $intFlagAudit = $clsUnitAudit->modifyUnitById($ids, $arrAu);
            if ( $intFlagAudit === false )
            {
                $this->rollback();
                return false;
            }*/
            //更新该房源对应的ES数据
            global $sysES;
            $clsEs = new Es($sysES['default']);
            foreach($ids as $id)
            {
                $intFlag = $clsEs->update(array('id' => $id, 'data' => $clsEs->houseFormat($arrUp)));
                if($intFlag == false){
                    $this->rollback();
                    return false;
                }

                //更新队列
                $intFlag = Quene::Instance()->Put('house', array('action' => 'online', 'houseId' => $id, 'realId' =>$realId, 'cityId' => $cityId, 'status' => $arrUp['houseStatus'], 'time' => date('Y-m-d H:i:s', time())));
                if ( $intFlag == false ) {
                    $this->rollback();
                    return false;
                }
            }

            $this->commit();
            return true;
        }
        $this->rollback();
        return false;
    }

    /**
     * 下架房源
     * @param int|array $ids 数组为更新多条
     * @return int|bool 成功返回影响条数，失败返回false
     */
    public function offLineWechatUnit($ids, $intTime,$realId,$cityId){
        //下架
        $arrUp['houseStatus'] = House::STATUS_OFFLINE;
        $arrUp['houseTags'] = House::HOUSE_NOTAG; //标签收回
        $arrUp['houseFine'] = House::FINE_NO; //精品房源回收
        $arrUp['houseXiajia'] = date('Y-m-d H:i:s', $intTime);
        $arrUp['houseUpdate'] = date('Y-m-d H:i:s', $intTime);
        $this->begin();
        if($this->modifyUnitById($ids, $arrUp)){ //刷主表
            //更新该房源对应的ES数据
            global $sysES;
            $clsEs = new Es($sysES['default']);
            foreach($ids as $id)
            {
                $intFlag = $clsEs->update(array('id' => $id, 'data' => $clsEs->houseFormat($arrUp)));
                if($intFlag == false){
                    $this->rollback();
                    return false;
                }

                //更新队列
                $intFlag = Quene::Instance()->Put('house', array('action' => 'offline', 'houseId' => $id, 'realId' => $realId, 'cityId' => $cityId, 'status' => $arrUp['houseStatus'], 'time' => date('Y-m-d H:i:s', time())));
                if ( $intFlag == false ) {
                    $this->rollback();
                    return false;
                }
            }

            $this->commit();
            return true;
        }
        $this->rollback();
        return false;
    }
	
	/**
	 * 通过搜索条件获取房源id
	 * 
	 * return array
	 */
	public function getSearchUnit($condition=array(), $order='', $offset=0, $size=20, $isES=TRUE, $houseType) 
	{
		if( $isES === TRUE )
		{ //从ES中搜索数据
			global $sysES;
			$params = $sysES['default'];
			$params['index'] = 'esf';
			$params['type'] = 'house';
			$client = new Es($params);
				
			$conditionEs = $client->houseFormat($condition);
			$arrSelect = $client->search(array('where' => $conditionEs, 'limit' => array($offset, $size), 'order' => $order));
				
			$intTotal = intval($arrSelect['total']);
			if ( !empty($arrSelect['data']) )
			{
				foreach($arrSelect['data'] as $value)
				{
					$arrIds[] = $value['houseId'];
				}
			}
			//$arrIds = empty($arrSphinx['matches'])? array(): array_keys($arrSphinx['matches']);

		}
		else
		{ //从数据库中搜索
			$where = " status != 0 and id in (".implode(',', $condition['id']).")";
			$intTotal = self::getCount($where);
			if( $intTotal>0 )
			{
				$arrUnit = self::getAll($where, '', '', '', 'id');
				$arrIds = array();
				foreach ($arrUnit as $unit) 
				{
					$arrIds[] = $unit['id'];
				}
				unset($arrUnit);
			}
		}
		if( empty($arrIds) ) return array();
		$arrUnit = $this->getAllHouse($arrIds, $houseType);
		return array('arrData'=>$arrUnit, 'intTotal'=>$intTotal);
	}
	
	public function getAllHouse($arrHouseId, $houseType)
	{
		//加载房源的基本信息
		if ( $houseType == 'Sale' ) 
		{
			$arrHouse = House::find(array("id IN(".implode(',', $arrHouseId).")", 'columns' => 'id,hoId,parkId as projId,bedRoom,status,livingRoom,bathRoom,picId,picExt,tags,fine, price as housePrice, unit as price,bA as area,create as addTime,houseUpdate as modifyTime, status, floor, floorMax, decoration, orientation, type'))->toArray();
			$arrUnit = Sale::find(array("houseId IN(".implode(',', $arrHouseId).")", 'columns' => 'houseId,parkName,features'))->toArray();
			foreach ( $arrUnit as $k => $v ) 
			{
				$arrUnitData[$v['houseId']]['parkName'] = $v['parkName'];
				$arrUnitData[$v['houseId']]['features'] = $v['features'];
			}
			$arrHouseExt = HouseExt::find(array("id IN (".implode(',', $arrHouseId).") AND name='customId'", 'columns' => 'houseId,value'))->toArray();
			foreach ( $arrHouseExt as $k => $v ) 
			{
				$arrHouseExt[$v['houseId']] = $v['value'];
			}
		} 
		else 
		{
			$arrHouse = House::find(array("id IN (".implode(',', $arrHouseId).")", 'columns' => 'id,hoId,parkId as projId,bedRoom,status,livingRoom,bathRoom,picId,picExt,tags,fine,unit as price,bA as area,create as addTime,houseUpdate as modifyTime, status, floor, floorMax, decoration, orientation, type'))->toArray();
			$arrUnit = Rent::find(array("houseId IN (".implode(',', $arrHouseId).")", 'columns' => 'houseId,parkName,price,currency'))->toArray();
			foreach ( $arrUnit as $k => $v ) 
			{
				$arrUnitData[$v['houseId']]['parkName'] = $v['parkName'];
				$arrUnitData[$v['houseId']]['rentPrice'] = $v['price'];
				$arrUnitData[$v['houseId']]['rentCurrency'] = $v['currency'];
			}
			$arrHouseExt = HouseExt::find(array("houseId IN (".implode(',', $arrHouseId).") AND name='customId'", 'columns' => 'houseId,value'))->toArray();
			foreach ( $arrHouseExt as $k => $v ) 
			{
				$arrHouseExt[$v['houseId']] = $v['value'];
			}
		}
		if ( !empty($arrHouse) ) 
		{
			//加载房源图片数量
			$intHouseType = $houseType == 'Sale' ? House::TYPE_ERSHOU : House::TYPE_ZHENGZU;
			$arrHousePicture = HousePicture::find(array("houseId IN (".implode(',', $arrHouseId).")", 'columns' => 'COUNT(1) AS cnt,houseId', 'group' => 'houseId'))->toArray();
			if ( !empty($arrHousePicture) ) 
			{
				foreach ( $arrHousePicture as $k => $v ) 
				{
					$arrHousePicture[$v['houseId']] = $v['cnt'];
				}
			}
			//扩展房源点击信息
			$clsZebHouse = new ZebHouse();
			$arrUnitClick = $clsZebHouse->getUnitClick($arrHouseId);
			foreach ( $arrHouse as $k => $v ) 
			{
				$arrHouse[$v['id']] = $v;
				unset($arrHouse[$k]);
				$arrHouse[$v['id']]['projName'] = isset($arrUnitData[$v['id']]['parkName']) ? $arrUnitData[$v['id']]['parkName'] : '';
				$arrHouse[$v['id']]['features'] = isset($arrUnitData[$v['id']]['features']) ? $arrUnitData[$v['id']]['features'] : '';
				$arrHouse[$v['id']]['CustomId'] = isset($arrHouseExt[$v['id']]) ? $arrHouseExt[$v['id']] : '';
				$arrHouse[$v['id']]['imageCount'] = isset($arrHousePicture[$v['id']]) ? $arrHousePicture[$v['id']] : 0;
				$arrHouse[$v['id']]['rentPrice'] = isset($arrUnitData[$v['id']]['rentPrice']) ? $arrUnitData[$v['id']]['rentPrice'] : '';
				$arrHouse[$v['id']]['rentCurrency'] = isset($arrUnitData[$v['id']]['rentCurrency']) ? $arrUnitData[$v['id']]['rentCurrency'] : '';
				$arrHouse[$v['id']]['clickToday'] = isset($arrUnitClick[$v['id']]['today']) ? $arrUnitClick[$v['id']]['today'] : 0;
				$arrHouse[$v['id']]['clickYesterday'] = isset($arrUnitClick[$v['id']]['yesterday']) ? $arrUnitClick[$v['id']]['yesterday'] : 0;
				$arrHouse[$v['id']]['clickTotal'] = isset($arrUnitClick[$v['id']]['month']) ? $arrUnitClick[$v['id']]['month'] : 0;
    		}
    		unset($arrHousePicture, $arrUnitClick);
		}
		//重构并填充数据
		if ( ! empty($arrHouseId) )
		{
			foreach ( $arrHouseId as $key => $item )
			{
				$arrNewHouse[$item] = isset($arrHouse[$item]) ? $arrHouse[$item] : array();
			}
		}
		return $arrNewHouse;
	}
	
	public function getAllHouseId($condition=array(), $order='', $offset = 0, $size = 20, $isES=TRUE, $houseType)
	{
		if( $isES === TRUE )
		{ //从ES中搜索数据
			global $sysES;
			$params = $sysES['default'];
			$params['index'] = 'esf';
			$params['type'] = 'house';
			$client = new Es($params);
			if($houseType == 1)
			{
				$arrType[] = House::TYPE_CIXIN;
				$arrType[] = House::TYPE_ERSHOU;
				$arrType[] = House::TYPE_XINFANG;
			}
			else
			{
				$arrType[] = House::TYPE_HEZU;
				$arrType[] = House::TYPE_ZHENGZU;
			}
			$condition['houseType'] = array('or' => $arrType);
			$conditionEs = $client->houseFormat($condition);
			$arrSelect = $client->search(array('where' => $conditionEs, 'limit' => array($offset, $size), 'order' => $order));
			
			$intTotal = intval($arrSelect['total']);
			if ( !empty($arrSelect['data']) )
			{
				foreach($arrSelect['data'] as $value)
				{
					$arrIds[] = $value['houseId'];
				}
			}
		}
		else
		{ //从数据库中搜索
			$where = " 1=1";
			if($houseType == 1)
			{
				$where .= " and type in (".House::TYPE_CIXIN.", ".House::TYPE_ERSHOU.", ".House::TYPE_XINFANG.")";
			}
			else
			{
				$where .= " and type in (".House::TYPE_HEZU.", ".House::TYPE_ZHENGZU.")";
			}
			foreach($condition as $key=>$value)
			{
				$where .=" and $key = $value";
			}
			$intTotal = self::getCount($where);
			if( $intTotal>0 )
			{
				$arrUnit = self::getAll($where, '', '', '', 'id');
				$arrIds = array();
				foreach ($arrUnit as $unit)
				{
					$arrIds[] = $unit['id'];
				}
				unset($arrUnit);
			}
		}
		if( empty($arrIds) ) return array();
		return $arrIds;  
	}
    
    /**
     * 获取经纪人 1:发布房源数；2：推荐房源数；3：库存房源数
     * @param type $realIds
     * @param type $type
     * @param type $houseType
     * @return type
     */
    public function getHouseNumByRealIds($realIds, $type = 3, $houseType = 'sale') 
    {
        if(empty($realIds) || !in_array($type, array(1,2,3)))
        {
            return array();
        }
        if(is_array($realIds))
            $where = "realId in (".implode(',', $realIds).")";
        else
            $where = "realId={$realIds}";
        
        if('sale' == $houseType)
            $where .= " and type in (".House::TYPE_CIXIN.", ".House::TYPE_ERSHOU.", ".self::TYPE_XINFANG.")";
        elseif('rent' == $houseType)
            $where .= " and type in (".House::TYPE_HEZU.", ".House::TYPE_ZHENGZU.")";
            
        if(1 == $type)
            $where .= " and status=".self::STATUS_ONLINE;
        elseif(2 == $type)
            $where .= " and fine=".self::FINE_YES; 
        elseif(3 == $type)
            $where .= " and status=".self::STATUS_OFFLINE;
        
        $condition = array(
            'conditions' => $where,
            'group'      => 'realId',
            'columns'    => 'count(*) as num,realId'
        );
        $res = self::find($condition, 0)->toArray();
        $data = array();
        
        foreach($res as $v)
        {
            $data[$v['realId']] = intval($v['num']);
        }
        
        return $data;
    }

    /*
     * 获取房源审核信息
     * */
    public function getHouseAuditing($con,$size=0, $offset=0, $order="auditing"){
        $rs = self::find([
            "conditions" => $con,
            "order" => "$order desc",
            "limit" => [
                'number' => $size,
                'offset' => $offset
            ],
        ])->toArray();
        foreach($rs as &$v){
            $rslog = HouseOplog::instance()->getInfoById($v['id']);
            $v['opName'] = $rslog['opName'];
            $v['opValue']  = $rslog['opValue'];
            $v['opTime'] = $rslog['time'];
        }

        return $rs;

    }

	/**
	 * 门店系统 恢复 回收站状态的房源给指定经纪人
	 *
	 * @param array $ids
	 * @param array $realtorData
	 */
	public  function recoveryUnitByRealtorIds($ids,$realtorData) {
		//根据参数 更新DB
		$this->begin();
		foreach ($ids as $id) {
			$flag = $this->modifyHouseById($id, $realtorData);
			if($flag === false) {
				$this->rollback();
				return false;
			}
			//更新ES,失败则回滚
			global $sysES;
			$params = $sysES['default'];
			$params['index'] = 'esf';
			$params['type'] = 'house';
			$client = new Es($params);
			$intFlag = $client->update(array('id' => $id, 'data' => $client->houseFormat($realtorData)));
			if( !$intFlag )
			{
				$this->rollback();
				return false;
			}
		}
		$this->commit();
		return TRUE;
	}

    /*
     * 面积房源比例
     * */
    public function getHouseByTime($cityId, $startTime, $endTime, $comId, $houseType=1){
        if($houseType==1){
            $where = " AND type in (".House::TYPE_CIXIN.",".House::TYPE_ERSHOU.",".self::TYPE_XINFANG.")";
        }else{
            $where = " AND type in (".House::TYPE_ZHENGZU.",".House::TYPE_HEZU.")";
        }
        $rs = $this->find([
            "conditions" => "cityId=$cityId AND roleType=".self::ROLE_REALTOR." AND create>='$startTime 00:00:00' AND create<= '$endTime 23:59:59' ".$where,
            "columns"=>"comId  ,id, bA"
        ])->toArray();
        $result = array();
        foreach($rs as $one){
            $area = intval($one['bA']);
            if( $area <  50){
                $result[0]['house'] += 1;
                if(in_array($one['comId'], $comId)) $result[0]['company'][$one['comId']] += 1;
            }elseif($area >= 50 && $area < 70 ){
                $result[1]['house'] += 1;
                if(in_array($one['comId'], $comId)) $result[1]['company'][$one['comId']] += 1;
            }elseif($area >= 70 && $area < 90){
                $result[2]['house'] += 1;
                if(in_array($one['comId'], $comId)) $result[2]['company'][$one['comId']] += 1;
            }elseif($area >= 90 && $area < 120 ){
                $result[3]['house'] += 1;
                if(in_array($one['comId'], $comId)) $result[3]['company'][$one['comId']] += 1;
            }elseif($area >= 120 && $area < 150){
                $result[4]['house'] += 1;
                if(in_array($one['comId'], $comId)) $result[4]['company'][$one['comId']] += 1;
            }elseif($area >= 150 && $area < 200){
                $result[5]['house'] += 1 ;
                if(in_array($one['comId'], $comId)) $result[5]['company'][$one['comId']] += 1;
            }elseif($area >= 200 && $area < 300){
                $result[6]['house'] += 1;
                if(in_array($one['comId'], $comId)) $result[6]['company'][$one['comId']] += 1;
            }elseif($area >= 300){
                $result[7]['house'] += 1;
                if(in_array($one['comId'], $comId)) $result[7]['company'][$one['comId']] += 1;
            }
        }
        $unit = array();
        foreach($result as $k=>$v){
            $unit[$k]['house'] = round($v['house']/count($rs)*100,1)."%";
            if(isset($v['company'])){
                foreach($v['company'] as $comId=>$comV){
                    $unit[$k]['company'][$comId] = round($comV/count($rs)*100,1)."%";
                }
            }
        }
        unset($result);
        return $unit;
    }

    /*
 * @desc 根据小区id获取房源
 * */
    public function getHouseByParkId($parkId){
        $rs = self::find([
            "conditions" => "parkId=".$parkId
        ])->toArray();
        if(empty($rs)) return array();
        foreach ($rs as $k=>$v){
            $result[$v['id']] = $v['id'];
        }
        return $result;
    }

    /*
     * @desc 小区房源转移
     * */
    public function moveHouseToNewPark($fromparkId, $toParkId){
        $rs = self::find([
            "conditions" => "parkId=".$fromparkId
        ])->toArray();
        if(empty($rs)) return array('status'=>false, 'info'=>'转移失败，被转移小区房源为空！');
        foreach ($rs as $k=>$v){
            $houseIds[$v['id']] = $v['id'];
        }

        $arrUp['parkId'] = $toParkId;
        $park = Park::findFirst("id=".$toParkId);
        $this->begin();
        if($this->modifyUnitById($houseIds, $arrUp)){ //刷主表
            //更新该房源对应的ES数据
            global $sysES;
            $clsEs = new Es($sysES['default']);
            $ids = array();
            try {
                foreach($houseIds as $id)
                {
                    $house = House::findFirst($id);
                    if($house->roleType ==2){
                        $arrUp['roleType'] = $house->roleType;
                    }
                    if($park){
                        $arrUp['parkName'] = $park->name;
                    }
                    $intFlag = $clsEs->update(array('id' => $id, 'data' => $clsEs->houseFormat($arrUp)));
                    if($intFlag == false){
                        $ids[] = $id;
                    }
                }
            }
            catch (Exception $ex){
                return false;
            }
            if(count($ids)>0){
                $this->rollback();
                return array('status'=>false, 'info'=>'转移失败，房源'.implode(",", $ids ).'不在ES里面！');
            }
            $rs = RefreshLog::instance()->updateAll(" parkId = ".$fromparkId, array("parkId"=>$toParkId));
            if(!$rs){
                return array("status"=>false,"info"=>"更新刷新表出错！");
                $this->rollback();
            }
            $rs = HousePicture::instance()->updateAll(" parkId = ".$fromparkId, array("parkId"=>$toParkId));
            if(!$rs){
                return array("status"=>false,"info"=>"更新房源图片表出错！");
                $this->rollback();
            }
            $rs = HouseCollect::instance()->updateAll(" parkId = ".$fromparkId, array("parkId"=>$toParkId));
            if(!$rs){
                return array("status"=>false,"info"=>"更新房源收藏表出错！");
                $this->rollback();
            }
            $this->commit();
            return array('status'=>true, 'info'=>'转移成功,共转移'.count($houseIds)."条房源!");
        }
        $this->rollback();
        return array('status'=>false, 'info'=>'转移失败!');
    }

    /**
     * 根据房源ID过滤非上架状态的房源
     * @param unknown $strHouseID
     * @return boolean|multitype:unknown |multitype:
     */
    public function getHouseOnlineByIds( $strHouseID )
    {
    	if ( empty($strHouseID) )
    	{
    		return false;
    	}
    	
    	$where = "id in({$strHouseID}) and status in(".self::STATUS_ONLINE.")";
    	$arrHouseIDs = self::find([
    			"conditions"=> $where,
    			"columns"	=>"id"
        ])->toArray();
    	
    	if(!empty($arrHouseIDs))
    	{
    		$arrOnlineHouseID = array();
    		foreach($arrHouseIDs as $strVal)
    		{
    			$arrOnlineHouseID[] = $strVal['id'];
    		}
    		return $arrOnlineHouseID;
    	}
    	return array();
    }

    public function getHouseIdByCode($houseCode){
        $arrCondition['conditions'] = "code=:code:";
        $arrCondition['bind'] = array(
            "code"  =>  $houseCode
        );
        return self::findFirst($arrCondition, 0)->toArray();
    }
    
    /**
     * 根据 房源id 获取新的房源id
     * @param array $houseId  array('houseId'=>1, 'houseType'=>'rent|sale', 'cityId'=>1)
     * @return array
     */
    public function getNewIdByHouseId($houseId)
    {
        if(empty($houseId))
        {
            return array();
        }
        $newHouseId = $houseCode = array();
        foreach($houseId as $v)
        {
            if($v['houseId'] >= self::MIN_HOUSE_ID)
            {
                //新的房源id
                $newHouseId[$v['houseId']] = $v['houseId'];
            }
            else
            {
                //从老表中倒过来的房源id
                if('sale' == $v['houseType'])
                {
                    $houseCode[$v['houseId']] = sprintf("2%02d%09d", $v['cityId'], $v['houseId']);
                }
                else
                {
                    $houseCode[$v['houseId']] = sprintf("1%02d%09d", $v['cityId'], $v['houseId']);
                }
            }
        }
        
        if(!empty($houseCode))
        {
            $where = "code in(".  implode(',', $houseCode).")";
            $condition = array(
                'conditions' => $where,
                'columns'    => 'id,code'
            );
            $data = self::find($condition, 0)->toArray();
            foreach($data as $v)
            {
                $oldHouseId = array_search($v['code'], $houseCode);
                $newHouseId[$oldHouseId] = $v['id'];
            }
        }
        
        return $newHouseId;
    }

}
