<?php
class Tagindex_service extends MY_Service{
	
	/**
     * 获得相关热门长尾词
     * @param $tag  string 搜索词
     * @param $limit  string 查询数目
	 * @param $order  string 排序
	 * @param $condition 查询条件 array() //暂时只接收catid
	 * @param mlength sphinx匹配个数
     * @return  array() or boolean
     */
	 
	 function get_relate_kw($condition = NULL,$tag = NULL,$limit = "0,10",$order = 'id asc',$mlength = 1){
		if(!isset($tag) || empty($tag)){
			$kw = $this->comm->findAll("tagindex",$condition,$order,"",$limit);
		}else{
			if($mlength<1){
				show_error("Sphinx Match length less than one");
				return FALSE;
			}
			$this->sphinx->ResetGroupBy();
			$this->sphinx->ResetFilters();
			$this->sphinx->SetMatchMode(SPH_MATCH_EXTENDED2);
			$limit = explode(",",$limit);
			$limit_min = intval($limit[0]);
			$limit_max = intval($limit[1]);
			$this->sphinx->SetLimits($limit_min,$limit_max);
			
			//过滤当前页面的Tag
			$findtag = $this->comm->find("tagindex",array("tag"=>$tag),"","id,catid");
			if($findtag){
				$tagid[0] = $findtag['id'];
			}else{
				$tagid = 0;
			}
			if($tagid){
				$this->sphinx->SetFilter('arr_id',$tagid,TRUE);
			}
			if(preg_match("/[^0-9a-z]/i",$tag)){
				$tag = preg_replace("/[^0-9a-z]|'s/i"," ",$tag);
				$tag = preg_replace("/[\s]{2,}/i"," ",trim($tag));
			}
			$site = $this->config->item("site");
			$res = $this->sphinx->Query("\"{$tag}\"/{$mlength}", "tagindex");
			$tagids = array(0);
			if(isset($res['matches'])){
				foreach($res['matches'] as $x){
					$tagids[] = $x['id'];
				}
			}else{
				$tagids = array(0);
			}
			$tagids = implode(",",$tagids);
			$kw = $this->comm->findAll("tagindex","id in({$tagids})",$order);
			if (empty($kw)){
				//sphinx设置属性的原因，只接受catid
				if(isset($condition) && $condition){
					foreach( $condition as $key => $con ){
						if($key == 'catid'){
							if(is_array($con)){
								$newcondition = $con;
							}else{
								$newcondition['catid'] = $con;
							}
						}
					}
					
					$rs_tmp = $this->comm->find('category',$newcondition);
					if ($rs_tmp['parentid']){
						$pid_tmp = $rs_tmp['arrchildid'] ? $rs_tmp['parentid']."," : $rs_tmp['parentid'];
						$catids = $pid_tmp.$rs_tmp['arrchildid'];
					}else {
						$catids = $rs_tmp['arrchildid'];
					}
					if ($catids){
						$kw = $this->comm->findAll("tagindex","catid in({$catids}) and item > 0",$order,"","{$limit_min},{$limit_max}");
					}
				}
			}
			
		}
		return $kw;
	 }
}