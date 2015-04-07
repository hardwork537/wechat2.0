<?php
class ParkExt extends BaseModel
{
    protected $id;
    protected $parkId;
    protected $name;
    protected $value;
    protected $length;
    protected $status;
    protected $update;
    
    //数据状态  status
    const STATUS_VALID   = 1;  //有效
    const STATUS_INVALID = 0;  //失效
    const STATUS_DELETE  = -1; //删除
    const KEY_OF_PERMIT_FOR_PRESALE = '预售许可证';
    const KEY_OF_YEAR_LIMIT = "产权年限";
    const KEY_OF_ESTATE_DEVELOPER = '开发商';
    const KEY_OF_PROPERTY_COMPANY = '物业公司';

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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if($name == '' || mb_strlen($name, 'utf8') > 50)
        {
            return false;
        }
        $this->name = $name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        if($value == '' || mb_strlen($value, 'utf8') > 250)
        {
            return false;
        }
        $this->value = $value;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        if(preg_match('/^\d{1,3}$/', $length == 0) || $length > 255)
        {
            return false;
        }
        $this->length = $length;
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

    public function getUpdate()
    {
        return $this->update;
    }

    public function setUpdate($update)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $update) == 0 || strtotime($update) == false)
        {
            return false;
        }
        $this->update = $update;
    }

    public function getSource()
    {
        return 'park_ext';
    }
    
    /**
     * 判断某个小区的某个扩展字段是否存在
     * @param int    $parkId
     * @param string $peName
     * return int | boolean
     */
    public function isExistExt($parkId, $peName)
    {
        $parkId = intval($parkId);
        $peName = trim($peName);
        if(!$parkId || !$peName)
        {
            return true;
        }
        $con['conditions'] = "parkId={$parkId} and name='{$peName}' and status=" . self::STATUS_VALID;
                
        $extInfo = self::findFirst($con);
        if($extInfo) 
        {
            $extInfo = $extInfo->toArray();
            
            return intval($extInfo['id']);
        }
        else
        {
            return false;
        }       
    }
    
    /**
     * 添加扩展字段
     * @param int   $parkId
     * @param array $data
     * @return boolean
     */
    public function add($parkId, $data)
    {
        $parkId = intval($parkId);
        if(empty($data) || !$parkId)
        {
            return false;
        }
        $rs = self::instance();
        $rs->id = null;
        $rs->parkId = intval($parkId);
        $rs->name = $data["name"];
        $rs->value = $data["value"];
        $rs->length = mb_strlen($data["value"], 'utf-8');
        $rs->status = self::STATUS_VALID;
        $rs->update = date("Y-m-d H:i:s");

        if($rs->create())
        {
            return true;
        }

        return false;
    }
    
    /**
     * 更新某个扩展字段
     * @param int   $peId
     * @param array $data
     * @return boolean
     */
    public function edit($peId, $data)
    {
        $peId = intval($peId);
        if(empty($data) || !$peId)
        {
            return false;
        }
        $rs = self::findFirst($peId);
        $rs->name = $data["name"];
        $rs->value = $data["value"];
        $rs->length = mb_strlen($data["value"], 'utf-8');
        $rs->update = date("Y-m-d H:i:s");
        
        if($rs->update())
        {
            return true;
        }
        
        return false;
    }
    
    /**
     * 删除小区扩展信息
     * @param int $parkId
     * @return boolean
     */
    public function del($parkId)
    {
        $parkId = intval($parkId);
        if(!$parkId)
        {
            return false;
        }
        $exts = $this->find(array("conditions"=>"parkId={$parkId}"));
        if($exts)
        {
            foreach($exts as $ext)
            {
                $ext->status = self::STATUS_DELETE;
                $delRet = $ext->update();
                if(!$delRet)
                    return false;
            }
        }
        else
        {
            return true;
        }
        
        return true;
    }
    
    public function columnMap()
    {
        return array(
            'peId'     => 'id',
            'parkId'   => 'parkId',
            'peName'   => 'name',
            'peValue'  => 'value',
            'peLength' => 'length',
            'peStatus' => 'status',
            'peUpdate' => 'update'
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
     * @return ParkExt_Model
     */

    public static function instance($cache = true) 
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
    
    /**
     * @abstract 获取小区扩展信息根据扩展字段值
     * @author Eric xuminwan@sohu-inc.com
     * @param int $intParkId
     * @param string $strName
     * @return array
     * 
     */
    public function getParkExtByParkId($intParkId, $strName = '')
    {
    	if(!$intParkId) return array();
    	if($strName != '')
    	{
    		$strCond = "status = 1 and parkId = ?1 and name =?2";
    		$arrParam = array(1=>$intParkId,2=>$strName);
    	}
    	else{
    		$strCond = "status = 1 and parkId = ?1";
    		$arrParam = array(1=>$intParkId);
    	}
    	$arrAssort = self::find(array(
    		$strCond,
    		'bind'=>$arrParam,	
    	),0)->toArray();
    	return $arrAssort;
    }


    /*
         * 获取小区扩展信息
         * by Moon
         */
    public function getParkExtByIdName($parkId,$name){
        if (!$parkId) return false;
        $arrCondition['conditions'] = "status = ".Park::STATUS_VALID." and parkId=:parkId: and name=:name:";
        $arrCondition['bind'] = array(
            "parkId"    =>  $parkId,
            'name'  =>  $name
        );
        return self::findFirst($arrCondition,0)->toArray();
    }

    /*
         * 获取小区扩展信息
         * by Moon
         */
    public function getParkExtById($parkId){
        if (!$parkId) return false;
        $arrCondition['conditions'] = "status = ".Park::STATUS_VALID." and parkId=:parkId: ";
        $arrCondition['bind'] = array(
            "parkId"    =>  $parkId,
        );
        return self::find($arrCondition,0)->toArray();
    }

    public function insertData($data){
        $parkExt = new ParkExt();
        $insertData['parkId'] = $data['parkId'];
        $insertData['name'] = $data['name'];
        $insertData['value'] = $data['value'];
        $insertData['length'] = mb_strlen($data['value'],"utf8");
        $insertData['status'] = $data['status'];
        $insertData['update'] = $data['update'];
        $parkExt->create($insertData);
    }
    

}