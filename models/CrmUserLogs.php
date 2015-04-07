<?php
/**
 * @abstract  销售日志
 * @copyright Sohu-inc User.
 * @author    Rady (yifengcao@sohu-inc.com)
 * @date      2014-09-28 14:12:18
 * @version   crm 2.0
 */

class CrmUserLogs extends BaseModel {

    protected $id;
	protected $userId;
	protected $userName;
	protected $agentId;
	protected $agentName;
	protected $toSaleId;
	protected $fromUserId;
	protected $modifyStr;
	protected $type;
	protected $time;

public function columnMap (){
	return array(
		'ulId' => 'id',
		'userId' => 'userId',
		'userName' => 'userName',
		'agentId' => 'agentId',
		'agentName' => 'agentName',
		'ulToSaleId' => 'toSaleId',
		'ulFromUserId' => 'fromUserId',
		'ulModifyStr' => 'modifyStr',
		'ulType' => 'type',
		'ulTime' => 'time'
	);
}

    public static function instance($cache=true){
        return parent::_instance(__CLASS__,$cache);
        return new self;
    }


    public function initialize ()
    {
        $this->setConn('esf');
    }

    public function getLogsList($con=array(),$offset=0,$size=20){
        $con = $this->_params_filter($con);
        return self::find(array(
			$con,
			"order" => " id desc",
			"limit" => array("offset"=>$offset, "number"=>$size)
		))->toArray();
    }

    public function getLogsCount($con=array()){
        $con = $this->_params_filter($con);
        return self::count($con);
    }


    private function  _params_filter($con){
        $c = " 1 ";
        if($con['starttime']){
            $c .= " and time>='".$con["starttime"]." 00:00:00'";
        }
        if($con['endtime']){
            $c .= " and time<='".$con["endtime"]." 23:59:59'";
        }
        if($con['user_name']){
            $c .= " and userName like'".trim($con["user_name"])."%'";
        }
        if($con['agent_name']){
            $c .= " and agentName like'%".trim($con["agent_name"])."%'";
        }
        if($con['modify_str']){
            $c .= "and modifyStr like'%".trim($con["modify_str"])."%'";
        }
        return $c;
    }

    /**
     * 获取所有的操作人列表
     * @return array
     */
    public function getSalesOptions(){
        $arr = array();
        $rs = self::find(array("group"=>"userId","order"=>"id desc","columns"=>"userId,userName"))->toArray();
        foreach($rs as $k=>$v){
            $arr[$v['userId']] = $v['userName'];
        }
        return $arr;
    }

    /**
     * 获取操作的门店列表
     * @return array
     */
    public function getAgentsOptions(){
        $arr = array();
		$rs = self::find(array("group"=>"agentId","order"=>"id desc","columns"=>"agentId,agentName"))->toArray();
        foreach($rs as $k=>$v){
            $arr[$v['agentId']] = $v['agentName'];
        }
        return $arr;
    }

    /**
     * 插入多条门店转移日志
     * @param array $data
     * @return boolean
     */
    public function addTranferShopLogs($data = array()) 
    {
        if(empty($data)) 
        {
            return false;
        }
        
        foreach($data as $v)
        {
            $rs = self::instance(false);
            
            $rs->userId = $v['userId'];
            $rs->userName = $v['userName'];
            $rs->agentId = $v['shopId'];
            $rs->agentName = $v['shopName'];
            $rs->toSaleId = $v['toSaleId'];
            $rs->fromUserId = $v['fromUserId'];
            $rs->modifyStr = $v['modifyStr'];
            $rs->type = $v['type'];
            $rs->time = $v['time'];
            if(!$rs->create())
            {
                return false;
            }
        }
        
        return true;
    }

}