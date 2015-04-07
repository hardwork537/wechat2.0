<?php
class PortCharge extends BaseModel
{
    protected $id;
    protected $cityId;
    protected $comId;
    protected $type;
    protected $numMin;
    protected $numMax;
    protected $perPrice;
    protected $status;
    protected $pcUpdate;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if(preg_match('/^\d{1,10}$/', $id == 0) || $id > 4294967295)
        {
            return false;
        }
        $this->id = $id;
    }

    public function getCityId()
    {
        return $this->cityId;
    }

    public function setCityId($cityId)
    {
        if(preg_match('/^\d{1,10}$/', $cityId == 0) || $cityId > 4294967295)
        {
            return false;
        }
        $this->cityId = $cityId;
    }

    public function getComId()
    {
        return $this->comId;
    }

    public function setComId($comId)
    {
        if(preg_match('/^\d{1,10}$/', $comId == 0) || $comId > 4294967295)
        {
            return false;
        }
        $this->comId = $comId;
    }

    public function getPrice()
    {
        return $this->perPrice;
    }

    public function setPrice($perPrice)
    {
        if(preg_match('/^\d{1,10}$/', $perPrice == 0) || $perPrice > 4294967295)
        {
            return false;
        }
        $this->perPrice = $perPrice;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        if(preg_match('/^-?\d{1,3}$/', $status) == 0 || $status > 127 || $status < -128)
        {
            return false;
        }
        $this->status = $status;
    }

    public function getUpdate()
    {
        return $this->pcUpdate;
    }

    public function setUpdate($pcUpdate)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $pcUpdate) == 0 || strtotime($pcUpdate) == false)
        {
            return false;
        }
        $this->pcUpdate = $pcUpdate;
    }

    public function getSource()
    {
        return 'port_charge';
    }

    public function columnMap()
    {
        return array(
            'pcId' => 'id',
            'cityId' => 'cityId',
            'comId' => 'comId',
            'pcType' => 'type',
            'pcNumMin' => 'numMin',
            'pcNumMax' => 'numMax',
            'pcPerPrice' => 'perPrice',
            'pcStatus' => 'status',
            'pcUpdate' => 'pcUpdate'//不要改成update以免影响sql解析
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }

	/**
	* 获取某城市某公司的全部的端口价格（不同天）
	*/
	public function getAllPriceByCompany($intCity, $intCompany)
	{
		$newArr = array();
		$condition[] = 'cityId='.$intCity;
		$condition[] = 'comId='.$intCompany;
		$nowTime = strtotime(date("Y-m",time()));
		$condition[] = "pcUpdate>='".date("Y-m",strtotime("-1 month",$nowTime))."'";
		$arr = $this->getAll($condition);
		if(!empty($arr))
		{
			foreach($arr as $key=>$val)
			{
				$newArr[$val['cityId']][$val['comId']][$val['type']][date("Y-m-d", strtotime($val['pcUpdate']))] = $val['perPrice'];
			}
		}
		return $newArr;
	}
}