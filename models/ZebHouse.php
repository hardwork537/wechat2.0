<?php

use Guzzle\Common\ToArrayInterface;
class ZebHouse extends BaseModel
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $houseId;

    /**
     *
     * @var integer
     */
    public $parkId=0;

    /**
     *
     * @var integer
     */
    public $regId=0;

    /**
     *
     * @var integer
     */
    public $distId=0;

    /**
     *
     * @var integer
     */
    public $cityId=0;

    /**
     *
     * @var integer
     */
    public $realId=0;

    /**
     *
     * @var integer
     */
    public $shopId=0;

    /**
     *
     * @var integer
     */
    public $areaId=0;

    /**
     *
     * @var integer
     */
    public $comId=0;

    /**
     *
     * @var integer
     */
    public $houseType=0;

    /**
     *
     * @var integer
     */
    public $housePrice=0;

    /**
     *
     * @var integer
     */
    public $houseUnit=0;

    /**
     *
     * @var integer
     */
    public $houseBedRoom=0;

    /**
     *
     * @var double
     */
    public $houseBA=0.00;

    /**
     *
     * @var integer
     */
    public $houseQuality=0;

    /**
     *
     * @var integer
     */
    public $houseTags=0;

    /**
     *
     * @var integer
     */
    public $houseFine=2;

    /**
     *
     * @var integer
     */
    public $houseTiming=0;

    /**
     *
     * @var integer
     */
    public $houseVerification=0;

    /**
     *
     * @var datetime
     */
    public $houseCreate='0000-00-00 00:00:00';

    /**
     *
     * @var integer
     */
    public $month;

    /**
     *
     * @var integer
     */
    public $refresh=0;

    /**
     *
     * @var integer
     */
    public $click=0;

    /**
     *
     * @var integer
     */
    public $bold=0;

    /**
     *
     * @var integer
     */
    public $d01Release=0;

    /**
     *
     * @var integer
     */
    public $d01Refresh=0;

    /**
     *
     * @var integer
     */
    public $d01Click=0;

    /**
     *
     * @var integer
     */
    public $d01Bold=0;

    /**
     *
     * @var integer
     */
    public $d01Tags=0;

    /**
     *
     * @var integer
     */
    public $d02Release=0;

    /**
     *
     * @var integer
     */
    public $d02Refresh=0;

    /**
     *
     * @var integer
     */
    public $d02Click=0;

    /**
     *
     * @var integer
     */
    public $d02Bold=0;

    /**
     *
     * @var integer
     */
    public $d02Tags=0;

    /**
     *
     * @var integer
     */
    public $d03Release=0;

    /**
     *
     * @var integer
     */
    public $d03Refresh=0;

    /**
     *
     * @var integer
     */
    public $d03Click=0;

    /**
     *
     * @var integer
     */
    public $d03Bold=0;

    /**
     *
     * @var integer
     */
    public $d03Tags=0;

    /**
     *
     * @var integer
     */
    public $d04Release=0;

    /**
     *
     * @var integer
     */
    public $d04Refresh=0;

    /**
     *
     * @var integer
     */
    public $d04Click=0;

    /**
     *
     * @var integer
     */
    public $d04Bold=0;

    /**
     *
     * @var integer
     */
    public $d04Tags=0;

    /**
     *
     * @var integer
     */
    public $d05Release=0;

    /**
     *
     * @var integer
     */
    public $d05Refresh=0;

    /**
     *
     * @var integer
     */
    public $d05Click=0;

    /**
     *
     * @var integer
     */
    public $d05Bold=0;

    /**
     *
     * @var integer
     */
    public $d05Tags=0;

    /**
     *
     * @var integer
     */
    public $d06Release=0;

    /**
     *
     * @var integer
     */
    public $d06Refresh=0;

    /**
     *
     * @var integer
     */
    public $d06Click=0;

    /**
     *
     * @var integer
     */
    public $d06Bold=0;

    /**
     *
     * @var integer
     */
    public $d06Tags=0;

    /**
     *
     * @var integer
     */
    public $d07Release=0;

    /**
     *
     * @var integer
     */
    public $d07Refresh=0;

    /**
     *
     * @var integer
     */
    public $d07Click=0;

    /**
     *
     * @var integer
     */
    public $d07Bold=0;

    /**
     *
     * @var integer
     */
    public $d07Tags=0;

    /**
     *
     * @var integer
     */
    public $d08Release=0;

    /**
     *
     * @var integer
     */
    public $d08Refresh=0;

    /**
     *
     * @var integer
     */
    public $d08Click=0;

    /**
     *
     * @var integer
     */
    public $d08Bold=0;

    /**
     *
     * @var integer
     */
    public $d08Tags=0;

    /**
     *
     * @var integer
     */
    public $d09Release=0;

    /**
     *
     * @var integer
     */
    public $d09Refresh=0;

    /**
     *
     * @var integer
     */
    public $d09Click=0;

    /**
     *
     * @var integer
     */
    public $d09Bold=0;

    /**
     *
     * @var integer
     */
    public $d09Tags=0;

    /**
     *
     * @var integer
     */
    public $d10Release=0;

    /**
     *
     * @var integer
     */
    public $d10Refresh=0;

    /**
     *
     * @var integer
     */
    public $d10Click=0;

    /**
     *
     * @var integer
     */
    public $d10Bold=0;

    /**
     *
     * @var integer
     */
    public $d10Tags=0;

    /**
     *
     * @var integer
     */
    public $d11Release=0;

    /**
     *
     * @var integer
     */
    public $d11Refresh=0;

    /**
     *
     * @var integer
     */
    public $d11Click=0;

    /**
     *
     * @var integer
     */
    public $d11Bold=0;

    /**
     *
     * @var integer
     */
    public $d11Tags=0;

    /**
     *
     * @var integer
     */
    public $d12Release=0;

    /**
     *
     * @var integer
     */
    public $d12Refresh=0;

    /**
     *
     * @var integer
     */
    public $d12Click=0;

    /**
     *
     * @var integer
     */
    public $d12Bold=0;

    /**
     *
     * @var integer
     */
    public $d12Tags=0;

    /**
     *
     * @var integer
     */
    public $d13Release=0;

    /**
     *
     * @var integer
     */
    public $d13Refresh=0;

    /**
     *
     * @var integer
     */
    public $d13Click=0;

    /**
     *
     * @var integer
     */
    public $d13Bold=0;

    /**
     *
     * @var integer
     */
    public $d13Tags=0;

    /**
     *
     * @var integer
     */
    public $d14Release=0;

    /**
     *
     * @var integer
     */
    public $d14Refresh=0;

    /**
     *
     * @var integer
     */
    public $d14Click=0;

    /**
     *
     * @var integer
     */
    public $d14Bold=0;

    /**
     *
     * @var integer
     */
    public $d14Tags=0;

    /**
     *
     * @var integer
     */
    public $d15Release=0;

    /**
     *
     * @var integer
     */
    public $d15Refresh=0;

    /**
     *
     * @var integer
     */
    public $d15Click=0;

    /**
     *
     * @var integer
     */
    public $d15Bold=0;

    /**
     *
     * @var integer
     */
    public $d15Tags=0;

    /**
     *
     * @var integer
     */
    public $d16Release=0;

    /**
     *
     * @var integer
     */
    public $d16Refresh=0;

    /**
     *
     * @var integer
     */
    public $d16Click=0;

    /**
     *
     * @var integer
     */
    public $d16Bold=0;

    /**
     *
     * @var integer
     */
    public $d16Tags=0;

    /**
     *
     * @var integer
     */
    public $d17Release=0;

    /**
     *
     * @var integer
     */
    public $d17Refresh=0;

    /**
     *
     * @var integer
     */
    public $d17Click=0;

    /**
     *
     * @var integer
     */
    public $d17Bold=0;

    /**
     *
     * @var integer
     */
    public $d17Tags=0;

    /**
     *
     * @var integer
     */
    public $d18Release=0;

    /**
     *
     * @var integer
     */
    public $d18Refresh=0;

    /**
     *
     * @var integer
     */
    public $d18Click=0;

    /**
     *
     * @var integer
     */
    public $d18Bold=0;

    /**
     *
     * @var integer
     */
    public $d18Tags=0;

    /**
     *
     * @var integer
     */
    public $d19Release=0;

    /**
     *
     * @var integer
     */
    public $d19Refresh=0;

    /**
     *
     * @var integer
     */
    public $d19Click=0;

    /**
     *
     * @var integer
     */
    public $d19Bold=0;

    /**
     *
     * @var integer
     */
    public $d19Tags=0;

    /**
     *
     * @var integer
     */
    public $d20Release=0;

    /**
     *
     * @var integer
     */
    public $d20Refresh=0;

    /**
     *
     * @var integer
     */
    public $d20Click=0;

    /**
     *
     * @var integer
     */
    public $d20Bold=0;

    /**
     *
     * @var integer
     */
    public $d20Tags=0;

    /**
     *
     * @var integer
     */
    public $d21Release=0;

    /**
     *
     * @var integer
     */
    public $d21Refresh=0;

    /**
     *
     * @var integer
     */
    public $d21Click=0;

    /**
     *
     * @var integer
     */
    public $d21Bold=0;

    /**
     *
     * @var integer
     */
    public $d21Tags=0;

    /**
     *
     * @var integer
     */
    public $d22Release=0;

    /**
     *
     * @var integer
     */
    public $d22Refresh=0;

    /**
     *
     * @var integer
     */
    public $d22Click=0;

    /**
     *
     * @var integer
     */
    public $d22Bold=0;

    /**
     *
     * @var integer
     */
    public $d22Tags=0;

    /**
     *
     * @var integer
     */
    public $d23Release=0;

    /**
     *
     * @var integer
     */
    public $d23Refresh=0;

    /**
     *
     * @var integer
     */
    public $d23Click=0;

    /**
     *
     * @var integer
     */
    public $d23Bold=0;

    /**
     *
     * @var integer
     */
    public $d23Tags=0;

    /**
     *
     * @var integer
     */
    public $d24Release=0;

    /**
     *
     * @var integer
     */
    public $d24Refresh=0;

    /**
     *
     * @var integer
     */
    public $d24Click=0;

    /**
     *
     * @var integer
     */
    public $d24Bold=0;

    /**
     *
     * @var integer
     */
    public $d24Tags=0;

    /**
     *
     * @var integer
     */
    public $d25Release=0;

    /**
     *
     * @var integer
     */
    public $d25Refresh=0;

    /**
     *
     * @var integer
     */
    public $d25Click=0;

    /**
     *
     * @var integer
     */
    public $d25Bold=0;

    /**
     *
     * @var integer
     */
    public $d25Tags=0;

    /**
     *
     * @var integer
     */
    public $d26Release=0;

    /**
     *
     * @var integer
     */
    public $d26Refresh=0;

    /**
     *
     * @var integer
     */
    public $d26Click=0;

    /**
     *
     * @var integer
     */
    public $d26Bold=0;

    /**
     *
     * @var integer
     */
    public $d26Tags=0;

    /**
     *
     * @var integer
     */
    public $d27Release=0;

    /**
     *
     * @var integer
     */
    public $d27Refresh=0;

    /**
     *
     * @var integer
     */
    public $d27Click=0;

    /**
     *
     * @var integer
     */
    public $d27Bold=0;

    /**
     *
     * @var integer
     */
    public $d27Tags=0;

    /**
     *
     * @var integer
     */
    public $d28Release=0;

    /**
     *
     * @var integer
     */
    public $d28Refresh=0;

    /**
     *
     * @var integer
     */
    public $d28Click=0;

    /**
     *
     * @var integer
     */
    public $d28Bold=0;

    /**
     *
     * @var integer
     */
    public $d28Tags=0;

    /**
     *
     * @var integer
     */
    public $d29Release=0;

    /**
     *
     * @var integer
     */
    public $d29Refresh=0;

    /**
     *
     * @var integer
     */
    public $d29Click=0;

    /**
     *
     * @var integer
     */
    public $d29Bold=0;

    /**
     *
     * @var integer
     */
    public $d29Tags=0;

    /**
     *
     * @var integer
     */
    public $d30Release=0;

    /**
     *
     * @var integer
     */
    public $d30Refresh=0;

    /**
     *
     * @var integer
     */
    public $d30Click=0;

    /**
     *
     * @var integer
     */
    public $d30Bold=0;

    /**
     *
     * @var integer
     */
    public $d30Tags=0;

    /**
     *
     * @var integer
     */
    public $d31Release=0;

    /**
     *
     * @var integer
     */
    public $d31Refresh=0;

    /**
     *
     * @var integer
     */
    public $d31Click=0;

    /**
     *
     * @var integer
     */
    public $d31Bold=0;

    /**
     *
     * @var integer
     */
    public $d31Tags=0;

    /**
     *
     * @var string
     */
    public $zhUpdate;
    private $strTabName =  'zeb_house_y';
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if(preg_match('/^\d{1,10}$/', $id == 0) || $id > 4294967295)
        {
            return false;
        }
        $this->id = $id;
    }

    public function getHouseId()
    {
        return $this->houseId;
    }

    public function setHouseId($houseId)
    {
        if(preg_match('/^\d{1,10}$/', $houseId == 0) || $houseId > 4294967295)
        {
            return false;
        }
        $this->houseId = $houseId;
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'zhId' => 'id', 
            'houseId' => 'houseId', 
            'parkId' => 'parkId', 
            'regId' => 'regId', 
            'distId' => 'distId', 
            'cityId' => 'cityId', 
            'realId' => 'realId', 
            'shopId' => 'shopId', 
            'areaId' => 'areaId', 
            'comId' => 'comId', 
            'houseType' => 'houseType', 
            'housePrice' => 'housePrice', 
            'houseUnit' => 'houseUnit', 
            'houseBedRoom' => 'houseBedRoom', 
            'houseBA' => 'houseBA', 
            'houseQuality' => 'houseQuality', 
            'houseTags' => 'houseTags', 
            'houseFine' => 'houseFine', 
            'houseTiming' => 'houseTiming', 
            'houseVerification' => 'houseVerification', 
            'houseCreate' => 'houseCreate', 
            'zhMonth' => 'month',
            'zhRefresh' => 'refresh',
            'zhClick' => 'click',
            'zhBold' => 'bold',
            'd01Release' => 'd01Release', 
            'd01Refresh' => 'd01Refresh', 
            'd01Click' => 'd01Click', 
            'd01Bold' => 'd01Bold', 
            'd01Tags' => 'd01Tags', 
            'd02Release' => 'd02Release', 
            'd02Refresh' => 'd02Refresh', 
            'd02Click' => 'd02Click', 
            'd02Bold' => 'd02Bold', 
            'd02Tags' => 'd02Tags', 
            'd03Release' => 'd03Release', 
            'd03Refresh' => 'd03Refresh', 
            'd03Click' => 'd03Click', 
            'd03Bold' => 'd03Bold', 
            'd03Tags' => 'd03Tags', 
            'd04Release' => 'd04Release', 
            'd04Refresh' => 'd04Refresh', 
            'd04Click' => 'd04Click', 
            'd04Bold' => 'd04Bold', 
            'd04Tags' => 'd04Tags', 
            'd05Release' => 'd05Release', 
            'd05Refresh' => 'd05Refresh', 
            'd05Click' => 'd05Click', 
            'd05Bold' => 'd05Bold', 
            'd05Tags' => 'd05Tags', 
            'd06Release' => 'd06Release', 
            'd06Refresh' => 'd06Refresh', 
            'd06Click' => 'd06Click', 
            'd06Bold' => 'd06Bold', 
            'd06Tags' => 'd06Tags', 
            'd07Release' => 'd07Release', 
            'd07Refresh' => 'd07Refresh', 
            'd07Click' => 'd07Click', 
            'd07Bold' => 'd07Bold', 
            'd07Tags' => 'd07Tags', 
            'd08Release' => 'd08Release', 
            'd08Refresh' => 'd08Refresh', 
            'd08Click' => 'd08Click', 
            'd08Bold' => 'd08Bold', 
            'd08Tags' => 'd08Tags', 
            'd09Release' => 'd09Release', 
            'd09Refresh' => 'd09Refresh', 
            'd09Click' => 'd09Click', 
            'd09Bold' => 'd09Bold', 
            'd09Tags' => 'd09Tags', 
            'd10Release' => 'd10Release', 
            'd10Refresh' => 'd10Refresh', 
            'd10Click' => 'd10Click', 
            'd10Bold' => 'd10Bold', 
            'd10Tags' => 'd10Tags', 
            'd11Release' => 'd11Release', 
            'd11Refresh' => 'd11Refresh', 
            'd11Click' => 'd11Click', 
            'd11Bold' => 'd11Bold', 
            'd11Tags' => 'd11Tags', 
            'd12Release' => 'd12Release', 
            'd12Refresh' => 'd12Refresh', 
            'd12Click' => 'd12Click', 
            'd12Bold' => 'd12Bold', 
            'd12Tags' => 'd12Tags', 
            'd13Release' => 'd13Release', 
            'd13Refresh' => 'd13Refresh', 
            'd13Click' => 'd13Click', 
            'd13Bold' => 'd13Bold', 
            'd13Tags' => 'd13Tags', 
            'd14Release' => 'd14Release', 
            'd14Refresh' => 'd14Refresh', 
            'd14Click' => 'd14Click', 
            'd14Bold' => 'd14Bold', 
            'd14Tags' => 'd14Tags', 
            'd15Release' => 'd15Release', 
            'd15Refresh' => 'd15Refresh', 
            'd15Click' => 'd15Click', 
            'd15Bold' => 'd15Bold', 
            'd15Tags' => 'd15Tags', 
            'd16Release' => 'd16Release', 
            'd16Refresh' => 'd16Refresh', 
            'd16Click' => 'd16Click', 
            'd16Bold' => 'd16Bold', 
            'd16Tags' => 'd16Tags', 
            'd17Release' => 'd17Release', 
            'd17Refresh' => 'd17Refresh', 
            'd17Click' => 'd17Click', 
            'd17Bold' => 'd17Bold', 
            'd17Tags' => 'd17Tags', 
            'd18Release' => 'd18Release', 
            'd18Refresh' => 'd18Refresh', 
            'd18Click' => 'd18Click', 
            'd18Bold' => 'd18Bold', 
            'd18Tags' => 'd18Tags', 
            'd19Release' => 'd19Release', 
            'd19Refresh' => 'd19Refresh', 
            'd19Click' => 'd19Click', 
            'd19Bold' => 'd19Bold', 
            'd19Tags' => 'd19Tags', 
            'd20Release' => 'd20Release', 
            'd20Refresh' => 'd20Refresh', 
            'd20Click' => 'd20Click', 
            'd20Bold' => 'd20Bold', 
            'd20Tags' => 'd20Tags', 
            'd21Release' => 'd21Release', 
            'd21Refresh' => 'd21Refresh', 
            'd21Click' => 'd21Click', 
            'd21Bold' => 'd21Bold', 
            'd21Tags' => 'd21Tags', 
            'd22Release' => 'd22Release', 
            'd22Refresh' => 'd22Refresh', 
            'd22Click' => 'd22Click', 
            'd22Bold' => 'd22Bold', 
            'd22Tags' => 'd22Tags', 
            'd23Release' => 'd23Release', 
            'd23Refresh' => 'd23Refresh', 
            'd23Click' => 'd23Click', 
            'd23Bold' => 'd23Bold', 
            'd23Tags' => 'd23Tags', 
            'd24Release' => 'd24Release', 
            'd24Refresh' => 'd24Refresh', 
            'd24Click' => 'd24Click', 
            'd24Bold' => 'd24Bold', 
            'd24Tags' => 'd24Tags', 
            'd25Release' => 'd25Release', 
            'd25Refresh' => 'd25Refresh', 
            'd25Click' => 'd25Click', 
            'd25Bold' => 'd25Bold', 
            'd25Tags' => 'd25Tags', 
            'd26Release' => 'd26Release', 
            'd26Refresh' => 'd26Refresh', 
            'd26Click' => 'd26Click', 
            'd26Bold' => 'd26Bold', 
            'd26Tags' => 'd26Tags', 
            'd27Release' => 'd27Release', 
            'd27Refresh' => 'd27Refresh', 
            'd27Click' => 'd27Click', 
            'd27Bold' => 'd27Bold', 
            'd27Tags' => 'd27Tags', 
            'd28Release' => 'd28Release', 
            'd28Refresh' => 'd28Refresh', 
            'd28Click' => 'd28Click', 
            'd28Bold' => 'd28Bold', 
            'd28Tags' => 'd28Tags', 
            'd29Release' => 'd29Release',
            'd29Refresh' => 'd29Refresh', 
            'd29Click' => 'd29Click', 
            'd29Bold' => 'd29Bold', 
            'd29Tags' => 'd29Tags', 
            'd30Release' => 'd30Release', 
            'd30Refresh' => 'd30Refresh', 
            'd30Click' => 'd30Click', 
            'd30Bold' => 'd30Bold', 
            'd30Tags' => 'd30Tags', 
            'd31Release' => 'd31Release', 
            'd31Refresh' => 'd31Refresh', 
            'd31Click' => 'd31Click', 
            'd31Bold' => 'd31Bold', 
            'd31Tags' => 'd31Tags', 
            'zhUpdate' => 'zhUpdate'
        );
    }

//    public function getSource(){
//        return "zeb_house_y".date("Y");
//    }

    public function getSource()
    {
        if( strlen($this->strTabName) == 11 )
            return $this->strTabName.date("Y");
        else
            return $this->strTabName;
    }
    public function setSource($strDate)
    {
        $this->strTabName = 'zeb_house_y'.$strDate;
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
	
	/**
	 * 获取当前日期的统计字段
	 *
	 * @param string $strDay
	 * @return array
	 */
    public function getTodayField($strDay = ''){
		$todayNum = empty($strDay) ? date('d') : $strDay;
        return array(
            'release' =>  "d".$todayNum."Release",//是否上架
            'click' =>  "d".$todayNum."Click",//点击次数
            'bold' =>  "d".$todayNum."Bold",//是否精品
            'refresh' =>  "d".$todayNum."Refresh",//刷新次数
            'tags' =>  "d".$todayNum."Tags",//标签数量
        );
    }
	
	/**
	 * 写入统计数据
	 *
	 * @param int $intHouseId
	 * @param array $arrData
	 * @param string $strMonth
	 * @param string $strDay
	 * @return array|bool
	 */
    public function addZebHouse($intHouseId, $arrData, $strMonth = '', $strDay = ''){
		$arrZh = $arrHouse = array();
		$arrHouse = House::Instance()->getOne('id='.$intHouseId);
		if (empty($arrHouse)) {
			return false;
		}

		//统计房源信息
		if (!isset($arrData['release'])) $arrData['release'] = (strtotime($arrHouse['create']) > strtotime(date("Y-m-d")) && $arrHouse['status'] == House::STATUS_ONLINE) ? 1 : 0;//是否上架
		if (!isset($arrData['fine'])) $arrData['bold'] = ($arrHouse['fine'] == House::FINE_YES) ? 1 : 0;//精品数
		if ($arrHouse['type'] == House::TYPE_ERSHOU || $arrHouse['type'] == House::TYPE_CIXIN || $arrHouse['type'] == House::TYPE_XINFANG) {
			if (!isset($arrData['tags'])) {
				$arrSale = Sale::Instance()->getOne('houseId='.$intHouseId);
				$arrSignCity = HouseSign::Instance()->getHouseSignByCityId($arrHouse['cityId'], House::TYPE_ERSHOU, false);
				$arrSign = explode(',', $arrSale['features']);
				$arrSign = array_intersect($arrSign, $arrSignCity);
				$arrData['tags'] = count($arrSign);//转为标签数，出售
				unset($arrSale, $arrSignCity, $arrSign);
			}
		} else {
			if (!isset($arrData['tags'])) $arrData['tags'] = ($arrHouse['tags'] == House::HOUSE_NOTAG) ? 0 : (($arrHouse['tags'] == House::HOUSE_ALLTAG) ? 2 : 1);//转为标签数，出租
		}
		$arrData['refresh'] = RefreshLog::Instance()->getCount("houseId=".$intHouseId." and time>=".strtotime(date('Y-m-d', time())));

		$arrZh['houseId'] = $intHouseId;
		$arrZh['parkId'] = $arrHouse['parkId'];
		$arrZh['regId'] = $arrHouse['regId'];
		$arrZh['distId'] = $arrHouse['distId'];
		$arrZh['cityId'] = $arrHouse['cityId'];
		$arrZh['realId'] = $arrHouse['realId'];
		$arrZh['shopId'] = $arrHouse['shopId'];
		$arrZh['areaId'] = $arrHouse['areaId'];
		$arrZh['comId'] = $arrHouse['comId'];
		$arrZh['houseType'] = $arrHouse['type'];
		$arrZh['housePrice'] = $arrHouse['price'];
		$arrZh['houseUnit'] = $arrHouse['unit'];
		$arrZh['houseBedRoom'] = $arrHouse['bedRoom'];
		$arrZh['houseBA'] = $arrHouse['bA'];
		$arrZh['houseQuality'] = $arrHouse['quality'];
		$arrZh['houseTags'] = $arrHouse['tags'];
		$arrZh['houseFine'] = $arrHouse['fine'];
		$arrZh['houseTiming'] = $arrHouse['timing'];
		$arrZh['houseVerification'] = $arrHouse['verification'];
		$arrZh['houseCreate'] = $arrHouse['create'];
		if (!empty($arrData)) {
			$arrField = $this->getTodayField($strDay);
			unset($arrField['click']);//点击量不更新
			foreach ($arrField as $key => $field) {
				$arrZh[$field] = isset($arrData[$key]) ? $arrData[$key] : 0;
			}
		}
		$arrZh['month'] = empty($strMonth) ? intval(date('m')) : intval($strMonth);
		$arrZh['zhUpdate'] = date('Y-m-d H:i:s', time());
		$res = self::create($arrZh);
		unset($arrZh, $arrData);
		return empty($res) ? false : $arrHouse;
    }
	
	/**
	 * 更新统计数据
	 *
	 * @param int $intHouseId
	 * @param array $arrData
	 * @param string $strMonth
	 * @param string $strDay
	 * @return array|bool
	 */
    public function modZebHouse($intHouseId, $arrData, $strMonth = '', $strDay = ''){
		$arrZh = $arrHouse = array();
		$strMonth = empty($strMonth) ? date('m') : $strMonth;
		$objZeb = self::findfirst("houseId=".$intHouseId." and month=".intval($strMonth));
		if (empty($objZeb)) return $this->addZebHouse($intHouseId, $arrData, $strMonth, $strDay);
		$arrHouse = House::Instance()->getOne('id='.$intHouseId);
		if (empty($arrHouse)) {
			return false;
		}

		//统计房源信息
		if (!isset($arrData['release'])) $arrData['release'] = ($arrHouse['status'] == House::STATUS_ONLINE) ? 1 : 0;//是否上架
		if (!isset($arrData['fine'])) $arrData['bold'] = ($arrHouse['fine'] == House::FINE_YES) ? 1 : 0;//精品数
		if ($arrHouse['type'] == House::TYPE_ERSHOU || $arrHouse['type'] == House::TYPE_CIXIN || $arrHouse['type'] == House::TYPE_XINFANG) {
			if (!isset($arrData['tags'])) {
				$arrSale = Sale::Instance()->getOne('houseId='.$intHouseId);
				$arrSignCity = HouseSign::Instance()->getHouseSignByCityId($arrHouse['cityId'], House::TYPE_ERSHOU, false);
				$arrSign = explode(',', $arrSale['features']);
				$arrSign = array_intersect($arrSign, $arrSignCity);
				$arrData['tags'] = count($arrSign);//转为标签数，出售
				unset($arrSale, $arrSignCity, $arrSign);
			}
		} else {
			if (!isset($arrData['tags'])) $arrData['tags'] = ($arrHouse['tags'] == House::HOUSE_NOTAG) ? 0 : (($arrHouse['tags'] == House::HOUSE_ALLTAG) ? 2 : 1);//转为标签数，出租
		}
		$arrData['refresh'] = RefreshLog::Instance()->getCount("houseId=".$intHouseId." and time>=".strtotime(date('Y-m-d', time())));

		if (!empty($arrData)) {
			$arrField = $this->getTodayField($strDay);
			unset($arrField['click']);//点击量不更新
			foreach ($arrField as $key => $field) {
				$arrZh[$field] = isset($arrData[$key]) ? intval($arrData[$key]) : 0;
			}
			$arrZh['zhUpdate'] = date('Y-m-d H:i:s', time());
			$res = $objZeb->update($arrZh);
		}
		unset($arrZh, $objZeb, $arrField, $arrData);
		return empty($res) ? false : $arrHouse;
    }
    
    /**
     * 获得百分比总数(支持批量)
     * @param ARRAY $elsecondition 搜索条件
     * @param str $strField 要汇总的字段
     */
    public function getCountByIds($condition)
    {
    	if( !is_array($condition) )
    	{
    		$this->error('参数错误');
    		return false;
    	}
        $month = substr($condition[1],11,2);
        $day = substr($condition[1],14,2);
        $where = $condition[0]." and month = '$month'";
        if(!empty($condition[2]))
        {
        	$where .= " and ".$condition[2];
        }
        $arrSearch = $this->getAll($where." GROUP BY parkId",'','','',' parkId, SUM(d'.$day.'Click) AS all_click_sum, count(1) as total');

    	if( false===$arrSearch)
    	{
    		return false;
    	}
    	else
    	{
    		$arrRerurn = array();
    		foreach($arrSearch as $itemSearch)
    		{
    			$arrRerurn[$itemSearch['parkId']] = $itemSearch;
    		}
    		return $arrRerurn;
    	}
    }
    
    /**
     * 经纪人房源点击统计
     * 缓存到明天的凌晨时间点
     *
     * @param int $realId 经纪人id
     * @return array $arrUnitClick=array(
     *                                        'sale'=>array('yesterday'=>xxx,'week'=>xxxx,'month'=>xxx),
     *                                        'rent'=>array('yesterday'=>xxx,'week'=>xxxx,'month'=>xxx),
     *                                  );
     */
    public function getRealtorUnitClickStat($realId)
    {
      	$key = MCDefine::REALTOR_UNIT_CLICK_STAT.$realId;
    	$objMC = new Mem();
    	$arrUnitClick = $objMC->Get($key);
    	//$arrUnitClick = array();
    	if(empty($arrUnitClick))	
    	{
    		//获取所有出售房源点击量
    		$arrSaleIds    = array();
    		$SaleClickNum  = array();
            $objHouse = new House();
    
    		//小区数据统计搜索条件
    		$condition['realId'] = $realId;
    		$SaleCountCon =  $condition;
    		$SaleCountCon['status'] = House::STATUS_ONLINE;
    		
    		$arrSaleIds    = $objHouse->getAllHouseId($SaleCountCon,'',0,2000,true,1);
    		$SaleClickInfo = $this->getUnitClick($arrSaleIds);
    		if(!empty($SaleClickInfo))
    		{
    			foreach ($SaleClickInfo as $unit_id => $item)
    			{
    				$SaleClickNum['yesterday'] += $item['yesterday'];
    				$SaleClickNum['week'] += $item['week'];
    				$SaleClickNum['month'] += $item['month'];
    			}
    		}
    
    		//获取所有出租房源点击量
    		$arrRentIds    = array();
    		$RentClickNum  = array();
    		$RentCountCon =  $condition;
    		$RentCountCon['status'] = House::STATUS_ONLINE;
    		$arrRentIds    = $objHouse->getAllHouseId($SaleCountCon,'',0,2000,true,2);

    		$RentClickInfo = $this->getUnitClick($arrRentIds);
    		if(!empty($RentClickInfo) ) 
    		{
    			foreach ($RentClickInfo as $unit_id => $item)
    			{
    				$RentClickNum['yesterday'] += $item['yesterday'];
    				$RentClickNum['week'] += $item['week'];
    				$RentClickNum['month'] += $item['month'];
    			}
    		}
    		$arrUnitClick = array('sale'=>$SaleClickNum, 'rent'=>$RentClickNum);
    			
    		if(empty($SaleClickNum)&&empty($RentClickNum)){
    			$intMemTime = 1800;
    		}else{
    			$intMemTime = 86400 - (time() - strtotime(date('Y-m-d')));
    		}
 		
    		if($intMemTime > 0){
    			$objMC->Set($key, $arrUnitClick, $intMemTime);
    		}
    	}
    	return $arrUnitClick;
    }

    public function getUnitClick($arrIds)
    {
    	$arrBackData = array();
    	$time = strtotime(date("Y-m-d"));
    	if ( !is_array($arrIds) ) $arrIds = array($arrIds);
    	$today = date('d');
    	if($today == '1' )
    	{
    		$month = date('m')-1;
    		$day = date ('d', mktime(0,0,0,date('m'),0,date('y')));
    	}
    	else
    	{
    		$month = date('m');
    		$day = $today-1;
    		if($day < 10)
    		{
    			$day = '0'.$day;
    		}
    	}
    	if(date('m') == 1 && date('d') == 1)
    	{
    		$day = '01';
    		$month = 1;
    	}
    	$where = " month = '$month'"; 
    	$lastweek = date('Y-m-d',strtotime('-1 week'));
    	$lastmonth = date('Y-m-d',strtotime('-1 month'));
    	$yesterday = date('Y-m-d',strtotime('-1 day'));
    	if(date('m') == 1 && date('d') == 1)
    	{
    		$yesterday = date('Y-m-d');
    	}
    	foreach($arrIds as $value)
    	{
    		$whereDay = $where." and houseId = $value";
    		$arrDayClick = $this->getAll($whereDay,'','','','houseId, d'.$day.'Click as click_sum , d'.$today.'Click as today_click_num');
            $yesterdayClick = 0;
            $todayClick = 0;
    		if(!empty($arrDayClick))
    		{
                if(!empty($arrDayClick[0]['click_sum']))
                {
                    $yesterdayClick = $arrDayClick[0]['click_sum'];
                }
                if(!empty($arrDayClick[0]['today_click_num']))
                {
                    $todayClick= $arrDayClick[0]['today_click_num'];
                }
    		}
            $arrBackData[$value]['today'] = $todayClick;
            $arrBackData[$value]['yesterday'] = $yesterdayClick;
    		$arrBackData[$value]['week'] = $this->getClick($lastweek, $yesterday, $value); 		
    		$arrBackData[$value]['month'] = $this->getClick($lastmonth, $yesterday, $value);
    		unset($whereDay, $arrDayClick);
    	}

    	return $arrBackData;
    }  
    
    
    public function getClick($last, $yesterday, $houseId)
    {
    	$lastmonth = intval(date('m', strtotime($last)));
    	$thismonth = intval(date('m', strtotime($yesterday)));
    	$lastday = date('d', strtotime($last));
    	$thisday = date('d', strtotime($yesterday));  
    	$month = $thismonth-$lastmonth;
    	$sum = 0;
    	switch ($month)
    	{
    		case 0:
    			{
    				$where = " month = '$thismonth' and houseId = $houseId";
    				$arrMonthData = $this->getAll($where,'','','','d01Click, d02Click, d03Click, d04Click, d05Click, d06Click, d07Click, d08Click, d09Click, d10Click, d11Click, d12Click, d13Click, d14Click, d15Click, d16Click, d17Click, d18Click, d19Click, d20Click, d21Click, d22Click, d23Click, d24Click, d25Click, d26Click, d27Click, d28Click, d29Click, d30Click, d31Click');
    				if(!empty($arrMonthData))
    				{
    					if(!empty($arrMonthData[0]))
    					{
    				        $sum = $this->share($arrMonthData[0], $sum, $lastday, $thisday);
    					}
    				}
    			   break;
    			}
    		case 1:
    			{
    				$where = " month in ( $lastmonth, $thismonth) and houseId = $houseId";
    				$arrMonthData = $this->getAll($where,' month asc','','','d01Click, d02Click, d03Click, d04Click, d05Click, d06Click, d07Click, d08Click, d09Click, d10Click, d11Click, d12Click, d13Click, d14Click, d15Click, d16Click, d17Click, d18Click, d19Click, d20Click, d21Click, d22Click, d23Click, d24Click, d25Click, d26Click, d27Click, d28Click, d29Click, d30Click, d31Click, month');   				
    				$thelastday = date ('d', mktime(0,0,0,$thismonth,0,date('y')));             
    				if(!empty($arrMonthData))
    				{
						foreach($arrMonthData as $monthData)
						{
							if($monthData['month'] == $lastmonth)
							{
								$sum = $this->share($monthData, $sum, $lastday, $thelastday);
							}
							if($monthData['month'] == $thismonth)
							{
								$sum = $this->share($monthData, $sum, 1, $thisday);
							}
						}
    				}   			
    			   break;	    				
    			}	
    		case 2:
    			{
    				$where = " month >= $lastmonth and month <= $thismonth and houseId = $houseId";
    				$arrMonthData = $this->getAll($where,' month asc','','','d01Click, d02Click, d03Click, d04Click, d05Click, d06Click, d07Click, d08Click, d09Click, d10Click, d11Click, d12Click, d13Click, d14Click, d15Click, d16Click, d17Click, d18Click, d19Click, d20Click, d21Click, d22Click, d23Click, d24Click, d25Click, d26Click, d27Click, d28Click, d29Click, d30Click, d31Click, month');
    				$firstlastday = date ('d', mktime(0,0,0,$lastmonth,0,date('y')));
    				$thelastday = date ('d', mktime(0,0,0,$thismonth,0,date('y')));
    				if(!empty($arrMonthData))
    				{
						foreach($arrMonthData as $monthData)
						{
							if($monthData['month'] == $lastmonth)
							{
	    						$sum = $this->share($monthData, $sum, $lastday, $firstlastday);
							}
							if($monthData['month'] == $thismonth)
							{
								$sum = $this->share($monthData, $sum, 1, $thisday);
							}
							if($monthData['month'] > $lastmonth && $monthData['month'] < $thismonth)
							{
	    						$sum = $this->share($monthData, $sum, 1, $thelastday);
							}
						}
    				}
    				break;
    			}
    			
    	}
    	if($month < 0)
    	{
    		$where = " month = '$thismonth' and houseId = $houseId";
    		$arrMonthData = $this->getAll($where,'','','','d01Click, d02Click, d03Click, d04Click, d05Click, d06Click, d07Click, d08Click, d09Click, d10Click, d11Click, d12Click, d13Click, d14Click, d15Click, d16Click, d17Click, d18Click, d19Click, d20Click, d21Click, d22Click, d23Click, d24Click, d25Click, d26Click, d27Click, d28Click, d29Click, d30Click, d31Click');
    		if(!empty($arrMonthData))
    		{
	    		if(!empty($arrMonthData[0]))
	    		{
	    		    $sum = $this->share($arrMonthData[0], $sum, 1, $thisday);
	    		}
    		}
    	}
        return $sum;
    }
    
    public function share($arrData, $sum, $start, $end)
    {
    	foreach($arrData as $key=>$value)
    	{
    		$day = intval(substr($key,1,2));
    		if($day >= $start && $day <= $end)
    		{
    			$sum = $sum + $value;
    		}
    		unset($day);
    	}    	
    	return $sum;
    }
    
    /**
     * 获取指定房源的点击数 -- 单日统计
     *
     * @param int|array $arrIds
     * @param int $datetype    1- 当天 2 -昨天
     * @return array
     */
    public function getUnitRentClick($arrIds,$datetype)
    {
    	$arrBackData = array();
    	if ( !is_array($arrIds) ) $arrIds = array($arrIds);
    
    	$year = date('y');
    	$day = date('d');
    	$month = date('m');
    
    	if($datetype == 2)
    	{
    		if($day == '1' )
    		{
    			$month = $month-1;
    			$day = date ('d', mktime(0,0,0,date('m'),0,$year));
    		}
    		else
    		{
    			$day = $day-1;
    			if($day < 10)
    			{
    				$day = '0'.$day;
    			}
    		}
    	}
    	$where = " month = '$month'";
    
    	foreach($arrIds as $value)
    	{
    		$whereDay = $where." and houseId = $value";
    		$str = 'd'.$day.'Click as click_sum ';
    		$arrDayClick = $this->getAll($whereDay,'','','','houseId,'.$str);
    		$arrBackData[$value]['day'] = $arrDayClick[0]['click_sum'];
    		unset($whereDay, $arrDayClick);
    	}
    
    	return $arrBackData;
    }
	
	/**
	 * 获得百分比总数(支持批量)
	 * @param array $arrCond 搜索条件
	 * @param string $strClick 点击字段
	 * @param string $strRelease 发布字段
	 */
	public function getZebCountByIds($arrCond, $strClick, $strRelease){
		if( !is_array($arrCond) ){
			return false;
		}
		$arrSearch = $this->getSelectData('ZebHouse',"parkId,sum(if({$strRelease}>0,{$strClick},0)) as all_click_sum,sum({$strRelease}) as total",implode(' and ', $arrCond),array(),array(),'','parkId');

		if( false===$arrSearch){
			return false;
		}else{
			$arrRerurn = array();
			foreach($arrSearch as $itemSearch){
				$arrRerurn[$itemSearch['parkId']] = $itemSearch;
			}
			return $arrRerurn;
		}
	}

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
    /*
     * 面积搜索排名比例,只能跨一个月
     * */
    public function getClickByTime($startTime, $endTime, $cityId, $houseType=1){
        $lastmonth = intval(date('m', strtotime($startTime)));
        $thismonth = intval(date('m', strtotime($endTime)));
        $lastday = date('d', strtotime($startTime));
        $thisday = date('d', strtotime($endTime));
        $lastTimeday  = strtotime($startTime);
        $thisTimeday =  strtotime($endTime);
        $month = $thismonth-$lastmonth;
        $startYear = intval(date('Y', strtotime($startTime)));
        $endYear  = intval(date('Y', strtotime($endTime)));
        $where = "cityId=$cityId ";

        if($month == 0){
            $where .= " AND month = $thismonth  ";
        }elseif($month==1){
            $where .= " AND month in ( $lastmonth, $thismonth) ";
        }
        if($houseType==1){
            $where .= " AND houseType in (".House::TYPE_CIXIN.",".House::TYPE_ERSHOU.")";
        }else{
            $where .= " AND houseType in (".House::TYPE_ZHENGZU.",".House::TYPE_HEZU.")";
        }

        $day = ' AND (0 ';
        while($lastTimeday<= $thisTimeday){
            $i = date('d', $lastTimeday);
            if($i<10){
                $day .= ' or d0'.intval($i)."Click>0";
            }else{
                $day .= ' or d'.intval($i)."Click>0";
            }
            $lastTimeday += 86400;
        }
        $day .= ")";
        $houseBAArr = array(
            0 => " AND houseBA < 50 ",
            1 => " AND houseBA < 70 AND houseBA>=50 ",
            2 => " AND houseBA >= 70 AND houseBA<90 ",
            3 => " AND houseBA >= 90 AND houseBA<120 ",
            4 => " AND houseBA >= 120 AND houseBA<150 ",
            5 => " AND houseBA >= 150 AND houseBA<200 ",
            6 => " AND houseBA >= 200 AND houseBA<300 ",
            7 => " AND houseBA >= 300  ",
        );
        $result = array();

        foreach($houseBAArr as $k=>$v){
            if($endYear - $startYear>0){
                $columns = "zhId as id, houseBA, d01Click, d02Click, d03Click, d04Click, d05Click, d06Click, d07Click, d08Click, d09Click, d10Click, d11Click, d12Click, d13Click, d14Click, d15Click, d16Click, d17Click, d18Click, d19Click, d20Click, d21Click, d22Click, d23Click, d24Click, d25Click, d26Click, d27Click, d28Click, d29Click, d30Click, d31Click ";
                $con = $where.$v.$day;
                $arrMonthData = $this->getDataByTwoYear($columns,$startYear, $endYear, $con);
            }else{
                $this->setSource($endYear);
                $arrMonthData = $this->getAll($where.$v.$day,'','','','id, houseBA, d01Click, d02Click, d03Click, d04Click, d05Click, d06Click, d07Click, d08Click, d09Click, d10Click, d11Click, d12Click, d13Click, d14Click, d15Click, d16Click, d17Click, d18Click, d19Click, d20Click, d21Click, d22Click, d23Click, d24Click, d25Click, d26Click, d27Click, d28Click, d29Click, d30Click, d31Click');
            }

            foreach($arrMonthData as $one){
                if(!isset($result[$k])){
                    $result[$k] = 0;
                }
                $result[$k] += $this->share($one, 0, $lastday, $thisday);
            }
        }
        foreach($result as $k=>$v){
            $unit[$k] = round($v/array_sum($result)*100,1)."%";
        }
        ksort($unit);
        return $unit;
    }

    public function getDataByTwoYear($columns,$startYear, $endYear, $con){
        $sql = "SELECT $columns FROM (SELECT * from zeb_house_y".$startYear." where $con AND zhMonth=12 UNION ALL SELECT * from zeb_house_y".$endYear." where $con AND zhMonth=1 ) t  ";
        //echo $sql;exit;
        $rs = $this->fetchAll($sql);
        return $rs;
    }

    //获取昨天城区板块的统计
    public function getStatsToRegion($regId=0){
        $month = intval(date('m', time()-86400));
        $day = date('d', time()-86400);
        $year = date("Y", time()-86400);
        $this->setSource($year);
        $con = "month=$month  ";

        $rs = $this->find(array(
            "conditions" => $con." AND regId=".$regId,
            "group" => "houseId",
            "columns"=>"d".$day."Click AS click, comId, cityId, distId, regId, parkId, houseId, houseType"
        ))->toArray();

        if(empty($rs)) return array();
        $result = array();
        foreach($rs as $k=>$v){
            if( $v['comId']==0) continue;
            $result[$v['comId']]['cityId'] = $v['cityId'];
            $result[$v['comId']]['distId'] = $v['distId'];
            $result[$v['comId']]['regId'] = $v['regId'];
            $result[$v['comId']]['comId'] = $v['comId'];
            $result[$v['comId']]['parkId'][$v['parkId']] = $v['parkId'];
            if($v["houseType"]==House::TYPE_ERSHOU || $v["houseType"]==House::TYPE_CIXIN){
                $result[$v['comId']]['saleClick']  = isset($result[$v['comId']]['saleClick'])?($result[$v['comId']]['saleClick']+$v['click']):$v['click'];
                $result[$v['comId']]['saleTotal']  = isset($result[$v['comId']]['saleTotal'])?($result[$v['comId']]['saleTotal']+1):1;
            }elseif($v["houseType"]==House::TYPE_ZHENGZU || $v["houseType"]==House::TYPE_HEZU){
                $result[$v['comId']]['rentClick']  = isset($result[$v['comId']]['rentClick'])?($result[$v['comId']]['rentClick']+$v['click']):$v['click'];
                $result[$v['comId']]['rentTotal']  = isset($result[$v['comId']]['rentTotal'])?($result[$v['comId']]['rentTotal']+1):1;
            }
        }
        unset($rs);
        return $result;
    }

    /**
     * 更新统计数据
     * @auth jackchen
     * @param int $intHouseId
     * @param array $arrData
     * @param int $intMonth
     * @return array|bool
     */
    public function modZebHouseClick($intHouseId, $arrData, $intMonth = 0){
        $arrZh = $arrHouse = array();
        $intMonth = empty($intMonth) ? date('m') : $intMonth;
        $objZeb = self::findfirst("houseId=".$intHouseId." and month=".$intMonth);
        if (empty($objZeb)) return $this->addZebHouse($intHouseId, $arrData, $intMonth);
        $arrHouse = House::Instance()->getOne('id='.$intHouseId);
        if (empty($arrHouse)) {
            echo '房源不存在\n';
            return false;
        }

        if (!empty($arrData)) {
            $arrField = $this->getTodayField();
            foreach ($arrField as $key => $field) {
                $arrZh[$field] = isset($arrData[$key]) ? $arrData[$key] : 0;
            }
            $arrZh['zhUpdate'] = date('Y-m-d H:i:s', time());
            $res = $objZeb->update($arrZh);
        }
        unset($arrZh, $objZeb, $arrField, $arrData);
        return empty($res) ? false : $arrHouse;
    }
    
    /**
     * 获取房源发布、刷新数、点击量的居室统计信息
     * @param unknown $intDay
     */
    public function getBedRoomInfoByRealID($intDay,$intMonth,$intHouseType = House::TYPE_SALE)
    {
    	$strSelect = "SUM(IF(houseBedRoom!=1,0,d{$intDay}Release)) release1,SUM(IF(houseBedRoom!=2,0,d{$intDay}Release)) release2,SUM(IF(houseBedRoom!=3,0,d{$intDay}Release)) release3,SUM(IF(houseBedRoom!=4,0,d{$intDay}Release)) release4, 
					  SUM(IF(houseBedRoom!=5,0,d{$intDay}Release)) release5,SUM(IF(houseBedRoom!=6,0,d{$intDay}Release)) release6,SUM(IF(houseBedRoom!=7,0,d{$intDay}Release)) release7,SUM(IF(houseBedRoom!=8,0,d{$intDay}Release)) release8,
					  SUM(IF(houseBedRoom!=9,0,d{$intDay}Release)) release9,SUM(IF(houseBedRoom!=99,0,d{$intDay}Release)) release99,SUM(IF(houseBedRoom!=100,0,d{$intDay}Release)) release100,
					  SUM(IF(houseBedRoom!=1,0,d{$intDay}Refresh)) refresh1,SUM(IF(houseBedRoom!=2,0,d{$intDay}Refresh)) refresh2,SUM(IF(houseBedRoom!=3,0,d{$intDay}Refresh)) refresh3,SUM(IF(houseBedRoom!=4,0,d{$intDay}Refresh)) refresh4, 
					  SUM(IF(houseBedRoom!=5,0,d{$intDay}Refresh)) refresh5,SUM(IF(houseBedRoom!=6,0,d{$intDay}Refresh)) refresh6,SUM(IF(houseBedRoom!=7,0,d{$intDay}Refresh)) refresh7,SUM(IF(houseBedRoom!=8,0,d{$intDay}Refresh)) refresh8,
					  SUM(IF(houseBedRoom!=9,0,d{$intDay}Refresh)) refresh9,SUM(IF(houseBedRoom!=99,0,d{$intDay}Refresh)) refresh99,SUM(IF(houseBedRoom!=100,0,d{$intDay}Refresh)) refresh100,
					  SUM(IF(houseBedRoom!=1,0,d{$intDay}Click)) click1,SUM(IF(houseBedRoom!=2,0,d{$intDay}Click)) click2,SUM(IF(houseBedRoom!=3,0,d{$intDay}Click)) click3,SUM(IF(houseBedRoom!=4,0,d{$intDay}Click)) click4, 
					  SUM(IF(houseBedRoom!=5,0,d{$intDay}Click)) click5,SUM(IF(houseBedRoom!=6,0,d{$intDay}Click)) click6,SUM(IF(houseBedRoom!=7,0,d{$intDay}Click)) click7,SUM(IF(houseBedRoom!=8,0,d{$intDay}Click)) click8,
					  SUM(IF(houseBedRoom!=9,0,d{$intDay}Click)) click9,SUM(IF(houseBedRoom!=99,0,d{$intDay}Click)) click99,SUM(IF(houseBedRoom!=100,0,d{$intDay}Click)) click100,
    				  SUM(d{$intDay}Release) Release,SUM(d{$intDay}Click) Click,SUM(d{$intDay}Refresh) Refresh,SUM(d{$intDay}Bold) Bold,SUM(d{$intDay}Tags) Tags";
    	
    	$strWhere = '';
		if ($intHouseType ==  House::TYPE_SALE)
		{
		    $strWhere .= " and houseType in (".House::TYPE_XINFANG.", ".House::TYPE_ERSHOU.", ".House::TYPE_CIXIN.")";
		}
		else 
		{
			$strWhere .= " and houseType in (".House::TYPE_HEZU.", ".House::TYPE_ZHENGZU.")";
		}
    	
    	$arrBedRoom = self::findFirst([
    		"conditions"=> "realId={$GLOBALS['client']['realId']} and month={$intMonth} {$strWhere}",
    		"columns"	=> $strSelect
    	])->toArray();
    	
    	if(empty($arrBedRoom)) return array();
    	
    	return $arrBedRoom;
    }

}
