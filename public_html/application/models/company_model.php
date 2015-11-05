<?php
/**
 * 公司model
 * @package sample
 * @subpackage classes
 */
class Company_model extends MY_Model{

    function __construct(){
        parent::__construct();
    }

    public  $mainTable = 'wl_company';

    /**
     * 关联表
     * @var array
     */
    protected $_link = array(
        'Sell'=>array(
            'table'=>'wl_sell',
            'selfKey'=>'username',
            'otherKey'=>'username'
        ),
        'Type'=>array(
            'table'=>'wl_type',
            'selfKey'=>'userid',
            'otherKey'=>'userid'
        )

    );

    public $_link1 = array(
        'Sell'=>array(
            'selfKey'=>'username',
            'linkKey'=>'username'
        ),
        'Type'=>array(
            'selfKey'=>'userid',
            'linkKey'=>'userid'
        ),
        'Member'=>array(
            'selfKey'=>'userid',
            'linkKey'=>'userid'
        )
    );

    public $_table = 'company';

    /**
     * 查询member公共方法
     * @param string $files  查询字段
     * @param string $where  条件
     * @param string $limit  limit
     * @param string $order  排序
     * @param int    $type   1：返回一条一维数据 0:默认返回二维数组
     * @return array 查询结果
     */
    public function getCompanyCommon($files='*',$where='',$group = "",$order='',$limit='',$type=0){
        $sql = "SELECT ".$files;
        $sql .= " FROM wl_company";
        if($where){
            $sql .= " WHERE ".$where;
        }
        if ($group) {
            $sql .= " GROUP BY " . $group;
        }

        if($order){
            $sql .= " ORDER BY ".$order;
        }

        if($limit){
            $sql .= " LIMIT ".$limit;
        }

        $query = $this->db->query($sql);

        if($query->num_rows>0){
            if(!$type) {
                return $query->result_array();
            }else{
                return $query->row_array();
            }

        }else{
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
    public function getCompanyCommonLink($files = '*', $manTable, $link, $where = '', $order = '', $limit = '', $type = 0)
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
     * 查询商家分类
     * @param $where
     * @param $order
     * @param $limit
     * @return array
     */
    public function getCompanySell($where,$order,$limit){
        return $this->getCompanyCommonLink('t1.userid,t1.username,t1.company,t1.markets,t2.tname',array('wl_company'=>'t1'),array('Type'=>'t2'),$where,$order,$limit);
    }
}