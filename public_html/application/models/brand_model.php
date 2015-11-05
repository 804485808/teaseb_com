<?php

class Brand_model extends MY_Model
{
    function __construct(){
        parent::__construct();
    }

    public $mainTable = 'wl_brand';

    /**
     * 关联表
     * @var array
     */
    protected $_link = array(
        'BrandValue' => array(
            'table' => 'wl_brand_value',
            'selfKey' => 'brandId',
            'otherKey' => 'value'
        ),

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
    public function getBrandCommon($files = '*', $where = '', $order = '', $limit = '', $type = 0)
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
    public function getBrandCommonLink($files = '*', $manTable, $link, $where = '', $order = '', $limit = '', $type = 0)
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
     * 删除 公共方法
     * @param array $del_arr 删除id
     * @return boolean
     */
    public function delect($del_arr)
    {
        foreach($del_arr as $val){
            $this->db->or_where('brandId', $val);
        }
        return $this->db->delete('brand');
    }

    /**
     * 插入 公共方法
     * @param array $insert_arr 数据数组
     * @return boolean
     */
    public function insert($insert_arr)
    {
        return $this->db->insert('brand',$insert_arr);
    }

    /**
     * 更新 公共方法
     * @param array $sear_arr 数据数组
     * @return boolean
     */
    public function updata($brandId,$update_arr)
    {
        $this->db->where('brandId',$brandId);
        return $this->db->update('brand',$update_arr);
    }



}