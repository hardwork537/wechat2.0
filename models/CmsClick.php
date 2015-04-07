<?php

class CmsClick extends BaseModel
{

    public $id;
    public $type;
    public $newsType;
    public $newsId;
    public $newsClick;
    public $newsUpdate;
    public $cityId;
//1: 30天点击量  2:7天点击量 3:优质
    const  TYPE_MONTH  = 1;
    const  TYPE_WEEK   = 2;
    const  TYPE_FINE   = 3;
    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'clickId' => 'id',
            'clickType' => 'type',
            'clickNewsType' => 'newsType',
            'clickNewsId' => 'newsId',
            'clickNewsClick' => 'newsClick',
            'clickNewsUpdate' => 'newsUpdate',
            "cityId"          => "cityId"
        );
    }
    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    public function getSource()
    {
        return 'cms_click_statistics';
    }
    /**
     * 实例化对象
     *
     * @param type $cache
     * @return \Area_Model
     */
    public static function instance ($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self();
    }
    public function getClick($type,$cityId, $size=50,$returnNum=5){
        $today = date("Y-m-d", time());
        $rs = $this->find([
            "conditions" => "type=$type AND cityId=$cityId AND newsUpdate>'".$today." 00:00:00'",
            "limit" =>array('offset' => 0, 'number' => $size),
            'order' => "newsClick desc"
        ])->toArray();
        if($returnNum && !empty($rs) && $type != 1){
            shuffle($rs);
            $rs = array_slice($rs,0,$returnNum);
        }
        //     3 => 'community',4 => 'prop', 6 => 'block'
        $result = array();
        $i = 0;
        foreach($rs as $k=>$v){
            //小区榜单
            if($v["newsType"] == 3){
                $one = CmsCommunity::findFirst("id=".$v['newsId'],0)->toArray();
            }
            //房源精选
            if($v["newsType"] == 4){
                $one = CmsProp::findFirst("id=".$v['newsId'],0)->toArray();
            }
            //板块置业
            if($v["newsType"] == 6){
                $one = CmsBlock::findFirst("id=".$v['newsId'],0)->toArray();
            }
            if($one){
                $result[$i]["title"]  = $one["title"];
                $result[$i]["url"]    = "/news/".date("Y-m-d", $one["publishTime"])."/".$v["newsType"]."/".$one["id"].".html";
                $result[$i]["imgUrl"] = !empty($one['imageId']) ? ImageUtility::getImgUrl("esf", $one['imageId'], $one['imageExt']) : '';
                $i++;
            }
        }

        return $result;
    }


}
