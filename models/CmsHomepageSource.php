<?php

class CmsHomepageSource extends BaseModel
{
    protected $id;
    protected $cityId;
    protected $type;
    protected $name;
    protected $imageId = 0;
    protected $imageExt = '';
    protected $title;
    protected $author;
    protected $modifyTime;
    protected $desc = '';
    protected $linkUrl;
    protected $weight = 1;
    protected $pv = 0;
    
    const TYPE_IMAGE   = 1;     //焦点图
    const TYPE_BLOCK   = 2;     //热门板块
    const TYPE_DYNAMIC = 3;     //业内动态
    const TYPE_ACTIVE  = 4;     //专题活动
    
    /**
     * 返回所有位置
     * @return array
     */
    public static function getAllTypes() 
    {
        return array(
            self::TYPE_IMAGE   => '焦点图',
            self::TYPE_BLOCK   => '热门板块',
            self::TYPE_DYNAMIC => '业内动态',
            self::TYPE_ACTIVE  => '专题活动',
        );
    }
    
    /**
     * 更新专题活动
     * @param int    $type
     * @param int    $source_id
     * @param array  $author
     * @param array  $new_data
     * @param array  $old_data
     * @return boolean
     */
    public function updateSource($type, $source_id, $userinfo, $new_data, $old_data) 
    {
        if(self::TYPE_ACTIVE == $type) 
        {
            $data = $this->_build_active_data($source_id, $userinfo, $new_data, $old_data);
        } 
        elseif(self::TYPE_BLOCK == $type) 
        {
            $data = $this->_build_block_data($source_id, $userinfo, $new_data, $old_data);
        } 
        elseif(self::TYPE_DYNAMIC == $type) 
        {
            return $this->_update_dynamic($source_id, $userinfo, $new_data);
        } 
        elseif(self::TYPE_IMAGE == $type) 
        {
            $data = $this->_build_image_data($source_id, $userinfo, $new_data, $old_data);
        } 
        else 
        {
            return false;
        }
        
        $source_data = $data['source_data'];
        $history_data = $data['history_data'];
               
        $this->begin();
      
        $rs = self::findFirst("id={$source_id}");
        foreach($source_data as $k=>$v)
        {
            $rs->$k = $v;
        }
        
        if($rs->update()) 
        {
            $ds = CmsHomepageHistory::instance();
            foreach($history_data as $k=>$v)
            {
                $ds->$k = $v;
            }
            
            if($ds->create()) 
            {
                $this->commit();
                return true;
                
            } 
            else 
            {
                $this->rollback();
                return false;
            }
        } 
        else 
        {
            $this->rollback();
            return false;
        }
    }
    
    private function _build_image_data($source_id, $userinfo, $new_data, $old_data) 
    {
        $source_data = array(
            'imageId'    => $new_data['imageId'],
            'imageExt'   => $new_data['imageExt'],
            'linkUrl'    => $new_data['linkUrl'],
            'title'      => $new_data['title'],       
            'desc'       => $new_data['desc'],
            'author'     => $userinfo['userName'],
            'modifyTime' => time()
        );
        $history_data = array(
            'sourceId'   => $source_id,
            'cityId'     => $old_data['cityId'],
            'userId'     => $userinfo['userId'],
            'author'     => $userinfo['userName'],
            'modifyTime' => time()
        );
        $old_content = array(
            'imageId'  => $old_data['imageId'],
            'imageExt' => $old_data['imageExt'],
            'title'    => $old_data['title'],
            'desc'     => $old_data['desc'],
            'linkUrl'  => $old_data['linkUrl']
        );
        $history_data['sourceContent'] = json_encode($old_content);
        
        return array('source_data'=>$source_data, 'history_data'=>$history_data);
    }
    
    private function _update_dynamic($city_id, $userinfo, $data) 
    {
        $condition = array(
            'conditions' => "cityId={$city_id} and type=".self::TYPE_DYNAMIC,
            'order'      => 'id asc'
        );
        $dynamics = self::find($condition, 0)->toArray();
        $dynamic_list = array();
        foreach($dynamics as $v) 
        {
            $dynamic_list[] = $v;
        }
        $this->begin();

        if(count($dynamic_list) != count($data)) 
        {        
            $deleteSql = "DELETE FROM cms_homepage_source WHERE cityId={$city_id} AND type=".self::TYPE_DYNAMIC;
            if(!$this->execute($deleteSql)) 
            {
                $this->rollback();
                return false;
            }
            $insertSql = "INSERT INTO cms_homepage_source(cityId,imageId,imageExt,title,author,type,linkUrl,sourceName,modifyTime) VALUES";
            foreach($data as $v) 
            {
                $title = $v['title'];
                $linkUrl = $v['linkUrl'];
                $imageId = $v['imageId'] ? $v['imageId'] : 0;
                $imageExt = $v['imageExt'] ? $v['imageExt'] : '';
                $author = $userinfo['userName'];
                $modifyTime = time();
                
                $insertSql .= "({$city_id},{$imageId},'{$imageExt}','{$title}','{$author}','{$linkUrl}','动态',{$modifyTime}),";
                $insertSql = rtrim($insertSql,',');
                if(!$this->execute($insertSql)) 
                {
                    $this->rollback();
                    return false;
                }
            }
            $this->commit();
            return true;
        } 
        else 
        {
            foreach($data as $k=>$v) 
            {            
                $old_data = $dynamic_list[$k];

                $rs = self::findFirst("id={$old_data['id']}");
                $rs->title = $v['title'];
                $rs->author = $userinfo['userName'];
                $rs->linkUrl = $v['linkUrl'];
                $rs->modifyTime = time();
                $rs->imageId = $v['imageId'] ? $v['imageId'] : 0;
                $rs->imageExt = $v['imageExt'] ? $v['imageExt'] : '';
                
                if(!$rs->update())
                {
                    $this->rollback();
                    return false;
                }
                
                $history_data = array(
                    'sourceId' => $old_data['id'],
                    'cityId'   => $old_data['cityId'],
                    'author'   => $userinfo['userName'],
                    'userId'   => $userinfo['userId'],
                    'modifyTime'=>time()
                );
                $history_content = array(
                    'title'   => $old_data['title'],
                    'linkUrl' => $old_data['linkUrl']
                );
                if($old_data['imageId'] && $old_data['imageExt']) 
                {
                    $history_content['imageId'] = $old_data['imageId'];
                    $history_content['imageExt'] = $old_data['imageExt'];
                }
                $history_data['sourceContent'] = json_encode($history_content);
                
                $ds = CmsHomepageHistory::instance(false);
                foreach($history_data as $k=>$v)
                {
                    $ds->$k = $v;
                }
                if(!$ds->create()) 
                {
                    $this->rollback();
                    return false;
                }
            }
            $this->commit();
            return true;
        }
    }
    private function _build_active_data($source_id, $userinfo, $new_data, $old_data) {
        $source_data = array(
            'imageId'    => $new_data['imageId'],
            'imageExt'   => $new_data['imageExt'],
            'linkUrl'    => $new_data['linkUrl'],
            'title'      => $new_data['title'],
            'author'     => $userinfo['userName'],
            'modifyTime' => time()
        );
        $history_data = array(
            'sourceId'   => $source_id,
            'cityId'     => $old_data['cityId'],
            'author'     => $userinfo['userName'],
            'userId'     => $userinfo['userId'],
            'modifyTime' => time()
        );
        $old_content = array(
            'imageId'  => $old_data['imageId'],
            'imageExt' => $old_data['imageExt'],
            'title'    => $old_data['title'],
            'linkUrl'  => $old_data['linkUrl']
        );
        $history_data['sourceContent'] = json_encode($old_content);
        
        return array('source_data'=>$source_data, 'history_data'=>$history_data);
    }
    
    private function _build_block_data($source_id, $userinfo, $new_data, $old_data) {
        $source_data = array(
            'imageId'    => $new_data['imageId'],
            'imageExt'   => $new_data['imageExt'],
            'linkUrl'    => $new_data['linkUrl'],
            'title'      => $new_data['title'],
            'author'     => $userinfo['userName'],
            'desc'       => $new_data['desc'],
            'modifyTime' => time()
        );
        $history_data = array(
            'sourceId'   => $source_id,
            'cityId'     => $old_data['cityId'],
            'author'     => $userinfo['userName'],
            'userId'     => $userinfo['userId'],
            'modifyTime' => time()
        );
        $old_content = array(
            'imageId'  => $old_data['imageId'],
            'imageExt' => $old_data['imageExt'],
            'title'    => $old_data['title'],
            'linkUrl'  => $old_data['linkUrl'],
            'desc'     => $old_data['desc']
        );
        $history_data['sourceContent'] = json_encode($old_content);
        
        return array('source_data'=>$source_data, 'history_data'=>$history_data);
    }
    
    public function setSourceid($sourceId)
    {
        $this->id = $sourceId;
    }

    public function setCityid($cityId)
    {
        $this->cityId = $cityId;
    }

    public function setSourcetype($sourceType)
    {
        $this->type = $sourceType;
    }

    public function setSourcename($sourceName)
    {
        $this->name = $sourceName;
    }

    public function setImageid($imageId)
    {
        $this->imageId = $imageId;
    }

    public function setImageext($imageExt)
    {
        $this->imageExt = $imageExt;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function setModifytime($modifyTime)
    {
        $this->modifyTime = $modifyTime;
    }

    public function setDesc($desc)
    {
        $this->desc = $desc;
    }

    public function setLinkurl($linkUrl)
    {
        $this->linkUrl = $linkUrl;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function setPv($pv)
    {
        $this->pv = $pv;
    }

    public function getSourceid()
    {
        return $this->id;
    }

    public function getCityid()
    {
        return $this->cityId;
    }

    public function getSourcetype()
    {
        return $this->type;
    }

    public function getSourcename()
    {
        return $this->name;
    }

    public function getImageid()
    {
        return $this->imageId;
    }

    public function getImageext()
    {
        return $this->imageExt;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getModifytime()
    {
        return $this->modifyTime;
    }

    public function getDesc()
    {
        return $this->desc;
    }

    public function getLinkurl()
    {
        return $this->linkUrl;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getPv()
    {
        return $this->pv;
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'sourceId'         => 'id', 
            'cityId'           => 'cityId', 
            'sourceType'       => 'type', 
            'sourceName'       => 'name', 
            'sourceImageId'    => 'imageId', 
            'sourceImageExt'   => 'imageExt', 
            'sourceTitle'      => 'title', 
            'sourceAuthor'     => 'author', 
            'sourceModifyTime' => 'modifyTime', 
            'sourceDesc'       => 'desc', 
            'sourceLinkUrl'    => 'linkUrl', 
            'sourceWeight'     => 'weight', 
            'sourcePv'         => 'pv'
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
     * @return CmsHomepageSource_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
}
