<?php
class Sell_service extends MY_Service{
	/**
	 *相关产品
	 * @param $word string 匹配词
	 * @param $limit string 个数
	 * @param $mlength int sphinx匹配度
	 * @param $sort 排序
	 * @param $fitter array sphinx过滤 	attr_itemid对应itemid
	 *  @retrun $relate_prospros array()
	 */
	function get_relate_pros($word,$limit="0,5",$sort="",$mlength=3,$filter=array()){
		if($word){
			$word = trim(preg_replace("/[^a-z0-9]/isU"," ",$word));
			$this->sphinx->ResetGroupBy();
			$this->sphinx->ResetFilters();
			if ($filter){
				$this->sphinx->SetFilter("attr_itemid",$filter,true);
			}
			if(strpos($limit,",")===false){
				show_error("limit param is invalid");
				return FALSE;
			}
			$limit = explode(",",$limit);
			$limit_min = intval($limit[0]);
			$limit_max = intval($limit[1]);
			$this->sphinx->SetLimits($limit_min,$limit_max);
			if(isset($match['groupby'])){
				$group=explode(" ",$sort);
				if(!isset($group[1])){
					$group[1] = 'desc';
				}
				$this->sphinx->SetGroupBy($group[0],SPH_GROUPBY_ATTR,"@group {$group[1]}");
			}

			$this->sphinx->SetMatchMode(SPH_MATCH_EXTENDED2);
			$site = $this->config->item("site");
			$res = $this->sphinx->Query("\"{$word}\"/{$mlength}", "sell_total");
			$relate_pros = array();
			if(isset($res['matches'])){
				foreach($res['matches'] as $prk=>$pro){
					$findpro = $this->comm->find("sell",array("itemid"=>$pro['id']));
					$findcorp = $this->comm->find('company',array("username"=>$findpro['username']),"","");
					$findarea = $this->comm->find("area",array("areaid"=>$findpro['areaid']),"","areaname");
					$relate_pros[] = array_merge($findcorp,$findarea,$findpro);
				}
			}
		}else {
			echo "Don't have conditions";
			return FALSE;
		}
		return $relate_pros;
	}
	
	/**
	 * 公司其他产品
	* @param $limit string 个数
	* @param $conditions 条件
	* @param $sort 排序
	* @retrun $pros array()
	*/
	function get_pros($conditions="",$sort="",$limit="0,5"){
		$proslist = array();
		$proslist = $this->comm->findAll('sell',$conditions,$sort,"",$limit);
		if ($proslist){
			foreach($proslist as $prk=>$pro){
				$findcorp = $this->comm->find('company',array("username"=>$pro['username']));
				$findarea = $this->comm->find("area",array("areaid"=>$pro['areaid']),"","areaname");
				if($findcorp && $findarea ){
				$pros[] = array_merge($findcorp,$findarea,$proslist[$prk]);
				}else{
				$pros[]=$proslist[$prk];
				}
			}
		}else {
			$pros = array();
		}
		return $pros;
	}
	/**
	 * 产品对比 VS
	 * @param $itemid int 产品id
	 * @param $limit string 个数
	* @param $mlength int sphinx匹配度
	* @param $val_limit 属性对比显示个数
	* @retrun $pros_view array('like_sell'=>"对比的产品",'op_value'=>"对比的属性")
	*/
	function get_pros_vs($itemid,$limit="0,5",$mlength=3,$val_limit="0,10"){
		if($itemid){
			$thissell = $this->comm->find("sell",array("itemid"=>$itemid),"","title");
			if (empty($thissell)){
				return false;
			}
			if(strpos($limit,",")===false){
				show_error("limit param is invalid");
				return FALSE;
			}
			$limit = explode(",",$limit);
			$limit_min = intval($limit[0]);
			$limit_max = intval($limit[1]);
			$this->sphinx->ResetFilters();
			$this->sphinx->SetMatchMode(SPH_MATCH_EXTENDED2);
			$this->sphinx->SetFilter("attr_itemid",array($itemid),true);
			$this->sphinx->SetLimits($limit_min,$limit_max);
			$site = $this->config->item("site");
			$word = preg_replace("/[^a-z0-9]/isU"," ",$thissell['title']);
			$res = $this->sphinx->Query("\"{$word}\"/{$mlength}", "{$site['sphinx_pre']}_sell");
			$like_sell = array();
			if(isset($res['matches'])){
				foreach($res['matches'] as $prk=>$pro){
					$like_sell[] = $this->comm->find("sell",array("itemid"=>$pro['id']));
				}
				if(count($like_sell)>1){
					$op_value=array();
					foreach($like_sell as $lk=>$ls){
						$find_value = $this->comm->findAll("category_value",array("itemid"=>$ls['itemid']));
						if($ls['maxprice']!=0.00){
							$op_value['Price'][$ls['itemid']] = $ls['currency']." ".$ls['minprice']."-".$ls['maxprice'];
						}else{
							$op_value['Price'][$ls['itemid']] = "Factory Price";
						}
						if(!empty($ls['minamount'])){
							$op_value['Min Order'][$ls['itemid']] = $ls['minamount'];
						}
						foreach($find_value as $fv){
							$option = $this->comm->find("category_option",array("oid"=>$fv['oid']));
							$op_value[$option['name']][$ls['itemid']] = $fv['value'];
						}
					}
					$i = 0;
					foreach($op_value as $op => $value){
						$count_value = count($value);
						$val_limit = array_pop(explode(",",$val_limit));
						$val_limit = $val_limit > 2 ? $val_limit : 10;
						if($count_value >= 2 && $i<$val_limit){
							$sort_op_value[$count_value.$op] = $value;
							$i++;
						}
					}
					krsort($sort_op_value);
				}else{
					$sort_op_value = array();
				}
			}else{
				$sort_op_value = array();
			}
		}
		
		$pros_view = array();
		$pros_view['like_sell'] =  $like_sell;
		$pros_view['op_value'] = $sort_op_value;
		return $pros_view;
	}
	
	/**
	 * 公司简介配置
	 * @param $itemid int 产品id
	* @param $quick_attr 是否显示 快速属性  默认显示
	* @param $is_content  是否显示产品内容  默认显示
	* @retrun $data_intro array('option_value'=>"快速查看属性",'sell_content'=>"产品内容",'com_cate'=>"公司类别",'sell_detail'=>"产品详细信息")
	*/
	function sell_intro($itemid,$quick_attr = 1,$is_content = 1){
		$sell_intro = $this->comm->find("sell",array("itemid"=>$itemid));
		$data_intro = array();
		if ($sell_intro){
			if ($quick_attr){
				$option_value = $this->comm->findAll("category_value",array("itemid"=>$itemid));
				if($option_value){
					foreach($option_value as $k => $v){
						$option = $this->comm->find("category_option",array("oid"=>$v['oid']));
						$option_value[$k]['name'] = $option['name'];
						$option_value[$k]['strlen'] = mb_strlen($v['value']) + mb_strlen($option['name']);
					}
				}
			}
			$data_intro['option_value'] = $option_value;
			$mem_intro = $this->comm->find('member',array('username'=>$sell_intro['username']),'','userid,mobile,qq,truename,department,career');
			$com_intro = $this->comm->find('company',array('username'=>$sell_intro['username']),'','mode,capital,regunit,size,regyear,regcity,business,telephone,fax,mail,address,zipcode,homepage,volume,export,thumb,introduce,hits');
			$mc_intro = array_merge($mem_intro,$com_intro,$sell_intro);
			if ($is_content){
				$sell_content = $this->comm->find("sell_data",array("itemid"=>$itemid),'','content');
				$data_intro['sell_content'] = $sell_content['content'];
			}
			
			$areaname = $this->comm->find("area",array("areaid"=>$sell_intro['areaid']),"","areaname");
			$data_intro['sell_detail'] = $mc_intro;
			$data_intro['sell_detail']['areaname'] = $areaname['areaname'];
		}
		return $data_intro;
		
	}
	
	
	/**
	 * 获得产品列表
	 * @param $tag  string 搜索词
	 * @param $limit  string 分页 0,20
	 * @param $order  string 排序
	 * @param $condition 查询条件  array("catid"=>'',"did"=>'') 只接收catid ,did
	 * @param mlength int sphinx匹配个数
	 * @return @plist array("total_rows"=>'分页用到的产品总数',"sell"=>'产品列表',"total"=>'sphinx显示的全部产品数目',"supplier_count"=>'供应商数目')   or boolean
	 */
	function plist($condition = NULL,$tag = NULL,$limit = "0,20",$order = 'itemid asc',$mlength = 1){
		if(strpos($limit,",")===false){
			show_error("limit param is invalid");
			return FALSE;
		}
		$limit = explode(",",$limit);
		$page = intval($limit[0]);
		$per_page = intval($limit[1]);
		$site = $this->config->item("site");
		foreach( $condition as $key => $con ){
			if($key == 'catid'){
				if(is_array($con)){
					$catid = $con;
				}else{
					$catid[] = $con;
				}
			}elseif($key == 'did'){
				if(is_array($con)){
					$did = $con;
				}else{
					$did[] = $con;
				}
	
			}
		}
		$this->sphinx->ResetGroupBy();
		$this->sphinx->ResetFilters();
		$this->sphinx->SetLimits($page,$per_page);
	
		if(!isset($tag) || empty($tag)){
			$this->sphinx->SetMatchMode(SPH_MATCH_FULLSCAN);
			if(isset($catid)){
				$this->sphinx->SetFilter('catid',$catid);
			}else{
				show_error("condition param catid is invalid");
				return FALSE;
			}
			if(isset($did)){
				$this->sphinx->SetFilter('did',$did);
			}			
			$res = $this->sphinx->Query("", "{$site['sphinx_pre']}_sell");
			$this->sphinx->SetGroupBy("username",SPH_GROUPBY_ATTR,"@count desc");
			$res1 = $this->sphinx->Query("", "{$site['sphinx_pre']}_sell");
			$supplier_count = $res1['total_found'];
		}else{
			$tag = preg_replace("/[^a-z0-9]/isU"," ",$tag);
			$this->sphinx->SetMatchMode(SPH_MATCH_EXTENDED2);
			if(isset($catid)){
				$this->sphinx->SetFilter('catid',$catid);
			}
			if(isset($did)){
				$this->sphinx->SetFilter('did',$did);
			}			
			$res = $this->sphinx->Query("\"{$tag}\"/{$mlength}", "{$site['sphinx_pre']}_sell");
			$this->sphinx->SetGroupBy("username",SPH_GROUPBY_ATTR,"@count desc");
			$res1 = $this->sphinx->Query("\"{$tag}\"/{$mlength}", "{$site['sphinx_pre']}_sell");
			$supplier_count = $res1['total_found'];
		}
		$total_rows = $res['total'];
		$total = $res['total_found'];
		$itemids = array(0);
		if(!empty($res['matches'])){
			foreach($res['matches'] as $x){
				$itemids[] = $x['id'];
			}
		}else{
			$itemids = array(0);
		}
		$itemid = implode(",",$itemids);
		if(empty($itemid)){
			$itemid = 0;
		}
		if(!isset($tag) || empty($tag)){
			$sell = $this->comm->findAll("sell","itemid in({$itemid})",$order);
		}else{
			//对于seo页面，排序使用sphinx的结果排序
			$sell = $this->comm->findAll("sell","itemid in({$itemid})","FIND_IN_SET(itemid,'{$itemid}')");
		}
		foreach ($sell as $sk=>$sv){
			$findarea = $this->comm->find("area",array("areaid"=>$sv['areaid']),"","areaname");
			$sell[$sk]['areaname'] = $findarea['areaname'];
			if ($sv['pptword']){
				$tmp_options = $this->comm->findAll('category_option',"oid in ({$sv['pptword']})","item desc","","0,5");
				$attr='';
				foreach ($tmp_options as $kk=>$v){
					$tmp_value = $this->comm->find('category_value',array('itemid'=>$sv['itemid'],'catid'=>$v['catid'],'oid'=>$v['oid']),"","value");
					if ($tmp_value['value']){
						$attr .= $v['name'].":".$tmp_value['value']." ; ";
					}
				}
			}
			$sell[$sk]['attr'] = $attr;
		}
		$plist['total_rows'] = $total_rows;
		$plist['sell'] = $sell;
		$plist['total'] = $total;		
		$plist['supplier_count'] = $supplier_count;
		return $plist;
	}
	
	
	
	/**
	 * 获得当前列表页面产品属性列表 汇总统计
	 * @param $tag  string 搜索词
	 * @param $limit  string 数目
	 * @param $order  string 排序
	 * @param $condition 查询条件 暂时只接收catid
	 * @param mlength int sphinx匹配个数
	 * @return  @dids array()   or boolean
	 */
	function pattrs($condition = NULL,$tag = NULL,$limit = "0,40",$order = 'itemid asc',$mlength = 1){
	
		$dids = array();
		$sortnum_desc = array();
		if(!isset($tag) || empty($tag)){
			if(!array_key_exists("catid",$condition)){
				show_error("condition param catid is not exsit");
				return FALSE;
			}
			$options = $this->comm->findAll("category_default_option",$condition,"num desc","","{$limit}");
			foreach($options as $k => $v){
				$did_option = $this->comm->find("category_option",array("oid"=>$v['oid']));
				$dids[$did_option['name']][$k] = $v;
				$dids[$did_option['name']][$k]['cnum'] = $v['num'];
				if(array_key_exists($did_option['name'],$sortnum_desc)){
					$sortnum_desc[$did_option['name']] = $sortnum_desc[$did_option['name']] + 1;
				}else{
					$sortnum_desc[$did_option['name']] = 1;
				}
			}
		}else{
			$site = $this->config->item("site");
			$tag = preg_replace("/[^a-z0-9]/isU"," ",$tag);
			if(strpos($limit,",")===false){
				show_error("limit param is invalid");
				return FALSE;
			}
			$limit = explode(",",$limit);
			$limit_min = intval($limit[0]);
			$limit_max = intval($limit[1]);
			$this->sphinx->SetMatchMode(SPH_MATCH_EXTENDED2);
			$this->sphinx->ResetGroupBy();
			$this->sphinx->ResetFilters();
			$this->sphinx->SetLimits($limit_min,$limit_max);
			$this->sphinx->SetGroupBy("did",SPH_GROUPBY_ATTR,"@count desc");
			$res = $this->sphinx->Query("\"{$tag}\"/{$mlength}", "{$site['sphinx_pre']}_sell");
			
			if(isset($res['matches'])){
				foreach($res['matches'] as $d => $did){
					$id = $did['attrs']['@groupby'];
					if($id){
						$did_value = $this->comm->find("category_default_option",array("id"=>$id));
						$did_option = $this->comm->find("category_option",array("oid"=>$did_value['oid']));
						$dids[$did_option['name']][$d] = $did_value;
						$dids[$did_option['name']][$d]['cnum'] = $did['attrs']['@count'];
						if(array_key_exists($did_option['name'],$sortnum_desc)){
							$sortnum_desc[$did_option['name']] = $sortnum_desc[$did_option['name']] + 1;
						}else{
							$sortnum_desc[$did_option['name']] = 1;
						}
					}
				}
			}
				
		}
	
		//按照一个属性包含多个属性值 进行降序排序
		array_multisort($sortnum_desc,SORT_NUMERIC, SORT_DESC,$dids);
	
		return $dids;
	}
	
	
	/**
	 * 获得当前列表页面产品的所有分类
	 * @param $tag  string 搜索词
	 * @param $limit  string 数目
	 * @param $order  string 排序
	 * @param $condition array('catid'=>'') 查询条件 暂时只接收catid
	 * @param mlength int sphinx匹配个数
	 * @return  @dids array()   or boolean
	 */
	
	function pcate($condition = NULL,$tag = NULL,$limit = "0,20",$order = 'itemid asc',$mlength = 1){
		if(!isset($tag) || empty($tag)){
			if(!$limit){
				$limit = '';
			}
			foreach( $condition as $key => $con ){
				if($key == 'catid'){
					$catids = $con;
				}
			}
			$cats = $this->comm->findAll("category","catid in({$catids}) and item > 0",$order,"",$limit);
		}else{
			$site = $this->config->item("site");
			$tag = preg_replace("/[^a-z0-9]/isU"," ",$tag);
			if(strpos($limit,",")===false){
				show_error("limit param is invalid");
				return FALSE;
			}
			$limit = explode(",",$limit);
			$limit_min = intval($limit[0]);
			$limit_max = intval($limit[1]);
			$this->sphinx->SetMatchMode(SPH_MATCH_EXTENDED2);
			$this->sphinx->ResetGroupBy();
			$this->sphinx->ResetFilters();
			if($limit){
				$this->sphinx->SetLimits($limit_min,$limit_max);
			}
			$this->sphinx->SetGroupBy("catid",SPH_GROUPBY_ATTR,"@count desc");
			$res = $this->sphinx->Query("\"{$tag}\"/{$mlength}", "{$site['sphinx_pre']}_sell");
			$catids = array('catid'=>0);
			if(isset($res['matches'])){
				foreach($res['matches'] as $c => $catid){
					$catids['catid'].= $c < (count($res['matches'])-1) ? $catid['attrs']['@groupby']."," : $catid['attrs']['@groupby'];
					$count_cat[$catid['attrs']['@groupby']]['num'] =  $catid['attrs']['@count'];
				}
			}else{
				$catids['catid'] = 0;
			}
	
				
			$cats = $this->comm->findAll("category","catid in({$catids['catid']})","FIND_IN_SET(catid,'{$catids['catid']}')");
			foreach($cats as $k => $v){
				$num = $count_cat[$v['catid']]['num'];
				$cats[$k]['num'] = $num;
			}
		}
	
		return $cats;
	}
	
	
	
	
	
	
	
	
	
}