<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class index extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->library('image');
        header('Content-type:text/html;charset=utf-8');
    }

    public function index(){
        $file = "E:/teaseb_com/data/16.txt";
        $data = file_get_contents($file);
//        $data = iconv("UTF-8", "GB2312//IGNORE", $data);
//        echo $data;die;

        $saveSell = array();

//title
        preg_match_all("/title:(.*)price/Uis",$data,$re);
        $title = trim(strip_tags($re[1][0]));
        $saveSell['title'] = $title;

//price
        preg_match_all("/price:(.*)thumb/Uis",$data,$re);
        $price = trim(strip_tags($re[1][0]));
        $saveSell['price'] = $price;

//thumb
      /*  preg_match_all("/thumb:(.*)canshu/Uis",$data,$re);
        $tempUrl =  $re[1][0];
        preg_match_all("/jqimg='(.*)'/Uis",$tempUrl,$turl);
        $thumb = $turl[1][0];

        $urlArr = explode('/',$thumb);
        $endUrl = $urlArr[count($urlArr)-1];

        //下载图片 加水印
        $tempUrl = $this->downImg($thumb);
        $saveSell['thumb'][0] = $tempUrl?$tempUrl:'';
        for($i=1;$i<4;$i++){
            $arr = explode('_',$endUrl);

            $downloadImg = str_replace($arr[0],$arr[0]."_".$i,$endUrl);

            $downloadImg = str_replace($endUrl,$downloadImg,$thumb);

           // sell:thumb
            $tempUrl = $this->downImg($downloadImg);
            $saveSell['thumb'][$i] = $tempUrl?$tempUrl:'';
        }*/

//option_value
        preg_match_all("/canshu:(.*)content/Uis",$data,$re);
        $tempTable = $re[1][0];

        //explain
        preg_match_all("/<p class=\"mar_t15\">(.*)<\/p>/Uis",$tempTable,$re);
        $explain = trim(strip_tags($re[1][0]));
        $saveSell['explain'] = $explain;

        //value
        preg_match_all("/<tbody>(.*)<\/tbody>/Uis",$tempTable,$re);
        $tempValue = $re[1][0];
        $tempArr = explode('</tr>',$tempValue);
        unset($tempArr[0]);

        foreach($tempArr as $k=>$v){

            if(preg_match_all("/<td><b>(.*)(：)*\s*<\/b><\/td>/Uis", $v, $re)) {
                $saveSell['option_value'][$k]['option'] = str_replace("&nbsp;", "", trim(strip_tags($re[1][0])));
            }

            if(preg_match_all("/<td><span(.*)>(.*)\s*<\/span><\/td>/Uis", $v, $re)){
                $saveSell['option_value'][$k]['value'] = str_replace("&nbsp;", "", trim(strip_tags($re[2][0])));
            }

        }
        $saveSell['option_value'] = array_filter($saveSell['option_value']);

//content
      /*  preg_match_all("/content:(.*)\s*<\/textarea>\s*fangfa/Uis",$data,$re);
        $tempContent = trim($re[1][0]);

        //下载content图片
        preg_match_all("/<img\s*src=\"(.*)\"/Uis",$tempContent,$re);
        $tempArrImg = $re[1];
        foreach($tempArrImg as $k=>$v){
            $thumb = $this->downImg($v);
            $tempContent = str_replace($v,$thumb,$tempContent);
        }
        $saveSell['content'] = $tempContent;*/

//Instructions

        /*preg_match_all("/fangfa:\s*(.*)\s*<\/textarea>/Uis",$data,$re);
        $tempInstructions = trim($re[1][0]);

        //下载Instructions图片
        preg_match_all("/<img\s*src=\"(.*)\"/Uis",$tempInstructions,$re);
        $tempArrImg = $re[1];
        foreach($tempArrImg as $k=>$v){
            $thumb = $this->downImg($v);
            $tempInstructions = str_replace($v,$thumb,$tempInstructions);
        }
        $saveSell['instructions'] = $tempInstructions;*/

        dump($saveSell);die;

        dump($saveSell);die;

    }

    //下载图片 加水印
    public function downImg($thumb){
        $tempThumb = $this->image->getImage($thumb);
        if($tempThumb){
            $this->image->imageWaterMark($tempThumb, 5, 'E:\teaseb_com\public_html\img\teaseb\sell_img\water\back1.jpg');
            $tempThumb = str_replace('E:/teaseb_com/public_html', '', $tempThumb);
            return $tempThumb;
        }else{
            return false;
        }
    }
}