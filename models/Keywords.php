<?php
class Keywords extends BaseModel
{
	//过滤关键字分隔符
	const WORD_SEPARATOR = ';';

    public $id;

    public $content;
   

    public function getSource ()
    {
        return 'keywords';
    }

    public function columnMap ()
    {
        return array(
			'kwId' => 'id',
			'kwContent' => 'content',
        );
    }

    public function initialize ()
    {
        $this->setConn('esf');
    }

	/**
	 * 获取过滤关键字
	 * 
	 * @return boolean|array
	 */
	public function getKeywordsFromMc()
	{
		//从Memcache取
		$result = Mem::Instance()->Get(MCDefine::UNIT_WEIGUI_KEYWORD_KEY);
		if(empty($result))
		{
			$result = self::findFirst(array())->toArray();
			if(empty($result)) return false;
			//更新到Memcache
			Mem::Instance()->Set(MCDefine::UNIT_WEIGUI_KEYWORD_KEY, array('keywords' => $result['content']), 86400, 0);//存一天
			$result = explode(self::WORD_SEPARATOR, $result['content']);
		}
		else
		{
			$result = explode(self::WORD_SEPARATOR, $result['keywords']);
		}
		return $result;
	}

	/**
	 * 校验房源描述是否存在关键字
	 * 
	 * @param array $arrData
	 * @return boolean|array
	 */
	public function validateKeywords($arrData)
	{
		$arrKeyWord = $this->getkeywordsFromMc();
		$keywords = array();
		foreach($arrKeyWord as $word)
		{
			if(isset($arrData['title']) && !empty($word) && stristr($arrData['title'], $word))
			{
				!in_array($word, $keywords) ? $keywords[]=$word:NULL;
			}
			if(isset($arrData['description']) && !empty($word) && stristr($arrData ['description'], $word))
			{
				!in_array($word, $keywords) ? $keywords[]=$word:NULL;
			}
		}
		unset($arrKeyWord);
		if(empty($keywords))
		{
			return false;
		}
		else
		{
			return $keywords;
		}
	}
	
	/**
	 * 实例化对象
	 *
	 * @param type $cache
	 * @return \Users_Model
	 */
	public static function instance ($cache = true)
	{
	    return parent::_instance(__CLASS__, $cache);
	    return new self();
	}
	
	
	/**
	 * 修改违规关键字
	 * @param array $arr
	 * @return boolean|array
	 */
	public function edit($id,$arr)
	{

	    $id = intval($id);
        $rs = self::findfirst($id);
        $rs->content = $arr["content"];

        if ($rs->update()) {
            return true;
        }
        return false;
	}
}