<?php
/**
 * @abstract 委托管理
* @author weiliting litingwei@sohu-inc.com
* @since  2014年9月30日11:15:03
*/
class Entrust extends BaseModel
{
    //发起者类型
    const SENDER_TYPE_PERSON    = 1; //个人
    
	//接受者类型
	const RECIPIENT_TYPE_BROKER = 1; //经纪人
	
	//委托内容类型
	const CONTENT_TYPE_SALE         = 2; //二手房(出售)
	const CONTENT_TYPE_RENT         = 1; //租房(出租)
	const CONTENT_TYPE_QIU_SALE     = 3; //求购
	const CONTENT_TYPE_QIU_RENT     = 4; //求租

	//委托状态
	const STATUS_VALIDITY       = 1; //有效状态
	const STATUS_DEL            = 2; //删除状态
	const STATUS_HIDE			= 3; //隐藏状态（当委托源处于隐藏状态时置该状态）
	
	//已读状态
	const NO_READ               = 1; //未读
	const READ                  = 2; //已读
	
	public $id;
	public $cityId;
	public $senderId;
	public $senderType;
	public $recipientId;
	public $recipientType;
	public $contentId;
	public $contentType;
	public $time;
	public $status;
	public $isRead;

	public function getSource()
	{
		return 'web_entrust';
	}
	
	
	public function columnMap()
	{
		return array(
				'enId' => 'id',
				'cityId' => 'cityId',
				'enSenderId' => 'senderId',
				'enSenderType' => 'senderType',
				'enRecipientId' => 'recipientId',
				'enRecipientType' => 'recipientType',
				'enContentId' => 'contentId',
				'enContentType' => 'contentType',
				'enTime' => 'time',
				'enStatus' => 'status',
				'isRead' => 'isRead'
		);
	}

	public function initialize()
	{
		$this->setReadConnectionService('esfSlave');
		$this->setWriteConnectionService('esfMaster');
	}
	
	/**
	 * 获得委托房源根据被委托的经纪人id
	 * @param int $intRealtor 经纪人id
	 * @param int $intUnitType 委托房源类型
	 * @return array array(
	 *						'content_id' = array(
	 *											'id'
	 *											'content_id' =>,
	 *											'is_read'=>
	 *											'entrust_time'=>
	 *						),
	 *						...
	 *						)
	 **/
	private function _getUnitEntrustByRealtorId( $intRealtor, $intUnitType ) 
	{
		if( empty( $intRealtor ) || empty( $intUnitType ) || 0 == intval( $intRealtor ) || 0 == intval( $intUnitType ) ) {
			$this -> setError( '参数错误' );
			return FALSE;
		}
		$where = " recipientId = ".intval( $intRealtor )." and recipientType = ".Entrust::RECIPIENT_TYPE_BROKER." and status = ".Entrust::STATUS_VALIDITY." and cityId = ".$GLOBALS['client']['cityId'];
		if($intUnitType == Entrust::CONTENT_TYPE_SALE)
		{
			$where .= " and contentType = ".Entrust::CONTENT_TYPE_SALE;//in (".House::TYPE_ERSHOU.",".House::TYPE_CIXIN.")";
		}
		else 
		{
		    $where .= " and contentType = ".Entrust::CONTENT_TYPE_RENT;//in (".House::TYPE_HEZU.",".House::TYPE_ZHENGZU.")";
		}
		$arrResult = self::getAll($where,' time desc', '', '', ' id, contentId, isRead, time');
		if( empty( $arrResult ) ) 
		{
			return array();
		}
		else 
		{
			$arrNewResult = array();
			foreach( $arrResult as $intResultKey => $itemResult )
			{
				$arrNewResult[$itemResult['contentId']] = $itemResult;
			}
			$arrResult = null;
			return $arrNewResult;
		}
	}
	
	/**
	 * 获得委托出租出售房源列表根据委托经纪人id
	 * @param int $intRealtorId 经纪人id
	 * @param int $content_type 委托房源类型
	 * @param int $offset 起点位置
	 * @param int $size 获得数据数量
	 * @return array array(
	 *						'0' => array(
	 *											'id'=>
	 *											'contact_phone' =>,
	 *											'contact_name' =>,
	 *											'house_id' =>,
	 *											'house_name' =>,
	 *											'entrust_time' =>
	 *											'is_read'=>,
	 *											'bedroom'=>
	 *											'area'=>
	 *											'floor'=>
	 *											'floor_max'=>
	 *											'exposure'
	 *											'fitment'=>
	 *											'price'=>
	 *											),
	 *						...
	 *						)
	 **/
	public function getUnitListByRealtorId( $intRealtorId, $content_type = Entrust::CONTENT_TYPE_SALE, $offset = 0, $size = 20 ) 
	{
		if( empty( $intRealtorId ) || 0 == intval( $intRealtorId ) ) 
		{
			$this -> error( '参数错误' );
			return FALSE;
		}
		$arrEntrust = $this -> _getUnitEntrustByRealtorId( $intRealtorId, $content_type );
		$arrContentIds = array_keys( $arrEntrust );
		if( empty( $arrContentIds ) ) return array();
		$condition = array();
		$condition['id'] = $arrContentIds;
		$condition['status'] = array( '<>' => 0 );//取得全部房源
		$objHouse = new House();
		if($content_type == Entrust::CONTENT_TYPE_SALE)
		{
			$houseType = 'Sale';
		}
		else 
		{
			$houseType = 'Rent';
		}
		$arrUnit = $objHouse->getSearchUnit( $condition, "", $offset, $size, false, $houseType );
		if( empty( $arrUnit['arrData'] ) ) return array();
		$arrNewUnit = array();
		$arrNewUnit['count'] = $arrUnit['intTotal'];
		foreach( $arrUnit['arrData'] as $data ) 
		{
			$temp = array();
   			$temp['hoId']    = $data['hoId'];
 			$temp['entrust_time']    = $arrEntrust[$data['id']]['time'];
			$temp['projId']  = $data['projId'];
			$temp['id']      = $data['id'];
			$temp['area']      = $data['area'];
			$temp['price']   = $data['housePrice'];
			$temp['status']   = $data['status'];
			$temp['rentPrice'] = $data['rentPrice'];
			$temp['rentCurrency'] = $data['rentCurrency'];
			$temp['danwei'] = '';
			if($data['type'] == House::TYPE_HEZU || $data['type'] == House::TYPE_ZHENGZU)
			{
				$temp['danwei'] = $GLOBALS['RENT_PRICE_UNIT'][$data['danwei']];
			}
			$temp['floor']           = $data['floor'];
			$temp['floorMax']       = $data['floorMax'];
			$temp['decoration']         = isset($GLOBALS['UNIT_FITMENT'][$data['decoration']]) ? $GLOBALS['UNIT_FITMENT'][$data['decoration']] : '';//装修情况
			$temp['orientation']        = isset($GLOBALS['UNIT_EXPOSURE'][$data['orientation']]) ? $GLOBALS['UNIT_EXPOSURE'][$data['orientation']] : '';//朝向
			if(empty($data['bedRoom']) && empty($data['livingRoom']))
			{
				$temp['bedRoom'] = '--';
			}
			else
			{
				$temp['bedRoom'] = $data['bedRoom']==99?'复式':($data['bedRoom']==100?'开间':($data['livingRoom'] > 0 ? $data['bedRoom'].'室'.$data['livingRoom'].'厅' : $data['bedRoom'].'室'));
			}
			$temp['enId']              = $arrEntrust[$data['id']]['id'];//委托id
			$temp['isRead']         = $arrEntrust[$data['id']]['isRead'];//委托是否已读
			$arrNewUnit['arrData'][$data['id']] = $temp;
			$arrParkIds[] = $data['projId'];
		}
	
		$arrParkIds = array_unique(array_filter($arrParkIds));
		$objPark = new Park();
		//获取小区信息
		$arrParkTemp = $objPark->getAll(" id in(".implode(',', $arrParkIds).")",'','','','id,name');
		foreach($arrParkTemp as $park)
		{
			$arrPark[$park['id']] = $park['name'];
		}

		foreach ($arrNewUnit['arrData'] as &$item)
		{
			$item['parkName'] = $arrPark[$item['projId']];//小区名称
		}

		return $arrNewUnit;
	}
	
	/**
	 * 删除委托根据委托id
	 * @param int $id 委托id
	 * @return false or true
	 **/
	public function delEntrustByIdAndRealtorId( $id, $intRealtorId ) 
	{
		if( empty( $id ) || empty( $intRealtorId ) || 0 == intval( $id ) || 0 == intval( $intRealtorId ) ) 
		{
			$this -> error( '参数错误' );
			return FALSE;
		}
        $where = " enid = ".intval( $id )." and enRecipientId = ".intval( $intRealtorId )." and enRecipientType = ".Entrust::RECIPIENT_TYPE_BROKER." and enStatus =".Entrust::STATUS_VALIDITY;
		$data['enStatus'] = Entrust::STATUS_DEL;
		return self::updateAll( $where, $data );
	}
	
	/**
	 * 设置委托房源已读
	 * @param int $id 委托id
	 * @param  经纪人id
	 * @return false or true
	 **/
	public function setReadByIdAndRealtorId( $id, $intRealtorId ) 
	{
		if( empty( $id ) || empty( $intRealtorId ) || 0 == intval( $id ) || 0 == intval( $intRealtorId ) )
		{
			$this -> error( '参数错误' );
			return FALSE;
		}
        $where = " enId = ".intval( $id )." and enRecipientId = ".intval( $intRealtorId )." and enRecipientType = ".Entrust::RECIPIENT_TYPE_BROKER." and enStatus =".Entrust::STATUS_VALIDITY." and isRead = ".Entrust::NO_READ;
		$data['isRead'] = Entrust::READ;
		return self::updateAll( $where, $data );
	}
	
	/**
	 * @abstract 添加委托信息 
	 * @author Eric xuminwan@sohu-inc.com
	 * @param array $arrData
	 * @return int | bool
	 * 
	 */
	public function addEntrust($arrData)
	{
		if(!$arrData) return false;
		$arrInsert = array();
		//cityId
		if(isset($arrData['cityId']))
		{
			$arrInsert['cityId'] = $arrData['cityId'];
		}
		 
		//发起者Id
		if(isset($arrData['senderId']))
		{
			$arrInsert['senderId'] = $arrData['senderId'];
		}
		 
		//发起者类型
		if(isset($arrData['senderType']))
		{
			$arrInsert['senderType'] = $arrData['senderType'];
		}
		 
		//接收者id
		if(isset($arrData['recipientId']))
		{
			$arrInsert['recipientId'] = $arrData['recipientId'];
		}
		 
		//接收者类型
		if(isset($arrData['recipientType']))
		{
			$arrInsert['recipientType'] = $arrData['recipientType'];
		}
		 
		//委托内容Id
		if(isset($arrData['contentId']))
		{
			$arrInsert['contentId'] = $arrData['contentId'];
		}
		
		//委托内容类型
		if(isset($arrData['contentType']))
		{
			$arrInsert['contentType'] = $arrData['contentType'];
		}
		
		//委托时间
		if(isset($arrData['time']))
		{
			$arrInsert['time'] = $arrData['time'];
		}
		 
		$arrInsert['status'] = self::STATUS_VALIDITY;
		$arrInsert['isRead'] = self::NO_READ;		//更新时间
		try
		{
			//这条不能使用self::create()的方式来处理，因为多条foreach时，model不重新new的话，自增的id无法更新
			$mEntrust = new Entrust();
			if($mEntrust->create($arrInsert))
				return $this->insertId();
			else
				return false;
		}
		catch (Exception $ex)
		{
			return false;
		}
	}
	
	/**
	 * @abstract 根据相关条件获取委托信息 
	 * @author Eric xuminwan@sohu-inc.com
	 * @param string $strCondition
     * @param string $columns
     * @param string $order
     * @param int $pageSize
     * @param int $offset
	 */
	public function getEntrustByCondition($strCondition, $columns = '', $order = '', $pageSize = 0, $offset = 0)
	{
		if(!$strCondition) return array();
		$arrCon = array();
		$arrCon['conditions'] = $strCondition;
		if($columns) $arrCon['columns'] = $columns;
		if($pageSize > 0) $arrCon['limit'] = array('number'=>$pageSize, 'offset'=>$offset);
		if($order) $arrCon['order'] = $order;
		$arrPark = self::find($arrCon,0)->toArray();
		return $arrPark;
	}
	
	/**
	 * @abstract 根据条件修改委托信息 
	 * @author Eric xuminwan@sohu-inc.com
	 * @param string $strCondition
	 * @param array $arrData
	 * @return bool
	 * 
	 */
	public function ModifyEntrustByCondition($strCondition, $arrData)
	{
		if(!($strCondition && $arrData)) return false;
		$result = self::find(array('conditions'=>$strCondition));
		if($result)
		{
			$resultFlag = true;
			foreach ($result as $entrust)
			{
				$entrust->status = $arrData['status'];
				if(!$entrust->save())
				{
					$resultFlag = false;
				}
			}
		}
		return $resultFlag;
	}

    public function deleteBySendId($senderId){
        $modelName = get_class($this);
        $this->getModelsManager()->executeQuery("delete from $modelName where senderId=:senderId:",array(
            "senderId"    =>  $senderId,
        ));
    }

    public function deleteById($id){
        $modelName = get_class($this);
        $this->getModelsManager()->executeQuery("delete from $modelName where id=:id:",array(
            "id"    =>  $id,
        ));
    }

    public function deleteByIds($ids){
        $modelName = get_class($this);
        $this->getModelsManager()->executeQuery("delete from $modelName where id in (".join(',', $ids).")");
    }
}
