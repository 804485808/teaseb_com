<?php
/**
 * 地区model
 * @package sample
 * @subpackage classes
 */
class Area_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    /**
     * 根据ID查询地区名称
     * @param $areaId 地区ID
     * @return array
     */
    public function getAreaName($areaId){
        $this->db->select('areaname,areaid');
        $this->db->from('area');
        $this->db->where('areaid',$areaId);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row_array();
        }else{
            return array();
        }
    }
}