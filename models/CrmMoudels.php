<?php
/**
 * @abstract  模块字典 操作
 * @copyright Sohu-inc Team.
 * @author    Rady (yifengcao@sohu-inc.com)
 * @date      2014-09-24 14:12:18
 * @version   admin 2.0
 */

class CrmMoudels extends BaseModel {

	public $id;
	public $name;
	public $url;
	public $weight;
	public $menuId;

	public function columnMap()
    {
        return array(
            'moudelId' 		=> 'id',
            'moudelName' 		=> 'name',
            'moudelUrl'	=> 'url',
            'moudelWeight'		=> 'weight',
            'menuId'		=> 'menuId',
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
     * 根据角色ID获取有权限的菜单
     * @param type $roleId
     * @return array();
     */
    public function getPowerMoudels($roleId,$menuId){
        $roleId = intval($roleId);
        $menuId = intval($menuId);
        if(!$roleId || !$menuId ){
            return array();
        }
        $sql = "SELECT b.moudelId,b.moudelName,b.moudelUrl FROM  crm_powers a RIGHT JOIN crm_moudels b ON a.moudelId=b.moudelId WHERE a.roleId={$roleId} and b.menuId={$menuId} GROUP BY moudelWeight";
        return $this->fetchAll($sql);
    }

    public function getMoudelsByMenuId($menuId){
        $menuId =  intval($menuId);
		return self::find(array(
			"menuId = {$menuId}",
			"order" =>" weight"
		))->toArray();
    }



}

?>

