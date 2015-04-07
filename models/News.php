<?php
/**
 * @abstract 焦点通资讯
 * @author litingwei litingwei@sohu-inc.com
 * @since  2014年9月13日18:03:14
 */
class News extends BaseModel
{
	const sAuth = 'FOCUSERSHOUFANGNEWS';//双方约定字符串
	
	public $id;
	public $title;
	public $author;
	public $create;
	public $nid;
	public $sourceName;
	public $summary;
	public $graphContent;
	public $sid;
	public $cityId;
	public $click;
	public $update;

	public function getSource()
	{
		return 'vip_news';
	}
	
	public function columnMap()
	{
		return array(
				'newsId' => 'id',
				'newsTitle' => 'title',
				'newsAuthor' => 'author',
				'newsCreate' => 'create',
				'newsNid' => 'nid',
				'newsSourceName' => 'sourceName',
				'newsSummary' => 'summary',
				'newsGraphContent' => 'graphContent',
				'newsSid' => 'sid',
				'cityId' => 'cityId',
				'newsClick' => 'click',
				'newsUpdate' => 'update',				
		);
	}

	public function initialize()
	{
		$this->setReadConnectionService('esfSlave');
		$this->setWriteConnectionService('esfMaster');
	}
	
	/**
	 * @abstract根据NID查找该新闻是否存在
	 * @param unknown_type $nid
	 */
	public function getIdByNid($nid)
	{
        return self::getAll(" nid = $nid",'','','','id, sid, cityId');
	}
}
