<?php
/**
 * @abstract  400电话绑定、解绑
 * @copyright Sohu-inc Team.
 * @author    Tony (tonyzhao@sohu-inc.com)
 * @date      2015-01-23 11:12:18
 */

class Phone400BindLog extends BaseModel {
    
    //操作频道来源
    const FROM_SYSTEM = 1;   //系统
    const FROM_ADMIN  = 2;   //admin
    
    //操作类型
    const TYPE_BIND   = 1;  //绑定
    const TYPE_UNBIND = 2;  //解绑
    
	public $id;
    public $cityId;
	public $realId;
	public $parkId;
    public $bindMonth;
	public $phonePre;
	public $phoneExt;
    public $operateFrom;
    public $operateType;
    public $operatorId;
    public $operateIp;
    public $operateTime;

	public function columnMap()
    {
        return array(
            'blId'          => 'id',
            'cityId'        => 'cityId',
            'realId'        => 'realId',
            'parkId'        => 'parkId',
            'blBindMonth'   => 'bindMonth',
            'blPhonePre'    => 'phonePre',
            'blPhoneExt'    => 'phoneExt',
            'blOperateFrom' => 'operateFrom',
            'blOperateType' => 'operateType',
            'blOperatorId'  => 'operatorId',
            'blOperateIp'   => 'operateIp',
            'blOperateTime' => 'operateTime'
        );
    }

    public function initialize ()
    {
        $this->setConn('esf');
    }
    
    public function getSource ()
    {
        return 'phone400_bind_log';
    }
    
    /**
     * 单例对象
     * @return type
     */
    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__,$cache);
    }
}

?>

