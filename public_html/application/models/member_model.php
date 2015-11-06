<?php
/**
 * 会员model
 * @package sample
 * @subpackage classes
 */
class Member_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    /**
     * 查询member公共方法
     * @param string $files  查询字段
     * @param string $where  条件
     * @param string $limit  limit
     * @param string $order  排序
     * @param int    $type   1：返回一条一维数据 0:默认返回二维数组
     * @return array 查询结果
     */
    public function getMemberCommon($files='*',$where='',$order='',$limit='',$type=0){
        $sql = "SELECT ".$files;
        $sql .= " FROM wl_member";
        if($where){
            $sql .= " WHERE ".$where;
        }

        if($order){
            $sql .= " ORDER BY ".$order;
        }

        if($limit){
            $sql .= " LIMIT ".$limit;
        }

        $query = $this->db->query($sql);

        if($query->num_rows>0){
            if(!$type){
                return $query->result_array();
            }else{
                return $query->row_array();
            }

        }else{
            return array();
        }
    }

    /**
     * 根据ID查询会员名称
     * @param $areaId 地区ID
     * @return array
     */
    public function getAreaName($areaId){
        $this->db->select('areaname,areaid');
        $this->db->from('member');
        $this->db->where('areaid',$areaId);
        $query = $this->db->get();

        if($query->num_rows()>0){
            return $query->row_array();
        }else{
            return array();
        }
    }




}