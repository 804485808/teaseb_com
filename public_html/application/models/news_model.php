<?php
class News_model extends MY_Model{

    function __construct()
    {
        parent::__construct();
        $this->load->model('category_new_model','category_new');
    }

    public  $_table = 'news';
    public  $_link1 = array(
        'News_data'=>array(
            'selfKey'=>'itemid',
            'linkKey'=>'itemid'
        ),
        'Category_new'=>array(
            'selfKey'=>'catid',
            'linkKey'=>'catid'
        ),
        'Category'=>array(
            'selfKey'=>'pcatid',
            'linkKey'=>'catid'
        )
    );

    /**
     * 获取某分类下最热门信息（包括所有递归子类）0:表示所有分类
     * @param $catid   int      新闻分类id
     * @param $limit   string limit
     * @param $pcatid  string/int 商品分类id
     * @return array
     */
    public function getNewsHot($catid,$limit,$pcatid=''){

        $catids = '';
        if(is_array($catid)){
            foreach($catid as $k=>$v){
                $catids .= $this->category_new->getAllChildCategory($v,'catid').",";
            }
            $catids = substr($catids,0,-1);
        }else{
            $catids = $this->category_new->getAllChildCategory($catid,'catid');
        }

        $where = array();
        if(!empty($catids))
        {
            $where['t1.catid in'] = $catids;
        }

        if(!empty($pcatid)){
            $where['t1.pcatid in'] = $pcatid;
        }

        $where['t1.status'] = 3;

        $newsHot = $this->SelectCommon('t1.catid,t1.addtime,t1.author,t1.title,t1.thumb,t1.itemid,t1.hits,t1.pcatid,t2.content,t3.catname,t4.catname as pcatname',array('News_data'=>'left','Category_new'=>'left','Category'=>'left'),'',
            $where,array('t1.hits'=>'desc'),$limit);
        return $newsHot;

    }


    /**
     * 获取某分类下最新信息（包括所有递归子类）0：表示所有分类
     * @param $catid    int   新闻分类id
     * @param $limit  string limit
     * @param $pcatid string/int 商品分类id
     * @return array
     */
    public function getNewsLast($catid,$limit,$pcatid=''){
        $catids = '';
        if(is_array($catid)){
            foreach($catid as $k=>$v){
                $catids .= $this->category_new->getAllChildCategory($v,'catid').",";
            }
            $catids = substr($catids,0,-1);
        }else{
            $catids = $this->category_new->getAllChildCategory($catid,'catid');
        }


        $where = array();
        if(!empty($catids))
        {
            $where['t1.catid in'] = $catids;
        }

        if(!empty($pcatid)){
            $where['t1.pcatid in'] = $pcatid;
        }

        $where['t1.status'] = 3;
        $newsHot = $this->SelectCommon('t1.catid,t1.addtime,t1.author,t1.title,t1.thumb,t1.itemid,t1.hits,t1.pcatid,t2.content,t3.catname,t4.catname as pcatname',array('News_data'=>'left','Category_new'=>'left','Category'=>'left'),'',
            $where,array('t1.addtime'=>'desc'),$limit);
        return $newsHot;

    }

    /**
     * 根据关键词获取推荐信息
     * @param $title string  关键字
     * @param $limit string limit
     * @return array
     */
    public function getNews($title,$limit){
        $newsHot = $this->SelectCommon('t1.catid,t1.addtime,t1.author,t1.title,t1.thumb,t1.itemid,t1.hits,t2.content'
            ,array('News_data'=>'left'),'', array('t1.status'=>3,'t1.title like'=>$title),array('t1.hits'=>'desc'),$limit);
        return $newsHot;

    }



    /**
     * 获取某分类下推荐信息(递归所有分类)
     * @param $catid int 新闻分类id
     * @param $level int 推荐级数
     * @param $limit string limit
     * @param $pcatid string/int 商品分类id
     * @return array
     */
    public function getNewsRecommend($catid,$level,$limit,$pcatid=''){

        $catids = $this->category_new->getAllChildCategory($catid,'catid');

        $where = array();
        if(!empty($catids))
        {
            $where['t1.catid in'] = $catids;
        }

        if(!empty($pcatid)){
            $where['t1.pcatid in'] = $pcatid;
        }

        $where['t1.status'] = 3;
        $where['t1.level'] = $level;
        $newsHot = $this->SelectCommon('t1.catid,t1.addtime,t1.level,t1.author,t1.title,t1.thumb,t1.itemid,t1.hits,t1.pcatid,t3.catname,t4.catname as pcatname,t2.content',
            array('News_data'=>'left','Category_new'=>'left','Category'=>'left'),'', $where,array('t1.addtime'=>'desc'),$limit);
        return $newsHot;

    }

    /**
     * 获取某个新闻详细信息
     * @param $itemid int 新闻id
     * @return array
     */
    public function getDetail($itemid){
        return $this->SelectCommon('t1.catid,t1.addtime,t1.author,t1.title,t1.thumb,t1.level,t1.itemid,t1.hits,t1.pcatid,t2.content,t3.catname,t4.catname as pcatname',array('News_data'=>'left','Category_new'=>'left','Category'=>'left'),'', array('t1.status'=>3,'t1.itemid'=>$itemid),'','','1');
    }



    /**
     * 统计某分类下所有分类（递归）新闻总数量
     * @param $catid    int 新闻分类
     * @param $pcatid   int 商品分类
     * @return int
     */
    public function getNewsCount($catid,$pcatid=''){
        $catids = $this->category_new->getAllChildCategory($catid,'catid');
        $re = $this->SelectCommon('count(*) as num',array('News_data'=>'left'),'',array('t1.catid in'=>$catids,'t1.pcatid in'=>$pcatid),'','',1);
        return $re['num'];

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