<?php

class CrmUser extends AdminUser {

    /**
     * 实例化对象
     *
     * @param type $cache
     * @return \Users_Model
     */
    public static function instance($cache = true) {
        return BaseModel::_instance(__CLASS__, $cache);
        return new self();
    }

    /**
     * crm登陆验证
     * @param str $email
     * @param str $pass
     * @return array
     */
    public function checkLogin($email, $pass) {
        if (!preg_match("/^[0-9a-zA-Z\_]+@sohu\-inc\.com$/", $email)) {
            $this->rtn['info'] = "用户名不符合要求";
            return false;
        }
        if (strlen($pass) < 6) {
            $this->rtn['info'] = "密码输入错误";
            return false;
        }
        $ds = @ldap_connect("ldap.sohu-inc.com:389");
        if (is_resource($ds) && @ldap_bind($ds, $email, $pass) <> 1) {
            return false;
        }
        return true;
    }

    /**
     * 获取销售个数
     * @param type $con
     * @return type
     */
    public function getSaleUserCount($con = array()) {
        $condition = " 1 ";
        if ($con['user_name'] != "") {
            $name = trim($con['user_name']);
            $condition .= " and name like '%{$name}%'";
        }
        if ($con['cityId'] >0) {
            $cityId = intval($con['cityId']);
            $condition .= " and cityId={$cityId} ";
        }
        if ($con['email'] != "") {
            $email = trim($con['email']);
            $condition .= " and email like '%{$email}%'";
        }
        if ($con['status']>0) {
            $status = intval($con['status']);
            $condition .= " and status = {$status}";
        } 
         $condition .= " and email <> '' ";
        return self::count(array(
                    $condition,
                        )
        );
    }

    /**
     * 获取CRM用户列表
     * @param type $condition  搜索条件
     * @param type $offset
     * @param type $size
     * @param type $order
     * @return type
     */
    public function getSaleUsersList($con = array(), $offset = 0, $size = 20) {
        $condition = " 1 ";
        $size = intval($size);
        $offset = intval($offset);
        if ($con['cityId'] >0) {
            $cityId = intval($con['cityId']);
            $condition .= " and cityId={$cityId} ";
        }
        if ($con['user_name'] != "") {
            $name = trim($con['user_name']);
            $condition .= " and name like '%{$name}%'";
        }
        if ($con['email'] != "") {
            $email = trim($con['email']);
            $condition .= " and email like '%{$email}%'";
        }
        if ($con['status']>0) {
            $status = intval($con['status']);
            $condition .= " and status = {$status}";
        } 
        $condition .= " and email <> '' ";
        $limit = array("number" => $size, "offset" => $offset);

        return self::find(array(
                    $condition,
                    "order" => "status asc,id desc",
                    'limit' => $limit
                ))->toArray();
    }

    public function crmAdd($username, $email, $mobile, $role_id, $team_id, $city_id) {
        $ck = $this->checkInput(0, $username, $email, $mobile, $role_id, $team_id, $city_id);
        if ($ck['status'] == 1) {
            return $ck;
        }
        $rs = CrmUser::instance();
        $rs->name = $username;
        $rs->email = $email;
        $rs->tel = $mobile;
        $rs->accname = substr($email, 0, strpos($email, "@")) . rand(1, 10000);
        $rs->crmTeamId = $team_id;
        $rs->cityId = $city_id;
        $rs->crmRoleId = $role_id;
        $rs->status = self::STATUS_VALID;
        $rs->adminRoleId = 4;
        $rs->addTime = time();

        if ($rs->save()) {
            $this->rtn['user_id'] = $rs->id;
            return $this->Rtn();
        } else {
            $this->rtn['info'] = "添加用户失败";
            return $this->Error();
        }
    }

    public function crmEdit($user_id, $username, $email, $mobile, $role_id, $team_id, $city_id) {
        $ck = $this->checkInput($user_id, $username, $email, $mobile, $role_id, $team_id, $city_id);
        if ($ck['status'] == 1) {
            return $ck;
        }
        $rs = CrmUser::findFirst($user_id);
        $rs->name = $username;
        $rs->email = $email;
        $rs->tel = $mobile;
        $rs->crmTeamId = $team_id;
        $rs->cityId = $city_id;
        $rs->crmRoleId = $role_id;

        if ($rs->update()) {
            $this->rtn['user_id'] = $user_id;
            return $this->Rtn();
        } else {
            $this->rtn['info'] = "修改用户失败";
            return $this->Error();
        }
    }

    public function crmDel($user_id) {
        return self::findFirst($user_id)->delete();
    }
    
    public function crmStart($user_id) {
        $rs =  self::findFirst($user_id);
        $rs->status = CrmUser::STATUS_VALID;
        return $rs->update();
    }

    private function checkInput($user_id, $username, $email, $mobile, $role_id, $team_id, $city_id) {
        if ($username == "") {
            $this->rtn['info'] = "用户名错误";
            return $this->Error();
        }
        if (!preg_match("/^[0-9a-zA-Z\_]+@sohu\-inc\.com$/", $email)) {
            $this->rtn['info'] = "邮箱错误";
            return $this->Error();
        }
        $con = "email = '{$email}'";
        //$con .= " and status=" . self::STATUS_VALID;
        $con .= " and id<>{$user_id}";
        if (self::count($con) > 0) {
            $this->rtn['info'] = "邮箱已经存在,不能重复添加";
            return $this->Error();
        }
        if (!preg_match("/^[0-9\-]{7,18}$/", $mobile)) {
            $this->rtn['info'] = "手机号码错误";
            return $this->Error();
        }
        if ($role_id == 0) {
            $this->rtn['info'] = "请选择角色";
            return $this->Error();
        }
        if ($team_id == 0) {
            $this->rtn['info'] = "请选择团队";
            return $this->Error();
        }
        if ($team_id == 0) {
            $this->rtn['info'] = "团队所在城市不正确";
            return $this->Error();
        }
        return $this->Rtn();
    }

    /**
     * 获取一个团队下用户个数
     * @param type $team_id
     * @return type
     */
    public function getUserCountByTeamId($team_id) {
        $team_id = intval($team_id);
        return self::count("crmTeamId = '{$team_id}'");
    }

    /**
     * 获取一个角色下用户个数
     * @param type $team_id
     * @return type
     */
    public function getUserCountByRoleId($role_id) {
        $role_id = intval($role_id);
        return self::count("crmRoleId = '{$role_id}'");
    }

    /**
     * 根据user_id 获取其负责城市的city_id
     * @param type $user_id
     * @return type
     */
    public function getCityIdByUserId($user_id) {
        $user_id = intval($user_id);
        return self::findFirst($user_id)->cityId;
    }

}
