<?php
class HousePicture extends BaseModel
{
	//房源的图片类型
	const IMG_HUXING = 1; //户型图
	const IMG_SHINEI = 2; //室内图
	const IMG_WAIGUAN = 3; //外观图
    const IMG_WEIZHI = 4;//位置图

	//房源的图片状态
	const STATUS_OK = 1; //有效
	const STATUS_DEL = -1; //删除
	const STATUS_NOPASS = 0; //审核失败

	//室内图最大限定条数
	const MAX_SHIENEI = 10;	

    protected $id;//为了兼容接口旧参数
    protected $houseId;
    protected $imgId;
    protected $imgExt;
    protected $parkId = 0;
    protected $type;
    protected $desc;
    protected $meta;
    protected $seq;
    protected $status;
    protected $picUpdate;
	private   $mNotDealImage = array();

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

    public function getImgId()
    {
        return $this->imgId;
    }

    public function setImgId($imgId)
    {
        if(preg_match('/^\d{1,10}$/', $imgId == 0) || $imgId > 4294967295)
        {
            return false;
        }
        $this->imgId = $imgId;
    }

    public function getImgExt()
    {
        return $this->imgExt;
    }

    public function setImgExt($imgExt)
    {
        $this->imgExt = $imgExt;
    }

    public function getParkId()
    {
        return $this->parkId;
    }

    public function setParkId($parkId)
    {
        if(preg_match('/^\d{1,10}$/', $parkId == 0) || $parkId > 4294967295)
        {
            return false;
        }
        $this->parkId = $parkId;
    }

    public function getPicType()
    {
        return $this->type;
    }

    public function setPicType($picType)
    {
        if(preg_match('/^\d{1,3}$/', $picType == 0) || $picType > 255)
        {
            return false;
        }
        $this->type = $picType;
    }

    public function getPicDesc()
    {
        return $this->desc;
    }

    public function setPicDesc($picDesc)
    {
        if($picDesc == '' || mb_strlen($picDesc, 'utf8') > 50)
        {
            return false;
        }
        $this->desc = $picDesc;
    }

    public function getPicMeta()
    {
        return $this->meta;
    }

    public function setPicMeta($picMeta)
    {
        if($picMeta == '' || mb_strlen($picMeta, 'utf8') > 250)
        {
            return false;
        }
        $this->meta = $picMeta;
    }

    public function getPicSeq()
    {
        return $this->seq;
    }

    public function setPicSeq($picSeq)
    {
        if(preg_match('/^\d{1,10}$/', $picSeq == 0) || $picSeq > 4294967295)
        {
            return false;
        }
        $this->seq = $picSeq;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        if(preg_match('/^-?\d{1,3}$/', $status) == 0 || $status > 127 || $status < -128)
        {
            return false;
        }
        $this->status = $status;
    }

    public function getPicUpdate()
    {
        return $this->picUpdate;
    }

    public function setPicUpdate($picUpdate)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $picUpdate) == 0 || strtotime($picUpdate) == false)
        {
            return false;
        }
        $this->picUpdate = $picUpdate;
    }

    public function getSource()
    {
        return 'house_picture';
    }

    public function columnMap()
    {
        return array(
            'hpId' => 'id',
            'houseId' => 'houseId',
            'imgId' => 'imgId',
            'imgExt' => 'imgExt',
            'parkId' => 'parkId',
            'picType' => 'type',
            'picDesc' => 'desc',
            'picMeta' => 'meta',
            'picSeq' => 'seq',
            'picStatus' => 'status',
            'picUpdate' => 'picUpdate'//不能改成update，否则sql解析不通过
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
     * @return Park_Model
     */

    public static function instance($cache = true) 
    {
        return parent::_instance(__CLASS__, $cache);
    }

	/**
	 * 获取房源图片描述配置（常量不支持数组）
	 *
	 * @return array
	 */
	public function getImageDesc(){
		return array(
			1 => '卧室',
			2 => '客厅',
			3 => '阳台',
			4 => '厨房',
			5 => '餐厅',
			6 => '书房',
			7 => '卫生间',
			8 => '储物间'
		);
	}
	
	/**
	 * 保存房源图片
	 *
	 * @param array $arrData
	 * @param int $type 0:其他 1:个人
	 * @return bool
	 */
	public function addImage($arrData, $type = 0) {
		$intInsert = false;
		if ( empty($arrData['houseId']) ) return false;
		$arrData['parkId'] = empty($arrData['parkId']) ? 0 : intval($arrData['parkId']);//接口会发布小区ID为0的房源
		if ( isset($arrData['houseId']) ) {
			$arrInsert['houseId'] = $arrData['houseId'];
		}
		if ( isset($arrData['parkId']) ) {
			$arrInsert['parkId'] = $arrData['parkId'];
		}
		if ( isset($arrData['uploadimage']) ) {
			$arrInsert['Image'] = $arrData['uploadimage'];
		}
		$intTime = time();
		$intStatus = self::STATUS_OK;
		if ( !empty($arrInsert['Image']) ) {
			$strSql = "INSERT INTO `{$this->getSource()}` (`houseId`, `imgId`, `imgExt`, `parkId`, `picType`, `picStatus`, `picUpdate`) VALUES ";
			if($type)
			{
				foreach ( $arrInsert['Image'] as $image ) {
					$intInsert = true;
					$strSql .= "('{$arrInsert['houseId']}', '{$image['image_id']}', '{$image['image_ext']}', '{$arrInsert['parkId']}', '{$image['type']}', '{$intStatus}', '".(date('Y-m-d H:i:s', $intTime--))."'),";
				}
			}
			else
			{
				foreach ( $arrInsert['Image'] as $intImageType => $arrRow ) {
					foreach ( $arrRow as $image ) {
						if ( in_array($image['image_id'], $this->mNotDealImage) ) continue;
						$intInsert = true;
						$strSql .= "('{$arrInsert['houseId']}', '{$image['image_id']}', '{$image['image_ext']}', '{$arrInsert['parkId']}', '{$intImageType}', '{$intStatus}', '".(date('Y-m-d H:i:s', $intTime--))."'),";
					}
				}
			}
			$strSql = rtrim($strSql, ",");
		}
		if ( $intInsert === false ) return true;
		if ( empty($strSql) ) return false;
		return $this->execute($strSql);
	}
	
	/**
	 * 根据房源Id和房源类型，删除指定房源无效图片
	 * 逻辑如下：
	 * 1）检出用户上传的所有图片
	 * 2）读取当前房源的所有图片
	 * 3）取1和2的差值，意味着差异的图片做删除标记，等待脚本去完成物理删除
	 * 4）检出1和2的交集，意味着不做改变的数据，全局变量，提交给添加图片逻辑，跳过已存在图片的插入
	 *
	 * @param int $intUnitId
	 * @param int $intUnitType
	 * @param array $arrImage 用户提交的图片
	 * @return int|bool
	 */
	public function delImageByHouseId($intHouseId, $arrImage = array()) {
		$arrRequestImage = $arrUseImage_C = $arrWatingDealImage = array();
		if ( !empty($arrImage) ) {
			foreach ( $arrImage as $ut => $urow ) {
				foreach ( $urow as $k => $v ) {
					$arrRequestImage[] = $v['image_id'];
				}
			}
		}
		//获取房源当前的图片ID
		$arrUseImage = self::find("houseId=".$intHouseId." and status=".self::STATUS_OK)->toArray();
		if ( !empty($arrUseImage) ) {
			foreach ( $arrUseImage as $k => $v ) {
				$arrUseImage_C[] = $v['imgId'];
			}
		}
		//如果图片为空，不进行更新处理，标记当前所有图不进行再次插入操作
		if ( empty($arrRequestImage) ) {
			$this->mNotDealImage = $arrUseImage_C;
			return true;
		}
		//获取用户删除的图片
		$arrWatingDealImage = array_diff($arrUseImage_C, $arrRequestImage);
		$this->mNotDealImage = array_intersect($arrRequestImage, $arrUseImage_C);
		if ( empty($arrWatingDealImage) ) return true;
		$strSql = "UPDATE `{$this->getSource()}` SET `picStatus`=".self::STATUS_DEL." WHERE houseId=".$intHouseId." AND imgId IN (".implode(',', $arrWatingDealImage).")";
		return $this->execute($strSql);
	}
	
	/**
	 * 根据条件获取图片信息
	 */
	public function getImageByCondition($condition=array(), $order='', $offset=0, $limit=0, $select='', $status=''){
		if(empty($condition)){
			return false;
		}
        if(!empty($condition['houseId'])){
			if(is_array($condition['houseId'])){
				$where = "(";   
				for($i=0;$i<count($condition['houseId']);$i++){
					if(empty($condition['houseId'][$i])) continue;
					if($i == count($condition['houseId'])-1){
						$where.=" houseId=".$condition['houseId'][$i].")";
					}else{
						$where.=" houseId=".$condition['houseId'][$i]." or ";
					}
				}
				$where = $where == "(" ? "1=1" : $where;
			}else{
				$where = "houseId=".$condition['houseId'];
			}
        } else{
        	$where = "1=1";
        }
		foreach($condition as $key=>$value){
			if($key == 'houseId') continue;
			$where.=" and ".$key."=".$value;
		}
        if($status!=''){
            $where .= " AND status=".$status;
        }
		$con['conditions'] =$where;
		
		$limit = intval($limit);
    	$offset = intval($offset);
    	if($limit>0){
    		$con['limit'] = array('number'=>$limit,'offset'=>$offset);
    	}
    	if(!empty($order)){
    		$con['order'] = $order;
    	}
    	if(!empty($select)){
    		$con['columns'] = $select;
    	}
    	return self::find($con);		
	}



    /**
     * 获取图片数量 - 根据房源ID
     * @auth jackchen
     * @param int  $parkId
     * @param int  $imgId
     * @param int  $status
     * @param int  $type
     * @return boolean
     */
    public function getHousePicCountById($houseId, $status=self::STATUS_OK, $type=0)
    {
        if(!$houseId) return 0;
        $strCondition = "houseId = $houseId and status = $status";
        if(!empty($type)) $strCondition .= " and type = $type";
        $count = $this->getCount($strCondition);
        return $count;
    }


	/**
	 * 获取指定房源的图片信息
	 *
	 * @param int $ids 数组为获取多条信息
	 * @return array
	 */
	public function getImageByHouseId($ids) {
		$arrBackData = array();
		if (!is_array($ids)) $ids = array($ids);
		$arrHouseImage = self::find(array("houseId IN(".implode(',', $ids).") and status =".HousePicture::STATUS_OK, "orderBy" => "picUpdate desc"));
		if ( !empty($arrHouseImage) ) {
			$arrHouseImage = $arrHouseImage->toArray();
			foreach ( $arrHouseImage as $u ) {
				$arrBackData[$u['houseId']][$u['type']][$u['id']] = array(
					'image_id' => $u['imgId'],
					'image_ext' => $u['imgExt'],
					'img_desc' => $u['desc'],
					'url' => ImageUtility::getImgUrl('esf', $u['imgId'], $u['imgExt'], 180, 120),
					'image' => $u['imgId'].".".$u['imgExt'],
				);
			}
		}
		unset($arrHouseImage);
		return $arrBackData;
	}
	
	/**
	 * 保存焦点通房源图片
	 *
	 * @param int $intUnitId
	 * @param int $intParkId
	 * @param array $arrData
	 * @return int|bool
	 */
	public function saveUnitImage($intUnitId, $intParkId, $arrData) {
		if ( !is_numeric($intUnitId) || $intUnitId <= 0) {
			return false;
		}
		if ( !is_numeric($intParkId) || $intParkId <= 0) {
			return false;
		}

		//获取该房源的数据库中图片并格式化
		$arrDBData = self::find(array("houseId='".$intUnitId."'", "orderBy" => "picUpdate desc"));
		$arrFormatDBData = array();
		if ( !empty($arrDBData) ) {
			$arrDBData = $arrDBData->toArray();
			foreach ( $arrDBData as $k => $v ){
				$arrFormatDBData[] = $v['imgId'].'.'.$v['imgExt'];
			}
			unset($arrDBData);
		}
		$arrFormatDBDataFlip = array_flip($arrFormatDBData);  //这样做主要是为了unset做准备

		$arrNewImage = array(); //新插入的图片数据
		$arrRepeatImage = array();  //重复的图片数据
		$time = time();
		$intMaxShinei = self::MAX_SHIENEI;
		$intStatus = self::STATUS_OK;
		$flag_sql_execute = false;
		$sql = "INSERT INTO `{$this->getSource()}` (`houseId`, `imgId`, `imgExt`, `parkId`, `picType`, `picStatus`, `picUpdate`) VALUES ";
		if ( isset($arrData['shinei']) ) {    //这里修改这个$arrData的结构时，记得修改MNetsMonitor->formartImage()的
			$tmp_count = $time;
			foreach ( $arrData['shinei']['img'] as $k => $v ) {

				if( intval($k)<0 || intval($k)>=$intMaxShinei ) continue;

				if( array_key_exists($v, $arrFormatDBDataFlip) ){  //这里是过滤要删除的图片和不需要写入库的数据
					$arrRepeatImage[] = $v;
					unset($arrFormatDBDataFlip[$v]);
				}else{
					$arrNewImage[] = $v;
				}
				$arrV = explode(".", $v);
				$sql .= "('{$intUnitId}','{$arrV[0]}','{$arrV[1]}','{$intParkId}','".self::IMG_SHINEI."','{$intStatus}','".date('Y-m-d H:i:s', $tmp_count--)."'),";
			}
			$flag_sql_execute = true;
		}

		if ( isset($arrData['huxing']) ) {
			$tmp_count = $time;
			foreach ( $arrData['huxing']['img'] as $k => $v ) {

				if( intval($k)<0 || intval($k)>=5 ) continue;

				if( array_key_exists($v, $arrFormatDBDataFlip) ){
					$arrRepeatImage[] = $v;
					unset($arrFormatDBDataFlip[$v]);
				}else{
					$arrNewImage[] = $v;
				}
				$arrV = explode(".", $v);
				$sql .= "('{$intUnitId}','{$arrV[0]}','{$arrV[1]}','{$intParkId}','".self::IMG_HUXING."','{$intStatus}','".date('Y-m-d H:i:s', $tmp_count--)."'),";
				$tmp_count--;
			}
			$flag_sql_execute = true;
		}
		if ( isset($arrData['waiguan']) ) {
			$tmp_count = $time;
			foreach ( $arrData['waiguan']['img'] as $k => $v ) {

				if( intval($k)<0 || intval($k)>=5 ) continue;

				if( array_key_exists($v, $arrFormatDBDataFlip) ){
					$arrRepeatImage[] = $v;
					unset($arrFormatDBDataFlip[$v]);
				}else{
					$arrNewImage[] = $v;
				}
				$arrV = explode(".", $v);
				$sql .= "('{$intUnitId}','{$arrV[0]}','{$arrV[1]}','{$intParkId}','".self::IMG_WAIGUAN."','{$intStatus}','".date('Y-m-d H:i:s', $tmp_count--)."'),";
				$tmp_count--;
			}
			$flag_sql_execute = true;
		}
		$sql = rtrim($sql, ",");

		//这里做删除无用图片做准备（把无用的图片unit_id置为0）
		if( !empty($arrFormatDBDataFlip) ){
			$image_id = array_flip($arrFormatDBDataFlip);
			$value_image_id = '';
			foreach ($image_id as $key_image_id => &$value_image_id) {
				$value_image_id = substr_replace($value_image_id, '', -4, 4);
			}
			$strDelCondtion = "houseId=".$intUnitId." AND imgId IN (".implode(',', $image_id).")";
			$updateUpdateData = array('picStatus' => self::STATUS_DEL);
			$this->updateAll($strDelCondtion, $updateUpdateData);
		}

		//删除原来的图片，为了做兼容排序操作
		if( !empty($arrRepeatImage) ){
			$value_image_id = '';
			foreach ($arrRepeatImage as &$value_image_id) {
				$value_image_id = substr_replace($value_image_id, '', -4, 4);
			}
			$strRepeatCondition = "houseId=".$intUnitId." AND imgId IN (".implode(',', $arrRepeatImage).")";
			$this->deleteAll($strRepeatCondition);
		}

		if( !$flag_sql_execute ){//清除图片时的操作
			return $this->delImageByHouseId($intUnitId);
		}

		$flag_result = $this->execute($sql);

		//推送队列入库小区图片库
		$intCityId = isset($GLOBALS['client']['cityId']) ? $GLOBALS['client']['cityId'] : 1;
		$intRealId = isset($GLOBALS['client']['realId']) ? $GLOBALS['client']['realId'] : 0;
		Quene::Instance()->Put('house', array('action' => 'image', 'houseId' => $intUnitId, 'realId' => $intRealId, 'cityId' => $intCityId, 'parkId' => $intParkId, 'time' => date('Y-m-d H:i:s', time())));

		return $flag_result;
	}
	
	/**  
	 * @abstract 个人房源删除图片，先将图片的houseId修改为0后，运行脚本删除
	 * @author Eric xuminwan@sohu-inc.com
	 * @param string $strCondition
	 * @return bool
	 * 
	 */
	public function modHousePictureById($strCondition)
	{
		if(!($strCondition))
		{
			return false;
		}
		$objPicture = self::find(array($strCondition));
		$flag_result = true;
		if($objPicture)
		{
			foreach ($objPicture as $picture)
			{
				$picture->houseId = 0;
				$flag = $picture->save();
				if(!$flag) $flag_result = false;
			}
		}
		return $flag_result;
	}



    /**
     * 获取指定房源ID
     * @auth jackchen
     * @param int $id
     * @return array
     */
    public function getImageByPicHouseId($id) {
        $arrBackData = array();
        $arrHouseImage = self::find(array("houseId =".$id." and status =".HousePicture::STATUS_OK, "orderBy" => "picUpdate desc"));
        if ( !empty($arrHouseImage) ) {
            $arrHouseImage = $arrHouseImage->toArray();
            foreach ( $arrHouseImage as $u ) {
                $arrBackData[$u['id']] = array(
                    'image_id' => $u['imgId'],
                    'image_ext' => $u['imgExt'],
                    'image_type' => $u['type'],
                    'img_desc' => $u['desc'],
                    //'url' => ImageUtility::getImgUrl('esf', $u['imgId'], $u['imgExt'], 180, 120)
                );
            }
        }
        unset($arrHouseImage);
        return $arrBackData;
    }

}