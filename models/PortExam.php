<?php
/**
 * @abstract 端口使用管检测表
 * @author litingwei litingwei@sohu-inc.com
 * @since  2014年9月15日16:24:21
 */
class PortExam extends BaseModel
{
	const PUBLIC_EXAM_DEFAULT = 2;//今日发布房源 考核数量默认值publish_exam
	const FAILURE_EXAM_DEFAULT = 0;//违规房源 考核数量默认值weigui_exam 此值用户不可以修改
	
	public $realId;
	public $publish;
	public $fresh;
	public $published;
	public $tag;
	public $fine;
	public $picture;
	public $failure;
	public $publishRes;
	public $freshRes;
	public $publishedRes;
	public $tagRes;
	public $fineRes;
	public $pictureRes;
	public $failureRes;
	public $examTime;
	public $useStat;

	public function getError()
	{
		return $this->error;
	}
	
	public function setError($strError)
	{
		$this->error = $strError;
	}
	
	public function columnMap()
	{
		return array(
				'realId' => 'realId',
				'pePublish' => 'publish',
				'peFresh' => 'fresh',
				'pePublished' => 'published',
				'peTag' => 'tag',
				'peFine' => 'fine',
				'pePicture' => 'picture',
				'peFailure' => 'failure',
				'pePublishRes' => 'publishRes',
				'peFreshRes' => 'freshRes',
				'pePublishedRes' => 'publishedRes',
				'peTagRes' => 'tagRes',		
				'peFineRes' => 'fineRes',
				'pePictureRes' => 'pictureRes',
				'peFailureRes' => 'failureRes',
				'peExamTime' => 'examTime',
				'peUseStat' => 'useStat',
		);
	}

	public function initialize()
	{
		$this->setReadConnectionService('esfSlave');
		$this->setWriteConnectionService('esfMaster');
	}
	
	/**
	 * 根据经纪人id获取信息数值
	 *
	 * @param int $realId
	 * @return array
	 */
	public function getExamById($realId)
	{
		$realId = intval($realId);
		if($realId <= 0)
		{
			$this->error = '经纪人id为空';
			return array();
		}
		$arrPortExam = self::getOne(" realId = $realId");
		if(!empty($arrPortExam))
		{
			if($arrPortExam['examTime'] != 0)
			{//（或凌晨清空结果，或停用账户清空检测数据），没有检测结果时，则合计不计算
				$arrPortExam['examTotal'] = $this->getExamTotal($arrPortExam);
				$arrPortExam['examTotalClass'] = $this->getExamTotalClass($arrPortExam['examTotal']);
				$arrPortExam['examTime'] = date('Y-m-d H:i', strtotime($arrPortExam['examTime']));
			}
		}
		return $arrPortExam;
	}
	
	/**
	 * 获取考核总和
	 *
	 * @param array $arrPortExam
	 * @return int
	 */
	public function getExamTotal(array $arrPortExam)
	{
		$intExamTotal = 0;
		$arrExamStand = self::getExamScoreStand();
		if($arrPortExam['publishRes'] >= $arrPortExam['publish'])
		{
			$intExamTotal += $arrExamStand['publish_stand'];
		}
		if($arrPortExam['freshRes'] >= $arrPortExam['fresh'])
		{
			$intExamTotal += $arrExamStand['fresh_stand'];
		}
		if($arrPortExam['publishedRes'] >= $arrPortExam['published'])
		{
			$intExamTotal += $arrExamStand['published_stand'];
		}
		if($arrPortExam['tagRes'] >= $arrPortExam['tag'])
		{
			$intExamTotal += $arrExamStand['tag_stand'];
		}
		if($arrPortExam['fineRes'] >= $arrPortExam['fine'])
		{
			$intExamTotal += $arrExamStand['fine_stand'];
		}
		if($arrPortExam['pictureRes'] >= $arrPortExam['picture'])
		{
			$intExamTotal += $arrExamStand['picture_stand'];
		}
		if($arrPortExam['failureRes'] == $arrPortExam['failure'])
		{
			$intExamTotal += $arrExamStand['failure_stand'];
		}
		return $intExamTotal;
	}
	
	/**
	 * 得分满分标准值
	 *
	 * @return array
	 */
	public static function getExamScoreStand(){
		return array(
				'publish_stand' => 20,
				'fresh_stand' => 20,
				'published_stand' => 10,
				'tag_stand' => 10,
				'fine_stand' => 10,
				'picture_stand' => 20,
				'failure_stand' => 10,
		);
	}
	
	/**
	 * 获取考核结果对应的颜色样式
	 *
	 * @param int $exam_total
	 * @return string
	 */
	public function getExamTotalClass($exam_total){
		$exam_total_class = 'red';//elseif ($exam_total <= 60){
		if($exam_total == 100){
			$exam_total_class = 'gre';
		}elseif($exam_total < 100 && $exam_total >= 70){
			$exam_total_class = 'orange';
		}
		return $exam_total_class;
	}
	
	/**
	 * 获取考核数量默认值
	 *
	 * @return array
	 */
	public static function getExamDefault($arrRealtorInfo)
	{
		
		if($arrRealtorInfo['pcType'] == '10'){
			return array(
					'publish' => PortExam::PUBLIC_EXAM_DEFAULT,
					'fresh' => intval($arrRealtorInfo['opEsfRefresh']),
					'published' => intval($arrRealtorInfo['opEsfRelease']),
					'tag' => intval($arrRealtorInfo['opEsfTags']),
					'fine' => intval($arrRealtorInfo['opEsfBold']),
					'picture' => intval($arrRealtorInfo['opEsfRelease']),
					'failure' => PortExam::FAILURE_EXAM_DEFAULT,
			);
		}else{
			return array(
					'publish' => PortExam::PUBLIC_EXAM_DEFAULT,
					'fresh' => intval($arrRealtorInfo['opRentRefresh']),
					'published' => intval($arrRealtorInfo['opRentRelease']),
					'tag' => intval($arrRealtorInfo['opRentTags']),
					'fine' => intval($arrRealtorInfo['opRentBold']),
					'picture' => intval($arrRealtorInfo['opRentRelease']),
					'failure' => PortExam::FAILURE_EXAM_DEFAULT,
			);
		}
	}
	
	/**
	 * 获取考核结果的不合格项总数
	 *
	 * @param array $arrPortExam
	 * @return int
	 */
	public function getExamFailNum(array $arrPortExam){
		$intFailNum = 0;
		if($arrPortExam['publishRes'] < $arrPortExam['publish']){
			$intFailNum++;
		}
		if($arrPortExam['freshRes'] < $arrPortExam['fresh']){
			$intFailNum++;
		}
		if($arrPortExam['publishedRes'] < $arrPortExam['published']){
			$intFailNum++;
		}
		if($arrPortExam['tagRes'] < $arrPortExam['tag']){
			$intFailNum++;
		}
		if($arrPortExam['fineRes'] < $arrPortExam['fine']){
			$intFailNum++;
		}
		if($arrPortExam['pictureRes'] < $arrPortExam['picture']){
			$intFailNum++;
		}
		if($arrPortExam['failureRes'] > $arrPortExam['failure']){
			$intFailNum++;
		}
		return $intFailNum;
	}
	
	
	/**
	 * 查看端口检测详情
	 *
	 * @param array $arrRealtorInfo
	 * @return array
	 */
	public function showExamByBrokerId($arrRealtorInfo)
	{
		$realId = $arrRealtorInfo['id'];
		$arrPortExam = $this->getExamById($realId);
		$arrScoreStand = self::getExamScoreStand();//满分标准
		if (empty($arrPortExam))
		{
			$arrPortExam = self::getExamDefault($arrRealtorInfo);
		}
		elseif(!empty($arrPortExam['examTime']))
		{//没有检测结束信息时（1只保存考核数量；2凌晨清空检测结果；3停用账户清空检测数据）
			$arrPortExam['publish_score'] = 0;
			$arrPortExam['fresh_score'] = 0;
			$arrPortExam['published_score'] = 0;
			$arrPortExam['tag_score'] = 0;
			$arrPortExam['fine_score'] = 0;
			$arrPortExam['picture_score'] = 0;
			$arrPortExam['failure_score'] = 0;
			$arrPortExam['score_total'] = 0;//得分总和
			if($arrPortExam['publishRes'] >= $arrPortExam['publish']){
				$arrPortExam['publish_score'] = $arrScoreStand['publish_stand'];
				$arrPortExam['score_total'] += $arrScoreStand['publish_stand'];
			}else{
				$arrPortExam['publish_res_class'] = 'red';
			}
			if($arrPortExam['freshRes'] >= $arrPortExam['fresh']){
				$arrPortExam['fresh_score'] = $arrScoreStand['fresh_stand'];
				$arrPortExam['score_total'] += $arrScoreStand['fresh_stand'];
			}else{
				$arrPortExam['fresh_res_class'] = 'red';
			}
			if($arrPortExam['publishedRes'] >= $arrPortExam['published']){
				$arrPortExam['published_score'] = $arrScoreStand['published_stand'];
				$arrPortExam['score_total'] += $arrScoreStand['published_stand'];
			}else{
				$arrPortExam['published_res_class'] = 'red';
			}
			if($arrPortExam['tagRes'] >= $arrPortExam['tag']){
				$arrPortExam['tag_score'] = $arrScoreStand['tag_stand'];
				$arrPortExam['score_total'] += $arrScoreStand['tag_stand'];
			}else{
				$arrPortExam['tag_res_class'] = 'red';
			}
			if($arrPortExam['fineRes'] >= $arrPortExam['fine']){
				$arrPortExam['fine_score'] = $arrScoreStand['fine_stand'];
				$arrPortExam['score_total'] += $arrScoreStand['fine_stand'];
			}else{
				$arrPortExam['fine_res_class'] = 'red';
			}
			if($arrPortExam['pictureRes'] >= $arrPortExam['picture']){
				$arrPortExam['picture_score'] = $arrScoreStand['picture_stand'];
				$arrPortExam['score_total'] += $arrScoreStand['picture_stand'];
			}else{
				$arrPortExam['picture_res_class'] = 'red';
			}
			if($arrPortExam['failureRes'] == $arrPortExam['failure']){
				$arrPortExam['failure_score'] = $arrScoreStand['failure_stand'];
				$arrPortExam['score_total'] += $arrScoreStand['failure_stand'];
			}else{
				$arrPortExam['failure_res_class'] = 'red';
			}
		}
		return $arrPortExam;
	}
	
	/**
	 * 检测保存的考核数量设置
	 *
	 * @param array $arrPost
	 * @return boolean
	 */
	public function checkPortExam(array $arrPost, $arrRealtorInfo){
		if(empty($arrPost)){
			$this->error = '提交数据为空';
			return false;
		}
		$arrExamName = array(
				'publish' => '今日发布',
				'fresh' => '今日刷新',
				'published' => '已发布房源',
				'tag' => '标签房源',
				'fine' => '精品房源',
				'picture' => '带图房源',
				'failure' => '违规房源',
		);
		$arrExamDef = self::getExamDefault($arrRealtorInfo);
		foreach ($arrExamDef as $key => $val){
			if(intval($arrPost[$key]) < 0){//考核数量端口权限值可以为0，所以限制不能小于0
				$this->mError = $arrExamName[$key].'考核数量不能为负数';
				return false;
			}
			if(($key == 'publish' && $val > 9999) || ($key != 'publish' && $arrPost[$key] > $val)){//今日发布限制输入4位，则最大值9999
				$this->mError = $arrExamName[$key].'考核数量不能大于端口权限';
				return false;
			}
		}
		return true;
	}
	
	/**
	 * 保存提交的考核数量设置
	 *
	 * @param array $arrExam
	 * @return boolean
	 */
	public function InsertExamSet(array $arrExam, $arrRealtorInfo){
		if(empty($arrExam))
		{
			return false;
		}
		$arrExamDef = self::getExamDefault($arrRealtorInfo);
		foreach ($arrExamDef as $key => $val)
		{
			if($key == 'failure')
			{//违规房源考核数量为定值0
				$arrExam[$key] = $val;
				continue;
			}
			if($key != 'publish' && $arrExam[$key] > $val)
			{
				$arrExam[$key] = $val;
			}
			else
			{
				$arrExam[$key] = intval($arrExam[$key]);
			}
		}
		$objPortExam = new PortExam();				
		$arrData = $objPortExam->findFirst(" realId = ".$arrExam['realId']);
		$arrPortExam = $arrData->toArray();
		if(!empty($arrPortExam))
		{
			$arrExam['publishRes'] = $arrPortExam['publishRes'];
			$arrExam['freshRes'] = $arrPortExam['freshRes'];
			$arrExam['publishedRes'] = $arrPortExam['publishedRes'];
			$arrExam['tagRes'] = $arrPortExam['tagRes'];
			$arrExam['pictureRes'] = $arrPortExam['pictureRes'];
			$arrExam['failureRes'] = $arrPortExam['failureRes'];
			$arrExam['fineRes'] = $arrPortExam['fineRes'];
			$arrExam['examTime'] = $arrPortExam['examTime'];
			$arrExam['useStat'] = $arrPortExam['useStat'];
		}
		$arrPortExam = null;

		return $arrData->update($arrExam);
	}
}
