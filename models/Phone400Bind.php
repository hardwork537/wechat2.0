<?php

class Phone400Bind extends BaseModel
{
    
    //操作类型
    const STATUS_BIND   = 1;  //绑定
    const STATUS_UNBIND = 2;  //解绑
    
    public $id;
    public $phonePre;
    public $phoneExt;
    public $parkId;
    public $realId;
    public $status;
    public $updateTime;
    public $createTime;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'pbId'         => 'id',
            'pbPhonePre'   => 'phonePre',
            'pbPhoneExt'   => 'phoneExt',
            'parkId'       => 'parkId', 
            'realId'       => 'realId', 
            'pbStatus'     => 'status',
            'pbUpdateTime' => 'updateTime',
            'pbCreateTime' => 'createTime'
        );
    }

    public function initialize ()
    {
        $this->setConn('esf');
    }
    
    public function getSource ()
    {
        return 'phone400_bind';
    }
    
    /**
     * 单例对象
     * @return type
     */
    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__,$cache);
    }
}
