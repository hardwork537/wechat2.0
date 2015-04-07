<?php
/**
 * Created by PhpStorm.
 * User: Moon
 * Date: 12/18/14
 * Time: 10:07 AM
 */
    class ZebRealtorPark extends BaseModel{
        protected $realId;

        protected $parkId;

        protected $parkName;

        protected $parkAddress;

        public function columnMap ()
        {
            return array(
                'realId' => 'realId',
                'parkId' => 'parkId',
                'parkName' => 'parkName',
                'parkAddress' => 'parkAddress',
            );
        }

        public function initialize ()
        {
            $this->setReadConnectionService('esfSlave');
            $this->setWriteConnectionService('esfMaster');
        }
    }