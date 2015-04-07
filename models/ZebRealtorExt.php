<?php

class ZebRealtorExt extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $zrId;

    /**
     *
     * @var integer
     */
    public $realId;

    /**
     *
     * @var integer
     */
    public $zr01 = 0;

    /**
     *
     * @var integer
     */
    public $zr02 = 0;

    /**
     *
     * @var integer
     */
    public $zr03 = 0;

    /**
     *
     * @var integer
     */
    public $zr04 = 0;

    /**
     *
     * @var integer
     */
    public $zr05 = 0;

    /**
     *
     * @var integer
     */
    public $sevenDayRank = 0;

    /**
     *
     * @var integer
     */
    public $zr07 = 0;

    /**
     *
     * @var integer
     */
    public $zr08 = 0;

    /**
     *
     * @var integer
     */
    public $zr09 = 0;

    /**
     *
     * @var integer
     */
    public $zr10 = 0;

    /**
     *
     * @var string
     */
    public $zrUpdate = '0000-00-00 00:00:00';
	
	public function getSource()
	{
		return 'zeb_realtor_ext';
	}

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'zrId' => 'zrId', 
            'realId' => 'realId', 
            'zr01' => 'zr01', 
            'zr02' => 'zr02', 
            'zr03' => 'zr03', 
            'zr04' => 'zr04', 
            'zr05' => 'zr05', 
            'zr06' => 'sevenDayRank',
            'zr07' => 'zr07', 
            'zr08' => 'zr08', 
            'zr09' => 'zr09', 
            'zr10' => 'zr10', 
            'zrUpdate' => 'zrUpdate'
        );
    }
	
	public function initialize()
	{
		$this->setReadConnectionService('esfSlave');
		$this->setWriteConnectionService('esfMaster');
	}

}
