<?php
class Company extends BaseModel
{
    protected $id;
    protected $cityId;
    protected $name;
    protected $abbr;
    protected $pinyin;
    protected $pinyinAbbr;
    protected $address = '';
    protected $postcode = '';
    protected $tel = '';
    protected $fax = '';
    protected $x = '';
    protected $y = '';
    protected $lonLat = '';
    protected $logoId = 0;
    protected $logoExt = '';
    protected $salesId = 0;
    protected $isCheck = self::ALLOW_NONE;
    protected $isOpenShop = 1;
    protected $cSId = 0;
    protected $status = self::STATUS_ENABLED;
    protected $update;
    protected $isCrmVerify = 0;
    protected $isShowTag = 0;
    protected $customTag = '';
    protected $isAdmin = 0;

    const STATUS_ENABLED  = 1;   //启用
    const STATUS_DISABLED = 0;   //未启
    const STATUS_WASTED   = -1;  //废弃
        
    //公司是否开通协议签署网店
    const OPEN_SHOP_ON=1;
    const OPEN_SHOP_OFF=2;
    
    //是否允许查看费用
    const ALLOW_NONE    = 0;   //都不允许查看
    const ALLOW_ALL     = 1;   //都允许查看
    const ALLOW_COMPANY = 2;   //只允许公司查看
     
    public function getComId()
    {
        return $this->comId;
    }

    public function setComId($comId)
    {
        if(preg_match('/^\d{1,10}$/', $comId == 0) || $comId > 4294967295)
        {
            return false;
        }
        $this->comId = $comId;
    }

    public function getCityId()
    {
        return $this->cityId;
    }

    public function setCityId($cityId)
    {
        if(preg_match('/^\d{1,10}$/', $cityId == 0) || $cityId > 4294967295)
        {
            return false;
        }
        $this->cityId = $cityId;
    }

    public function getComName()
    {
        return $this->comName;
    }

    public function setComName($comName)
    {
        if($comName == '' || mb_strlen($comName, 'utf8') > 50)
        {
            return false;
        }
        $this->comName = $comName;
    }

    public function getComAbbr()
    {
        return $this->comAbbr;
    }

    public function setComAbbr($comAbbr)
    {
        if($comAbbr == '' || mb_strlen($comAbbr, 'utf8') > 30)
        {
            return false;
        }
        $this->comAbbr = $comAbbr;
    }

    public function getComPinyin()
    {
        return $this->comPinyin;
    }

    public function setComPinyin($comPinyin)
    {
        if($comPinyin == '' || mb_strlen($comPinyin, 'utf8') > 50)
        {
            return false;
        }
        $this->comPinyin = $comPinyin;
    }

    public function getComPinyinAbbr()
    {
        return $this->comPinyinAbbr;
    }

    public function setComPinyinAbbr($comPinyinAbbr)
    {
        if($comPinyinAbbr == '' || mb_strlen($comPinyinAbbr, 'utf8') > 50)
        {
            return false;
        }
        $this->comPinyinAbbr = $comPinyinAbbr;
    }

    public function getComAddress()
    {
        return $this->comAddress;
    }

    public function setComAddress($comAddress)
    {
        if($comAddress == '' || mb_strlen($comAddress, 'utf8') > 50)
        {
            return false;
        }
        $this->comAddress = $comAddress;
    }

    public function getComPostcode()
    {
        return $this->comPostcode;
    }

    public function setComPostcode($comPostcode)
    {
        if($comPostcode == '' || mb_strlen($comPostcode, 'utf8') > 6)
        {
            return false;
        }
        $this->comPostcode = $comPostcode;
    }

    public function getComTel()
    {
        return $this->comTel;
    }

    public function setComTel($comTel)
    {
        if($comTel == '' || mb_strlen($comTel, 'utf8') > 30)
        {
            return false;
        }
        $this->comTel = $comTel;
    }

    public function getComFax()
    {
        return $this->comFax;
    }

    public function setComFax($comFax)
    {
        if($comFax == '' || mb_strlen($comFax, 'utf8') > 30)
        {
            return false;
        }
        $this->comFax = $comFax;
    }

    public function getComXY()
    {
        return $this->comXY;
    }

    public function setComXY($comXY)
    {
        if($comXY == '' || mb_strlen($comXY, 'utf8') > 50)
        {
            return false;
        }
        $this->comXY = $comXY;
    }

    public function getComLonLat()
    {
        return $this->comLonLat;
    }

    public function setComLonLat($comLonLat)
    {
        if($comLonLat == '' || mb_strlen($comLonLat, 'utf8') > 30)
        {
            return false;
        }
        $this->comLonLat = $comLonLat;
    }

    public function getComLogo()
    {
        return $this->comLogo;
    }

    public function setComLogo($comLogo)
    {
        if($comLogo == '' || mb_strlen($comLogo, 'utf8') > 50)
        {
            return false;
        }
        $this->comLogo = $comLogo;
    }

    public function getComSalesId()
    {
        return $this->comSalesId;
    }

    public function setComSalesId($comSalesId)
    {
        if(preg_match('/^\d{1,10}$/', $comSalesId == 0) || $comSalesId > 4294967295)
        {
            return false;
        }
        $this->comSalesId = $comSalesId;
    }

    public function getComCSId()
    {
        return $this->comCSId;
    }

    public function setComCSId($comCSId)
    {
        if(preg_match('/^\d{1,10}$/', $comCSId == 0) || $comCSId > 4294967295)
        {
            return false;
        }
        $this->comCSId = $comCSId;
    }

    public function getComStatus()
    {
        return $this->comStatus;
    }

    public function setComStatus($comStatus)
    {
        if(preg_match('/^-?\d{1,3}$/', $comStatus) == 0 || $comStatus > 127 || $comStatus < -128)
        {
            return false;
        }
        $this->comStatus = $comStatus;
    }

    public function getComUpdate()
    {
        return $this->comUpdate;
    }

    public function setComUpdate($comUpdate)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $comUpdate) == 0 || strtotime($comUpdate) == false)
        {
            return false;
        }
        $this->comUpdate = $comUpdate;
    }

    public function getSource()
    {
        return 'company';
    }

    /**
     * 新增公司字典
     * @param array $data
     * @return array
     */
    public function add($data)
    {
        if(empty($data))
        {
            return array('status'=>1, 'info'=>'参数为空！');
        }
        if($this->isExistCompanyName($data["comName"], $data["cityId"]))
        {
            return array('status'=>1, 'info'=>'公司全称已经存在！');
        }
        if ($this->isExistCompanyNameAbbr($data["comAbbr"], $data["cityId"]))
        {
            return array('status'=>1, 'info'=>'公司简称已经存在！');
        }
        $clsPinYin = new HanZiToPinYin();
        $pinyinShort = $clsPinYin->getPinYin(trim($data["comAbbr"]));

        $rs = self::instance();
        $rs->cityId = $data["cityId"];
        $rs->name = $data["comName"];
        $rs->abbr = $data["comAbbr"];
        $rs->pinyin = $pinyinShort['full'];
        $rs->pinyinAbbr = $pinyinShort['short'];
        $rs->update = date("Y-m-d H:i:s");
        $rs->isAdmin = intval($data['manageRealtor']);
        $rs->isCheck = intval($data['chkcost']);
        $rs->isShowTag = intval($data['customTitleCheck']);
        $rs->customTag = $data['customTitle'] ? $data['customTitle'] : '';
        
        $this->begin();
        if($rs->create())
        {
            //添加公司账号
            $accountExist = VipAccount::instance()->checkIsExistAccount(0, $data['comAccount']);
            if($accountExist)
            {
                $this->rollback();
                return array('status'=>1, 'info'=>'账号已存在！');
            }
            $comAccount = VipAccount::findFirst("toId={$rs->id} and to=".VipAccount::ROLE_COMPANY);
            if(!$comAccount)
            {
                $comAccount = VipAccount::instance();
                $newFlag = true;
            }
            
            $comAccount->to = VipAccount::ROLE_COMPANY;
            $comAccount->name = $data['comAccount'];
            $comAccount->toId = $rs->id;
            $comAccount->status = VipAccount::STATUS_VALID;
            $data['comPwd'] && $comAccount->password = sha1(md5($data['comPwd']));

            $accountRes = $newFlag ? $comAccount->create() : $comAccount->update();
            
            if($accountRes)
            {
                //新增销售、客服
                if($data['saleId'] || $data['CSId'])
                {
                    $allocationRes = Crmallocation::instance()->addAllocation(Crmallocation::COMPANY, $rs->id, $data['saleId'], $data['CSId']);
                    if(!$allocationRes)
                    {
                        $this->rollback();
                        return array('status'=>1, 'info'=>'添加公司失败！');
                    }
                }
                $arrRequest = array(
                    'id'         => $rs->id,
                    'name'       => $rs->name,
                    'abbr'       => $rs->abbr,
                    'address'    => $rs->address,
                    'tel'        => $rs->tel,
                    'fax'        => $rs->fax,
                    'logoId'     => $rs->logoId,
                    'logoExt'    => $rs->logoExt,
                    'cityId'     => $rs->cityId,
                    'account'    => $comAccount->name,
                    'saleId'     => intval($data['saleId']),
                    'CSId'       => intval($data['CSId']),
                    'status'     => $rs->status,               // 1. 有效 2. 删除 3. 无效
                    'isCheck'    => $rs->isCheck, //公司及下属部门管理经纪人 1. 有 2. 无
                    'pinyin'     => $rs->pinyin,
                    'pinyinAbbr' => $rs->pinyinAbbr,
                    'isDict'     => 1,          // 0. 字典 1. 公司
                    'isAdmin'    => $rs->isAdmin, //
                    'isCrmVerify'=> $rs->isCrmVerify,  //是否CRM对接表示，默认0
                    'customTag'  => $rs->customTag,
                    'isShowTag'  => $rs->isShowTag,
                    'isOpenShop' => $rs->isOpenShop, //公司是否开通协议签署网店 1. 是 2. 否
                );
                $arrRequest = Utility::utf8Togbk($arrRequest);
                $erpRes = SohuErp::SendCompanyToErp($arrRequest);
                $this->commit();
                return array('status'=>0, 'info'=>'添加公司成功！', 'id'=>$rs->id);
            }
            $this->rollback();
            return array('status'=>1, 'info'=>'添加公司失败！');
        }
        $this->rollback();
        return array('status'=>1, 'info'=>'添加公司失败！');
    }

    /**
     * 编辑公司信息
     *
     * @param int   $id
     * @param array $data
     * @return array
     */
    public function edit($id, $data)
    {
        if(empty($data))
        {
            return array('status'=>1, 'info'=>'参数为空！');
        }
        if($this->isExistCompanyName($data["comName"], $data["cityId"], $id))
        {
            return array('status'=>1, 'info'=>'公司全称已经存在！');
        }
        if ($this->isExistCompanyNameAbbr($data["comAbbr"], $data["cityId"], $id))
        {
            return array('status'=>1, 'info'=>'公司简称已经存在！');
        }
        $clsPinYin = new HanZiToPinYin();
        $pinyinShort = $clsPinYin->getPinYin(trim($data["comAbbr"]));

        $rs = self::findfirst($id);
        $rs->cityId = $data["cityId"];
        $rs->name = $data["comName"];
        $rs->abbr = $data["comAbbr"];
        $rs->pinyin = $pinyinShort['full'];
        $rs->pinyinAbbr = $pinyinShort['short'];
        $rs->update = date("Y-m-d H:i:s");
        $rs->isAdmin = intval($data['manageRealtor']);
        $rs->isCheck = intval($data['chkcost']);
        $rs->isShowTag = intval($data['customTitleCheck']);
        $rs->customTag = $data['customTitle'] ? $data['customTitle'] : '';
        $this->begin();
        if($rs->update()) 
        {
            if($data['comAccount'])
            {
                $accountExist = VipAccount::instance()->checkIsExistAccount(VipAccount::ROLE_COMPANY, $data['comAccount'], $rs->id);
                if($accountExist)
                {
                    $this->rollback();
                    return array('status'=>1, 'info'=>'账号已存在！');
                }
                $comAccount = VipAccount::findFirst("toId={$rs->id} and to=".VipAccount::ROLE_COMPANY." and status=".VipAccount::STATUS_VALID);
                if($comAccount)
                {
                    if($comAccount->name != $data['comAccount'])
                    {
                        $comAccount->name = $data['comAccount'];
                        $comAccount->update = date('Y-m-d H:i:s');
                        if(!$comAccount->update())
                        {
                            $this->rollback();
                            return array('status'=>1, 'info'=>'修改公司失败！');
                        }
                    }
                }
                else
                {
                    $comAccount = VipAccount::instance();
                    $comAccount->to = VipAccount::ROLE_COMPANY;
                    $comAccount->name = $data['comAccount'];
                    $comAccount->toId = $rs->id;
                    $comAccount->status = VipAccount::STATUS_VALID;
                    $data['pwd'] && $comAccount->password = sha1(md5($data['pwd']));
                    if(!$comAccount->create())
                    {
                        $this->rollback();
                        return array('status'=>1, 'info'=>'公司修改失败！');
                    }
                }
            }
            //销售、客服
            if($data['saleId'])
            {
                $allocationRes = Crmallocation::instance()->addAllocation(Crmallocation::COMPANY, $rs->id, $data['saleId'], $data['CSId']);
                if(!$allocationRes)
                {
                    $this->rollback();
                    return array('status'=>1, 'info'=>'公司修改失败！');
                }
            }
            
            $this->commit();
            return array('status'=>0, 'info'=>'公司修改成功！');

            $this->commit();
            return array('status'=>0, 'info'=>'公司修改成功！');
        }
        $this->rollback();
        return array('status'=>1, 'info'=>'公司修改失败！');
    }

    private function isExistCompanyName($comName, $cityId, $comId=0)
    {
        $comName = trim($comName);
        if(empty($comName))
        {
            return true;
        }
        $con['conditions'] = "name='{$comName}' and cityId={$cityId} and status=" . self::STATUS_ENABLED;
        $comId > 0 && $con['conditions'] .= " and id<>{$comId}";

        $intCount = self::count($con);
        if($intCount > 0)
        {
            return true;
        }
        return false;
    }

    private function isExistCompanyNameAbbr($comAbbr, $cityId, $comId=0)
    {
        $comAbbr = trim($comAbbr);
        if(empty($comAbbr))
        {
            return true;
        }
        $con['conditions'] = "abbr='{$comAbbr}' and cityId={$cityId} and status=" . self::STATUS_ENABLED;
        $comId > 0 && $con['conditions'] .= " and id<>{$comId}";

        $intCount = self::count($con);
        if($intCount > 0)
        {
            return true;
        }
        return false;
    }

    /**
     * 删除单条记录
     *
     * @param int $comId
     * @return boolean
     */
    public function del($comId)
    {
        $rs = self::findFirst("id=".$comId);
        $rs->status = self::STATUS_WASTED;
        
        $this->begin();
        if($rs->update())
        {
            $comAccount = VipAccount::findFirst("toId={$comId} and to=".VipAccount::ROLE_COMPANY." and status=".VipAccount::STATUS_VALID);
            if($comAccount)
            {
                $comAccount->status = VipAccount::STATUS_DELETE;
                if($comAccount->update())
                {
                    $this->commit();
                    return true;
                }
                $this->rollback();
                return false;
            }
            else
            {
                $this->commit();
                return true;
            }
        }
        $this->rollback();
        return false;
    }

    public function columnMap()
    {
        return array(
            'comId'         => 'id',
            'cityId'        => 'cityId',
            'comName'       => 'name',
            'comAbbr'       => 'abbr',
            'comPinyin'     => 'pinyin',
            'comPinyinAbbr' => 'pinyinAbbr',
            'comAddress'    => 'address',
            'comPostcode'   => 'postcode',
            'comTel'        => 'tel',
            'comFax'        => 'fax',
            'comX'          => 'x',
            'comY'          => 'y',
            'comLonLat'     => 'lonLat',
            'comLogo'       => 'logo',
            'comLogoId'     => 'logoId',
            'comLogoExt'    => 'logoExt',
            'comSalesId'    => 'salesId',
            'isCheck'	    => 'isCheck',
            'isOpenShop'    => 'isOpenShop',
            'isCrmVerify'    => 'isCrmVerify',
            'comCSId'       => 'cSId',
            'comStatus'     => 'status',
            'comUpdate'     => 'update',
            'isAdmin'       => 'isAdmin',
            'isShowTag'     => 'isShowTag',
            'comCustomTag'  => 'customTag'
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
     * @return Company_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }

    /**
     * 根据公司ID获取公司
     * @param int $shopId
     * @return boolean
     */
    public function getCompanyById($comId)
    {
        if(empty($comId))
        {
            return false;
        }
        return self::findfirst(" id=".$comId);
    }

    /**
     * @abstract 批量获取公司信息
     * @author Eric xuminwan@sohu-inc.com
     * @param array $ids
     * @return array|bool
     *
     */
    public function getCompanyByIds($ids, $columns = '')
    {
        if(!$ids) return false;
        if(is_array($ids))
        {
            $arrBind = $this->bindManyParams($ids);
            $arrCond = "id in({$arrBind['cond']})";
            $arrParam = $arrBind['param'];
            $condition = array(
                $arrCond,
                "bind" => $arrParam,
            );
        }
        else
        {
            $condition = array('conditions'=>"id={$ids}");
        }
        $columns && $condition['columns'] = $columns;
        $arrCompany  = self::find($condition,0)->toArray();
        $arrRcompany=array();
        foreach($arrCompany as $value)
        {
        	$arrRcompany[$value['id']] = $value;
        }
        return $arrRcompany;
    }

    /**
     * 屏蔽个别公司的电话修改功能
     * 使用的位置 1、门店系统 > 经纪人修改页：姓名、手机 两个项目为灰色不可修改
     * 使用的位置 2、企业经纪人系统 > 个人信息页：手机、电话 两个项目为灰色不可修改
     * @param  int 公司id
     * @param  int 经济人类型
     * @return bool eg: true:不可以修改,false：可以修改
     */
    public static function forbidEditPhone($intCompanyId, $intRealtorType=0){
        if( $intRealtorType!=Realtor::TYPE_COMPANY) return false;

        $arrCompanyId = array(
            '129'  => array(),
            '8515' => array(),
            '480' => array(),//易合房地产经纪有限责任公司
			//'229' => array(),//北京我爱我家房地产经纪有限公司
			'1454' => array(),//北京思源创新房地产经纪有限公司
        );  
        if( array_key_exists($intCompanyId, $arrCompanyId) ) return true;
        else return false;
    }
    
    /**
     * 验证修改公司资料信息
     *
     * @param array $data 提交的信息
     * @return bool 成功返回true，失败返回false
     */
    public function checkCompanyInfo( $data = array() )
    {
    	if(!empty($data['tel']) &&  !preg_match("/^[0-9]{8}$/",$data['tel']) ){
    		$this->error="您输入的电话格式有误";
    		return false;
    	}
    	if( !empty($data['fax']) && !preg_match("/^[0-9]{8}$/",$data['fax']) ){
    		$this->error="您输入的传真格式有误";
    		return false;
    	}
    	return true;
    }
    
    /**
     * 根据公司名、公司账号查找区域信息(公司）
     * @param array  $arrCondition
     * @param string $strColumns
     * @param string $strOrderBy
     * @param number $intLimit
     * @param number $intOffset
     * @return boolean|multitype:|unknown
     */
    public function getCompanyListByCondition( $strCondition,$strColumns='' )
    {
    	if( empty($strCondition) )	return false;
    	
    	return self::query()
    	->columns($strColumns)
    	->where($strCondition)
    	->leftJoin(VipAccount, 'va.toId = Company.id', 'va')
    	->limit(20)
    	->execute();
    }

    /*
     * 根据城市id获取经纪人公司
     * */
    public function  getCompanyByCityId( $cityId ){
        $rs = $this->find("cityId=".$cityId." AND status=".self::STATUS_ENABLED)->toArray();
        $result = array();
        if($rs){
            foreach($rs as $k=>$v){
                $result[$k]['id'] = $v['id'] ;
                $result[$k]['name'] = $v['abbr'];
            }
        }
        return $result;
    }
}

