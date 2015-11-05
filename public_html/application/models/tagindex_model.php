<?php

/**
 * 关键词model
 * @package sample
 * @subpackage classes
 */
class Tagindex_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    /**
     * 查询关键词
     * @return 随机关键词
     */
    public function getRoundTagindex(){

        $query = $this->db->query('SELECT t1.id,t1.tag,t1.linkurl
                          FROM `wl_tagindex` AS t1
                          JOIN (SELECT ROUND(RAND() * ((SELECT MAX(id) FROM `wl_tagindex`)-(SELECT MIN(id) FROM `wl_tagindex`))+(SELECT MIN(id) FROM `wl_tagindex`)) AS id) AS t2
                          WHERE t1.id >= t2.id LIMIT 0,6');

        if($query->num_rows>0){

            return $query->result_array();

        }else{

             $this->db->select('id,tag,linkurl');
             $query = $this->db->get('tagindex',0,6);
             if($query->num_rows>0){
                 return $query->result_array();
             }else{
                 return false;
             }
        }

    }
}