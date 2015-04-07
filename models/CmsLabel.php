<?php

class CmsLabel extends BaseModel
{
    protected $id;
    protected $cityId;
    protected $type;
    protected $name;
    protected $createTime;
    
    const LABEL_AREA    = 1;  //区域
    const LABEL_BLOCK   = 2;  //版块
    const LABEL_PRICE   = 3;  //价格
    const LABEL_FEATURE = 4;  //特色
    
    /**
     * 获取所有标签类型
     * @return array
     */
    public static function getAllTypes() 
    {
        return array(
            self::LABEL_AREA    => '区域',
            self::LABEL_BLOCK   => '版块',
            self::LABEL_PRICE   => '价格',
            self::LABEL_FEATURE => '特色'
        );
    }
    
    /**
     * 新增标签
     * @param array $data
     * @return array
     */
    public function add($data)
    {
        if(empty($data))
        {
            return array('status'=>1, 'info'=>'参数为空！');
        }
        if($this->isExistLabelName($data["name"], $data["cityId"]))
        {
            return array('status'=>1, 'info'=>'标签已经存在！');
        }

        $rs = self::instance();
        $rs->cityId = $data["cityId"];
        $rs->name = $data["name"];
        $rs->type = $data["type"];
        $rs->createTime = time();

        if($rs->create())
        {
            return array('status'=>0, 'info'=>'添加标签成功！');
        }
        return array('status'=>1, 'info'=>'添加标签失败！');
    }
    
    /**
     * 编辑标签
     *
     * @param int   $id
     * @param array $data
     * @return array
     */
    public function edit($id, $data)
    {
        if(empty($data))
        {
            return array('status'=>1, 'info'=>'参数为空！');
        }
        if($this->isExistLabelName($data["name"], $data["cityId"], $id))
        {
            return array('status'=>1, 'info'=>'标签已经存在！');
        }

        $rs = self::findfirst($id);
        if(!rs)
        {
            return array('status'=>1, 'info'=>'标签不存在！');
        }
        $rs->name = $data["name"];
        $rs->type = $data["type"];

        if($rs->update()) 
        {
            return array('status'=>0, 'info'=>'标签修改成功！');
        }
        return array('status'=>1, 'info'=>'标签修改失败！');
    }
    
    private function isExistLabelName($labelName, $cityId, $labelId=0)
    {
        $labelName = trim($labelName);
        if(empty($labelName))
        {
            return true;
        }
        $con['conditions'] = "name='{$labelName}' and cityId={$cityId}";
        $labelId > 0 && $con['conditions'] .= " and id<>{$labelId}";

        $intCount = self::count($con);
        if($intCount > 0)
        {
            return true;
        }
        return false;
    }
    
    /**
     * 删除标签
     * @param array $ids
     * @return boolean
     */
    public function del($ids)
    {
        if(empty($ids))
        {
            return false;
        }
        $id = implode(',', $ids);
        $rs = self::find("id in ({$id})");
        if(!$rs)
        {
            return false;
        }
        foreach($rs as $v)
        {
            if(!$v->delete())
            {
                return false;
            }
        }
        return true;
    }
    
    /**
     * 根据城市获取所有标签名
     * @param int $cityId
     * @return array
     */
    public function getLabelsByCityId($cityId) 
    {
        $cityId = intval($cityId);
        if(1 > $cityId) 
        {
            return array();
        }
        $condition = array(
            'conditions' => "cityId={$cityId}",
            'columns'    => 'id,name'
        );
        $labels = self::find($condition, 0)->toArray();
        $lists = array();
        foreach($labels as $label) 
        {
            $lists[$label['id']] = $label['name'];
        }
        
        return $lists;
    }
    
    /**
     * 批量插入标签
     * @param array $data
     * @return boolean
     */
    public function addLabels($data) 
    {
        if(empty($data)) 
        {
            return false;
        }
        $sql = "INSERT into cms_label(`cityId`,  `labelType`,  `labelName`,  `labelCreateTime`) VALUES";
        $time = time();
        foreach($data as $v) 
        {
            extract($v);
            $sql .= "({$cityId},{$type},'{$name}',{$time}),";                       
        }
        $sql = rtrim($sql, ',');

        return $this->execute($sql);
    }
    
    public function setLabelid($labelId)
    {
        $this->id = $labelId;
    }

    public function setCityid($cityId)
    {
        $this->cityId = $cityId;
    }

    public function setLabeltype($labelType)
    {
        $this->type = $labelType;
    }

    public function setLabelname($labelName)
    {
        $this->name = $labelName;
    }

    public function setCreatetime($createTime)
    {
        $this->createTime = $createTime;
    }

    public function getLabelid()
    {
        return $this->id;
    }

    public function getCityid()
    {
        return $this->cityId;
    }

    public function getLabeltype()
    {
        return $this->type;
    }

    public function getLabelname()
    {
        return $this->name;
    }

    public function getCreatetime()
    {
        return $this->createTime;
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'labelId'         => 'id', 
            'cityId'          => 'cityId', 
            'labelType'       => 'type', 
            'labelName'       => 'name', 
            'labelCreateTime' => 'createTime'
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
     * @return CmsLabel_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }

    /*
     * 获取tags
     * */
    public function getTags($cityId, $flag=true){
        $rs = $this->find([
            "conditions"=>"cityId=$cityId",
            "order"=>"id desc",
            "columns"=>"id, name, type",

        ])->toArray();
        foreach($rs as $v){
            if(empty($v['type'])) continue;
            $param[$v['type']][$v["id"]] = $v;
            if($v['type'] == CmsLabel::LABEL_AREA ){
                $num = CmsArticleLabel::count("labelId=".$v["id"]." AND cityId=$cityId AND status=".CmsArticleLabel::STATUS_PUBLISH);
                $param[$v['type']][$v["id"]]["num"] = $num;
                $ids[$v["id"]] = $v["id"];
                $nums[$v["id"]] = $num;
            }
            if( $v["type"]== CmsLabel::LABEL_FEATURE ){
                $numType = CmsArticleLabel::count("labelId=".$v["id"]." AND cityId=$cityId AND status=".CmsArticleLabel::STATUS_PUBLISH);
                $param[$v['type']][$v["id"]]["num"] = $numType;
                $idsType[$v["id"]] = $v["id"];
                $numsType[$v["id"]] = $numType;
            }
            if($v["type"] == CmsLabel::LABEL_PRICE){
                if(strpos($v["name"],"以下",1)){
                    $num = substr($v["name"], 0 , 3) -1;
                }elseif(strpos($v["name"],"以上",1)){
                    $num = substr($v["name"], 0 , 3) +1000;
                }else{
                    $num = substr($v["name"], 0 , 3);
                }
                $numsPrice[$v["id"]] = $num;
            }

        }
        $types =CmsLabel::getAllTypes();
        foreach($param as $k=>&$v){
            foreach ($v as $key=>$value){
                $lists[$types[$k]][$key]['name'] = $value['name'];
                $lists[$types[$k]][$key]['id'] = $key;
                $lists[$types[$k]][$key]['num'] = $value['num'];
            }
        }
        //区域这一列 按文章数排序
        if(!empty($lists[$types[CmsLabel::LABEL_AREA]])){
            array_multisort($nums, SORT_DESC, $ids, SORT_DESC, $lists[$types[CmsLabel::LABEL_AREA]]);
        }
        //特色这一列 按文章数排序
        if(!empty($lists[$types[CmsLabel::LABEL_FEATURE]])){
            array_multisort($numsType, SORT_DESC, $idsType, SORT_DESC, $lists[$types[CmsLabel::LABEL_FEATURE]]);
        }
        if(!empty($lists[$types[CmsLabel::LABEL_PRICE]])){
            array_multisort($numsPrice, SORT_ASC, $lists[$types[CmsLabel::LABEL_PRICE]]);
        }

        return $lists;
    }

}
