<?php

class CmsUser extends BaseModel
{
    protected $id;
    protected $email;
    protected $name;
    protected $tel;
    protected $cityId;
    protected $roleId;
    protected $photoId = 0;
    protected $photoExt = '';
    protected $status = self::STATUS_ENABLED;
    protected $addTime;
    
    //用户状态
    const STATUS_ENABLED  = 1;    //有效
    const STATUS_DISABLED = 0;    //无效
    const STATUS_DELETE   = -1;   //删除
    
    /**
     * 登陆验证
     * @return string
     */
    public function checkLogin() 
    {
        if (PHP_SAPI === 'cli') 
        {
            return false;
        } 
        //取得nginx头部信息	    
        $passport_userid = isset($_SERVER['HTTP_X_SOHUPASSPORT_USERID']) ? $_SERVER['HTTP_X_SOHUPASSPORT_USERID'] : '';
        if(!preg_match("/(.+)@(.+)$/", $passport_userid, $passport_info)) 
        {
           return false;
        }		

        return $passport_userid;
    }
    
    /**
     * 修改用户信息
     * @param int   $userId
     * @param array $data
     * @return boolean
     */
    public function updateUser($userId, $data)
    {
        $userId = intval($userId);
        if(!$userId || empty($data))
        {
            return false;
        }
        $rs = self::findFirst("id={$userId} and status=".self::STATUS_ENABLED);
        if(!$rs)
        {
            return false;
        }
        foreach($data as $k=>$v)
        {
            $rs->$k = $v;
        }
        
        return $rs->update() ? true : false;
    }
    
    /**
     * 添加用户
     * @param array $data
     * @return array
     */
    public function add($data)
    {
        if(empty($data))
        {
            return array('status'=>1, 'info'=>'参数为空！');
        }
        if($this->isExistUserEmail($data["email"]))
        {
            return array('status'=>1, 'info'=>'邮箱已经存在！');
        }
        $rs = self::instance();
        $rs->email = $data["email"];
        $rs->name = $data["name"];
        $rs->tel = $data["tel"];  
        $rs->cityId = $data["cityId"];
        $rs->roleId = $data["roleId"];
        $rs->addTime = time();
        
        if($rs->create())
        {
            return array('status'=>0, 'info'=>'添加用户成功！');
        }
        return array('status'=>1, 'info'=>'添加用户失败！');
    }
    
    /**
     * 修改用户
     * @param array $data
     * @return array
     */
    public function edit($userId, $data)
    {
        $userId = intval($userId);
        if(empty($data) || $userId < 1)
        {
            return array('status'=>1, 'info'=>'参数为空！');
        }
        if($this->isExistUserEmail($data["email"], $userId))
        {
            return array('status'=>1, 'info'=>'邮箱已经存在！');
        }
        $rs = self::findFirst("id={$userId} and status=".self::STATUS_ENABLED);
        if(!$rs)
        {
            return array('status'=>1, 'info'=>'用户不存在或无效！');
        }
        $rs->email = $data["email"];
        $rs->name = $data["name"];
        $rs->tel = $data["tel"];  
        $rs->cityId = $data["cityId"];
        $rs->roleId = $data["roleId"];
        
        if($rs->update())
        {
            return array('status'=>0, 'info'=>'修改用户成功！');
        }
        return array('status'=>1, 'info'=>'修改用户失败！');
    }
    
    /**
     * 删除用户
     * @param array $userIds
     * @return boolean
     */
    public function deleteByUserId($userIds = array())
    {
        if(empty($userIds))
        {
            return false;
        }
        $id = implode(',', $userIds);
        $rs = self::find("id in({$id})");
        if(!$rs)
        {
            return false;
        }
        $this->begin();
        foreach($rs as $v)
        {
            $v->status = self::STATUS_DELETE;
            if(!$v->update())
            {
                $this->rollback();
                return false;
            }
        }
        $this->commit();
        return true;
    }

    private function isExistUserEmail($email, $userId=0)
    {
        $email = trim($email);
        if(empty($email))
        {
            return true;
        }
        $con['conditions'] = "email='{$email}'";
        $userId > 0 && $con['conditions'] .= " and id<>{$userId}";

        $intCount = self::count($con);
        if($intCount > 0)
        {
            return true;
        }
        return false;
    }
    
    public function setUserid($userId)
    {
        $this->id = $userId;
    }

    public function setUseremail($userEmail)
    {
        $this->email = $userEmail;
    }

    public function setUsername($userName)
    {
        $this->name = $userName;
    }

    public function setUsertel($userTel)
    {
        $this->tel = $userTel;
    }

    public function setCityid($cityId)
    {
        $this->cityId = $cityId;
    }

    public function setRoleid($roleId)
    {
        $this->roleId = $roleId;
    }

    public function setUserphotoid($userPhotoId)
    {
        $this->photoId = $userPhotoId;
    }

    public function setUserphotoext($userPhotoExt)
    {
        $this->photoExt = $userPhotoExt;
    }

    public function setUserstatus($userStatus)
    {
        $this->status = $userStatus;
    }

    public function setUseraddtime($userAddTime)
    {
        $this->addTime = $userAddTime;
    }

    public function getUserid()
    {
        return $this->id;
    }

    public function getUseremail()
    {
        return $this->email;
    }

    public function getUsername()
    {
        return $this->name;
    }

    public function getUsertel()
    {
        return $this->tel;
    }

    public function getCityid()
    {
        return $this->cityId;
    }

    public function getRoleid()
    {
        return $this->roleId;
    }

    public function getUserphotoid()
    {
        return $this->photoId;
    }

    public function getUserphotoext()
    {
        return $this->photoExt;
    }

    public function getUserstatus()
    {
        return $this->status;
    }

    public function getUseraddtime()
    {
        return $this->addTime;
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'userId'       => 'id', 
            'userEmail'    => 'email', 
            'userName'     => 'name', 
            'userTel'      => 'tel', 
            'cityId'       => 'cityId', 
            'roleId'       => 'roleId', 
            'userPhotoId'  => 'photoId', 
            'userPhotoExt' => 'photoExt', 
            'userStatus'   => 'status', 
            'userAddTime'  => 'addTime'
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
     * @return CmsUser_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
}
