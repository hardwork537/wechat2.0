<?php
class VipScoreDetail extends BaseModel
{
	const PROJECT_LOGIN = 1; //日常登陆
	const PROJECT_NO_ILLEGAL_UNIT = 2; //无违规房源
	const PROJECT_HOUSE_COMMENT = 3; //小区评论
	const PROJECT_PAY_PORT = 4; //购买付费端口
	//const PROJECT_PRODUCT_UNIT = 5; //置业专家房源产品
	//const PROJECT_PRODUCT_FACE = 6; //置业专家头像产品
	const PROJECT_CONTRIBUTION = 7; //贡献奖励
	const PROJECT_ILLEGAL_UNIT = 8; //违规房源
	const PROJECT_ILLEGAL_HOUSE_COMMENT = 9; //违规小区评论
	const PROJECT_PAST_PASSPORT = 10; //过期帐号
	const PROJECT_OTHER_ILLEGAL = 11; //其他违规
	const PROJECT_IMAGE_PROVIDER = 12; //小区标库,通过一张图片奖励10积分
	const PROJECT_CONSUME = 13; //消费
	const PROJECT_HOUSE_AUTH = 14; //真房源认证
	const PROJECT_APP_LOGIN = 15; //手机APP摇一摇(签到)送积分
    const PROJECT_EDIT = 16;//手动调整积分
	
	const SORT_DAY = 1; //日常类
	const SORT_BSIS = 2; //商务类
	const SORT_ADD = 3; //加分类
	const SORT_REDUCE = 4; //减分
	const SORT_CONSUME = 5; //消费类
	
	const Transactor_APP = 'APP';
	
	public $scoreId;
	public $type;
	public $sortId;
	public $count;
	public $desc;
	public $time;
	public $transactor;
	public $ip;
	public $realId;
	public $cityId;
    private $strTabName =  'vip_score_';
	
	public function getId()
	{
		return $this->$scoreId;
	}
	
	public function setId($ScoreId)
	{
		if(preg_match('/^\d{1,10}$/', $ScoreId == 0) || $ScoreId > 4294967295)
		{
			return false;
		}
		$this->scoreId = $ScoreId;
	}
	
	public function getType()
	{
		return $this->type;
	}
	
	public function setType($Type)
	{
		$this->type = $Type;
	}
	
	public function getSortId()
	{
		return $this->sortId;
	}
	
	public function setSortId($SortId)
	{
		$this->sortId = $SortId;
	}
	
/*	public function getCount()
	{
		return $this->count;
	}
	
	public function setCount($Count)
	{
		$this->count = $Count;
	}
	*/
	public function getDesc()
	{
		return $this->desc;
	}
	
	public function setDesc($Desc)
	{
		$this->desc = $Desc;
	}
	
	public function getTime()
	{
		return $this->time;
	}
	
	public function setTime($Time)
	{
		$this->time = $Time;
	}
	
	public function getTransactor()
	{
		return $this->transactor;
	}
	
	public function setTransactor($Transactor)
	{
		$this->transactor = $Transactor;
	}
	
	public function getIp()
	{
		return $this->ip;
	}
	
	public function setIp($Ip)
	{
		$this->ip = $Ip;
	}
	
	public function getRealId()
	{
		return $this->realId;
	}
	
	public function setRealId($RealId)
	{
		$this->realId = $RealId;
	}
	
	public function getCityId()
	{
		return $this->cityId;
	}
	
	public function setCityId($CityId)
	{
		$this->cityId = $CityId;
	}

    public function getSource()
    {
        if( strlen($this->strTabName) == 10 )
            return $this->strTabName.date('Ym');
        else
            return $this->strTabName;
    }
    public function setSource($strDate)
    {
        $this->strTabName = 'vip_score_'.$strDate;
    }
	
	public function columnMap()
	{
		return array(
				'scoreId' => 'scoreId',
				'scoreType' => 'type',
				'sortId' => 'sortId',
				'scoreCount' => 'count',
				'scoreDesc' => 'desc',
				'scoreTime' => 'time',
				'scoreTransactor' => 'transactor',
				'scoreIp' => 'ip',
				'realId' => 'realId',
				'cityId' => 'cityId',
		);
	}
	
	public function initialize()
	{
		$this->setReadConnectionService('esfSlave');
		$this->setWriteConnectionService('esfMaster');
	}

    /**
     * 实例化
     * @param type $cache
     * @return Sale_Model
     */

    public static function instance($cache = true)
    {
        return parent::_instance(__CLASS__, $cache);
        return new self;
    }

	
	/**
	 * 添加积分
	 * @param array $arrData
	 * @return boolean
	 */
	public function AddScoreDetail( $arrData )
	{
		if ( empty($arrData) ) return false;
		
		$arrInsert = array();
		if ( isset($arrData['scoreType']) )
		{
			$arrInsert['type'] = $arrData['scoreType'];
		}
		
		if ( isset($arrData['sortId']) )
		{
			$arrInsert['sortId'] = $arrData['sortId'];
		}
		
		if ( isset($arrData['scoreCount']) )
		{
			$arrInsert['count'] = $arrData['scoreCount'];
		}
		
		if ( isset($arrData['scoreDesc']) )
		{
			$arrInsert['desc'] = $arrData['scoreDesc'];
		}
		
		if ( isset($arrData['scoreTransactor']) )
		{
			$arrInsert['transactor'] = $arrData['scoreTransactor'];
		}
		
		if ( isset($arrData['realId']) )
		{
			$arrInsert['realId'] = $arrData['realId'];
		}
		
		if ( isset($arrData['cityId']) ) {
			$arrInsert['cityId'] = $arrData['cityId'];
		}
		
		$arrInsert['ip'] = Utility::GetUserIP();
		$arrInsert['time'] = date('Y-m-d H:i:s');
		
		return self::create($arrInsert);
	}

    /**
     * 积分等级
     *
     * @param int $intIntegral
     * @return int
     */
    public  function BrokerRank($intIntegral) {
        if ( $intIntegral >= 0 && $intIntegral < 500 ) {
            return array('rank' => 1, 'icon' => 'intger1.gif', 'medal' => '银牌经纪人', 'next_level' => 500-$intIntegral);
        } elseif ( $intIntegral >= 500 && $intIntegral < 1000 ) {
            return array('rank' => 2, 'icon' => 'intger1.gif', 'medal' => '银牌经纪人', 'next_level' => 1000-$intIntegral);
        } elseif ( $intIntegral >= 1000 && $intIntegral < 2000 ) {
            return array('rank' => 3, 'icon' => 'intger1.gif', 'medal' => '银牌经纪人', 'next_level' => 2000-$intIntegral);
        } elseif ( $intIntegral >= 2000 && $intIntegral < 4000 ) {
            return array('rank' => 4, 'icon' => 'intger1.gif', 'medal' => '银牌经纪人', 'next_level' => 4000-$intIntegral);
        } elseif ( $intIntegral >= 4000 && $intIntegral < 8000 ) {
            return array('rank' => 5, 'icon' => 'intger1.gif', 'medal' => '银牌经纪人', 'next_level' => 8000-$intIntegral);
        } elseif ( $intIntegral >= 8000 && $intIntegral < 15000 ) {
            return array('rank' => 6, 'icon' => 'intger2.gif', 'medal' => '金牌经纪人', 'next_level' => 15000-$intIntegral);
        } elseif ( $intIntegral >= 15000 && $intIntegral < 25000 ) {
            return array('rank' => 7, 'icon' => 'intger2.gif', 'medal' => '金牌经纪人', 'next_level' => 25000-$intIntegral);
        } elseif ( $intIntegral >= 25000 && $intIntegral < 35000 ) {
            return array('rank' => 8, 'icon' => 'intger2.gif', 'medal' => '金牌经纪人', 'next_level' => 35000-$intIntegral);
        } elseif ( $intIntegral >= 35000 && $intIntegral < 50000 ) {
            return array('rank' => 9, 'icon' => 'intger2.gif', 'medal' => '金牌经纪人', 'next_level' => 50000-$intIntegral);
        } elseif ( $intIntegral >= 50000 && $intIntegral < 65000 ) {
            return array('rank' => 10, 'icon' => 'intger2.gif', 'medal' => '金牌经纪人', 'next_level' => 65000-$intIntegral);
        } elseif ( $intIntegral >= 65000 && $intIntegral < 80000 ) {
            return array('rank' => 11, 'icon' => 'intger3.gif', 'medal' => '钻石经纪人', 'next_level' => 80000-$intIntegral);
        } elseif ( $intIntegral >= 80000 && $intIntegral < 100000 ) {
            return array('rank' => 12, 'icon' => 'intger3.gif', 'medal' => '钻石经纪人', 'next_level' => 100000-$intIntegral);
        } elseif ( $intIntegral >= 100000 && $intIntegral < 150000 ) {
            return array('rank' => 13, 'icon' => 'intger3.gif', 'medal' => '钻石经纪人', 'next_level' => 150000-$intIntegral);
        } elseif ( $intIntegral >= 150000 && $intIntegral < 250000 ) {
            return array('rank' => 14, 'icon' => 'intger3.gif', 'medal' => '钻石经纪人', 'next_level' => 250000-$intIntegral);
        } elseif ( $intIntegral >= 250000 && $intIntegral < 350000 ) {
            return array('rank' => 15, 'icon' => 'intger3.gif', 'medal' => '钻石经纪人', 'next_level' => 350000-$intIntegral);
        } elseif ( $intIntegral >= 350000 && $intIntegral < 500000 ) {
            return array('rank' => 16, 'icon' => 'intger4.gif', 'medal' => '皇冠经纪人', 'next_level' => 500000-$intIntegral);
        } elseif ( $intIntegral >= 500000 && $intIntegral < 650000 ) {
            return array('rank' => 17, 'icon' => 'intger4.gif', 'medal' => '皇冠经纪人', 'next_level' => 650000-$intIntegral);
        } elseif ( $intIntegral >= 650000 && $intIntegral < 800000 ) {
            return array('rank' => 18, 'icon' => 'intger4.gif', 'medal' => '皇冠经纪人', 'next_level' => 800000-$intIntegral);
        } elseif ( $intIntegral >= 800000 && $intIntegral < 1000000 ) {
            return array('rank' => 19, 'icon' => 'intger4.gif', 'medal' => '皇冠经纪人', 'next_level' => 1000000-$intIntegral);
        } elseif ( $intIntegral >= 1000000 ) {
            return array('rank' => 20, 'icon' => 'intger4.gif', 'medal' => '皇冠经纪人', 'next_level' => 0);
        }
    }

    //跨一个月查找积分排名
    public function  getScoreTwoMonth( $con, $startMonth, $endMonth){
        $con = str_replace("time", "scoreTime",  $con);
        $sql = "SELECT SUM(scoreCount)as num ,realId FROM (SELECT * from vip_score_".$startMonth." where $con UNION ALL SELECT * from vip_score_".$endMonth." where $con) t GROUP BY realId ORDER BY num desc, realId desc ";
        $rs = $this->fetchAll($sql);
        return $rs;
    }
    //根据用户id获取7天积分排名
    public function getScoreRankByUserid($userId){
        if (!$userId) return array();
        $time = date("Y-m-d", time()-86400*7)." 00:00:00";
        $startMonth = date("Ym", time()-86400*7);
        $endMonth = date("Ym", time());
        $con = " sortId !=".self::SORT_CONSUME." AND  time>'{$time}'";
        if($startMonth != $endMonth){
            $rs = $this->getScoreTwoMonth($con, $startMonth, $endMonth);
        }else{
            $isExit = $this->findFirst($con." AND realId=$userId", 0)->toArray();
            if(empty($isExit)){
                return 0;
            }
            $rs = $this->find(array("conditions" => $con,
                    'order'=> 'num desc, realId desc',
                    'group'=> 'realId',
                    "columns"=>"SUM(count)as num ,realId ")
            )->toArray();
        }
        $result = 0;
        if($rs){
            $i = 1;
            foreach($rs as $v){
                if($v['realId']== $userId){
                    $result = $i;
                    break;
                }else{
                    $result= $i;
                }
                $i++;
            }
        }
        return $result;
    }

    //手动调整积分
    public function updateScore($data){
        $this->begin();
        $rs = $this->AddScoreDetail($data);
        if($rs){
            $accountScore = VipAccount::instance()->updateRealtorScore($data['realId'],$data['scoreCount'], $data['sortId']);
            if($accountScore){
                $this->commit();
                return TRUE;
            }
        }
        $this->rollback();
        return FALSE;
    }

}