<?php
/**
 * @abstract 经纪人短信设置
 * @author jackchen
 * @since  2014-09-16
 */
class VipSmsRemind extends BaseModel
{
	public $id;
	public $realId;
	public $time;
	public $count;
	public $flush;
	public $recommend;
	public $new;
	public $flag;
    public $park;
    public $create;

	public function columnMap()
	{
		return array(
   			'remindId' => 'id',
			'realId' => 'realId',
			'remindTime' => 'time',
			'rateCount' => 'count',
			'rateFlush' => 'flush',
			'rateRecommend' => 'recommend',
			'rateNew' => 'new',
			'rateFlag' => 'flag',
            'ratePark' => 'park',
            'createTime' => 'create',
		);
	}
	
	public function initialize()
	{
		$this->setReadConnectionService('esfSlave');
		$this->setWriteConnectionService('esfMaster');
	}

    public function getSource()
    {
        return 'vip_sms_remind';
    }

    /**
     * 实例化
     * @param boolean $cache
     * @return Model
     */
    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }

    /**
     * 根据经纪人ID，获取短信设置
     * @param   int   $realId
     * @return  array $data
     */
    public function getSmsByRealtorId($realId)
    {
        if(!$realId){
            return false;
        }
        $arrCond  = "realId = ?1";
        $arrParam = array(1=>$realId);
        $data = self::findFirst(
            array(
                $arrCond,
                "bind" => $arrParam
            ),0
        );
        return $data->toArray();
    }

    /**
     * 根据经纪人ID，删除短信设置
     * @param unknown $realId
     */
	public function deleteSmsByRealtorId($realId)
	{
		if( empty($realId) )	return false;
		
		$objSms = self::findFirst("realId={$realId}");
		return $objSms->delete();
	}
	
	/**
	 * 根据经纪人ID，编辑短信设置
	 * @param unknown $realId
	 */
	public function editSmsByRealtorId($realId, $arrData, $opType = 'add')
	{
		if( empty($realId) || empty($arrData) )	return false;
		
		if( $opType == 'add' )
		{
			return self::create($arrData);
		}
		else 
		{
			$obj = self::findFirst("realId ={$realId}");
			$obj->time 		= $arrData['time'];
			$obj->count 	= $arrData['count'];
			$obj->flush 	= $arrData['flush'];
			$obj->recommend = $arrData['recommend'];
			$obj->new 		= $arrData['new'];
			$obj->flag 		= $arrData['flag'];
			$obj->park 		= $arrData['park'];
			return $obj->update();
		}
	}

}
