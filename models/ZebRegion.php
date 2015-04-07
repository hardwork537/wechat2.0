<?php

class ZebRegion extends BaseModel
{

    public $id;
    public $cityId;
    public $distId;
    public $regId;
    public $date;
    public $parkNum;
    public $saleTotal;
    public $saleClick;
    public $rentTotal;
    public $rentClick;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'zrId' => 'id',
            'cityId' => 'cityId',
            'distId' => 'distId',
            'regId' => 'regId',
            'comId' => 'comId',
            'zrDate' => 'date',
            'zrParkNum' => 'parkNum',
            'zrSaleTotal' => 'saleTotal',
            'zrSaleClick' => 'saleClick',
            'zrRentTotal' => 'rentTotal',
            'zrRentClick' => 'rentClick'
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

    //获取城区统计
    public function getDataByDist($con, $size=0, $offset=0,$type="sale"){
        $res = $this->find([
            "conditions" => $con,
            "limit" => [
                'number' => $size,
                'offset' => $offset
            ],
            "order" => $type."Click desc",
            "group"   => 'distId',
            "columns"=>"distId  ,SUM(parkNum) as parkNum, SUM(saleTotal) as saleTotal, SUM(saleClick) as saleClick, SUM(rentTotal) as rentTotal, SUM(rentClick) as rentClick"
        ])->toArray();
        return $res;
    }

    //获取城区下公司统计
    public function getDataByCom($con, $size=0, $offset=0){
        $res = $this->find([
            "conditions" => $con,
            "limit" => [
                'number' => $size,
                'offset' => $offset
            ],
            "group"   => 'comId',
            "columns"=>"comId,distId  ,SUM(parkNum) as parkNum, SUM(saleTotal) as saleTotal, SUM(saleClick) as saleClick, SUM(rentTotal) as rentTotal, SUM(rentClick) as rentClick"
        ])->toArray();
        return $res;
    }



    //获取板块统计
    public function getDataByReg($con, $size=0, $offset=0,$type="sale"){
        $res = $this->find([
            "conditions" => $con,
            "limit" => [
                'number' => $size,
                'offset' => $offset
            ],
            "order"   => $type."Click desc",
            "group"   => 'regId',
            "columns"=>"distId ,regId ,SUM(parkNum) as parkNum, SUM(saleTotal) as saleTotal, SUM(saleClick) as saleClick, SUM(rentTotal) as rentTotal, SUM(rentClick) as rentClick"
        ])->toArray();
        if(!empty($res)){
            foreach($res as $k=>$v){
                $regIds[$v['regId']] = $v['regId'];
            }
            $regidsInfo = CityRegion::instance()->getRegionByIds($regIds);
            foreach($res as $key=>&$value){
                $value['regName'] = $regidsInfo[$value['regId']]['name'];
            }
        }
        return $res;
    }

    //批量插入多个
    public function addData($arrData){
        if(empty($arrData)) return false;
        $valSql = '';
        $createTime = date("Y-m-d",time()-86400);
        foreach($arrData as $v){
            $zrSaleTotal = isset($v['saleTotal'])?$v['saleTotal']:0;
            $zrSaleClick = isset($v['saleClick'])?$v['saleClick']:0;
            $zrRentTotal = isset($v['rentTotal'])?$v['rentTotal']:0;
            $zrRentClick = isset($v['rentClick'])?$v['rentClick']:0;
            $valSql .= "(".$v['cityId'].",".$v['distId'].",".$v['regId'].",".$v['comId'].",'".$createTime."',".count($v['parkId']).",".$zrSaleTotal.",".$zrSaleClick.",".$zrRentTotal.",".$zrRentClick."),";
        }
        $valSql = trim($valSql,',');

        $sql = "INSERT INTO zeb_region (cityId,distId,regId ,comId, zrDate, zrParkNum,zrSaleTotal,zrSaleClick, zrRentTotal, zrRentClick  ) VALUES {$valSql}";
        $rs = $this->execute($sql);
        return $rs;
    }

}
