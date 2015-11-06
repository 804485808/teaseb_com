<?php
/**
 * 关键词model
 * @package sample
 * @subpackage classes
 */
class Tagindex_model extends MY_Model{
    function __construct(){
        parent::__construct();
    }
	
	static $table = "tagindex";
	
    /**
     * 查询关键词
     * @return 随机关键词
     */
    public function getRoundTagindex($limit){

        $query = $this->db->query('SELECT t1.id,t1.tag,t1.linkurl,t1.siteurl
                          FROM `wl_tagindex` AS t1
                          JOIN (SELECT ROUND(RAND() * ((SELECT MAX(id) FROM `wl_tagindex`)-(SELECT MIN(id) FROM `wl_tagindex`))+(SELECT MIN(id) FROM `wl_tagindex`)) AS id) AS t2
                          WHERE t1.id >= t2.id LIMIT '.$limit);

        if($query->num_rows>0){
            return $query->result_array();
        }else{
             $this->db->select('*');
             $query = $this->db->get('tagindex',$limit);
             if($query->num_rows>0){
                 return $query->result_array();
             }else{
                 return false;
             }
        }

    }
	
	public function getTag($tagid){
		$tagid = intval($tagid);
		if(!is_int($tagid) or empty($tagid)){
			throw new Exception("param tagid is not Int");
		}
		return $this->find(self::$table,array("id"=>$tagid));
	}
	
	
	
    /**
     * 查询分类每个状态下的关键词
	 * @param status 0 => 默认数据,1 => google下拉框数据 2 => google相关链接数据
     * @return 
     */
	public function getCategoryTag($catid,$limit,$status=0){
		$tagids = $this->findAll("tagindex_option",array("catid"=>$catid,"status"=>$status),"id asc","",$limit);
		$tags = array();
		if(!$tagids){
			return false;
		}
		foreach($tagids as $tag){
			$tags[$tag['tagindex_id']] = $this->getTag($tag['tagindex_id']);
		}
		
		return $tags;
	}
}