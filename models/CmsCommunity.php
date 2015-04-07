<?php

class CmsCommunity extends BaseModel
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
    protected $pv = 0;
    protected $status = self::STATUS_PENDING;

    const STATUS_PENDING = 1;   //待发布
    const STATUS_PUBLISH = 2;   //已发布
    const STATUS_REVOKE  = 3;   //撤回
    
    const LIST_TYPE = 3;
    
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
     * 新增文章
     * @param type $data
     * @return boolean
     */
    public function add($data)
    {
        if(empty($data))
        {
            return false;
        }
        $this->begin();
        
        $rs = self::instance();
        $rs->cityId = $data['cityId'];
        $rs->title = $data['title'];
        $rs->sourceName = $data['sourceName'];
        $rs->intro = $data['intro'];
        $rs->imageId = $data['imageId'];
        $rs->imageExt = $data['imageExt'];
        $rs->author = $data['author'];
        $rs->userId = $data['userId'];
        $rs->createTime = time();
        $rs->modifyTime = time();
        //添加到主表 cms_community
        if($rs->create())
        {
            $commId = $rs->id;
            $sql = "INSERT into cms_community_recommend(commId, parkId, crRecommendReason, crWeight) VALUES";
            foreach($data['parks'] as $k=>$v)
            {
                $weight = $k + 1;
                $reason = $v['reason'];
                $sql .= "({$commId},{$v['parkId']},'{$reason}',{$weight}),";
            }
            $sql = rtrim($sql, ',');
            if($this->execute($sql))
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
                    'imageId'   => $rs->imageId,
                    'imageExt'  => $rs->imageExt
                );
                $esRes = CmsEs::add($esArr);
                
                $this->commit();
                return true;
            }
            else
            {
                $this->rollback();
                return false;
            }
        }
        $this->rollback();
        return false;
    }
    
    /**
     * 编辑文章
     * @param int  $id
     * @param type $data
     * @return boolean
     */
    public function edit($id, $data)
    {
        if(empty($data) || !$id)
        {
            return false;
        }
        $this->begin();
        
        $rs = self::findFirst("id={$id}");
        $rs->title = $data['title'];
        $rs->sourceName = $data['sourceName'];
        $rs->intro = $data['intro'];
        $rs->imageId = $data['imageId'];
        $rs->imageExt = $data['imageExt'];
        $rs->modifyTime = time();
        //修改主表 cms_community
        if($rs->update())
        {
            $delSql = "DELETE from cms_community_recommend where commId={$id}";
            if(!$this->execute($delSql))
            {
                $this->rollback();
                return false;
            }
            $insertSql = "INSERT into cms_community_recommend(commId, parkId, crRecommendReason, crWeight) VALUES";
            foreach($data['parks'] as $k=>$v)
            {
                $weight = $k + 1;
                $reason = $v['reason'];
                $insertSql .= "({$id},{$v['parkId']},'{$reason}',{$weight}),";
            }
            $insertSql = rtrim($insertSql, ',');
            if($this->execute($insertSql))
            {
                //修改 ES
                $esData = array(
                    'id'   => self::LIST_TYPE.'_'.$id,
                    'data' => array(
                        'newsTitle' => $rs->title,
                        'newsDesc'  => $rs->intro,
                        'imageId'   => $rs->imageId,
                        'imageExt'  => $rs->imageExt
                    )
                );
                $esRes = CmsEs::update($esData);
                
                $this->commit();
                return true;
            }
            else
            {
                $this->rollback();
                return false;
            }
        }
        $this->rollback();
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
                return false;
            }
            //修改ES状态  
            $esArr['data']['newsStatus'] = $v->status;
            $res = CmsEs::update($esArr);
        }
        
        return true;
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

    public function setPv($pv)
    {
        $this->pv = $pv;
    }

    public function setStatus($status)
    {
        $this->status = $status;
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

    public function getPv()
    {
        return $this->pv;
    }

    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'commId'          => 'id', 
            'cityId'          => 'cityId', 
            'userId'          => 'userId', 
            'commTitle'       => 'title', 
            'commAuthor'      => 'author', 
            'commSourceName'  => 'sourceName', 
            'commIntro'       => 'intro', 
            'commImageId'     => 'imageId', 
            'commImageExt'    => 'imageExt', 
            'commCreateTime'  => 'createTime', 
            'commModifyTime'  => 'modifyTime', 
            'commPublishTime' => 'publishTime', 
            'commRevokeTime'  => 'revokeTime', 
            'commPv'          => 'pv', 
            'commStatus'      => 'status'
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
     * @return CmsCommunity_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
    
    public function getHouseNewsList($param)
    {
        return self::find($param,0)->toArray();
    }

}
