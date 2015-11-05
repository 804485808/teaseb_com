<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('comm_model','comm');
        $this->load->model('tagindex_model','tagindex');
        $this->load->model('sell_model','sell');
	}
	
	public function index(){
        $this->update_img();
        $data['url'] = "index";
		$data['username'] = $this->username;
		$this->config->set_item("compress_output",TRUE);
		$this->load->helper('inflector');
		$site = $this->config->item("site");
		$data['site'] = $site;

		$data['country'] = array("China","India","Japan","Malaysia","Thailand","Turkey","USA","Vietnam");		

        //关键词封装
        $re_tagindex = $this->tagindex->getRoundTagindex();

        $data['keywords'] = $re_tagindex;

        //获取最新商品
        $selllist = $this->sell->getLatestProducts('0,10');
		$data['selllist'] = $selllist;

        //获取最新供应商
        $this->load->model('member_model','member');
        $this->load->model('company_model','company');
        $data['comlist'] = $this->company->SelectCommon('userid,username,company,business','','','','','0,9');
        $data['new_comlist'] = $this->company->SelectCommon('t1.userid,t1.username,t1.company,t1.business',array('Member'=>'left'),'','',array('t2.regtime'=>'desc'),'0,9');
        //获取最新询单信息
        $this->load->model('inquiry_model','inquiry');
        $data['NewInquiry'] = $this->inquiry->getNewInquiry('0,10');

        //获取最热门商品
        $hot_pros = $this->sell->getHotProducts('0,15');

        //商品属性
        $this->load->model('category_option_model','category_option');
        foreach($hot_pros as $k=>$v){

            $re = $this->category_option->getSellOption($v['pptword'],$v['itemid']);
            $hot_pros[$k]['attr'] = array_slice($re,0,3);
        }
        unset($hot_pros[2]);
		if(!$hot_pros){
			$hot_pros = array();
		}

		$data['hot_pros'] = $hot_pros;
        $this->load->model('category_model','category');

        $top_cates = $this->category->SelectCommon('catid,catname,linkurl','','',array('parentid'=>'0','item <>'=>'0'),array('hits'=>'desc','letter'=>'asc'));

		$top_cates_1 = array_slice($top_cates,0,16);
        $top_cates_other = array_slice($top_cates,17);
        $data['top_cates_other'] = $top_cates_other;
        //调整Other Motors顺序
        foreach($top_cates_1 as $k=>$v){
            if($v['catid']==587){
                $otherArr = $v;
                unset($top_cates_1[$k]);
            }
            if($v['catid']==2051){
                $hubMotors = $v;
                unset($top_cates_1[$k]);
               $re = $this->category->SelectCommon('catid,catname,linkurl','','',array('catid'=>'1104'),'','',1);
               $MotorParts = $re;
            }


        }
        $top_cates_1[]=$otherArr;
        $top_cates_1[]=$MotorParts;

		$count_cates = count($top_cates);
		$top_cates_2 = array();
		if($count_cates > 8){
			$top_cates_2 = array_slice($top_cates,8,$count_cates-8);
		}

		$data['top_cates_1'] = $top_cates_1;			
		$data['top_cates_2'] = array_chunk($top_cates_2,20);

		$sub_cate=array();
		foreach($top_cates_1 as $s=>$t){
            $sub_cate[$t['catid']] = $this->category->SelectCommon('catid,catname,linkurl','','',array('parentid'=>$t['catid'],'item <>'=>'0'),array('hits'=>'desc','letter'=>'asc'));
		}
		$data['sub_cate'] = $sub_cate;

        $this->load->model('company_model','company');

        $data['senior_com'] = $this->company->SelectCommon('userid,username,company','','',array('company !='=>' '),array('vip'=>'desc'),'0,10');
        $showcase = $this->sell->SelectCommon('*','','',array('level'=>'1'),'','0,8');
		if(!$showcase){
			$showcase = array();
		}

		$data['showcase_1'] = array_shift($showcase);
		$showcase = array_chunk($showcase,4);

        $this->load->model('area_model','area');
		if(isset($showcase[0])){
			foreach($showcase[0] as $x=>$z){
                $area = $this->area->getAreaName($z['areaid']);
				$showcase[0][$x]['areaname'] = $area['areaname'];
			}
		}

		if(isset($showcase[1])){
			foreach($showcase[1] as $n=>$m){
                $user = $this->member->SelectCommon('userid','','',array('username'=>$m['username']),'','',1);
				$showcase[1][$n]['userid'] = $user['userid'];
			}
		}

        $this->load->model('news_model','news');
        $this->load->model('category_new_model','category_new');

        //获取技术
        $tempTechnology = $this->category_new->getShowCategory('Technology');
        $data['mobile_technology'] = $tempTechnology;
        $arr = array();
        foreach($tempTechnology as $k=>$v){
                $arr[$v['catname']][] = $v;
        }
        $data['technology'] = array_slice($arr,0,3);

        //获取展会
        $tempExhibition = $this->category_new->getShowCategory('Exhibition');
        $data['exhibition'] = array_slice($tempExhibition,0,7);
        //获取行情
        $tempCompany = $this->category_new->getShowCategory('Company News');
        $tempIndustry = $this->category_new->getShowCategory('Industry News');
        $re2 = array_merge_recursive($tempCompany,$tempIndustry);

        $arr = array();
        foreach($re2 as $k=>$v){
            $arr[$v['catname']][] = $v;
        }
        $data['market'] = array_slice($arr,0,2);

        //获取新闻排行
        $this->load->model('news_model','news');
        $data['newsTop'] = $this->news->getNewsTop('0,12');
        //hot news
        $data['hotNews'] = $this->news->SelectCommon('*','','','',array('hits'=>'desc'),'0,8');
        //获取价格
        $temp = $this->sell->getHotProductPrice(4);

        $data['productPrice'] = $temp;
		$data['showcase'] = $showcase;
		header('Content-Language:en');

        $data['title'] = "Motors-biz.com, Comprehensive Portal on Motor Products, Information, Exhibitions, Price, Suppliers, Buyers, Manufacturers";
        $data['description']="Motors-biz.com, a promising comprehensive portal for motor products, helps you to select suitable motor products. Learn about latest price and information on technology, news and exhibitions, find quality suppliers, buyers and manufacturers.";

        $data['mob'] = true;
        $data['pc_url'] = "http://www.motors-biz.com";
        $this->load->view('header', $data);
        $this->load->view('main');
        $this->load->view('footer');

	}

    public function update_img(){
        $this->getHtml();die;
        $this->load->model('info_model','info');
        $this->load->library('image');
        $allInfo = $this->info->SelectCommon('*','','','');

        header("Content-Type:text/html;charset=UTF-8");
        foreach($allInfo as $k=>$v){

            //sell:thumb
//             if(preg_match_all('/\.(\d+)x(\d+)/',$v['thumb'],$imgwh)){
//                 $thumb = str_replace($imgwh[0][0],'',$v['thumb']);
//             }else{
//                 $thumb = $v['thumb'];
//             }
//            $thumb = $this->image->getImage($thumb);
//            $this->image->imageWaterMark($thumb,5,'E:\teaseb_com\public_html\img\teaseb\sell_img\water\back1.jpg');
//            $thumb = str_replace('E:/teaseb_com/public_html','',$thumb);
//            $saveSell['thumb'] = $thumb;


            //sell:title
            $saveSell['title'] = $v['title'];

            //sell:num_price unit

                     //num1
            if(preg_match_all('/[\x7f-\xff]+/',$v['num1'],$re)){
                $unit = $re[0][0];
                $num1 = trim(str_replace($unit,'',$v['num1']));

            }else{
                $unit = '';
                $num1 = trim($v['num1']);
            }

                     //num2
            if(preg_match_all('/[\x7f-\xff]+/',$v['num2'],$re)){
                $num2 = trim(str_replace($unit,'',$v['num2']));
            }else{
                $num2 = trim($v['num2']);
            }

                    //num3
            if(preg_match_all('/[\x7f-\xff]+/',$v['num3'],$re)){
                $num3 = trim(str_replace($unit,'',$v['num3']));
            }else{
                $num3 = trim($v['num3']);
            }

            $num_price = $num1.":".$v['price1']."|".$num2.":".$v['price2']."|".$num3.":".$v['price3'];

            $saveSell['num_price'] = $num_price;
            $saveSell['unit'] = $unit;

            //sell:username
            $saveSell['username'] = $v['company_username']?$v['company_username']:$v['copany_username1'];

            //sell:telephone
            $saveSell['telephone'] = $v['telphone'];

            //sell:company
            $saveSell['company'] = $v['company_name']?$v['company_name']:$v['company_name1'];

            //sell:

        }


    }

    public function getHtml(){

        $url = "http://detail.1688.com/offer/520958674568.html?tracelog=p4p";
        $content = file_get_contents($url);
        echo "DFSsd";
        echo $content;die;
    }



}


