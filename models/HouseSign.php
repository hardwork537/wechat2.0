<?php

class HouseSign extends BaseModel
{

    public $id;

    public $cityId;

    public $houseType;

    public $sign;

    public function getId ()
    {
        return $this->id;
    }

    public function setId ($id)
    {
        if (preg_match('/^\d{1,10}$/', $id == 0) || $id > 4294967295) {
            return false;
        }
        $this->id = $id;
    }

    public function getCityId ()
    {
        return $this->cityId;
    }


    public function setCityId ($cityId)
    {
        if (preg_match('/^\d{1,10}$/', $cityId == 0) || $cityId > 4294967295) {
            return false;
        }
        $this->cityId = $cityId;
    }

    public function getHouseType ()
    {
        return $this->houseType;
    }

    public function setHouseType ($houseType)
    {
        if (preg_match('/^\d{1,3}$/', $houseType == 0) || $houseType > 255) {
            return false;
        }
        $this->houseType = $houseType;
    }

    public function getSign ()
    {
        return $this->sign;
    }

    public function setSign ($sign)
    {
        if ($sign == '' || mb_strlen($sign, 'utf8') > 20) {
            return false;
        }
        $this->sign = $sign;
    }

    public function getSource ()
    {
        return 'house_sign';
    }

    public function columnMap ()
    {
        return array(
                'hsId' => 'id',
                'cityId' => 'cityId',
                'houseType' => 'houseType',
                'houseSign' => 'sign'
        );
    }

    public function initialize ()
    {
        $this->setconn('esf');
    }

    /**
     * 获取城市下的房源特色标签数组
     * 设置缓存到mc，缓存1天
     *
     * @param int $city_id
     *            城市id -默认值‘北京’
     * @param int $house_type
     *            房源类型
     * @param bool $return_all
     *            返回数据形式，true表示返回完整数据，false则返回简单数据
     * @return array 房源特色标签数组
     */
    public function getHouseSignByCityId ($city_id = 1, $house_type = 0, $return_all = true)
    {
        $mc_key = MCDefine::HOUSE_SIGN_KEY . $city_id;
        $arrHouseSign = MCache::Instance()->Get($mc_key);
        if ($arrHouseSign === FALSE)
        {
            $arrHouseSign = self::find("cityId = " . $city_id)->toArray(); // 2014.6.13
                                                                           // 解决admin后台房源标签数据莫名丢失问题，原因：只取了name！需要获取所有内容
            Mem::Instance()->Set($mc_key, $arrHouseSign, 86400);
        } 
//        else
//        {
//            $arrHouseSign = unserialize($arrHouseSign);
//        }
        if (! empty($arrHouseSign) && $house_type == House::TYPE_ERSHOU || $house_type == House::TYPE_ZHENGZU) {
            $arrHouseSignTmp = $arrHouseSign;
            $arrHouseSign = array();
            foreach ($arrHouseSignTmp as $data) 
            {
                if ($data['houseType'] == $house_type) 
                {
                    if ($return_all)
                        $arrHouseSign[$data['id']] = $data;
                    else
                        $arrHouseSign[$data['id']] = $data['sign'];
                }
            }
        }
        return $arrHouseSign;
    }

    /**
     * 获取指定城市指定类型的特色房源
     */
    public function getUnitTag ($cityId, $houseType)
    {
        if (empty($cityId)) {
            return false;
        }
        if (empty($houseType)) {
            return false;
        }
        $con['conditions'] = " cityId = ".$cityId;
        if($houseType == 'Sale')
        {
        	$con['conditions'] .= " and houseType in (".House::TYPE_CIXIN.", ".House::TYPE_ERSHOU.")";
        }
        else 
        {
        	$con['conditions'] .= " and houseType in (".House::TYPE_HEZU.", ".House::TYPE_ZHENGZU.")";
        }
        $con['columns'] = "sign as name";
        return self::find($con);
    }

    /**
     * 添加标签
     * @param array $arr
     * @return boolean
     */
    public function add ($arr)
    {
        return $this->create ( array (
        'sign' => $arr['sign'],
        'cityId' => $arr['cityId'],
        'houseType' => $arr['houseType'],
        ) );
    }
    
    /**
     * 删除单条记录
     * @param unknown $where
     */
    public function del($where){
        $rs = self::findFirst($where);
        if ($rs->delete()) {
            return true;
            }
        return false;
    }

    /**
     * 实例化对象
     *
     * @param type $cache            
     * @return \Users_Model
     */
    public static function instance ($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self();        
    }

    /**
     * 获取以id为键名，名称为键值的数据
     *
     * @param int $city_id 城市id -默认值‘北京’
     * @param int $unit_type 房源类型
     * @return array
     */
    public function getHouseSignOption($city_id = 1, $unit_type = 0){
        $arrUnitSignTmp = $this->getHouseSignByCityId($city_id, $unit_type);
        $arrUnitSign = array();
        if(!empty($arrUnitSignTmp)){
            foreach ($arrUnitSignTmp as $data){
                $arrUnitSign[$data['id']] = $data['sign'];
            }
        }
        return $arrUnitSign;
    }

}
