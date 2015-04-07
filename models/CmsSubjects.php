<?php

class CmsSubjects extends BaseModel
{

    protected $id;

    protected $cityId;

    protected $path;

    protected $name;

    protected $clickNum = 0;

    protected $userAccname;

    protected $uploadTime;

    protected $updateTime;

    protected $createTime;

    private $_rootPath;
    public $error;

    public function columnMap ()
    {
        return array(
                'subjectId' => 'id',
                'cityId' => 'cityId',
                'subjectPath' => 'path',
                'subjectName' => 'name',
                'subjectClickNum' => 'clickNum',
                'userAccname' => 'userAccname',
                'subjectUploadTime' => 'uploadTime',
                'subjectUpdateTime' => 'updateTime',
                'subjectCreateTime' => 'createTime'
        );
    }

    public function initialize ()
    {
        $this->setConn('esf');
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
     * 增加记录
     *
     * @param array $data            
     * @return boolean int false，成功返回自增ID
     */
    public function add ($arr)
    {
        $rs = self::instance();
        $logininfo = Cookie::get(LOGIN_KEY);
        $date = date('Y-m-d H:i:s');
        $data['uploadTime'] = $date;
        $data['updateTime'] = $date;
        $data['createTime'] = $date;
        $data['userAccname'] = $logininfo['accname'];
        $data['name'] = $arr['name'];
        $data['cityId'] = intval($arr['cityId']);
        $data['path'] = $arr['path'];
        $file = $arr['files'][0];
        try {
            if ($file && $file->isUploadedFile()) {
                $path = $this->createZipPath($data['cityId'], $data['path']);
                if(!$this->extractTo($file, $path)){
                    return false;
                }
                $rs->create($data);
                return true;
            }
        } catch (Exception $e) {
                echo $e->getMessage();
                $this->error = $e->getMessage();
                return false;
        }
        
        return false;
    }

    /**
     * 修改记录
     *
     * @param array $data
     * @return boolean int false，成功返回自增ID
     */
    public function edit ($id,$arr)
    {
        $rs = self::findFirst(intval($id));
        $logininfo = Cookie::get(LOGIN_KEY);
        $date = date('Y-m-d H:i:s');
        $data['uploadTime'] = $date;
        $data['updateTime'] = $date;
        $data['userAccname'] = $logininfo['accname'];
        $data['name'] = $arr['name'];
        $path = $this->getZipPath($rs->cityId, $rs->path);
        $file = $arr['files'][0];
        try {
            if ($file &&  $file->isUploadedFile()) {
                if(!$this->extractTo($file, $path)){
                    return false;
                }
            }
            $rs->update($data);
            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    
        return false;
    }
    
    /**
     * 获取根路径。
     *
     * @return string
     * @throws Exception
     */
    public function getRootPath ()
    {
        if ($this->_rootPath === null) {
            $this->_rootPath = dirname(__FILE__) . '/../subjects';
            $path = $this->_rootPath;
        }
        
        $this->_rootPath = realpath($this->_rootPath);
        if ($this->_rootPath === false) {
            throw new Exception("不是一个正确的路径");
        }
        
        return $this->_rootPath;
    }

    /**
     * 设置解压文件根路径
     *
     * @param string $path            
     */
    public function setRootPath ($path)
    {
        $this->_rootPath = $path;
    }

    /**
     * 根据根目录，城市与指定目录生成目录路径。
     *
     * @param string|int $city            
     * @param string $dir            
     * @return string
     */
    public function createZipPath ($cityId, $dir)
    {
        $cityAbbr = City::findFirst($cityId)->pinyinAbbr;
        $path = implode('/', array(
                $this->getRootPath(),
                $cityAbbr,
                $dir
        ));
        if (! is_dir($path)) {
            if (! mkdir($path, 0777, true)) {
                throw new Exception('目录创建不成功');
            }
            $path = realpath($path);
        }else{
            throw new Exception('目录已经存在');
        }
        return $path;
    }
    
    public function getZipPath($cityId, $dir){
         $cityAbbr = City::findFirst($cityId)->pinyinAbbr;
         $path = implode('/', array(
                $this->getRootPath(),
                $cityAbbr,
                $dir
        ));
         return $path;
    }

    /**
     * 解压ZIP文件到指定目录。
     *
     * @param string $file
     *            待解压文件
     * @param string $path
     *            指定解压到目录
     * @return boolean
     */
    public function extractTo ($file, $path)
    {
        $ar = new ZipArchive();
        if ($ar->open($file) === true) {
            $ar->extractTo($path);
            $ar->close();
            return true;
        }
        //throw new Exception('解压文件失败 ');
        return false;
    }
}
