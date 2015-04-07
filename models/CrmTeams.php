<?php
/**
 * @abstract  团队字典 操作
 * @copyright Sohu-inc Team.
 * @author    Rady (yifengcao@sohu-inc.com)
 * @date      2014-09-28 14:12:18
 * @version   admin 2.0
 */

class CrmTeams extends BaseModel {

    private static $team_option = array();
    private static $team_city_option = array();

    const ZB = 1;
    const BJ = 2;
    const SH = 3;
    const TJ = 4;
    const SZ = 5;

    protected $id;
	protected $name;
    protected $parentId;
    protected $cityId;
	public function columnMap (){
		return array('teamId' => 'id','teamName' => 'name','cityId' => 'cityId','teamParentId' => 'parentId');
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
     * 添加团队
     * @param array $data
     * @return int 0:错误 大于0: 返回ID
     */
    public function pack_add($teamName,$parentId){
        $cityId = intval($this->getCityIdByTeamId($parentId));
        $teamName = trim($teamName);
        $parentId = intval($parentId);
        if(empty($teamName)){
            return 0;
        }
		$rs = $this->instance();
		$rs->name = $teamName ;
		$rs->cityId = $cityId ;
		$rs->parentId = $parentId ;

        if($rs->save()){
            return $rs->id;
        }else{
            return 0;
        }
    }

    /**
     * 修改团队
     * @param array $data
     * @return int 0:错误 大于0: 返回ID
     */
    public function pack_update($teamId,$teamName,$parentId){
        $cityId = intval($this->getCityIdByTeamId($parentId));
        $teamName = trim($teamName);
        $teamId = intval($teamId);
        $parentId = intval($parentId);
        if(empty($teamName) || $teamId ==0){
            return 0;
        }

		$rs =  self::findFirst($teamId);
		$rs->name = $teamName;
		$rs->parentId = $parentId;

        if($parentId==1){

        }else{
            $rs->cityId = $cityId;
        }


        if($rs->update()){
            return $teamId;
        }else{
            return 0;
        }
    }

    /**
     * 删除团队
     * @param array $data
     * @return int 0:错误 大于0: 返回ID
     */
    public function pack_delete($teamId){
        $teamId = intval($teamId);
        if($teamId ==0){
            return 0;
        }
        $rs = self::findFirst($teamId)->delete();
        return true;
    }


    private static function _getTeamsRecursion($arr,$top_catid=0,$level=0){
        $nbsp = str_repeat("&nbsp;",$level*4);
        if(is_array($arr[$top_catid]) && !empty($arr[$top_catid])){
            foreach($arr[$top_catid] as $k=>$v){
                self::$team_option[$v['id']]= $nbsp.$v['name'];
                self::_getTeamsRecursion($arr,$v['id'],$level+1);
            }
        }
        return self::$team_option;
    }

    private static function _getTeamsRecursion2($arr,$top_catid=0,$level=0){
        $nbsp = str_repeat("&nbsp;",$level*4);
        if(is_array($arr[$top_catid]) && !empty($arr[$top_catid])){
            foreach($arr[$top_catid] as $k=>$v){
                self::$team_city_option[]=array("id"=>$v['id'],"name"=>$nbsp.$v['name'],"cityId"=>$v['cityId']);
                self::_getTeamsRecursion2($arr,$v['id'],$level+1);
            }
        }
        return self::$team_city_option;
    }


    /**
     * 获取指定团队列表数组 用于下拉框
     * @param type $parentId  //父ID
     * @return arr
     */
    public static function getTeamsOptions($parentId=0){
        $data = self::find()->toArray();
        $arr = array();
        if(is_array($data) && !empty($data)){
            foreach($data as $q){
                    $arr[$q['parentId']][$q['id']]['id'] =  $q['id'];
						$arr[$q['parentId']][$q['id']]['name'] =  $q['name'];
                    $arr[$q['parentId']][$q['id']]['parentId'] =  $q['parentId'];
            }
            return self::_getTeamsRecursion($arr,$parentId,0);
        }
        return array();
    }

    /**
     * 获取指定团队列表数组,带城市属性与层级关系
     * @param type $parentId  //父ID
     * @return arr
     */
    public static function getTeamsOptionsWithCity($parentId=0){
        $data = self::find()->toArray();
        $arr = array();
        if(is_array($data) && !empty($data)){
            foreach($data as $q){
                    $arr[$q['parentId']][$q['id']]['id'] =  $q['id'];
                    $arr[$q['parentId']][$q['id']]['name'] =  $q['name'];
                    $arr[$q['parentId']][$q['id']]['parentId'] =  $q['parentId'];
                    $arr[$q['parentId']][$q['id']]['cityId'] =  $q['cityId'];
            }
            return self::_getTeamsRecursion2($arr,$parentId,0);
        }
        return array();
    }

    /**
     * 获取指定团队列表数组
     * @param type $parentId
     * @return arr
     */
    public static function getTeamsArr($parentId=0){
        $data = self::find()->toArray();
        $arr = array();
        if(is_array($data) && !empty($data)){
            foreach($data as $k=>$v){
                $arr[$v['id']] = $v['name'];
            }
        }
        return $arr;
    }

    /**
     * 根据teamId获取cityId
     * @param type $teamId
     * @return type
     */
    public function getCityIdByTeamId($teamId){
        $rs = self::findFirst(intval($teamId))->toArray();
        return $rs['cityId'];
    }

    /**
     * 获取一个团队下面的子团队个数
     * @param type $teamId
     * @return type
     */
    public function getChildTeamCount($teamId){
        $teamId = intval($teamId);
        return self::count("parentId = {$teamId}");
    }


    /**
     * 根据teamId获取parentId
     * @param type $teamId
     * @return type
     */
    public function getParentIdByTeamId($teamId){
        $condition['teamId'] =intval($teamId);
        $rs = $this->Get($condition);
        return $rs[0]['parentId'];
    }

    /**
     * 根据城市ID获取下面所有的团队,按照parentid,teamId排序
     * @param type $cityId
     */
    public function getTeamOptionsByCityId($cityId = 0){
        $cityId = intval($cityId);
        if($cityId > 0)
        {
            $condition = array(
                'conditions' => "cityId={$cityId} and parentId<>1",
                'order'      => 'parentId asc,id asc',
            );
            $rs = self::find($condition, 0)->toArray();
            if(is_array($rs))
            {
                foreach($rs as $k=>$v ){
                    $arr[$v['id']] = $v['name'];
                }
                return $arr;
            }
            return array();
        }
        else
        {
            return self::getTeamsOptions();
        }
    }
}
