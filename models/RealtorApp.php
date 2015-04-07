<?php
/**
 * @abstract APP
 * @author weiliting litingwei@sohu-inc.com
 * @since  2014年9月2日10:58:03
 */
class RealtorApp extends BaseModel
{
    //rptype  1出租2出售
    const RPTYPE_SALE=2;
    const RPTYPE_RENT=1;

    //


	public $rpId;
	public $realId;
	public $VaName;
	public $rpType;
	public $cityId;
	public $comId;
	public $comAbbr;
	public $houseId = 0; 
	public $parkName;
	public $parkId = 0;
	public $distId = 0;
	public $distName;
	public $regId = 0;
	public $regName = NUll;
	public $houseUnit = 0;
	public $rentPrice = 0;
	public $rentCurrency = 0;
	public $houseBA = 0;
	public $houseUA = 0;
	public $houseBedRoom = 0;
	public $houseLivingRoom = 0;
	public $houseBathRoom = 0;
	public $rpData;
	public $rpTime;
	public $rpAuth = 0;
	public $rpAuthTime;
	public $rpMsg;
	public $rpFaceImage = 0;
	public $realName = '';
	public $realMobile;

    //认证状态 0待认证/1认证成功/-1认证失败/-2认证过期
    public static $HOUSE_AUTHING = 0;
    public static $HOUSE_AUTHED  = 1;
    public static $HOUSE_AUTHERROR  = -1;
    public static $HOUSE_AUTHTIMEOUT = -2;//过期
	
	public function columnMap()
	{
		return array(
	   			'rpId' => 'rpId',
				'realId' => 'realId',
				'VaName' => 'VaName',
				'rpType' => 'rpType',
				'cityId' => 'cityId',
				'comId' => 'comId',
				'comAbbr' => 'comAbbr',
				'houseId' => 'houseId',
				'parkName' => 'parkName',
				'parkId' => 'parkId',
				'distId' => 'distId',
				'distName' => 'distName',
				'regId' => 'regId',
				'regName' => 'regName',
				'houseUnit' => 'houseUnit',
				'rentPrice' => 'rentPrice',	
				'rentCurrency' => 'rentCurrency',
				'houseBA' => 'houseBA',
				'houseUA' => 'houseUA',
				'houseBedRoom' => 'houseBedRoom',
				'houseLivingRoom' => 'houseLivingRoom',
				'houseBathRoom' => 'houseBathRoom',
				'rpData' => 'rpData',
				'rpTime' => 'rpTime',
				'rpAuth' => 'rpAuth',
				'rpAuthTime' => 'rpAuthTime',
				'rpMsg' => 'rpMsg',
				'rpFaceImage' => 'rpFaceImage',
				'realName' => 'realName',
				'realMobile' => 'realMobile',
		);
	}
	
	public function initialize()
	{
		$this->setReadConnectionService('esfSlave');
		$this->setWriteConnectionService('esfMaster');
	}

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }

    //根据rpId更新审核状态
    public function editByRpid($id, $param){
        if(!$id) return false;
        $obj = self::findFirst($id);
        $obj->rpAuth = ($param['status']==1)?self::$HOUSE_AUTHED:self::$HOUSE_AUTHERROR;
        $obj->rpMsg  = !empty($param['rpMsg'])?$param['rpMsg']:'';
        $obj->rpAuthTime = date('Y-m-d H:i:s');
        return $obj->update();
    }

	/**
	 * 获取房源认证信息
	 * @param array $condition
	 * @return array
	 */
	public function getAuthStatus($condition){
		$arrTitle = array(1=>'通过真房源认证',2=>'真房源认证失败',4=>'等待真房源认证',3=>'真房源认证已过期');
		$arrBackData = array();
		if(empty($condition)) return false;
        $where = " houseId in (".implode(',', $condition['houseId']).")";
        foreach( $condition as $key => $value)
        {
        	if( $key != 'houseId')
        	{
        	    $where .= " and $key = $value";
        	}
        }
        $arrAuthInfo = RealtorApp::getAll($where, ' rpTime DESC', '', '', 'rpId,realId,cityId,rpTime,rpAuth,rpMsg,houseId,rpType');
		if ( !empty($arrAuthInfo) ) {
			foreach ( $arrAuthInfo as $k => $v ) {
				if($v['rpAuth'] == 0 ){$v['rpAuth'] = 4;}//因有房源未上传认证，与之进行区分
				if($v['rpAuth'] == -1 ){$v['rpAuth'] = 2;}
				$arrBackData[$v['houseId']] = $v;
				$arrBackData[$v['houseId']]['auth'] = $v['rpAuth'];
				$arrBackData[$v['houseId']]['title'] = $arrTitle[$v['rpAuth']];
// 				$arrBackData[$v['houseId']]['msg'] = $arrTitle[$v['rpMsg']];	ps：数据库中写的是字符串，不明白这里为什么这用先，先注释
			}
		}
		return $arrBackData;
	}

    //获取认证通过的真房源信息
    public function getHouseByOk(){
        $rs = self::find([
            "conditions" => "rpAuth=".self::$HOUSE_AUTHED,
            "order" => "rpId desc",
            "columns"=>"rpId, rpAuthTime, houseId"
        ])->toArray();
        $result = array();
        foreach($rs as $k=>$v){
            $result[$v['rpId']] = $v;
        }
        return $result;
    }
    //设为过期
    public function idTimeOut($id){
        if(!$id) return false;
        $obj = self::findFirst($id);
        $obj->rpAuth = self::$HOUSE_AUTHTIMEOUT;
        return $obj->update();
    }
}
