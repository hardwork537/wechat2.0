<?php

class CmsBlockContent extends BaseModel
{
    protected $id;
    protected $blockId;
    protected $title;
    protected $recommendPark;
    protected $summary;
    protected $content;
    protected $weight;
    
    /**
     * 保存板块置业正文内容
     * @param int   $id
     * @param array $data
     * @return array
     */
    public function updateContent($id, $data) 
    {
        if(empty($id) || empty($data)) 
        {
            return array('status'=>1, 'info'=>'正文保存失败');
        }
        $this->begin();
        $deleteSql = "DELETE FROM cms_block_content WHERE blockId={$id}";
        if($this->execute($deleteSql)) 
        {
            //添加到表 cms_block_content 中
            $insertSql = "INSERT into cms_block_content(`blockId`,`bcTitle`,`bcRecommendPark`,`bcContent`,`bcSummary`,`bcWeight`) VALUES";
            foreach($data['article_contents'] as $k=>$v) 
            {
                $weight = $k + 1;
                extract($v);
                $recommendPark = empty($parkId) ? '' : implode(',', $parkId);
                
                $insertSql .= "({$id},'{$title}','{$recommendPark}','{$content}','{$summary}',{$weight}),";
            }

            $insertSql = rtrim($insertSql, ',');
            if(!$this->execute($insertSql))
            {
                $this->rollback();
                return array('status'=>1, 'info'=>'正文保存失败');
            }
            $comment = array();
            $comment[] = array(
                'id'      => $data['editor_id'],
                'type'    => CmsBlock::COMMENT_EDITOR,
                'comment' => $data['editor_comment']
            );
            foreach($data['broker_comments'] as $v) 
            {
                $value = array();
                $value['id'] = $v['id'];
                $value['type'] = CmsBlock::COMMENT_REALTOR;
                $value['comment'] = $v['comment'];
                
                $comment[] = $value;
            }
            //更新 cms_block 中的 comment 字段
            $rs = CmsBlock::findFirst("id={$id}");
            $rs->comment = json_encode($comment);
            $rs->modifyTime = time();
            if($rs->update())
            {
                $this->commit();
                return array('status'=>0, 'info'=>'正文保存成功');
            }
            else
            {
                $this->rollback();
                return array('status'=>1, 'info'=>'正文保存失败');
            }
        } 
        else 
        {
            $this->rollback();
            return array('status'=>1, 'info'=>'正文保存失败');
        }
        
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setRecommendpark($recommendPark)
    {
        $this->recommendPark = $recommendPark;
    }

    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getRecommendpark()
    {
        return $this->recommendPark;
    }

    public function getSummary()
    {
        return $this->summary;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public static function find($parameters = array())
    {
        return parent::find($parameters);
    }

    public static function findFirst($parameters = array())
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return array(
            'bcId'            => 'id', 
            'blockId'         => 'blockId',
            'bcTitle'         => 'title', 
            'bcRecommendPark' => 'recommendPark', 
            'bcSummary'       => 'summary', 
            'bcContent'       => 'content', 
            'bcWeight'        => 'weight'
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
     * @return CmsBlockContent_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
}
