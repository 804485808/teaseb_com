<?php
class Tagindex_service extends MY_Service{
	function __construct()
	{
		parent::__construct();
		$this->load->model("tagindex_model","tagindex");
		$this->load->model("comm_model","comm");
		$this->load->library('Sphinxclient','','sphinx');
        $this->sphinx->SetServer ('127.0.0.1', 9312);
        $this->sphinx->SetConnectTimeout(1);
        $this->sphinx->SetArrayResult(true);
	}
	
	function getKeywordTag($keyword,$limit,$matchLength=2){
		$this->sphinx->ResetGroupBy();
		$this->sphinx->ResetFilters();
		$this->sphinx->SetMatchMode(SPH_MATCH_EXTENDED2);
		$this->sphinx->SetSortMode(SPH_SORT_RELEVANCE);
		$this->sphinx->SetLimits(0,$limit);
		$res = $this->sphinx->Query("\"{$keyword}\"/{$matchLength}",'tagindex');
		if(!empty($res['matches'])){
			foreach($res['matches'] as $k=>$v){
                $tags[] = $this->tagindex->getTag($v['id']);
            }
			return $tags;
		}else{
			return false;
		}
		
	}
}