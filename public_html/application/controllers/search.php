<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Search extends MY_Controller{
    public function index(){

        $this->load->helper('inflector');
        $this->load->model('category_model','category');
        $this->load->model('category_default_option_model','categoryDO');
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

        $this->load->service('pub_service','service');
        $this->load->service('tagindex_service','tagindex');

        $kw = $this->input->post('input_text');
        if(!$kw){
            $kw = $this->uri->segment(2,0);
            if(strstr($kw,'_cid_')){
                $thislinkurl = $kw;

                if(preg_match('/_did_(\d+)/',$thislinkurl,$re)) {
                    $did = $re[1];
                }else{
                    $did = '';
                }

                if(preg_match('/_cid_(\d+)/',$thislinkurl,$re)){
                    $cid = $re[1];
                }else{
                    $cid = '';
                }
                $re = explode('_did_',$kw);
                $kw = $re[0];
                $kw = preg_replace("/%20/"," ",$kw);
            }
        }

        if(preg_match("/[^0-9a-z]/i",$kw)){
            $kw = preg_replace("/[^0-9a-z]|'s/i"," ",$kw);
            $kw = preg_replace("/[\s]{2,}/i"," ",trim($kw));
        }


        $data['kw'] = str_replace("-"," ",$kw);


        //分页
        $page_size=18;
        $page = $this->uri->segments;
        $page = $page[3];
        $data['page'] = $page = intval($page);
        $data['NowPage'] = ($page/$page_size)+1;
        $data['page_size'] = $page_size;



            //sphinx 属性 查询
            $this->load->library('Sphinx','sphinx');

            $res = $this->sphinx->getTagAttr($kw,0,88);

            $attr = array();
            foreach($res[1]['matches'] as $k=>$v){
                $id = $v['attrs']['@groupby'];
                if($id) {
                    $did_value = $this->comm->find("category_default_option",array("id"=>$id));
                    $did_option = $this->comm->find("category_option",array("oid"=>$did_value['oid']));
                    $attr[$did_option['name']][$k] = $did_value;
                    $attr[$did_option['name']][$k]['cnum'] = $v['attrs']['@count'];
                }

            }

            //分类
            $cateChild = array();

            foreach(array_slice($res[0]['matches'],0,20) as $k=>$v){
                $catidd = $v['attrs']['catid'];
                $cateChild[$catidd] = $this->category->getCategoryCommon('catname,catid,linkurl',"catid='{$catidd}'",'','',1);
                $cateChild[$catidd]['cnum'] = $v['attrs']['@count'];
            }

            $data['cateChild'] = $cateChild;
            $catid = array_pop($cateChild);
            $catid = $catid['catid'];
            if(!$catid){
                $catid=1;
            }
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
            if($cid){
                $spCatid = array($cid);
            }else{
                $spCatid = '';
            }

            if($did){
                $spDid = array($did);
            }else{
                $spDid = '';
            }


            $re = $this->sphinx->getTagSell($kw,$page,$page_size,$spCatid,$spDid);

            $data['sell_count']=$re['total_found'];
            $sell_count=$re['total_found'];

            $country = file_get_contents(base_url('/skin/country.txt'));
            $sellList = array();
            foreach($re['matches'] as $k=>$v){
                $itemid = $v['id'];
                $re = $this->sell->getSellCompany($itemid,$country);
                $sellList[$itemid] = $re;
            }

        //关键词高亮
        $opt = array("before_match"=>"<font style='font-weight:bold;color:#f00'>","after_match"=>"</font>");
        foreach($sellList as $k=>$v){
            $tempArr = array($v['title']);
            $rows = $this->sphinx->buildExcerpts($tempArr,"sell_total",$kw,$opt);
            $sellList[$k]['title'] = $rows[0];
        }
            $data['sellList'] = $sellList;

            //Product price
            $ProductPrice = array();
            foreach($sellList as $k=>$v){
                $ProductPrice[$k]['itemid'] = $v['itemid'];
                $ProductPrice[$k]['title'] = $v['title'];
                $ProductPrice[$k]['username'] = $v['username'];
                $ProductPrice[$k]['linkurl'] = $v['linkurl'];
                $ProductPrice[$k]['price'] = $v['minprice']>0 ? $v['currency']." ".$v['minprice'] : "Negoti..";
                $name = '';
                foreach($v['attr'] as $vv){
                    $name = strtolower($vv['name']);
                    if($name=='voltage'){
                        $ProductPrice[$k]['voltage'] = $vv['value'];
                    }

                    if($name=='power'||$name=='max output power'||$name=='horse power'||$name=='rated output power'||$name=='power supply'||$name=='compressor power'){
                        $ProductPrice[$k]['power'] = $vv['value'];
                    }
                }

            }


            //host products
            $re = $this->sell->getSellCommon('itemid,title,linkurl,username,thumb',"catid = {$catid}",'','hits desc','0,6');

            $data['hostProduct'] = $re;

            $data['ProductPrice1'] = $ProductPrice;
            //分页
            $data['total_count']=$sell_count;
            $cons = $thislinkurl;
            $base_url = site_url("search/".$cons);
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
            $config['anchor_class'] = "class='pro_page'";
            $config['cur_tag_open'] = '<span class="current">';
            $config['cur_tag_close'] = '</span>';
            $this->pagination->initialize($config);
            $data['pages'] = $pages = $this->pagination->create_links();
            $data['mobPageUrl'] = "search/".$kw;


        //You like
        $re = $this->category->getCategoryCommon('parentid,catname',"catid = '{$catid}'",'','',1);

        $parentid = $re['parentid'];
        $catname = $re['catname'];
       if(!$parentid){
           $parentid=1;
       }
        $re = $this->category->getCategoryCommon('arrchildid',"catid = '{$parentid}'",'','',1);

        $sre = $this->sell->getSellCommonLink('t1.itemid,t1.subtitle,t1.title,t1.thumb,t1.minprice,t1.currency,t1.username,t1.unit,t1.minamount,t2.areaname',array('wl_sell'=>'t1'),
            array('Area'=>'t2'),"t1.catid in ({$re['arrchildid']})","t1.hits desc","","0,6");




        $data['mayLike'] = $sre;


        //keywords
        $re = $this->sphinx->getCategoryTag($catname);

        if(!empty($re['matches'])){
            foreach($re['matches'] as $jh){
                $kw1[] = $this->comm->find("tagindex",array("id"=>$jh['id']));
            }
        }


        $data['keywords'] = $kw1;


        $data['country'] = array("China","India","Japan","Malaysia","Thailand","Turkey","USA","Vietnam");

        $data['title'] = "Guide for ".$thislinkurl." Motors, Suppliers Information, Hot Products, Newest Product, Product Price, ".$thislinkurl." Motors for Sale on motors-biz.com";

        $data['description']="Provide product attributes for filtering, including brand, place of origin, voltage,
         power, product condition, etc. Trade platform for buying hot and newest motors and contacting suppliers, learning about suppliers information.";


        $data['pc_url'] = str_replace('m.motors-biz.com','www.motors-biz.com',site_url("search/".$kw."/".$page));
        $this->load->view('header',$data);
        $this->load->view('search_index');
        $this->load->view('footer');




    }
}