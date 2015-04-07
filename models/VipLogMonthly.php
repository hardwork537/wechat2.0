<?php
class VipLogMonthly extends BaseModel
{
    protected $lmId;
    protected $vaId;
    protected $realId;
    protected $shopId;
    protected $comId;
    protected $lmMonth;
    protected $lmLoginCount;
    protected $lmLoginTime;
    protected $lmOP01;
    protected $lmOP02;
    protected $lmOP03;
    protected $lmOP04;
    protected $lmOP05;
    protected $lmOP06;
    protected $lmOP07;
    protected $lmOP08;
    protected $lmOP09;
    protected $lmOP10;
    protected $lmOP11;
    protected $lmOP12;
    protected $lmOP13;
    protected $lmOP14;
    protected $lmOP15;

    public function getLmId()
    {
        return $this->lmId;
    }

    public function setLmId($lmId)
    {
        if(preg_match('/^\d{1,10}$/', $lmId == 0) || $lmId > 4294967295)
        {
            return false;
        }
        $this->lmId = $lmId;
    }

    public function getVaId()
    {
        return $this->vaId;
    }

    public function setVaId($vaId)
    {
        if(preg_match('/^\d{1,10}$/', $vaId == 0) || $vaId > 4294967295)
        {
            return false;
        }
        $this->vaId = $vaId;
    }

    public function getRealId()
    {
        return $this->realId;
    }

    public function setRealId($realId)
    {
        if(preg_match('/^\d{1,10}$/', $realId == 0) || $realId > 4294967295)
        {
            return false;
        }
        $this->realId = $realId;
    }

    public function getShopId()
    {
        return $this->shopId;
    }

    public function setShopId($shopId)
    {
        if(preg_match('/^\d{1,10}$/', $shopId == 0) || $shopId > 4294967295)
        {
            return false;
        }
        $this->shopId = $shopId;
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

    public function getLmMonth()
    {
        return $this->lmMonth;
    }

    public function setLmMonth($lmMonth)
    {
        if(preg_match('/^\d{1,5}$/', $lmMonth == 0) || $lmMonth > 65535)
        {
            return false;
        }
        $this->lmMonth = $lmMonth;
    }

    public function getLmLoginCount()
    {
        return $this->lmLoginCount;
    }

    public function setLmLoginCount($lmLoginCount)
    {
        if(preg_match('/^\d{1,10}$/', $lmLoginCount == 0) || $lmLoginCount > 4294967295)
        {
            return false;
        }
        $this->lmLoginCount = $lmLoginCount;
    }

    public function getLmLoginTime()
    {
        return $this->lmLoginTime;
    }

    public function setLmLoginTime($lmLoginTime)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $lmLoginTime) == 0 || strtotime($lmLoginTime) == false)
        {
            return false;
        }
        $this->lmLoginTime = $lmLoginTime;
    }

    public function getLmOP01()
    {
        return $this->lmOP01;
    }

    public function setLmOP01($lmOP01)
    {
        if(preg_match('/^\d{1,10}$/', $lmOP01 == 0) || $lmOP01 > 4294967295)
        {
            return false;
        }
        $this->lmOP01 = $lmOP01;
    }

    public function getLmOP02()
    {
        return $this->lmOP02;
    }

    public function setLmOP02($lmOP02)
    {
        if(preg_match('/^\d{1,10}$/', $lmOP02 == 0) || $lmOP02 > 4294967295)
        {
            return false;
        }
        $this->lmOP02 = $lmOP02;
    }

    public function getLmOP03()
    {
        return $this->lmOP03;
    }

    public function setLmOP03($lmOP03)
    {
        if(preg_match('/^\d{1,10}$/', $lmOP03 == 0) || $lmOP03 > 4294967295)
        {
            return false;
        }
        $this->lmOP03 = $lmOP03;
    }

    public function getLmOP04()
    {
        return $this->lmOP04;
    }

    public function setLmOP04($lmOP04)
    {
        if(preg_match('/^\d{1,10}$/', $lmOP04 == 0) || $lmOP04 > 4294967295)
        {
            return false;
        }
        $this->lmOP04 = $lmOP04;
    }

    public function getLmOP05()
    {
        return $this->lmOP05;
    }

    public function setLmOP05($lmOP05)
    {
        if(preg_match('/^\d{1,10}$/', $lmOP05 == 0) || $lmOP05 > 4294967295)
        {
            return false;
        }
        $this->lmOP05 = $lmOP05;
    }

    public function getLmOP06()
    {
        return $this->lmOP06;
    }

    public function setLmOP06($lmOP06)
    {
        if(preg_match('/^\d{1,10}$/', $lmOP06 == 0) || $lmOP06 > 4294967295)
        {
            return false;
        }
        $this->lmOP06 = $lmOP06;
    }

    public function getLmOP07()
    {
        return $this->lmOP07;
    }

    public function setLmOP07($lmOP07)
    {
        if(preg_match('/^\d{1,10}$/', $lmOP07 == 0) || $lmOP07 > 4294967295)
        {
            return false;
        }
        $this->lmOP07 = $lmOP07;
    }

    public function getLmOP08()
    {
        return $this->lmOP08;
    }

    public function setLmOP08($lmOP08)
    {
        if(preg_match('/^\d{1,10}$/', $lmOP08 == 0) || $lmOP08 > 4294967295)
        {
            return false;
        }
        $this->lmOP08 = $lmOP08;
    }

    public function getLmOP09()
    {
        return $this->lmOP09;
    }

    public function setLmOP09($lmOP09)
    {
        if(preg_match('/^\d{1,10}$/', $lmOP09 == 0) || $lmOP09 > 4294967295)
        {
            return false;
        }
        $this->lmOP09 = $lmOP09;
    }

    public function getLmOP10()
    {
        return $this->lmOP10;
    }

    public function setLmOP10($lmOP10)
    {
        if(preg_match('/^\d{1,10}$/', $lmOP10 == 0) || $lmOP10 > 4294967295)
        {
            return false;
        }
        $this->lmOP10 = $lmOP10;
    }

    public function getLmOP11()
    {
        return $this->lmOP11;
    }

    public function setLmOP11($lmOP11)
    {
        if(preg_match('/^\d{1,10}$/', $lmOP11 == 0) || $lmOP11 > 4294967295)
        {
            return false;
        }
        $this->lmOP11 = $lmOP11;
    }

    public function getLmOP12()
    {
        return $this->lmOP12;
    }

    public function setLmOP12($lmOP12)
    {
        if(preg_match('/^\d{1,10}$/', $lmOP12 == 0) || $lmOP12 > 4294967295)
        {
            return false;
        }
        $this->lmOP12 = $lmOP12;
    }

    public function getLmOP13()
    {
        return $this->lmOP13;
    }

    public function setLmOP13($lmOP13)
    {
        if(preg_match('/^\d{1,10}$/', $lmOP13 == 0) || $lmOP13 > 4294967295)
        {
            return false;
        }
        $this->lmOP13 = $lmOP13;
    }

    public function getLmOP14()
    {
        return $this->lmOP14;
    }

    public function setLmOP14($lmOP14)
    {
        if(preg_match('/^\d{1,10}$/', $lmOP14 == 0) || $lmOP14 > 4294967295)
        {
            return false;
        }
        $this->lmOP14 = $lmOP14;
    }

    public function getLmOP15()
    {
        return $this->lmOP15;
    }

    public function setLmOP15($lmOP15)
    {
        if(preg_match('/^\d{1,10}$/', $lmOP15 == 0) || $lmOP15 > 4294967295)
        {
            return false;
        }
        $this->lmOP15 = $lmOP15;
    }

    public function getSource()
    {
        return 'vip_log_monthly';
    }

    public function columnMap()
    {
        return array(
            'lmId' => 'lmId',
            'vaId' => 'vaId',
            'realId' => 'realId',
            'shopId' => 'shopId',
            'comId' => 'comId',
            'lmMonth' => 'lmMonth',
            'lmLoginCount' => 'lmLoginCount',
            'lmLoginTime' => 'lmLoginTime',
            'lmOP01' => 'lmOP01',
            'lmOP02' => 'lmOP02',
            'lmOP03' => 'lmOP03',
            'lmOP04' => 'lmOP04',
            'lmOP05' => 'lmOP05',
            'lmOP06' => 'lmOP06',
            'lmOP07' => 'lmOP07',
            'lmOP08' => 'lmOP08',
            'lmOP09' => 'lmOP09',
            'lmOP10' => 'lmOP10',
            'lmOP11' => 'lmOP11',
            'lmOP12' => 'lmOP12',
            'lmOP13' => 'lmOP13',
            'lmOP14' => 'lmOP14',
            'lmOP15' => 'lmOP15'
        );
    }

    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
}