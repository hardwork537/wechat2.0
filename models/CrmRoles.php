<?php
/**
 * @abstract  角色字典 操作
 * @copyright Sohu-inc Team.
 * @author    Rady (yifengcao@sohu-inc.com)
 * @date      2014-09-28 14:12:18
 * @version   admin 2.0
 */

class CrmRoles extends CrmBaseModel {

    const ROLE_BOSS = 1;    //总经理
    const ROLE_CHIEF = 2;   //首席代表
    const ROLE_MANAGE = 3;  //经理
    const ROLE_SALE = 4;    //顾问


    protected $id;
	protected $name;
    public function columnMap (){
		return array('roleId' => 'id','roleName' => 'name');
	}

	public function initialize ()
    {
        $this->setConn('esf');
    }

    /**
     * 单例对象
     * @return type
     */
    public static function instance($cache=true){
        return BaseModel::_instance(__CLASS__,$cache);
        return new self;
    }

    /**
     * 添加角色
     * @param array $data
     * @return int 0:错误 大于0: 返回ID
     */
    public function pack_add($role_name,$is_xiaoshou){
        $role_name = trim($role_name);
        $is_xiaoshou = intval($is_xiaoshou);

        $ck = $this->checkInput(0,$role_name);
        if($ck['status']==1){
            return $ck;
        }

        $rs = $this->instance();
		$rs->name = $role_name ;
        if($rs->save()){
            $this->rtn['role_id'] = $rs->id;
            return  $this->Rtn();
        }else{
            $this->rtn['info'] = "添加角色失败";
            return $this->Error();
        }
    }

    /**
     * 修改角色
     * @param array $data
     * @return int 0:错误 大于0: 返回ID
     */
    public function pack_update($role_id,$role_name,$is_xiaoshou){
        $role_name = trim($role_name);
        $role_id = intval($role_id);
        $is_xiaoshou = intval($is_xiaoshou);

        $ck = $this->checkInput($role_id,$role_name);
        if($ck['status']==1){
            return $ck;
        }

        $rs =  self::findFirst($role_id);
		$rs->name = $role_name;

        if($rs->update()){
            $this->rtn['role_id'] = $role_id;
            return $this->Rtn();
        }else{
            $this->rtn['info'] = "修改角色失败";
            return $this->Rtn();
        }
    }

    /**
     * 检测角色名字重复
     * @param type $role_id
     * @param type $role_name
     */
    private function checkInput($role_id,$role_name){
        $role_name = trim($role_name);
        $role_id = intval($role_id);

        if(empty($role_name)){
            $this->rtn['info'] = "角色名不能为空";
            return $this->Error();
        }

        $con = "id <>{$role_id} and name = '{$role_name}'";

        if(self::findFirst($con)){
            $this->rtn['info'] = "角色名已经存在";
            return $this->Error();
        }
        return $this->Rtn();
    }

    /**
     * 删除角色
     * @param array $data
     * @return int 0:错误 大于0: 返回ID
     */
    public function pack_delete($role_id){
        $role_id = intval($role_id);
        if($role_id ==0){
            return 0;
        }
		$rs = self::findFirst($role_id)->delete();
        return true;
    }

	/**
	 *角色下拉列表
	*/
    public function getRolesOptions(){
        $arr =array();
        $rs = self::find()->toArray();
        foreach($rs as $k=>$v){
            $arr[$v['id']] = $v['name'];
        }
        return $arr;
    }

}

?>

