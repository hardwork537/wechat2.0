<?php
/**
 * @abstract 经纪人常用刷新定时方案表
 * @author Raul
 * @since  date 2014/9/24
 */
class VipRefreshScheme extends BaseModel
{
	public $id;
	public $realId;
	public $no;
	public $scheme;
	public $default;
	
	const DEFAULT_YES = 1;	//默认方案
	const DEFAULT_NO  = 0;	//非默认方案
	
	public function columnMap()
	{
		return array(
   			'rsId' => 'id',
			'realId' => 'realId',
			'rsNo' => 'no',
			'rsScheme' => 'scheme',
            'rsDefault'=>'default',
		);
	}
	
	public function initialize()
	{
		$this->setReadConnectionService('esfSlave');
		$this->setWriteConnectionService('esfMaster');
	}

    public function getSource()
    {
        return 'vip_refresh_scheme';
    }
    
    /**
     * 实例化对象
     * @param type $cache
     * @return Port_Model
     */
    public static function instance($cache = true)
    {
    	return parent::_instance(__CLASS__, $cache);
    }
    
    /**
     * 添加定时方案
     * @param unknown $arrData
     */
    public function addScheme($arrData)
    {
    	if(empty($arrData))	return false;
    	
    	$arrInsert = array();
    	
    	if(isset($arrData['realId']))
    	{
    		$arrInsert['realId'] = $arrData['realId'];
    	}
    	if(isset($arrData['no']))
    	{
    		$arrInsert['no'] = $arrData['no'];
    	}
    	else
    	{
    		$intNO = 1;
    		$objScheme = self::findFirst("realId={$GLOBALS['client']['realId']} order by no desc");
    		if($objScheme)
    		{
    			$intNO = (int)$objScheme->no + 1;
    		}
    		$arrInsert['no'] = $intNO;
    	}
    	if(isset($arrData['scheme']))
    	{
    		$arrInsert['scheme'] = $arrData['scheme'];
    	}
    	if(isset($arrData['default']))
    	{
    		$arrInsert['default'] = $arrData['default'];
    	}
    	
    	return self::create($arrInsert);
    }
    
    /**
     * 编辑定时方案
     * @param unknown $arrData
     */
    public function editScheme($intID,$arrData)
    {
    	if(empty($arrData) || empty($intID))	return false;
    	 
    	$arrUpdate = array();
    	 
    	if(isset($arrData['realId']))
    	{
    		$arrUpdate['realId'] = $arrData['realId'];
    	}
    	if(isset($arrData['no']))
    	{
    		$arrUpdate['no'] = $arrData['no'];
    	}
    	if(isset($arrData['scheme']))
    	{
    		$arrUpdate['scheme'] = $arrData['scheme'];
    	}
    	if(isset($arrData['default']))
    	{
    		$arrUpdate['default'] = $arrData['default'];
    	}
    	$objScheme = self::findFirst("realId={$GLOBALS['client']['realId']} and id = {$intID}");
    	return $objScheme->update($arrUpdate);
    }
}
