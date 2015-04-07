<?php
/**
 * Created by PhpStorm.
 * User: Moon
 * Date: 12/4/14
 * Time: 2:52 PM
 */
class WebPhoneRecord extends BaseModel{
    protected $id;
    protected $phone;
    protected $create_time;

    public function getSource()
    {
        return 'web_phone_record';
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'phone' => 'phone',
            'create_time' => 'create_time'
        );
    }

    /**
     * 实例化对象
     *
     * @param type $cache
     * @return \WebPhoneRecord
     */
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

}