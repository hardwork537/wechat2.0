<?php
/**
 * @abstract 区域表
 * @author jackchen
 * @since  2014-09-18
 */
class Area extends BaseModel
{
    //区域状态 0：关闭  1：有效  -1:删除
    const STATUS_GUANBI = 0;
    const STATUS_OK = 1;
    const STATUS_DEL = -1;
    
    //是否可以创建经纪人
    const REALTOR_YES = 1;	//是
    const REALTOR_NO  = 2;	//否
    
    public $id;
    public $comId;
    public $regId = 0;
    public $distId = 0;
    public $cityId;
    public $name = '';
    public $parentId = 0;
    public $createRealtor = 1;
    public $abbr = '';
    public $address = '';
    public $postcode = '';
    public $tel = '';
    public $fax = '';
    public $X = '';
    public $Y = '';
    public $lonLat = '';
    public $logo = '';
    public $salesId = 0;
    public $CSId = 0;
    public $status;
    public $update;   


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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if($name == '' || mb_strlen($name, 'utf8') > 50)
        {
            return false;
        }
        $this->name = $name;
    }

    public function getAbbr()
    {
        return $this->abbr;
    }

    public function setAbbr($abbr)
    {
        if($abbr == '' || mb_strlen($abbr, 'utf8') > 30)
        {
            return false;
        }
        $this->abbr = $abbr;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        if($address == '' || mb_strlen($address, 'utf8') > 50)
        {
            return false;
        }
        $this->address = $address;
    }

    public function getTel()
    {
        return $this->tel;
    }

    public function setTel($tel)
    {
        if($tel == '' || mb_strlen($tel, 'utf8') > 30)
        {
            return false;
        }
        $this->tel = $tel;
    }

    public function getFax()
    {
        return $this->fax;
    }

    public function setFax($fax)
    {
        if($fax == '' || mb_strlen($fax, 'utf8') > 30)
        {
            return false;
        }
        $this->fax = $fax;
    }

    public function getX()
    {
        return $this->X;
    }

    public function setX($X)
    {
        if($X == '' || mb_strlen($X, 'utf8') > 50)
        {
            return false;
        }
        $this->X = $X;
    }

    public function getY()
    {
        return $this->Y;
    }

    public function setY($Y)
    {
        if($Y == '' || mb_strlen($Y, 'utf8') > 50)
        {
            return false;
        }
        $this->Y = $Y;
    }

    public function getLonLat()
    {
        return $this->lonLat;
    }

    public function setLonLat($lonLat)
    {
        if($lonLat == '' || mb_strlen($lonLat, 'utf8') > 30)
        {
            return false;
        }
        $this->lonLat = $lonLat;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function setLogo($logo)
    {
        if($logo == '' || mb_strlen($logo, 'utf8') > 50)
        {
            return false;
        }
        $this->logo = $logo;
    }

    public function getSalesId()
    {
        return $this->salesId;
    }

    public function setSalesId($salesId)
    {
        if(preg_match('/^\d{1,10}$/', $salesId == 0) || $salesId > 4294967295)
        {
            return false;
        }
        $this->salesId = $salesId;
    }

    public function getCSId()
    {
        return $this->CSId;
    }

    public function setCSId($CSId)
    {
        if(preg_match('/^\d{1,10}$/', $CSId == 0) || $CSId > 4294967295)
        {
            return false;
        }
        $this->CSId = $CSId;
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
        return 'area';
    }

    public function columnMap()
    {
        return array(
            'areaId' => 'id',
            'comId' => 'comId',
            'regId'=>'regId',
            'distId'=>'distId',
            'cityId' => 'cityId',
            'areaName' => 'name',
        	'areaParentId' => 'parentId',
        	'areaCreateRealtor' => 'createRealtor',		
            'areaAbbr' => 'abbr',
            'areaAddress' => 'address',
            'areaPostcode' => 'postcode',
            'areaTel' => 'tel',
            'areaFax' => 'fax',
            'areaX' => 'X',
            'areaY' => 'Y',
            'areaLonLat' => 'lonLat',
            'areaLogo' => 'logo',
            'areaSalesId' => 'salesId',
            'areaCSId' => 'CSId',
            'areaStatus' => 'status',
            'areaUpdate' => 'update',
        );
    }


    /**
     * 根据区域ID，获取数据
     * @param   int   $areaId
     * @return  array $data
     */
    public function getAreaById($areaId)
    {
        if(!$areaId){
            return false;
        }
        $arrCond  = "id = ?1";
        $arrParam = array(1=>$areaId);
        $data = self::findFirst(
            array(
                $arrCond,
                "bind" => $arrParam
            ),0
        );
        return $data->toArray();
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

    //修改区域
    public function editAreaById($areaId, $arrUpdate){
        $arrCond  = "id = ?1  ";
        $arrParam = array(1=>$areaId);
        $objArea =  self::findFirst(
            array(
                $arrCond,
                "bind" => $arrParam
            )
        );
        if(isset($arrUpdate['name'])){
            $objArea->name =$arrUpdate['name'] ;
        }
        if(isset($arrUpdate['salesId'])){
            $objArea->salesId = $arrUpdate['salesId'];
        }
        if(isset($arrUpdate['CSId'])){
            $objArea->CSId = $arrUpdate['CSId'];
        }
        $objArea->update = date("Y-m-d H:i:s");
        $intFlag = $objArea->update();
        if( !$intFlag )
        {
            return false;
        }
        return $intFlag;
    }

    //删除
    public function delAreaById($id){
        $objArea =  self::findFirst("id=".$id);
        $objArea->status = -1;
        $objArea->update = date("Y-m-d H:i:s");
        $intFlag = $objArea->update();
        if( !$intFlag )
        {
            return array('status'=>false, 'info'=>'删除失败！');
        }
        return array('status'=>true, 'info'=>'删除成功！');
    }
    
    /**
     * 通过获取某一区域的所有区域  包含本身的id   递归
     * @param int $id
     * @return string 字符串，","分割
     */
    public function getAllAreaById($id,$status = '')
    {
    	$strBack = $id;
    	//增加条件，如果为空，则默认为全部的
    	$where = " parentId = $id";
    	if(!empty($status)) 
    	{
    		$where .= " and status = $status";
    	}
    	$arrArea = self::getAll($where,' name ASC','','',' id, parentId');

    
    	if(!empty($arrArea))
    	{
    		foreach($arrArea as $val)
    		{
    			$strBack .= ",".self::getAllAreaById($val['id']);
    		}
    	}
    	$strBack = rtrim($strBack, ",");
       
    	return $strBack;
    }
    
    /**
     * 根据区域id获得区域信息（支持批量）
     * @param array $arrId  array（id1，id2）
     * @return array(
     * 					id1 = array(区域信息)
     * 				)
     */
    public function getAreaByIds($arrId)
    {
    	if( empty($arrId) || !is_array($arrId) ){
    		$this->error = "参数错误";
    		return false;
    	}
    	$arrId = array_unique($arrId);

    	$where = " id in (".implode(',', $arrId).") and status =".Area::STATUS_OK;
    	
    	$arrArea = self::getAll($where,' name asc','','','');
    	if( false === $arrArea ){
    		return false;
    	}
    	if(empty($arrArea)){
    		return array();
    	}
    	$arrReturn = array(); //初始化返回值
    	foreach($arrArea as $itemArea){
    		$arrReturn[$itemArea['id']] = $itemArea;
    	}
    	return $arrReturn;
    }   
    
    /**
     * 添加区域信息
     * @param unknown $arrData
     */
    public function addArea($arrData)
    {
    	if(empty($arrData))	return false;
    	
    	$arr = array(
    			'comId' 		=> isset($arrData['comId']) ? $arrData['comId'] : 0,
    			'regId' 		=> isset($arrData['regId']) ? $arrData['regId'] : 0,
    			'distId' 		=> isset($arrData['distId']) ? $arrData['distId'] : 0,
    			'cityId' 		=> isset($arrData['cityId']) ? $arrData['cityId'] : 0,
    			'name' 			=> isset($arrData['name']) ? $arrData['name'] : '',
    			'parentId' 		=> isset($arrData['parentId']) ? $arrData['parentId'] : 0,
    			'abbr'			=> isset($arrData['abbr']) ? $arrData['abbr'] : '',
    			'address'		=> isset($arrData['address']) ? $arrData['address'] : '',
    			'postcode' 		=> isset($arrData['postcode']) ? $arrData['postcode'] : '',
    			'tel' 			=> isset($arrData['tel']) ? $arrData['tel'] : '',
    			'fax' 			=> isset($arrData['fax']) ? $arrData['fax'] : '',
    			'X' 			=> isset($arrData['X']) ? $arrData['X'] : '',
    			'Y' 			=> isset($arrData['Y']) ? $arrData['Y'] : '',
    			'lonLat' 		=> isset($arrData['lonLat']) ? $arrData['lonLat'] : '',
    			'logo' 			=> isset($arrData['logo']) ? $arrData['logo'] : '',
    			'salesId' 		=> isset($arrData['salesId']) ? $arrData['salesId'] : 0,
    			'CSId' 			=> isset($arrData['CSId']) ? $arrData['CSId'] : 0,
    			'status' 		=> isset($arrData['status']) ? $arrData['status'] : '',
    			'update'		=> date('Y-m-d H:i:s'),
    	);
    	
    	return self::create($arr);
    }
    
    /**
     * 根据公司名、公司账号查找区域信息(区域）
     * @param array  $arrCondition
     * @param string $strColumns
     * @param string $strOrderBy
     * @param number $intLimit
     * @param number $intOffset
     * @return boolean|multitype:|unknown
     */
    public function getAreaListByCondition( $strCondition,$strColumns='',$strOrderBy='',$intLimit=0,$intOffset=0 )
    {
    	if( empty($strCondition) )	return false;
    	 
    	if( empty($intLimit) && empty($intOffset) )
    	{
    		return self::query()
    		->columns($strColumns)
    		->leftJoin('VipAccount', 'va.toId = Area.id', 'va')
    		->where($strCondition)
    		->orderBy($strOrderBy)
    		->execute()
    		->toArray();
    	}
    	else 
    	{
	    	return self::query()
	    	->columns($strColumns)
	    	->leftJoin('VipAccount', 'va.toId = Area.id', 'va')
	    	->where($strCondition)
	    	->orderBy($strOrderBy)
	    	->limit($intLimit,$intOffset)
	    	->execute()
	    	->toArray();
    	}
    }
    
    
   /**
    * 通过某一区域id获取该区域的门店   不获得子区域的门店    不调用递归
    * @param unknown $intAreaID
    * @param number $intCompanyID
    * @return boolean|unknown
    */
    public function getShopByAreaID($intAreaID,$intCompanyID = 0)
    {
    	if ( !is_numeric($intAreaID) || intval($intAreaID) <= 0 )
    	{
    		return false;
    	}
    	$arrCondition = array();
    	$arrCondition['id'] 	 = $intAreaID;
    	$arrCondition['status']  = Shop::STATUS_VALID;
    	if( $intCompanyID > 0 )
    	{
    		$arrCondition['comId'] = $intCompanyID;
    	}
    	
    	$strCondition = $this->getConditionByParam($arrCondition);
    	
    	return Shop::instance()->count($arrCondition);
    }
    
    /**
     * 通过某一区域id获取该区域的经纪人 不获得子区域的经纪人   不调用递归
     * @param int $sectorId
     * @return int
     */
    public function getRealtorByAreaID($intAreaID,$intCompanyID = 0)
    {
    	if ( !is_numeric($intAreaID) || intval($intAreaID) <= 0 )
    	{
    		return false;
    	}
    	$arrCondition = array();
    	$arrCondition['areaId'] = $intAreaID;
    	$arrCondition['status'] = Realtor::STATUS_OPEN;
    	if( $intCompanyID > 0 )
    	{
    		$arrCondition['comId'] = $intCompanyID;
    	}
    	
    	$strCondition = $this->getConditionByParam($arrCondition);
    	
    	return Realtor::instance()->count($strCondition);
    }
    
    /**
     * 通过某一区域id获取该区域的端口   不获取子区域    不调用递归
     * @param int $intAreaID
     * @return int
     */
    public function getPortByAreaID($intAreaID,$intCompanyID = 0)
    {
    	if ( !is_numeric($intAreaID) || intval($intAreaID) <= 0 )
    	{
    		return false;
    	}
    	$intReturnCount = 0;
    
    	$arrCondition = array();
    	$arrCondition['areaId'] = $intAreaID;
    	$arrCondition['status'] = RealtorPort::STATUS_ENABLED;
    	if( $intCompanyID > 0 )
    	{
    		$arrCondition['comId'] = $intCompanyID;
    	}
    	
    	$strCondition = $this->getConditionByParam($arrCondition);
    	
    	$objPort = RealtorPort::instance()->find($strCondition);
    	$arrPort = $objPort ? $objPort->toArray() : array();
    	
    	$intCount = 0;
    	if(!empty($arrPort))
    	{
	    	foreach ($arrPort as $strKey => $strVal )
	    	{
	    		//根据RealtorPort中的PortID去port_city获取端口数
	    		$objPortCity = PortCity::instance()->findFirst("portId = {$strVal['portId']}");
	    		$intCount += $objPortCity ? (int)$objPortCity->equivalent : 0;
	    	}
    	}
    	return $intCount;
    }
    
    /**
     * 通过某一个(调用递归)或多个(非调用递归)区域id获取该区域下的所有门店
     * 优化性能by lostsun@sohu-inc.com at 2014-03-11
     * @param string $sectorId
     * @return int
     */
    public function getShopCountByArea($arrAreaID)
    {
    	if(is_array($arrAreaID))
    	{
    		$arraySector = array();
    		foreach ($arrAreaID as $sid)
    		{
    			if(intval($sid)>0) $arraySector[] = intval($sid);
    		}
    		$strAreaIDs = implode(',', $arraySector);
    	}
    	else
    	{
    		if ( !is_numeric($arrAreaID) || intval($arrAreaID) <= 0)
    		{
    			return false;
    		}
    		
    		$strAreaIDs = $this->getAllAreaById($arrAreaID);
    	}
    	return Shop::instance()->count("areaId in ($strAreaIDs) and status=".Shop::STATUS_VALID);
    }
    
    /**
     * 通过某一个(调用递归)或多个(非调用递归)区域id获取该区域下的所有经纪人
     * 优化性能by lostsun@sohu-inc.com at 2014-03-11
     * @param int $sectorId
     * @return int
     */
    public function getRealtorCountByArea($arrAreaId,$intCompanyID = 0)
    {
    	if(is_array($arrAreaId))
    	{
    		$arraySector = array();
    		foreach ($arrAreaId as $sid)
    		{
    			if(intval($sid)>0) $arraySector[] = intval($sid);
    		}
    		$strSector = implode(',', $arraySector);
    	}
    	else
    	{
    		if ( !is_numeric($arrAreaId) || intval($arrAreaId) <= 0 )
    		{
    			return false;
    		}
    		$strSector = $this->getAllAreaById($arrAreaId);
    	}
    	
    	$strCondition = '';
    	if($intCompanyID > 0 )
    	{
    		$strCondition .= "comId = {$intCompanyID} and areaId in ({$strSector}) and status=".Realtor::STATUS_OPEN;
    	}
    	else
    	{
    		$strCondition .= "areaId in ({$strSector}) and status=".Realtor::STATUS_OPEN;
    	}
    	return Realtor::instance()->count($strCondition);
    }
    
    
    /**
     * 通过某一个(调用递归)或多个(非调用递归)区域id获取该区域下的所有端口
     * 优化性能by lostsun@sohu-inc.com at 2014-03-11
     * @param int $sectorId
     * @return int
     */
    public function getPortCountByArea($arrAreaId,$intCompanyID = 0)
    {
    	if(is_array($arrAreaId))
    	{
    		$arrSector = array();
    		foreach ($arrAreaId as $sid)
    		{
    			if(intval($sid)>0) $arrSector[] = intval($sid);
    		}
    		$strSector = implode(',', $arrSector);
    	}
    	else
    	{
    		if ( !is_numeric($arrAreaId) || intval($arrAreaId) <= 0 )
    		{
    			return false;
    		}
    		$strSector = $this->getAllAreaById($arrAreaId);
    	}

		$strCondition = '';
		if($intCompanyID > 0 )
		{
			$strCondition .= "comId = {$intCompanyID} and areaId in ($strSector) and status = ".RealtorPort::STATUS_ENABLED;
		}
		else
		{
			$strCondition .= "areaId in ($strSector) and status = ".RealtorPort::STATUS_ENABLED;
		}
		$objPort = RealtorPort::instance()->find($strCondition);
		$arrPort = $objPort ? $objPort->toArray() : array();
		$intCount = 0;
    	if(!empty($arrPort))
	    {
    		foreach ($arrPort as $strKey => $strVal )
	    		{
	    			//根据RealtorPort中的PortID去port_city获取端口数
	    			$objPortCity = PortCity::instance()->findFirst("portId = {$strVal['portId']}");
	    			$intCount += $objPortCity ? $objPortCity->equivalent : 0;
	    		}
	    }
	    return $intCount;
    }
    
    /**
     * 获取一条区域的信息及账户
     *
     * @param int $id 区域id
     * @return array
     */
    public function getOneDataById($id)
    {
    	if ( !is_numeric($id) || intval($id) <= 0 ) {
    		$this->error("未指定修改的区域帐号！");
    		return false;
    	}
    
        $arrArea = self::getOne(" id = $id");   
    	//实例化企业帐号类
    	$objVipAccount = new VipAccount();
    	$arrVipAccount = $objVipAccount->getOne(" toId = $id and to = ".VipAccount::ROLE_AREA);
    	if(is_array($arrVipAccount))
    	{
    		foreach($arrVipAccount as $key=>$val)
    		{
    			if($key != 'status')
    			{
    				$arrArea[$key] = $val;
    			}
    		}
    	}
    	return $arrArea;
    }

   /**
     * 通过某一区域id获取该区域的门店数组 不获得子区域的门店 不调用递归 联动用
     * @param string $areaId
     * @return array
     */
    public function getOnlyShopByArea($areaId)
    {
    	$arrNewSArea = array();
        if ( !is_numeric($areaId) || intval($areaId) <= 0 )
        {
            return false;
        }

        $arrArea = Shop::Instance()->getAll(array("areaId = ".$areaId." and status = ".Shop::STATUS_VALID));
        foreach($arrArea as $key=>$val)
        {
        	$arrNewSArea[$val['id']] = $val['name'];
        }
        return $arrNewSArea;
    }
    
    /**
     * 验证修改区域资料信息
     *
     * @param array $data 提交的信息
     * @return bool 成功返回true，失败返回false
     */
    public function checkAreaInfo( $data = array() )
    {
    	if( empty($data['address']) )
    	{
    		$this->error = "区域地址不能为空";
    		return false;
    	}
    	if( empty($data['tel']) )
    	{
    		$this->error = "区域电话不能为空";
    		return false;
    	}
    	if( !preg_match("/^[0-9]{8}$/",$data['tel']) )
    	{
    		$this->error = "电话只能输入8位数字";
    		return false;
    	}
    	return true;
    }
    /*
     * @desc 通过区域id获取区域信息，账号，父级区域名
     *
     * */
    public function getAreaInfoById($id){
        $data = Area::findFirst("id=$id",0)->toArray();
        if($data){
            $arrVipAccount = VipAccount::findFirst(" toId = $id and to = ".VipAccount::ROLE_AREA, 0) ->toArray() ;
            $data['accountName'] = $arrVipAccount['name'];

            if($data['comId']){
                $rs = Company::findFirst("id=".$data['comId'],0)->toArray();
                $data['comName'] = $rs['name'];
            }
            if($data['parentId']){
                $rsP = Area::findFirst("id=".$data['parentId'],0)->toArray();
                $data['parentName'] = $rsP['name'];
            }
            return $data;
        }
        return false;

    }
    
    /**
     * 根据区域id获取信息
     * @param int|array $areaIds
     * @param string    $columns
     * @param int       $status
     * @return array
     */
    public function getAreaByareaIds($areaIds, $columns = '', $status = self::STATUS_OK)
    {
        if(empty($areaIds))
        {
            return array();
        }
        if(is_array($areaIds))
        {
            $arrBind = $this->bindManyParams($areaIds);
            $arrCond = "id in({$arrBind['cond']}) and status={$status}";
            $arrParam = $arrBind['param'];
            $condition = array(
                $arrCond,
                "bind" => $arrParam,
            );
        }
        else
        {
            $condition = array('conditions'=>"id={$areaIds} and status={$status}");
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
    public function getAreaByComId($comId){
        $rs = $this->find("comId=$comId AND status=".self::STATUS_OK)->toArray();
        if(empty($rs)) return array();
        foreach($rs as $k=>$v){
            $result[$v['id']] = $v["name"];
        }
        return $result;
    }

}
