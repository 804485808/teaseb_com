<?php
class Category_model extends MY_Model {
    function __construct()
    {
		parent::__construct();
    }
    static  $table = 'category';
    public $mainTable = 'wl_category';

    public function creatData($data)
    {
        return $this->createDateCommon($data, $this->mainTable);
    }

	/**
     * 获取当前类别信息
     */
	public function getCategory($catid){
		$catid = intval($catid);
		if(!is_int($catid) or empty($catid)){
			throw new Exception("param catid is not Int");
		}
		return $this->find(self::$table,array("catid"=>$catid));
	}
	
	/**
     * 获取所有顶级的类别
     */
	public function getTopCategory(){
		$rs = $this->findAll(self::$table,"parentid = 0 and item <> 0","hits desc,letter asc");
		return $rs;
	}
	
	 /**
     * 获取当前类别的所有父类
     */
	public function getAllParentCategory($catid){
		$thisCategory = $this->getCategory($catid);
		if(!$thisCategory){
			return false;
		}else{
			if($thisCategory['parentid']){
				$parents = $this->findAll(self::$table,"catid in({$thisCategory['arrparentid']})","FIND_IN_SET(catid,'{$thisCategory['arrparentid']}')");
			}else{
				$parents = array($thisCategory);
			}
			
			return $parents;
		}
	}
	
	/**
     * 获取当前类别的子类
     */
	public function getSubCategory($catid){
		$thisCategory = $this->getCategory($catid);
		if(!$thisCategory){
			return false;
		}else{
			$subs = $this->findAll(self::$table,"parentid = {$thisCategory['catid']} and item <> 0","listorder asc");
			return $subs;
		}
	}
	
	 /**
     * 获取当前类别的顶级父类
     */
	 
	 public function getTopParentCategory($catid){
		 $parents = $this->getAllParentCategory($catid);
		 return $parents[0];
	 }
	

}