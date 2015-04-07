<?php
/**
 * @abstract 公司描述信息表
 * @author weiliting litingwei@sohu-inc.com
 * @since  2014年9月25日11:35:03
 */
class CompanyMore extends BaseModel
{
	public $id;
	public $comId;
	public $name;
	public $text;
	public $length;
	public $status;
	public $update;

	public function columnMap()
	{
		return array(
				'cmId' => 'id',
				'comId' => 'comId',
				'cmName' => 'name',
				'cmText' => 'text',
				'cmLength' => 'length',
				'cmStatus' => 'status',
				'cmUpdate' => 'update',
		);
	}

	public function initialize()
	{
		$this->setReadConnectionService('esfSlave');
		$this->setWriteConnectionService('esfMaster');
	}
}	