<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Slist extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('comm_model','comm');
	}

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

        //did
        $did = $this->uri->rsegment(4,0);
        if(preg_match("/(.*)+[_oid_]+(.*)/",$did,$re)){
            $did = array($re[2]);
        }else{
            $did = '';
        }

        //分页
        $page_size=18;
        $page = $this->uri->rsegment(5,0);
        $data['page'] = $page = intval($page);
        $data['NowPage'] = ($page/$page_size)+1;
        $data['page_size'] = 18;

        //catid
        $tagid=intval($this->uri->rsegment(3,0));

        $linkurl=urldecode($this->uri->rsegment(4,''));
        if(!$tagid){
            show_404();
            die();
        }else{
            $thistag = $this->comm->find("tagindex",array("id"=>$tagid));
            if(!$thistag){
                show_404();
                die();
            }
            if(!$linkurl or stripos($linkurl,$thistag['linkurl'])===false){
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".site_url("slist/".__FUNCTION__."/".$thistag['id']."/".$thistag['linkurl']));
                die();
            }
            //elseif($linkurl=="cid_0_".$thistag['linkurl']."_oid_0"){
            //	$linkurl=$thistag['linkurl'];
            //}
        }

        $data['thistag'] = $thistag;
        if(stripos($linkurl,"cid_")!==false || stripos($linkurl,"oid_")!==false){
            $tag=explode("_",$linkurl);

            $thecatid=$tag[1];
            $theoid=array_pop($tag);
            if($theoid){
                $theoid=array($theoid);
            }else{
                $theoid=array();
            }
            if($thecatid){
                $re = $this->category->getCategoryCommon('arrchildid',"catid='{$thecatid}'",'','',1);
                if($re['arrchildid']) {
                    $sphinxCatid = explode(',', $re['arrchildid']);
                }else{
                    $sphinxCatid = array($thecatid);
                }
            }

        }


        $tag=$thistag['tag'];

        $thiscat = $catid_0=$this->comm->find("category",array("catid"=>$thistag['catid']));
        if(empty($thiscat['arrchildid'])){
            $thiscat['arrchildid'] = $thistag['catid'];
        }

        $catname = $thiscat['catname'];



        if ($catid_0) {

            $catid = intval($catid_0['catid']);
            if(!$catid){
                show_404();
                die();
            }
            $re = $this->category->getCategoryCommon('catid,arrchildid,linkurl,catname,arrparentid',"catid={$catid}",'','',1);
			
			if($re['parentid']!=0){
				$parentid = explode(',',$re['arrparentid']);
				$parentid = $parentid[1];
				$pre = $this->category->getCategoryCommon('catname,linkurl,catid',"catid={$parentid}",'','',1);
				//二级分类
				$data['parent'] = $pre;
			}
            

            $data['thisUrl'] = $re['linkurl'];
            $data['catid'] = $catid;
            $data['nowcat'] = $re;

            if($re['arrchildid']){

                $data['pcat'] = $pcat = $this->comm->findAll("category","catid in({$re['arrchildid']})");
                $spChild = explode(',',$re['arrchildid']);
            }
            if(!$spChild){
                $spChild = array($catid);
            }


            if($spChild){
                $did='';
            }
            //sphinx 属性 查询
            $this->load->library('Sphinx','sphinx');
            $res = $this->sphinx->getTagAttr($tag,0,88);

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
            $tagcatid='';

            $re = $this->sphinx->getTagSell($tag,$page,$page_size,$sphinxCatid,$theoid);

            $data['sell_count']=$re['total_found'];
            $sell_count=$re['total_found'];

            $country = file_get_contents('./skin/country.txt');
            $sellList = array();
            foreach($re['matches'] as $k=>$v){
                $itemid = $v['id'];
                $re = $this->sell->getSellCompany($itemid,$country);
                $sellList[$itemid] = $re;
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
            $re = $this->sell->getSellCommon('itemid,subtitle,title,linkurl,username,thumb',"catid = {$catid}",'','hits desc','0,6');
            $data['hostProduct'] = $re;

            $data['ProductPrice1'] = $ProductPrice;
            //分页
            $data['total_count']=$sell_count;
            $thislinkurl=$this->uri->rsegment(4,'');
            $cons = $thistag['linkurl'];

            $base_url = site_url("slist/".__FUNCTION__."/".$thistag['id']."/".$thislinkurl);
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
            $config['cur_tag_open'] = '<span class="current">';
            $config['cur_tag_close'] = '</span>';
            $this->pagination->initialize($config);
            $data['pages'] = $pages = $this->pagination->create_links();
            $data['mobPageUrl'] = "slist/".__FUNCTION__."/".$thistag['id']."/".$thislinkurl;



        }
        //You like
        $re = $this->category->getCategoryCommon('arrchildid,parentid',"catid = '{$catid}'",'','',1);
        $parentid = $re['parentid'];
		if($parentid != 0){
			$re = $this->category->getCategoryCommon('arrchildid',"catid = '{$parentid}'",'','',1);
		}
		

        $sre = $this->sell->getSellCommonLink('t1.itemid,t1.subtitle,t1.title,t1.thumb,t1.minprice,t1.currency,t1.username,t1.unit,t1.minamount,t2.areaname',array('wl_sell'=>'t1'),
            array('Area'=>'t2'),"t1.catid in ({$re['arrchildid']})","t1.hits desc","","0,6");




        $data['mayLike'] = $sre;
		
		//related searchs
		if($thiscat['parentid']!=0){
			$parentid = explode(',',$thiscat['arrparentid']);
			$parentid = $parentid[1];
			$pre = $this->category->getCategoryCommon('catname,linkurl,catid',"catid={$parentid}",'','',1);
		}else{
			$pre = $thiscat;
		}
		
		$attrlink = $this->comm->findAll("attrtag",array("catid"=>$pre['catid']),"id asc","","0,10");
		foreach($attrlink as $k =>$v){
			$attrlink[$k]['tag'] = $v['tag']." ".$pre['catname'];
		}
		$data['attrlink'] = $attrlink;

        //keywords
        $re = $this->sphinx->getCategoryTag($catname);
        if(!empty($re['matches'])){
            foreach($re['matches'] as $jh){
                $kw[] = $this->comm->find("tagindex",array("id"=>$jh['id']));
            }
        }

        $data['keywords'] = $kw;


        $data['country'] = array("China","India","Japan","Malaysia","Thailand","Turkey","USA","Vietnam");

        $data['title'] = $thistag['tag']." Price, Suppliers, Manufacturers on ".$site['site_name'];


        $data['pc_url'] = str_replace('m.motors-biz.com','www.motors-biz.com',site_url("slist/".__FUNCTION__."/".$thistag['id']."/".$thislinkurl."/".$page));
        $data['header_name'] = $thistag['linkurl'];
        $this->load->view('header',$data);
        $this->load->view('slist');
        $this->load->view('footer');
    }
}