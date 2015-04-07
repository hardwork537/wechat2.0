<?php

class HousePicOplog extends  BaseModel
{

    public $id;
    public $opId;
    public $opAccname;
    public $cityId;
    public $housenum;
    public $housePic;
    public $houseWeigui;
    public $date;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'hoId' => 'id',
            'opId' => 'opId',
            'opAccname'=>'opAccname',
            'cityId' => 'cityId', 
            'hoHousenum' => 'housenum',
            'hoHousePic' => 'housePic',
            'hoHouseWeigui' => 'houseWeigui',
            'hoDate' => 'date'
        );
    }

    public static function instance ($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self();
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }

    public function updateOrAddById($arrData){
        $con = "cityId=".$arrData['cityId']." AND opId=".$arrData['opId']." AND date='".date("Y-m-d")."'";
        $rs = $this->findFirst($con);
        if($rs){
            $rs->housenum    = $rs->housenum + $arrData['housenum'];
            $rs->housePic    = $rs->housePic + $arrData['housePic'];
            $rs->houseWeigui = $rs->houseWeigui + $arrData['houseWeigui'];
            return $rs->update();
        }else{
            return $this->addByHouseID($arrData);
        }


    }
    //添加操作记录
    public function addByHouseID( $arrData )
    {
        if( empty($arrData) )	return false;
        $arrInsert = array();
        $arrInsert['opId']	       =   isset($arrData['opId'])	?	$arrData['opId']	:	0;//操作人id
        $arrInsert['opAccname']	   =   isset($arrData['opAccname'])	?	$arrData['opAccname']	:	"";//操作人id
        $arrInsert['cityId']       =   isset($arrData['cityId'])? $arrData['cityId'] : 1;
        $arrInsert['housenum']     =   isset($arrData['housenum'])	?	$arrData['housenum']	:	15;
        $arrInsert['housePic']     =   isset($arrData['housePic'])  ?  $arrData['housePic']   :   0;
        $arrInsert['houseWeigui']  =   isset($arrData['houseWeigui'])  ?  $arrData['houseWeigui']   :   "";
        $arrInsert['date']	       =   date('Y-m-d');
        try
        {
            return self::create($arrInsert);
        }
        catch (Exception $ex)
        {
            return false;
        }
    }

    //查找
    public function getInfoByTime($cityId, $startTime, $endTime,$accname, $offset, $size=15){
        $con = "cityId=$cityId";
        if($startTime){
            $con .= " AND date>='$startTime' ";
        }
        if($endTime){
            $con .= " AND date<='$endTime' ";
        }
        if($accname){
            $con .= " AND opAccname='$accname' ";
        }
        $data["total"] = $this->count($con);
        $data["list"]  = $this->find([
            "conditions" => $con,
            "order" => "id desc",
            "limit" => [
                'number' => $size,
                'offset' => $offset
            ],
            "group"   => ["date", "opId"]
        ])->toArray();
        if(!empty($data["list"])){
            foreach($data["list"] as $k=>&$v){
                $adminUser = AdminUser::findFirst("id=".$v['opId'],0)->toArray();
                if($adminUser){
                    $v["name"] = $adminUser["name"];
                }
            }
        }
        return $data;
    }

}
