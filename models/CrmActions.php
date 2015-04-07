<?php
/**
 * @abstract  模块字典 操作
 * @copyright Sohu-inc Team.
 * @author    Rady (yifengcao@sohu-inc.com)
 * @date      2014-09-24 14:12:18
 * @version   admin 2.0
 */

class CrmActions extends BaseModel {

	public $id;
	public $moudelId;
	public $name;
	public $url;

	public function columnMap()
    {
        return array(
            'actionId' 		=> 'id',
            'moudelId' 		=> 'moudelId',
            'actionName'	=> 'name',
            'actionUrl'		=> 'url',
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
        return new self;
    }


     /**
     * 根据角色ID获取有权限的菜单
     * @param type $role_id
     * @return array();
     */
    public function getPowerMoudels($role_id,$menu_id){
        $role_id = intval($role_id);
        $menu_id = intval($menu_id);
        if(!$role_id || !$menu_id ){
            return array();
        }
        $sql = "SELECT b.moudel_id,b.moudel_name,b.moudel_url FROM  ".FS_DBTABLEPRE."crm_powers a RIGHT JOIN ".FS_DBTABLEPRE."crm_moudels b ON a.moudel_id=b.moudel_id WHERE a.role_id={$role_id} and b.menu_id={$menu_id} GROUP BY moudel_id";
        return $this->execute($sql)->fetchAll();
    }

    /**
     * 根据模块ID获取下面的所有操作
     * @param type $menu_id
     * @return type
     */
    public function getActionsByMoudelId($moudelId){
        $moudelId = intval($moudelId);
		return self::find(array(
			"moudelId = {$moudelId}",
		))->toArray();
    }

    /**
     * 获取所有的操作URL
     * @return type
     */
    public function getGroupbyActions(){
        $arr =array();
		$rs = self::find(array(
			"group" => "url"
		))->toArray();
        foreach($rs as $v){
            $arr[]=$v['url'];
        }
        return $arr;
    }
}


