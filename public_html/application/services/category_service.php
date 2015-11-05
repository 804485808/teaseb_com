<?php
class Category_service extends MY_Service{
	/*
	** 获取父类以及子分类,如果分类下没有产品的，就不显示该分类
	* @@ condition 获取父类的条件 array() or string 默认值是第一级分类
	* @@ plimit 获取父类的个数 int
	* @@ porder 父类的排序 string
	* @@ climit 获取子类的个数 int
	* @@ corder 获取子类的排序 string
	
	* return cates array();
	
	cates = array("parent"=>array(),
				  "sub"=>array(
					catid=>array(),
					...
				  ));
	
	*/
	function pc_category($condition="parentid = 0 and item > 0",$plimit="0,15",$climit="0,5",$porder="catid asc",$corder="catid desc"){
		$cates['parent'] = $this->comm->findAll("category",$condition,$porder,"",$plimit);
		if(!$cates['parent']){
			return FALSE;
		}
		foreach($cates['parent'] as $k=>$v){
			if($v['item']<=0){
				unset($cates['parent'][$k]);
				continue;
			}
			$cates['sub'][$v['catid']] = $this->comm->findAll("category","parentid = {$v['catid']} and item > 0",$corder,"",$climit);
		}
		return $cates;
	}
	
}