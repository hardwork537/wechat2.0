<?php
/**
 * @abstract  菜单字典 操作
 * @copyright Sohu-inc Team.
 * @author    Rady (yifengcao@sohu-inc.com)
 * @date      2014-09-24 14:12:18
 * @version   admin 2.0
 */

class CrmPowers extends BaseModel {

	public $roleId;
	public $id;
	public $menuId;
	public $moudelId;
	public $actionId;

	public function columnMap()
    {
        return array(
            'powersId' 		=> 'id',
            'roleId' 		=> 'roleId',
            'menuId' 		=> 'menuId',
            'moudelId'	=> 'moudelId',
            'actionId'		=> 'actionId',
        );
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
        return parent::_instance(__CLASS__,$cache);
    }

    /**
     * 添加权限
     * @param type $data
     * @return bool
     */
    public function pack_add($data){
        $roleId = intval($data['role_id']);
        $power = $data['power'];
        $flag = true;
        if(is_array($power) && !empty($power)){
			foreach (self::find("roleId = '{$roleId}'") as $rs) {
				$rs->delete();
			}
            foreach($power as $k=>$v){
                $v = explode("_", $v);
                $add_arr = array(
                    "role_id" => $roleId,
                    "menu_id" => intval($v[0]),
                    "moudel_id" => intval($v[1]),
                    "action_id" => intval($v[2]),
                );
				$rs = self::instance(false);
				$rs ->roleId = $roleId;
				$rs ->menuId = intval($v[0]);
				$rs ->moudelId = intval($v[1]);
				$rs ->actionId = intval($v[2]);
                if(!$rs->save()){
                    $flag = false;
                    break;
                }
            }
        }
        if($flag){
            return true;
        }else{
            return false;
        }

    }

      /**
     * 根据角色获取所有有权限的menu_id
     * @param type $roleId
     */
    public function getPowerMenuId($roleId){
        $roleId = intval($roleId);
		return self::find(array(
			"roleId = {$roleId} ",
			"group" => "menuId",
			"columns" => "menuId"
		))->toArray();
    }

    /**
     * 根据角色获取所有有权限的moudel_id
     * @param type $roleId
     */
    public function getPowerMoudelId($roleId){
		$roleId = intval($roleId);
		return self::find(array(
			"roleId = {$roleId} ",
			"group" => "moudelId",
			"columns" => "moudelId"
		))->toArray();
    }

    /**
     * 根据角色获取所有有权限的action_id
     * @param type $roleId
     */
    public function getPowerActionId($roleId){
		$roleId = intval($roleId);
		return self::find(array(
			"roleId = {$roleId} ",
			"group" => "actionId",
			"columns" => "actionId"
		))->toArray();
    }

	/**
     * 获取所有可以访问的URL
     * @return array
    */
    public function getPowerArr($roleId){
        $urlArr = array();
        $roleId = intval($roleId);
        $sql = "SELECT b.moudelUrl,b.moudelName,c.actionId,c.actionUrl FROM  crm_powers a left JOIN crm_moudels b ON a.moudelId=b.moudelId left join crm_actions c on a.actionId=c.actionId  WHERE a.roleId={$roleId}";
        $_arr =  $this->fetchAll($sql);
        foreach($_arr as $k => $v){
            if(!empty($v)){
                $m = str_replace('\\', '/',$v['moudelUrl']);
                $m = trim($m,"/");
                $m = $m."/".trim($v['actionUrl']);
                $urlArr[] = $m;
            }
        }
        return $urlArr;
    }

	/**
     * 根据角色ID获取有权限的菜单
     * @param type $role_id
     * @return type
     */
    public function getPowerMenus($roleId){
        $roleId = intval($roleId);
        $sql = "SELECT b.menuId,b.menuName,b.menuUrl FROM  crm_powers a RIGHT JOIN crm_menus b ON a.menuId=b.menuId WHERE a.roleId={$roleId} GROUP BY a.menuId";
        return $this->fetchAll($sql);
    }

}


