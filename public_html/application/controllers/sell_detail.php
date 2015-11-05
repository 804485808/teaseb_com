<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sell_detail extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('comm_model','comm');
	}
	
	public function index(){
		$this->load->helper('inflector');
		$site = $this->config->item("site");
		$data['site'] = $site;
        $data['header_name'] = "Product Detail";
		
		$itemid = intval($this->uri->rsegment(3,0));
		if(!$itemid){
			show_404();
			die();
		}

        $this->load->model('sell_model','sell');
        $product = $this->sell->getSellCommon('*',"itemid='{$itemid}'",'','','',1);
		if(!$product){
			show_404();
			die();
		}
		$sell_linkurl = $this->uri->rsegment(4,'');

		if(!$sell_linkurl or stripos($sell_linkurl,$product['linkurl'])===false){
			header("HTTP/1.1 301 Moved Permanently"); 
			header("Location: ".site_url("sell_detail/".__FUNCTION__."/".$itemid."/".$product['linkurl']));
			die();
		}

        //hits+1
        $this->sell->addSellHits($itemid);

        $this->load->model('category_model','category');
        $cat = $this->category->getCategoryCommon('*',"catid='{$product['catid']}'",'','',1);

        $pcat = $this->category->getCategoryCommon('*',"catid in ({$cat['arrparentid']})");


		$data['pcat'] = $pcat;
		$data['cat'] = $cat;


        $this->load->library('Sphinx','','seSphinx');

        $res = $this->seSphinx->getTagindex($cat['catname']);

		$keywords=array();
		if(isset($res['matches'])){
			foreach($res['matches'] as $jh){
				$keywords[] = $this->comm->find("tagindex",array("id"=>$jh['id']));
			}
		}else{
			$keywords = $this->comm->findAll("tagindex","","","","0,5");
		}
		$data['keywords'] = $keywords;
		if($product['itemid']<1000000){
			$data['title'] = $product['title']." - ".$product['subtitle']." On ".$site['site_name'];
		}else{
			$data['title'] = $product['subtitle']." From ".$product['company']." ".$product['itemid']." On ".$site['site_name'];
		}
		
		
		
		//Related Searches
		$tagids = array();
		$res = $this->seSphinx->getTagindex($product['title']);
		if(isset($res['matches'])){
			foreach($res['matches'] as $r){
				$tagids[] = $r['id'];
			}
			$tagids = implode(",",$tagids);
			$related_search = $this->comm->findAll("tagindex","id in({$tagids})");
			$data['related_search'] = $related_search;
		}
		
		
		$com_data = $this->comm->find("company",array("username"=>$product['username']),"","*");


        $data['com_data'] = $com_data;

        $this->load->model('type_model','type');

        $res = $this->type->getTypeCommon('tname,tid',"userid='{$com_data['userid']}'");
        $types = '';
        $typesId = '';
        foreach(array_slice($res,0,10) as $v){
            $types .=$v['tname'].',';
            $typesId .=$v['tid'].',';
        }

        $data['types'] = $types;
		$data['com_type'] = $res;

        //供应商推荐商品
        $typesId = substr($typesId,0,-1);
        if($typesId) {
            $res = $this->sell->getSellCommon('*', "mycatid in ({$typesId})",'', 'hits desc', '0,6');
        }else{
            $res = '';
        }
        $data['com_products'] = $res;
		//dump($data['com_type']);


		$sell_areaname = $this->comm->find("area",array("areaid"=>$product['areaid']),"","areaname");
		$product['sell_areaname'] = $sell_areaname['areaname'];
		
		$product['typeid']=$this->comm->find("type",array("tid"=>$product['mycatid']));
		
		$sell_content=$this->comm->find("sell_data",array("itemid"=>$itemid));
		$product['content']=$sell_content['content'];
		


        $country = file_get_contents('./skin/country.txt');
        $re = $this->sell->getSellCompany($itemid,$country);

        $com_areaname = $this->comm->find("area",array("areaid"=>$com_data['areaid']),"","areaname");
        $re['com_areaname'] = $com_areaname['areaname'];

        $content = $this->comm->find("sell_data",array("itemid"=>$itemid),"","content");
        $re['content'] = $content['content'];
		$re['content']=preg_replace("/<(\/?div.*?)>/si","",$re['content']);
		
		$data['product'] = $re;
		$product = $re;

		
		//products vs
        $country = file_get_contents('./skin/country.txt');
        $results  = $this->seSphinx->getSellTotal($product['title']);
        foreach($results['matches'] as $v){
            $itemid = $v['id'];
            $re = $this->sell->getSellCompany($itemid,$country);
            $sellList[$itemid] = $re;
        }
        $arr = array_pop($sellList);
        $option = $arr['attr'];
        $likeSell = $sellList;
        $data['option'] = $option;
        $data['likeSell'] = $likeSell;


        //$data['title'] = "Submersible ".$product['subtitle'].", buy Submersible  Water filled Motor L8 for deepwell of 200mm (8&quot;) for sale, wound rotor induction motors, three phase wound rotor induction motors, squirrel cage and wound rotor induction motors in Induction Motors On motors-biz.com";

        $data['pc_url'] = str_replace('m.motors-biz.com','www.motors-biz.com',site_url("sell_detail/index/".$data['product']['itemid']."/".$data['product']['linkurl']));
        $this->load->view('header',$data);
        $this->load->view('sell_detail');
        $this->load->view('footer');




	}	
}