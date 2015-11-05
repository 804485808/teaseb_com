<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Category_value_model extends MY_Model{

    function __construct(){
        parent::__construct();
    }
    public  $mainTable = 'wl_category_value';

    /**
     * 关联表
     * @var array
     */
    protected $_link = array(
        'Sell'=>array(
            'table'=>'wl_sell',
            'selfKey'=>'itemid',
            'otherKey'=>'itemid'
        ),
        'CategoryOption'=>array(
            'table'=>'wl_category_option',
            'selfKey'=>'oid',
            'otherKey'=>'oid'
        ),
    );

    /**
     * 查询sell公共方法
     * @param string $files  查询字段
     * @param string $where  条件
     * @param string $limit  limit
     * @param string $order  排序
     * @param int    $type   1：返回一条一维数据 0:默认返回二维数组
     * @return array 查询结果
     */
    public function getValueCommon($files='*',$where='',$order='',$limit='',$type=0){
        $sql = "SELECT ".$files;
        $sql .= " FROM wl_category_value";
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

        if($query->num_rows>0){
            return $query->result_array();
        }else{
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
    public function getValueCommonLink($files = '*', $manTable, $link, $where = '', $order = '',$group ='' ,$limit = '', $type = 0)
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

        if ($group) {
            $sql .= " GROUP BY " . $group;
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

    //属性产品
    public function getValue($files,$country,$order,$group,$limit)
    {
        $value = $this->getValueCommonLink($files,array('wl_category_value'=>'t1'),array('CategoryOption'=>'t2','Sell'=>'t3'),'t2.oid = '.$country,$order,$group,$limit,'');
        return $value;
    }

    //分类产品
    public function getPrice($files,$attr,$catid,$limit)
    {
        $value = $this->getValueCommonLink($files,array('wl_category_value'=>'t1'),array('CategoryOption'=>'t2','Sell'=>'t3'),"t2.name in({$attr}) and t1.catid =".$catid,"",$limit,'');
        return $value;
    }
}
