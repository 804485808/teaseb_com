<?php
class Category_new_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }


    public $mainTable = 'wl_category_new';

    /**
     * 关联表
     * @var array
     */
    protected $_link = array(
        'News'=>array(
            'table'=>'wl_news',
            'selfKey'=>'catid',
            'otherKey'=>'catid'
        ),
    );

    public  $_link1 = array(
        'News'=>array(
            'selfKey'=>'catid',
            'linkKey'=>'catid'
        ),
    );

    public  $_table = 'category_new';

    /**
     * 创建 主表匹配数组
     * @return array|bool
     */
    public function creatData($data){
        return $this->createDateCommon($data,$this->mainTable);
    }

    /**
     * 查询sell公共方法
     * @param string $files 查询字段
     * @param string $where 条件
     * @param string $limit limit
     * @param string $order 排序
     * @param int $type 1：返回一条一维数据 0:默认返回二维数组
     * @return array 查询结果
     */
    public function getCategoryNewCommon($files = '*', $where = '', $order = '', $limit = '', $type = 0)
    {
        $sql = "SELECT " . $files;
        $sql .= " FROM ".$this->mainTable;
        if ($where) {
            $sql .= " WHERE " . $where;
        }

        if ($order) {
            $sql .= " ORDER BY " . $order;
        }

        if ($limit) {
            $sql .= " LIMIT " . $limit;
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
     * @param string $files 查询字段
     * @param array $manTable 主表 array('表名'=>'别名')
     * @param array $link 关联表 array('$_link'=>'别名')
     * @param string $where 查询条件
     * @param string $order 排序
     * @param string $limit limit
     * @param int $type 1：返回一条一维数据 0:默认返回二维数组
     * @return array
     */
    public function getCategoryNewCommonLink($files = '*', $manTable, $link, $where = '', $order = '', $limit = '', $type = 0)
    {
        $manTableName = key($manTable);
        $manTableAlse = $manTable[$manTableName];
        $sql = "SELECT " . $files;
        $sql .= " FROM " . $manTableName . " AS " . $manTableAlse;

        if ($link) {
            while ($key = key($link)) {
                $sql .= " LEFT JOIN " . $this->_link[$key]['table'] . " AS " . $link[$key] . " ON " . $link[$key] . "." . $this->_link[$key]['otherKey'] . " = " . $manTableAlse . "." . $this->_link[$key]['selfKey'];
                next($link);
            }
        }

        if ($where) {
            $sql .= " WHERE " . $where;
        }

        if ($order) {
            $sql .= " ORDER BY " . $order;
        }

        if ($limit) {
            $sql .= " LIMIT " . $limit;
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
     * 添加分类
     * @return string
     */
    public function addCategory(){
        if($_POST['category']){
            $Post = $_POST['category'];
            $data = array(
                'parentid' =>$Post['parentid'],
                'catname'=>$Post['catname'],
                'level'=>$Post['level']
            );

            $re = $this->getCategoryNewCommon('catid',"catname = '{$Post['catname']}'",'','',1);
            if(empty($re) && $this->db->insert('category_new',$data)){
                return "保存成功";
            }else{
                return "已经存在";
            }
        }
    }

    /**
     * 获取定级分类
     * @return array
     */
    public function getParentCategory(){
        return $this->getCategoryNewCommon('*','parentid=0');
    }

    /**
     * 获取子类
     * @param $catid
     * @return array|bool
     */
    public function getChildCategory($catid){

        $re = $this->getCategoryNewCommon('catid,catname',"parentid='{$catid}'",'listorder ASC');
        if($re){
            return $re;
        }else{
            return false;
        }
    }

    public $allChild;

    public function getAllChildCategory($catid,$fields){

        $re = $this->getCategoryNewCommon($fields,"parentid='{$catid}'");
        if($re){
            foreach($re as $v){
                $this->allChild[] = $v['catid'];
                $this->getAllChildCategory($v['catid'],$fields);
            }
        }
    }

    public function getShowCategory($type)
    {

//        $re = $this->getCategoryNewCommon('catid', "catname='{$type}'", '', '', 1);
        $re = $this->SelectCommon('catid','','',array('catname'=>$type),'','',1);
        $parentId = $re['catid'];

        $sql = "select * from (select t1.catid,t1.catname,t2.title,t2.itemid,t2.tag,t2.thumb,t2.level as l2,t1.level as l1,t3.content from wl_category_new as t1 LEFT JOIN wl_news as t2 on t1.catid=t2.catid
          LEFT JOIN wl_news_data as t3 ON t2.itemid=t3.itemid WHERE t1.parentid = '{$parentId}' and t1.status=1 and t2.status=3 ) as v ORDER BY v.l1  ASC, v.l2 ASC
          ";


        $query = $this->db->query($sql);

       $re =  $query->result_array();
        if(!$re){
            $sql = "select * from (select t1.catid,t1.catname,t2.title,t2.itemid,t2.tag,t2.thumb,t2.level as l2,t1.level as l1,t3.content from wl_category_new as t1 LEFT JOIN wl_news as t2 on t1.catid=t2.catid
          LEFT JOIN wl_news_data as t3 ON t2.itemid=t3.itemid WHERE t1.catid = '{$parentId}' and t1.status=1 and t2.status=3 ) as v ORDER BY v.l1  ASC, v.l2 ASC
          ";


            $query = $this->db->query($sql);
            $re =  $query->result_array();
        }
        return $re;

    }




}