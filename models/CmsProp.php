<?php

class CmsProp extends BaseModel
{
    const STATUS_NOT_PUSH = 1;   //未推送   
    const STATUS_PUBLISH  = 2;   //已发布
    const STATUS_REVOKE   = 3;   //已撤回
    const STATUS_PENDING  = 4;   //已推送未发布
    
    const LIST_TYPE = 4;
    
    protected $id;
    protected $cityId;
    protected $userId;
    protected $subjectName;
    protected $title = '';
    protected $author;
    protected $sourceName = '';
    protected $imageId = 0;
    protected $imageExt = '';
    protected $createTime = 0;
    protected $modifyTime = 0;
    protected $publishTime = 0;
    protected $revokeTime = 0;
    protected $pushTime = 0;
    protected $startTime = 0;
    protected $endTime = 0;
    protected $pv = 0;
    protected $status = self::STATUS_NOT_PUSH;
    protected $intro = '';
    protected $subjectRequire;
    
    /**
     * 获取所有文章状态
     * @return array
     */
    public static function getAllStatus() 
    {
        return array(
            self::STATUS_NOT_PUSH => '未推送',
            self::STATUS_PENDING  => '已推送未发布',
            self::STATUS_PUBLISH  => '已发布',
            self::STATUS_REVOKE   => '已撤回'
        );
    }
    
    /**
     * 获取所有状态对应的下一个状态
     * @return type
     */
    public static function getNextStatus() 
    {
        return array(
            self::STATUS_NOT_PUSH => array('id' => self::STATUS_PENDING, 'name' => '推送', 'action' => 'push'),
            self::STATUS_PENDING  => array('id' => self::STATUS_PUBLISH, 'name' => '发布', 'action' => 'publish'),
            self::STATUS_PUBLISH  => array('id' => self::STATUS_REVOKE, 'name' => '撤回', 'action' => 'revoke'),
            self::STATUS_REVOKE   => array('id' => self::STATUS_PUBLISH, 'name' => '发布', 'action' => 'publish')
        );
    }
    
    /**
     * 新增选题
     * @param array $data
     * @return boolean
     */
    public function addSubject($data)
    {
        if(empty($data))
        {
            return false;
        }
        $rs = self::instance();
        $rs->cityId = $data['cityId'];
        $rs->subjectName = $data['subjectName'];
        $rs->subjectRequire = $data['subjectRequire'];
        $rs->startTime = $data['startTime'];
        $rs->endTime = $data['endTime'];
        $rs->author = $data['author'];
        $rs->userId = $data['userId'];
        $rs->createTime = time();
        $rs->modifyTime = time();
        
        if($rs->create())
        {
            //添加到 ES 中
            $esArr = array(
                'id'        => self::LIST_TYPE.'_'.$rs->id,
                'newsId'    => $rs->id,
                'cityId'    => $rs->cityId,
                'newsStatus'=> self::STATUS_PENDING,
                'newsUpdate'=> 0,
                'newsType'  => self::LIST_TYPE,
                'newsSign'  => json_encode(array(),JSON_UNESCAPED_UNICODE)
            );
            
			$esRes = CmsEs::add($esArr);
            
            return true;
        }
        return false;
    }
    
    /**
     * 文章操作：发布或撤回
     * @param array  $ids
     * @param string $action
     * @return boolean
     */
    public function operate($ids, $action)
    {
        if(empty($ids) || !in_array($action, array('push', 'publish', 'revoke')))
        {
            return false;
        }
        $id = implode(',', $ids);
        $rs = self::find("id in({$id})");
        if(!$rs)
        {
            return false;
        }
        $this->begin();
        foreach($rs as $v)
        {
            $esArr = array(
                'id' => self::LIST_TYPE.'_'.$v->id
            );
            if('publish' == $action)
            {
                $v->status = self::STATUS_PUBLISH;
                $v->publishTime = time();
                $esArr['data']['newsUpdate'] = $v->publishTime;
            }
            elseif('revoke' == $action)
            {
                $v->status = self::STATUS_REVOKE;
                $v->revokeTime = time();
            }
            elseif('push' == $action)
            {
                $v->status = self::STATUS_PENDING;
                $v->pushTime = time();
            }
            if(!$v->update())
            {
                return false;
            }
            $labels = CmsArticleLabel::find("articleId={$v->id} and articleType=".CmsArticleLabel::TYPE_PROP);
            if($labels)
            {
                foreach($labels as $label)
                {
                    $label->status = $v->status;
                    if(!$label->update())
                    {
                        $this->rollback();
                        return false;
                    }
                }
            }
            //修改ES状态  
            $esArr['data']['newsStatus'] = $v->status;
            $res = CmsEs::update($esArr);
        }
        $this->commit();
        return true;
    }
    
    /**
     * 修改房源精选
     * @param array $data
     * @return boolean
     */
    public function editProp($id, $data) {
        if(empty($data) || !$id) 
        {
            return false;
        }
        $rs = self::findFirst("id={$id}");
        if(!$rs)
        {
            return false;
        }
        $this->begin();
        $rs->cityId = $data['cityId'];
        $rs->sourceName = $data['sourceName'];
        $rs->imageId = $data['imageId'];
        $rs->imageExt = $data['imageExt'];
        $rs->title = $data['title'];
        $rs->intro = $data['intro'];
        $rs->modifyTime = time();
        //修改表 cms_prop
        if($rs->update()) 
        {
            $deleteSql = "DELETE FROM cms_article_label WHERE articleId={$id} AND articleType=".CmsArticleLabel::TYPE_PROP;
            if(!$this->execute($deleteSql))
            {
                $this->rollback();
                return false;
            }
            //插入 cms_article_label
            $insertSql = "INSERT into cms_article_label(`articleId`, `cityId`, `articleType`, `labelId`, `labelType`, `articleStatus`) VALUES";
            $articleLabels = array();
            foreach($data['label'] as $v) 
            {
                $insertSql .= "({$id},{$data['cityId']},".  CmsArticleLabel::TYPE_PROP . ",{$v['id']},{$v['type']},{$rs->status}),";
                $articleLabels[] = array(
                    'id'   => $v['id'],
                    'name' => $v['name']
                );
            }
            $insertSql = rtrim($insertSql, ',');
            if(!$this->execute($insertSql)) 
            {
                $this->rollback();
                return false;
            } 
            
            $esData = array(
                'id'   => self::LIST_TYPE.'_'.$id,
                'data' => array(
                    'newsTitle' => $rs->title,
                    'newsDesc'  => $rs->intro,
                    'newsSign'  => $articleLabels,
                    'imageId'   => $rs->imageId,
                    'imageExt'  => $rs->imageExt
                )
            );
            
            if(empty($data['propOrder']))
            {
                //修改ES
                $esRes = CmsEs::update($esData);
                
                $this->commit();
                return true;
            }
            //修改表 cms_prop_recommend
            foreach($data['propOrder'] as $v) 
            {
                $proid = intval($v['proid']);
                if($proid < 1) 
                {
                    continue;
                }
                $ds = CmsPropRecommend::findFirst("houseId={$v['proid']} and propId={$id}");
                if(!$ds)
                {
                    continue;
                }
                $ds->weight = $v['weight'];
                if(!$ds->update()) 
                {
                    $this->rollback();
                    return false;
                }
            }
            //修改ES
            $esRes = CmsEs::update($esData);
                
            $this->commit();
            return true;
        } 
        
        $this->rollback();
        return false;
    }
    
    
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCityid($cityId)
    {
        $this->cityId = $cityId;
    }

    public function setUserid($userId)
    {
        $this->userId = $userId;
    }

    public function setSubjectname($subjectName)
    {
        $this->subjectName = $subjectName;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function setSourcename($sourceName)
    {
        $this->sourceName = $sourceName;
    }

    public function setImageid($imageId)
    {
        $this->imageId = $imageId;
    }

    public function setImageext($imageExt)
    {
        $this->imageExt = $imageExt;
    }

    public function setCreatetime($createTime)
    {
        $this->createTime = $createTime;
    }

    public function setModifytime($modifyTime)
    {
        $this->modifyTime = $modifyTime;
    }

    public function setPublishtime($publishTime)
    {
        $this->publishTime = $publishTime;
    }

    public function setRevoketime($revokeTime)
    {
        $this->revokeTime = $revokeTime;
    }

    public function setPushtime($pushTime)
    {
        $this->pushTime = $pushTime;
    }

    public function setStarttime($startTime)
    {
        $this->startTime = $startTime;
    }

    public function setEndtime($endTime)
    {
        $this->endTime = $endTime;
    }

    public function setPv($pv)
    {
        $this->pv = $pv;
    }
  
    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setIntro($intro)
    {
        $this->intro = $intro;
    }

    public function setSubjectrequire($subjectRequire)
    {
        $this->subjectRequire = $subjectRequire;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCityid()
    {
        return $this->cityId;
    }

    public function getUserid()
    {
        return $this->userId;
    }

    public function getSubjectname()
    {
        return $this->subjectName;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getSourcename()
    {
        return $this->sourceName;
    }

    public function getImageid()
    {
        return $this->imageId;
    }

    public function getImageext()
    {
        return $this->imageExt;
    }

    public function getCreatetime()
    {
        return $this->createTime;
    }

    public function getModifytime()
    {
        return $this->modifyTime;
    }

    public function getPublishtime()
    {
        return $this->publishTime;
    }

    public function getRevoketime()
    {
        return $this->revokeTime;
    }

    public function getPushtime()
    {
        return $this->pushTime;
    }

    public function getStarttime()
    {
        return $this->startTime;
    }

    public function getEndtime()
    {
        return $this->endTime;
    }

    public function getPv()
    {
        return $this->pv;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getIntro()
    {
        return $this->intro;
    }

    public function getSubjectrequire()
    {
        return $this->subjectRequire;
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'propId'             => 'id', 
            'cityId'             => 'cityId', 
            'userId'             => 'userId', 
            'propSubjectName'    => 'subjectName', 
            'propTitle'          => 'title', 
            'propAuthor'         => 'author', 
            'propSourceName'     => 'sourceName', 
            'propImageId'        => 'imageId', 
            'propImageExt'       => 'imageExt', 
            'propCreateTime'     => 'createTime', 
            'propModifyTime'     => 'modifyTime', 
            'propPublishTime'    => 'publishTime', 
            'propRevokeTime'     => 'revokeTime', 
            'propPushTime'       => 'pushTime', 
            'propStartTime'      => 'startTime', 
            'propEndTime'        => 'endTime', 
            'propPv'             => 'pv', 
            'propStatus'         => 'status', 
            'propIntro'          => 'intro', 
            'propSubjectRequire' => 'subjectRequire'
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
     * @return CmsProp_Model
     */
    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
    
    public function getSaleNewsList($param)
    {
        return self::find($param,0)->toArray();
    }

}
