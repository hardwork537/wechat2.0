<?php
/**
 * @abstract 留言管理Model
 * @author Raul
 * @since  date 2014/9/17
 */
class Gbook extends BaseModel
{
	const CHECK_YES = 1;	//已被查看
	const CHECK_NO = 0;		//未被查看

	const USER_TYPE_BROKER = 1;		//中介 经纪人
	const USER_TYPE_PERSONAL = 2;	//个人
    const USER_TYPE_ADMIN = 3;  //admin用户
	
	const  STATUS_NORMAL = 1;	//正常
	const  STATUS_DEL = 2;		//删除
    
    const HOUSE_TYPE_RENT = 1;  //租房
    const HOUSE_TYPE_SALE = 2;  //二手房
	
	protected $id;
    protected $houseId=0;
    protected $houseType=1;
    protected $houseUrl;
    protected $cityId=0;
    protected $author='';
    protected $realtorId=0;
    protected $type;
    protected $authorId=0;
    protected $authorType;
    protected $contact;
    protected $content;
    protected $time;
    protected $check=0;
    protected $status=1;
    protected $ip;

    public function columnMap ()
    {
        return array(
        		'gbookId'			=>'id',
        		'houseId'			=>'houseId',
        		'houseType'			=>'houseType',
        		'houseUrl'			=>'houseUrl',
        		'cityId'			=>'cityId',
        		'gbookAuthor'		=>'author',
        		'realtorId'			=>'realtorId',
        		'gbookType'			=>'type',
        		'gbookAuthorId'		=>'authorId',
        		'gbookAuthorType'	=>'authorType',
        		'gbookContact'		=>'contact',
        		'gbookContent'		=>'content',
        		'gbookTime'			=>'time',
        		'gbookCheck'		=>'check',
        		'gbookStatus'		=>'status',
        		'gbookIp'			=>'ip',
        );
    }

    public function getSource()
    {
    	return 'vip_gbook';
    }
    
	public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    
    public function addGook( $arrData )
    {
    	
    }
    
    /**
     * 修改留言信息
     * @param unknown $intGbookID
     * @param unknown $intRealtorID
     * @param unknown $arrData
     */
    public function editGbook( $intGbookID, $intRealtorID, $arrData )
    {
    	if( empty($intGbookID) || empty($intRealtorID) )	return false;
    	
    	if( empty($arrData) )	return true;
    	
    	$arrModify = array();
    	if( isset($arrData['check']) )	$arrModify['check']		= $arrData['check'];
    	if( isset($arrData['status']) )	$arrModify['status']	= $arrData['status'];
    	
    	$objGbook = self::findFirst("id = {$intGbookID} and realtorId = {$intRealtorID}");
    	$objGbook->check 	=  isset($arrData['check']) ? $arrData['check'] : $objGbook->check;
    	$objGbook->status 	=  isset($arrData['status']) ? $arrData['status'] : $objGbook->status;
    	return $objGbook->update();
    }
    
    /**
     * 删除留言内容
     * @param unknown $intGbookID
     * @param unknown $intRealtorID
     */
    public function deleteGbook( $intGbookID, $intRealtorID )
    {
    	if( empty($intGbookID) || empty($intRealtorID) )	return false;
    	
    	$objGbook = self::findFirst("id = {$intGbookID} and realtorId = {$intRealtorID}");
    	return $objGbook->delete();
    }
}