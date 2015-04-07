<?php
class Realtor extends BaseModel
{
    /**
     * 经纪人状态
     * 1.停用 -1.删除    3.启用    4.未认证   5.待认证   6.未通过认证 7.休眠 8.免费体验
     * 对应DB字段 broker_status
     */
    const STATUS_STOP = 1;
    const STATUS_DELETE = -1;
    const STATUS_OPEN = 3;
    const STATUS_VERIFY_NO = 4;
    const STATUS_VERIFY_WAIT = 5;
    const STATUS_VERIFY_FALSE = 6;
    const STATUS_SLEEP = 7;
    const STATUS_FREE = 8;

    //新的经纪人状态
    //新的经纪人状态
    const NEW_STATUS_REG      = 1;    //注册
    const NEW_STATUS_WAIT     = 2;    //待审
    const NEW_STATUS_PASS     = 3;    //过审(已通过认证，但当前无在线房源，且非免费、付费或休眠状)
    const NEW_STATUS_FREE     = 4;    //免费(当前已有在线房源，但未开通端口)
    const NEW_STATUS_PAY      = 5;    //付费
    const NEW_STATUS_SLEEP    = 6;    //休眠
    const NEW_STATUS_DEL      = 7;    //删除

    //经纪人固定电话是否优先级显示手机号
    const REALTOR_PHONE_SHOW = 2;
    const REALTOR_PHONE_DEFAULT_HIDE = 1;
    /**
     * 经纪人类型
     * 1.企业经纪人  2.独立经纪人
     * 对应DB字段 broker_type
     */
    const TYPE_COMPANY = 1;
    const TYPE_ALONE = 2;

    //经纪人固定电话是否优先级显示手机号
    const REALTOR_MOBILE_SHOW = 2;
    const REALTOR_MOBILE_DEFAULT_HIDE = 1;

    //是否是预约经纪人
    const IS_NO_ORDER = 0;  //没有预约
    const IS_ORDER    = 1;  //有预约

    //拒绝理由 常量定义  realtorExt表 deny_id字段 存储
    const DENY_PHOTO_CONTENT_NOT_MATCH = 1;
    const DENY_PHOTO_NOT_MATCH = 2;
    const DENY_CONTENT_NOT_MATCH = 3;

    //区分过审和免费的界限数字
    const FREE_HOUSE_NUM = 0;

    //企业经纪人认证状态
    const CERTI_NO = 0;
    const CERTI_WAIT = 1;
    const CERTI_YES = 2;
    const CERTI_NOT = 3;

    //到期提醒时间值 days
    const WARN_DATE = 3;

    //构造端口状态数组常量 全部状态
    const PORT_STA_ALL = 4;

    //是否优质经纪人
    const IS_GOOD = 1;     //是
    const IS_NOT_GOOD = 0; //不是

    protected $error;

    public $id;
    public $areaId;
    public $shopId = 0;
    public $comId;
    public $regId;
    public $distId;
    public $cityId;
    public $name;
    public $email = '';
    public $gender = 0;
    public $dOB = '';
    public $idCard = '';
    public $mobile = '';
    public $tel = '';
    public $telExt = '';
    public $weixin = '';
    public $qQ = '';
    public $logoId = 0;
    public $logoExt = '';
    public $score = 0;
    public $rank = 0;
    public $validation = 0;
    public $denyId = 0;
    public $status = 0;
    public $update;
    public $type;
    public $shopInfo;
    public $defaultTel;
    public $create;
    public $passport = '';
    public $desc = '';
    public $isOrder = self::IS_NO_ORDER;
    public $isGood = 0;
    public $certification = 0;
    public $sort = 0;
    public $code = '';

	//以下是额外绑定的非数据库字段
    public $accId;
    public $accName;
    public $opSaleRelease;
    public $opSaleRefresh;
    public $opSaleBold;
    public $opSaleTags;
    public $opSaleTagsExtra;
    public $opRentRelease;
    public $opRentRefresh;
    public $opRentBold;
    public $opRentTags;
    public $opRentTagsExtra;
    public $opStartDate;
    public $opExpiryDate;


    public function getId()
    {
        return $this->id;
    }

    public function setId($realId)
    {
        if(preg_match('/^\d{1,10}$/', $realId == 0) || $realId > 4294967295)
        {
            return false;
        }
        $this->id = $realId;
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

    public function getRealName()
    {
        return $this->name;
    }

    public function setRealName($realName)
    {
        if($realName == '' || mb_strlen($realName, 'utf8') > 10)
        {
            return false;
        }
        $this->name = $realName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        if($email == '' || mb_strlen($email, 'utf8') > 10)
        {
            return false;
        }
        $this->email = $email;
    }

    public function getRealGender()
    {
        return $this->gender;
    }

    public function setRealGender($realGender)
    {
        if(preg_match('/^\d{1,3}$/', $realGender == 0) || $realGender > 255)
        {
            return false;
        }
        $this->gender = $realGender;
    }

    public function getRealDOB()
    {
        return $this->dOB;
    }

    public function setRealDOB($realDOB)
    {
        if($realDOB == '' || mb_strlen($realDOB, 'utf8') > 10)
        {
            return false;
        }
        $this->dOB = $realDOB;
    }

    public function getRealIdCard()
    {
        return $this->idCard;
    }

    public function setRealIdCard($realIdCard)
    {
        if($realIdCard == '' || mb_strlen($realIdCard, 'utf8') > 20)
        {
            return false;
        }
        $this->idCard = $realIdCard;
    }

    public function getRealMobile()
    {
        return $this->mobile;
    }

    public function setRealMobile($realMobile)
    {
        if($realMobile == '' || mb_strlen($realMobile, 'utf8') > 15)
        {
            return false;
        }
        $this->mobile = $realMobile;
    }

    public function getRealTel()
    {
        return $this->tel;
    }

    public function setRealTel($realTel)
    {
        if($realTel == '' || mb_strlen($realTel, 'utf8') > 15)
        {
            return false;
        }
        $this->tel = $realTel;
    }

    public function getRealWeixin()
    {
        return $this->weixin;
    }

    public function setRealWeixin($realWeixin)
    {
        if($realWeixin == '' || mb_strlen($realWeixin, 'utf8') > 30)
        {
            return false;
        }
        $this->weixin = $realWeixin;
    }

    public function getRealQQ()
    {
        return $this->qQ;
    }

    public function setRealQQ($realQQ)
    {
        if($realQQ == '' || mb_strlen($realQQ, 'utf8') > 15)
        {
            return false;
        }
        $this->qQ = $realQQ;
    }

    public function getLogoId()
    {
        return $this->logoId;
    }

    public function setLogoId($logoId)
    {
        if(preg_match('/^\d{1,10}$/', $logoId == 0) || $logoId > 4294967295)
        {
            return false;
        }
        $this->logoId = $logoId;
    }

    public function getLogoExt()
    {
        return $this->logoExt;
    }

    public function setLogoExt($logoExt)
    {
        if($logoExt == '' || mb_strlen($logoExt, 'utf8') > 4)
        {
            return false;
        }
        $this->logoExt = $logoExt;
    }

    public function getRealScore()
    {
        return $this->score;
    }

    public function setRealScore($realScore)
    {
        if(preg_match('/^\d{1,10}$/', $realScore == 0) || $realScore > 4294967295)
        {
            return false;
        }
        $this->score = $realScore;
    }

    public function getRealRank()
    {
        return $this->rank;
    }

    public function setRealRank($realRank)
    {
        if(preg_match('/^\d{1,10}$/', $realRank == 0) || $realRank > 4294967295)
        {
            return false;
        }
        $this->rank = $realRank;
    }

    public function getRealValidation()
    {
        return $this->validation;
    }

    public function setRealValidation($realValidation)
    {
        if(preg_match('/^-?\d{1,3}$/', $realValidation) == 0 || $realValidation > 127 || $realValidation < -128)
        {
            return false;
        }
        $this->validation = $realValidation;
    }

    public function getRealStatus()
    {
        return $this->status;
    }

    public function setRealStatus($realStatus)
    {
        if(preg_match('/^-?\d{1,3}$/', $realStatus) == 0 || $realStatus > 127 || $realStatus < -128)
        {
            return false;
        }
        $this->status = $realStatus;
    }

    public function getRealUpdate()
    {
        return $this->update;
    }

    public function setRealUpdate($realUpdate)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $realUpdate) == 0 || strtotime($realUpdate) == false)
        {
            return false;
        }
        $this->update = $realUpdate;
    }

    public function getRealType()
    {
        return $this->type;
    }

    public function setRealType($realType)
    {
        $this->type = $realType;
    }

    public function getSource()
    {
        return 'realtor';
    }

    public function columnMap()
    {
        return array(
            'realId'         => 'id',
            'areaId'         => 'areaId',
            'shopId'         => 'shopId',
            'comId'          => 'comId',
            'regId'          => 'regId',
            'distId'         => 'distId',
            'cityId'         => 'cityId',
            'realName'       => 'name',
        	'realEmail'	     => 'email',
            'realGender'     => 'gender',
            'realDOB'        => 'dOB',
            'realIdCard'     => 'idCard',
            'realMobile'     => 'mobile',
            'realTel'        => 'tel',
        	'realTelExt'	 => 'telExt',
            'realWeixin'     => 'weixin',
            'realQQ'         => 'qQ',
            'realLogoId'     => 'logoId',
            'realLogoExt'    => 'logoExt',
            'realScore'      => 'score',
            'realRank'       => 'rank',
            'realValidation' => 'validation',
            'realDenyId'     => 'denyId',
        	'realCertification' => 'certification',
            'realStatus'     => 'status',
        	'realCreate' => 'create',
            'realUpdate'     => 'update',
            'realType'       => 'type',
        	'realLogoId'	 => 'logoId',
        	'realLogoExt' 	 => 'logoExt',
            'realDefaultTel' =>  'defaultTel',
        	'realTelExt'     => 'telExt',
        	'realCreate'     => 'create',
        	'realPassport'   => 'passport',
        	'realDesc'       => 'desc',
            'realIsOrder'    => 'isOrder',
            'realIsGood'    => 'isGood',
            'realCertification'=>'certification',
        	'realSort'	=> 'sort',
        	'realCode'	=> 'code'
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
     * @return Realtor_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }

    /**
     * 根据经纪人id，获取指定经纪人的信息
     *
     * @param int $realId
     * @return object
     */
    public function getRealtorById($realId) {
        if ( empty($realId) ) {
            return false;
        }
        $arrCond  = "id = ?1";
        $arrParam = array(1 => $realId);
        $arrRes   = self::findFirst(array(
            $arrCond,
            "bind" => $arrParam
        ));
        return $arrRes;
    }


    //根据条件获取经纪人信息
    public function getRealInfoByCondition($param,$otherInfoFlag=1){
        $realtorInfo =  self::find($param,0)->toArray();
        if (!$realtorInfo) return array();
        foreach ($realtorInfo as &$value){
//            $mRealtorAttach = new RealtorAttach();
//            $attachInfo = $mRealtorAttach::findFirst(
//                array(
//                    "id=?1",
//                    'bind'=>array(
//                        1   =>  $value['id']
//                    )
//                ),0
//            )->toArray();
//            if ($attachInfo){
//                $value['imgId'] = $attachInfo['imgId'];
//                $value['imgExt'] = $attachInfo['imgExt'];
//                $value['realtorImgUrl'] = ImageUtility::getImgUrl("esf", $attachInfo['imgId'], $attachInfo['imgExt'],180,120);
//            }
            if ($value['comId']){
                $mCompany = new Company();
                $companyInfo = $mCompany->findFirst(
                    array(
                        'id=?1',
                        'bind'  =>  array(
                            1   =>  $value['comId'],
                        )
                    ),0
                )->toArray();
                if ($companyInfo) $value['comName'] = $companyInfo['name'];
            }
            if ($value['shopId']){
                $mShop = new Shop();
                $shopInfo = $mShop->findFirst(
                    array(
                        'id=?1',
                        'bind'  =>  array(
                            1   =>  $value['shopId'],
                        )
                    ),0
                )->toArray();
                if ($shopInfo) $value['shopName'] = $shopInfo['name'];
            }
        }
        unset($value);
        return $realtorInfo;
    }

	/**
	 * 根据手机号获得经纪人信息
	 * @param int $intMobile
	 * @return Ambigous <multitype:, 成功返回数组，失败返回false, false, boolean, unknown>
	 */
	public function getRealtorByMobile($intMobile){
		$objRealtor = self::findFirst(array("mobile = ".$intMobile." AND status != ".Realtor::STATUS_DELETE));
		return empty($objRealtor) ? null : $objRealtor;
	}

	/**
	 * 判断手机号是否已经被注册过
	 * @param int $intMobile
	 */
	public function checkMobileHasRegistered($intMobile){
		$objRealtor = $this->getRealtorByMobile($intMobile);
		if(empty($objRealtor)){
			return true;
		}
		return false;
	}

	/**
	 * 注册经纪人
	 * @param array $postArr
	 */
	public function regRealtor($postArr){
		//事务处理
		$this->begin();
		//插入表realtor数据
		$postArr['type'] = self::TYPE_COMPANY;
		$postArr['status'] = self::STATUS_STOP;
		$realId = $this->creatRealtorFromAPP($postArr);
		if($realId)
		{
			//插入表vip_account数据
			$arrAddAcc = array();
			$arrAddAcc['name'] = $postArr['accname'];
			$arrAddAcc['password'] = sha1(md5($postArr['password']));
			$arrAddAcc['toId'] = $realId;
			$arrAddAcc['to'] = VipAccount::ROLE_REALTOR;//经纪人
			$arrAddAcc['status'] = VipAccount::STATUS_VALID;//经纪人状态
			$clsVipAccount = new VipAccount();
			if($clsVipAccount->creatVipAccount($arrAddAcc['name'],$arrAddAcc['password'],$arrAddAcc['toId'],$arrAddAcc['to'],$arrAddAcc['status']))
			{
				$this->commit();
				return $realId;//返回经纪人ID
			}
			else
			{
				//注册失败
				$this->rollback();
				return false;
			}
		}
		else
		{
			//注册失败
			$this->rollback();
			return false;
		}
	}

	/**
	 * 经纪人入库
	 * @param array $data
	 * @return boolean|Ambigous <成功返回lastInsertId，失败返回false, number, boolean>
	 */
	public function creatRealtorFromAPP($data){
		//初始化入库数据
		$data['update'] = date('Y-m-d H:i:s', time());
		//创建经纪人信息
		$this->create($data);
		$intInsertId = $this->insertId();

		if ( $intInsertId <= 0 ) {
			return false;
		}
		return $intInsertId;
	}

    /**
     * 根据条件，获取指定经纪人的信息
     * @auth jackchen
     * @param array $arr
     * @return object
     */
    public function getRealtorByCondition($arr) {
        if ( !is_array($arr) || count($arr) <= 0) {
            return false;
        }
        $startNum =1;
        $condStr = '';
        foreach($arr as $key=>$val)
        {
            $condStr .= $key.' = ?'.$startNum.' AND ';
            $arrParam[$startNum] = $val;
            $startNum++;
        }

        if(!empty($condStr))
        {
            $condStr = substr($condStr,0,-4);
        }

        $arrRes   = self::findFirst(array(
            $condStr,
            "bind" => $arrParam
        ),0);
        return $arrRes;

    }

    /**
     * 经纪人找回密码第一步时的验证
     * @auth jackchen
     * @param array $arr
     * @return bool
     */
    public function checkTelRet($arr){
        if(empty($arr['broker_accname'])){
            self::setError('账号不能为空');
            return false;
        }
        if(empty($arr['telephone'])){
            self::setError('手机号不能为空');
            return false;
        }

        if(!preg_match("/^[1][3|4|5|8]\d{9}$/",$arr['telephone']))
        {
            self::setError('您输入的手机号码格式有误！');
            return false;
        }

        //判断账号是否存在
        $objvip = new VipAccount();
        $arraccount  = $objvip->getAccountByStatus($arr['broker_accname'],VipAccount::STATUS_VALID)->toArray();
        if(count($arraccount) == 0){
            self::setError('您输入的账号有误！');
            return false;
        }


        //判断手机号是否匹配
        $condition2['id'] = $arraccount['toId'];
        $condition2['mobile'] = $arr['telephone'];
        //$condition2['status'] = Realtor::STATUS_OPEN;
        $arrRealtor = self::getRealtorByCondition($condition2)->toArray();

        if(count($arrRealtor) == 0){
            self::setError('账号和手机号不匹配！');
            return false;
        }

        return true;
    }

    public function getError()
    {
        return $this->error;
    }

    public function setError($strError)
    {
        $this->error = $strError;
    }

     /**
     * 删除单条记录
     *
     * @param int $realtorId
     * @return boolean
     */
    public function del($realtorId)
    {
        $rs = self::findFirst("id=".$realtorId);
        if(!$rs)
        {
            return array('status'=>1, 'info'=>'经纪人不存在！');
        }
        if(self::STATUS_OPEN == $rs->status)
        {
            return array('status'=>1, 'info'=>'开启用户禁止删除！');
        }
        $this->begin();
        $rs->status = self::STATUS_DELETE;
        if($rs->update())
        {
            //删除账号
            $account = VipAccount::findFirst("toId={$realtorId} and to=".VipAccount::ROLE_REALTOR);
            if($account)
            {
                $account->status = VipAccount::STATUS_DELETE;
                if(!$account->update())
                {
                    $this->rollback();
                    return array('status'=>1, 'info'=>'删除失败！');
                }
            }
            //删除房源
            $delHouseRes = House::instance()->delHouseByRealId($realtorId);
            if($delHouseRes)
            {
                $realExt = RealtorExt::instance();
                $realExt->alId = $realtorId;
                $realExt->name = 'deltime';
                $realExt->value = date('Y-m-d H:i:s');
                $realExt->status = RealtorExt::STATUS_VALID;
                $realExt->update = date('Y-m-d H:i:s');
                
                $createRes = $realExt->create();
                
                $this->commit();
                return array('status'=>0, 'info'=>'删除成功！');
            }
            else
            {
                $this->rollback();
                return array('status'=>1, 'info'=>'删除失败！');
            }
        }

        $this->rollback();
        return array('status'=>1, 'info'=>'删除失败！');
    }

    /**
     * 根据经纪人Id获取经纪人相关信息
     */
    public function getRealtorAllInfo($realId)
    {
    	if ( !is_numeric($realId) || intval($realId)<=0 )
    	{
    		$this->error = '参数错误';
    		exit;
    	}
    	//经纪人基本信息
    	$arrRealtorInfo = self::getOne(" id = {$realId}");
    	//经纪人头像
    	$arrRealtorInfo['photo_url'] = $arrRealtorInfo['logo'] = ImageUtility::getImgUrl("esf", $arrRealtorInfo['logoId'], $arrRealtorInfo['logoExt'], 180, 120);

    	//获取经纪人账户信息
    	$objAcc = new VipAccount();
    	$arrAcc = $objAcc->getAccountByToId($objAcc::ROLE_REALTOR, $realId);
    	if ( empty($arrAcc) ) {
    		$this->error = '无数据';
    		return false;
    	}
		$arrAcc = $arrAcc->toArray();

		//获取经纪人总积分
		$arrRealtorInfo['score'] = $arrAcc['totalIntegral'];

    	//获取经纪人端口数量
    	$objRealtorPort = new RealtorPort();
    	$arrRes = $objRealtorPort->getAccountByRealId($realId);
		$arrRes = empty($arrRes) ? array() : $arrRes->toArray();
        if(!empty($arrRes))
        {
	    	//到期时间
	    	$arrRealtorInfo['opExpiryDate'] = $arrRes['expiryDate'];
	    	if(!empty($arrRealtorInfo['opExpiryDate']))
	    	{
	    		$arrRealtorInfo['is_expired'] = (strtotime($arrRealtorInfo['opExpiryDate'])-strtotime(date("Y-m-d")))/86400;
	    		$arrRealtorInfo['is_expired'] = $arrRealtorInfo['is_expired'] < 0 ? 0 : $arrRealtorInfo['is_expired'];
	    	}
	    	else
	    	{
	    		$arrRealtorInfo['is_expired'] = 0;
	    	}
	        $arrRealtorInfo['portId'] = empty($arrRes['portId']) ? '' : $arrRes['portId'];
        }
        try
        {
        	if(!empty($arrRes['portId']))
        	{
		        //获取经纪人端口类型
		        $objPortCity = new PortCity();
		        $arrPort = $objPortCity->getOne(" id = ".$arrRes['portId']);
		        $arrRealtorInfo['pcType'] = empty($arrPort['type']) ? '' : $arrPort['type'];

		        $arrRealtorInfo['opNum'] = !empty($arrPort['equivalent']) ?$arrRes['num']*$arrPort['equivalent']:0;
		    	//经纪人对应的端口数量等等
		    	//$arrRealtorInfo['opNum'] = empty($arrRes['num']) ? 0 : $arrRes['num'];
		    	$arrRealtorInfo['opSaleRelease'] = $arrRes['saleRelease'];
		    	$arrRealtorInfo['opSaleRefresh'] = $arrRes['saleRefresh'];
		    	$arrRealtorInfo['opSaleBold'] = $arrRes['saleBold'];
		    	$arrRealtorInfo['opSaleTags'] = $arrRes['saleTags'];
		    	$arrRealtorInfo['opSaleTagsExtra'] = $arrRes['saleTagsExtra'];
		    	$arrRealtorInfo['opRentRelease'] = $arrRes['rentRelease'];
		    	$arrRealtorInfo['opRentRefresh'] = $arrRes['rentRefresh'];
		    	$arrRealtorInfo['opRentBold'] = $arrRes['rentBold'];
		    	$arrRealtorInfo['opRentTags'] = $arrRes['rentTags'];
		    	$arrRealtorInfo['opRentTagsExtra'] = $arrRes['rentTagsExtra'];
        	} else {
		    	$arrRealtorInfo['opNum'] = $arrRealtorInfo['is_expired'] = 0;
			}
	    	$objRealtorExt = new RealtorExt();

	    	$arrRealtorExt = $objRealtorExt->getAll(" alId = {$realId}");
    	}
    	catch(Exception $e)
    	{
    	}

    	if(!empty($arrRealtorExt))
    	{
	    	foreach($arrRealtorExt as $ext)
	    	{
	    		if($ext['name'] == 'description')
	    		{
	    			$arrRealtorInfo['descript'] = $ext['value'];
	    		}
	    	    if($ext['name'] == 'deny_id')
	    	    {
	    	    	$arrRealtorInfo['deny_id'] = $ext['value'];
	    	    }
	    	    if($ext['name'] == '门店信息')
	    	    {
	    	    	$arrRealtorInfo['shop_info'] = $ext['value'];
	    	    }
	    	}
    	}

    	$arrRealtorInfo['descript'] = empty($arrRealtorInfo['descript']) ? '':$arrRealtorInfo['descript'];
    	$arrRealtorInfo['shop_info'] = empty($arrRealtorInfo['shop_info']) ? '':$arrRealtorInfo['shop_info'];
    	//所属门店
    	if( $arrRealtorInfo['shopId']>0 ){
    		$arrShopInfo = Shop::getOne(" id = ".$arrRealtorInfo['shopId']);
    		$arrRealtorInfo['shopName'] = $arrShopInfo['name'] != '' ? $arrShopInfo['name'] : '';
    	}
    	else
        {
    		$arrRealtorInfo['shopName'] = '';
    	}

    	//所属公司简称
    	if( $arrRealtorInfo['comId']>0 )
    	{
    		$arrComInfo = Company::getOne(" id = ".$arrRealtorInfo['comId']);
    		$arrRealtorInfo['comName'] = !empty($arrComInfo['abbr']) ? $arrComInfo['abbr'] : '';
            $arrRealtorInfo['companyName'] = !empty($arrComInfo['name']) ? $arrComInfo['name'] : '';
    	}
    	else
    	{
    		$arrRealtorInfo['comName'] = '';
    	}

        return $arrRealtorInfo;
    }

    /**
     * @abstract 批量获取经纪人信息
     * @param array $ids
     * @return array
     *
     */
	public function getRealtorByIds($ids, $columns = '')
	{
		if(empty($ids))
        {
            return array();
        }
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
			$condition = array("id={$ids}");
		}
        $columns && $condition['columns'] = $columns;
        $arrRealtor  = self::find($condition, 0)->toArray();
		$arrRrealtor = array();
		foreach($arrRealtor as $value)
		{
			$arrRrealtor[$value['id']] = $value;
		}
		return $arrRrealtor;
	}


    /**
     * @abstract 获取同一区域内的经纪人信息
     * @auth jackchen
     * @param int $areaId
     * @return array
     */
    public function getRealtorAreaIds($areaId)
    {
        if(empty($areaId)){
            return false;
        }
        $where ="status in (".Realtor::STATUS_OPEN.",".Realtor::STATUS_FREE.")";
        $con['conditions'] = "areaId=".$areaId." and ".$where;
        $con['columns'] = "id";
        $arrData = self::find($con);
        return $arrData->toArray();
    }

    /**
     * 启用经纪人端口
     * @param array|int $realIds
     * @param array     $data
     * @return array
     */
    public function openPort($realIds, $data)
    {
        if(empty($realIds))
        {
            return array('status'=>1, 'info'=>'请选择要启用的经纪人！');
        }
        $realInfos = $this->getRealtorByIds($realIds, 'id,areaId,shopId,comId,regId,distId,cityId,status,certification');
        if(empty($realInfos))
        {
            return array('status'=>1, 'info'=>'经纪人不存在！');
        }
        foreach($realInfos as $realId=>$value)
        {
            if(self::STATUS_OPEN == $value['status'])
            {
                return array('status'=>1, 'info'=>'存在已经启用经纪人！');
            }
            if(self::CERTI_YES != $value['certification'])
            {
                return array('status'=>1, 'info'=>'经纪人还未通过审核，无法启用！');
            }
        }
        /****************** to be continued ******************/
        //执行清理 经纪人当天的计费记录，成功后，则插入新的计费记录
        //删除当天计费记录成功，则 设置事物开始
        /****************** to be continued ******************/
        $this->begin();
        foreach($realInfos as $realId=>$value)
        {
//            $orderObj = Orders::instance(false);
//            $orderObj->to = Orders::TO_REALTOR;
//            $orderObj->cityId = $value['cityId'];
//            $orderObj->comId = $value['comId'];
//            $orderObj->areaId = intval($value['areaId']);
//            $orderObj->shopId = $value['shopId'];
//            $orderObj->realId = $value['id'];
//            $orderObj->signingDate = date("Y-m-d");
//            $orderObj->startDate = date("Y-m-d");
//            $orderObj->expiryDate = $data['stopTime'];
//            $orderObj->amount = $data['price'];
//            $orderObj->status = Orders::STATUS_ENABLED;
//            //先生成订单 port
//            if($orderObj->create())
//            {
                $orderId = $orderObj->id;
                $realtorPortObj = RealtorPort::instance(false);
                $realtorPortObj->realId = $value['id'];
                $realtorPortObj->shopId = $value['shopId'];
                $realtorPortObj->areaId = intval($value['areaId']);
                $realtorPortObj->comId = $value['comId'];
                $realtorPortObj->regId = $value['regId'];
                $realtorPortObj->cityId = $value['cityId'];
                $realtorPortObj->orderId = 0;
                $realtorPortObj->portId = $data['portId'];
                $realtorPortObj->saleRelease = $data['saleRelease'];
                $realtorPortObj->saleRefresh = $data['saleRefresh'];
                $realtorPortObj->saleBold = $data['saleBold'];
                $realtorPortObj->saleTags = $data['saleTags'];
                $realtorPortObj->rentRelease = $data['rentRelease'];
                $realtorPortObj->rentRefresh = $data['rentRefresh'];
                $realtorPortObj->rentBold = $data['rentBold'];
                $realtorPortObj->rentTags = $data['rentTags'];
                $realtorPortObj->startDate = date("Y-m-d");
                $realtorPortObj->expiryDate = $data['stopTime'];
                $realtorPortObj->status = RealtorPort::STATUS_ENABLED;
                $realtorPortObj->updateTime = date('Y-m-d H:i:s');
                
                //哎，麻烦，还要找之前的 rentTagsExtra,saleTagsExtra
                $doneContion = array(
                    'conditions' => "realId={$realId} and status=".RealtorPort::STATUS_COMPLETED,
                    'columns'    => "realId,rentTagsExtra,saleTagsExtra",
                    'order'      => 'id desc',
                    'limit'      => array(
                        'offset' => 0,
                        'number' => 1
                    )
                );
                $lastDonePort = RealtorPort::find($doneContion, 0)->toArray();
                if(!empty($lastDonePort))
                {
                    if($lastDonePort[0]['rentTagsExtra'] > 0 || $lastDonePort[0]['saleTagsExtra'] > 0)
                    {
                        $realtorPortObj->rentTagsExtra = $lastDonePort[0]['rentTagsExtra'];
                        $realtorPortObj->saleTagsExtra = $lastDonePort[0]['saleTagsExtra'];
                    }
                }
                //插入到端口分配表 realtor_port
                if($realtorPortObj->create())
                {
                    //修改经纪人表中经纪人状态
                    $realtorObj = Realtor::findFirst("id={$value['id']}");
                    $realtorObj->status = Realtor::STATUS_OPEN;
                    $realtorObj->update = date("Y-m-d H:i:s");
                    if(self::IS_ORDER == $realtorObj->isOrder)
                    {
                        //如果是从 预约状态开启，则删除预约信息
                        $booking = RealtorBooking::find("realId={$realtorObj->id}");
                        if($booking)
                        {
                            foreach($booking as $book)
                            {
                                if(!$book->delete())
                                {
                                    $this->rollback();
                                    return array("status"=>1, 'info'=>'启用经纪人失败！');
                                }
                            }
                        }
                        $realtorObj->isOrder = self::IS_NO_ORDER;
                    }
                    if(!$realtorObj->update())
                    {
                        $this->rollback();
                        return array("status"=>1, 'info'=>'启用经纪人失败！');
                    }
                    //写入队列
                    Quene::Instance()->Put('realtor', array('action' => 'score', 'type' => VipScoreDetail::PROJECT_PAY_PORT, 'realId' => $value['id'], 'port' => intval($data['equivalent']), 'time' => date('Y-m-d H:i:s', time())));
                    //Quene::Instance()->Put('realtor', array('action' => 'stop', 'realId' => $value['id'], 'time' => date('Y-m-d H:i:s', time())), array('delay' => strtotime($data['stopTime'])-time()));
                }
                else
                {
                    $this->rollback();
                    return array("status"=>1, 'info'=>'启用经纪人失败！');
                }
//            }
//            else
//            {
//                $this->rollback();
//                return array("status"=>1, 'info'=>'启用经纪人失败！');
//            }
        }
        $this->commit();

        return array("status"=>0, 'info'=>'启用经纪人成功！', 'data'=>$realInfos);
    }

    /**
     * 预约经纪人端口
     * @param array|int $realIds
     * @param array     $data
     * @return array
     */
    public function orderPort($realIds, $data)
    {
        if(empty($realIds))
        {
            return array('status'=>1, 'info'=>'请选择要启用的经纪人！');
        }
        $realInfos = $this->getRealtorByIds($realIds, 'id,areaId,shopId,comId,regId,distId,cityId,status,certification');
        if(empty($realInfos))
        {
            return array('status'=>1, 'info'=>'经纪人不存在！');
        }
        $openedNum = 0;
        foreach($realInfos as $realId=>$value)
        {
            self::STATUS_OPEN == $value['status'] && $openedNum++;
            if(self::CERTI_YES != $value['certification'])
            {
                return array('status'=>1, 'info'=>'经纪人还未通过审核，无法启用！');
            }
        }
        if($openedNum > 0)
        {
            return array('status'=>1, 'info'=>'存在已经启用经纪人！');
        }

        $this->begin();
        foreach($realInfos as $realId=>$value)
        {
//            $orderObj = Orders::instance(false);
//            $orderObj->to = Orders::TO_REALTOR;
//            $orderObj->cityId = $value['cityId'];
//            $orderObj->comId = $value['comId'];
//            $orderObj->areaId = intval($value['areaId']);
//            $orderObj->shopId = $value['shopId'];
//            $orderObj->realId = $value['id'];
//            $orderObj->signingDate = date("Y-m-d");
//            $orderObj->startDate = date("Y-m-d");
//            $orderObj->expiryDate = $data['stopTime'];
//            $orderObj->amount = $data['price'];
//            $orderObj->status = Orders::STATUS_DISABLED;
//            //先生成订单 port
//            if($orderObj->create())
//            {
                $realtorBookingObj = RealtorBooking::findFirst("realId={$value['id']} and status<>".RealtorBooking::STATUS_DELETE);
                if($realtorBookingObj)
                {
                    $rs = $realtorBookingObj;
                }
                else
                {
                    $rs = RealtorBooking::instance(false);
                }

                $rs->realId = $value['id'];
                $rs->comId = $value['comId'];
                $rs->orderId = 0;
                $rs->portId = $data['portId'];
                $rs->saleRelease = $data['saleRelease'];
                $rs->saleRefresh = $data['saleRefresh'];
                $rs->saleBold = $data['saleBold'];
                $rs->saleTags = $data['saleTags'];
                $rs->rentRelease = $data['rentRelease'];
                $rs->rentRefresh = $data['rentRefresh'];
                $rs->rentBold = $data['rentBold'];
                $rs->rentTags = $data['rentTags'];
                $rs->startDate = $data['startTime'];
                $rs->expiryDate = $data['stopTime'];
                $rs->status = RealtorBooking::STATUS_ENABLED;
                $rs->updateTime = date('Y-m-d H:i:s');

                //插入到端口分配表 realtor_booking
                if($realtorBookingObj)
                {
                    $bookingRes = $rs->update();
                }
                else
                {
                    $bookingRes = $rs->create();
                }
                if($bookingRes)
                {
                    $realtorObj = Realtor::findFirst("id={$value['id']}");
                    $realtorObj->isOrder = Realtor::IS_ORDER;
                    $realtorObj->update = date("Y-m-d H:i:s");
                    //修改经纪人预约信息
                    if(!$realtorObj->update())
                    {
                        $this->rollback();
                        return array("status"=>1, 'info'=>'预约经纪人失败！');
                    }
                }
                else
                {
                    $this->rollback();
                    return array("status"=>1, 'info'=>'创建预约队列失败！');
                }
//            }
//            else
//            {
//                $this->rollback();
//                return array("status"=>1, 'info'=>'预约经纪人失败！');
//            }
        }
        $this->commit();

        return array("status"=>0, 'info'=>'预约经纪人成功！');
    }

    /**
     * 取消端口预约
     * @param array $realIds
     * @return boolean
     */
    public function cancelOrder($realIds)
    {
        if(empty($realIds))
        {
            return false;
        }
        $id = implode(',', $realIds);
        $realInfo = self::find("id in ({$id}) and status=".self::STATUS_STOP);
        if(!$realInfo)
        {
            return false;
        }
        $this->begin();
        foreach($realInfo as $rs)
        {
            $rs->isOrder = self::IS_NO_ORDER;
            if(!$rs->update())
            {
                $this->rollback();
                return false;
            }
            //删除预约信息 realtor_booking
            $booking = RealtorBooking::find("realId=".$rs->id);
            if(!$booking)
            {
                continue;
            }
            foreach($booking as $book)
            {
                if(!$book->delete())
                {
                    $this->rollback();
                    return false;
                }
            }
        }
        $this->commit();
        return true;
    }

    //获取拒绝理由
    public function getDenyCode($code = 0)
    {
    	$JUJUE_REASON=array(
    			self::DENY_PHOTO_CONTENT_NOT_MATCH => "图片与文字信息不相符，请重新提交个人信息，进行认证",
    			self::DENY_PHOTO_NOT_MATCH => "图片不清晰,请重新提交个人信息，进行认证",
    			self::DENY_CONTENT_NOT_MATCH => "信息不全,请重新提交个人信息，进行认证"
    	);
    	if ( empty($code) )
    	{
    		return $JUJUE_REASON;
    	}
    	else
    	{
    		return $JUJUE_REASON[$code];
    	}
    }

    /**
     *  验证修改独立经纪人资料信息
     *
     * @param array $data 提交的信息
     * @return bool 成功返回true，失败返回false
     */
    public function checkIndieRealtorInfo( $data = array() )
    {
    	if( empty($data['company_name_abbr']))
    	{
    		$this->setError('公司不能为空');
    		return false;
    	}
    	if( empty($data['district_id']))
    	{
    		$this->setError('请选择城区');
    		return false;
    	}

    	if( empty($data['region_id']))
    	{
    		$this->setError('请选择板块');
    		return false;
    	}
    	if( empty($data['shop_info']))
    	{
    		$this->setError('门店不能为空');
    		return false;
    	}
    	//判断经纪人是否付费
    	$xiugai = array(Realtor::STATUS_OPEN);
    	$realtor_indie_type = $data['realtor_status'];
    	if(in_array($realtor_indie_type,$xiugai)){

    		if( !preg_match("/^[1][3|4|5|7|8]\d{9}$/",$data['realtor_mobile']) ){
    			$this->setError('您输入的手机号码格式有误');
    			return false;
    		}
    	}

    	if( empty($data['realtor_mail']) ){
    		$this->setError('邮箱不能为空');
    		return false;
    	}else{
    		//判断邮箱是否被注册过
    		$num = $this->getCount(" id != ".$data['realtor_id']." and status != ".self::STATUS_DELETE." and email ='".$data['realtor_mail']."'");
    		if($num>0){
    			$this->setError('已经被注册了，换个别的吧');
    			return false;
    		}
    	}

    	if( !preg_match("/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/",$data['realtor_mail']) ){
    		$this->setError('邮箱格式不对');
    		return false;
    	}

    	//20110616	新曾固定电话
    	if((!empty($data['default_tel']) || !empty($data['tel_ext'])) && empty($data['realtor_tel'])){
    		$this->setError("电话号码不能为空");
    		return false;
    	}
    	if( !empty($data['tel_ext']) && !preg_match("/^[0-9]{1,5}$/",$data['tel_ext']) ){
    		$this->setError("分机只能输入1～5位数字");
    		return false;
    	}
    	if(!empty($data['realtor_tel'])){
    		$data['realtor_tel'] = str_replace("－","-", $data['realtor_tel']);//判断“-”是否有全角的
    		if(!preg_match("/^([0-9]{3,4}\-[0-9]{3,8}\-? | [0-9]{3,8} |[0-9\-]{3,13})$/",$data['realtor_tel'])){
    			$this->setError("电话号码输入有误!");
    			return false;
    		}
    	}
    	//增加敏感词过滤 2012-3-9 周海龙 <hailongzhou@sohu-inc.com>
    	$flag = Utility::Illegal_word_stock($data['realtor_describe']);
    	if($flag){
    		$this->setError("您填写的信息中使用了敏感词，请更换后重试");
    		return false;
    	}
    	return true;
    }

    /**
     * @abstract 根据相关条件获取经纪人
     * @author Eric xuminwan@sohu-inc.com
     * @param string $strCondition
     * @param string $columns
     * @param string $order
     * @param int $pageSize
     * @param int $offset
     *
     */
    public function getRealtorInfoByCondition($strCondition, $columns = '', $order = '', $pageSize = 0, $offset = 0)
    {
    	if(!$strCondition) return array();
    	$arrCon = array();
    	$arrCon['conditions'] = $strCondition;
    	if($columns) $arrCon['columns'] = $columns;
    	if($pageSize > 0) $arrCon['limit'] = array('number'=>$pageSize, 'offset'=>$offset);
    	if($order) $arrCon['order'] = $order;
    	$arrPark = self::find($arrCon,0)->toArray();
        $returnData = array();
        foreach($arrPark as $v)
        {
            $returnData[$v['id']] = $v;
        }

    	return $returnData;
    }

    public static function getAllNewStatus($status = 0)
    {
        $allStatus = array(
            self::STATUS_OPEN => '启用',
            self::STATUS_STOP => '非启用'
        );
        if(0 == $status)
        {
            return $allStatus;
        }
        else
        {
            return array_key_exists($status, $allStatus) ? $allStatus[$status] : '';
        }
    }

    /** 获取经纪人状态
     * @return array();
     */
    public static function getAllStatus($status = 0)
    {
        $allStatus = array(
            self::NEW_STATUS_REG    => '注册',
            self::NEW_STATUS_WAIT   => '待审',
            self::NEW_STATUS_PASS   => '过审',
            self::NEW_STATUS_FREE   => '免费',
            self::NEW_STATUS_PAY    => '付费',
            self::NEW_STATUS_SLEEP  => '休眠'
        );
        if(0 == $status)
        {
            return $allStatus;
        }
        else
        {
            return array_key_exists($status, $allStatus) ? $allStatus[$status] : '';
        }
    }

    /**
     * 获取经纪人状态名字
     *
     * @param int    $status       经纪人状态
     * @param int    $isNew        是否是经纪人新状态
     * @param int    $onlineNum    在线房源量(当老状态是免费时，需要该参数)
     * @return string   经纪人状态名称
     */
    public static function getRealStatusName($status, $isNew = 1, $onlineNum = 0)
    {
        //注册/待审/过审/免费/付费/休眠
        if(!$isNew)
        {
            //先转化成新状态
            $status = self::getRealNewStatus($status, $onlineNum);
        }

        return self::getAllStatus($status);
    }

    /**
     * 经纪人状态转化(old to new)
     * @param int    $oldStatus   经纪人旧的状态
     * @param int    $onlineNum   在线房源量(当老状态是免费时，需要该参数)
     * @return int   经纪人新的状态
     * @by tonyzhao
     */
    public static function getRealNewStatus($oldStatus, $onlineNum = 0)
    {
        /*
        新经纪人状态：注册/待审/过审/免费/付费/休眠
        新的老的对应关系：注册4  待审5？6 过审8？ 免费8？ 付费3 休眠1
        目前线上的休眠未来会被下线，也就是7不存在2可以不在产品端展示
         **/
        $oldStatus = intval($oldStatus);
        switch ($oldStatus)
        {
            //旧停用 -> 新休眠
            case self::STATUS_STOP:
                $newStatus = self::NEW_STATUS_SLEEP;
                break;

            //旧删除 -> 新删除
            case self::STATUS_DELETE:
                $newStatus = self::NEW_STATUS_DEL;
                break;

            //旧启用 -> 新付费
            case self::STATUS_OPEN:
                $newStatus = self::NEW_STATUS_PAY;
                break;

            //旧未认证 -> 新注册
            case self::STATUS_VERIFY_NO:
                $newStatus = self::NEW_STATUS_REG;
                break;

            //旧等待认证、认证失败 -> 新待审
            case self::STATUS_VERIFY_FALSE:
            case self::STATUS_VERIFY_WAIT:
                $newStatus = self::NEW_STATUS_WAIT;
                break;

            //旧免费 -> 新过审(无在线房源)、免费(有在线房源)
            case self::STATUS_FREE:
                if($onlineNum > self::FREE_HOUSE_NUM)
                {
                    $newStatus = self::NEW_STATUS_FREE;
                } else {
                    $newStatus = self::NEW_STATUS_PASS;
                }
                break;

            //旧休眠 弃用
            default:
                $newStatus = 0;
                break;
        }

        return $newStatus;
    }

    /**
     * 修改经纪人信息
     * @param int   $id
     * @param array $data
     * @return boolean
     */
    public function edit($id, $data)
    {
        if(!$id || empty($data))
        {
            return false;
        }
        $rs = self::findFirst($id);
        if(!$rs)
        {
            return false;
        }
        $data['distId'] > 0 && $rs->distId = $data['distId'];
        $data['regId'] > 0 && $rs->regId = $data['regId'];
        $data['name'] && $rs->name = $data['name'];
        $data['comId'] > 0 && $rs->comId = $data['comId'];
        $data['tel'] && $rs->mobile = $data['tel'];
        
        $this->begin();
        if($data['shopId'] > 0)
        {
            //如果修改门店，则修改经纪人的销售、客服,保持和门店的一致
            if($data['shopId'] != $rs->shopId)
            {
                $shopAllocation = Crmallocation::instance()->getAllocationByToIds(Crmallocation::SHOP, $data['shopId'], 'typeId,toId1,toId2');
                if(!empty($shopAllocation))
                {
                    
                    $editAlloRes =  Crmallocation::instance()->addAllocation(Crmallocation::REALTOR, $id, $shopAllocation[$data['shopId']]['toId1'], $shopAllocation[$data['shopId']]['toId2']);
                    if(!$editAlloRes)
                    {
                        $this->rollback();
                        return false;
                    }
                }
            }
            //经纪人区域、板块和门店区域、板块保持一致
            $shopDistId = intval($data['shopDistId']);
            $shopRegId = intval($data['shopRegId']);
            
            $shopDistId > 0 && $rs->distId = $shopDistId;
            $shopRegId > 0 && $rs->regId = $shopRegId;
            $rs->shopId = $data['shopId'];
        }
        if(($data['shopId']==0 && $data['shopName']=='其他门店'))
        {
            //如果修改门店，则修改经纪人的销售、客服,保持和板块的一致
            if($data['shopId'] != $rs->shopId)
            {
                $regAllocation = Crmallocation::instance()->getAllocationByToIds(Crmallocation::REGION, $rs->regId, 'typeId,toId1,toId2');
                if(!empty($regAllocation))
                {
                    $editAlloRes =  Crmallocation::instance()->addAllocation(Crmallocation::REALTOR, $id, $regAllocation[$rs->regId]['toId1'], $regAllocation[$rs->regId]['toId2']);
                    if(!$editAlloRes)
                    {
                        $this->rollback();
                        return false;
                    }
                }
            }
            $rs->shopId = $data['shopId'];
        }
        $rs->code = Utility::getRealtorCode($rs->comId, $id, $rs->shopId);

        if(!$rs->update())
        {
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }


    /**
     * 返回端口状态值数组
     * @return unknown
     */
    public function getPortStatus()
    {
    	return array(
    			self::PORT_STA_ALL=>'端口状态',
    			self::STATUS_OPEN=>'已启用',
    			self::STATUS_STOP=>'未启用'
    	);
    }

    public function isCertificationShow($realId, $type)
    {
    	if(empty($realId))
    	{
    		return false;
    	}
    	$mcKey = "certification_realId_".$realId;
    	$objMC = new Mem();
    	$data = $objMC->Get($mcKey);
    	if($data)
    	{
    		return false;
    	}
    	$arrData = $this->getOne(" id = $realId");
        if($type == 1)
        {
	    	if($arrData['certification'] != self::CERTI_YES)
	    	{
	    		return true;
	    	}
        }
        else
        {
        	if($arrData['status'] != self::STATUS_FREE)
        	{
        		return true;
        	}
        }

        if(time()-$arrData['validation'] < 3600*24*3)
        {
        	return true;
        }
        return false;
    }

    //根据经纪人ids获取经纪人账号， 姓名
    public function getRealBaseByIds($ids){
        if(empty($ids)) return array();
        $base = $this->getRealtorByIds($ids, "id,name,mobile,comId,shopId,areaId ");
        $account = VipAccount::instance()->getAccountByToIds(VipAccount::ROLE_REALTOR,$ids, "toId, name" );
        foreach($base as $v){
            if($v["comId"]){
                $comIds[$v["comId"]] = $v["comId"];
            }
            if($v["shopId"]){
                $shopIds[$v["shopId"]] = $v["shopId"];
            }
            if($v["areaId"]){
                $areaIds[$v["areaId"]] = $v["areaId"];
            }
        }
        $com = Company::instance()->getCompanyByIds($comIds, "name,id");
        $shop = Shop::instance()->getShopByIds($shopIds, "name,id");
        $area = Area::instance()->getAreaByIds($areaIds);

        foreach($base as $k=>&$v){
            $v['accountName'] = $account[$k]['name'];
            $v['comName'] = $com[$v["comId"]]['name'];
            $v['shopName'] = $shop[$v["shopId"]]['name'];
            $v['areaName'] = $area[$v["areaId"]]['name'];
        }
        return $base;
    }

    /**
     * 即将到期的经纪人
     * @param array $condition
     * @return array
     */
    public function getExpiringCount($where)
    {
    	$intExpiry = date("Y-m-d",strtotime("+".Realtor::WARN_DATE." days"));
    	$where .= " and Realtor.status = ".Realtor::STATUS_OPEN." and p.expiryDate < '$intExpiry' and p.expiryDate != '0000-00-00'"; 
    	$objCount = self::query()
    	->columns('COUNT(distinct Realtor.id) AS cnt')
    	->where($where)
    	->leftJoin('VipAccount', 'v.toId = Realtor.id', 'v')
    	->leftJoin('RealtorPort', 'p.realId = v.toId and p.status = 1', 'p')
    	->execute()
    	->getFirst();
    	return  $objCount->cnt? $objCount->cnt:0;
    }

    /**
     * 根据给定条件查询对应信息的数量  未删除的经纪人
     *
     * @return int 账户总数
     */
    public function getRealtorCountForNormal($where, $status)
    {
    	//不限端口状态，提取所有非删除经纪人
    	if(self::PORT_STA_ALL == intval($status) || 0 == intval($status)|| empty($status))
    	{
    		$where .= " and Realtor.status != ".intval(self::STATUS_DELETE);
    	}
    	else
    	{
    		$where .= " and Realtor.status = $status";
    	}
    	 $objCount = self::query()
    	->columns('count(distinct Realtor.id) as cnt')
    	->where($where)
    	->leftJoin('VipAccount', 'Realtor.id = v.toId', 'v')
    	->leftJoin('RealtorPort', 'v.toId = p.realId and p.status = 1', 'p')
    	->execute()
    	->getFirst();
    	 return  $objCount->cnt? $objCount->cnt:0;
    }

    /**
     * 根据给定条件查询对应信息的数量 未删除的经纪人
     *
     * @return int 账户总数
     */
    public function getRealtorListForNormal($where,$order='', $offset='', $size='', $select = '', $status)
    {
        //不限端口状态，提取所有非删除经纪人
    	if(self::PORT_STA_ALL == intval($status) || 0 == intval($status) || empty($status))
    	{
    		$where .= " and Realtor.status != ".intval(self::STATUS_DELETE);
    	}
    	else
    	{
    		$where .= " and Realtor.status = $status";
    	}
    	try {
    		if(empty($offset) && empty($size))
    		{
    			$arrRealtor = self::query()
    			->columns('Realtor.id,Realtor.name,Realtor.status,Realtor.create,Realtor.mobile,Realtor.areaId,Realtor.shopId,Realtor.code,v.name as accname,p.expiryDate,p.startDate,p.portId,p.num')
    			->where($where." GROUP BY Realtor.id"." order by ".$order)
    			->leftJoin('VipAccount', 'Realtor.id = v.toId', 'v')
    			->leftJoin('RealtorPort', 'v.toId = p.realId and p.status = 1', 'p')
    			->execute()
    			->toArray();
    		}
    		else
    		{
		    	$arrRealtor = self::query()
		    	->columns('Realtor.id,Realtor.name,Realtor.status,Realtor.create,Realtor.mobile,Realtor.areaId,Realtor.code,v.name as accname,p.expiryDate,p.startDate,p.portId,p.num')
		    	->where($where." GROUP BY Realtor.id order by ".$order." limit ".$offset." , ".$size)
	 	        ->leftJoin('VipAccount', 'Realtor.id = v.toId', 'v')
	    	    ->leftJoin('RealtorPort', 'v.toId = p.realId and p.status = 1', 'p')
		    	->execute()
		    	->toArray();
    		}
    	}
        catch(Exception $e)
    	{
    		echo $e->getMessage();
    	}
    	$arrIds = array();
    	$arrPortCity = array();
    	foreach($arrRealtor as $value)
    	{
    		$arrIds[] = $value['portId'];
    	}
    	$arrIds = array_filter($arrIds);
    	$arrIds = array_unique($arrIds);

    	$objPortCity = new PortCity();
    	if(!empty($arrIds))
    	{
	    	$arr = $objPortCity->getAll(" id in (".implode(',', $arrIds).")",'','','',' id, type, equivalent');
	    	$arrPortCity = array();
		    foreach($arr as $port)
		    {
		    	$arrPortCity[$port['id']] = $port;
		    }
    	}
    	if(!empty($arrRealtor))
    	{
    		foreach($arrRealtor as $k=>$v)
    		{
    			$arrRealtor[$k]['create'] = substr($arrRealtor[$k]['create'],0,10);
    			$arrRealtor[$k]['port_type'] = $arrPortCity[$v['portId']]['type'];
    			//端口类型为出售
    			if( PortCity::STATUS_Sale == $arrPortCity[$v['portId']]['type'])
    			{
    				$arrRealtor[$k]['max_port_sale'] = $v['num']*$arrPortCity[$v['portId']]['equivalent'];
    				$arrRealtor[$k]['max_port_rent'] = 0;
    			}
    			//端口类型为出租
    			if( PortCity::STATUS_Rent == $arrPortCity[$v['portId']]['type'])
    			{
    				$arrRealtor[$k]['max_port_rent'] = $v['num']*$arrPortCity[$v['portId']]['equivalent'];
    				$arrRealtor[$k]['max_port_sale'] = 0;
    			}
    			//端口状态
    			if(self::STATUS_OPEN == $v['status'])
    			{
    				//启用状态
    				$arrRealtor[$k]['broker_status_name'] = '已启用';
    				$arrRealtor[$k]['openClose'] = '停用';
    				$arrRealtor[$k]['del'] = '<a href="javascript:void(0);" title="已启用状态下的经纪人不能删除!" style="color:#666"  >删除</a>';
    				$arrRealtor[$k]['expiryDate'] = $v['expiryDate'] ? $v['expiryDate'] : '不限制';
    				if($arrRealtor[$k]['expiryDate'] == '0000-00-00')
    				{
    					$arrRealtor[$k]['expiryDate'] = '不限制';
    				}
    				$arrRealtor[$k]['checkboxDisabled'] = "  ";
    			}
    			else
    			{
    				//未启用状态
    				$arrRealtor[$k]['broker_status_name'] = '未启用';
    				$arrRealtor[$k]['openClose'] = '启用';
    				$arrRealtor[$k]['hrefUrl'] = "\"{$v['id']}_qiyong\"  rel=\"#overlay\"";
    			    $arrRealtor[$k]['del'] = '<a  href="javascript:if(confirm(\'此操作将会删除经纪人所有相关信息,确定要删除吗?\')){chooseSubmit(base_url+\'realtor/delete?realId='.$v['id'].'\');}">删除</a>';
    			    $arrRealtor[$k]['expiryDate'] = $v['expiryDate'] ?$v['expiryDate'] : '无';
    			    $arrPort = RealtorPort::getAll(" realId = {$v['id']} and status = ".RealtorPort::STATUS_COMPLETED,' id desc',0,1,' startDate,expiryDate');
    				if(!empty($arrPort)) 
    				{
    					$arrRealtor[$k]['startDate'] = $arrPort[0]['startDate'];
    					$arrRealtor[$k]['expiryDate'] = $arrPort[0]['expiryDate'];
    				}
    				if($arrRealtor[$k]['expiryDate'] == '0000-00-00')
    				{
    					$arrRealtor[$k]['expiryDate'] = '无';
    				} 
    				$arrRealtor[$k]['checkboxDisabled'] = "  disabled";
    			}
    		}
    	}
    	return $arrRealtor;
    }

    /**
     * 拒绝认证
     * @param int   $realId
     * @param array $data
     * @return boolean
     */
    public function rejectVerify($realId, $data)
    {
        if(!$realId || empty($data))
        {
            return false;
        }
        $realtor = self::findFirst("id={$realId} and type=".self::TYPE_ALONE);
        if(!$realtor)
        {
            return false;
        }
        $realtor->status = self::STATUS_VERIFY_FALSE;
        $realtor->validation = time();
        $realtor->certification = self::CERTI_NOT;
        $realtor->denyId = $data['denyId'];
        $realtor->update = date('Y-m-d H:i:s');
        $this->begin();
        if($realtor->update())
        {
            //修改资源表 crm_allocation
            $editAllRes = $this->editRealAllocation($realId, $data['saleId'], $data['CSId']);
            if($editAllRes)
            {
                $this->commit();
                return true;
            }
            $this->rollback();
            return false;
        }
        $this->rollback();
        return false;
    }

    /**
     * 通过认证
     * @param int   $realId
     * @param array $data
     * @return boolean
     */
    public function passVerify($realId, $data)
    {
        if(!$realId || empty($data))
        {
            return false;
        }
        $realtor = self::findFirst("id={$realId} and type=".self::TYPE_ALONE);
        if(!$realtor)
        {
            return false;
        }
        $realtor->status = self::STATUS_FREE;
        $realtor->validation = time();
        $realtor->certification = self::CERTI_YES;
        $realtor->update = date('Y-m-d H:i:s');

        $this->begin();
        if($realtor->update())
        {
            //修改经纪人销售、客服
            $editAllRes = $this->editRealAllocation($realId, $data['saleId'], $data['CSId']);
            if(!$editAllRes)
            {
                $this->rollback();
                return false;
            }
            $portRes = $this->openFreePort($realId);
            if(!$portRes)
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

    public function editRealAllocation($realId, $saleId, $CSId)
    {
        $saleId = intval($saleId);
        $CSId = intval($CSId);

        return Crmallocation::instance()->addAllocation(Crmallocation::REALTOR, $realId, $saleId, $CSId);
    }

    /**
     * 独立经纪人认证通过开通免费端口
     * @param int $realId
     * @return boolean
     */
    public function openFreePort($realId)
    {
        //$realtor = self::findFirst("id={$realId} and type=".self::TYPE_ALONE, 0)->toArray();
        $realtor = self::findFirst("id={$realId}", 0)->toArray();
        if(empty($realtor) || self::STATUS_OPEN == $realtor['status'])
        {
            return false;
        }
        //确保 realtor_port 中可用端口的唯一性
        $validPorts = RealtorPort::find("realId={$realId} and status=".RealtorPort::STATUS_ENABLED);
        if($validPorts)
        {
            foreach($validPorts as $validPort)
            {
                $validPort->status = RealtorPort::STATUS_COMPLETED;
                $validPort->update = date('Y-m-d H:i:s');
                $validPort->expiryDate = date('Y-m-d');
                if(!$validPort->update())
                {
                    return false;
                }
            }
        }

        /*
        $realOrders = Orders::find("realId={$realId} and to=".Orders::TO_REALTOR." and status=".Orders::STATUS_ENABLED);
        if($realOrders)
        {
            //先关闭所有订单
            foreach($realOrders as $v)
            {
                $v->status = Orders::STATUS_DISABLED;
                $v->update = date("Y-m-d H:i:s");
                if(!$v->update())
                {
                    return false;
                }
            }
        }
        $realOrder = Orders::instance(false);
        $realOrder->to = Orders::TO_REALTOR;
        $realOrder->cityId = $realtor['cityId'];
        $realOrder->comId = $realtor['comId'];
        $realOrder->areaId = intval($realtor['areaId']);
        $realOrder->shopId = $realtor['shopId'];
        $realOrder->signingDate = date('Y-m-d');
        $realOrder->startDate = date('Y-m-d');
        $realOrder->expiryDate = date('Y-m-d');
        $realOrder->status = Orders::STATUS_ENABLED;
        $realOrder->amount = 0;

        if(!$realOrder->create())
        {
            return false;
        }
        */
        //$port = Port::findFirst("type=".Port::TYPE_FREE." and status=".Port::STATUS_ENABLED, 0)->toArray();
        $port = Port::findFirst("name='QS1' and status=".Port::STATUS_ENABLED, 0)->toArray();
        if(empty($port))
        {
            return false;
        }
        $portCity = PortCity::findFirst("cityId={$realtor['cityId']} and portId={$port['id']} and status=".PortCity::STATUS_ENABLED, 0)->toArray();
        if(empty($portCity))
        {
            return false;
        }
        //$cityInfo = City::findFirst($realtor['cityId'], 0)->toArray();
        //require_once DOCROOT."../config/{$cityInfo['pinyinAbbr']}.config.inc.php";

        $rs = RealtorPort::instance(false);
        $rs->realId = $realId;
        $rs->shopId = $realtor['shopId'];
        $rs->areaId = intval($realtor['areaId']);
        $rs->comId = $realtor['comId'];
        $rs->regId = $realtor['regId'];
        $rs->cityId = $realtor['cityId'];
        $rs->orderId = 0;
        $rs->portId = $portCity['id'];
        $rs->saleRelease = $portCity['esfRelease'];
        $rs->saleRefresh = $portCity['esfRefresh'];
        $rs->saleBold = $portCity['esfBold'];
        $rs->saleTags = $portCity['esfTags'];
        $rs->rentRelease = $portCity['rentRelease'];
        $rs->rentRefresh = $portCity['rentRefresh'];
        $rs->rentBold = $portCity['rentBold'];
        $rs->rentTags = $portCity['rentTags'];
        $rs->startDate = date('Y-m-d');
        //$rs->expiryDate = date('Y-m-d', strtotime("+ ".BROKER_FREETIME." days"));
        $rs->expiryDate = '0000-00-00';
        $rs->status = RealtorPort::STATUS_ENABLED;
        $rs->updateTime = date('Y-m-d H:i:s');
        
        //哎，麻烦，还要找之前的 rentTagsExtra,saleTagsExtra
        $doneContion = array(
            'conditions' => "realId={$realId} and status=".RealtorPort::STATUS_COMPLETED,
            'columns'    => "realId,rentTagsExtra,saleTagsExtra",
            'order'      => 'id desc',
            'limit'      => array(
                'offset' => 0,
                'number' => 1
            )
        );
        $lastDonePort = RealtorPort::find($doneContion, 0)->toArray();
        if(!empty($lastDonePort))
        {
            if($lastDonePort[0]['rentTagsExtra'] > 0 || $lastDonePort[0]['saleTagsExtra'] > 0)
            {
                $rs->rentTagsExtra = $lastDonePort[0]['rentTagsExtra'];
                $rs->saleTagsExtra = $lastDonePort[0]['saleTagsExtra'];
            }
        }

        if($rs->create())
        {
            return true;
        }

        return false;
    }

    /**
     * 企业经济人资料认证
     * @param array $passReal
     * @param array $denyReal
     * @param array $data      其他信息，诸如  array('userId'=>0, 'source'=>1, 'actionType'=>1)
     * @return boolean
     */
    public function certifyRealtor($passReal, $denyReal, $data = array())
    {
        $this->begin();
        $logData = array();

        if(!empty($passReal))
        {
            //通过认证
            foreach($passReal as $v)
            {
                $realtor = self::findFirst($v['id']);
                $realtor->certification = self::CERTI_YES;
                $realtor->status = self::STATUS_OPEN;
                if($data['source'] != RealtorCertificationLog::SOURCE_FROM_VIP)
                {
                    $realtor->validation = time();
                }
                
                $cityId = $realtor->cityId;
                
                if(!$realtor->update())
                {
                    $this->rollback();
                    return false;
                }
                $openRes = $this->openFreePort($v['id']);
                if(!$openRes)
                {
                    $this->rollback();
                    return false;
                }

                $logData[] = array(
                    'cityId' => $cityId,    
                    'realId' => $v['id'],                  
                    'source' => intval($data['source']),
                    'status' => RealtorCertificationLog::STATUS_PASS,
                    'denyId' => 0,
                    'actionType' => intval($data['actionType']),
                    'operatorId' => intval($data['userId']),
                    'operateIp'  => Utility::GetUserIP()
                );
            }
        }
        $denyRealIds = array();
        if(!empty($denyReal))
        {
            //认证失败
            foreach($denyReal as $v)
            {
                $realtor = self::findFirst($v['id']);
                $realtor->certification = self::CERTI_NOT;
                $realtor->denyId = $v['reason'];
                $realtor->validation = time();
                
                $cityId = $realtor->cityId;
                if(Realtor::STATUS_OPEN == $realtor->status)
                {
                    $denyRealIds[] = $v['id'];
                }
                if(!$realtor->update())
                {
                    $this->rollback();
                    return false;
                }
                $logData[] = array(
                    'cityId' => $cityId,    
                    'realId' => $v['id'],                  
                    'source' => intval($data['source']),
                    'status' => RealtorCertificationLog::STATUS_UNPASS,
                    'denyId' => $v['reason'],
                    'actionType' => intval($data['actionType']),
                    'operatorId' => intval($data['userId']),
                    'operateIp'  => Utility::GetUserIP()
                );                
            }
        }
        $logRes = RealtorCertificationLog::instance()->addCertLog($logData);
        $this->commit(); 
        if(!empty($denyRealIds))
        {
            $stopPortRes = $this->stopPort($denyRealIds);
            if($stopPortRes['status'] == 1)
            {
                $stopPortRes = $this->stopPort($denyRealIds);
            }
        }
        return true;
    }

    /**
     * 批量停止端口
     * @param array $realIds
     * @return array
     */
    public function stopPort($realIds)
    {
        if(empty($realIds))
        {
            return false;
        }
        $realId = implode(',', $realIds);
        $tags = self::count("id in ({$realId}) and status=".self::STATUS_STOP);
		if(intval($tags) > 0)
        {
            return array('status'=>1, 'info'=>'存在已经停止经纪人!');
		}

        $this->begin();
        //删除刷新队列
        $refreshQueue = VipRefreshQueue::find("realId in ({$realId})");
        if($refreshQueue)
        {
            foreach($refreshQueue as $queue)
            {
                if(!$queue->delete())
                {
                    $this->rollback();
                    return array('status'=>1, 'info'=>'停止失败！');
                }
            }
        }
        //经纪人端口检测数据清0
        $portExam = RealtorAppraisal::find("realId in ({$realId})");
        if($portExam)
        {
            foreach($portExam as $exam)
            {
                $exam->publish = 0;
                $exam->fresh = 0;
                $exam->published = 0;
                $exam->tag = 0;
                $exam->fine = 0;
                $exam->picture = 0;
                $exam->failure = 0;
                $exam->publishRes = 0;
                $exam->freshRes = 0;
                $exam->publishedRes = 0;
                $exam->tagRes = 0;
                $exam->fineRes = 0;
                $exam->pictureRes = 0;
                $exam->failureRes = 0;
                $exam->examTime = '0000-00-00 00:00:00';
                $exam->useStat = 0;
                $exam->lastScore = 0;

                if(!$exam->update())
                {
                    $this->rollback();
                    return array('status'=>1, 'info'=>'停止失败！');
                }
            }
        }

        //修改经纪人状态
        $realtors = self::find("id in ($realId)");
        foreach($realtors as $realtor)
        {
            $realtor->status = self::STATUS_STOP;
            $realtor->update = date('Y-m-d H:i:s');
            if(!$realtor->update())
            {
                $this->rollback();
                return array('status'=>1, 'info'=>'停止失败！');
            }
        }

        //操作经纪人端口表
        $realPort = RealtorPort::find("realId in ({$realId}) and status=".RealtorPort::STATUS_ENABLED);
        if($realPort)
        {
            $orderIds = array();
            $portInfos = array();
            foreach($realPort as $port)
            {
                $orderIds[] = $port->orderId;
                $portInfos[] = array(
                    'portId' => $port->portId,
                    'realId' => $port->realId
                );

                $port->status = RealtorPort::STATUS_COMPLETED;
                $port->update = date('Y-m-d H:i:s');
                $port->expiryDate = date('Y-m-d');
                if(!$port->update())
                {
                    $this->rollback();
                    return array('status'=>1, 'info'=>'停止失败！');
                }
            }

//            if(!empty($orderIds))
//            {
//                $orderId = implode(',', $orderIds);
//                $orders = Orders::find("id in ({$orderId}) and to=".Orders::TO_REALTOR." and status=".Orders::STATUS_ENABLED);
//                if($orders)
//                {
//                    foreach($orders as $order)
//                    {
//                        $order->status = Orders::STATUS_DISABLED;
//                        $order->expiryDate = date('Y-m-d');
//                        $order->update = date('Y-m-d H:i:s');
//                        if(!$order->update())
//                        {
//                            $this->rollback();
//                            return array('status'=>1, 'info'=>'停止失败！');
//                        }
//                    }
//                }
//            }
        }

        //处理房源
        $houses = House::find("realId in ({$realId}) and status=".House::STATUS_ONLINE." and roleType<>".House::ROLE_SELF);
        if($houses)
        {
            foreach($houses as $house)
            {
                $house->status = House::STATUS_OFFLINE;
                $house->xiajia = date('Y-m-d H:i:s');
                $house->houseUpdate = date('Y-m-d H:i:s');

                if(!$house->update())
                {
                    $this->rollback();
                    return array('status'=>1, 'info'=>'停止失败！');
                }

                global $sysES;
                $clsEs = new Es($sysES['default']);
                $arrData = array(
                    'status'      => House::STATUS_OFFLINE,
                    'xiajia'      => $house->xiajia,
                    'houseUpdate' => $house->houseUpdate
                );
                $intFlag = $clsEs->update(array('id' => $house->id, 'data' => $clsEs->houseFormat($arrData)));
//                if($intFlag == false)
//                {
//                    $this->rollback();
//                    return array('status'=>1, 'info'=>'停止失败！');
//                }
                Quene::Instance()->Put('house', array('action' => 'offline', 'houseId' => $house->id, 'realId' => $house->realId, 'cityId' => $house->cityId, 'status' => $house->status, 'time' => date('Y-m-d H:i:s', time())));

            }
        }

        $this->commit();
        return array('status'=>0, 'info'=>'停止成功！', 'portInfos'=>$portInfos);
    }

    /**
     * 独立经纪人转移
     * @param int|array $realIds
     * @param int       $saleId
     * @param int       $userId
     * @param string    $userName
     * @param int       $cityId
     * @return boolean
     */
    public function tranferRealtor($realIds, $saleId, $userId, $userName, $cityId)
    {
        if(empty($realIds))
        {
            return false;
        }

        //获取更新之前销售
        $beforeSales = Crmallocation::instance()->getAllocationByToIds(Crmallocation::REALTOR, $realIds, 'typeId,toId1');

        $this->begin();
        foreach((array)$realIds as $realId)
        {
            $realtorRes = Crmallocation::instance()->addAllocation(Crmallocation::REALTOR, $realId, $saleId);
            if(!$realtorRes)
            {
                $this->rollback();
                return false;
            }
        }
        $this->commit();
        //写log日志
        $realList = $this->getRealtorByIds($realIds, 'id,name');
        $saleList = AdminUser::instance()->getUserForSearch($cityId);;
        $data = array();
        foreach($realList as $id=>$v)
        {
            $value = array();
            $value['userId'] = $userId;
            $value['userName'] = $userName;
            $value['shopId'] = $id;
            $value['shopName'] = $v['name'];
            $value['toSaleId'] = $saleId;
            $value['fromUserId'] = $beforeSales[$id]['toId1'] ? $beforeSales[$id]['toId1'] : 0;
            $value['modifyStr'] .= $beforeSales[$id]['toId1'] ? $saleList[$beforeSales[$id]['toId1']] : '';
            $value['modifyStr'] .= '→';
            $value['modifyStr'] .= $saleId ? $saleList[$saleId] : '';
            $value['time'] = date('Y-m-d H:i:s');
            $value['type'] = 2;
            $data[] = $value;
            unset($value);
        }
        CrmUserLogs::instance()->addTranferShopLogs($data);

        return true;
    }

    /**
     * 企业经济人转为独立经纪人
     * @param int $realId
     * @return array
     */
    public function convertRealtor($realId)
    {
        if(empty($realId))
        {
			return array('status'=>1, 'info'=>'经纪人不能为空！');
		}
		$brokerInfo = $this->getOneDataById($brokerID);
        $realInfo = self::findFirst($realId);
		if(!$realInfo)
        {
            return array('status'=>1, 'info'=>'经纪人信息不存在！');
		}
		if($realInfo->status != self::STATUS_STOP )
        {
            return array('status'=>1, 'info'=>'该经纪人还没有停止使用！');
		}
		//取门店名称
        $shopInfo = Shop::findFirst($realInfo->shopId, 0)->toArray();
		$shopName = $shopInfo['name'];
        $realInfo->shopId = 0;
        $realInfo->type = self::TYPE_ALONE;

        $this->begin();
        if(!$realInfo->update())
        {
            $this->rollback();
            return array('status'=>1, 'info'=>'已停用的经纪人转独立经纪人失败！');
        }
        $shopRes = RealtorExt::instance()->updateRealExtById($realId, '门店信息', $shopName);
        if(!$shopRes)
        {
            $this->rollback();
            return array('status'=>1, 'info'=>'已停用的经纪人转独立经纪人失败！');
        }

        $this->commit();
        return array('status'=>0, 'info'=>'已停用的经纪人转独立经纪人失败！');
    }

	/**
	 * 根据经纪人名称，获取经纪人信息(默认true为非删除状态，false为全部状态)
	 * @param string $name
	 * @param array $cond 额外的条件
	 * @param boolean $flag
	 * @return array
	 */
	public function getAllByRealtorName($name, $cond = array(), $flag = true)
	{
		$condition = array();
		$condition[] = "name like '{$name}%'";
		if(!empty($cond)){
			foreach($cond as $k => $v){
				$condition[] = $v;
			}
		}
		if(true == $flag)
		{
			$condition[] =  'status <>'.self::STATUS_DELETE;
		}
		return $this->getAll(implode(' and ', $condition));
	}

	/**
	 * 根据经纪人id数组，获取符合的所有经纪人名称
	 * @param array $arrIds
	 * @author libo <neroli@sohu-inc.com>
	 */
	public function getRealtorNameByIds($arrIds)
	{
		$arrRealtorName = array();//经纪人姓名
		$arrRealtorInfo = Realtor::Instance()->getSelectData('Realtor', 'Realtor.id,Realtor.name,va.name as accname', "Realtor.id in(".implode(',', $arrIds).")", array(), array(), '', '', '', 0, 0, array('model' => 'VipAccount', 'conditions' => 'va.toId = Realtor.id and va.to='.VipAccount::ROLE_REALTOR, 'alias' => 'va', 'join' => 'left'));
		foreach($arrRealtorInfo as $realtor)
		{
			$arrRealtorName[$realtor['id']]['name'] = $realtor['name'];
			$arrRealtorName[$realtor['id']]['accname'] = $realtor['accname'];
		}

		return $arrRealtorName;
	}

	/**
	 * 根据经纪人账号，获取经纪人信息(默认true为非删除状态，false为全部状态)
	 * @param string $accname
	 * @param array $cond 额外的条件
	 * @param boolean $flag
	 * @return array
	 * @author libo <neroli@sohu-inc.com>
	 */
	public function getAllByAccname($accname, $cond = array(), $flag = true)
	{
		$condition[] = "va.name like '{$accname}%'";
		if(!empty($cond)){
			foreach($cond as $k => $v){
				$condition[] = $v;
			}
		}
		if(true == $flag)
		{
			$condition[] =  'Realtor.status <>'.self::STATUS_DELETE;
		}
		return Realtor::Instance()->getSelectData('Realtor', 'Realtor.id,Realtor.name,va.name as accname', implode(' and ', $condition), array(), array(), '', '', '', 0, 0, array('model' => 'VipAccount', 'conditions' => 'va.toId = Realtor.id and va.to='.VipAccount::ROLE_REALTOR, 'alias' => 'va', 'join' => 'left'));
	}

    /**
     * 合并经纪人
     * @param array $data
     * @return array
     */
    public function mergeRealtor($data)
    {
        $checkRes = $this->_checkMergeData($data);
        if(0 !== $checkRes['status'])
        {
            return $checkRes;
        }
        $arrFrom = $checkRes['from'];
        $arrTo = $checkRes['to'];

        $this->begin();
        //删除刷新队列
        $refreshQueue = VipRefreshQueue::find("realId={$arrFrom['id']}");
        if($refreshQueue)
        {
            foreach($refreshQueue as $queue)
            {
                if(!$queue->delete())
                {
                    $this->rollback();
                    return array('status'=>1, 'info'=>'合并失败！');
                }
            }
        }

        //经纪人端口检测数据清0
        $portExam = RealtorAppraisal::find("realId={$arrFrom['id']}");
        if($portExam)
        {
            foreach($portExam as $exam)
            {
                if(!$exam->delete())
                {
                    $this->rollback();
                    return array('status'=>1, 'info'=>'合并失败！');
                }
            }
        }

        //修改经纪人状态
        $realtor = self::findFirst($arrFrom['id']);

        $realtor->status = self::STATUS_STOP;
        $realtor->update = date('Y-m-d H:i:s');
        if(!$realtor->update())
        {
            $this->rollback();
            return array('status'=>1, 'info'=>'合并失败！');
        }

        //操作经纪人端口表
        $realPort = RealtorPort::find("realId in({$arrFrom['id']},{$arrTo['id']}) and status=".RealtorPort::STATUS_ENABLED);
        if($realPort)
        {
            $orderIds = array();
            $portInfos = array();
            $portIds = array();
            $portNum = 0;
            foreach($realPort as $port)
            {
                $portIds[$port->realId] = $port->portId;
                if($arrTo['id'] == $port->realId)
                {
                    $toPort = array('realId'=>$port->realId, 'portId'=>$port->portId);
                    $toPortObj = $port;
                    continue;
                }
                $fromPort = array('realId'=>$port->realId, 'portId'=>$port->portId);
                $orderIds[] = $port->orderId;
                $portInfos[] = array(
                    'portId' => $port->portId,
                    'realId' => $port->realId
                );

                $port->status = RealtorPort::STATUS_DISABLED;
                $port->update = date('Y-m-d H:i:s');
                $port->expiryDate = date('Y-m-d');
                if(!$port->update())
                {
                    $this->rollback();
                    return array('status'=>1, 'info'=>'合并失败！');
                }
            }
            if(empty($fromPort) || empty($toPort))
            {
                $this->rollback();
                return array('status'=>1, 'info'=>'要合并的或被合并的经纪人没有有效端口！');
            }
            $portCitys = PortCity::find("id in(".  implode(',', $portIds).")", 0)->toArray();
            foreach($portCitys as $v)
            {
                $cityId = $v['cityId'];
                $portType = $v['type'];

                if($v['id'] == $fromPort['portId'])
                {
                    $portNum += intval($v['equivalent']);
                    $fromPort = $v;
                }
                if($v['id'] == $toPort['portId'])
                {
                    $portNum += intval($v['equivalent']);
                    $toPort = $v;
                }
            }

            if($fromPort['type'] != $toPort['type'])
            {
                $this->rollback();
                return array('status'=>1, 'info'=>'端口类型不一致，不能进行合并！');
            }
            if($portNum > 0)
            {
                $newPort = PortCity::findFirst("cityId={$cityId} and type='{$portType}' and equivalent={$portNum} and status=".PortCity::STATUS_ENABLED, 0)->toArray();
                $toPortObj->portId = $newPort['id'];
                if(!$toPortObj->update())
                {
                    return array('status'=>1, 'info'=>'合并失败！');
                }

            }

//            if(!empty($orderIds))
//            {
//                $orderId = implode(',', $orderIds);
//                $orders = Orders::find("id in ({$orderId}) and to=".Orders::TO_REALTOR." and status=".Orders::STATUS_ENABLED);
//                if($orders)
//                {
//                    foreach($orders as $order)
//                    {
//                        $order->status = Orders::STATUS_DISABLED;
//                        $order->expiryDate = date('Y-m-d');
//                        $order->update = date('Y-m-d H:i:s');
//                        if(!$order->update())
//                        {
//                            $this->rollback();
//                            return array('status'=>1, 'info'=>'合并失败！');
//                        }
//                    }
//                }
//            }
        }

        //处理房源
        $houses = House::find("realId={$arrFrom['id']} and roleType=".House::ROLE_REALTOR);
        if($houses)
        {
            foreach($houses as $house)
            {
                $house->shopId = $arrTo['shopId'];
                $house->comId = $arrTo['comId'];
                if(!$house->update())
                {
                    $this->rollback();
                    return array('status'=>1, 'info'=>'合并失败！');
                }

                global $sysES;
                $clsEs = new Es($sysES['default']);
                $arrData = array(
                    'shopId'      => $house->shopId,
                    'comId'       => $house->comId
                );
                $intFlag = $clsEs->update(array('id' => $house->id, 'data' => $clsEs->houseFormat($arrData)));
                if($intFlag == false)
                {
                    $this->rollback();
                    return array('status'=>1, 'info'=>'停止失败！');
                }
            }
        }

        $this->commit();
        return array('status'=>0, 'info'=>'合并成功！', 'data'=>array('from'=>$arrFrom, 'to'=>$arrTo));
    }

    private function _checkMergeData($data)
    {
    	if(empty($data))
    	{
            return array('status'=>1, 'info'=>'经纪人参数错误');
    	}

    	//源经纪人id
    	$fromRealId = intval($data['fromRealId']);
    	//目标经纪人id
    	$toRealId = intval($data['toRealId']);
    	if($fromRealId <= 0 || $toRealId <= 0)
    	{
            return array('status'=>1, 'info'=>'没有需要合并的经纪人信息');
    	}
    	elseif ($fromRealId == $toRealId)
    	{
            return array('status'=>1, 'info'=>'同一经纪人不能合并!');
    	}
    	//构造条件，获取对应的经纪人基本信息
        $condition = array(
            'conditions' => "id in({$fromRealId},{$toRealId})"
        );
        $arrAllRealtor = Realtor::find($condition, 0)->toArray();
    	$arrResult = array();
   		if($arrAllRealtor[0]['id'] == $intFromId)//判定源经纪人基本信息
   		{
   			$arrFrom = $arrAllRealtor[0]; //赋值为源经纪人
   			$arrTo = $arrAllRealtor[1];   //赋值为 目标经纪人
   		}
   		else
   		{
   			$arrFrom = $arrAllRealtor[1];
   			$arrTo = $arrAllRealtor[0];
   		}

   		if($arrFrom['cityId'] != $arrTo['cityId'])
   		{
            return array('status'=>1, 'info'=>'禁止跨城市合并经纪人!');
   		}
   		if($arrFrom['comId'] != $arrTo['comId'])
   		{
            return array('status'=>1, 'info'=>'禁止跨公司合并经纪人!');
   		}

        $arrResult['status'] = 0;
        $arrResult['from'] = $arrFrom;
        $arrResult['to'] = $arrTo;

   		return $arrResult;
    }
    
    /**
     * 转移房源
     * @param array $data
     * @return array
     */
    public function moveHouse($data)
    {
        $checkRes = $this->_checkMoveData($data);

        if(0 !== $checkRes['status'])
        {
            return $checkRes;
        }
        $toRealInfo = $checkRes['info'];
        $where = "realId={$data['fromRealId']} and status=".House::STATUS_OFFLINE;
        $houses = House::find($where);
       
        if($houses)
        {
            $this->begin();
            foreach($houses as $house)
            {
                //修改 house 表经纪人信息
                $house->realId = $toRealInfo['realId'];
                $house->comId = $toRealInfo['comId'];
                $house->shopId = $toRealInfo['shopId'];
                $house->areaId = $toRealInfo['areaId'];
                
                if(!$house->update())
                {
                    $this->rollback();
                    return array('status'=>1, 'info'=>'转移失败');
                }
                //修改ES
                global $sysES;
                $clsEs = new Es($sysES['default']);
                $arrData = array(
                    'realId'      => $house->realId,
                    'comId'       => $house->comId,
                    'areaId'      => $house->areaId,
                    'shopId'      => $house->shopId
                );
                $intFlag = $clsEs->update(array('id' => $house->id, 'data' => $arrData));
                if($intFlag == false)
                {
                    $this->rollback();
                    return array('status'=>1, 'info'=>'转移失败！');
                }
            }
            $this->commit();
            return array('status'=>0, 'info'=>'转移成功');
        }
        else
        {
            return array('status'=>0, 'info'=>'转移成功');
        }              
    }
    
    private function _checkMoveData($data)
    {
        if(empty($data))
        {	
            return false; 	
        }
    	$realIds = array(intval($data['fromRealId']), intval($data['toRealId']));
    	
    	//获取信息
        $realInfos = $this->getRealtorByIds($realIds, 'cityId,id,status,comId,areaId,shopId');
    	$arrFrom = array();
    	$arrTo = array();
    	if(!empty($realInfos) && count($realInfos) == 2)
    	{
            $arrFrom = $realInfos[$data['fromRealId']];
            $arrTo = $realInfos[$data['toRealId']];

    		if($arrFrom['cityId'] != $arrTo['cityId'])
    		{
                return array('status'=>1, 'info'=>'禁止跨城市转移房源经纪人');
    		}    	
    		if(in_array($arrFrom['status'], array(self::STATUS_OPEN)))
    		{
    			//非启用的，非免费版，非休眠的经纪人可以转移房源
                return array('status'=>1, 'info'=>'已启用经纪人禁止转移房源');
    		}    		

    		$arrResult = array(
    			'realId'		=>	$arrTo['id'],
    			'cityId'		=>	$arrTo['cityId'],
	    		'comId'         =>	$arrTo['comId'],
	    		'areaId'		=>	$arrTo['areaId'],
	    		'shopId'		=>	$arrTo['shopId'],
    		);
    		unset($arrFrom, $arrTo, $realInfos);
  
    		return array('status'=>0, 'info'=>$arrResult);
        }
        else
        {
            return array('status'=>1, 'info'=>'经纪人参数错误');
        }
    }
    
    /**
     * 批量注册经纪人
     * @param array $data
     * @return array
     */
    public function regRealtorByBatch($data)
    {
        if(empty($data))
        {
            return array('status'=>1);
        }

        $this->begin();
        foreach($data as $v)
        {
            $realData = array(
                'shopId'        => intval($v['shopId']),
                'comId'         => intval($v['comId']),
                'regId'         => intval($v['regId']),
                'distId'        => intval($v['distId']),
                'cityId'        => intval($v['cityId']),
                'name'          => $v['realName'],
                'mobile'        => $v['realMobile'],
                'certification' => self::CERTI_NO,
                'status'        => self::STATUS_STOP,
                'type'          => self::TYPE_COMPANY,
                'create'        => date('Y-m-d H:i:s')
            );

            //添加到 realtor 表中
            $this->id = null;
            $realRes = $this->create($realData);
            if(!$realRes)
            {
                $this->rollback();
                return array('status'=>1);
            }
           
            $realId = $this->id;
            
            $accountData = array(
                'name'     => $v['realAccount'],
                'password' => sha1(md5($v['pwd'])),
                'to'       => VipAccount::ROLE_REALTOR,
                'toId'     => $realId,
                'status'   => VipAccount::STATUS_VALID,
                'update' => date('Y-m-d H:i:s')
            );
            
            //添加到账号表 vip_account 中
            $accountObj = VipAccount::instance();
            $accountObj->id = null;
            $accountRes = $accountObj->create($accountData);
            if(!$accountRes)
            {
                $this->rollback();
                return array('status'=>1);
            }
        }
        
        $this->commit();
        return array('status'=>0);
    }
}
