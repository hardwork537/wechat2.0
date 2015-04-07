<?php
/**
 * @abstract  经纪人发票信息表
 * @copyright Sohu-inc Team.
 * @author    Tony (tonyzhao@sohu-inc.com)
 * @date      2015-01-21 14:12:18
 */

class RealtorInvoice extends BaseModel {
    
    //发票抬头
    const HEAD_PERSON   = 1;   //个人
    const HEAD_COMPANY  = 2;   //公司
    
	public $id;
    public $cityId;
	public $realId;
	public $head;
	public $headName;
	public $distId;
    public $regId = 0;
    public $cityStr;
    public $address;
    public $phone = '';
    public $updateTime;

	public function columnMap()
    {
        return array(
            'riId'       => 'id',
            'cityId'     => 'cityId',
            'realId'     => 'realId',
            'distId'     => 'distId',
            'regId'      => 'regId',
            'riHead'     => 'head',
            'riHeadName' => 'headName',
            'riCityStr'  => 'cityStr',
            'riAddress'  => 'address',
            'riPhone'    => 'phone',
            'riUpdate'   => 'updateTime'
        );
    }

    public function initialize ()
    {
        $this->setConn('esf');
    }
    
    public function getSource ()
    {
        return 'realtor_invoice';
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

