<?php
/**
 * @abstract 焦点通资讯扩展
* @author litingwei litingwei@sohu-inc.com
* @since  2014年9月13日18:11:14
*/
class NewsExt extends BaseModel
{
	public $id;
	public $content;
	
	public function getSource()
	{
		return 'vip_news_ext';
	}

	public function columnMap()
	{
		return array(
				'newsId' => 'id',
				'newsContent' => 'content',
		);
	}

	public function initialize()
	{
		$this->setReadConnectionService('esfSlave');
		$this->setWriteConnectionService('esfMaster');
	}
}
