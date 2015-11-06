<?php
class Category_new_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }



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

            $re = $this->SelectCommon('catid','','',array('catname'=>$Post['catname']),'','',1);
            if(empty($re) && $this->db->insert('category_new',$data)){
                return "保存成功";
            }else{
                return "已经存在";
            }
        }
    }

    /**
     * 获取所有顶级分类
     * @return array
     */
    public function getParentCategory(){
        return $this->SelectCommon('*','','',array('parentid'=>'0'));
    }

    /**
     * 获取某分类下所有分类（一级）
     * @param $catid
     * @return array|bool
     */
    public function getChildCategory($catid){

        $re = $this->SelectCommon('*','','',array('parentid'=>$catid),array('listorder'=>'asc'));
        if($re){
            return $re;
        }else{
            return false;
        }
    }


    /**
     * 获取某分类下所有的分类（递归）
     * @param $catid
     * @param $fields
     * @return string
     */
    public function getAllChildCategory($catid,$fields,$allChild=''){
        $re = $this->SelectCommon($fields,'','',array('parentid'=>$catid));
        if($re){
            foreach($re as $v){
                $allChild[] = $catid;
                $allChild[] = $v['catid'];
                $this->getAllChildCategory($v['catid'],$fields,$allChild);
            }
        }elseif(!$allChild){
            return $catid;
        }
        return implode(',',array_unique($allChild));
    }

    /**
     * 更加新闻分类名称查询该分类下的需要展示的新闻
     * @param $type 分类名称
     * @return array
     */
    public function getShowCategory($type,$limit='')
    {

        $re = $this->SelectCommon('catid','','',array('catname'=>$type),'','',1);
        $parentId = $re['catid'];
        if($limit){
            $limit = " limit ".$limit;
        }else{
            $limit = '';
        }

        $sql = "select * from (select t1.catid,t1.catname,t2.title,t2.itemid,t2.tag,t2.thumb,t2.level as l2,t1.level as l1,t3.content from wl_category_new as t1 LEFT JOIN wl_news as t2 on t1.catid=t2.catid
          LEFT JOIN wl_news_data as t3 ON t2.itemid=t3.itemid WHERE t1.parentid = '{$parentId}' and t1.status=1 and t2.status=3 ) as v ORDER BY v.l1  ASC, v.l2 ASC
          ".$limit;


        $query = $this->db->query($sql);

        $re =  $query->result_array();
        if(!$re){
            $sql = "select * from (select t1.catid,t1.catname,t2.title,t2.itemid,t2.tag,t2.thumb,t2.level as l2,t1.level as l1,t3.content from wl_category_new as t1 LEFT JOIN wl_news as t2 on t1.catid=t2.catid
          LEFT JOIN wl_news_data as t3 ON t2.itemid=t3.itemid WHERE t1.catid = '{$parentId}' and t1.status=1 and t2.status=3 ) as v ORDER BY v.l1  ASC, v.l2 ASC
          ".$limit;


            $query = $this->db->query($sql);
            $re =  $query->result_array();
        }
        return $re;

    }




}