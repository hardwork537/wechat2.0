<?php

class Notice extends BaseModel
{
	const PAGESIZE = 20;//列表最多条数
	
    protected $id;
    protected $cityId;
    protected $comId;
    protected $title;
    protected $titleBold;
    protected $titleRed;
    protected $content;
    protected $createTime;
    protected $author;
    /**
     * Method to set the value of field noticeId
     *
     * @param integer $noticeId
     * @return $this
     */
    public function setNoticeid($noticeId)
    {
        $this->id = $noticeId;
        return $this;
    }
    /**
     * Method to set the value of field cityId
     *
     * @param integer $cityId
     * @return $this
     */
    public function setCityid($cityId)
    {
        $this->cityId = $cityId;
        return $this;
    }
    /**
     * Method to set the value of field comId
     *
     * @param integer $comId
     * @return $this
     */
    public function setComid($comId)
    {
        $this->comId = $comId;
        return $this;
    }
    /**
     * Method to set the value of field noticeTitle
     *
     * @param string $noticeTitle
     * @return $this
     */
    public function setNoticetitle($noticeTitle)
    {
        $this->title = $noticeTitle;
        return $this;
    }
    /**
     * Method to set the value of field noticeTitleBold
     *
     * @param integer $noticeTitleBold
     * @return $this
     */
    public function setNoticetitlebold($noticeTitleBold)
    {
        $this->titleBold = $noticeTitleBold;
        return $this;
    }
    /**
     * Method to set the value of field noticeTitleRed
     *
     * @param integer $noticeTitleRed
     * @return $this
     */
    public function setNoticetitlered($noticeTitleRed)
    {
        $this->titleRed = $noticeTitleRed;
        return $this;
    }

    /**
     * Method to set the value of field noticeContent
     *
     * @param string $noticeContent
     * @return $this
     */
    public function setNoticecontent($noticeContent)
    {
        $this->content = $noticeContent;
        return $this;
    }

    /**
     * Method to set the value of field noticeCreateTime
     *
     * @param string $noticeCreateTime
     * @return $this
     */
    public function setNoticecreatetime($noticeCreateTime)
    {
        $this->createTime = $noticeCreateTime;
        return $this;
    }

    /**
     * Method to set the value of field noticeAuthor
     *
     * @param string $noticeAuthor
     * @return $this
     */
    public function setNoticeauthor($noticeAuthor)
    {
        $this->author = $noticeAuthor;
        return $this;
    }

    /**
     * Returns the value of field noticeId
     *
     * @return integer
     */
    public function getNoticeid()
    {
        return $this->id;
    }

    /**
     * Returns the value of field cityId
     *
     * @return integer
     */
    public function getCityid()
    {
        return $this->cityId;
    }

    /**
     * Returns the value of field comId
     *
     * @return integer
     */
    public function getComid()
    {
        return $this->comId;
    }

    /**
     * Returns the value of field noticeTitle
     *
     * @return string
     */
    public function getNoticetitle()
    {
        return $this->title;
    }

    /**
     * Returns the value of field noticeTitleBold
     *
     * @return integer
     */
    public function getNoticetitlebold()
    {
        return $this->titleBold;
    }

    /**
     * Returns the value of field noticeTitleRed
     *
     * @return integer
     */
    public function getNoticetitlered()
    {
        return $this->titleRed;
    }

    /**
     * Returns the value of field noticeContent
     *
     * @return string
     */
    public function getNoticecontent()
    {
        return $this->content;
    }

    /**
     * Returns the value of field noticeCreateTime
     *
     * @return string
     */
    public function getNoticecreatetime()
    {
        return $this->createTime;
    }

    /**
     * Returns the value of field noticeAuthor
     *
     * @return string
     */
    public function getNoticeauthor()
    {
        return $this->author;
    }

    public function getSource()
    {
    	return 'vip_notice';  
    }
    
    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'noticeId' => 'id',
            'cityId' => 'cityId',
            'comId' => 'comId',
            'noticeTitle' => 'title',
            'noticeTitleBold' => 'titleBold',
            'noticeTitleRed' => 'titleRed',
            'noticeContent' => 'content',
            'noticeCreateTime' => 'createTime',
            'noticeAuthor' => 'author'
        );
    }

    /**
     * 实例化对象
     *
     * @param type $cache
     * @return \Users_Model
     */
    public static function instance ($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self();
    }

    /**
     * 添加公告
     *
     * @param array $arr
     * @return boolean
     */
    public function add ($arr)
    {

        $rs = self::instance();
        $rs->cityId = intval($arr["cityId"]);
        $rs->title = $arr["title"];
        $rs->titleBold =intval($arr["titleBold"]) ;
        $rs->titleRed = intval($arr["titleRed"]);
        $rs->content = $arr["content"];
        $rs->comId = intval($arr["comId"]);
        $rs->createTime = date("Y-m-d H:i:s");
        $rs->author = $arr["author"];
        if ($rs->create()) {
            return true;
        }
        return false;
    }

    /*
     * @desc 修改
     * */
    public function edit ($id,$arr)
    {
        $data = array(
            'cityId' => intval($arr["cityId"]),
            'title' => $arr["title"],
            'titleBold' => intval($arr["titleBold"]),
            'titleRed' => intval($arr["titleRed"]),
            'content' => $arr["content"],
            'comId' => intval($arr["comId"]),
            'author' => $arr["author"]
        );
        $id = intval($id);
        $rs =  self::findFirst($id);

        return $rs->update($data);
    }

    /**
     * 删除
     *
     * @param type $id
     * @return type
     */
    public function del ($id)
    {
        $rs = self::findFirst($id);
        if ($rs->delete()) {
            return true;
        }
        return false;
    }

    public function initialize ()
    {
        $this->setConn('esf');
    }

    /**
     * 查询公告信息(只获取第一页(20条)信息，做了缓存机制)
     * @param $cityId 所查的城市
     * @param $companyId 所查的公司
     * @param $size memcache缓存的条数 调用memcache的条数不一致，为防止mem数据重复，所以采用了截取，最大上限20条
     * @notice key值改变要考虑admin.51f.com/fs_notices.php  最后的函数flushMemcache();
     * @return array
     */
    public function getNotices($cityId, $comId, $size=self::PAGESIZE, $page=1) 
    {
    	if( empty($cityId) )
    	{
    		$this->error = '城市id为空！';
    		return false;
    	}
    	if( empty($comId) ){
    		$this->error = '公司id为空！';
    		return false;
    	}
    	$cityId = intval($cityId);
    	$comId = intval($comId);
//     	$memKey = MCDefine::NOTICES.$city_id;
//     	$objMem = FSMC::Instance($GLOBALS['CONFIG_MEMCACHE_DEFAULT']);
//     	$dataMEM = $objMem->Get($memKey);
    	if( empty($dataMEM[$comId]) ){
    		$where = "(cityId = $cityId and comId = $comId) or (cityId = 0 and comId = 0) or (cityId = $cityId and comId = 0)";
    		$data = self::getAll($where,' createTime desc', 0, self::PAGESIZE, 'id');
    		$count = self::getCount($where);
    		$ids = array();
    		foreach($data as &$val){
    			$ids[] = $val['id'];
    		}
    		$dataMEM[$comId] = array('ids'=>$ids, 'count'=>$count);
//     		$objMem->Set($memKey, $dataMEM, 3600);//放入memcache
    	}
    	//当第二页时，不执行查询数据库了
    	if( intval($page)>1 )
    	{
    		return array('data'=>$dataMEM[$comId]['ids'], 'count'=>$dataMEM[$comId]['count']);
    	}
    
    	$select = 'id,title,titleBold,titleRed,createTime';
    	$arrId = array_slice($dataMEM[$comId]['ids'], 0, $size);
    	if(!empty($arrId))
    	{
	    	$result = self::getAll(" id in (".implode(',', $arrId).")", 'createTime  DESC', 0, 0, $select);
	    	for($i =0;$i<count($result);$i++)
	    	{
	    		$result[$i]['create'] = date('Y-m-d', strtotime($result[$i]['createTime']));
	    	}
    	}
    	else 
    	{
    		$result = array();
    	}
    	return array('data'=>$result, 'count'=>$dataMEM[$comId]['count']);
    }
    
    /**
     * 查询公告信息(包括第二页)
     * @param $city_id 所查的城市
     * @param $company_id 所属公司id
     * @return array('data'=>'公告列表数据', 'pageData'=>'分页')
     */
    public function getAllNotices($city_id, $company_id,$page=1) {
    	if( empty($city_id) ){
    		$this->error = '城市id为空！';
    		return false;
    	}
    	if( empty($company_id) ){
    		$this->error = '公司id为空！';
    		return false;
    	}
    	$pageSize = self::PAGESIZE;
    	$temp = $this->getNotices($city_id, $company_id);
    	$maxPage = ceil($temp['count']/$pageSize);
    	if( $page>$maxPage && $maxPage>=1 )
    	{
    		$page = $maxPage;
    	}
    	//========== ========== 第一页 ========== ==========
    	if( $page == 1)
    	{
    		$data = $temp;
    		$pageData = Page::vipPage($temp['count'], 1, $pageSize);
    		return array('data'=>$data['data'], 'pageData'=>$pageData, 'page'=>$page);
    	}
    	//========== ========== 非第一页 ========== ==========

    	$where = "(cityId = $city_id and comId = $company_id) or (cityId = 0 and comId = 0) or (cityId = $city_id and comId = 0)";
    	$select  = 'id,title,titleBold,titleRed,createTime';
    	$data = self::getAll($where, ' createTime desc', ($page-1)*$pageSize, $pageSize, $select);
        for($i=0;$i<count($data);$i++)
        {
        	$data[$i]['create'] = substr($data[$i]['createTime'],0,10);
        }        
    	$pageData = Page::vipPage($temp['count'], $page, $pageSize);
    	return array('data'=>$data, 'pageData'=>$pageData);
    }
}
