<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sell_list extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('comm_model','comm');
	}

	public function index(){
        $data['header_name'] = "Product List";
        $this->load->helper('inflector');
        $this->load->model('category_model','category');
        $this->load->model('category_default_option_model','categoryDO');
        $this->load->model('category_option_model','category_option');
        $this->load->model('sell_model','sell');

		$data['username'] = $this->username;
		$this->load->service("url_service","urls");
		$current_url = $this->urls->curPageURL();
		if($current_url){
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: ".$current_url);
			die();
		}
		$site = $this->config->item("site");
		$data['site'] = $site;

        //did
        $did = $this->uri->rsegment(4,0);
        if(preg_match("/_oid_(\d+)/",$did)){
           $re = explode("_oid_",$did);
            $did = array($re[1]);
        }else{
            $did = '';
        }

        //分页
        if(strstr($this->uri->rsegment(4,0),'_ps_')){
            $re = explode('_ps_',$this->uri->rsegment(4,0));
            $page_size = $re[1];
        }else {
            $page_size = 20;
        }
        $data['page_size'] = $page_size;
        $page = $this->uri->rsegment(5,0);
        $data['page'] = $page = intval($page);
        $data['NowPage'] = ($page/$page_size)+1;
		 //catid
		$catid_0 = $this->uri->rsegment(3,0);
		$catid = str_ireplace("catid_","",$catid_0);
		$thiscat = $this->category->SelectCommon('catid,arrchildid,linkurl,catname,arrparentid','','',array('catid'=>$catid),'','',1);
		if(!$thiscat){

		}



        if (preg_match("/^[a-zA-Z]{1,}_[0-9]{1,}$/isU",$catid_0)) {
            $tid = explode("_",$catid_0);
            $catid = intval($tid[1]);
            if(!$catid){
                show_404();
                die();
            }
            $requestCategory = $this->category->SelectCommon('arrchildid,linkurl,catname,arrparentid','','',array('catid'=>$catid),'','',1);
            $parentid = explode(',',$requestCategory['arrparentid']);
            if(!$parentid[1]){
                $parentid = $catid;
            }else {
                $parentid = $parentid[1];
            }

            $pre = $this->category->SelectCommon('catname,linkurl,catid','','',array('catid'=>$parentid),'','',1);
            //二级分类
            $data['parent'] = $pre;

            $data['thisUrl'] = $requestCategory['linkurl'];
            $data['thisUrl1'] = str_replace('.html','',site_url("sell_list/index/catid_".$catid."/".$requestCategory['linkurl']));
            $data['catid'] = $catid;
            $data['nowcat'] = $requestCategory;

            if($requestCategory['arrchildid']){

                $data['pcat'] = $pcat = $this->category->SelectCommon('*','','',array('catid in'=>$requestCategory['arrchildid']));

                $spChild = explode(',',$requestCategory['arrchildid']);
            }

            if(!$spChild){
                $spChild = array($catid);
            }


            //sphinx 属性 查询
            $this->load->library('Sphinx','sphinx');
            $CategoryAttr = $this->sphinx->getCategoryAttr(0,88,$spChild,$did1='');

            $attr = array();
            foreach($CategoryAttr[1]['matches'] as $k=>$v){
                $id = $v['attrs']['@groupby'];
                if($id) {
                    $did_value = $this->categoryDO->SelectCommon('*','','',array('id'=>$id),'','',1);
                    $did_option = $this->category_option->SelectCommon('*','','',array('oid'=>$did_value['oid']),'','',1);
                    $attr[$did_option['name']][$k] = $did_value;
                    $attr[$did_option['name']][$k]['cnum'] = $v['attrs']['@count'];
                }

            }


            //分类
            $cateChild = array();
            foreach(array_slice($CategoryAttr[0]['matches'],0,15) as $k=>$v){
                $catidd = $v['attrs']['catid'];
                $cateChild[$catidd] = $this->category->SelectCommon('catname,catid,linkurl','','',array('catid'=>$catidd),'','',1);
                $cateChild[$catidd]['cnum'] = $v['attrs']['@count'];
            }

            $data['cateChild'] = $cateChild;

            //查询关键属性
            $attr1['Brand']=array();
            $attr1['Place Of Origin']=array();
            $attr1['Voltage']=array();
            $attr1['Power']=array();
            $i=0;
            foreach($attr as $k=>$v){

                //品牌
                if(strstr($k,'Brand')){
                  $attr1['Brand']=array_merge($attr1['Brand'],$v);
                }

                //产地
                if(strstr($k,'Place Of Origin')){
                    $attr1['Place Of Origin']=array_merge($attr1['Place Of Origin'],$v);
                }

                //电压
                if(strstr($k,'Voltage')){
                    $attr1['Voltage']=array_merge($attr1['Voltage'],$v);
                }

                //攻略
                if(strstr($k,'Power')){
                    $attr1['Power']=array_merge($attr1['Power'],$v);
                }
                //根据量查询
                if($i<5){
                    $attr1[$k]=$v;
                }
                $i++;
            }

            foreach($attr1 as $k=>$v){
                if(!$v){
                    unset($attr1[$k]);
                }
            }

            $data['attr'] = $attr1;

            //sell
            $sellResult = $this->sphinx->getCategorySell($page,$page_size,$spChild,$did);

            $data['sell_count']=$sellResult['total_found'];
            $sell_count=$sellResult['total_found'];

            $country = file_get_contents('./skin/country.txt');
            $sellList = array();
            foreach($sellResult['matches'] as $k=>$v){
                $itemid = $v['id'];
                $temp = $this->sell->getSellCompany($itemid,$country);
                $sellList[$itemid] = $temp;
            }

            $data['sellList'] = $sellList;
            //Product price
            $ProductPrice = $this->sell->getRandSell();
            $data['randSellPrice'] = $ProductPrice;


            //host products
            $hostProducts = $this->sell->SelectCommon('itemid,subtitle,title,linkurl,username,thumb,catid','','',array('catid'=>$catid),array('hits'=>'desc'),'0,6');
            $data['hostProduct'] = $hostProducts;


            //分页
            $data['total_count']=$sell_count;
            $thislinkurl=$this->uri->rsegment(4,'');
            $base_url = site_url("sell_list/".__FUNCTION__."/".$catid_0."/".$thislinkurl);
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
            $data['mobPageUrl'] = "sell_list/".__FUNCTION__."/".$catid_0."/".$thislinkurl;

        }



		//related searchs
		$attrlink = $this->comm->findAll("attrtag",array("catid"=>$pre['catid']),"id asc","","0,10");
		foreach($attrlink as $k =>$v){
			$attrlink[$k]['tag'] = $v['tag']." ".$pre['catname'];
		}

		$data['attrlink'] = $attrlink;

        //You like
        $temp = $this->category->SelectCommon('parentid,catname','','',array('catid'=>$catid),'','',1);
        $catname = $temp['catname'];
        if($temp['parentid']){
            $parentid = $temp['parentid'];
        }else{
            $parentid = $catid;
        }

        $temp = $this->category->SelectCommon('parentid,catname','','',array('catid'=>$parentid),'','',1);
		if(empty($temp['arrchildid'])){
            $temp['arrchildid'] = $catid;
		}

        $sre = $this->sell->SelectCommon('t1.itemid,t1.subtitle,t1.title,t1.thumb,t1.minprice,t1.currency,t1.username,t1.unit,t1.minamount,t2.areaname',array('Area'=>'left'),'',
            array('t1.catid in'=>$temp['arrchildid']),array('t1.hits'=>'desc'),'0,5');


        $data['mayLike'] = $sre;


        //keywords
        $temp = $this->sphinx->getCategoryTag($catname);

        if(!empty($temp['matches'])){
            foreach($temp['matches'] as $jh){
                $kw1[] = $this->comm->find("tagindex",array("id"=>$jh['id']));
            }
        }

        //一级分类
        $temp = $this->category->SelectCommon('catname,catid,linkurl','','',array('parentid'=>'0'),array('hits'=>'desc'),'0,30');
        $data['oneCategory'] = $temp;
        $data['keywords'] = $kw1;

		$data['country'] = array("China","India","Japan","Malaysia","Thailand","Turkey","USA","Vietnam");

		$thiscat = $this->comm->find("category",array("catid"=>$catid));

        $data['title'] = $thiscat['catname']." Price, Suppliers, Manufacturers on ".$site['site_name'];


//        dump($data['sellList']);die;
        $data['pc_url'] = str_replace('m.motors-biz.com','www.motors-biz.com',site_url("sell_list/".__FUNCTION__."/".$catid_0."/".$thislinkurl."/".$page));
        $this->load->view('header',$data);
        $this->load->view('sell_list');
        $this->load->view('footer');


	}



}