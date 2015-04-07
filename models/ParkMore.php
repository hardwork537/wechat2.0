<?php
class ParkMore extends BaseModel
{
    protected $id;
    protected $parkId;
    protected $name;
    protected $text;
    protected $length;
    protected $status;
    protected $update;
    
    //数据状态  status
    const STATUS_VALID   = 1;  //有效
    const STATUS_INVALID = 0;  //失效
    const STATUS_DELETE  = -1; //删除

    const KEY_OF_BUS_STATION = '周边公交';
    
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

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        if($text == '' || strlen($text) > 65535)
        {
            return false;
        }
        $this->text = $text;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        if(preg_match('/^\d{1,5}$/', $length == 0) || $length > 65535)
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
        return 'park_more';
    }
    
    /**
     * 判断某个小区的某个扩展字段是否存在
     * @param int    $parkId
     * @param string $pmName
     * return int | boolean
     */
    public function isExistMore($parkId, $pmName)
    {
        $parkId = intval($parkId);
        $pmName = trim($pmName);
        if(!$parkId || !$pmName)
        {
            return true;
        }
        $con['conditions'] = "parkId={$parkId} and name='{$pmName}' and status=" . self::STATUS_VALID;
                
        $moreInfo = self::findFirst($con);
        if($moreInfo) 
        {
            $moreInfo = $moreInfo->toArray();
            
            return intval($moreInfo['id']);
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
        $rs->text = $data["value"];
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
    public function edit($pmId, $data)
    {
        $pmId = intval($pmId);
        if(empty($data) || !$pmId)
        {
            return false;
        }
        $rs = self::findFirst($pmId);
        $rs->name = $data["name"];
        $rs->text = $data["value"];
        $rs->length = mb_strlen($data["value"], 'utf-8');
        $rs->update = date("Y-m-d H:i:s");
        
        if($rs->update())
        {
            return true;
        }
        
        return false;
    }
    
    /**
     * 删除小区描述信息
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
        $mores = $this->find(array("conditions"=>"parkId={$parkId}"));
        if($mores)
        {
            foreach($mores as $more)
            {
                $more->status = self::STATUS_DELETE;              
                $delRet = $more->update();
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
            'pmId'     => 'id',
            'parkId'   => 'parkId',
            'pmName'   => 'name',
            'pmText'   => 'text',
            'pmLength' => 'length',
            'pmStatus' => 'status',
            'pmUpdate' => 'update'
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

    public function getParkMoreById($parkId){
        if (!$parkId) return false;

        $arrCondition['conditions'] = "parkId=:parkId:";
        $arrCondition['bind'] = array(
            "parkId"    =>  $parkId
        );
        return self::find($arrCondition, 0)->toArray();
    }

    /*
         * 获取小区扩展信息
         * by Moon
         */
    public function getParkMoreByIdName($parkId,$name){
        if (!$parkId) return false;
        $arrCondition['conditions'] = "status = ".Park::STATUS_VALID." and parkId=:parkId: and name=:name:";
        $arrCondition['bind'] = array(
            "parkId"    =>  $parkId,
            'name'  =>  $name
        );
        return self::findFirst($arrCondition,0)->toArray();
    }


}