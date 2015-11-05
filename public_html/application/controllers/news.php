<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class news extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('comm_model','comm');
        $this->load->model('tagindex_model','tagindex');
    }

    public function index(){
        $site = $this->config->item("site");
        $data['site'] = $site;
        $url = $this->uri->rsegment(1,0);
        $data['url'] = $url;
        $data['header_name'] = "Information";
        $this->load->model('category_new_model','category_new');
        $this->load->model('news_model','news');

        //获取新闻分类
        $category_new = $this->category_new->getChildCategory('1');

        //获取新闻分类信息
        $newsDetail = Array();
        foreach($category_new as $k =>$v){
            if($k>5) {break;}
            $newsDetail[$k]['catid'] = $v['catid'];
            $newsDetail[$k]['catname'] = $v['catname'];
            $newsDetail[$k]['catid'] = $v['catid'];
            $temp_news = $this->news->getNewsDetail($v['catid'],'0,11');
            foreach($temp_news as $key=>$v)
            {
                $news_one = strip_tags($v['content']);
                $temp_news[$key]['content'] = str_replace("&nbsp;", " ", $news_one);
            }
            $newsDetail[$k][$k] = $temp_news;
        }
        //新闻Technology(技术)
        $technology_new = $this->category_new->getChildCategory('0');
        unset($technology_new[0]);

        //获取Technology(技术)分类信息
        $technologyDetail = Array();
        foreach($technology_new as $k =>$v){
            $technologyDetail[$k]['catid'] = $v['catid'];
            $technologyDetail[$k]['catname'] = $v['catname'];
            $technologyDetail[$k]['catid'] = $v['catid'];
            $news= $this->news->getNewsDetail($v['catid'],'0,11');
            foreach($news as $key=>$v)
            {
                $news_one = strip_tags($v['content']);
                $news[$key]['content'] = str_replace("&nbsp;", " ", $news_one);
            }
            $technologyDetail[$k][$k] = $news;
        }

        //热门阅读
        $newsHot = $this->news->getNewsHot('','0,10');
        foreach($newsHot as $k=>$v)
        {
            $temp_news = strip_tags($v['content']);
            $newsHot[$k]['content'] = str_replace("&nbsp;", " ", $temp_news);
        }
        //推荐阅读
        $newsRecommend = $this->news->getNewsRecommend('','1','0,10');
        foreach($newsRecommend as $k=>$v)
        {
            $temp_recommend = strip_tags($v['content']);
            $newsRecommend[$k]['content'] = str_replace("&nbsp;", " ", $temp_recommend);
        }
        //最新阅读
        $latestNews= $this->news->getLatestNews('0,10');
        foreach($latestNews as $k=>$v)
        {
            $temp_news = strip_tags($v['content']);
            $latestNews[$k]['content'] = str_replace("&nbsp;", " ", $temp_news);
        }

        //关键词封装
        $re_tagindex = $this->tagindex->getRoundTagindex();
        $data['keywords'] = $re_tagindex;

        $data['newsHot'] =$newsHot;
        $data['newsDetail'] = $newsDetail;
        $data['newsRecommend'] = $newsRecommend;
        $data['latestNews'] = $latestNews;
        $data['technologyDetail'] = $technologyDetail;
        $data['title'] = "Motor Information Space on Technology, Exhibitions, News, Business Celebrities";
        $data['description']="Find helpful information on motors including technical articles, company news, industry news, business celebrities, the latest exhibitions.";
        $data['pc_url'] = str_replace('m.motors-biz.com','www.motors-biz.com',site_url("news/".__FUNCTION__));
        header('Content-Language:en');
        $this->load->view('header',$data);
        $this->load->view('news/news_index');
        $this->load->view('footer');
    }


    //浏览量
    public function quantity($itemid,$hits)
    {
        $update_arr = array(
            'hits' => $hits+1
        );
        return $this->news->updata($itemid, $update_arr);
    }

    //日期格式
    public function newsData($time)
    {
        $data[D]   =  date( "d",$time);
        $data[M]   =  date( "M",$time);
        $data[Y]   =  date( "Y",$time);
        return $data;
    }

    //信息评论
    public function newsReview()
    {
        $itemid = $this->uri->rsegment(3,0);
        $date = array();
        $date['itemid'] = intval($itemid);
        $date['content'] =$_POST['content'];
        $date['time'] = time();
        $this->load->model('news_review_model','news_review');
        $this->news_review->addReview($date);
        echo $_POST['content'];
    }

    //新闻详情
    public function newsDetail()
    {
        //获取参数
        $itemid = $this->uri->rsegment(3,0);
        $itemid = intval($itemid);
        $site = $this->config->item("site");
        $data['site'] = $site;
        $this->load->model('news_model','news');
        $this->load->model('sell_model','sell');
        $this->load->model('category_new_model','category_new');
        $this->load->model('news_review_model','news_review');

        //查询信息列表
        $newsDetail = $this->news->getDetail($itemid);
        $newsDetail['data'] = $this->newsData($newsDetail['addtime']);
        $newsDetail['content'] = str_replace("&nbsp;", " ", $newsDetail['content']);
        $newsDetail['content'] = preg_replace("/style=.+?['|\"]/i",'',$newsDetail['content']);//去除样式

        $category_news = $this->category_new->SelectCommon('','','',array('catid'=>$newsDetail['catid']),'','',1);
        //信息评论
        $newsReview = $this->news_review->getNewsReview($itemid,'0,5');
        foreach($newsReview as $k=>$v) {
            $newsReview[$k]['time'] = date('Y-m-d H:i:s', $v['time']);
        }
        $newsDetail['newsReview'] = $newsReview;
        $newsDetail['count']=$sell_count= $this->news_review->getNewsReviewCount($itemid);

        //相关阅读
        $newsRelated = $this->news->getNewsDetail($newsDetail['catid'],'0,10');

        //获取最新商品
        $hot_pros = $this->sell->get_sells_cates('0,4');

        //关键词封装
        $re_tagindex = $this->tagindex->getRoundTagindex();
        $data['keywords'] = $re_tagindex;

        $data['header_name'] = $category_news['catname'];
        $data['pc_url'] = str_replace('m.motors-biz.com','www.motors-biz.com',site_url("news/".__FUNCTION__."/".$itemid));
        $data['hot_pros'] = $hot_pros;
        $data['newsDetail'] = $newsDetail;
        $data['newsRelated'] = $newsRelated;
        $this->load->view('header',$data);
        $this->load->view('news/newsDetail');
        $this->load->view('footer');
    }
    //新闻列表
    public function newsList()
    {
        $catid = $this->uri->rsegment(3,0);
        $catid = intval($catid);
        $site = $this->config->item("site");
        $data['site'] = $site;
        $page = $this->uri->rsegment(4,0);
        $data['page'] = $page = intval($page);
        $page_size = 10;
        if(!empty($page)) {
            $data['pc_url'] = str_replace('m.motors-biz.com','www.motors-biz.com',site_url("news/" . __FUNCTION__ . "/" . $catid. "/" . $page));
        }else
        {
            $data['pc_url'] = str_replace('m.motors-biz.com','www.motors-biz.com',site_url("news/" . __FUNCTION__ . "/" . $catid));
        }
        $data['page_size'] = $page_size;
        $data['page_num'] = ($page/$page_size)+1;
        $this->load->model('news_model','news');
        $this->load->model('category_new_model','category_new');

        $temp_name = $this->category_new->SelectCommon('catname','','',array('catid'=>$catid),'','',1);
        $data['catname'] = $temp_name['catname'];

        $temp_list = $this->news->getCategoryNewsList($catid,"$page,$page_size");
        $sell_count = $this->news->getNewsCount($catid);
        $data['newsList'] = $temp_list;

        //分页
        $base_url = "news/".__FUNCTION__."/".$catid;
        $data['base_url'] = $base_url;
        $data['total_page']=ceil($sell_count/$page_size);

        //关键词封装
        $re_tagindex = $this->tagindex->getRoundTagindex();
        $data['keywords'] = $re_tagindex;

        $data['title'] = "Motor Information ".$data['catname'].", Recommended products, Hot news on Motors-biz.com";
        $data['description']="Supply you with an intelligible motor information list with technology, news on company and industry, business celebrities. Conveniently learn about recommended products and hot news.";
        $data['header_name'] = $temp_name['catname'];
        $this->load->view('header',$data);
        $this->load->view('news/newsList');
        $this->load->view('footer');
    }

}
