<?php
/**
 * @�����߼�������
 * @author qiyaguo <qiyaguo@sohu-inc.com>
 * @date 2014/10/19
 *
 */
class NetsMonitor {
	private $mError;
	private $mCrmUserAccName = 'netmonitor';
	private $mCrmUserName = '����';
	private $mCrmUserPermission = 1;
	private $mCityId = 0;

	/**
	 * ��ȡ��������
	 *
	 * @return string
	 */
	public function getError() {
		return $this->mError;
	}

	/**
	 * ��ȡ���������˷�Դ
	 *
	 * @param int $int_unit_id
	 * @param string $unit_type
	 * @return bool|array
	 */
	public function getIndixRealtorUnit($int_unit_id) {
		$clsUnit = new House();
		return $clsUnit->getOne('id='.$int_unit_id.' and roleType='.House::ROLE_REALTOR);
	}

	/**
	 * ����ɾ����Դ
	 *
	 * @param array $arrData
	 * @return bool
	 */
	public function delIndixRealtorUnit($arrData) {
		if ( empty($arrData) ) {
			$this->mError = '���ݲ���';
			return false;
		}

		$arrUpdate['status'] = House::STATUS_DELETE;
		$arrUpdate['tags'] = 0;
		$arrUpdate['fine'] = 0;
		$arrUpdate['fineTime'] = '0000-00-00 00:00:00';
		$arrUpdate['delTime'] = date('Y-m-d H:i:s', time());

		//������־
        $LogInfo = "��{$arrData['passport']}��ɾ����{$arrData['unit_type']}_id:{$arrData['id']}";
        $arrLog=array(
	        'crm_user_accname'    =>  $this->mCrmUserAccName,
	        'crm_user_permission' =>  $this->mCrmUserPermission,
	        'city_id'             =>  $this->mCityId,
	        'message'             =>  $LogInfo,
	        'time'                =>  time(),
	        'ip'                  =>  Utility::GetUserIP()
        );
		
		 //����ʼ
         $clsUnit = new House();
		 $clsUnit->begin();
         $arrUpdate['status'] = House::STATUS_DELETE;
		 $intFlag = $clsUnit->modifyHouseById($arrData['id'], $arrUpdate);
		 if ( $intFlag === false ) {
			 $clsUnit->rollback();
			 $this->mError = '��Դɾ��ʧ��';
			 return false;
		 }
		 //����ES����
		 global $sysES;
		 $clsEs = new Es($sysES['default']);
		 $intFlag = $clsEs->update(array('id' => $arrData['id'], 'data' => $clsEs->houseFormat($arrUpdate)));
		 if ( $intFlag == false ) {
			 $clsUnit->rollback();
			 $this->mError = '��Դɾ��ʧ��';
			 return false;
		 }
		 //ɾ��ͼƬ
         $arrParkImages = $this->getUnitParkImageIds($arrData['parkId']);//����С��ͼƬ
         $intFlag = $this->delRealtorUnitImage($arrData['id'], $arrParkImages);
		 if ( $intFlag == false ) {
			 $clsUnit->rollback();
			 $this->mError = '��Դɾ��ʧ��';
			 return false;
		 }
		 $clsUnit->commit();
		 ////TLogAction::Singleton()->LogInsert(new TLogAdmin(AbsLog::LogCrmPersonUnit),$arrLog);
		 $this->mError = '��Դɾ���ɹ�';
		 return true;
	}

    /**
	 * ��ȡ��С�����ͼid��
	 * @param int $intParkId С��id
	 * @return array
	 */
    public function getUnitParkImageIds($intParkId) {
        $clsParkPhoto = new ParkPicture();
        $arrParkPhoto = $clsParkPhoto->getImageByParkId($intParkId);
        $arrParkImageIds = array();
        foreach($arrParkPhoto[ParkPicture::IMAGE_TYPE_WAIGUAN] as $value){
            $arrParkImageIds[] = $value['image_id'];
        }
        return $arrParkImageIds;
    }

	/**
	 * �ָ���Դ���ָ���Դ����Ϊ�¼�״̬��
	 *
	 * @param array $arrData
	 * @return bool
	 */
	public function recoverIndixRealtorUnit($arrData) {
		if ( empty($arrData) ) {
			$this->mError = '���ݲ���';
			return false;
		}

		$arrUpdate['status'] = House::STATUS_OFFLINE;
		$arrUpdate['delTime'] = '0000-00-00 00:00:00';

		//������־
        $LogInfo = "��{$arrData['passport']}���ָ���{$arrData['unit_type']}_id:{$arrData['id']}";
        $arrLog=array(
	        'crm_user_accname'    =>  $this->mCrmUserAccName,
	        'crm_user_permission' =>  $this->mCrmUserPermission,
	        'city_id'             =>  $this->mCityId,
	        'message'             =>  $LogInfo,
	        'time'                =>  time(),
	        'ip'                  =>  Utility::GetUserIP()
        );
		
		 //����ʼ
         $clsUnit = new House();
		 $clsUnit->begin();
         $arrUpdate['status'] = House::STATUS_DELETE;
		 $intFlag = $clsUnit->modifyHouseById($arrData['id'], $arrUpdate);
		 if ( $intFlag === false ) {
			 $clsUnit->rollback();
			 $this->mError = '��Դ�ָ�ʧ��';
			 return false;
		 }
		 //����ES����
		 global $sysES;
		 $clsEs = new Es($sysES['default']);
		 $intFlag = $clsEs->update(array('id' => $arrData['id'], 'data' => $clsEs->houseFormat($arrUpdate)));
		 if ( $intFlag == false ) {
			 $clsUnit->rollback();
			 $this->mError = '��Դ�ָ�ʧ��';
			 return false;
		 }
		 //�ָ�ͼƬ
         $arrParkImages = $this->getUnitParkImageIds($arrData['parkId']);//����С��ͼƬ
         $intFlag = $this->recoverRealtorUnitImage($arrData['id'], $arrParkImages);
		 if ( $intFlag == false ) {
			 $clsUnit->rollback();
			 $this->mError = '��Դ�ָ�ʧ��';
			 return false;
		 }
		 $clsUnit->commit();
		 ////TLogAction::Singleton()->LogInsert(new TLogAdmin(AbsLog::LogCrmPersonUnit),$arrLog);
		 $this->mError = '��Դ�ָ��ɹ�';
		 return true;
	}

	/**
	 * ��ȡ���˷�ԴID
	 *
	 * @param int $int_unit_id
	 */
	public function getPersonUnit($int_unit_id) {
		$clsPersonUnit = new House();
		return $clsPersonUnit->getOne('id='.$int_unit_id.' and roleType='.House::ROLE_SELF);
	}

	/**
	 * ɾ�����˷�Դ
	 *
	 * @param array $arrData
	 * @return bool
	 */
	public function delPersonUnit($arrData) {
		if ( empty($arrData) ) {
			$this->mError = '���ݲ���';
			return false;
		}
		//������־
		$arrLog=array(
	        'crm_user_accname'    =>  $this->mCrmUserAccName,
	        'crm_user_permission' =>  $this->mCrmUserPermission,
	        'city_id'             =>  $this->mCityId,
	        'unit_id'             =>  $arrData['id'],
	        'action'              =>  3,//��������
	        'time'                =>  time(),
	        'ip'                  =>  Utility::GetUserIP()
         );
		 
		 //����ʼ
         $clsPersonUnit = new House();
		 $clsPersonUnit->begin();
         $arrUpdate['status'] = House::STATUS_DELETE;
		 $intFlag = $clsPersonUnit->modifyHouseById($arrData['id'], $arrUpdate);
		 if ( $intFlag === false ) {
			 $clsPersonUnit->rollback();
			 $this->mError = '��Դɾ��ʧ��';
			 return false;
		 }
		 //����ES����
		 global $sysES;
		 $clsEs = new Es($sysES['default']);
		 $intFlag = $clsEs->update(array('id' => $arrData['id'], 'data' => $clsEs->houseFormat($arrUpdate)));
		 if ( $intFlag == false ) {
			 $clsPersonUnit->rollback();
			 $this->mError = '��Դɾ��ʧ��';
			 return false;
		 }
		 //ɾ��ͼƬ
         $intFlag = $this->delPersonUnitImage($arrData['id']);
		 if ( $intFlag == false ) {
			 $clsPersonUnit->rollback();
			 $this->mError = '��Դɾ��ʧ��';
			 return false;
		 }
		 $clsPersonUnit->commit();
		 ////TLogAction::Singleton()->LogInsert(new TLogAdmin(AbsLog::LogCrmPersonUnit),$arrLog);
		 $this->mError = '��Դɾ���ɹ�';
		 return true;
	}

	/**
	 * �ָ����˷�Դ�����漰���޵����⣬������ִ�з�Դ�ظ���
	 *
	 * @param array $arrData
	 * @return bool
	 */
	public function recoverPersonUnit($arrData) {
		if ( empty($arrData) ) {
			$this->mError = '���ݲ���';
			return false;
		}
		/**�ж����ϸ��˷�Դ�Ƿ���,�糬��,�ָ�ʧ��. */
		$clsPersonal = new House();
		$arrUnitInfo = $clsPersonal->getOne('id='.$arrData['id']);
		$condition['hoId'] = $arrUnitInfo['hoId'];
		if(false == $this->getPersonUnitCountByCondition($condition) ){
			$this->mError = '��Ч��Դ�ѳ���';
			return false;
		}

		//������־
		$LogInfo = "��{$arrData['passport']}���ָ���{$arrData['unit_type']}_id:{$arrData['id']}";
		$arrLog=array(
	        'crm_user_accname'    =>  $this->mCrmUserAccName,
	        'crm_user_permission' =>  $this->mCrmUserPermission,
	        'city_id'             =>  $this->mCityId,
	        'unit_id'             =>  $arrData['id'],
	        'action'              =>  3,//��������
			'message'			  =>  $LogInfo,
	        'time'                =>  time(),
	        'ip'                  =>  Utility::GetUserIP()
         );
		 
		 //����ʼ
         $clsPersonUnit = new House();
		 $clsPersonUnit->begin();
         $arrUpdate['status'] = House::STATUS_ONLINE;
		 $intFlag = $clsPersonUnit->modifyHouseById($arrData['id'], $arrUpdate);
		 if ( $intFlag === false ) {
			 $clsPersonUnit->rollback();
			 $this->mError = '��Դ�ָ�ʧ��';
			 return false;
		 }
		 //����ES����
		 global $sysES;
		 $clsEs = new Es($sysES['default']);
		 $intFlag = $clsEs->update(array('id' => $arrData['id'], 'data' => $clsEs->houseFormat($arrUpdate)));
		 if ( $intFlag == false ) {
			 $clsPersonUnit->rollback();
			 $this->mError = '��Դ�ָ�ʧ��';
			 return false;
		 }
		 //ɾ��ͼƬ
         $intFlag = $this->recoverPersonUnitImage($arrData['id']);
		 if ( $intFlag == false ) {
			 $clsPersonUnit->rollback();
			 $this->mError = '��Դ�ָ�ʧ��';
			 return false;
		 }
		 $clsPersonUnit->commit();
		 ////TLogAction::Singleton()->LogInsert(new TLogAdmin(AbsLog::LogCrmPersonUnit),$arrLog);
		 $this->mError = '��Դ�ָ��ɹ�';
		 return true;
	}

	/**
	 * ��ȡָ�����˵�ǰ��Ч�ķ�Դ����
	 *
	 * @param int $condition
	 * @return bool
	 */
	public function getPersonUnitCountByCondition($condition) {
		$clsPersonUnit = new House();
		$intUnitCount = $clsPersonUnit->getCount(array('hoId='.$condition['hoId'].' and status='.House::STATUS_ONLINE));
		if ( $intUnitCount >= 2 ) {
			return false;
		}
		return true;
	}

	/**
	 * ����ɾ��itcͼƬ������ͼƬ
	 *
	 * @param int $int_unit_id ��ԴID
	 * @param array $arrParkImages �÷�Դ����ӦС�������ͼ
	 */
	public function delRealtorUnitImage($int_unit_id, $arrParkImages=array()) {
		$class_unit_image = new HousePicture();
		$string_unit_type = strtolower($string_unit_type);
		$array_unit_image = $class_unit_image->getAll(array('houseId='.$int_unit_id));
		if ( ! empty($array_unit_image) ) {
			foreach ( $array_unit_image as $k => $v ) {
                if( in_array($v['imgId'], $arrParkImages) ) continue;  //��ֹɾ��С�����ͼ
				$array_image[] =  $v['imgId'].".".$v['imgExt'];
			}
		}
		if ( ! empty($array_image) ) {
			$this->deleteImage($array_image);
		}
	}
	
	/**
	 * ����ָ�itcͼƬ������ͼƬ
	 *
	 * @param int $int_unit_id ��ԴID
	 * @param array $arrParkImages �÷�Դ����ӦС�������ͼ
	 */
	public function recoverRealtorUnitImage($int_unit_id, $arrParkImages=array()) {
		$class_unit_image = new HousePicture();
		$string_unit_type = strtolower($string_unit_type);
		$array_unit_image = $class_unit_image->getAll(array('houseId='.$int_unit_id));
		if ( ! empty($array_unit_image) ) {
			foreach ( $array_unit_image as $k => $v ) {
				if( in_array($v['imgId'], $arrParkImages) ) continue;  //��ֹɾ��С�����ͼ
				$array_image[] =  $v['imgId'].".".$v['imgExt'];
			}
		}
		if ( ! empty($array_image) ) {
			$this->recoverImage($array_image);
		}
	}

	/**
	 * ����ɾ��itcͼƬ������ͼƬ
	 *
	 * @param int $int_unit_id ��ԴID
	 */
	public function delPersonUnitImage($int_unit_id) {
		$class_unit_image = new HousePicture();
		$array_unit_image = $class_unit_image->getAll(array('houseId='.$int_unit_id));
		if ( ! empty($array_unit_image) ) {
			foreach ( $array_unit_image as $k => $v ) {
				$array_image[] =  $v['imgId'].".".$v['imgExt'];
			}
		}
		if ( ! empty($array_image) ) {
			$this->deleteImage($array_image);
		}
	}
	
	/**
	 * ����ָ�itcͼƬ������ͼƬ
	 *
	 * @param int $int_unit_id ��ԴID
	 */
	public function recoverPersonUnitImage($int_unit_id) {
		$class_unit_image = new HousePicture();
		$array_unit_image = $class_unit_image->getAll(array('houseId='.$int_unit_id));
		if ( ! empty($array_unit_image) ) {
			foreach ( $array_unit_image as $k => $v ) {
				$array_image[] =  $v['imgId'].".".$v['imgExt'];
			}
		}
		if ( ! empty($array_image) ) {
			$this->recoverImage($array_image);
		}
	}

	/**
	 * ɾ����ԴͼƬ��������ͷ����ƬͼƬ
	 * @param array $arrImage ��ԴͼƬ
	 * @param string $LogInfo ��־��¼��Ϣ
	 */
	function delPhoto($strImage, $LogInfo){
	    if( empty($strImage) ){
	    	$this->mError = '�봫��ͼƬ��';
	    	return false;
	    }

        $preg = '/[^0-9a-z](\d{1,11}.[a-z]{3,4})/';
        $result = preg_match_all($preg, $strImage, $matches);
        if( !$result ){
	    	$this->mError = 'ͼƬ��ʽ����';
            return false;
        }
		$array_image = $matches[1];
		if(!empty($array_image)){
	        $this->deleteImage($array_image);
		}
		$arrLog=array(
	        'crm_user_accname'    =>  $this->mCrmUserAccName,
	        'crm_user_permission' =>  $this->mCrmUserPermission,
	        'city_id'             =>  $this->mCityId,
	        'unit_id'             =>  '0',
	        'action'              =>  3,//��������
			'message'			  =>  $LogInfo,
	        'time'                =>  mktime(),
	        'ip'                  =>  Utility::GetUserIP()
        );
        ////TLogAction::Singleton()->LogInsert(new TLogAdmin(AbsLog::LogCrmAdmin),$arrLog);
        return true;
    }


	/**
	 * �ָ���ԴͼƬ��������ͷ����ƬͼƬ
	 * @param array $arrImage ��ԴͼƬ
	 * @param string $LogInfo ��־��¼��Ϣ
	 */
	function recoverPhoto($strImage, $LogInfo){
	    if( empty($strImage) ){
	    	$this->mError = '�봫��ͼƬ��';
	    	return false;
	    }
        $preg = '/[^0-9a-z](\d{1,11}.[a-z]{3,4})/';
        $result = preg_match_all($preg, $strImage, $matches);
        if( !$result ){
	    	$this->mError = 'ͼƬ��ʽ����';
            return false;
        }

        $array_image = $matches[1];
		if(!empty($array_image)){
	        $this->recoverImage($array_image);//�ֱ�ɾ��
		}

		$arrLog=array(
	        'crm_user_accname'    =>  $this->mCrmUserAccName,
	        'crm_user_permission' =>  $this->mCrmUserPermission,
	        'city_id'             =>  $this->mCityId,
	        'unit_id'             =>  '0',
	        'action'              =>  3,//��������
			'message'			  =>  $LogInfo,
	        'time'                =>  mktime(),
	        'ip'                  =>  Utility::GetUserIP()
        );
        ////TLogAction::Singleton()->LogInsert(new TLogAdmin(AbsLog::LogCrmAdmin),$arrLog);
        return true;
    }
	
	/**
	 * ����ɾ���Ѻ�����ͼƬ
	 * @param array $arrImage
	 */
	public function deleteImage($arrImage){
		foreach($arrImage as $kt=> $vt){
			$image_info = explode('.', $vt);
			$image_id = isset($image_info[0]) ? intval($image_info[0]) : 0;
			if ($image_id) $this->moveImageData($image_id, true);
		}
	}

	/**
	 * �Ѻ���ͼƬ�ָ�
	 * @param array $arrImage
	 */
	public function recoverImage($arrImage){
		foreach($arrImage as $kt=> $vt){
			$image_info = explode('.', $vt);
			$image_id = isset($image_info[0]) ? intval($image_info[0]) : 0;
			if ($image_id) $this->moveImageData($image_id, false);
		}
	}
	
	/**
	 * �����ƶ�ͼƬ����
	 * @param intval $image_id
	 * @param bool $is_del
	 */
	public function moveImageData($image_id, $is_del = true){
		$clsUnitImage = new HousePicture();
		$clsUnit = new House();

		if ($is_del) {
			$arrUnitImages = $clsUnitImage->getAll(array('imgId='.$image_id.' AND status='.HousePicture::STATUS_OK));
		} else {
			$arrUnitImages = $clsUnitImage->getAll(array('imgId='.$image_id.' AND status='.HousePicture::STATUS_DEL));
		}
		if (!empty($arrUnitImages)) {
			foreach ($arrUnitImages as $arrUnitImage) {
				$clsUnitImage->begin();
				if ($is_del) {
					$clsUnitImage->updateAll(array('id='.$arrUnitImage['id']), array('status' => HousePicture::STATUS_DEL));
				} else {
					$clsUnitImage->updateAll(array('id='.$arrUnitImage['id']), array('status' => HousePicture::STATUS_OK));
				}
				$intUnitImageAffect = $clsUnitImage->affectedRows();
				if ( $intUnitImageAffect === false ) {
					$this->mError = '����ͼƬ����ʧ��';
					$clsUnitImage->rollback();
					return false;
				}
				if ($is_del) {
					$intFlag = Scs::Instance()->deleteImage($arrUnitImage['imgId'], $arrUnitImage['imgExt']);
				} else {
					$intFlag = Scs::Instance()->recoverImage($arrUnitImage['imgId'], $arrUnitImage['imgExt']);
				}
				if ( $intFlag === false ) {
					$this->mError = '����ͼƬ�ļ�ʧ��';
					$clsUnitImage->rollback();
					return false;
				}
				$clsUnitImage->commit();
				$arrUpdate = array();
				$arrUnit = $clsUnit->getOne('id='.$arrUnitImage['houseId']);
				$strCond = 'houseId='.$arrUnitImage['houseId'].' AND type='.HousePicture::IMG_SHINEI;
				if ($is_del) $strCond .= 'imgId !='.$image_id;//ɾ���Ļ��ų�ԭͼ
				$arrNewImage = $clsUnitImage->getAll($strCond);
				if (empty($arrNewImage)) {
					$arrUpdate = array('status' => House::STATUS_OFFLINE, 'tags' => House::HOUSE_NOTAG, 'fine' => House::FINE_NO, 'xiajia' => date('Y-m-d H:i:s', time()), 'houseUpdate' => date('Y-m-d H:i:s', time()), 'picId' => 0, 'picExt' => 0);//�¼ܴ˷�Դ
				} elseif ($arrUnit['picId'] == $image_id || empty($arrUnit['picId'])) {//ɾ����ָ��˷���ͼ
					$arrUpdate = array('picId' => $arrNewImage[0]['imgId'], 'picExt' => $arrNewImage[0]['imgExt']);//����Ĭ��ͼ
				}
				$clsUnit->begin();
				/*if (empty($arrNewImage)) {
					//��Դ�¼�ȡ����ʱ
					$clsRefreshQueue = new TRefreshQueueMod();
					$intRefreshDel = $clsRefreshQueue->delFromRefreshListByIds($arrUnitImage['unit_id'], $arrUnitImage['unit_type']);
					if ($intRefreshDel == false) {
						$this->mError = 'ȡ����ʱʧ��';
						$clsUnit->rollback();
						return false;
					}
				}*/
				$intUnitAffect = $clsUnit->modifyHouseById($arrUnitImage['houseId'], $arrUpdates);
				if ( $intUnitAffect === false ) {
					$this->mError = '���·�Դ������Ϣʧ��';
					$clsUnit->rollback();
					return false;
				}
				//����ES����
				global $sysES;
				$clsEs = new Es($sysES['default']);
				$intFlag = $clsEs->update(array('id' => $arrUnitImage['houseId'], 'data' => $clsEs->houseFormat($arrUpdate)));
				if ( $intFlag == false ) {
					$this->mError = '���·�Դ����ʧ��';
					$clsUnit->rollback();
					return false;
				}
				$clsUnit->commit();
			}
			return true;
		}
		return false;
	}
	
}