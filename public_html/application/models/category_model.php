<?php
class Category_model extends MY_Model {
	
	public $gcategory;
	public $catid;
    public $mainTable = 'wl_category';
	
    function __construct()
    {
		parent::__construct();
    }

    public  $_link1 = array(

    );

    public  $_table = 'category';

    /**
     * 查询sell公共方法
     * @param string $files  查询字段
     * @param string $where  条件
     * @param string $limit  limit
     * @param string $order  排序
     * @param int    $type   1：返回一条一维数据 0:默认返回二维数组
     * @return array 查询结果
     */
    public function getCategoryCommon($files='*',$where='',$order='',$limit='',$type=0){
        $sql = "SELECT ".$files;
        $sql .= " FROM ".$this->mainTable;
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

        if ($query->num_rows > 0) {
            if (!$type) {
                return $query->result_array();
            } else {
                return $query->row_array();
            }
        } else {
            return array();
        }

    }


    /**
     * 连表查询 公共方法
     * @param string $files    查询字段
     * @param array $manTable  主表 array('表名'=>'别名')
     * @param array $link      关联表 array('$_link'=>'别名')
     * @param string $where    查询条件
     * @param string $order    排序
     * @param string $limit    limit
     * @param int $type        1：返回一条一维数据 0:默认返回二维数组
     * @return array
     */
    public function getCategoryCommonLink($files='*',$manTable,$link,$where='',$order='',$group = "",$limit='',$type=0){

        $manTableName = key($manTable);
        $manTableAlse = $manTable[$manTableName];
        $sql = "SELECT ".$files;
        $sql .= " FROM ".$manTableName." AS ".$manTableAlse;

        if($link){
            while($key = key($link)){
                $sql .= " LEFT JOIN ".$this->_link[$key]['table']." AS ".$link[$key]." ON ".$link[$key].".".$this->_link[$key]['otherKey']." = ".$manTableAlse.".".$this->_link[$key]['selfKey'];
                next($link);
            }
        }

        if($where){
            $sql .= " WHERE ".$where;
        }

        if($order){
            $sql .= " ORDER BY ".$order;
        }
        if ($group) {
            $sql .= " GROUP BY " . $group;
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
	* 添加分类
	* @param $arr_category 数组 array("字段名"=>"值")
	*/
	function add($arr_category){
		$this->db->insert("category",$arr_category);
		$catid = $this->db->insert_id();
		$this->catid = $catid;
		if($arr_category['parentid']){
			$arr_category['catid'] = $this->catid;
			$this->gcategory[$this->catid] = $arr_category;
			$arrparentid = $this->get_arrparentid($catid,$this->gcategory);
		}else{
			$arrparentid = '0';
		}
		
		$this->db->update("category",array("arrparentid"=>$arrparentid,"listorder"=>$catid),array("catid"=>$catid));
		
		if($arr_category['parentid']){
			$childs = '';
			$childs .= ",".$catid;
			$parents = array();
			$parents = $this->get_arrparentid($catid,$this->gcategory,FALSE);
			foreach($parents as $catid) {
				$arrchildid = $this->gcategory[$catid]['child'] ? $this->gcategory[$catid]['arrchildid'].$childs : $catid.$childs;
				$this->db->update("category",array("child"=>1,"arrchildid"=>$arrchildid),array("catid"=>$catid));
			}
		}
		return $catid;
		
		
	}
	
	/**
	* 获取父类ID
	* @param $catid 分类ID
	* @param $gcategory 全部分类
	* @param $type 返回字符串或者数组 默认返回字符串
	*/
	function get_arrparentid($catid,$gcategory,$type=TRUE){
		if($gcategory[$catid]['parentid']){
			$parents = array();
			$cid = $catid;
			while($catid) {
				if($gcategory[$cid]['parentid']) {
					$parents[] = $cid = $gcategory[$cid]['parentid'];
				} else {
					break;
				}
			}
			if($type === TRUE){
				$parents[] = 0;
				return implode(',', array_reverse($parents));
			}else{
				return $parents;
			}
		}else{
			return '0';
		}
	}
	
	/**
	* 删除分类 有子分类的无法删除，修复父级分类
	* @param $catid 分类ID
	*/
	function del($catid){
		
		$findcat = $this->find("category",array("catid"=>$catid));
		if(!$findcat){
			return FALSE;
		}
		if($findcat['child'] == 0){
			$this->db->delete("category",array("catid"=>$catid));
			$findparent = $this->find("category",array("parentid"=>$findcat['parentid']));
			if(!$findparent){
				$this->db->update("category",array("child"=>0),array("catid"=>$findcat['parentid']));
			}
			$parents = $this->get_arrparentid($catid,$this->gcategory,FALSE);
			foreach($parents as $cid) {
				$arrchildid = str_replace(",".$catid,"",$this->gcategory[$cid]['arrchildid']);
				$this->db->update("category",array("arrchildid"=>$arrchildid),array("catid"=>$cid));
			}
			return TRUE;
		}else{
			return FALSE;
		}
		
	}


}