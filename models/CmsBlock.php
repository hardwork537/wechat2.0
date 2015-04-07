<?php

class CmsBlock extends BaseModel
{
    protected $id;
    protected $cityId;
    protected $userId;
    protected $title;
    protected $author;
    protected $sourceName;
    protected $intro;
    protected $imageId = 0;
    protected $imageExt = '';
    protected $createTime = 0;
    protected $modifyTime = 0;
    protected $publishTime = 0;
    protected $revokeTime = 0;
    protected $status = self::STATUS_PENDING;
    protected $pv = 0;
    protected $recommendPark = '';
    protected $comment;
    protected $turnImage;

    const STATUS_PENDING = 1;   //待发布
    const STATUS_PUBLISH = 2;   //已发布
    const STATUS_REVOKE  = 3;   //撤回
    
    //点评类型
    const COMMENT_EDITOR  = 1;  //编辑 
    const COMMENT_REALTOR = 2;  //经纪人
    
    //列表中的类型
    const LIST_TYPE = 6;
    /**
     * 获取所有文章状态
     * @return array
     */
    public static function getAllStatus() 
    {
        return array(
            self::STATUS_PENDING => '待发布',
            self::STATUS_PUBLISH => '已发布',
            self::STATUS_REVOKE  => '已撤回'
        );
    }
    
    /**
     * 获取所有状态对应的下一个状态
     * @return type
     */
    public static function getNextStatus() 
    {
        return array(
            self::STATUS_PENDING => array('id' => self::STATUS_PUBLISH, 'name' => '发布'),
            self::STATUS_PUBLISH => array('id' => self::STATUS_REVOKE, 'name' => '撤回'),
            self::STATUS_REVOKE => array('id' => self::STATUS_PUBLISH, 'name' => '发布')
        );
    }
    
    /**
     * 文章操作：发布或撤回
     * @param array  $ids
     * @param string $action
     * @return boolean
     */
    public function operate($ids, $action)
    {
        if(empty($ids) || !in_array($action, array('publish', 'revoke')))
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
            if(!$v->update())
            {
                $this->rollback();
                return false;
            }
            //修改 cms_article_label 中articleStatus
            $labels = CmsArticleLabel::find("articleId={$v->id} and articleType=".CmsArticleLabel::TYPE_BLOCK);
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
     * 添加文章
     * @param array $data
     * @return array
     */
    public function addArticle($data) 
    {
        if(empty($data)) 
        {
            return array('status'=>1, 'info'=>'文章添加失败');
        }

        $rs = self::instance();
        $rs->cityId = $data['cityId'];
        $rs->sourceName = $data['sourceName'];
        $rs->intro = $data['intro'];
        $rs->title = $data['title'];
        $rs->author = $data['author'];
        $rs->userId = $data['userId'];
        $rs->turnImage = json_encode($data['image_list']);
        $rs->createTime = time();
        $rs->modifyTime = time();

        if($rs->create())
        {
            //添加到 ES 中
            $esArr = array(
                'id'        => self::LIST_TYPE.'_'.$rs->id,
                'newsId'    => $rs->id,
                'cityId'    => $rs->cityId,
                'newsTitle' => $rs->title,
                'newsStatus'=> self::STATUS_PENDING,
                'newsUpdate'=> 0,
                'newsType'  => self::LIST_TYPE,
                'newsDesc'  => $rs->intro,
            );  
            
			$esRes = CmsEs::add($esArr);
            
            return array('status'=>0, 'info'=>'添加文章成功', 'article_id'=>$rs->id);
        }
        return array('status'=>1, 'info'=>'添加文章失败');
    }
    
    /**
     * 编辑文章
     * @param int   $id
     * @param array $data
     * @return array
     */
    public function updateArticle($id, $data) 
    {
        if(empty($data) || !$id) 
        {
            return array('status'=>1, 'info'=>'文章修改失败');
        }

        $rs = self::findFirst("id={$id}");
        if(!$rs)
        {
            return array('status'=>1, 'info'=>'文章修改失败');
        }
        $rs->sourceName = $data['sourceName'];
        $rs->intro = $data['intro'];
        $rs->title = $data['title'];
        $rs->turnImage = json_encode($data['image_list']);
        $rs->modifyTime = time();
        
        if($rs->update())
        {     
            $esArr = array(
                'id'   => self::LIST_TYPE.'_'.$rs->id,
                'data' => array(
                    'newsDesc'  => $rs->intro,
                    'newsTitle' => $rs->title
                )
            );
            $res = CmsEs::update($esArr);
            
            return array('status'=>0, 'info'=>'修改文章成功', 'article_id'=>$id);
        }
        return array('status'=>1, 'info'=>'修改文章失败');
    }
    
    /**
     * 修改底部推荐信息
     * @param int   $article_id
     * @param array $data
     * @return array
     */
    public function updateArticleBottom($article_id, $data) 
    {
        if(empty($article_id) || empty($data)) 
        {
            return array('status'=>1, 'info'=>'底部推荐保存失败');
        }
        
        $this->begin();
        $rs = self::findFirst("id={$article_id}");
        $rs->imageId = $data['imageId'];
        $rs->imageExt = $data['imageExt'];
        $rs->recommendPark = implode(',', $data['recommendPark']);
        $rs->modifyTime = time();
        
        //修改表 cms_block
        if($rs->update()) 
        {
            $deleteSql = "DELETE FROM cms_article_label WHERE articleId={$article_id} AND articleType=".CmsArticleLabel::TYPE_BLOCK;
            if(!$this->execute($deleteSql)) 
            {
                $this->rollback();
                return array('status'=>1, 'info'=>'底部推荐保存失败');
            }
            //添加到表 cms_article_label 中
            $insertSql = "INSERT into cms_article_label(`articleId`,`cityId`,`articleType`,`labelId`,`labelType`,`articleStatus`) VALUES";
            $type = CmsArticleLabel::TYPE_BLOCK;
            $condition = array(
                'conditions' => "id in (".  implode(',', $data['label']) . ")",
                'columns'    => 'id,type,name'
            );
            $labels = CmsLabel::find($condition, 0)->toArray();
            $articleLabel = array();
            foreach($labels as $v) 
            {         
                $articleLabel[] = array(
                    'id'  => $v['id'],
                    'name'=> $v['name']
                );
                $insertSql .= "({$article_id},{$data['cityId']},{$type},{$v['id']},{$v['type']},{$rs->status}),";
            }
            $insertSql = rtrim($insertSql, ',');     
            if(!$this->execute($insertSql)) 
            {
                $this->rollback();
                return array('status'=>1, 'info'=>'底部推荐保存失败');
            }
            
            //添加到表 cms_block_prop 中
            $deleteSql = "DELETE FROM cms_block_prop WHERE blockId={$article_id}";
            if(!$this->execute($deleteSql)) 
            {
                $this->rollback();
                return array('status'=>1, 'info'=>'底部推荐保存失败');
            }
            $insertSql = "INSERT into cms_block_prop(`blockId`,`bpTitle`,`bpHouseId`,`distId`,`regId`,`bpPriceMin`,`bpPriceMax`,`bpAreaMin`,`bpAreaMax`) VALUES";
            //推荐房源
            foreach($data['prop_list'] as $v) 
            {
                extract($v);
                $proid = implode(',', $proid);
                $insertSql .= "({$article_id},'{$title}','{$proid}',{$distId},{$regId},{$priceFrom},{$priceTo},{$areaFrom},{$areaTo}),";
            }
            $insertSql = rtrim($insertSql, ',');

            if(!$this->execute($insertSql)) 
            {
                $this->rollback();
                return array('status'=>1, 'info'=>'底部推荐保存失败');
            } 
            //修改ES
            $esData = array(
                'id'  => self::LIST_TYPE.'_'.$article_id,
                'data'=> array(
                    'newsSign' => $articleLabel,
                    'imageId'  => $rs->imageId,
                    'imageExt' => $rs->imageExt
                )
            );
            $esRes = CmsEs::update($esData);
            
            $this->commit();
            return array('status'=>0, 'info'=>'底部推荐保存成功');
        } 
        else 
        {
            $this->rollback();
            return array('status'=>1, 'info'=>'底部推荐保存失败');
        }
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

    public function setIntro($intro)
    {
        $this->intro = $intro;
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

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setPv($pv)
    {
        $this->pv = $pv;
    }

    public function setRecommendpark($recommendPark)
    {
        $this->recommendPark = $recommendPark;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function setTurnimage($turnImage)
    {
        $this->turnImage = $turnImage;
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

    public function getIntro()
    {
        return $this->intro;
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

    public function getStatus()
    {
        return $this->status;
    }

    public function getPv()
    {
        return $this->pv;
    }

    public function getRecommendpark()
    {
        return $this->recommendPark;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getTurnimage()
    {
        return $this->turnImage;
    }


    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'blockId'            => 'id', 
            'cityId'             => 'cityId', 
            'userId'             => 'userId', 
            'blockTitle'         => 'title', 
            'blockAuthor'        => 'author', 
            'blockSourceName'    => 'sourceName', 
            'blockIntro'         => 'intro', 
            'blockImageId'       => 'imageId', 
            'blockImageExt'      => 'imageExt', 
            'blockCreateTime'    => 'createTime', 
            'blockModifyTime'    => 'modifyTime', 
            'blockPublishTime'   => 'publishTime', 
            'blockRevokeTime'    => 'revokeTime', 
            'blockStatus'        => 'status', 
            'blockPv'            => 'pv', 
            'blockRecommendPark' => 'recommendPark', 
            'blockComment'       => 'comment', 
            'blockTurnImage'     => 'turnImage'
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
     * @return CmsBlock_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
    
    public function getBlockNewsList($param)
    {
        return self::find($param,0)->toArray();
    }

}
