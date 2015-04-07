<?php

class ZebCompany extends BaseModel
{

    public $id;
    public $comId = 0;
    public $cityId = 0;
    public $date;
    public $realtorTotal = 0;
    public $realtorFreeH = 0;
    public $realtorPaid = 0;
    public $realtorReg = 0;
    public $realtorWait = 0;
    public $realtorPass = 0;
    public $realtorFree = 0;
    public $realtorPaidH = 0;
    public $realtorSleep = 0;
    public $updateTime = 0;
    

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'zcId'           => 'id',
            'cityId'         => 'cityId',  
            'comId'          => 'comId', 
            'zcDate'         => 'date',
            'zcRealtorTotal' => 'realtorTotal',
            'zcRealtorFreeH' => 'realtorFreeH',
            'zcRealtorPaid'  => 'realtorPaid',
            'zcRealtorReg'   => 'realtorReg',
            'zcRealtorWait'  => 'realtorWait',
            'zcRealtorPass'  => 'realtorPass',
            'zcRealtorFree'  => 'realtorFree',
            'zcRealtorPaidH' => 'realtorPaidH',
            'zcRealtorSleep' => 'realtorSleep',
            'zcUpdate'       => 'updateTime'
        );
    }
    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
    
    /**
     * 根据公司id、日期获取公司统计数据
     * @param int|array $comIds
     * @param string    $columns
     * @param string    $date
     * @return array
     */
    public function getDataByComId($comIds, $columns = '', $date = false)
    {
        if(empty($comIds))
        {
            return array();
        }
        if(is_array($comIds))
        {
            $arrBind = $this->bindManyParams($comIds);
            $arrCond = "comId in({$arrBind['cond']})";
            false === $date || $arrCond .= " and date='{$date}'";
            $arrParam = $arrBind['param'];
            $condition = array(
                $arrCond,
                "bind" => $arrParam,
            );
        }
        else
        {
            $where = "comId={$comIds}";
            false === $date || $where .= " and date='{$date}'";
            $condition = array('conditions'=>"comId={$comIds} and date='{$date}'");
        }
        $columns && $condition['columns'] = $columns;
        $arrData  = self::find($condition,0)->toArray();
        $arrRdata=array();
        foreach($arrData as $value)
        {
//            if(false == $date)
//            {
//                $arrRdata[$value['comId']] = $value;
//            }
//            else
//            {
                $arrRdata[$value['comId']] = $value;
//            }       	
        }
        
        return $arrRdata;
    }
}
