<?php
class ParkPicture extends BaseModel
{
    protected $parkId;
    protected $cityId;
    protected $imgId;
    protected $imgExt;
    protected $type;
    protected $desc = '';
    protected $meta = '';
    protected $weight;
    protected $realId = 0;
    protected $status;
    protected $update;
    protected $uploadTime;
    protected $auditor = 0;
    protected $auditTime = 0;
    
    const IMAGE_TYPE_WAIGUAN = 1;  //外观图
	const IMAGE_TYPE_HUXING  = 2;  //户型图
	const IMAGE_TYPE_ZHUTU  = 3;  //主图(优质小区活动提供)
	const IMAGE_TYPE_WAIJING  = 4;  //外景图(优质小区活动提供)
	const IMAGE_TYPE_ZHOUBIAN  = 5;  //周边图(优质小区活动提供)
    
    //数据状态status
	const STATUS_UNCHECK = 1;  //未审核
	const STATUS_PASS    = 2;  //通过审核
	const STATUS_UNPASS  = 3;  //未通过
	const STATUS_DELETE  = -1; //删除状态
    
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

    public function getPicType()
    {
        return $this->picType;
    }

    public function setPicType($picType)
    {
        if(preg_match('/^\d{1,3}$/', $picType == 0) || $picType > 255)
        {
            return false;
        }
        $this->picType = $picType;
    }

    public function getPicDesc()
    {
        return $this->picDesc;
    }

    public function setPicDesc($picDesc)
    {
        if($picDesc == '' || mb_strlen($picDesc, 'utf8') > 50)
        {
            return false;
        }
        $this->picDesc = $picDesc;
    }

    public function getPicMeta()
    {
        return $this->picMeta;
    }

    public function setPicMeta($picMeta)
    {
        if($picMeta == '' || mb_strlen($picMeta, 'utf8') > 250)
        {
            return false;
        }
        $this->picMeta = $picMeta;
    }

    public function getPicSeq()
    {
        return $this->picSeq;
    }

    public function setPicSeq($picSeq)
    {
        if(preg_match('/^\d{1,10}$/', $picSeq == 0) || $picSeq > 4294967295)
        {
            return false;
        }
        $this->picSeq = $picSeq;
    }

    public function getPicRealId()
    {
        return $this->picRealId;
    }

    public function setPicRealId($picRealId)
    {
        if(preg_match('/^\d{1,10}$/', $picRealId == 0) || $picRealId > 4294967295)
        {
            return false;
        }
        $this->picRealId = $picRealId;
    }

    public function getPicStatus()
    {
        return $this->picStatus;
    }

    public function setPicStatus($picStatus)
    {
        if(preg_match('/^-?\d{1,3}$/', $picStatus) == 0 || $picStatus > 127 || $picStatus < -128)
        {
            return false;
        }
        $this->picStatus = $picStatus;
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
        return 'park_picture';
    }
    
    public function getStatus() 
    {
        return array(
            self::STATUS_UNCHECK => '未审核',
            self::STATUS_PASS    => '通过审核',
            self::STATUS_UNPASS  => '未通过审核',
            self::STATUS_DELETE  => '已删除'
        );
    }
    
    public static function getWaiGuanTag()
    {
        return array(
             1 => '实景图',
             2 => '效果图',
             3 => '楼座图',
             4 => '交通图',
             5 => '样板间',
             6 => '配套图',
             7 => '装修案例',
        );
	}
    
    /**
     * 批量审核图片
     * @param array $pictures
     * @param int   $fromStatus
     * @param int   $toStatus
     * @return array
     */
    public function auditBatch($pictures, $fromStatus = self::STATUS_UNCHECK, $toStatus = self::STATUS_PASS)
    {
        //$this->begin();
        $info = '';
        foreach($pictures as $v)
        {
            $res = $this->audit($v,$fromStatus,$toStatus);
            if(0 !== $res['status'])
            {
               // $this->rollback();
                $info .= $res['info'];
            }
            //审核通过加积分
            if($toStatus == self::STATUS_PASS && 0 == $res['status']){
                $rs = self::findFirst("parkId={$v['parkId']} and imgId={$v['imgId']}");
                if($rs){
                     Quene::Instance()->Put('realtor', array('action' => 'score', 'type' => VipScoreDetail::PROJECT_IMAGE_PROVIDER, 'realId' => $rs->realId, 'time' => date('Y-m-d H:i:s', time())));//写入队列加积分
                }

            }

        }
        if($info!=''){
            return array('status'=>1, 'info'=>$info.',其他审核成功！');
        }
        //$this->commit();
        return array('status'=>0, 'info'=>'审核成功！');
    }
    
    /**
     * 审核图片
     * @param array   $data
     * @param int     $fromStatus
     * @param int     $toStatus
     * @return array
     */
    public function audit($data, $fromStatus = self::STATUS_UNCHECK, $toStatus = self::STATUS_PASS) 
    {
        $allStatus = $this->getStatus();
        if(empty($data) || !array_key_exists($fromStatus, $allStatus) || !key_exists($toStatus, $allStatus)) 
        {
            return array('status'=>1, 'info'=>'小区'.$data['parkId'].'图片'.$data['imgId'].'参数无效！');
        }
        $parkId = $data['parkId'];
        $imgId = $data['imgId'];
        
        if(!$this->isExist($parkId, $imgId, $fromStatus))
        {
            return array('status'=>1, 'info'=>'小区'.$parkId.'图片'.$imgId.'不是待审！');
        }   

        $rs = self::findFirst("parkId={$parkId} and imgId={$imgId}");
        $rs->auditor = $data['auditor'];
        $rs->auditTime = time();
        $rs->status = $toStatus;

        if($rs->update()) 
        {
            return array('status'=>0, 'info'=>'审核成功！');  
        }
        return array('status'=>1, 'info'=>'小区'.$parkId.'图片'.$imgId.'审核失败！');
    }
    
    /**
     * 检测图片是否已存在
     * @param int  $parkId
     * @param int  $imgId
     * @param int  $status
     * @return boolean
     */
    private function isExist($parkId, $imgId, $status=self::STATUS_UNCHECK) 
    {
        $parkId = intval($parkId);
        $imgId = intval($imgId);
        if(!$parkId || !$imgId)
        {
            return false;
        }
        $con['conditions'] = "parkId={$parkId} and imgId={$imgId} and status={$status}";
                
        $intCount = self::count($con);
        if($intCount > 0) 
        {
            return true;
        }
        return false;
    }
    
    public function columnMap()
    {
        return array(
            'parkId'        => 'parkId',
            'cityId'        => 'cityId',
            'imgId'         => 'imgId',
            'imgExt'        => 'imgExt',
            'picType'       => 'type',
            'picDesc'       => 'desc',
            'picMeta'       => 'meta',
            'picWeight'     => 'weight',
            'picRealId'     => 'realId',
            'picStatus'     => 'status',
            'picUpdate'     => 'update',
            'picUploadTime' => 'uploadTime',
            'picAuditor'    => 'auditor',
            'picAuditTime'  => 'auditTime',
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
     * @return ParkPicture_Model
     */

    public static function instance($cache = true) 
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
    
    /**
     * @abstract 获取小区图片By parkId
     * @author Eric xuminwan@sohu-inc.com
     * @param int $intParkId
     * @param int $picType 1:获取小区图片 2:获取优质小区活动提供的图片
     * @return array
     * 
     */
    public function getPicByParkId($intParkId, $picType = 1, $num=8)
    {
    	if(!($intParkId && $picType)) return false;
    	if($picType == 2)
    	{
    		$strCon = "status = 2 and parkId = ?1 and type in(".self::IMAGE_TYPE_ZHUTU.",".self::IMAGE_TYPE_WAIJING.",".self::IMAGE_TYPE_ZHOUBIAN.")";
    	}
    	elseif($picType == 1)
    	{
    		$strCon = "status = 2 and parkId = ?1 and type in(".self::IMAGE_TYPE_WAIGUAN.",".self::IMAGE_TYPE_HUXING.")";
    	}
    	$arrParam = array(1=>$intParkId);
        $arrCondition = array($strCon,'limit'=>$num, 'bind'=>$arrParam,'order'=>'type');
        if ($num == 0){
            unset($arrCondition['limit']);
        }

    	$arrPic = self::find($arrCondition,0);
		if ( empty($arrPic) ) return array();
    	return $arrPic->toArray();
    }

	/**
	 * 获取指定小区的图片信息，根据图片类型和居室类型进行分组
	 *不用了
	 * @param int $intParkId
	 * @return array
	 */
	public function getImageByParkId($intParkId) {
		$arrBackData = array();
		$arrParkImage = self::find(array("parkId = ".$intParkId." AND status=".ParkPicture::STATUS_PASS));
		if ( !empty($arrParkImage) ) {
			$arrParkImage = $arrParkImage->toArray();
			foreach ( $arrParkImage as $image ) {
				$arrBackData[$image['type']][] = array(
					'image_id' => $image['imgId'],
					'image_ext' => $image['imgExt'],
					'url' => ImageUtility::getImgUrl('esf', $image['imgId'], $image['imgExt'], 180, 120),
					'big_url' => ImageUtility::getImgUrl('esf', $image['imgId'], $image['imgExt'])
				);
			}
		}
		unset($arrParkImage);
		return $arrBackData;
	}


    /**
     * 获取小区ID下的图片总数
     * @auth jackchen
     *@param int $intParkId
     * @return int
     */
    public function getParkPicTotal($intParkId){
        if ( empty($intParkId) ) {
            return false;
        }
        $where =" status=".self::STATUS_PASS;
        $where .=" and parkId=".$intParkId;

        return $this->getCount($where);
    }
    
    /**
     * 获取小区下所有图片
     * @param int $parkId
     * @param int $cityId
     * @return array
     */
    public function getParkPictureById($parkId = 0, $cityId = 0, $bedRoom = '')
    {
        $arrBackData = array();
        if(!$parkId)
        {
            return array();
        }
        $where = "parkId={$parkId} and status=".self::STATUS_PASS;
        $cityId && $where .= " and cityId={$cityId}";
  
        $arrPhoto = self::find(array('conditions'=>$where, 'order'=>'weight asc'), 0)->toArray();
        
        foreach($arrPhoto as $photo) 
        {
            $meta = $photo['meta'] ? json_decode($photo['meta'], true) : array();
            $arrBackData[$photo['type']][] = array(
                "url"        => ImageUtility::getImgUrl(PRODUCT_NAME, $photo['imgId'], $photo['imgExt'], 180, 120),
                "midUrl"     => ImageUtility::getImgUrl(PRODUCT_NAME, $photo['imgId'], $photo['imgExt'], 600, 450),
                "bigUrl"     => ImageUtility::getImgUrl(PRODUCT_NAME, $photo['imgId'], $photo['imgExt'], 600, 450),
                "image"      => $photo['imgId'].".".$photo['imgExt'],
                "imgId"      => $photo['imgId'],
                "imgExt"     => $photo['imgExt'],
                "tag"        => $photo['desc'],
                "uploadTime" => $photo['uploadTime'],
                "weight"     => $photo['weight'],
                "bedRoom"   => intval($meta['bedRoom']),
                "livingRoom"=> intval($meta['livingRoom']),
                "bathRoom"  => intval($meta['bathRoom']),
                "areaMin"   => floatval($meta['areaMin']),
                "areaMax"   => floatval($meta['areaMax']),
                "exposure"  => intval($meta['exposure'])
            );
        }  
        
        return $arrBackData;
    }
    
    /**
     * 修改小区图片
     * @param array  $parkInfo      小区信息
     * @param array  $newPictures   新小区图片
     * @param array  $oriPictures   旧小区图片
     * @param string $newImage      新封面图
     * @param string $oriImage      旧封面图
     * @param int    $imageType     图片类型
     * @return boolean
     */
    public function saveParkPictures($parkInfo, $newPictures, $oriPictures, $newImage, $oriImage, $imageType = self::IMAGE_TYPE_WAIGUAN)
    {
        if(empty($newPictures) && empty($oriPictures))
        {
            return false;
        }
        $parkId = $parkInfo['id'];
        $newImage || $newImage = '.';
        $this->begin();
        if($newImage != $oriImage && self::IMAGE_TYPE_WAIGUAN == $imageType)
        {
            //修改封面图
            $park = Park::findFirst($parkId);
            if(!$park)
            {
                $this->rollback();
                return false;
            }
            $image = explode('.', $newImage);
            $park->picId = intval($image[0]);
            $park->picExt = $image[1];
            $park->update = date('Y-m-d H:i:s');
            //self::IMAGE_TYPE_WAIGUAN == $imageType && $park->allowWgPhoto = $parkInfo['allowWgPhoto'];
            //self::IMAGE_TYPE_HUXING == $imageType && $park->allowHxPhoto = $parkInfo['allowHxPhoto'];
            if(!$park->update())
            {
                $this->rollback();
                return false;
            }
        }
        
        $oldPicIds = $newPicIds = $delPicIds = array();
        foreach($oriPictures as $v)
        {
            $oldPicIds[] = $v['imgId'];
        }
        $weight = 0;
        foreach($newPictures as $v)
        {
            $weight++;
            list($picId, $picExt) = explode('.', $v['image']);
            $newPicIds[] = $picId;
            $meta = array();
            $v['bedRoom'] > 0 && $meta['bed_room'] = intval($v['bedRoom']);
            $v['livingRoom'] > 0 && $meta['living_room'] = intval($v['livingRoom']);
            $v['bathRoom'] > 0 && $meta['bath_room'] = intval($v['bathRoom']);
            $v['exposure'] > 0 && $meta['exposure'] = intval($v['exposure']);
            $v['areaMin']  && $meta['area_min'] = floatval($v['areaMin']);
            $v['areaMax']  && $meta['area_max'] = floatval($v['areaMax']);

            
            if(in_array($picId, $oldPicIds))
            {
                $rs = self::findFirst("parkId={$parkId} and imgId={$picId}");
                $rs->weight = $weight;
                $rs->desc = $v['tag'];
                $rs->update = date('Y-m-d H:i:s');
                empty($meta) || $rs->meta = json_encode($meta);
                if(!$rs->update())
                {
                    $this->rollback();
                    return false;
                }
            }
            else
            {
                $rs = self::findFirst("parkId={$parkId} and imgId={$picId}");
                if(!$rs)
                {
                    $rs = self::instance(false);
                    $newFlag = true;
                }
                $rs->parkId = $parkId;
                $rs->cityId = $parkInfo['cityId'];
                $rs->imgId = $picId;
                $rs->imgExt = $picExt;
                $rs->desc = $v['tag'];
                $rs->status = self::STATUS_PASS;
                $rs->weight = $weight;
                $rs->type = $imageType;
                empty($meta) || $rs->meta = json_encode($meta);
                $rs->uploadTime = time();
                if($newFlag)
                {
                    if(!$rs->create())
                    {
                        $this->rollback();
                        return false;
                    }
                }
                else
                {
                    if(!$rs->update())
                    {
                        $this->rollback();
                        return false;
                    }
                }             
            }
        }
        
        foreach($oldPicIds as $v)
        {
            if(!in_array($v, $newPicIds))
            {
                $delPicIds[] = $v;
            }
        }
        if(!empty($delPicIds))
        {
            $delPicId = implode(',', $delPicIds);
            $delPictures = self::find("parkId={$parkId} and imgId in ($delPicId)");
            foreach($delPictures as $ds)
            {
                $ds->status = self::STATUS_DELETE;
                $ds->update = date('Y-m-d H:i:s');
                if(!$ds->update())
                {
                    $this->rollback();
                    return false;
                }
            }
        }
        
        $this->commit();
        return true;
    }
    
    static public function getParkPictureBedroom()
    {
		$arrBedroom = $GLOBALS['UNIT_BEDROOM'];
		$arrBedroom = $arrBedroom + array('101'=>'别墅');
        
		return $arrBedroom;
	}
    
    /**
     * 获取小区图片个数
     * @param int $cityId
     * @param int $fromTime
     * @param int $toTime
     * @param int $type
     * @param int $status
     * @return int
     */
    public function getPictureNum($cityId, $fromTime = 0, $toTime = 0, $type = self::IMAGE_TYPE_WAIGUAN, $status = self::STATUS_PASS)
    {
        $where = "cityId={$cityId} and type={$type} and status={$status}";
        $fromTime > 0 && $where .= " and auditTime>={$fromTime}";
        $toTime > 0 && $where .= " and auditTime<={$toTime}";
        
        $pictureNum = self::count($where);
        
        return intval($pictureNum);
    }

    public function getPicCountByIds($parkIds)
    {
        if (!$parkIds) return false;
        if (is_numeric($parkIds)){
            $parkIds = array($parkIds);
        }
        $mParkPicture = new ParkPicture();
        $arrCondition['conditions'] = "status=:status: and parkId in (".join(',', $parkIds).")";
        $arrCondition['bind'] = array(
            "status"    =>  ParkPicture::STATUS_PASS,
        );
        $mParkPicture::find();
        if(!($intParkId && $picType)) return false;
        if($picType == 2)
        {
            $strCon = "status = 2 and parkId = ?1 and type in(".self::IMAGE_TYPE_ZHUTU.",".self::IMAGE_TYPE_WAIJING.",".self::IMAGE_TYPE_ZHOUBIAN.")";
        }
        elseif($picType == 1)
        {
            $strCon = "status = 2 and parkId = ?1 and type in(".self::IMAGE_TYPE_WAIGUAN.",".self::IMAGE_TYPE_HUXING.")";
        }
        $arrParam = array(1=>$intParkId);
        $arrCondition = array($strCon,'limit'=>$num, 'bind'=>$arrParam,'order'=>'type');
        if ($num == 0){
            unset($arrCondition['limit']);
        }

        $arrPic = self::find($arrCondition,0);
        if ( empty($arrPic) ) return array();
        return $arrPic->toArray();
    }

}