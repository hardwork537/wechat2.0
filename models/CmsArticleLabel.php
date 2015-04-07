<?php

class CmsArticleLabel extends BaseModel
{
    protected $id;
    protected $articleId;
    protected $cityId;
    protected $articleType;
    protected $labelId;
    protected $labelType;
    protected $status;
    
    const TYPE_PROP  = 1;    //房源精选
    const TYPE_BLOCK = 2;    //板块置业

    const STATUS_PENDING = 1;   //待发布
    const STATUS_PUBLISH = 2;   //已发布
    const STATUS_REVOKE  = 3;   //撤回
    /**
     * 根据标签id获取文章数量
     * @param int|array $ids
     * @return array
     */
    public function getNumByLabelId($ids)
    {
        if(empty($ids))
        {
            return array();
        }
        $id = implode(',', (array)$ids);
        $sql = "SELECT count(*) as num, labelId FROM cms_article_label WHERE labelId in({$id}) GROUP BY labelId";
        $nums = $this->fetchAll($sql);
        
        $res = array();
        foreach($nums as $value)
        {
            $res[$value['labelId']] = $value['num'];
        }
        
        return $res;
    }
    
    public function setArticleid($articleId)
    {
        $this->articleId = $articleId;
    }

    public function setCityid($cityId)
    {
        $this->cityId = $cityId;
    }

    public function setArticletype($articleType)
    {
        $this->articleType = $articleType;
    }

    public function setLabelid($labelId)
    {
        $this->labelId = $labelId;
    }

    public function setLabeltype($labelType)
    {
        $this->labelType = $labelType;
    }

    public function getArticleid()
    {
        return $this->articleId;
    }

    public function getCityid()
    {
        return $this->cityId;
    }

    public function getArticletype()
    {
        return $this->articleType;
    }

    public function getLabelid()
    {
        return $this->labelId;
    }

    public function getLabeltype()
    {
        return $this->labelType;
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'alId'        => 'id',
            'articleId'   => 'articleId', 
            'cityId'      => 'cityId', 
            'articleType' => 'articleType', 
            'labelId'     => 'labelId', 
            'labelType'   => 'labelType',
            "articleStatus"=>'status'
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
     * @return CmsArticleLabel_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }

    /*
     * 获取文章数最多的标签
     * 区域、板块取文章数最多的前5个标签，特色取文章数最多的前6个标签，价格固定展示5个标签
     * */
    public function getTags($cityId, $flag=true){
        $sql = "select count(articleId) as num ,b.labelId, b.labelType ,b.labelName from cms_article_label a RIGHT JOIN cms_label b ON a.labelId = b.labelId WHERE b.cityId=$cityId  GROUP BY b.labelId ORDER BY num desc ";
        $rs = $this->fetchAll($sql);
        foreach($rs as $v){
            if(empty($v['labelType'])) continue;
            $param[$v['labelType']][$v["labelId"]] = $v;
        }
        $types =CmsLabel::getAllTypes();

        foreach($param as $k=>&$v){
            if($flag){
                switch($k){
                    case CmsLabel::LABEL_FEATURE:
                        $v = array_slice($v, 0,6);
                        break;
                    case CmsLabel::LABEL_PRICE;
                        //ksort($v);
                        break;
                    default :
                        $v = array_slice($v, 0,5);
                        break;
                }
            }
            foreach ($v as $key=>$value){
                if($value["labelType"] == CmsLabel::LABEL_PRICE){
                    if(strpos($value["labelName"],"以下",1)){
                        $num = substr($value["labelName"], 0 , 3) -1;
                    }elseif(strpos($value["labelName"],"以上",1)){
                        $num = substr($value["labelName"], 0 , 3) +1000;
                    }else{
                        $num = substr($value["labelName"], 0 , 3);
                    }
                    $numsPrice[$value["labelId"]] = $num;
                }
                $lists[$types[$k]][$key]['name'] = $value['labelName'];
                $lists[$types[$k]][$key]['id'] = $value['labelId'];
            }
            if(!empty($lists[$types[CmsLabel::LABEL_PRICE]])){
                array_multisort($numsPrice, SORT_ASC, $lists[$types[CmsLabel::LABEL_PRICE]]);
            }

        }
        return $lists;
    }
    //根据文章数，获取热门标签
    public function getHotTags($cityId, $size=12, $offset=0){
        $sql = "select count(articleId) as num ,b.labelId, b.labelType ,b.labelName from cms_article_label a RIGHT JOIN cms_label b ON a.labelId = b.labelId WHERE b.cityId=$cityId AND a.articleStatus=".self::STATUS_PUBLISH."  GROUP BY b.labelId ORDER BY num desc,b.labelId desc limit $offset, $size ";
        $rs = $this->fetchAll($sql);
        foreach($rs as $v){
            $param[$v["labelId"]] = $v;
            $param[$v["labelId"]]['num'] = $v["num"];
        }
        foreach($param as $k=>$v){
//            if($v["labelType"] == CmsLabel::LABEL_AREA){
//                $rs = CityDistrict::findFirst("name='".$v['labelName']."'",0)->toArray();
//                $lists[$k]['pinyin'] = isset($rs["pinyin"]) ? $rs["pinyin"] : '';
//            }elseif($v["labelType"] == CmsLabel::LABEL_BLOCK){
//                $rs = CityRegion::findFirst("name='".$v['labelName']."'",0)->toArray();
//                $lists[$k]['pinyin'] = isset($rs["pinyin"]) ? $rs["pinyin"] : '';
//            }
            $lists[$k]['name'] = $v['labelName'];
            $lists[$k]['num'] = $v['num'];
        }
        return $lists;
    }

}
