<?php
class CompanyTemplate extends BaseModel
{
	//字段 type 模板房源类型
	const SALE = 1;
	const RENT = 2;

	//字段 is_show 是否启用公司默认模板
	const IS_SHOW = 1;
	const ISNOT_SHOW = 2;

    protected $id;
    protected $comId = 0;
    protected $type = 0;
    protected $title = '';
    protected $template;
    protected $seq = 0;
    protected $status = 0;
    protected $ctUpdate;
    
    const STATUS_OPEN   = 1;  //启用
    const STATUS_CLOSE  = 0;  //关闭
    const STATUS_DELETE = -1; //删除
    
    /**
     * 新增公司模板
     * @param array $data
     * @return array
     */
    public function add($data) 
    {
        if(empty($data)) 
        {
            return array('status'=>1, 'info'=>'参数为空！');
        }
        if($this->isExistCompanytemplate($data['comId'], $data['seq'], $data['type']))
        {
            return array('status'=>1, 'info'=>'模板已存在！');
        }
        
        $rs = self::instance();
        $rs->comId = $data["comId"];
        $rs->type = $data["type"];
        $rs->title = $data["title"];
        $rs->template = $data['content'];
        $rs->seq = $data['seq'];
        $rs->status = $data['status'];
        $rs->update = date("Y-m-d H:i:s");

        if($rs->create()) 
        {
            return array('status'=>0, 'info'=>'添加公司模板成功！');  
        }
        return array('status'=>1, 'info'=>'添加公司模板失败！');  
    }
    
    private function isExistCompanytemplate($comId, $seq, $type) 
    {
        $con['conditions'] = "comId={$comId} and seq={$seq} and type={$type}";
                
        $intCount = self::count($con);
        if($intCount > 0) 
        {
            return true;
        }
        return false;
    }
    
    /**
     * 编辑公司模板
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
        
        $rs = self::findfirst($id);
        if(!$rs)
        {
            return array('status'=>1, 'info'=>'模板不存在！');
        }
        $rs->status = $data["status"];
        $rs->title = $data["title"];
        $rs->template = $data["content"];
        $rs->ctUpdate = date("Y-m-d H:i:s");
        
        if ($rs->update()) {
            return array('status'=>0, 'info'=>'公司模板修改成功！');
        }
        return array('status'=>1, 'info'=>'公司模板失败！');
    }
    
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

    public function getCtType()
    {
        return $this->type;
    }

    public function setCtType($type)
    {
        if(preg_match('/^-?\d{1,1}$/', $type) == 0 || $type > 127 || $type < -128)
        {
            return false;
        }
        $this->type = $type;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        if($title == '' || mb_strlen($title, 'utf8') > 20)
        {
            return false;
        }
        $this->title = $title;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setTemplate($template)
    {
        if($template == '' || strlen($template) > 65535)
        {
            return false;
        }
        $this->template = $template;
    }

    public function getSeq()
    {
        return $this->seq;
    }

    public function setSeq($seq)
    {
        if(preg_match('/^-?\d{1,2}$/', $seq) == 0 || $seq > 127 || $seq < -128)
        {
            return false;
        }
        $this->seq = $seq;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        if(preg_match('/^-?\d{1,1}$/', $status) == 0 || $status > 127 || $status < -128)
        {
            return false;
        }
        $this->status = $status;
    }

    public function getCtUpdate()
    {
        return $this->ctUpdate;
    }

    public function setCtUpdate($ctUpdate)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $ctUpdate) == 0 || strtotime($ctUpdate) == false)
        {
            return false;
        }
        $this->ctUpdate = $ctUpdate;
    }

    public function getSource()
    {
        return 'company_template';
    }
        
    public function columnMap()
    {
        return array(
            'ctId'          => 'id',
            'comId'         => 'comId',
            'ctType'        => 'type',
            'ctTitle'       => 'title',
            'ctTemplate'    => 'template',
            'ctSeq'         => 'seq',
            'ctStatus'      => 'status',
            'ctUpdate'      => 'ctUpdate',
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

	/*
	 * 获取指定类型的房源模板(用于前端展示)
	 * @param $intCompanyId int
	 * @param $intType 房源类型
	 */
	public function getTemplateList($intCompanyId, $intType){
		$strCond = "comId='".$intCompanyId."' AND status='".self::IS_SHOW."' AND type='".$intType."'";
		$arrTemplate = self::find(array($strCond, 'order' => 'seq', 'columns' => 'title,template'));
		$arrTemplate = empty($arrTemplate) ? array() : $arrTemplate->toArray();
		foreach($arrTemplate as $key => $value){
			$arrTemplate[$key]['template'] = stripslashes($value['template']); 
		}
		return $arrTemplate;
	}
}
