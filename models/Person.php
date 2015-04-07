<?php
class Person extends BaseModel
{
    
    protected $id;
    protected $password;
    protected $name;
    protected $email = '';
    protected $emailStatus = self::BIND_EMAIL_NOT;
    protected $mobile = '';
    protected $mobileStatus = self::BIND_MOBILE_NOT;
    protected $QQ = '';
    protected $contactWay = '';
    protected $createTime;
    protected $loginIp = '';
    protected $loginTime;
    protected $loginNum = 0;
    protected $isWhiteList = self::NOT_WHITE_LIST;
    protected $status = self::STATUS_VALID;
    
    //登录账号类型
    const ROLE_PERSON = 6;
    
    //is_email_bind
    const BIND_EMAIL_NOT = 0;
    const BIND_EMAIL_YES = 1;
    //is_phone_bind
    const BIND_MOBILE_NOT = 0;
    const BIND_MOBILE_YES = 1;
    
    //绑定手机成功标志值 记录memcache中
    const PERSON_BIND_PHONE_IS_SUCCEED = 1;
    const PERSON_BIND_PHONE_NOT_SUCCEED = 0;
    
    //绑定手机信息存放时间（memcache中）
    const PERSONINFO_BIND_PHONE_MEMCACHE_TIME = 3600;//1小时
    //绑定手机 手机号存放时间（memcache中）
    const PERSON_BIND_PHONE_VAL_MEMCACHE_TIME = 3600;
    
    //is_white_list  是否是白名单
    const IS_WHITE_LIST = 1;
    const NOT_WHITE_LIST = 0;
    
    //用户状态
    const STATUS_VALID = 1;//可用
    const STATUS_INVALID = 0;//不可用

    public function getSource()
    {
        return 'web_user';
    }

    public function columnMap()
    {
        return array(
            'wbId' => 'id',
        	'wbPwd' => 'password',
            'wbUser' => 'name',
            'wbEmail' => 'email',
            'wbEmailBinding' => 'emailStatus',
            'wbPhone' => 'mobile',
            'wbPhoneBinding' => 'mobileStatus',
            'wbQQ' => 'QQ',
        	'wbContactOnline' => 'contactWay',
        	'wbCreate' => 'createTime',
        	'wbLoginIP' => 'loginIp',
        	'wbLoginTime' => 'loginTime',
        	'wbLoginNum' => 'loginNum',
            'wbIsWhite' => 'isWhiteList',
        	'wbStatus' => 'status',
        	'wbUpdate' => 'wbUpdate',
        );
    }

    /**
     * 实例化
     * @param type $cache
     * @return Person_Model
     */
    
    public static function instance($cache = true)
    {
    	return parent::_instance(__CLASS__, $cache);
    	return new self;
    }
    
    
    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    
    /**
     * @abstract 根据条件获取个人信息 
     * @author Eric xuminwan@sohu-inc.com
     * @param string $strCondition
     * @return array
     */
    public function getPersonByCondition($strCondition)
    {
    	if(!$strCondition) return array();
    	$arrPerson = self::find(array($strCondition),0)->toArray();
    	return $arrPerson;
    }
    
	/**
     * @abstract 获取个人信息 BY ID
     * @author Eric xuminwan@sohu-inc.com
     * @param int $id
     * @return array
     */
    public function getPersonById($id)
    {
    	if(!$id) return array();
    	$strCondition = "id = ?1";
    	$arrParam = array('1'=>$id);
    	$arrPerson = self::findFirst(array($strCondition,'bind'=>$arrParam),0)->toArray();
    	return $arrPerson;
    }

    /**
     * @abstract 根据个人Id更新信息
     * @author Eric xuminwan@sohu-inc.com
     * @param int $intPersonId 
     * @param array $arrUpdate
     * @return bool
     * 
     */
    public function updatePersonInfoById($intPersonId,$arrUpdate)
    {
    	if(!($intPersonId && $arrUpdate)) return false;
    	$arrCond  = "id = ?1  ";
    	$arrParam = array(1=>$intPersonId);
    	$objPerson =  self::findFirst(
    			array(
    					$arrCond,
    					"bind" => $arrParam
    			)
    	);
    	$objPerson->name =isset($arrUpdate['name']) ? $arrUpdate['name'] : '' ;
    	$objPerson->password = isset($arrUpdate['password']) ? $arrUpdate['password'] : 0;
    	$objPerson->loginTime = isset($arrUpdate['loginTime']) ? $arrUpdate['loginTime'] : 0;
    	$intFlag = $objPerson->update();
    	if( !$intFlag )
    	{
    		return false;
    	}
    	return $intFlag;
    }
    
    /**
     * @abstract 插入个人信息 BY passport 
     * @author Eric xuminwan@sohu-inc.com
     * @param array $data
     * @return int $personId
     * 
     */
    public function insertPersonByPassport($data)
    {
    	$name = $data['name'];
    	if(empty($data) || !$name)
    	{
    		return false;
    	}
    	$rs = self::instance();
    	$rs->password = $data['password'];
    	$rs->name = $data["name"];
    	$rs->createTime = $data["createTime"];
    	$rs->loginTime = time();
    	$rs->status = $data['status'];
    	if($rs->create())
    	{
    		return $this->insertId();
    	}
    	else
    	{
    		return false;
    	}
    	
    }
    
    
    
    public function updateInfo($intPersonId,$arrUpdate)
    {
    	if(!($intPersonId && $arrUpdate)) return false;
    	$arrCond  = "id = ?1  ";
    	$arrParam = array(1=>$intPersonId);
    	$objPerson =  self::findFirst(
    			array(
    					$arrCond,
    					"bind" => $arrParam
    			)
    	);
    	if(isset($arrUpdate['name']))
    	{
    		$objPerson->name = $arrUpdate['name'];
    	}
    	if(isset($arrUpdate['password']))
    	{
    		$objPerson->name = $arrUpdate['password'];
    	}
    	if(isset($arrUpdate['email']))
    	{
    		$objPerson->email = $arrUpdate['email'];
    	}
    	if(isset($arrUpdate['emailStatus']))
    	{
    		$objPerson->emailStatus = $arrUpdate['emailStatus'];
    	}
    	if(isset($arrUpdate['mobile']))
    	{
    		$objPerson->mobile = $arrUpdate['mobile'];
    	}
    	if(isset($arrUpdate['mobileStatus']))
    	{
    		$objPerson->mobileStatus = $arrUpdate['mobileStatus'];
    	}
    	if(isset($arrUpdate['contactWay']))
    	{
    		$objPerson->contactWay = $arrUpdate['contactWay'];
    	}
    	if(isset($arrUpdate['loginTime']))
    	{
    		$objPerson->loginTime = $arrUpdate['loginTime'];
    	}
    	$intFlag = $objPerson->update();
    	if( !$intFlag )
    	{
    		return false;
    	}
    	return $intFlag;
    }
    

}