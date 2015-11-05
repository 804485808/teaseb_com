<?php
class Pub_service extends MY_Service{
	
	function array_sort($arr,$keys,$type='asc'){
		$keysvalue = $new_array = array();
		foreach ($arr as $k=>$v){
			$keysvalue[$k] = $v[$keys];
		}
		if($type == 'asc'){
			asort($keysvalue);
		}else{
			arsort($keysvalue);
		}
		reset($keysvalue);
		foreach ($keysvalue as $k=>$v){
			$new_array[$k] = $arr[$k];
		}
		return $new_array;
	}
	
	function all_linkurl($array,$moduleid="1"){
		if ($array){
			foreach ($array as $k=>$v){
				$tmpcat = $this->comm->find("category",array("catid"=>$v['catid']));
				$parenturl = array();
				if ($tmpcat['arrparentid']){
					$parenturl = $this->comm->findAll('category',"catid in ({$tmpcat['arrparentid']})");
				}
				if ($parenturl){
					$str='';
					foreach ($parenturl as $p){
						$str .= $p['linkurl']."/";
						$array[$k]['all_linkurl'] = $str.$tmpcat['linkurl'];
					}
				}else {
					$array[$k]['all_linkurl'] = $tmpcat['linkurl'];
				}
			}
			return $array;
		}else {
			return false;
		}
		
	}
	
}