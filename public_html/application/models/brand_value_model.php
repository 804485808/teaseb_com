<?php

class Brand_value_model extends MY_Model
{
    function __construct(){
        parent::__construct();
    }

    public $mainTable = 'wl_brand_value';

    /**
     * 关联表
     * @var array
     */
    protected $_link = array(
        'Brand'=>array(
            'table'=>'wl_brand',
            'selfKey'=>'value',
            'otherKey'=>'brandId'
        ),
        'Sell'=>array(
            'table'=>'wl_sell',
            'selfKey'=>'itemid',
            'otherKey'=>'itemid'
        )
    );

    /**
     * 创建 主表匹配数组
     * @return array|bool
     */
    public function creatData($data){
        return $this->createDateCommon($data,$this->mainTable);
    }
    /**
     * 查询品牌公共方法
     * @param string $files 查询字段
     * @param string $where 条件
     * @param string $limit limit
     * @param string $order 排序
     * @param int $type 1：返回一条一维数据 0:默认返回二维数组
     * @return array 查询结果
     */
    public function getBrandValueCommon($files = '*', $where = '', $order = '', $limit = '', $type = 0)
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
            return $query->result_array();
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
    public function getBrandValueCommonLink($files = '*', $manTable, $link, $where = '', $order = '',$group = "" , $limit = '', $type = 0)
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

    //品牌产品
    public function getBrand($files,$catid,$order,$group,$limit)
    {
        $brand = $this->getBrandValueCommonLink($files,array('wl_brand_value'=>'t1'),array('Brand'=>'t2','Sell'=>'t3'),'t1.catid ='.$catid,$order,$group,$limit,'');
        return $brand;
    }
}