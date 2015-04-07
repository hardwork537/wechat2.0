<?php
class ParkMatch extends BaseModel
{
    public $id;
    public $toParkId; 
    public $fromParkName;
    public $comId;
    public $fromDistName;


    public function getSource()
    {
        return 'park_match';
    }

    public function columnMap()
    {
        return array(
            'pmId' => 'id',
            'toParkId' => 'toParkId',
            'fromParkName' => 'fromParkName',
            'comId' => 'comId',
            'fromDistName' => 'fromDistName'
        );
    }

    public function initialize()
    {
        $this->setConn('esf');
    }
    
    /**
     * 实例化对象
     *
     * @param type $cache
     * @return \Users_Model
     */
    public static function instance ($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self();
    }
    
    /**
     *  获取小区匹配配置信息
     * @param unknown $intComID
     */
    public function getParkMatch($intComID)
    {
    	if(empty($intComID))
    		return false;
    	
    	$arrBackData = array();
    	
    	$arrCond  = "comId = ?1 " ;
    	$arrParam = array(1 => $intComID);
    	$arrRes   = self::find(array(
			$arrCond,
			"bind" => $arrParam
    	));

		if ( !empty($arrRes) ) {
			$arrBackData = array();
			foreach ( $arrRes as $v ) {
				$arrBackData[$v->fromParkName.'_'.Util::FormatDistrict($v->fromDistName)] = $v->toParkId;
			}
		}
    	 
    	return $arrBackData;
    }
    
    /**
     * 添加API配置
     * @param array $arr
     * @return boolean
     */
    public function add ($arr)
    {
        $rs = self::instance();
        $rs->toParkId = $arr["toParkId"];
        $rs->fromParkName = $arr["fromParkName"];
        $rs->fromDistName = $arr["fromDistName"];
        $rs->comId = $arr["comId"];
    
        if ($rs->create()) {
            return true;
        }
        return false;
    }
    
    /**
     * 删除单条API配置
     *
     * @param unknown $where
     */
    public function del ($where)
    {
        $rs = self::findFirst($where);
        if ($rs->delete()) {
            return true;
        }
        return false;
    }
}