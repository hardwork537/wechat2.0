<?php

class HouseCollect extends BaseModel
{


    const TYPE_REALTOR = 1;//经纪人
    const TYPE_PERSONAL = 2;//个人
    
    //收藏房源类别houseType
    const TYPE_SALE = 1;
    const TYPE_RENT = 2;
    
    //收藏房源状态
    const STATUS_VALID = 1;
    const STATUS_INVALID = 2;
    
    private $mError;
    private static $LIMIT_MAX_AMOUNT = 10;//限制用户可收藏的出租或出售房源的最大个数

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $houseId;

    /**
     *
     * @var string
     */
    public $houseTitle;

    /**
     *
     * @var integer
     */
    public $houseType;

    /**
     *
     * @var integer
     */
    public $houseRoleType;

    /**
     *
     * @var integer
     */
    public $parkId;

    /**
     *
     * @var integer
     */
    public $realId;

    /**
     *
     * @var integer
     */
    public $personId;

    /**
     *
     * @var integer
     */
    public $createTime;
    public $status; 

    public function getSource()
    {
        return 'web_house_collect';
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'hcId' => 'id',
            'houseId' => 'houseId', 
            'houseTitle' => 'houseTitle', 
            'houseType' => 'houseType', 
            'houseRoleType' => 'houseRoleType',
            'parkId' => 'parkId', 
            'realId' => 'realId', 
            'personId' => 'personId',
            'hcCreateTime' => 'createTime',
        	'hcStatus' => 'status',
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }


    public function InsertUnitCollectInfo($data)
    {
        /************检查表单数据[start]************/
        if ( empty($data) ) {
            $this->setError("您提交的参数有误!");
            return false;
        }
        //校验表单数据并得到经过处理的表单数据
        $data = $this->checkParam($data);
        if(!$data) return false;
        /************检查表单数据[end]************/

        //检查已收藏出售或出租房源的个数
        $mHouse = new House();
        $houseInfo = $mHouse::findFirst("id=".$data['houseId'],0)->toArray();
        if (!$houseInfo) return false;
        $arSaleType = array(House::TYPE_XINFANG,House::TYPE_CIXIN,House::TYPE_ERSHOU);
        $arRentType = array(House::TYPE_HEZU, House::TYPE_ZHENGZU);
        $countStr = "(";
        $typeName = '';
        if (in_array($houseInfo['type'], $arSaleType)){ //出售
            $typeName = "出售";
            foreach($arSaleType as $key => $type){
                if ($key == 0){
                    $countStr .= "houseType=".$type;
                }
                else{
                    $countStr .= " or houseType=".$type;
                }

            }
        }
        else{
            $typeName = "出租";
            foreach($arRentType as $key => $type){
                if ($key == 0){
                    $countStr .= "houseType=".$type;
                }
                else{
                    $countStr .= " or houseType=".$type;
                }

            }
        }
        $countStr .= ")";
        $count =self::count($countStr." and personId=".$data['personId']);
        if(in_array($houseInfo['type'], $arSaleType)){ //出售
            $mSale = new Sale();
            $saleInfo = $mSale->getSaleById($data['houseId']);
            $houseInfo['title'] = $saleInfo ? $saleInfo->title : '';
        }
        else{
            $mRent = new Rent();
            $rentInfo = $mRent->getRentById($data['houseId']);
            $houseInfo['title'] = $rentInfo ? $rentInfo->title : '';
        }
        if(($count+1) > self::$LIMIT_MAX_AMOUNT) {

            $this->setError(sprintf("您已经收藏了%d条%s房源，不能再收藏%s房源了!", self::$LIMIT_MAX_AMOUNT,$typeName,$typeName));
            echo 0;
            exit;
            //return false;
        }

        /************整理入库字段值[start]************/
        //其它字段
        $insertData['createTime'] = date('Y-m-d H:i:s');
        $insertData['houseId'] = $data['houseId'];
        $insertData['personId'] = $data['personId'];
        $insertData['houseTitle'] = $houseInfo['title'];
        $insertData['status'] = self::STATUS_VALID;
        $insertData['houseRoleType'] = $houseInfo['roleType'];
        $insertData['parkId'] = $houseInfo['parkId'] ? $houseInfo['parkId'] : 0;
        $insertData['realId'] = $houseInfo['roleType'] == House::ROLE_REALTOR ? $houseInfo['realId'] : $houseInfo['hoId'] ;
        $insertData['houseType'] = in_array($houseInfo['type'], $arSaleType) ? self::TYPE_SALE : self::TYPE_RENT;
        /************整理入库字段值[end]************/
        //入库
        try{
            return self::create($insertData);
        }
        catch(Exception $e){
            return false;
        }
    }


    /**
     * 检查参数是否完整
     *
     * @param unknown_type $param
     * @return unknown
     */
    public function checkParam($data)
    {
        if(empty($data)) return false;

        //房源id
        $data['houseId'] = intval($data['houseId']);
        if($data['houseId'] <= 0)
        {
            $this->setError("房源id有误！");
            return false;
        }

        //个人id
        $data['personId'] = intval($data['personId']);
        if($data['personId'] <= 0)
        {
            $this->setError("个人id有误！");
            return false;
        }

        return $data;
    }

    public function setError($strError)
    {
        $this->mError = $strError;
    }

    /**
     * 获取错误描述
     *
     * @return string
     */
    public function getError() {
        return $this->mError;
    }


    public function deleteByCondition($strCondition){
        if ($strCondition == '') return false;
        try{
            return $this->delete($strCondition);
        }
        catch(Exception $e){
            return false;
        }
    }
    
    /**
     * @abstract 进行逻辑删除
     * @author Eric xuminwan@sohu-inc.com
     * @param int $hcId
     * @param array $data
     * @return bool
     */
    public function delHouseCollect($hcId, $data)
    {
    	$hcId = intval($hcId);
    	$rs = self::findfirst($hcId);
    	$rs->status = $data["status"];
    	if ($rs->update()) {
    		return true;
    	}
    	return false;
    }
    
    /**
     * @abstract 获取个人收藏的房源 
     * @author Eric xuminwan@sohu-inc.com
     * @param int $intPersonId
     * @param string $houseType
     * @return array
     * 
     */
    public function getHouseCollectByPersonId($intPersonId,$houseType = 'Sale')
    {
    	if(!$intPersonId) return array();
    	$strCondition = "personId = ?1";
    	if($houseType == 'Sale')
    	{
    		$strCondition .= " and houseType = ".self::TYPE_SALE;
    	}
    	elseif($houseType == 'Rent')
    	{
    		$strCondition .= " and houseType =".self::TYPE_RENT;
    	}
    	$strCondition .= " and status = ".self::STATUS_VALID;
    	$arrParam = array('1'=>$intPersonId);
    	$arrHouseCollect = self::find(array(
    			$strCondition,
    			'bind'=>$arrParam,
    			'order'=>'createTime desc',
    	),0)->toArray();
    	return $arrHouseCollect;
    }

    public static function instance ($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self();
    }
}
