<?php
/**
 * Created by PhpStorm.
 * User: ydsq4
 * Date: 2015/10/12
 * Time: 14:17
 */
class Catalog extends MY_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->model('tagindex_model','tagindex');
    }

    public function index(){
        $site = $this->config->item("site");
        $data['site'] = $site;
        $catid = $this->uri->rsegment(3,0);
        $linkurl = $this->uri->rsegment(4,0);
        $catid = intval($catid);
        $this->load->model('news_model','news');
        $this->load->model('inquiry_model','inquiry');
        $this->load->model('area_model','area');
        $this->load->model('sell_model','sell');
        $this->load->model('category_model','category');
        $this->load->model('category_option_model','category_option');

        $thiscat = $this->category->SelectCommon('*','','',array("catid"=>$catid),'','',1);
        $data['thiscat'] =  $thiscat;
        if(!$thiscat){
            show_404();
            die();
        }else{
            if($linkurl!==$thiscat['linkurl']){
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".site_url("catalog/".__FUNCTION__."/".$thiscat['catid']."/".$thiscat['linkurl']));
                die();
            }
        }
        $area = $this->area->SelectCommon("areaname,areaid",'','');
        foreach($area as $k=>$v)
        {
            $areas[$v['areaid']] = $v['areaname'];
        }

        //点击量
        $this->db->set("hits","hits+1",FALSE);
        $this->db->where("catid",$thiscat['catid']);
        $this->db->update("category");
        $thiscat['arrchildid'] = $thiscat['arrchildid'] ? $thiscat['arrchildid'] : $thiscat['catid'];
        $cat_list = $thiscat['arrchildid'];

        //分类
        $second_cat=$this->category->SelectCommon('*','','',array('parentid'=>$thiscat['catid'],'item <>'=>'0'),array('hits'=>'desc','letter'=>'asc'),"0,20");
        $data['second_cat'] = $second_cat ? array_chunk($second_cat,ceil(count($second_cat)/2),true) : $second_cat;

        //价格
        $productPrice = $this->sell->getHotCategoryPrice($cat_list,4);
        $data['productPrice'] = $productPrice;

        //最新产品
        $new_sell = $this->sell->SelectCommon('unit,minamount,minprice,currency,itemid,areaid,title,thumb,linkurl,username,subtitle','','',
            array('status'=>'3','catid in'=>$cat_list),array('addtime'=>'desc'),"0,4");
        foreach($new_sell as $k =>$v){
            $new_sell[$k]['areaname'] =  $areas[$v['areaid']];
        }
        $data['new_sell'] = $new_sell;

        //热门产品
        $hot_pros = $this->sell->SelectCommon('unit,minamount,minprice,currency,itemid,areaid,title,thumb,linkurl,username','','',
            array('status'=>'3','catid in'=>$cat_list),array('hits'=>'desc'),"0,4");
        foreach($hot_pros as $k =>$v){
            $hot_pros[$k]['areaname'] =  $areas[$v['areaid']];
        }
        $data['hot_pros'] = $hot_pros;

        //推荐阅读
        $newsRecommend = $this->news->getNewsRecommend('','1','0,10');
        foreach($newsRecommend as $k =>$v){
            $newsRecommend[$k]['content'] = strip_tags($v['content']);
        }
        $data['newsRecommend'] = $newsRecommend;

        //展会
        $exhibition = $this->news->getNewsDetail(4,'0,10');
        foreach($exhibition as $k =>$v){
            $exhibition[$k]['content'] = strip_tags($v['content']);
        }
        $data['exhibition'] = $exhibition;

        //获取最新询单信息
        $data['newInquiry'] = $this->inquiry->getNewInquiry('0,13');

        //关键词封装
        $re_tagindex = $this->tagindex->getRoundTagindex();
        $data['keywords'] = $re_tagindex;
        $data['pc_url'] = str_replace('m.motors-biz.com','www.motors-biz.com',site_url("catalog/".__FUNCTION__."/".$thiscat['catid']."/".$thiscat['linkurl']));
        $data['header_name'] = $thiscat['catname'];
        $this->load->view('header',$data);
        $this->load->view('second_cat');
        $this->load->view('footer');
    }

}
