<?php
class VipLogDaily extends BaseModel
{
    public $ldId;
    public $vaId;
    public $realId;
    public $shopId = 0;
    public $comId;
    public $date;
    public $loginCount = 0;
    public $loginTime;
    public $logAndroid = 0;
    public $ldOP02 = 0;
    public $ldOP03 = 0;
    public $ldOP04 = 0;
    public $ldOP05 = 0;
    public $ldOP06 = 0;
    public $ldOP07 = 0;
    public $ldOP08 = 0;
    public $ldOP09 = 0;
    public $ldOP10 = 0;
    public $ldOP11 = 0;
    public $ldOP12 = 0;
    public $ldOP13 = 0;
    public $ldOP14 = 0;
    public $ldOP15 = 0;

    public function getLdId()
    {
        return $this->ldId;
    }

    public function setLdId($ldId)
    {
        if(preg_match('/^\d{1,10}$/', $ldId == 0) || $ldId > 4294967295)
        {
            return false;
        }
        $this->ldId = $ldId;
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

    public function getLdDate()
    {
        return $this->date;
    }

    public function setLdDate($ldDate)
    {
        $this->date = $ldDate;
    }

    public function getLdLoginCount()
    {
        return $this->loginCount;
    }

    public function setLdLoginCount($ldLoginCount)
    {
        if(preg_match('/^\d{1,10}$/', $ldLoginCount == 0) || $ldLoginCount > 4294967295)
        {
            return false;
        }
        $this->loginCount = $ldLoginCount;
    }

    public function getLdLoginTime()
    {
        return $this->loginTime;
    }

    public function setLdLoginTime($ldLoginTime)
    {
        if(preg_match('/^\d{4}-|\/\d{1,2}-|\/\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $ldLoginTime) == 0 || strtotime($ldLoginTime) == false)
        {
            return false;
        }
        $this->loginTime = $ldLoginTime;
    }

    public function getLogAndroid()
    {
        return $this->logAndroid;
    }

    public function setLogAndroid($logAndroid)
    {
        if(preg_match('/^\d{1,10}$/', $logAndroid == 0) || $logAndroid > 4294967295)
        {
            return false;
        }
        $this->logAndroid = $logAndroid;
    }

    public function getlogWeixin()
    {
        return $this->logWeixin;
    }

    public function setlogWeixin($ogWeixin)
    {
        if(preg_match('/^\d{1,10}$/', $ogWeixin == 0) || $ogWeixin > 4294967295)
        {
            return false;
        }
        $this->logWeixin = $ogWeixin;
    }

    public function getLdOP03()
    {
        return $this->ldOP03;
    }

    public function setLdOP03($ldOP03)
    {
        if(preg_match('/^\d{1,10}$/', $ldOP03 == 0) || $ldOP03 > 4294967295)
        {
            return false;
        }
        $this->ldOP03 = $ldOP03;
    }

    public function getLdOP04()
    {
        return $this->ldOP04;
    }

    public function setLdOP04($ldOP04)
    {
        if(preg_match('/^\d{1,10}$/', $ldOP04 == 0) || $ldOP04 > 4294967295)
        {
            return false;
        }
        $this->ldOP04 = $ldOP04;
    }

    public function getLdOP05()
    {
        return $this->ldOP05;
    }

    public function setLdOP05($ldOP05)
    {
        if(preg_match('/^\d{1,10}$/', $ldOP05 == 0) || $ldOP05 > 4294967295)
        {
            return false;
        }
        $this->ldOP05 = $ldOP05;
    }

    public function getLdOP06()
    {
        return $this->ldOP06;
    }

    public function setLdOP06($ldOP06)
    {
        if(preg_match('/^\d{1,10}$/', $ldOP06 == 0) || $ldOP06 > 4294967295)
        {
            return false;
        }
        $this->ldOP06 = $ldOP06;
    }

    public function getLdOP07()
    {
        return $this->ldOP07;
    }

    public function setLdOP07($ldOP07)
    {
        if(preg_match('/^\d{1,10}$/', $ldOP07 == 0) || $ldOP07 > 4294967295)
        {
            return false;
        }
        $this->ldOP07 = $ldOP07;
    }

    public function getLdOP08()
    {
        return $this->ldOP08;
    }

    public function setLdOP08($ldOP08)
    {
        if(preg_match('/^\d{1,10}$/', $ldOP08 == 0) || $ldOP08 > 4294967295)
        {
            return false;
        }
        $this->ldOP08 = $ldOP08;
    }

    public function getLdOP09()
    {
        return $this->ldOP09;
    }

    public function setLdOP09($ldOP09)
    {
        if(preg_match('/^\d{1,10}$/', $ldOP09 == 0) || $ldOP09 > 4294967295)
        {
            return false;
        }
        $this->ldOP09 = $ldOP09;
    }

    public function getLdOP10()
    {
        return $this->ldOP10;
    }

    public function setLdOP10($ldOP10)
    {
        if(preg_match('/^\d{1,10}$/', $ldOP10 == 0) || $ldOP10 > 4294967295)
        {
            return false;
        }
        $this->ldOP10 = $ldOP10;
    }

    public function getLdOP11()
    {
        return $this->ldOP11;
    }

    public function setLdOP11($ldOP11)
    {
        if(preg_match('/^\d{1,10}$/', $ldOP11 == 0) || $ldOP11 > 4294967295)
        {
            return false;
        }
        $this->ldOP11 = $ldOP11;
    }

    public function getLdOP12()
    {
        return $this->ldOP12;
    }

    public function setLdOP12($ldOP12)
    {
        if(preg_match('/^\d{1,10}$/', $ldOP12 == 0) || $ldOP12 > 4294967295)
        {
            return false;
        }
        $this->ldOP12 = $ldOP12;
    }

    public function getLdOP13()
    {
        return $this->ldOP13;
    }

    public function setLdOP13($ldOP13)
    {
        if(preg_match('/^\d{1,10}$/', $ldOP13 == 0) || $ldOP13 > 4294967295)
        {
            return false;
        }
        $this->ldOP13 = $ldOP13;
    }

    public function getLdOP14()
    {
        return $this->ldOP14;
    }

    public function setLdOP14($ldOP14)
    {
        if(preg_match('/^\d{1,10}$/', $ldOP14 == 0) || $ldOP14 > 4294967295)
        {
            return false;
        }
        $this->ldOP14 = $ldOP14;
    }

    public function getLdOP15()
    {
        return $this->ldOP15;
    }

    public function setLdOP15($ldOP15)
    {
        if(preg_match('/^\d{1,10}$/', $ldOP15 == 0) || $ldOP15 > 4294967295)
        {
            return false;
        }
        $this->ldOP15 = $ldOP15;
    }

    public function getSource()
    {
        return 'vip_log_daily';
    }

    public function columnMap()
    {
        return array(
            'ldId' => 'ldId',
            'vaId' => 'vaId',
            'realId' => 'realId',
            'shopId' => 'shopId',
            'comId' => 'comId',
            'ldDate' => 'date',
            'ldLoginCount' => 'loginCount',
            'ldLoginTime' => 'loginTime',
            'ldOP01' => 'logAndroid',//安卓登录日志
            'ldOP02' => 'logWeixin',   //微信登录日志
            'ldOP03' => 'ldOP03',
            'ldOP04' => 'ldOP04',
            'ldOP05' => 'ldOP05',
            'ldOP06' => 'ldOP06',
            'ldOP07' => 'ldOP07',
            'ldOP08' => 'ldOP08',
            'ldOP09' => 'ldOP09',
            'ldOP10' => 'ldOP10',
            'ldOP11' => 'ldOP11',
            'ldOP12' => 'ldOP12',
            'ldOP13' => 'ldOP13',
            'ldOP14' => 'ldOP14',
            'ldOP15' => 'ldOP15'
        );
    }


    public function initialize()
    {
        $this->setReadConnectionService('esfSlave');
        $this->setWriteConnectionService('esfMaster');
    }
}