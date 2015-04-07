<?php
class Image extends BaseModel
{
	//图片分类
	const TYPE_DEFAULT = 1; //默认分类
	//图片来源
	const FROM_REALTOR = 1; //经纪人发布
        const FROM_CMS = 2;     //cms文章上传
        const FROM_ADMIN = 3; //admin用户
	//图片状态
	const STATUS_OK = 1; //有效
	const STATUS_DEL = -1; //删除
	const STATUS_NOPASS = 0; //审核失败

    public $imgId;
    public $imgType;
    public $imgExt;
    public $imgWidth;
    public $imgHeight;
    public $imgSize;
    public $imgMd5Data;
    public $imgMd5Url;
    public $imgFrom;
    public $imgFromId=0;
    public $imgStatus;
    public $imgUpdate;

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

    public function getImgType()
    {
        return $this->imgType;
    }

    public function setImgType($imgType)
    {
        if(preg_match('/^\d{1,3}$/', $imgType == 0) || $imgType > 255)
        {
            return false;
        }
        $this->imgType = $imgType;
    }

    public function getImgExt()
    {
        return $this->imgExt;
    }

    public function setImgExt($imgExt)
    {
        $this->imgExt = $imgExt;
    }

    public function getImgWidth()
    {
        return $this->imgWidth;
    }

    public function setImgWidth($imgWidth)
    {
        if(preg_match('/^\d{1,5}$/', $imgWidth == 0) || $imgWidth > 65535)
        {
            return false;
        }
        $this->imgWidth = $imgWidth;
    }

    public function getImgHeight()
    {
        return $this->imgHeight;
    }

    public function setImgHeight($imgHeight)
    {
        if(preg_match('/^\d{1,5}$/', $imgHeight == 0) || $imgHeight > 65535)
        {
            return false;
        }
        $this->imgHeight = $imgHeight;
    }

    public function getImgSize()
    {
        return $this->imgSize;
    }

    public function setImgSize($imgSize)
    {
        if(preg_match('/^\d{1,10}$/', $imgSize == 0) || $imgSize > 4294967295)
        {
            return false;
        }
        $this->imgSize = $imgSize;
    }

    public function getImgMd5Data()
    {
        return $this->imgMd5Data;
    }

    public function setImgMd5Data($imgMd5Data)
    {
        $this->imgMd5Data = $imgMd5Data;
    }

    public function getImgMd5Url()
    {
        return $this->imgMd5Url;
    }

    public function setImgMd5Url($imgMd5Url)
    {
        $this->imgMd5Url = $imgMd5Url;
    }

    public function getImgFrom()
    {
        return $this->imgFrom;
    }

    public function setImgFrom($imgFrom)
    {
        if(preg_match('/^\d{1,3}$/', $imgFrom == 0) || $imgFrom > 255)
        {
            return false;
        }
        $this->imgFrom = $imgFrom;
    }

    public function getImgFromId()
    {
        return $this->imgFromId;
    }

    public function setImgFromId($imgFromId)
    {
//        if(preg_match('/^\d{1,10}$/', $imgFromId == 0) || $imgFromId > 4294967295)
//        {
//            return false;
//        }
        $this->imgFromId = $imgFromId;
    }

    public function getImgStatus()
    {
        return $this->imgStatus;
    }

    public function setImgStatus($imgStatus)
    {
        if(preg_match('/^-?\d{1,3}$/', $imgStatus) == 0 || $imgStatus > 127 || $imgStatus < -128)
        {
            return false;
        }
        $this->imgStatus = $imgStatus;
    }

    public function getImgUpdate()
    {
        return $this->imgUpdate;
    }

    public function setImgUpdate($imgUpdate)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $imgUpdate) == 0 || strtotime($imgUpdate) == false)
        {
            return false;
        }
        $this->imgUpdate = $imgUpdate;
    }

    public function getSource()
    {
        return 'image';
    }

    public function columnMap()
    {
		//亲，请不要修改这里的映射^_^^_^
        return array(
            'imgId' => 'imgId',
            'imgType' => 'imgType',
            'imgExt' => 'imgExt',
            'imgWidth' => 'imgWidth',
            'imgHeight' => 'imgHeight',
            'imgSize' => 'imgSize',
            'imgMd5Data' => 'imgMd5Data',
            'imgMd5Url' => 'imgMd5Url',
            'imgFrom' => 'imgFrom',
            'imgFromId' => 'imgFromId',
            'imgStatus' => 'imgStatus',
            'imgUpdate' => 'imgUpdate'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('imgSlave');
        $this->setWriteConnectionService('imgMaster');
    }
	
	/**
	 * 获取指定MD5值的图片信息
	 *
	 * @return object
	 */
	public function getImageByMd5($imgMd5Data = '', $imgMd5Url = '') {
		if ( empty($imgMd5Data) && empty($imgMd5Url) ) {
			return false;
		}
		if ($imgMd5Data) {
			$strCond  = "imgMd5Data = ?1";
			$arrParam = array(1 => $imgMd5Data);
		} else {
			$strCond  = "imgMd5Url = ?1";
			$arrParam = array(1 => $imgMd5Url);
		}
		$objRes = self::findFirst(array(
			$strCond,
			"bind" => $arrParam
		));
		return empty($objRes) ? array() : $objRes->toArray();
	}




}