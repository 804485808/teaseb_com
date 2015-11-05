<?php
class News_model extends MY_Model{

    function __construct()
    {
        parent::__construct();
    }

    public  $mainTable = 'wl_news';

    /**
     * 关联表
     * @var array
     */
    protected $_link = array(
        'NewsData'=>array(
            'table'=>'wl_news_data',
            'selfKey'=>'itemid',
            'otherKey'=>'itemid'
        ),
        'Category'=>array(
            'table'=>'wl_category_new',
            'selfKey'=>'catid',
            'otherKey'=>'catid'
        )
    );

    public  $_link1 = array(
        'News_data'=>array(
            'selfKey'=>'itemid',
            'linkKey'=>'itemid'
        ),
        'Category_new'=>array(
            'selfKey'=>'catid',
            'linkKey'=>'catid'
        )
    );

    public  $_table = 'news';


    /**
     * 查询news公共方法
     * @param string $files 查询字段
     * @param string $where 条件
     * @param string $limit limit
     * @param string $order 排序
     * @param int $type 1：返回一条一维数据 0:默认返回二维数组
     * @return array 查询结果
     */
    public function getNewsCommon($files = '*', $where = '', $order = '', $limit = '', $type = 0)
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
    public function getNewsCommonLink($files = '*', $manTable, $link, $where = '', $order = '', $limit = '', $type = 0)
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
     * 获取分类详细信息
     * @param $itemid
     * @return array
     */
    public function getNewsDetail($catid,$limit){
        return $this->SelectCommon('t1.title,t2.content,t1.thumb,t1.itemid',array('News_data'=>'left'),'',
            array('t1.catid'=>$catid,'t1.status'=>3),array('t1.addtime'=>'desc'),$limit);
    }

    /**
     * 获取最热门信息
     * @param $limit  limit
     * @return array
     */
    public function getNewsHot($catid,$limit){
        $where = array();
        if(!empty($catid))
        {
            $where = array('t1.catid'=>$catid,'t1.status'=>3);
        }
        $newsHot = $this->SelectCommon('t1.catid,t1.addtime,t1.author,t1.title,t1.thumb,t1.itemid,t1.hits,t2.content',array('News_data'=>'left'),'',
            $where,array('t1.hits'=>'desc'),$limit);
        return $newsHot;

    }

    /**
     * 获取推荐信息
     * @param $title  关键字
     * @param $limit  limit
     * @return array
     */
    public function getNews($title,$limit){
        $newsHot = $this->SelectCommon('t1.catid,t1.addtime,t1.author,t1.title,t1.thumb,t1.itemid,t1.hits,t2.content'
            ,array('News_data'=>'left'),'', array('t1.status'=>3,'t1.title like'=>$title),array('t1.hits'=>'desc'),$limit);
        return $newsHot;

    }

    /**
     * 获取最新信息
     * @param $limit  limit
     * @return array
     */
    public function getLatestNews($limit){
        $LatestNews = $this->SelectCommon('t1.catid,t1.addtime,t1.author,t1.title,t1.thumb,t1.itemid,t1.hits,t2.content'
            ,array('News_data'=>'left'),'', array('t1.status'=>3),array('t1.addtime'=>'desc'),$limit);
        return $LatestNews;

    }

    /**
     * 获取推荐信息
     * @param $level  推荐级数
     * @param $limit  limit
     * @return array
     */
    public function getNewsRecommend($catid,$level,$limit){
        $where = array();
        if(!empty($catid))
        {
            $where = array('t1.catid'=>$catid,'t1.level'=>$level,'t1.status'=>3);
        }
        else
        {
            $where = array('t1.level'=>$level,'t1.status'=>3);
        }
        $newsHot = $this->SelectCommon('t1.catid,t1.addtime,t1.author,t1.title,t1.thumb,t1.itemid,t1.hits,t2.content',
            array('News_data'=>'left'),'', $where,array('t1.addtime'=>'desc'),$limit);
        return $newsHot;

    }

    /**
     * 获取id详细信息
     * @param $itemid
     * @return array
     */
    public function getDetail($itemid){
        return $this->SelectCommon('t1.catid,t1.addtime,t1.author,t1.title,t1.thumb,t1.itemid,t1.hits,t2.content',array('News_data'=>'left'),'', array('t1.status'=>3,'t1.itemid'=>$itemid),'','','1');
    }

    /**
     * 获取新闻总排行
     * @param $limit
     * @return array
     */
    public function getNewsTop($limit){
//        return $this->getNewsCommonLink('t1.title,t1.itemid,t1.thumb,t1.hits,t2.content',array('wl_news'=>'t1'),array('NewsData'=>'t2'),'t1.level=1','t1.hits desc',$limit);
        return $this->SelectCommon('t1.title,t1.itemid,t1.thumb,t1.hits,t2.content',array('News_data'=>'left'),'',array('t1.status'=>3,'t1.level'=>'1'),array('t1.hits'=>'desc'),$limit);
    }

    /**
     * 获取分类下面的列表
     * @param $catid
     * @param $limit
     * @return array
     */
    public function getCategoryNewsList($catid,$limit){

        $this->load->model('category_new_model','category_new');
        $this->category_new->getAllChildCategory($catid,'catid');
        $catids = $this->category_new->allChild;

        $catids = implode(',',$catids);
        if(!$catids){
            $catids = $catid;
        }


        return $this->getNewsCommonLink('t1.itemid,t1.title,t1.hits,t1.tag,t1.addtime,t1.thumb,t2.content,t3.catname',array('wl_news'=>'t1'),array('NewsData'=>'t2','Category'=>'t3'),"t1.catid in ({$catids})",'t1.addtime desc',$limit);
    }

    /**
     * 统计总数量
     * @param $catid
     * @return int
     */
    public function getNewsCount($catid){
        $this->load->model('category_new_model','category_new');

        $this->category_new->getAllChildCategory($catid,'catid');
        $re = $this->category_new->allChild;

        $catids = implode(',',$re);
        if(!$catids){
            $catids=$catid;
        }
        $sql = "
            select COUNT(*) as num from wl_news as t1 LEFT JOIN wl_news_data as t2 on t1.itemid=t2.itemid WHERE t1.catid in ({$catids})
        ";
        $query = $this->db->query($sql);
        $re = $query->result_array();
        return $re[0]['num'];
    }

    /**
     * 更新 公共方法
     * @param array $sear_arr 数据数组
     * @return boolean
     */
    public function updata($itemid,$update_arr)
    {
        $this->db->where('itemid',$itemid);
        return $this->db->update('news',$update_arr);
    }
}