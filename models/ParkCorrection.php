<?php
class ParkCorrection extends BaseModel
{
    protected $id;
    protected $parkId;
    protected $userType;
    protected $user;
    protected $propertyCompany;
    protected $developer;
    protected $fee;
    protected $FAR;
    protected $GR;
    protected $oldRate;
    protected $rentRate;
    protected $houses;
    protected $pRemark;
    protected $pMessage;
    protected $buildYear;
    protected $facility;
    protected $pCount;
    protected $status;
    protected $updatetime;
    protected $audit;
    protected $updateField;//更新字段，仅供前台显示
    
    //userType
    const TYPE_REALTOR = 1; // 经纪人
    const TYPE_PERSONAL = 2; // 个人

    //status
    const STATUS_VERING = 0; // 未审核
    const STATUS_VEREND = 1; // 审核通过

    
    protected static $Statuses=array(
        self::STATUS_VERING => "未审核",
        self::STATUS_VEREND => "已审核",
    );
    public static function getStatuses()
    {
        return self::$Statuses;
    }
    
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

    public function getUserType()
    {
        return $this->userType;
    }

    public function setUserType($userType)
    {
        if(preg_match('/^\d{1,3}$/', $userType == 0) || $userType > 255)
        {
            return false;
        }
        $this->userType = $userType;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        if($user == '' || mb_strlen($user, 'utf8') > 50)
        {
            return false;
        }
        $this->user = $user;
    }

    public function getPropertyCompany()
    {
        return $this->propertyCompany;
    }

    public function setPropertyCompany($propertyCompany)
    {
        if($propertyCompany == '' || mb_strlen($propertyCompany, 'utf8') > 50)
        {
            return false;
        }
        $this->propertyCompany = $propertyCompany;
    }

    public function getDeveloper()
    {
        return $this->developer;
    }

    public function setDeveloper($developer)
    {
        if($developer == '' || mb_strlen($developer, 'utf8') > 50)
        {
            return false;
        }
        $this->developer = $developer;
    }

    public function getFee()
    {
        return $this->fee;
    }

    public function setFee($fee)
    {
        if($fee == '' || mb_strlen($fee, 'utf8') > 20)
        {
            return false;
        }
        $this->fee = $fee;
    }

    public function getFAR()
    {
        return $this->FAR;
    }

    public function setFAR($FAR)
    {
        if($FAR == '' || mb_strlen($FAR, 'utf8') > 20)
        {
            return false;
        }
        $this->FAR = $FAR;
    }

    public function getGR()
    {
        return $this->GR;
    }

    public function setGR($GR)
    {
        if($GR == '' || mb_strlen($GR, 'utf8') > 20)
        {
            return false;
        }
        $this->GR = $GR;
    }

    public function getOldRate()
    {
        return $this->oldRate;
    }

    public function setOldRate($oldRate)
    {
        if(preg_match('/^\d{1,3}$/', $oldRate == 0) || $oldRate > 255)
        {
            return false;
        }
        $this->oldRate = $oldRate;
    }

    public function getRentRate()
    {
        return $this->rentRate;
    }

    public function setRentRate($rentRate)
    {
        if(preg_match('/^\d{1,3}$/', $rentRate == 0) || $rentRate > 255)
        {
            return false;
        }
        $this->rentRate = $rentRate;
    }

    public function getHouses()
    {
        return $this->houses;
    }

    public function setHouses($houses)
    {
        if(preg_match('/^\d{1,5}$/', $houses == 0) || $houses > 65535)
        {
            return false;
        }
        $this->houses = $houses;
    }

    public function getPCount()
    {
        return $this->pCount;
    }

    public function setPCount($pCount)
    {
        if(preg_match('/^\d{1,5}$/', $pCount == 0) || $pCount > 65535)
        {
            return false;
        }
        $this->pCount = $pCount;
    }

    public function getPRemark()
    {
        return $this->pRemark;
    }

    public function setPRemark($pRemark)
    {
        if($pRemark == '' || mb_strlen($pRemark, 'utf8') > 50)
        {
            return false;
        }
        $this->pRemark = $pRemark;
    }

    public function getBuildYear()
    {
        return $this->buildYear;
    }

    public function setBuildYear($buildYear)
    {
        $this->buildYear = $buildYear;
    }

    public function getFacility()
    {
        return $this->facility;
    }

    public function setFacility($facility)
    {
        if($facility == '' || mb_strlen($facility, 'utf8') > 200)
        {
            return false;
        }
        $this->facility = $facility;
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

    public function getAudit()
    {
        return $this->audit;
    }

    public function setAudit($audit)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $audit) == 0 || strtotime($audit) == false)
        {
            return false;
        }
        $this->audit = $audit;
    }

    public function getSource()
    {
        return 'park_correction';
    }

    public function columnMap()
    {
        return array(
            'pcId' => 'id',
            'parkId' => 'parkId',
            'pcUserType' => 'userType',
            'pcUser' => 'user',
            'pcPropertyCompany' => 'propertyCompany',
            'pcDeveloper' => 'developer',
            'pcFee' => 'fee',
            'pcFAR' => 'FAR',
            'pcGR' => 'GR',
            'pcOldRate' => 'oldRate',
            'pcRentRate' => 'rentRate',
            'pcHouses' => 'houses',
            'pcPCount' => 'pCount',
            'pcPRemark' => 'pRemark',
            'pcBuildYear' => 'buildYear',
            'pcFacility' => 'facility',
            'pcStatus' => 'status',
            'pcUpdate' => 'updatetime',
            'pcAudit' => 'audit',
        	'pcUpdateField' => 'updateField',
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
     * @return Park_Model
     */
    
    public static function instance($cache = true)
    {
    	return parent::_instance(__CLASS__, $cache);
    	return new self;
    }
    
    /**
     * @abstract 根据相关条件获取纠错信息 按照纠错时间倒序
     * @author Eric xuminwan@sohu-inc.com
     * @param string $strCondition
     * @return array 
     * 
     */
    public function getLatestByCondition($strCondition)
    {
    	if(!$strCondition) return array();
    	$arrInfo = self::findFirst(array(
    			$strCondition,
    			'orderBy' => 'update desc',
    	));
    	if($arrInfo){
    		return $arrInfo->toArray();
    	}else{
    		return false;
    	}
    }
    
    /**
     * @abstract 获取小区的纠错日志 按照纠错时间倒序
     * @author Eric xuminwan@sohu-inc.com
     * @param string $strCondition
     * @return array
     *
     */
    public function getUpdateLogByCondition($strCondition)
    {
    	if(!$strCondition) return array();
    	$arrInfo = self::find(array(
    			$strCondition,
    			'orderBy' => 'update desc',
    	));
    	if($arrInfo){
    		return $arrInfo->toArray();
    	}else{
    		return false;
    	}
    }
    
    /**
     * @abstract 插入小区纠错信息 
     * @author Eric xuminwan@sohu-inc.com
     * @param array $data
     * @return bool
     * 
     */
    public function InsertParkCorrInfo($data)
    {
    	if(!$data) return false;
    	$parkCorr = self::instance();
    	$parkCorr->parkId = $data['parkId'];
    	$parkCorr->userType = $data['userType'];
    	$parkCorr->user = $data['user'];
    	$parkCorr->propertyCompany = $data['propertyCompany'];
    	$parkCorr->developer = $data['developer'];
    	$parkCorr->fee = intval($data['fee']);
    	$parkCorr->FAR = intval($data['FAR']);
    	$parkCorr->GR = intval($data['GR']);
    	$parkCorr->oldRate = intval($data['oldPeople']);
    	$parkCorr->rentRate = intval($data['rentPeople']);
    	$parkCorr->houses = intval($data['houses']);
    	$parkCorr->pCount = intval($data['pCount']);
    	$parkCorr->pRemark = $data['pMessage'];
    	$parkCorr->facility = $data['facility'];
    	$parkCorr->buildYear = $data['buildYear'];
    	$parkCorr->status = $data['status'];
    	$parkCorr->updatetime = $data['update'];
    	$parkCorr->updateField = $data['updateField'];
    	if($parkCorr->create())
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }
    
    public function getParkcorrectList($strCondition,$pagesize,$offset)
    {
        
        $sql ="SELECT park_correction.*,park.cityId,park.parkName FROM park_correction  LEFT JOIN park ON park.parkId = park_correction.parkId WHERE $strCondition order by park_correction.pcUpdate asc limit $offset,$pagesize ";
        $result["list"]=$this->fetchAll($sql);
        
         $sql2="SELECT count(*) as total FROM park_correction  LEFT JOIN park ON park.parkId = park_correction.parkId WHERE $strCondition";
         $total=$this->fetchOne($sql2);
         $result["total"] = $total["total"];
         return $result;
    }
    
    public function del($id)
    {
        $rs = self::findFirst($id);
        if ($rs->delete()) {
            return array('status'=>0,'info'=>'删除成功');
        }
        return array('status'=>1,'info'=>'删除失败');
    }
    public function updateStatus($id)
    {
        $rs = self::findFirst($id);

        $rs->status=  self::STATUS_VEREND;
        $rs->audit=   date('Y-m-d H:i:s');
        if($rs->update())
        {
            return array('status'=>0,'info'=>'跟新成功');
        }
        return array('status'=>1,'info'=>'跟新失败');
        
    }
}