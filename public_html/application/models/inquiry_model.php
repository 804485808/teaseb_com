<?php

class Inquiry_model extends MY_Model
{
    function __construct(){
        parent::__construct();
    }

    public $mainTable = 'wl_inquiry';

    /**
     * 关联表
     * @var array
     */
    protected $_link = array(
        'InquiryData' => array(
            'table' => 'wl_inquiry_data',
            'selfKey' => 'id',
            'otherKey' => 'id'
        ),
    );

    public $_link1 = array(
        'Inquiry_data' => array(
            'selfKey' => 'id',
            'linkKey' => 'id'
        ),
        'Sell' => array(
            'selfKey' => 'sid',
            'linkKey' => 'itemid'
        )
    );

    public $_table = 'inquiry';

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
    public function getInquiryCommon($files = '*', $where = '', $order = '', $limit = '', $type = 0)
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
    public function getInquiryCommonLink($files = '*', $manTable, $link, $where = '', $order = '', $limit = '', $type = 0)
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
     * 获取分类下最新询单
     * @param $catid int 分类id 0：全部分类
     * @param $limit  string limit
     * @return array
     */
    public function getNewInquiry($catid=0,$limit){
        $this->load->model('sell_model','sell');
        $this->load->model('category_model','category');

        if($catid){
            $arrchildid = $this->comm->find('category',array('catid' => $catid));
            if ($arrchildid) {
                $arrchildid = $arrchildid['arrchildid'];
            } else {
                $arrchildid = $catid;
            }

            $where['t3.catid in']=$arrchildid;
        }
        $where['t3.status']=3;

        return $this->SelectCommon('t1.*,t2.message,t3.catid',array('Inquiry_data'=>'left','Sell'=>'left'),'',$where,array('t1.postdate'=>'desc'),$limit);

    }


    /**
     * 添加询单
     * @return bool
     */
    public function saveInquiry(){

        $sear_arr=$this->input->post();
        $data = $sear_arr['post'];
        if($data){
            $data['ip'] = $this->input->ip_address();
            $data['postdate'] = time();

            $mainData = $this->creatData($data);

            if($this->db->insert('inquiry',$mainData)){

                $dataDetail['id'] = mysql_insert_id();
                $dataDetail['message'] = $sear_arr['content'];
                if($this->db->insert('inquiry_data',$dataDetail)){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }

        }else{
            return false;
        }
    }


}