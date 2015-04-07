<?php
class HouseOwner extends BaseModel
{
    protected $id;
    protected $personId;
    protected $cityId;
    protected $name;
    protected $gender = 0;
    protected $mobile;
    protected $mobileIsPublic = 1;
    protected $tel = '';
    protected $weixin = '';
    protected $qQ = '';
    protected $account = 0;
    protected $password = 0;
    protected $validation = 0;
    protected $status = 1;
    protected $houseOwnerUpdate;
    
    const SHOW_PHONE = 1;//公开手机
    const NO_SHOW_PHONE = 2;//不公开手机
    
    const LIMIT_MAX_AMOUNT = 2;//限制个人用户可发布的房源的最大个数
    //房主状态
    const STATUS_OK = 1;

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
        if($name == '' || mb_strlen($name, 'utf8') > 10)
        {
            return false;
        }
        $this->name = $name;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        if(preg_match('/^\d{1,3}$/', $gender == 0) || $gender > 255)
        {
            return false;
        }
        $this->gender = $gender;
    }

    public function getMobile()
    {
        return $this->mobile;
    }

    public function setMobile($mobile)
    {
        if($mobile == '' || mb_strlen($mobile, 'utf8') > 15)
        {
            return false;
        }
        $this->mobile = $mobile;
    }

    public function getMobileIsPublic()
    {
        return $this->mobileIsPublic;
    }

    public function setMobileIsPublic($mobileIsPublic)
    {
        if(preg_match('/^\d{1,3}$/', $mobileIsPublic == 0) || $mobileIsPublic > 255)
        {
            return false;
        }
        $this->mobileIsPublic = $mobileIsPublic;
    }

    public function getTel()
    {
        return $this->tel;
    }

    public function setTel($tel)
    {
        if($tel == '' || mb_strlen($tel, 'utf8') > 15)
        {
            return false;
        }
        $this->tel = $tel;
    }

    public function getWeixin()
    {
        return $this->weixin;
    }

    public function setWeixin($weixin)
    {
        if($weixin == '' || mb_strlen($weixin, 'utf8') > 30)
        {
            return false;
        }
        $this->weixin = $weixin;
    }

    public function getQQ()
    {
        return $this->qQ;
    }

    public function setQQ($qQ)
    {
        if($qQ == '' || mb_strlen($qQ, 'utf8') > 15)
        {
            return false;
        }
        $this->qQ = $qQ;
    }

    public function getAccount()
    {
        return $this->account;
    }

    public function setAccount($account)
    {
        if($account == '' || mb_strlen($account, 'utf8') > 50)
        {
            return false;
        }
        $this->account = $account;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        if($password == '' || mb_strlen($password, 'utf8') > 32)
        {
            return false;
        }
        $this->password = $password;
    }

    public function getValidation()
    {
        return $this->validation;
    }

    public function setValidation($validation)
    {
        if(preg_match('/^-?\d{1,3}$/', $validation) == 0 || $validation > 127 || $validation < -128)
        {
            return false;
        }
        $this->validation = $validation;
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
        return 'house_owner';
    }

    public function columnMap()
    {
        return array(
            'hoId' => 'id',
        	'personId' => 'personId',
            'cityId' => 'cityId',
            'hoName' => 'name',
            'hoGender' => 'gender',
            'hoMobile' => 'mobile',
            'hoMobileIsPublic' => 'mobileIsPublic',
            'hoTel' => 'tel',
            'hoWeixin' => 'weixin',
            'hoQQ' => 'qQ',
            'hoAccount' => 'account',
            'hoPassword' => 'password',
            'hoValidation' => 'validation',
            'hoStatus' => 'status',
            'hoUpdate' => 'houseOwnerUpdate'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }

    public function getInfoById($id){
        if (!$id) return false;
        $arrCondition['conditions'] = "id=:id: and status = 1";
        $arrCondition['bind'] = array(
            "id"    =>  $id
        );
        return self::findFirst($arrCondition,0)->toArray();
    }
    /**
     * @abstract 根据房主ID批量获取小区信息
     * @author Eric xuminwan@sohu-inc.com
     * @param array $ids
     * @return array|bool
     *
     */
    public function getInfoByIds($ids)
    {
        if(!$ids) return false;
        if(is_array($ids))
        {
            $arrBind = $this->bindManyParams($ids);
            $arrCond = "id in({$arrBind['cond']}) and status = 1";
            $arrParam = $arrBind['param'];
            $arrInfo  = self::find(array(
                $arrCond,
                "bind" => $arrParam
            ),0)->toArray();
            if(is_array($arrInfo)){
                foreach($arrInfo as $value){
                    $result[$value['id']] = $value;
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

    public function getInfoByIdsNoStatus($ids)
    {
        if(!$ids) return false;
        if(is_array($ids))
        {
            $arrBind = $this->bindManyParams($ids);
            $arrCond = "id in({$arrBind['cond']}) ";
            $arrParam = $arrBind['param'];
            $arrInfo  = self::find(array(
                $arrCond,
                "bind" => $arrParam
            ),0)->toArray();
            if(is_array($arrInfo)){
                foreach($arrInfo as $value){
                    $result[$value['id']] = $value;
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
    
    /**
     * @abstract 添加房主信息 
     * @author Eric xuminwan@sohu-inc.com
     * @param array $arrData
     * @return int | bool
     * 
     */
    public function addHouseOwner($arrData)
    {
    	if(!$arrData) return false;
    	$arrInsert = array();
    	//个人ID
    	if(isset($arrData['personId']))
    	{
    		$arrInsert['personId'] = $arrData['personId'];
    	}
    	
    	//城市Id
    	if(isset($arrData['cityId']))
    	{
    		$arrInsert['cityId'] = $arrData['cityId'];
    	}
    	
    	//名字
    	if(isset($arrData['name']))
    	{
    		$arrInsert['name'] = $arrData['name'];
    	}
    	
    	//手机号码
    	if(isset($arrData['mobile']))
    	{
    		$arrInsert['mobile'] = $arrData['mobile'];
    	}
    	
    	//是否公开手机号
    	if(isset($arrData['mobileIsPublic']))
    	{
    		$arrInsert['mobileIsPublic'] = $arrData['mobileIsPublic'];
    	}
    	
    	//QQ
    	if(isset($arrData['qQ']))
    	{
    		$arrInsert['qQ'] = $arrData['qQ'];
    	}
    	
    	$arrInsert['status'] = 1;
		$arrInsert['houseOwnerUpdate'] = date('Y-m-d H:i:s');		//更新时间
		try
		{
			if(self::create($arrInsert))
				return $this->insertId();
			else
				return false;
		}
		catch (Exception $ex)
		{
            echo $ex->getMessage();
			return false;
		}
    }

    /**
     * 实例化
     * @param type $cache
     * @return HouseOwner_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }

    public function editById($ownerId, $arrUpdate){
        if (!$ownerId || !$arrUpdate || !is_array($arrUpdate)) return false;

        $objOwner = self::findfirst("id = ".$ownerId);
        if (!$objOwner) return false;
        return $objOwner->update($arrUpdate);
    }
}