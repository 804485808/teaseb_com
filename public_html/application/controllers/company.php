<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Company extends CI_Controller {
	function __construct(){
		parent::__construct();
        $this->load->model('tagindex_model','tagindex');
	}


    //供应商
    public function suppliers(){

        $site = $this->config->item("site");
        $data['site'] = $site;
        $url_name = $this->uri->rsegment(3,0);
        $url = $this->uri->rsegment(1,0);
        $data['header_name'] = "Suppliers";

        $data['url'] = $url;
        $tid = explode("_", $url_name);

        //pc地址
        $tid[0] = empty($url_name)? "Category" : $tid[0];
        $temp_url = empty($url_name)? site_url("company/".__FUNCTION__) : site_url("company/".__FUNCTION__."/".$url_name);
        $data['pc_url'] = str_replace('m.motors-biz.com','www.motors-biz.com',$temp_url);

        //分页
        $page_size = empty($tid[2])? 30 :$tid[2];
        $data['page_size'] = $page_size;
        $page = $this->uri->rsegment(4,0);
        $data['page'] = $page = intval($page);
        $data['page_num'] = ($page/$page_size)+1;
        if(!empty($page))
        {
            $data['pc_url'] = str_replace('m.motors-biz.com','www.motors-biz.com',site_url("company/".__FUNCTION__."/".$url_name."/".$page));
        }

        $this->load->model('category_model','category');
        $this->load->model("sell_model","sell");
        $this->load->model("company_model","company");
        $this->load->model("area_model","area");
        $this->load->library('Sphinx','sphinx');
        $this->load->model('tagindex_model','tagindex');

        //关键词封装
        $re_tagindex = $this->tagindex->getRoundTagindex();
        $data['keywords'] = $re_tagindex;

        //分类
        $category_type = $category_hot_type = $this->category->getCategoryCommon('catid,catname,linkurl,arrchildid',"parentid = 0",'hits desc,letter asc','0,20');

        foreach($category_type as $key=>$value)
        {
            $category_num = $this->category->getCategoryCommon('catid,catname,linkurl,company_num',"catid =".$value['catid'],'','',1);
            $category_type[$key]['num'] = $category_num['company_num'];
        }
        $category_arr= array();
        foreach ($category_type as $v) {
            $category_arr[] = $v['num'];
        }
        array_multisort($category_arr, SORT_DESC, $category_type);

        $res = $this->sphinx->getCompany('');
        foreach($res['matches'] as $k => $v)
        {
            $markets_type[$k] = $v['attrs'];
        }

        $business_type = $this->sphinx_company('mode');
        foreach($business_type as $k=>$v) {
            if (empty($v['mode'])) {//判断是否为空（false）
                unset($business_type[$k]);//删除
            }
        }

        $volume_type = $this->sphinx_company('volume');
        foreach($volume_type as $k=>$v) {
            if (!$v['volume']) {//判断是否为空（false）
                unset($volume_type[$k]);//删除
            }
        }

        $country_type = $this->sphinx_company('areaid');
        $area = $this->area->SelectCommon("areaname,areaid",'','');
        foreach($area as $k=>$v)
        {
            $areas[$v['areaid']] = $v['areaname'];
        }
        foreach($country_type as $k => $v)
        {
            $country_type[$k]['name'] = $areas[$v['areaid']];
        }

        //markets_type
        $markets = array();
        $markets_one = array();
        foreach($markets_type as $k => $v)
        {
            $markets[] = explode(';',$v['markets']);
        }
        foreach($markets as $k => $v)
        {
            foreach($v as $k => $v)
            {
                if(!empty($v)) {
                    $markets_one[] = trim($v);
                }
            }
        }
        $markets_type = array_count_values($markets_one);

        //供应商列表
        if($tid[0] == "Category")
        {
            if(empty($tid[1]))
            {
                $cat_list = $category_type[0]['arrchildid'];
                $new_list = explode(',',$cat_list);
            }
            else
            {
                $cat_list =  $this->category->getCategoryCommon('arrchildid',"catid = ".$tid[1],'hits desc,letter asc','',1);
                $cat_list =  $cat_list['arrchildid'];
                $new_list = explode(',',$cat_list);
            }
            $res = $this->sphinx->getCategorySup($page,$page_size,$new_list);
            foreach($res['matches'] as $k => $v) {
                $category_sup[$k] = $v['attrs'];
            }

            if($res['total_found'] < 1000) {
                $sell_count = $res['total_found'];
            }
            else
            {
                $sell_count = 1000;
            }

            foreach($category_sup as $k =>$v)
            {
                $category_list[$k] = $this->company->getCompanyCommon('userid,mode,business,markets,volume,export,company,username',"username = '".$v['username']."'",'','','',1);
                $category_list[$k]['sell'] = $this->sell->getSellCommon('linkurl,itemid,thumb,username,title',"username = '".$v['username']."'",'','','0,4');
            }
            $list = $category_list;

            //最新产品
            $list_sell = $this->list_sell($cat_list);
        }
        elseif($tid[0] == "Business")
        {
            $tid[1] = str_replace("%20", " ", $tid[1]);
            $tid[1] = substr($tid[1],0,15);
            $sell = $this->sell("mode like '".$tid[1]."%'",$page,$page_size);
            $list = $sell['list'];
            $sell_count = $sell['sell_count'];
            //最新产品
            $list_sell = $this->list_sell($sell['cat_name']);
        }
        elseif($tid[0] == "Markets")
        {
            $tid[1] = str_replace("%20", " ", $tid[1]);
            $sell = $this->sell("markets like '".$tid[1]."%'",$page,$page_size);
            $list = $sell['list'];
            $sell_count = $sell['sell_count'];
            //最新产品
            $list_sell = $this->list_sell($sell['cat_name']);
        }
        elseif($tid[0] == "Volume")
        {
            $tid[1] = str_replace("%20", " ", $tid[1]);
            $tid[1] = str_replace("%C2%A0", "&nbsp;", $tid[1]);
            $sell = $this->sell("volume = '".$tid[1]."'",$page,$page_size);
            $list = $sell['list'];
            $sell_count = $sell['sell_count'];
            //最新产品
            $list_sell = $this->list_sell($sell['cat_name']);
        }
        elseif($tid[0] == "Country")
        {
            $tid[1] = str_replace("%20", " ", $tid[1]);
            $sell = $this->sell("areaid = '".$tid[1]."'",$page,$page_size);
            $list = $sell['list'];
            $sell_count = $sell['sell_count'];
            //最新产品
            $list_sell = $this->list_sell($sell['cat_name']);
        }

        $data['new_sell'] = $list_sell['new_sell'];
        $data['hot_pros'] = $list_sell['hot_pros'];
        //分页
        $base_url = "company/".__FUNCTION__."/".$url_name;
        $data['base_url'] = $base_url;
        $data['total_page']=ceil($sell_count/$page_size);
        $data['tid'] =$page_size;

        //关键词封装
        $re_tagindex = $this->tagindex->getRoundTagindex();
        $data['keywords'] = $re_tagindex;

        $data['title'] = "Motor Suppliers Directory- Reliable and Senior Motor Suppliers and Manufacturers on Motors-biz.com";
        $data['description']="Find directory of motor suppliers and manufacturers. The trade platform for choosing quality verified motor manufacturers and global buyers is provided on motor-biz.com.";
        $data['category_type'] = $category_type;
        $data['category_hot_type'] = $category_hot_type;
        $data['business_type'] = $business_type;
        $data['markets_type'] = $markets_type;
        $data['volume_type'] = $volume_type;
        $data['country_type'] = $country_type;
        $data['list'] = $list;
        $this->load->view('header',$data);
        $this->load->view('company/suppliers');
        $this->load->view('footer');
    }

    //产品(最新，热门)
    public function list_sell($userid_list)
    {
        if(empty($userid_list))
        {
            return;
        }
        $new_sell = $this->sell->getSellCommon('unit,minamount,minprice,currency,itemid,areaid,title,thumb,linkurl,username'
            ,"status = 3 and userid in({$userid_list})",'','addtime desc',"0,8");
        $data['new_sell'] = $new_sell;
        $hot_pros = $this->sell->getSellCommon('unit,minamount,minprice,currency,itemid,areaid,title,thumb,linkurl,username'
            ,"status = 3 and userid in({$userid_list})",'','hits DESC',"0,5");
        $data['hot_pros'] = $hot_pros;
        return $data;
    }

    //属性产品
    public function sell($where,$page,$page_size)
    {
        $company_sup = $this->company->getCompanyCommon('username,userid',$where,'','hits desc',"$page,$page_size");
        $company_num = $this->company->getCompanyCommon('username,userid',$where);
        $data['sell_count'] = count($company_num);

        foreach($company_sup as $k =>$v)
        {
            $company_list[$k] = $this->company->getCompanyCommon('userid,mode,business,markets,volume,export,company,username',"username = '".$v['username']."'",'','','',1);
            $company_list[$k]['sell'] = $this->sell->getSellCommon('userid,catid,linkurl,itemid,thumb,username,title',"username = '".$v['username']."'",'','','0,4');
            $cat_name[] = $v['userid'];
        }
        $cat_name = implode(',',$cat_name);
        $list = $company_list;
        $data['list'] = $list;
        $data['cat_name'] = $cat_name;
        return $data;
    }
    public function sphinx_company($attr)
    {
        $res = $this->sphinx->getCompany($attr);
        foreach($res['matches'] as $k => $v)
        {
            $company_type[$k] = $v['attrs'];
        }
        return $company_type;
    }

    //m.motors-biz 公司首页
    public function companyDetail(){

        $this->load->helper('inflector');
        $this->load->model('company_model','company');
        $this->load->model('sell_model','sell');

        $username = $this->uri->rsegment(3,0);
        if(!$username){
            show_404();
            die();
        }


        $companyDetail = $this->company->SelectCommon('*','','',array('username'=>$username),'','',1);
        $data['header_name'] = "Company Profile";
        if(!$companyDetail){
            show_404();
            die;
        }


        $data['companyDetail'] = $companyDetail;

        $pages = $this->uri->rsegment(4,0);


        $page_size = 20;
        $data['page_size'] = $page_size;
        $data['NowPage'] = ($pages/$page_size)+1;
        $limit = $pages.",".$page_size;

        $companySell =  $this->sell->SelectCommon('*','','',array('username'=>$username,'status'=>'3'),array('addtime'=>'desc'),$limit);
        $data['companySell'] = $companySell;
//        dump($companySell);die;
        $sell_count =  $this->sell->SelectCommon('count(*) as num','','',array('username'=>$username,'status'=>'3'),array('addtime'=>'desc'),'',1);
        $sell_count = $sell_count['num'];


        //分页
        $data['total_count']=$sell_count;
        $thislinkurl=$this->uri->rsegment(4,'');
        $base_url = site_url("company/index/".$username);
        $data['total_page']=ceil($sell_count/$page_size);
        $this->load->library('pagination');
        $config['base_url'] = $base_url;
        $config['total_rows'] = $sell_count ? $sell_count : 0;
        $config['per_page'] = $page_size;
        $config['uri_segment'] = 4;
        $config['num_links'] = 4;
        $config['suffix'] = $this->config->item('url_suffix');
        $config['first_link']='first';
        $config['last_link']='last';
        $config['anchor_class'] = "class='pro_page' rel='nofollow'";
//            $config['cur_tag_open'] = '<span class="current">';
        $config['cur_tag_open'] = '<span class="current">';
        $config['cur_tag_close'] = '</span>';
        $this->pagination->initialize($config);
        $data['pages'] = $pages = $this->pagination->create_links();
        $data['mobPageUrl'] = "company/".__FUNCTION__."/".$username;

        $data['title'] = $companyDetail['company']." on motors-biz.com";
        $data['pc_url'] = "http://".$username.".motors-biz.com";


        $this->load->view('header',$data);
        $this->load->view('company/index');
        $this->load->view('footer');
    }

    public function companyInfo(){

        $this->load->helper('inflector');
        $this->load->model('company_model','company');
        $this->load->model('sell_model','sell');
        $data['header_name'] = "Company Info";

        $username = $this->uri->rsegment(3,0);
        if(!$username){
            show_404();
            die;
        }

        $companyDetail = $this->company->SelectCommon('*','','',array('username'=>$username),'','',1);

        if(!$companyDetail){
            show_404();
            die;
        }


        $data['companyDetail'] = $companyDetail;
        $data['title'] = $companyDetail['company']." on motors-biz.com";
        $data['pc_url'] = "http://".$username.".motors-biz.com";

        $this->load->view('header',$data);
        $this->load->view('company/companyInfo');
        $this->load->view('footer');
    }

}