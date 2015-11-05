<?php
/**
 * Created by PhpStorm.
 * User: ydsq4
 * Date: 2015/10/12
 * Time: 14:17
 */
class Products extends MY_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->model('tagindex_model','tagindex');
    }
    public function index()
    {
        $site = $this->config->item("site");
        $data['site'] = $site;
        $data['header_name'] = "Products";
        $this->load->model('category_option_model','category_option');
        $this->load->model('sell_model','sell');

        //获取最新商品
        $selllist = $this->sell->getLatestProducts('0,10');
        $data['selllist'] = $selllist;

        //获取最热门商品
        $hot_pros = $this->sell->getHotProducts('0,15');
        //商品属性
        foreach($hot_pros as $k=>$v){

            $temp = $this->category_option->getSellOption($v['pptword'],$v['itemid']);
            $hot_pros[$k]['attr'] = array_slice($temp,0,3);
        }
        $data['hot_pros'] = $hot_pros;

        //价格
        $productPrice = $this->sell->getHotProductPrice(4);
        $data['productPrice'] = $productPrice;

        //关键词封装
        $re_tagindex = $this->tagindex->getRoundTagindex();
        $data['keywords'] = $re_tagindex;

        $this->load->view('header',$data);
        $this->load->view('product/product');
        $this->load->view('footer');
    }

    public function productList(){
        $data['header_name'] = "Categories";
        $this->load->model('category_model','category');
        $temp = $this->category->SelectCommon('catid,catname,linkurl','','',array('parentid'=>'0','item <>'=>'0'),array('hits'=>'desc','letter'=>'asc'));
        $top_cates = array_slice($temp,0,11);
        $data['top_cates'] = $top_cates;
        $this->load->view('header',$data);
        $this->load->view('product/productList');
    }

    //手机top加载
    public function ajax_product_list_top(){
        $this->load->model('category_model','category');
        $top_cates_num = $this->input->post('top_cates_num',TRUE);
        $temp = $this->category->SelectCommon('catid,catname,linkurl','','',array('parentid'=>'0','item <>'=>'0'),array('hits'=>'desc','letter'=>'asc'),"0,$top_cates_num");
        echo json_encode($temp);
    }

    //手机button加载
    public function ajax_product_list(){
        $this->load->model('category_model','category');
        $top_cates_num = $this->input->post('top_cates_num',TRUE);
        $temp = $this->category->SelectCommon('catid,catname,linkurl','','',array('parentid'=>'0','item <>'=>'0'),array('hits'=>'desc','letter'=>'asc'),"$top_cates_num,5");
        echo json_encode($temp);
    }

}
