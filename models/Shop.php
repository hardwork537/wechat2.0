<?php
class Shop extends BaseModel
{
    public $id;
    public $areaId = 0;
    public $comId;
    public $regId;
    public $distId;
    public $cityId;
    public $name;
    public $abbr = '';
    public $remark = '';
    public $accname = '';
    public $parentId = 0;
    public $address = '';
    public $postcode = '';
    public $tel = '';
    public $fax = '';
    public $X = '';
    public $Y = '';
    public $BX = '';
    public $BY = '';
    public $logoId = 0;
    public $logoExt = '';
    public $saleId = 0;
    public $CSId = 0;
    public $isAdmin = 1;
    public $status = self::STATUS_VALID;
    public $update;

    const STATUS_VALID   = 1;  //有效
    const STATUS_INVALID = 0;  //关闭
    const STATUS_DELETE  = -1; //删除

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

    public function getShopName()
    {
        return $this->shopName;
    }

    public function setShopName($shopName)
    {
        if($shopName == '' || mb_strlen($shopName, 'utf8') > 50)
        {
            return false;
        }
        $this->shopName = $shopName;
    }

    public function getShopAbbr()
    {
        return $this->shopAbbr;
    }

    public function setShopAbbr($shopAbbr)
    {
        if($shopAbbr == '' || mb_strlen($shopAbbr, 'utf8') > 30)
        {
            return false;
        }
        $this->shopAbbr = $shopAbbr;
    }

    public function getShopAddress()
    {
        return $this->shopAddress;
    }

    public function setShopAddress($shopAddress)
    {
        if($shopAddress == '' || mb_strlen($shopAddress, 'utf8') > 50)
        {
            return false;
        }
        $this->shopAddress = $shopAddress;
    }

    public function getShopPostcode()
    {
        return $this->shopPostcode;
    }

    public function setShopPostcode($shopPostcode)
    {
        if($shopPostcode == '' || mb_strlen($shopPostcode, 'utf8') > 6)
        {
            return false;
        }
        $this->shopPostcode = $shopPostcode;
    }

    public function getShopTel()
    {
        return $this->shopTel;
    }

    public function setShopTel($shopTel)
    {
        if($shopTel == '' || mb_strlen($shopTel, 'utf8') > 30)
        {
            return false;
        }
        $this->shopTel = $shopTel;
    }

    public function getShopFax()
    {
        return $this->shopFax;
    }

    public function setShopFax($shopFax)
    {
        if($shopFax == '' || mb_strlen($shopFax, 'utf8') > 30)
        {
            return false;
        }
        $this->shopFax = $shopFax;
    }

    public function getShopXY()
    {
        return $this->shopXY;
    }

    public function setShopXY($shopXY)
    {
        if($shopXY == '' || mb_strlen($shopXY, 'utf8') > 50)
        {
            return false;
        }
        $this->shopXY = $shopXY;
    }

    public function getShopLonLat()
    {
        return $this->shopLonLat;
    }

    public function setShopLonLat($shopLonLat)
    {
        if($shopLonLat == '' || mb_strlen($shopLonLat, 'utf8') > 30)
        {
            return false;
        }
        $this->shopLonLat = $shopLonLat;
    }

    public function getShopLogoId()
    {
        return $this->logoId;
    }

    public function setShopLogoId($shopLogo)
    {
        if($shopLogo == '' || mb_strlen($shopLogo, 'utf8') > 50)
        {
            return false;
        }
        $this->logoId = $shopLogo;
    }

    public function getShopSalesId()
    {
        return $this->shopSalesId;
    }

    public function setShopSalesId($shopSalesId)
    {
        if(preg_match('/^\d{1,10}$/', $shopSalesId == 0) || $shopSalesId > 4294967295)
        {
            return false;
        }
        $this->shopSalesId = $shopSalesId;
    }

    public function getShopCSId()
    {
        return $this->shopCSId;
    }

    public function setShopCSId($shopCSId)
    {
        if(preg_match('/^\d{1,10}$/', $shopCSId == 0) || $shopCSId > 4294967295)
        {
            return false;
        }
        $this->shopCSId = $shopCSId;
    }

    public function getShopStatus()
    {
        return $this->shopStatus;
    }

    public function setShopStatus($shopStatus)
    {
        if(preg_match('/^-?\d{1,3}$/', $shopStatus) == 0 || $shopStatus > 127 || $shopStatus < -128)
        {
            return false;
        }
        $this->shopStatus = $shopStatus;
    }

    public function getShopUpdate()
    {
        return $this->shopUpdate;
    }

    public function setShopUpdate($shopUpdate)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $shopUpdate) == 0 || strtotime($shopUpdate) == false)
        {
            return false;
        }
        $this->shopUpdate = $shopUpdate;
    }

    public function getSource()
    {
        return 'shop';
    }

    public function columnMap()
    {
        return array(
            'shopId'       => 'id',
            'comId'        => 'comId',
        	    'areaId'       => 'areaId',
            'regId'        => 'regId',
            'distId'       => 'distId',
            'cityId'       => 'cityId',
            'shopName'     => 'name',
            'shopAbbr'     => 'abbr',
        	'shopRemark'   => 'remark',
        	'shopAccname'  => 'accname',
        	'shopParentId' => 'parentId',
            'shopAddress'  => 'address',
            'shopPostcode' => 'postcode',
            'shopTel'      => 'tel',
            'shopFax'      => 'fax',
        	'shopX'        => 'X',
        	'shopY'        => 'Y',
            'shopBX'=>'BX',
            'shopBY'=>'BY',
            'shopLonLat'   => 'lonLat',

            'shopLogoId'     => 'logoId',
            'shopLogoExt'     => 'logoExt',
            'shopSalesId'  => 'saleId',
            'shopCSId'     => 'CSId',
            'isAdmin'     => 'isAdmin',
            'shopStatus'   => 'status',
            'shopUpdate'   => 'update',

        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self();
    }

    /**
     * 根据门店ID获取门店名
     * @param int $shopId
     * @return boolean
     */
    public function getShopById($shopId)
    {
    	if(empty($shopId))
    	{
    		return false;
    	}
    	return self::findfirst(" id=".$shopId);
    }

    /**
     * 编辑门店信息
     *
     * @param int   $id
     * @param array $data
     * @return array
     */
    public function edit($id, $data)
    {
        if(empty($data))
        {
            return array('status'=>1, 'info'=>'参数为空！');
        }
        if($this->isExistShopName($data["shopName"], $data["cityId"], $id, $data['comId']))
        {
            return array('status'=>1, 'info'=>'门店名称已经存在！');
        }
        
        $this->begin();
        $rs = self::findfirst($id);
        $rs->name = $data["shopName"];
        $rs->saleId = intval($data["saleId"]);
        $rs->CSId = intval($data["CSId"]);
        $rs->distId = $data["distId"];
        $rs->regId = $data["regId"];
        $rs->update = date("Y-m-d H:i:s");
        $data['comId'] > 0 && $rs->comId = $data['comId'];

        if(!$rs->update())
        {
            $this->rollback();
            return array('status'=>1, 'info'=>'门店修改失败！');
        }
        $allocationRes = $this->tranferShop(array($rs->id), $data['saleId'], $data['userId'], $data['userName'], $data["cityId"]);
        if(!$allocationRes)
        {
            $this->rollback();
            return array('status'=>1, 'info'=>'门店修改失败！');
        }
        //修改门店下面经纪人的区域、板块
        $realtors = Realtor::find("shopId={$rs->id} and cityId={$data["cityId"]} and status<>".Realtor::STATUS_DELETE);
        if($realtors)
        {
            foreach($realtors as $realtor)
            {
                if($realtor->distId != $data['distId'] || $realtor->regId != $data['regId'])
                {
                    $realtor->distId = $data['distId'];
                    $realtor->regId = $data['regId'];
                    if(!$realtor->update())
                    {
                        $this->rollback();
                        return array('status'=>1, 'info'=>'门店修改失败！');
                    }
                }
            }
        }
        $this->commit();
        return array('status'=>0, 'info'=>'门店修改成功！');       
    }

    private function isExistShopName($shopName, $cityId, $shopId=0, $comId=0)
    {
        $shopName = trim($shopName);
        if(empty($shopName))
        {
            return true;
        }
        $con['conditions'] = "name='{$shopName}' and cityId={$cityId} and status=" . self::STATUS_VALID;
        $shopId > 0 && $con['conditions'] .= " and id<>{$shopId}";
        $comId > 0 && $con['conditions'] .= " and comId={$comId}";
        
        $intCount = self::count($con);
        if($intCount > 0)
        {
            return true;
        }
        return false;
    }

    /**
     * 删除单条记录
     *
     * @param int $shopId
     * @return boolean
     */
    public function del($shopId)
    {
        $realNum = Realtor::count("shopId={$shopId} and status<>".Realtor::STATUS_DELETE);
        if($realNum > 0)
        {
            return array('status'=>1, 'info'=>'门店下还有经纪人，不能删除！');
        }
        $rs = self::findFirst("id=".$shopId);
        if(!$rs)
        {
            return array('status'=>1, 'info'=>'门店不存在！');
        }
        $rs->status = self::STATUS_DELETE;
        $this->begin();

        if($rs->update())
        {
            $shopAccount = VipAccount::findFirst("toId={$shopId} and to=".VipAccount::ROLE_SHOP." and status=".VipAccount::STATUS_VALID);
            if($shopAccount)
            {
                $shopAccount->status = VipAccount::STATUS_DELETE;
                if($shopAccount->update())
                {
                    $this->commit();
                    return array('status'=>0, 'info'=>'删除成功！');
                }
                $this->rollback();
                return array('status'=>1, 'info'=>'删除失败！');
            }
            else
            {
                $this->commit();
                return array('status'=>0, 'info'=>'删除成功！');
            }
            return array('status'=>0, 'info'=>'删除成功！');
        }
        $this->rollback();
        return array('status'=>1, 'info'=>'删除失败！');
    }

    /**
     * @abstract 批量获取门店信息
     * @author tonyzhao@sohu-inc.com
     * @param array $ids
     * @return array
     *
     */
	public function getShopByIds($ids, $columns = '')
	{
		if(!$ids)
            return array();
		if(is_array($ids))
		{
			$arrBind = $this->bindManyParams($ids);
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
                'conditions' => "id={$ids}"
            );
		}
        $columns && $condition['columns'] = $columns;
        $arrShop  = self::find($condition, 0)->toArray();
		$arrRshop=array();
		foreach($arrShop as $value)
		{
			$arrRshop[$value['id']] = $value;
		}
		return $arrRshop;
	}

	/**
	 * 根据门店ID获得已启用的经纪人总数(支持批量)
	 * @param arr $arrId array(id1,id2)
	 * @return
	 */
	public function getCountOpenRealtorByIdS($arrId){
		if( empty($arrId) || !is_array($arrId) ){
			$this->error('传参错误');
			return false;
		}

		$where = " shopId in (".implode(',', $arrId).") and status = ".Realtor::STATUS_OPEN." GROUP BY shopId";
		$objRealtor = new Realtor();
		$arrRealtor =  $objRealtor->getAll($where,'','','','shopId, count(id) as sum');

		if( false === $arrRealtor ){
			$this->error($objRealtor-> getError());
			return false;
		}
		$objRealtor= null;
		if( empty($arrRealtor) ){
			return array();
		}
		$arrReturn = array();
		foreach($arrRealtor as $itemRealtor){
			$arrReturn[$itemRealtor['shopId']] = $itemRealtor['sum'];
		}
		return $arrReturn;
	}

   /**
     * 通过某一门店id获取该门店的经纪人数组 联动用
     * @param int $shopId
     * @return array
     */
    public function getRealtorByShop($shopId)
    {
        $arrNewRealtor = array();
        if ( !is_numeric($shopId) || intval($shopId) <= 0 )
        {
            return false;
        }
        $condition = "shopId=".$shopId." and status=".Realtor::STATUS_OPEN;
        $arrRealtor = Realtor::Instance()->getAll($condition);
        foreach($arrRealtor as $key=>$val)
        {
            $arrNewRealtor[$val['id']] = $val['name'];
        }
        return $arrNewRealtor;
    }

	/**
	 * 判断登录展帐号是否存在
	 * @param str $strAgentAccname 登录帐号
	 */
	public function checkShopAccname($strAgentAccname)
	{
		if(empty($strAgentAccname) || strlen($strAgentAccname) >50)
		{
			$this->error('传参错误');
			return true;
		}
		//检查企业帐号中是否存在
		$objVipAccount = new VipAccount();
		$returnAccount = $objVipAccount->getCount(" name = '$strAgentAccname'");

		$condition = null;
		if( false !== $returnAccount && 0 == intval($returnAccount) ){
			$returnShop = $this->getCount(" accname = '$strAgentAccname'");
			if( false !== $returnShop && 0 == intval($returnShop) ){
				$this->error("此帐号不存在，可以添加");
				return false;
			}else{
				$this->error("门店中存在此帐号");
				return true;
			}
		}else{
			$this->error("企业中存在此帐号");
			return true;
		}
	}

	/**
	 * 验证门店输入信息
	 * @param array $arrShop 门店输入信息
	 * @return false or true;
	 */
	public function checkShopInfo($arrShop)
	{
		//检验传参
		if( empty($arrShop) || !is_array($arrShop)  )
		{
			$this->error('传参错误');
			return false;
		}
		//检验门店所属城市city_id
		if( !isset($arrShop['cityId']) ){
			$this->error('门店所属城市输入错误');
			return false;
		}
		//检验门店所属公司company_id
		if( !isset( $arrShop['comId']) ){
			$this->setError('门店所属公司输入错误');
			return false;
		}
		//检验门店所属区域sector_id
		if( !isset( $arrShop['areaId'] ) ){
			$this->error('门店所属区域输入错误');
			return false;
		}
		//检验门店所属名称agent_name
		if( !isset( $arrShop['name']) || empty($arrShop['name']) || strlen($arrShop['name'])>50 ){
			$this->error('门店所属名称输入错误');
			return false;
		}
		//检验门店所属城区district_id
		if( !isset( $arrShop['distId']) ){
			$this->error('门店所属城区输入错误');
			return false;
		}
		//检验门店所属板块hot_area_id
		if( !isset( $arrShop['regId']) ){
			$this->error('门店所属板块输入错误');
			return false;
		}
		//检验门店端口总数max_port
// 		if( !isset( $arrShop['max_port']) ){
// 			$this->error('门店所属端口总数输入错误');
// 			return false;
// 		}
		//检验门店所属地址address
		if( !isset( $arrShop['address'])  || strlen($arrShop['address'])>255 ){
			$this->error('门店所属地址输入错误');
			return false;
		}
		//检验门店所属地址tel
		if( !isset($arrShop['tel'])  || strlen($arrShop['tel'])>50 ){
			$this->error('门店所属电话输入错误');
			return false;
		}
		//检验门店所属logo_id
		if( !isset( $arrShop['logoId']) ){
			$this->error('门店所属logo_id输入错误');
			return false;
		}
		//检验门店所属logo_ext
		if( !isset( $arrShop['logoExt']) || strlen($arrShop['logoExt'])>20 ){
			$this->error('门店所属logo_ext输入错误');
			return false;;
		}
		//检验门店所属登录名agent_accname
		if( !isset( $arrShop['accname']) || empty($arrShop['accname']) || strlen($arrShop['logoExt'])>50 ){
			$this->error('门店所属登录名输入错误');
			return false;
		}
		//检验门店所属X经度坐标x
		if( !isset($arrShop['x']) || strlen($arrShop['x'])>50 ){
			$this->error('门店所属X经度坐标错误');
			return false;
		}
		//检验门店所属Y纬度坐标x
		if( !isset( $arrShop['y']) || strlen($arrShop['y'])>50 ){
			$this->setError('门店所属Y纬度坐标错误');
			return false;
		}
// 		//检验门店所属销售ID xiaoshou_id
// 		if( !isset( $arrShop['xiaoshou_id']) ){
// 			$this->error('门店所属销售ID错误');
// 			return false;
// 		}
// 		//检验门店所属客服ID kefu_id
// 		if( !isset( $arrShop['kefu_id']) ){
// 			$this->error('门店所属客服ID错误');
// 			return false;
// 		}
		$this->error('成功');
		return true;
	}

    public function addShop($data)
    {
        if(empty($data))
        {
            return array('status'=>1, 'info'=>'参数为空');
        }
        $isExist = $this->isExistShopName($data['name'], $data['cityId'],0 ,$data['comId']);
        if($isExist)
        {
            return array('status'=>1, 'info'=>'门店名已存在');
        }
        $this->begin();
        $rs = self::instance();
        foreach($data as $k=>$v)
        {
            $rs->$k = $v;
        }

        if(!$rs->create())
        {
            $this->rollback();
            return array('status'=>1, 'info'=>'添加失败');           
        }
        $allocationRes = Crmallocation::instance()->addAllocation(Crmallocation::SHOP, $rs->id, $data['saleId'], 0);
        if(!$allocationRes)
        {
            $this->rollback();
            return array('status'=>1, 'info'=>'公司修改失败！');
        }
        $this->commit();
        return array('status'=>0, 'info'=>'添加成功');
    }
	/*
	 * 添加门店信息
	* @param 门店的信息
	* @return false or true;;
	*/
	public function add($arrShop)
	{
		if( !is_array($arrShop)){
			$this->error("参数错误");
			return false;
		}
		//添加门店信息需要操作2个表(Shop,VipAccount),所以这里用事物处理 不支持事物 先取消事物
		//先添加企业账户 在添加门店信息

		$this->begin(); //事务开始
		$arrEnterprise = array( //初始化企业帐号信息
				'name'      => $arrShop['accname'], //企业登录帐号
				'password'  => $arrShop['passwd'], //企业登录密码
				'cityId'    => $arrShop['cityId'], //城市id
				'status'    => VipAccount::STATUS_VALID,
				'loginTime' => isset($arrShop['lastlogintime']) ? $arrShop['lastlogintime'] :time(), //企业最后登录时间
		);
		if(isset($arrShop['ent_type'])){
			$arrEnterprise['to'] = $arrShop['ent_type'];
			unset($arrShop['ent_type']);
		}else{
			$arrEnterprise['to'] = VipAccount::ROLE_SHOP;
		}

		$objVipAccount = new VipAccount();
		$arrCheck = $objVipAccount->checkVipAccountInfo($arrEnterprise);
		if( $arrCheck === false ){
			$this->error("企业参数错误");
			return false;
		}
		$returnAddShop = $this->tdAdd($arrShop); //添加门店信息
		$arrEnterprise['toId'] = $returnAddShop;
		$returnAddShop = intval($returnAddShop) > 0 ? true : false;
		if(false === $returnAddShop)
		{
			$this->rollback();
			return false;
		}

		$boolFlag = false;
		try
		{
			$objAccount = $objVipAccount->create($arrEnterprise);
			if($objAccount == true)
			{
				$boolFlag = true;
			}
			else
			{
				$this->rollback();
				return false;
			}
		}
		catch (Exception $ex)
		{
			$this->rollback();
			return false;
		}
		
		$arrAllocation = array(
				'type' => Crmallocation::SHOP,
				'typeId' => $arrEnterprise['toId'],
		        'toId1' => $arrShop['toId1'],
				'toId2' => $arrShop['toId2'],
				'status' => Crmallocation::STATUS_VALID
		);
		$objAllocation = new Crmallocation();
		unset($boolFlag);
		
		try
		{
			$objAll = $objAllocation->create($arrAllocation);
			if($objAll == true)
			{
				$boolFlag = true;
			}
			else
			{
				$this->rollback();
				return false;
			}
		}
		catch (Exception $ex)
		{
			$this->rollback();
			return false;
		}
		
		
		$this->commit();

		if($boolFlag)
		{
			$this->error('门店添加成功');
			return true;
		}
		else
		{
			$this->error('门店添加失败');
			return false;
		}
	}

	public function tdAdd($arrData)
	{
		if( empty($arrData) )	return false;

		//公司编号
		if( isset($arrData['comId']) )
		{
			$arrInsert['comId'] = $arrData['comId'];
		}
		//区域
		if( isset($arrData['areaId']) )
		{
			$arrInsert['areaId'] = $arrData['areaId'];
		}
		//板块
		if( isset($arrData['regId']) )
		{
			$arrInsert['regId'] = $arrData['regId'];
		}
		//区县
		if( isset($arrData['distId']) )
		{
			$arrInsert['distId'] = $arrData['distId'];
		}
		//城市
		if( isset($arrData['cityId']) )
		{
			$arrInsert['cityId'] = $arrData['cityId'];
		}
		//门店名称
		if( isset($arrData['name']) )
		{
			$arrInsert['name'] = $arrData['name'];
		}
		//门店简称
		if( isset($arrData['abbr']) )
		{
			$arrInsert['abbr'] = $arrData['abbr'];
		}
		//备注
		if( isset($arrData['remark']) )
		{
			$arrInsert['remark'] = $arrData['remark'];
		}
		//账户
		if( isset($arrData['accname']) )
		{
			$arrInsert['accname'] = $arrData['accname'];
		}
		//地址
		if( isset($arrData['address']) )
		{
			$arrInsert['addrss'] = $arrData['address'];
		}
		//邮编
		if( isset($arrData['postcode']) )
		{
			$arrInsert['postcode'] = $arrData['postcode'];
		}
		//电话
		if( isset($arrData['tel']) )
		{
			$arrInsert['tel'] = $arrData['tel'];
		}
		//传真
		if( isset($arrData['fax']) )
		{
			$arrInsert['fax'] = $arrData['fax'];
		}
		//X坐标
		if( isset($arrData['x']) )
		{
			$arrInsert['x'] = $arrData['x'];
		}
		//Y坐标
		if( isset($arrData['y']) )
		{
			$arrInsert['y'] = $arrData['y'];
		}
		//经纬度
		if( isset($arrData['lonLat']) )
		{
			$arrInsert['lonLat'] = $arrData['lonLat'];
		}
		//Logo编号
		if( isset($arrData['logoId']) )
		{
			$arrInsert['logoId'] = $arrData['logoId'];
		}
		//Logo扩展
		if( isset($arrData['logoExt']) )
		{
			$arrInsert['logoExt'] = $arrData['logoExt'];
		}
		//销售编号
		if( isset($arrData['salesId']) )
		{
			$arrInsert['salesId'] = $arrData['salesId'];
		}
		//客服Id
		if( isset($arrData['cSId']) )
		{
			$arrInsert['cSId'] = $arrData['cSId'];
		}
		//管理经纪人
		if( isset($arrData['isAdmin']) )
		{
			$arrInsert['isAdmin'] = $arrData['isAdmin'];
		}
		$arrInsert['status'] = self::STATUS_VALID;

		try
		{
			if(self::create($arrInsert))
				return $this->insertId();
			else
				return false;
		}
		catch (Exception $ex)
		{
			return false;
		}
	}

	/**
	 * 修改门店信息
	 * @param array $conditionShop 门店条件
	 * @param array $dataShop 要修改的门店数据
	 * @param array $conditionEnterprise 企业帐号条件
	 * @param array $dataEnterprise 企业帐号数据
	 * @return false or true
	 */
	public function tcUpdate($conditionShop, $dataShop,$conditionEnterprise = array(),$dataEnterprise=array())
	{
		if( !is_array($conditionShop) || !is_array($dataShop) || !is_array($conditionEnterprise) || !is_array($dataEnterprise) ){
			$this->error('参数错误');
			return false;
		}
		$this->begin(); //事务开始

		$returnUpdateShop = $this->updateAll(" shopId = ".$conditionShop['id'], $dataShop);
		if( false !== $returnUpdateShop)
		{
			if( !empty($conditionEnterprise) && !empty($dataShop) )
			{//判断是否需要修改企业帐号信息
				$objVipAccount = new VipAccount();
				$where = " vaTo = ".$conditionEnterprise['to']." and vaToId = ".$conditionEnterprise['toId'];
				if(isset($conditionEnterprise['name']))
				{
					$where .= " and vaName = '".$conditionEnterprise['name']."'";
				}
				$returnUpdateEnterprise = $objVipAccount->updateAll($where, $dataEnterprise);
				if( false !== $returnUpdateEnterprise){
					$this->commit();//确认
					$this->error('门店信息修改成功');
					return true;
				}else{
					$this->rollback();//回滚
					$this->error('企业账户修改失败');
					return false;
				}
			}else{
				$this->commit();//确认
				$this->error('门店信息修改成功');
				return true;
			}
		}else{
			$this->rollback();//回滚
			$this->error('门店信息修改失败');
			return false;
		}
				}

	/**
	 * 删除门店
	 * @param $condition =array(id=>1,accname=>'asd')
	 * @return false or true;
	 */
	public function tcDelete($condition) {
		if(!is_array($condition)){
			$this -> error('传参错误');
			return false;
		}
		//逻辑删除-删除经纪人在删除门店信在息删除企业账户
		//删除经纪人
		$objRealtor = new Realtor();
		$arrRealtor = $objRealtor->getAll(" shopId = ".$condition['id'],'','','','');
        $arr['realStatus'] = $objRealtor::STATUS_DELETE;
		if(!empty($arrRealtor)){
			foreach($arrRealtor as $Realtor){
				$real = $objRealtor->updateAll(" realId =".$Realtor['id']." and shopId = ".$condition['id'], $arr);
				if(false === $real){
					$this -> error("{$Realtor['name']}经纪人删除失败");
					return false;
				}
			}
		}

		$returnDeleShop = $this->tcUpdate(array('id'=>$condition['id']), array('shopStatus'=>self::STATUS_DELETE/*,'deltime'=>time()*/),array('toId'=>$condition['id'],'to'=>VipAccount::ROLE_SHOP,'name'=>$condition['accname']),array('vaStatus'=>VipAccount::STATUS_DELETE/*,'deltime'=>time()*/));
		if( false !== $returnDeleShop ){
			$this -> error("删除门店信息成功");
			return true;
		}else{
			$this -> error("删除门店信息失败");
			return false;
		}
	}

	/**
	 * 根据经纪公司id获得区域信息
	 * @param int $intCompanyId
	 * @return false or array;;
	 */
	public function getAreaByCompanyID($intCompanyId){
		if( 0 > intval($intCompanyId) ){
			$this->error('传参错误');
			return false;
		}
		$condition[] = 'comId='.$intCompanyId;
		$condition[] = 'status='.Area::STATUS_OK;
		$objArea = new Area();
		$arrArea = $objArea->getAll($condition,"","","","");
		$objArea = null;
		if(	false === $arrArea ){
			$this->error('没有获得城区信息');
			return false;
		}else{
			$this->error('成功');
			return $arrArea;
		}
	}

	/**
	 * 验证修改门店资料信息
	 *
	 * @param array $data 提交的信息
	 * @return bool 成功返回true，失败返回false
	 */
	public function checkShopData( $data = array() )
	{
		if( empty($data['distId']))
		{
			$this->setError("请选择城区");
			return false;
		}
		if( empty($data['regId']))
		{
			$this->setError("请选择板块");
			return false;
		}
		if( !empty($data['tel']) && !preg_match("/^[0-9]{8}$/",$data['tel']) ){
			$this->setError("电话格式不对");
			return false;

		}
		if( !empty($data['fax']) && !preg_match("/^[0-9]{8}$/",$data['fax']) ){
			$this->setError("传真格式不对");
			return false;
		}
		return true;
	}

	/**
	 * 门店数组id键值，name为值一维数组
	 *
	 * @return
	 */
	public function getShopForOption($where)
	{
		$newArr = array();
		$arrShop = $this->getAll($where,'','','','id, name');
		if(is_array($arrShop))
		{
			foreach ($arrShop as $key=>$val)
			{
				$newArr[$val['id']] = $val['name'];
			}
		}

		return $newArr;
	}
    
    /**
     * 门店转移
     * @param int|array $shopIds
     * @param int       $saleId
     * @param int       $userId
     * @param string    $userName
     * @param int       $cityId
     * @return boolean
     */
    public function tranferShop($shopIds, $saleId, $userId, $userName, $cityId) 
    {
        if(empty($shopIds)) 
        {
            return false;
        }
        $beforeSales = Crmallocation::instance()->getAllocationByToIds(Crmallocation::SHOP, $shopIds, 'typeId,toId1');
        //开启事务
        $this->begin();
        //门店进行销售转移
        foreach((array)$shopIds as $shopId)
        {
            $shopRes = Crmallocation::instance()->addAllocation(Crmallocation::SHOP, $shopId, $saleId);
            if(!$shopRes)
            {
                $this->rollback();
                return false;
            }
            //门店下面的经纪人进行销售转移
            $realtors = Realtor::find("shopId={$shopId} and status<>".Realtor::STATUS_DELETE);
            if(!$realtors)
            {
                continue;
            }
            foreach($realtors as $realtor)
            {
                $realtorRes = Crmallocation::instance()->addAllocation(Crmallocation::REALTOR, $realtor->id, $saleId);
                if(!$realtorRes)
                {
                    $this->rollback();
                    return false;
                }
            }
        }
        $this->commit();
        
        //写log日志
        $shopList = $this->getShopByIds($shopIds, 'id,name');
        $saleList = AdminUser::instance()->getUserForSearch($cityId);;
        $data = array();
        foreach($shopList as $id=>$v) 
        {
            $value = array();
            $value['userId'] = $userId;
            $value['userName'] = $userName;
            $value['shopId'] = $id;
            $value['shopName'] = $v['name'];
            $value['toSaleId'] = $saleId;
            $value['fromUserId'] = $beforeSales[$id]['toId1'];                 
            $value['modifyStr'] .= $beforeSales[$id]['toId1'] ? $saleList[$beforeSales[$id]['toId1']] : '';
            $value['modifyStr'] .= '→';
            $value['modifyStr'] .= $saleId ? $saleList[$saleId] : '';
            $value['time'] = date('Y-m-d H:i:s');
            $value['type'] = 1;
            $data[] = $value;
            unset($value);
        }
        CrmUserLogs::instance()->addTranferShopLogs($data);
            
        return true;
    }   
    
    /**
     * 获取门店端口数
     * @param array $shopIds
     * @return array
     */
    public function getPortNumByShopId($shopIds)
    {
        if(empty($shopIds))
        {
            return array();
        }
        $where = "status=".RealtorPort::STATUS_ENABLED." and shopId in(".  implode(',', $shopIds).")";
        $condition = array(
            'conditions' => $where,
            'columns'    => 'shopId,portId,count(*) as num',
            'group'      => array('shopId','portId')
        );
        $portInfo = RealtorPort::find($condition, 0)->toArray();
        $data = $pcIds = array();
        foreach($portInfo as $v)
        {
            $data[$v['shopId']][$v['portId']] = intval($v['num']);
            in_array($v['portId'], $pcIds) || $pcIds[] = $v['portId'];
        }
        if(!empty($data))
        {
            $ports = PortCity::instance()->getPortsByIds($pcIds, 'id,type,equivalent');
            foreach($data as $shopId=>$value)
            {
                foreach($value as $pcId=>$num)
                {
                    if(empty($ports[$pcId]))
                    {
                        continue;
                    }
                    $port = $ports[$pcId];
                    if(PortCity::STATUS_Sale == $port['type'])
                    {
                        $data[$shopId]['saleNum'] += $port['equivalent'] * $num;
                    }
                    elseif(PortCity::STATUS_Rent == $port['type'])
                    {
                        $data[$shopId]['rentNum'] += $port['equivalent'] * $num;
                    }
                    unset($data[$shopId][$pcId]);
                }
            }
        }
        
        return $data;
    }
    
    /**
     * 取门店数据，主要针对没有销售、客服情况
     * @param array   $condition
     * @param boolean $noSale
     * @param boolean $noCS
     * @param int     $offset
     * @param int     $size
     * @return array
     */
    public function getShopByCondition($condition, $noSale, $noCS, $offset = 0, $size = 15)
    {
        $columnsMap = $this->columnMap();
        $data = array();
        
        if(!$noCS && !$noSale)
        {          
            $wheres = array();
            foreach($condition as $column=>$value)
            {
                foreach($value as $flag=>$v)
                {
                    $wheres[] = "{$columnsMap[$column]} {$flag} {$v}";
                }
            }
            $where = implode(' and ', $wheres);
            $totalNum = self::count($where);
            $shopCondition = array(
                'conditions' => $where,
                'order'      => 'id desc',
            );
            $size > 0 && $shopCondition['limit'] = array('offset'=>$offset, 'number'=>$size);
            $res = self::find($shopCondition, 0)->toArray();  
            foreach($res as $v)
            {
                $data[$v['id']] = $v;
            }
        }
        else
        {
            $table = $this->getSource();
            $wheres = array();
            foreach($condition as $column=>$value)
            {
                foreach($value as $flag=>$v)
                {
                    $wheres[] = "{$column} {$flag} {$v}";
                }
            }
            $shopWhere = implode(' and ', $wheres);
            $allocationWhere = "caType=".  Crmallocation::SHOP." and caStatus=".  Crmallocation::STATUS_VALID;
            if($noCS && $noSale)
            {
                $allocationWhere .= " and (caToId1>0 or caToId2>0)";
            }
            else
            {
                $allocationWhere .= $noSale ? " and caToId1>0" : " and caToId2>0";
            }
                
            $baseSql = "(SELECT * FROM {$table} WHERE {$shopWhere}) as a
                    LEFT JOIN
                        (SELECT caTypeId FROM crm_allocation WHERE {$allocationWhere} GROUP BY caTypeId) as b
                    ON a.shopId=b.caTypeId WHERE b.caTypeId is null
                    ORDER BY a.shopId DESC";  
            $sql = "SELECT b.caTypeId,a.* FROM ".$baseSql;
            $sql .= $size > 0 ? " LIMIT {$offset},{$size}" : "";
            $res = $this->fetchAll($sql);
            foreach($res as $value)
            {
                $id = $value['shopId'];
                foreach($value as $column=>$v)
                {
                    $data[$id][$columnsMap[$column]] = $v;
                }
            }
            $countSql = "SELECT count(*) as num FROM ".$baseSql;
            $totalNum = $this->fetchOne($countSql);
            $totalNum = $totalNum['num'];
        }
        
        return array('list'=>$data, 'totalNum'=>intval($totalNum));
    }
    /*
     * 门店转移
     * @param $shopId int 门店id
     * @param $areaId int 区域id
     * */
    public function moveShop($shopId, $areaId){
        if(!$shopId || !$areaId ) return array("status"=>false,"info"=>"参数错误！");
        $this->begin();
        $rs = $this->findFirst($shopId);
        $rs -> areaId = $areaId;
        //更新shop表
        if(!$rs->update()){
            return array("status"=>false,"info"=>"更新门店表出错！");
            $this->rollback();
        };
        //更新realtor表
        $rs = Realtor::instance()->updateAll(" shopId = ".$shopId, array("areaId"=>$areaId));
        if(!$rs){
            return array("status"=>false,"info"=>"更新经纪人表出错！");
            $this->rollback();
        }
        //更新refresh_log表
        $rs = RefreshLog::instance()->updateAll(" shopId = ".$shopId, array("areaId"=>$areaId));
        if(!$rs){
            return array("status"=>false,"info"=>"更新刷新表出错！");
            $this->rollback();
        }
        //更新realtor_port表
        $rs = RealtorPort::instance()->updateAll(" shopId = ".$shopId, array("areaId"=>$areaId));
        if(!$rs){
            return array("status"=>false,"info"=>"更新经纪人端口表出错！");
            $this->rollback();
        }
        //更新order表
        $rs = Orders::instance()->updateAll(" shopId = ".$shopId, array("areaId"=>$areaId));
        if(!$rs){
            return array("status"=>false,"info"=>"更新经纪人端口表出错！");
            $this->rollback();
        }
        $this->commit();
        return array("status"=>true,"info"=>"转移成功！");
    }
    
    /**
     * 修改门店客服
     * @param int|array $shopIds
     * @param int       $saleId
     * @param int       $userId
     * @param string    $userName
     * @param int       $cityId
     * @return boolean
     */
    public function modifyShopCSId($shopIds, $CSId, $userId, $userName, $cityId) 
    {
        if(empty($shopIds)) 
        {
            return false;
        }
        $beforeCSs = Crmallocation::instance()->getAllocationByToIds(Crmallocation::SHOP, $shopIds, 'typeId,toId2');
        //开启事务
        $this->begin();
        //门店进行销售转移
        foreach((array)$shopIds as $shopId)
        {
            $shopRes = Crmallocation::instance()->addAllocation(Crmallocation::SHOP, $shopId, false, $CSId);
            if(!$shopRes)
            {
                $this->rollback();
                return false;
            }
            //门店下面的经纪人进行销售转移
            $realtors = Realtor::find("shopId={$shopId} and status<>".Realtor::STATUS_DELETE);
            if(!$realtors)
            {
                continue;
            }
            foreach($realtors as $realtor)
            {
                $realtorRes = Crmallocation::instance()->addAllocation(Crmallocation::REALTOR, $realtor->id, false, $CSId);
                if(!$realtorRes)
                {
                    $this->rollback();
                    return false;
                }
            }
        }
        $this->commit();
        
        //写log日志
        $shopList = $this->getShopByIds($shopIds, 'id,name');
        $saleList = AdminUser::instance()->getOptions(AdminUser::ROLE_CS, array(), $cityId);

        $data = array();
        foreach($shopList as $id=>$v) 
        {
            $value = array();
            $value['userId'] = $userId;
            $value['userName'] = $userName;
            $value['shopId'] = $id;
            $value['shopName'] = $v['name'];
            $value['toCSId'] = $CSId;
            $value['fromUserId'] = $beforeCSs[$id]['toId2'];                 
            $value['modifyStr'] .= $beforeCSs[$id]['toId2'] ? $saleList[$beforeCSs[$id]['toId2']] : '';
            $value['modifyStr'] .= '→';
            $value['modifyStr'] .= $CSId ? $saleList[$CSId] : '';
            $value['time'] = date('Y-m-d H:i:s');
            $value['type'] = 1;
            $data[] = $value;
            unset($value);
        }
        AdminModifyCsLogs::instance()->addModifyShopCSLogs($data);
            
        return true;
    }  
}
