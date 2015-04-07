<?php
class Product extends BaseModel{
    protected  $id;
    protected  $name;
    protected  $content;
    protected  $big_pic;
    protected  $small_pic;
    protected  $days;
    protected  $counts;
    protected  $cost;
    protected  $rank;
    protected  $type;
    protected  $city;
    protected  $createTime;
    protected  $redeemCount;

    const TYPE_SALE_EXPERTS_UNIT = 1; //出售置业专家房源
    const TYPE_RENT_EXPERTS_UNIT = 2; //出租置业专家房源
    const TYPE_SALE_EXPERTS_FACE = 3; //出售置业专家头像
    const TYPE_RENT_EXPERTS_FACE = 4; //出租置业专家头像
    const TYPE_SALE_TAG = 5;          //出售标签
    const TYPE_RENT_TAG = 6;          //出租标签
    
    static $Types=array(
        self::TYPE_SALE_EXPERTS_UNIT      => "出售置业专家房源",
        self::TYPE_RENT_EXPERTS_UNIT      => "出租置业专家房源",
        self::TYPE_SALE_EXPERTS_FACE      => "出售置业专家头像",
        self::TYPE_RENT_EXPERTS_FACE      => "出租置业专家头像",
        self::TYPE_SALE_TAG               => "出售标签",
        self::TYPE_RENT_TAG               => "出租标签"
    );


    public static function instance($cache = true) {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }
    public function initialize(){
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
   
    public function getSource()
    {
        return 'product';
    }

    public function columnMap()
    {
        return array(
            'id'               => 'id',
            'productName'      => 'name',
            'productContent'   => 'content',
            'productBig_pic'   => 'big_pic',
            'productSmall_pic' => 'small_pic',
            'productDays'      => 'days',
            'productCounts'    => 'counts',
            'productCost'      => 'cost',
            'productRank'      => 'rank',
            'productType'      => 'type',
            'city'             => 'city',
            'createTime'       => 'createTime',
            'redeemCount'      => 'redeemCount',    
        );
    }
   
    public function getId(){
        return $this->id;
    }
    public function setId($Id){
        if(preg_match('/^\d{1,10}$/', $Id == 0) || $Id > 4294967295)
        {
            return false;
        }
        $this->id = $Id;
    }
    
    public function getproductName(){
        return $this->name;
    }
    public function setproductName($name)
    {
        if($name == '' || mb_strlen($name, 'utf8') > 50)
        {
            return false;
        }
        $this->name = $name;
    }
    public function getproductContent(){
        return $this->content;
    }
    public function setproductContent($content)
    {
        if($content == '' || mb_strlen($content, 'utf8') > 500)
        {
            return false;
        }
        $this->content = $content;
    }
    public function getproductBig_pic(){
        return $this->big_pic;
    }
    public function setproductBig_pic($big_pic)
    {
        if($big_pic == '' || mb_strlen($big_pic, 'utf8') > 100)
        {
            return false;
        }
        $this->big_pic = $big_pic;
    }
    public function getproductSmall_pic(){
        return $this->small_pic;
    }
    public function setproductSmall_pic($small_pic)
    {
        if($small_pic == '' || mb_strlen($small_pic, 'utf8') > 100)
        {
            return false;
        }
        $this->small_pic = $small_pic;
    }
    
    
    public function getdays()
    {
        return $this->days;
    }
    public function setdays($days)
    {
        if(preg_match('/^\d{1,10}$/', $days == 0) || $days > 4294967295)
        {
            return false;
        }
        $this->days = $days;
    }
    
    public function getcounts()
    {
        return $this->counts;
    }
    public function setcounts($counts)
    {
        if(preg_match('/^\d{1,10}$/', $counts == 0) || $counts > 4294967295)
        {
            return false;
        }
        $this->counts = $counts;
    }
    
    public function getcost()
    {
        return $this->cost;
    }
    public function setcost($cost){
        if(preg_match('/^\d{1,10}$/', $cost == 0) || $cost > 4294967295)
        {
            return false;
        }
        $this->cost = $cost;
    }
    
    public function getrank(){
        return $this->rank;
    }
    public function setrank($rank)
    {
        if(preg_match('/^\d{1,10}$/', $rank == 0) || $rank > 4294967295)
        {
            return false;
        }
        $this->rank = $rank;
    }
    
    public function gettype(){
        return $this->type;
    }
    public function settype($type){
        if(preg_match('/^\d{1,10}$/', $type == 0) || $type > 4294967295)
        {
            return false;
        }
        $this->type = $type;
    }
    
    public function getcity(){
        return $this->city;
    }
    public function setcity($city)
    {
        if($city == '' || mb_strlen($city, 'utf8') > 50)
        {
            return false;
        }
        $this->city = $city;
    }
    public function getcreateTime(){
        return $this->createTime;
    }
    public function setcreateTime($createTime){
        if($createTime == '' || mb_strlen($createTime, 'utf8') > 50)
        {
            return false;
        }
        $this->createTime = $createTime;
    }
    public function getredeemCount()
    {
        return $this->redeemCount;
    }
    public function setredeemCount($redeemCount)
    {
        if(preg_match('/^\d{1,10}$/', $redeemCount == 0) || $redeemCount > 4294967295)
        {
            return false;
        }
        $this->redeemCount = $redeemCount;
    }
    public function del($id)
    {
        $rs = self::findFirst("id=".$id);

        if($rs->delete())
            return array("status"=>0, "info"=>"删除失败!");
    
    }
    public function edit($id,$data)
    {
        $id = intval($id);

        if(empty($data) || !$id) 
        {                    
            return array('status'=>1, 'info'=>'参数为空！');
        }
        
        $rs = self::findFirst($id);
        $rs->name = $data["name"];
        $rs->content = $data["content"];
        $rs->big_pic = $data["big_pic"];
        $rs->small_pic = $data["small_pic"];
        $rs->days = $data['days'];
        $rs->counts = $data['counts'];
        $rs->cost = $data['cost'];    
        $rs->rank = $data['rank'];
        $rs->type = $data['type'];
        $rs->city = $data['city'];
        $rs->redeemCount = $data['redeemCount'];


        if($rs->update()) 
            return array('status'=>0, 'info'=>'修改成功！');  
    
    }
    public function add($data)
    {
        if(empty($data)) 
        {                    
            return array('status'=>1, 'info'=>'参数为空！');
        }
        
        $rs = self::instance();
        $rs->name = $data["name"];
        $rs->content = $data["content"];
        $rs->big_pic = $data["big_pic"];
        $rs->small_pic = $data["small_pic"];
        $rs->days = $data['days'];
        $rs->counts = $data['counts'];
        $rs->cost = $data['cost'];    
        $rs->rank = $data['rank'];
        $rs->type = $data['type'];
        $rs->city = $data['city'];
        $rs->createTime = date("Y-m-d H:i:s");
        $rs->redeemCount = $data['redeemCount'];


        if($rs->create()) 
            return array('status'=>0, 'info'=>'修改成功！');  
    
    }


}