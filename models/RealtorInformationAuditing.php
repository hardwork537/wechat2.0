<?php
/**
 * @abstract 经纪人个人信息审核表
 * @author litingwei litingwei@sohu-inc.com
 * @since  2014年10月11日16:12:14
 */
class RealtorInformationAuditing extends BaseModel
{
	//个人信息审核状态
	const STATUS_WAIT = 0;
	const STATUS_YES = 1;
	const STATUS_NO = 2;
	
	public $id;
	public $realId;
    public $cityId;
	public $logoId = 0;
	public $logoExt = 0;
	public $cardId = 0;
	public $cardExt = 0;
	public $status = 0;
	public $create;
    public $updateTime = '0000-00-00 00:00:00';
	public $failure = 0;

	public function getSource()
	{
		return 'realtor_information_auditing';
	}
	
	public function columnMap()
	{
		return array(
				'riId' => 'id',
				'realId' => 'realId',
                'cityId' => 'cityId',
				'riLogoId' => 'logoId',
				'riLogoExt' => 'logoExt',
				'riCardId' => 'cardId',
				'riCardExt' => 'cardExt',
				'riStatus' => 'status',
				'riCreate' => 'create',
				'riFailure'	=> 'failure',
                'riUpdate' => 'updateTime'
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
     * @return RealtorInformationAuditing_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
    
    /**
     * 获取审核拒绝理由
     * @return type
     */
    public static function getDenyReason()
    {
        return array(
            1 => '图片与文字信息不符',
            2 => '图片不清晰',
            3 => '信息不全'
        );
    }
    
    /**
     * 经纪人资料审核
     * @param array $passReals
     * @param array $denyReals
     * @return boolean
     */
    public function auditRealtor($passReals, $denyReals)
    {
        $this->begin();
        if(!empty($denyReals))
        {
            $id = implode(',', array_keys($denyReals));
            $denyAudit = self::find("realId in ({$id}) and status=".self::STATUS_WAIT);
            foreach($denyAudit as $rs)
            {
                $rs->status = self::STATUS_NO;
                $rs->failure = $denyReals[$rs->realId]['reason'];
                $rs->updateTime = date('Y-m-d H:i:s');
                if(!$rs->update())
                {
                    $this->rollback();
                    return false;
                }
            }
        }
        if(!empty($passReals))
        {
            $id = implode(',', array_keys($passReals));
            $passAudit = self::find("realId in ({$id}) and status=".self::STATUS_WAIT);
            //修改审核表状态
            foreach($passAudit as $rs)
            {
                $rs->status = self::STATUS_YES;
                $rs->updateTime = date('Y-m-d H:i:s');
                if(!$rs->update())
                {
                    $this->rollback();
                    return false;
                }
            }
            
            foreach($passReals as $id=>$v)
            {
                $realtor = Realtor::findFirst($id);
                $realtor->logoId = intval($v['logoId']);
                $realtor->logoExt = $v['logoExt'];
                //$realtor->mobile = $v['mobile'];
                if(!$realtor->update())
                {
                    $this->rollback();
                    return false;
                }
                
                $realcard = RealtorAttach::findFirst("realId={$id} and type=".RealtorAttach::TYPE_BZCARD);
                if($realcard)
                {
                    $realcard->imgId = intval($v['cardId']);
                    $realcard->imgExt = $v['cardExt'];
                    $realcard->status = RealtorAttach::STATUS_TRUE;
                    $realcard->update = date('Y-m-d H:i:s');
                    if(!$realcard->update())
                    {
                        $this->rollback();
                        return false;
                    }
                }
                else
                {
                    $realcard = RealtorAttach::instance(false);
                    $realcard->realId = $id;
                    $realcard->imgId = intval($v['cardId']);
                    $realcard->imgExt = $v['cardExt'];
                    $realcard->status = RealtorAttach::STATUS_TRUE;
                    $realcard->type = RealtorAttach::TYPE_BZCARD;
                    if(!$realcard->create())
                    {
                        $this->rollback();
                        return false;
                    }
                }
            }
        }
            
        $this->commit();
        return true;
    }
}

