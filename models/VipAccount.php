<?php
use \Phalcon\Db\Column;

class VipAccount extends BaseModel
{
	/**
	 * 帐号状态
	 * 1.有效	2.删除	3.无效
	 *
	 */
	const STATUS_VALID = 1;
	const STATUS_DELETE  = 2;
	const STATUS_INVALID = 3;
	/**
	 * 帐号类型
	 * 1.公司	3.区域	5.门店	7.经纪人
	 *
	 */
    const ROLE_COMPANY = 1;
	const ROLE_AREA = 3;
	const ROLE_SHOP = 5;
	const ROLE_REALTOR = 7;

    public $id;
    public $name;
    public $password;
    public $to;
    public $toId;
    public $toIds = '';
    public $loginCount = 0;
    public $loginTime;
    public $signCount;
    public $signTime;
    public $totalIntegral = 0;
    public $costIntegral = 0;
    public $saleRefresh = 0;
    public $rentRefresh = 0;
    public $saleTags = 0;
    public $rentTags = 0;
    public $status;
    public $update;
	/**
	 * 定义错误描述全局变量
	 *
	 */
	private $mError;

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

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        if($password == '' || mb_strlen($password, 'utf8') > 50)
        {
            return false;
        }
        $this->password = $password;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function setTo($to)
    {
        if(preg_match('/^\d{1,3}$/', $to == 0) || $to > 255)
        {
            return false;
        }
        $this->to = $to;
    }

    public function getToId()
    {
        return $this->toId;
    }

    public function setToId($toId)
    {
        if(preg_match('/^\d{1,10}$/', $toId == 0) || $toId > 4294967295)
        {
            return false;
        }
        $this->toId = $toId;
    }

    public function getToIds()
    {
        return $this->toIds;
    }

    public function setToIds($toIds)
    {
        if($toIds == '' || mb_strlen($toIds, 'utf8') > 150)
        {
            return false;
        }
        $this->toIds = $toIds;
    }

    public function getLoginCount()
    {
        return $this->loginCount;
    }

    public function setLoginCount($loginCount)
    {
        if(preg_match('/^\d{1,10}$/', $loginCount == 0) || $loginCount > 4294967295)
        {
            return false;
        }
        $this->loginCount = $loginCount;
    }

    public function getLoginTime()
    {
        return $this->loginTime;
    }

    public function setLoginTime($loginTime)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $loginTime) == 0 || strtotime($loginTime) == false)
        {
            return false;
        }
        $this->loginTime = $loginTime;
    }
    
    public function getSignCount()
    {
    	return $this->signCount;
    }
    
    public function setSignCount($signCount)
    {
    	if(preg_match('/^\d{1,10}$/', $signCount == 0) || $signCount > 4294967295)
    	{
    		return false;
    	}
    	$this->signCount = $signCount;
    }
    
    public function getSignTime()
    {
    	return $this->signTime;
    }
    
    public function setSignTime($signTime)
    {
    	if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $signTime) == 0 || strtotime($signTime) == false)
    	{
    		return false;
    	}
    	$this->signTime = $signTime;
    }
    
    public function getTotalIntegral()
    {
    	return $this->totalIntegral;
    }
    
    public function setTotalIntegral($TotalIntegral)
    {
    	if(preg_match('/^\d{1,10}$/', $TotalIntegral == 0) || $TotalIntegral > 4294967295)
    	{
    		return false;
    	}
    	$this->totalIntegral = $TotalIntegral;
    }
    
    public function getCostIntegral()
    {
    	return $this->costIntegral;
    }
    
    public function setCostIntegral($CostIntegral)
    {
    	if(preg_match('/^\d{1,10}$/', $CostIntegral == 0) || $CostIntegral > 4294967295)
    	{
    		return false;
    	}
    	$this->costIntegral = $CostIntegral;
    }

    public function getSaleRefresh()
    {
    	return $this->saleRefresh;
    }
    
    public function setSaleRefresh($saleRefresh)
    {
    	if(preg_match('/^\d{1,3}$/', $saleRefresh == 0) || $saleRefresh > 255)
    	{
    		return false;
    	}
    	$this->saleRefresh = $saleRefresh;
    }

    public function getRentRefresh()
    {
    	return $this->rentRefresh;
    }
    
    public function setRentRefresh($rentRefresh)
    {
    	if(preg_match('/^\d{1,3}$/', $rentRefresh == 0) || $rentRefresh > 255)
    	{
    		return false;
    	}
    	$this->rentRefresh = $rentRefresh;
    }

    public function getSaleTags()
    {
    	return $this->saleTags;
    }
    
    public function setSaleTags($saleTags)
    {
    	if(preg_match('/^\d{1,5}$/', $saleTags == 0) || $saleTags > 65535)
    	{
    		return false;
    	}
    	$this->saleTags = $saleTags;
    }

    public function getRentTags()
    {
    	return $this->rentTags;
    }
    
    public function setRentTags($rentTags)
    {
    	if(preg_match('/^\d{1,5}$/', $rentTags == 0) || $rentTags > 65535)
    	{
    		return false;
    	}
    	$this->rentTags = $rentTags;
    }
    
    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        if(preg_match('/^-?\d{1,4}$/', $status) == 0 || $status > 127 || $status < -128)
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
        return 'vip_account';
    }

    public function columnMap()
    {
        return array(
            'vaId' => 'id',
            'vaName' => 'name',
            'vaPassword' => 'password',
            'vaTo' => 'to',
            'vaToId' => 'toId',
            'vaToIds' => 'toIds',
            'vaLoginCount' => 'loginCount',
            'vaLoginTime' => 'loginTime',
            'vaSignCount' => 'signCount',
            'vaSignTime' => 'signTime',
            'vaTotalIntegral' => 'totalIntegral',
            'vaCostIntegral' => 'costIntegral',
        	'vaSaleRefresh'	=> 'saleRefresh',
        	'vaRentRefresh' => 	'rentRefresh',
        	'vaSaleTags' => 'saleTags',
        	'vaRentTags' => 'rentTags',
            'vaStatus' => 'status',
            'vaUpdate' => 'update'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
	
	/**
	 * 检查帐号是否存在
	 *
     * @param str $name
	 * @return bool
	 */
	public function isExistAccount($name) {
		if ( empty($name) ) {
			return false;
		}
		$arrCond  = "name = ?1";
		$arrParam = array(1 => $name);
		$arrAccount = self::findFirst(array(
			$arrCond,
			"bind" => $arrParam
		));
		if ( empty($arrAccount) ) {
			return false;
		}
		//状态不为删除状态的帐号一律视为已存在
		if ( $arrAccount->status == SCEntAccont::STATUS_DELETE ) {
			return false;
		}
		return true;
	}
	
	/**
	 * 加载指定帐号信息
	 *
     * @param str $name
	 * @return object
	 */
	public function getAccountByAccName($name) {
		if ( empty($name) ) {
			return false;
		}
		$arrCond  = "name = ?1";
		$arrParam = array(1 => $name);
		$arrRes   = self::findFirst(array(
			$arrCond,
			"bind" => $arrParam
		));
		return $arrRes;
	}
	
	/**
	 * 根据公司、区域、门店或经纪人的ID获取指定帐号信息
	 *
     * @param int $to
     * @param int $toId
	 * @return object
	 */
	public function getAccountByToId($to, $toId) 
	{
		if ( empty($to) || empty($toId)) 
		{
			return false;
		}
		$arrCond  = "to = ?1 AND toId = ?2";
		$arrParam = array(1 => $to, 2 => $toId);
		$arrRes   = self::findFirst(array(
			$arrCond,
			"bind" => $arrParam
		));
		return $arrRes;
	}
	
	/**
	 * 创建帐号
	 *
	 * @param string $name 帐号
	 * @param string $password 密码
	 * @param int $toId 帐号类型
	 * @param int $to 帐号id
	 * @param int $status 帐号状态
	 * @return bool 成功返回InsertId，失败返回false
	 */
	public function creatVipAccount($name, $password, $toId, $to, $status) {
		$arrInsert['name'] = $name;
		$arrInsert['password'] = $password;
		$arrInsert['toId'] = $toId;
		$arrInsert['to'] = $to;
		$arrInsert['status'] = $status;
		$arrInsert['update'] = date('Y-m-d H:i:s', time());
		$this->create($arrInsert);
		$intInsertId = $this->insertId();
		if ( $intInsertId <= 0 ) {
			return false;
		}
		return $intInsertId;
	}

	/**
	 * 修改经纪人APP登录信息
	 * @param unknown $intRealID
	 * @param unknown $arrData
	 */
	public function modifyAppSign( $intRealID, $arrData )
	{
		if( empty($intRealID) || empty($arrData) )	return false;
		
		$arrUpdate = array();
		if( isset($arrData['signTime']) )
		{
			$arrUpdate['signTime']	=	$arrData['signTime'];
		}
		
		if( isset($arrData['signCount']) )
		{
			$arrUpdate['signCount']	=	$arrData['signCount'];
		}
		
		$objVipAccount = self::findFirst("toId = {$intRealID}");
		$objVipAccount->signTime	=	$arrData['signTime'];
		$objVipAccount->signCount	=	$arrData['signCount'];
		return $objVipAccount->update();
	}


    /**
     * 根据用户名,账号类型，账号状态 加载，获取账号信息
     * @auth  jackchen
     * @param string $name
     * @param int $status
     * @return array
     */
    public function getAccountByStatus($name,$status) {
        if ( empty($name) || empty($status) ) {
            return false;
        }
        $arrCond  = "name = ?1 and status = ?2 and to = 7";
        $arrParam = array(1 => $name,2=>$status);
        $arrRes   = self::findFirst(array(
            $arrCond,
            "bind" => $arrParam
        ),0);
        return $arrRes;
    }


    /**
     * 修改账号密码 -经纪人
     * @auth  jackchen
     * @param int $toId
     * @param string  $pwd
     * @return array
     */
    public function modifyRealtorPwd($toId,$pwd)
    {
        if(empty($toId)){
            return false;
        }
        $arrCond  = "toId = ?1  and to =7";
        $arrParam = array(1=>$toId);
        $objvip =  self::findFirst(
            array(
                $arrCond,
                "bind" => $arrParam
            )
        );
        $objvip->password = $pwd;
        $intFlag = $objvip->update();
        if( !$intFlag )
        {
            return false;
        }
        return $intFlag;
    }

    /**
     * @abstract 批量获取账号信息
     * @param int        $to 
     * @param array|int  $toIds 
     * @param string     $columns
     * @return array
     * 
     */
	public function getAccountByToIds($to, $toIds, $columns = '')
	{
		if(empty($toIds)) 
            return array();
		if(is_array($toIds))
		{
			$arrBind = $this->bindManyParams($toIds);
			$arrCond = "toId in({$arrBind['cond']}) and to={$to} and status=".self::STATUS_VALID;
			$arrParam = $arrBind['param'];
            $condition = array(
					$arrCond,
					"bind" => $arrParam,
			);           
		}
		else
		{
            $condition = array(
                'conditions' => "toId={$toIds} and to={$to} and status=".self::STATUS_VALID
            );
		}
        $columns && $condition['columns'] = $columns;
        $arrAccount  = self::find($condition, 0)->toArray();
		$arrRaccount = array();
		foreach($arrAccount as $value)
		{
			$arrRaccount[$value['toId']] = $value;
		}
		return $arrRaccount;
	}
    
    /**
     * 实例化对象
     *
     * @param type $cache            
     * @return \Users_Model
     */
    public static function instance ($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self();
    }

    /**
     * 修改账号密码 -区域账号
     * @param int $toId
     * @param string  $pwd
     * @return array
     */
    public function modifyAreaPwd($toId,$pwd)
    {
        if(empty($toId)){
            return false;
        }
        $arrCond  = "toId = ?1  and to =".self::ROLE_AREA;
        $arrParam = array(1=>$toId);
        $objvip =  self::findFirst(
            array(
                $arrCond,
                "bind" => $arrParam
            )
        );
        $objvip->password = $pwd;
        $intFlag = $objvip->update();
        if( !$intFlag )
        {
            return false;
        }
        return $intFlag;
    }
    
    /**
     * 检验企业帐号信息
     * @param array $arrEnterprise 企业帐号信息
     * @return false or true;
     */
    public function checkVipAccountInfo($arrEnterprise){
    	//检验传参
    	if( empty($arrEnterprise) || !is_array($arrEnterprise)  ){
    		$this -> error('传参错误');
    		return false;
    	}
    	//检验企业登录帐号ent_accname
    	if( !isset( $arrEnterprise['name']) || empty($arrEnterprise['name']) || strlen($arrEnterprise['name'])>50 ){
    		$this -> error('企业登录帐号输入错误');
    		return false;
    	}
    	//检验企业登录密码passwd
    	if( !isset( $arrEnterprise['password']) || empty($arrEnterprise['password']) || strlen($arrEnterprise['password'])>50 ){
    		$this -> error('企业登录密码输入错误');
    		return false;
    	}
    	//检验企业类型ent_type
    	if( !isset($arrEnterprise['to']) || !is_integer($arrEnterprise['to']) ){
    		$this -> error('企业类型错误');
    		return false;
    	}
    	//检验企业最后登录时间lastlogintime
    	if( !isset( $arrEnterprise['loginTime']) ||  empty($arrEnterprise['loginTime']) ){
    		$this -> error('企业最后登录时间错误');
    		return false;
    	}

    	$this -> error('成功');
    	return true;
    }
    
    /**
     * 根据条件获取账号
     * @param string $where
     * @param string $columns
     * @param string $order
     * @param int    $offset
     * @param int    $limit
     * @return array
     */
    public function getAccountByCondition($where, $columns = '', $order = '', $offset = 0, $limit = 0)
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
            $data[$v['toId']] = $v;
        }
        
        return $data;
    }
    
    /**
     * 检测账号是否存在
     * @param int $to
     * @param string $name
     * @return boolean
     */
    public function checkIsExistAccount($to, $name, $toId = 0)
    {
        $where = "name='{$name}' and status=".self::STATUS_VALID;
        
        if($toId > 0)
        {
            $totalNum = self::count($where);
            $to > 0 && $where .= " and to={$to}";
            $where .= " and toId={$toId}";
            $selfNum = self::count($where);
            
            $accountNum = $totalNum - $selfNum;
        }
        else
        {
            $to > 0 && $where .= " and to={$to}";
            $accountNum = self::count($where);
        }
           
        return $accountNum > 0 ? true : false;
    }

    /*
     * 修改经纪人积分
     * */
    public  function  updateRealtorScore($toId, $score, $type=3, $to=self::ROLE_REALTOR){

        $rs = $this->findFirst("toId = $toId AND to = $to");
        if($rs){
            if($type == VipScoreDetail::SORT_ADD){
                $rs->totalIntegral = $rs->totalIntegral + $score;
            }else{
                $rs->totalIntegral = $rs->totalIntegral - $score;
            }
            return $rs->update();
        }
        return false;
    }
}
