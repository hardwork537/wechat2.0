<?php
class VipProduct extends BaseModel
{
	const TYPE_SALE_EXPERTS_UNIT = 1; //出售置业专家房源
	const TYPE_RENT_EXPERTS_UNIT = 2; //出租置业专家房源
	const TYPE_SALE_EXPERTS_FACE = 3; //出售置业专家头像
	const TYPE_RENT_EXPERTS_FACE = 4; //出租置业专家头像
	const TYPE_SALE_TAG = 5; //出售标签
	const TYPE_RENT_TAG = 6; //出租标签
    static $Types=array(
        self::TYPE_SALE_EXPERTS_UNIT      => "出售置业专家房源",
        self::TYPE_RENT_EXPERTS_UNIT      => "出租置业专家房源",
        self::TYPE_SALE_EXPERTS_FACE      => "出售置业专家头像",
        self::TYPE_RENT_EXPERTS_FACE      => "出租置业专家头像",
        self::TYPE_SALE_TAG               => "出售标签",
        self::TYPE_RENT_TAG               => "出租标签"
    );
    public $id;
    public $name = '';
    public $content = '';
    public $bigPic = '';
    public $smallPic = '';
    public $days = 0;
    public $counts = 0;
    public $cost = 0;
    public $seq = 0;
    public $type = 0;
    public $city = '';
    public $time = 0;
    public $exchanged = 0;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if(preg_match('/^\d{1,11}$/', $id == 0) || $id > 4294967295)
        {
            return false;
        }
        $this->id = $id;
    }

    public function getSource()
    {
        return 'vip_product';
    }

    public function columnMap()
    {
        return array(
            'vpId' => 'id',
            'vpName' => 'name',
            'vpContent' => 'content',
            'vpBigPic' => 'bigPic',
            'vpSmallPic' => 'smallPic',
            'vpDays' => 'days',
            'vpCounts' => 'counts',
            'vpCost' => 'cost',
            'vpSeq' => 'seq',
            'vpType' => 'type',
            'vpCity' => 'city',
            'vpTime' => 'time',
            'vpExchanged' => 'exchanged',
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
     * @return Sale_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
	
	/**
	 * 添加兑换商品
	 *
	 * @param array $arrData
	 * @return bool
	 */
	public function addProduct($arrData = array()){
		if ( empty($arrData) ) return false;
		//兑换商品名称
		if ( isset($arrData['name']) ) {
			$arrInsert['name'] = Utility::filterSubject($arrData['name']);
		}
		//兑换商品描述
		if ( isset($arrData['content']) ) {
			$arrInsert['content'] = Utility::filterSubject($arrData['content']);
		}
		//兑换商品大图地址
		if ( isset($arrData['bigPic']) ) {
			$arrInsert['bigPic'] = $arrData['bigPic'];
		}
		//兑换商品小图地址
		if ( isset($arrData['smallPic']) ) {
			$arrInsert['smallPic'] = $arrData['smallPic'];
		}
		//兑换商品使用期限
		if ( isset($arrData['days']) ) {
			$arrInsert['days'] = $arrData['days'];
		}
		//兑换商品库存数量
		if ( isset($arrData['counts']) ) {
			$arrInsert['counts'] = $arrData['counts'];
		}
		//兑换商品消费积分
		if ( isset($arrData['cost']) ) {
			$arrInsert['cost'] = $arrData['cost'];
		}
		//兑换商品排序
		if ( isset($arrData['seq']) ) {
			$arrInsert['seq'] = $arrData['seq'];
		}
		//兑换商品类型
		if ( isset($arrData['type']) ) {
			$arrInsert['type'] = $arrData['type'];
		}
		//兑换商品已兑换数量
		if ( isset($arrData['exchanged']) ) {
			$arrInsert['exchanged'] = $arrData['exchanged'];
		}
		//兑换商品授权城市
		if ( isset($arrData['city']) ) {
			$arrInsert['city'] = $arrData['city'];
		}
		$arrInsert['time'] = time();
		return self::create($arrInsert);
	}
	
	/**
	 * 根据ID修改商品信息
	 *
	 * @param int $intProductId
	 * @param array $arrData
	 * @return bool
	 */
	public function modProductById($intProductId, $arrData = array()) {

		if ( empty($arrData) || empty($intProductId) ) return false;
		//兑换商品名称
		if ( isset($arrData['name']) ) {
			$arrUpdate['name'] = Utility::filterSubject($arrData['name']);
		}
		//兑换商品描述
		if ( isset($arrData['content']) ) {
			$arrUpdate['content'] = Utility::filterSubject($arrData['content']);
		}
		//兑换商品大图地址
		if ( isset($arrData['bigPic']) ) {
			$arrUpdate['bigPic'] = $arrData['bigPic'];
		}
		//兑换商品小图地址
		if ( isset($arrData['smallPic']) ) {
			$arrUpdate['smallPic'] = $arrData['smallPic'];
		}
		//兑换商品使用期限
		if ( isset($arrData['days']) ) {
			$arrUpdate['days'] = $arrData['days'];
		}
		//兑换商品库存数量
		if ( isset($arrData['counts']) ) {
			$arrUpdate['counts'] = $arrData['counts'];
		}
		//兑换商品消费积分
		if ( isset($arrData['cost']) ) {
			$arrUpdate['cost'] = $arrData['cost'];
		}
		//兑换商品排序
		if ( isset($arrData['seq']) ) {
			$arrUpdate['seq'] = $arrData['seq'];
		}
		//兑换商品类型
		if ( isset($arrData['type']) ) {
			$arrUpdate['type'] = $arrData['type'];
		}
		//兑换商品已兑换数量
		if ( isset($arrData['exchanged']) ) {
			$arrUpdate['exchanged'] = $arrData['exchanged'];
		}
		//兑换商品授权城市
		if ( isset($arrData['city']) ) {
			$arrUpdate['city'] = $arrData['city'];
		}
		$objProductUpdate = self::findfirst("id = ".$intProductId); 
		if( empty($objProductUpdate) )	return false;
		return $objProductUpdate->update($arrUpdate);
	}
	
	/**
	 * 根据ID获取指定的商品信息
	 *
	 * @param int $intProductId
	 * @return array
	 */
	public function getProductById($intProductId) {
    	if( empty($intProductId) ) return array();
    	$arrProduct = self::findfirst( "id=".$intProductId );
    	if( empty($arrProduct) ) return array();
		return $arrProduct->toArray();
	}
	
	/**
	 * 删除商品
	 *
	 * @param int $intProductId 商品ID
	 * @return int
	 */
	public function delProductById($intProductId) {
		return $this->deleteAll("vpId = ".$intProductId);
	}
	
	/**
	 * 获取兑换商品
	 *
	 * @param array $arrCondition 查询条件
	 * @param string $strOrder 排序条件
	 * @param int $intOffset 起始位置
	 * @param int $intSize 查询长度
	 * @param string $strSelect 查询字段
	 * @return array
	 */
	public function getProduct($arrCondition = array(), $strOrder = '', $intOffset = 0, $intSize = 20, $strSelect = ''){
		return $this->getAll($arrCondition, $strOrder, $intOffset, $intSize, $strSelect);
	}
	
	/**
	 * 获取兑换商品数量
	 *
	 * @param array $arrCondition 查询条件
	 * @return int
	 */
	public function getProductCount($arrCondition = array()){
		return $this->getCount($arrCondition);
	}
}