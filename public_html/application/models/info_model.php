<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Info_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public $mainTable = 'wl_info';
    public  $_table = 'info';
    /**
     * 创建 主表匹配数组
     * @return array|bool
     */
    public function creatData($data)
    {
        return $this->createDateCommon($data, $this->mainTable);
    }
}