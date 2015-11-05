<?php
/**
 * 地区model
 * @package sample
 * @subpackage classes
 */
class Area_model extends MY_Model{

    function __construct(){
        parent::__construct();
    }

    public  $_link1 = array(

    );

    public  $_table = 'area';
    /**
     * 根据ID查询地区名称
     * @param $areaId 地区ID
     * @return array
     */
    public function getAreaName($areaId){
        return $this->SelectCommon('areaname,areaid','','',array('areaid'=>$areaId),'','',1);

    }
}