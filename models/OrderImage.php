<?php
class OrderImage extends BaseModel
{
	public $id;
	public $orderId;
	public $data;
	public $hash;
	public $time;

	public function columnMap()
	{
		return array(
				'oiId' => 'id',
				'orderId' => 'orderId',
				'oiData' => 'data',
				'oiHash' => 'hash',
				'oiTime' => 'time',
		);
	}

    public function initialize()
    {
        $this->setConn("esf");
    }

    /**
     * 实例化
     * @param type $cache
     * @return Order_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }

	/**
	 * 展示图片
	 */
	public function showImage( $intOrderId)
	{
		$arrOrderImg = self::findFirst(" orderId = $intOrderId")->toArray();
		$image = $arrOrderImg['data'];
		$image = base64_decode($image);
		header("Content-Type:image/pjpeg");
		echo $image;
		exit;
	}

	/**
	 * 添加图片
	 */
	public function add($orderId,$file)
	{
		$rs = $this;
		$rs->orderId = $orderId;
		$rs->data = base64_encode(file_get_contents($file));
		$rs->hash = hash("md5",$rs->data);
		$rs->time = date("Y-m-d H:i:s");
		return $rs->save();
	}

	/**
	 * 修改图片
	 */
	public function edit($orderId,$file)
	{
		$rs = self::findFirst("orderId='{$orderId}'");
		if($rs){
                    $rs->data = base64_encode(file_get_contents($file));
                    $rs->hash = hash("md5",$rs->data);
                    $rs->time = date("Y-m-d H:i:s");
                    return $rs->update();
                }else{
                    $this->add($orderId,$file);
                }
	}
}