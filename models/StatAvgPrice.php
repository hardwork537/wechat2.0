<?php
class StatAvgPrice extends BaseModel
{
	/**
	 * 均价时间单位
	 * @var unknown
	 */
	const TYPE_YEAR = 1;	//年均价
	const TYPE_MONTH = 2;	//月均价
	const TYPE_WEEK = 3;	//周均价
	
	/**
	 * @abstract 均价类型 relateType 
	 * 
	 */
	const TYPE_CITY = 1;
	const TYPE_DISTRICT = 2;
	const TYPE_REGION = 3;
	const TYPE_PARK = 4;
	
    public $id;
    public $relateId;
    public $relateType;
    public $type;
    public $field;
    public $value;
    public $status;
    public $update;

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

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        if(preg_match('/^\d{1,3}$/', $type == 0) || $type > 255)
        {
            return false;
        }
        $this->type = $type;
    }

    public function getField()
    {
        return $this->field;
    }

    public function setField($field)
    {
        if($field == '' || mb_strlen($field, 'utf8') > 10)
        {
            return false;
        }
        $this->field = $field;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        if(preg_match('/^\d{1,10}$/', $value == 0) || $value > 4294967295)
        {
            return false;
        }
        $this->value = $value;
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
        return 'stat_avgprice';
    }

    public function columnMap()
    {
        return array(
            'statId' => 'id',
            'relateId' => 'relateId',
        	'relateType' => 'relateType',	
            'statType' => 'type',
            'statField' => 'field',
            'statValue' => 'value',
            'statStatus' => 'status',
            'statUpdate' => 'update'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    
    /**
     * @abstract 根据条件类型获取相应的均价 
     * @author Eric xuminwan@sohu-inc.com
     * @param int $relateId 关联均价字典ID
     * @param int $relateType 关联均价字典类型(城市、区域、版块等)
     * @param int $type
     * @param int $field
     * @param int $cFieldType 时间条件类型(1:等于 2:大于 3:>=) 
     * @return array|bool
     * 
     */
    public function getAvgPriceByCondition($relateId,$relateType,$type,$field,$cFieldType=1)
    {
    	if (!($relateId && $relateType && $type && $field)) return false;
    	switch($cFieldType){
    		case 1:
    			$compareType = '=';
    			break;
    		case 2:
    			$compareType = '>';
    			break;
    		case 3:
    			$compareType = '>=';
    			break;
    			
    			
    	}		
    	$arrCon = "relateId = ?1 and relateType = ?2 and type = ?3 and field ".$compareType." ?4";
    	$arrParam = array(
    			1=>$relateId,
    			2=>$relateType,
    			3=>$type,
    			4=>$field,
    		);
    	$arrAvgPrice = self::find(array(
    		$arrCon,
    		'bind' => $arrParam,
    		'order' => 'field',
    	),0)->toArray();
    	return $arrAvgPrice;
    }

    public function addAvgPrice($arrParam){
        $date = isset($arrParam['field']) && $arrParam['field'] ? $arrParam['field'] : date("Y-m-01");
        $this->relateId = $arrParam['relateId'];
        $this->relateType = $arrParam['relateType'];
        $this->type = $arrParam['type'];
        $this->field = $date;
        $this->value = $arrParam['value'];
        $this->status = 1;
        $this->update = date("Y-m-d H:i:s");
        return $this->create();
    }
}