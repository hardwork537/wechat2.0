<?php
/**
 * @abstract 登陆日志
 * @copyright Sohu-inc Team.
 * @author    Rady(yifengcao@sohu-inc.com)
 * @version   crm 2.0
 */

class CrmLoginLogs extends BaseModel
{

    protected $id;

    protected $userId;

    protected $userName;

    protected $userAccname;

    protected $cityId;

    protected $cityName;

    protected $teamId;

    protected $teamName = '';

    protected $roleId;

    protected $roleName = '';

    protected $userEmail;

    protected $ip;

    protected $status;

    protected $time;

    public function columnMap ()
    {
        return array(
                'loginId' => 'id',
                'userId' => 'userId',
                'userAccname' => 'userAccname',
                'userName' => 'userName',
                'cityId' => 'cityId',
                'cityName' => 'cityName',
                'teamId' => 'teamId',
                'teamName' => 'teamName',
                'roleId' => 'roleId',
                'roleName' => 'roleName',
                'userEmail' => 'userEmail',
                'loginIp' => 'ip',
                'loginStatus' => 'status',
                'loginTime' => 'time'
        );
    }

    public function initialize ()
    {
        $this->setConn('esf');
    }

    /**
     * 实例化对象
     *
     * @return type
     */
    public static function instance ($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self();
    }

    public function addLoginLog ($userinfo)
    {
        $logIp = Util::getUserIP();
        $rs = self::instance();
        $userLogin = array(
                "userId" => $userinfo['id'],
                "userAccname" => $userinfo['accname'],
                "userName" => $userinfo['name'],
                "cityId" => $userinfo['cityId'],
                "cityName" => $userinfo['cityName'],
                "userEmail" => $userinfo['email'],
                "roleId" => $userinfo['roleId'],
                "roleName" => $userinfo['roleName'],
                "teamId" => $userinfo['teamId'],
                "teamName" => $userinfo['teamName'],
                "ip" => $logIp,
                "status" => 1,
                "time" => time()
        );

        return $rs->save($userLogin);
    }

    public function getLogsList ($con = array(), $offset = 0, $size = 20)
    {
        $con = $this->_params_filter($con);
        return self::find(array(
			$con,
			"group" => "userAccname",
			"limit" => array("offset"=>$offset, "number"=>$size),
			"columns" => "count(*) as num, userAccname, userName, cityName, roleName, teamName",
			))->toArray();
    }

    public function getLogsCount ($con = array())
    {
        $con = $this->_params_filter($con);
        return count(self::count(array($con,"group" => "userAccname")));
    }

    private function _params_filter ($con)
    {
        $c = "1 ";
        if ($con['starttime']) {
            $c .= " and time >= '".strtotime($con["starttime"])."'";
        }
        if ($con['endtime']) {
            $c .= " and time <= '".strtotime($con["endtime"] . " 23:59:59")."'";
        }
        if ($con['crm_user_name']) {
            $c .= " and userName like '%".trim($con["crm_user_name"])."%'";
        }
        if ($con['city_name']) {
            $c .= " and cityName like '%".trim($con["city_name"])."%'";
        }
        if ($con['team_name']) {
			$c .= " and teamName like '%".trim($con["team_name"])."%'";
        }
        if ($con['role_name']) {
			$c .= " and roleName like '%".trim($con["role_name"])."%'";
        }
        return $c;
    }

    public function get_crmuser_options ()
    {
        $arr = array();
        $rs = $this->Get("", "group by  crm_user_id order by login_id desc ", 0, 0, "crm_user_id,crm_user_name");
        foreach ($rs as $k => $v) {
            $arr[$v['crm_user_id']] = $v['crm_user_name'];
        }
        return $arr;
    }

    public function get_city_options ()
    {
        $arr = array();
        $rs = $this->Get("", "group by  city_id order by login_id desc ", 0, 0, "city_id,city_name");
        foreach ($rs as $k => $v) {
            $arr[$v['city_id']] = $v['city_name'];
        }
        return $arr;
    }

    public function get_team_options ()
    {
        $arr = array();
        $rs = $this->Get("", "group by  team_id order by login_id desc ", 0, 0, "team_id,team_name");
        foreach ($rs as $k => $v) {
            $arr[$v['team_id']] = $v['team_name'];
        }
        return $arr;
    }

    public function get_role_options ()
    {
        $arr = array();
        $rs = $this->Get("", "group by  role_id order by login_id desc ", 0, 0, "role_id,role_name");
        foreach ($rs as $k => $v) {
            $arr[$v['role_id']] = $v['role_name'];
        }
        return $arr;
    }
}

