<?php
/**
 * @abstract  修改门店客服
 * @copyright Sohu-inc User.
 * @author    tony (tonyzhao@sohu-inc.com)
 * @date      2015-01-13 14:12:18
 */

class AdminModifyCsLogs extends BaseModel 
{
    protected $id;
	protected $userId;
	protected $userName;
	protected $shopId;
	protected $shopName;
	protected $toCSId;
	protected $fromUserId;
	protected $modifyStr;
	protected $type;
	protected $time;

    public function columnMap ()
    {
        return array(
            'ulId'         => 'id',
            'userId'       => 'userId',
            'userName'     => 'userName',
            'shopId'       => 'shopId',
            'shopName'     => 'shopName',
            'ulToCSId'   => 'toCSId',
            'ulFromUserId' => 'fromUserId',
            'ulModifyStr'  => 'modifyStr',
            'ulType'       => 'type',
            'ulTime'       => 'time'
        );
    }
    
    public function getSource()
    {
    	return 'admin_modify_cs_logs';
    }
    
    public static function instance($cache=true)
    {
        return parent::_instance(__CLASS__,$cache);
        return new self;
    }


    public function initialize ()
    {
        $this->setConn('esf');
    }


    /**
     * 插入多条门店转移日志
     * @param array $data
     * @return boolean
     */
    public function addModifyShopCSLogs($data = array()) 
    {
        if(empty($data)) 
        {
            return false;
        }
        $tableName = $this->getSource();
        $insertSql = "INSERT INTO {$tableName}(userId,userName,shopId,shopName,ulToCSId,ulFromUserId,ulModifyStr,ulType,ulTime) VALUES";
        $value = '';
        foreach($data as $v)
        {
            $value .= "({$v['userId']},'{$v['userName']}',{$v['shopId']},'{$v['shopName']}',{$v['toCSId']},{$v['fromUserId']},'{$v['modifyStr']}',{$v['type']},'{$v['time']}'),";
        }
        if(!$value)
        {
            return false;
        }
        $insertSql .= rtrim($value, ',');
        $insertRes = $this->execute($insertSql);
        
        return $insertRes;
    }

}