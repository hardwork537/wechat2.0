<?php
/**
 * @abstract  菜单字典 操作
 * @copyright Sohu-inc Team.
 * @author    Rady (yifengcao@sohu-inc.com)
 * @date      2014-09-24 14:12:18
 * @version   admin 2.0
 */

class CrmMenus extends BaseModel {

	public $id;
	public $name;
	public $url;
	public $weight;

	public function columnMap()
    {
        return array(
            'menuId' 		=> 'id',
            'menuName' 		=> 'name',
            'menuUrl'	=> 'url',
            'menuWeight'		=> 'weight',
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
     * 获取所有的菜单
     */
    public function  getAllMenus(){
		return self::find(array(
			"order" => " weight "
		))->toArray();
    }

	/**
     * 根据所有权限列表
     * @param type
     * @return type
     */
    public function getMenusList(){
        $menu_list = $this->getAllMenus();

        if(is_array($menu_list)){
            foreach($menu_list as $k=>$v){
                $menu_list[$k]["moudels"] = CrmMoudels::instance()->getMoudelsByMenuId($v["id"]);
                if(is_array($menu_list[$k]["moudels"])){
                    foreach($menu_list[$k]["moudels"] as $p=>$q){
                        $menu_list[$k]["moudels"][$p]['actions'] = CrmActions::instance()->getActionsByMoudelId($q["id"]);
                    }
                }
            }
        }

        return $menu_list;
    }

}

?>

