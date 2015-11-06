<?php
class Sell_service extends MY_Service{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model("category_model","category");
		$this->load->model("comm_model","comm");
		$this->load->model("category_option_model","category_option");
		$this->load->model("company_model","company");
		$this->load->library('Sphinxclient','','sphinx');
        $this->sphinx->SetServer ('127.0.0.1', 9312);
        $this->sphinx->SetConnectTimeout(1);
        $this->sphinx->SetArrayResult(true);
	}
	
	
	/**
	 * 获取某个下产品各个(sphinx)属性的数据统计
	 * @conditions array("did"=>1);
	 * @groupby array("did","@count desc");
	 */
	private function getKeywordSellGroupBy($keyword,$limit,$groupby,$orderby,$arrayConditions=null,$matchLength=3){
		
		$this->sphinx->ResetFilters();
		$this->sphinx->ResetGroupBy();
		$this->sphinx->SetMatchMode(SPH_MATCH_EXTENDED2);
		$this->sphinx->SetSortMode(SPH_SORT_RELEVANCE);
		$this->sphinx->SetLimits(0,$limit);
		if(is_array($arrayConditions)){
			foreach($arrayConditions as $k => $v){
				if($k == 'did' || $k == 'catid' || $k == 'userid'){
					$value = explode(",",$v);
					$this->sphinx->SetFilter($k,$value);
				}
			}
		}
		if(!empty($groupby) and !empty($orderby)){
			$this->sphinx->SetGroupBy($groupby,SPH_GROUPBY_ATTR,$orderby);
		}
		
        $res = $this->sphinx->Query("\"{$keyword}\"/{$matchLength}",'sell_total');
		
        return $res;
		
	}
	
	
	public function getKeywordAttrs($keyword,$limit){
		$res = $this->getKeywordSellGroupBy($keyword,$limit,"did","@count desc");
		$attr = array();
		if(!empty($res['matches'])){
			 foreach($res['matches'] as $k=>$v){
                $id = $v['attrs']['@groupby'];
                if($id) {
                    $did_value = $this->comm->find("category_default_option",array("id"=>$id));
                    $did_option = $this->category_option->getOption($did_value['oid']);
                    $attr[$did_option['name']][$k] = $did_value;
                    $attr[$did_option['name']][$k]['cnum'] = $v['attrs']['@count'];
                }
            }
			return $attr;
		}else{
			return false;
		}
	}
	
	
	 /**
     * 更加keyword搜索 统计分类
     * @param $keyword string 关键词
     * @param $limit    int limit
     * @return bool
     */
    public function getKeywordCategory($keyword,$limit){
        $res = $this->getKeywordSellGroupBy($keyword,$limit,"catid","@count desc");
        $attr = array();
        if(!empty($res['matches'])){
            foreach($res['matches'] as $k=>$v){
                $catid = $v['attrs']['@groupby'];
                if($catid) {
                    $tmpcategroy = $this->category->getCategory($catid);
                    $tmpcategroy['cnum'] = $v['attrs']['@count'];
                    $category[$catid] = $tmpcategroy;
                }
            }
            return $category;
        }else{
            return false;
        }
    }
	
	public function getKeywordSellItems($keyword,$offset,$limit,$arrayConditions=null,$matchLength=3){
        $this->sphinx->ResetFilters();
        $this->sphinx->ResetGroupBy();
        $this->sphinx->SetMatchMode(SPH_MATCH_EXTENDED2);
		$this->sphinx->SetSortMode(SPH_SORT_RELEVANCE);
        $this->sphinx->SetLimits($offset,$limit);
		if(is_array($arrayConditions)){
			foreach($arrayConditions as $k => $v){
				if($k == 'did' || $k == 'catid' || $k == 'userid'){
					$value = explode(",",$v);
					foreach($value as $t){
						$t = intval($t);
						if(!is_int($t) or !$t){
							throw new Exception("attr value is not integer");
						}
					}
					$this->sphinx->SetFilter($k,$value);
				}else{
					throw new Exception("attr name is not did or catid");
				}
			}
		}

       $res = $this->sphinx->Query("\"{$keyword}\"/{$matchLength}",'sell_total');
	   $itemids = array();
	   if(!empty($res['matches'])){
			  foreach($res['matches'] as $k=>$v){
                $itemids['itemid'][] = $v['id'];
            }
			$itemids['total'] = $res['total'];
			$itemids['total_found'] = $res['total_found'];
			return $itemids;
		}else{
			return false;
		}
    }
	
	public function getKeywordByUseridSellItems($keyword,$limit,$userid){
		$matchLength = count(explode(" ",$keyword));
		return $this->getKeywordSellItems($keyword,0,$limit,array("userid"=>$userid),$matchLength);
	}
	
	/**
	 * 获取分类下产品各个(sphinx)属性的数据统计
	 * @conditions array("did"=>1);
	 * @groupby array("did","@count desc");
	 */
	private function getCategorySellGroupBy($catid,$limit,$groupby,$orderby,$conditions=null){
		$category = $this->category->getCategory($catid);
		if(!$category){
			return false;
		}
		
		$catList = explode(",",$category['arrchildid']);
		$this->sphinx->ResetFilters();
		$this->sphinx->ResetGroupBy();
		$this->sphinx->SetMatchMode(SPH_MATCH_FULLSCAN);
		$this->sphinx->SetSortMode(SPH_SORT_RELEVANCE);
		$this->sphinx->SetLimits(0,$limit);
		
		$this->sphinx->SetFilter("catid",$catList);
		
		if(is_array($conditions)){
			foreach($conditions as $k => $v){
				if($k == 'did'){
					$value = explode(",",$v);
					$this->sphinx->SetFilter("did",$value);
				}
			}
		}
		if(!empty($groupby) and !empty($orderby)){
			$this->sphinx->SetGroupBy($groupby,SPH_GROUPBY_ATTR,$orderby);
		}
		
        $res = $this->sphinx->Query('','sell_total');
        return $res;
		
	}
	/**
	 * 获取分类下产品最热门的公司
	 * 
	 */
	public function getCategorySellCompany($catid,$limit){
		$res = $this->getCategorySellGroupBy($catid,$limit,"username","hits desc");
		$company = array();
		if(!empty($res['matches'])){
			foreach($res['matches'] as $k => $v) {
				$company[$k] = $this->company->getCompany($v['attrs']['username']);
			}
			return $company;
		}else{
			return false;
		}
	}
	/**
	 * 获取分类下产品属性值以及统计
	 * 
	 */
	public function getCategoryAttrs($catid,$limit){
		$res = $this->getCategorySellGroupBy($catid,$limit,"did","@count desc");
		$attr = array();
		if(!empty($res['matches'])){
			 foreach($res['matches'] as $k=>$v){
                $id = $v['attrs']['@groupby'];
                if($id) {
                    $did_value = $this->comm->find("category_default_option",array("id"=>$id));
                    $did_option = $this->category_option->getOption($did_value['oid']);
                    $attr[$did_option['name']][$k] = $did_value;
                    $attr[$did_option['name']][$k]['cnum'] = $v['attrs']['@count'];
                }
            }
			return $attr;
		}else{
			return false;
		}
	}
	
	/**
     * 分类下的商品itemid
     * @param $limit
     * @param $catid
     * @param $did
	 * return array("itemid"=>array(多个itemid数组),"total"=>"","total_found"=>"")
     */
    public function getCategorySellItems($catid,$offset,$limit,$conditions=null){
		$category = $this->category->getCategory($catid);
		if(!$category){
			return false;
		}
		$catList = explode(",",$category['arrchildid']);
        $this->sphinx->ResetFilters();
        $this->sphinx->ResetGroupBy();
        $this->sphinx->SetMatchMode(SPH_MATCH_FULLSCAN);
        $this->sphinx->SetSortMode(SPH_SORT_EXTENDED,"sellid desc");
        $this->sphinx->SetLimits($offset,$limit);
        $this->sphinx->SetFilter('catid',$catList);

        if(is_array($conditions)){
			foreach($conditions as $k => $v){
				if($k == 'did'){
					$value = explode(",",$v);
					$this->sphinx->SetFilter("did",$value);
				}
			}
		}

       $res = $this->sphinx->Query('','sell_total');
	  
	   $itemids = array();
	   if(!empty($res['matches'])){
			  foreach($res['matches'] as $k=>$v){
                $itemids['itemid'][] = $v['id'];
            }
			$itemids['total'] = $res['total'];
			$itemids['total_found'] = $res['total_found'];
			return $itemids;
		}else{
			return false;
		}
    }
	
}