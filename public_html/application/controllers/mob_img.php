<?php
class Mob_img extends MY_Controller{
    function __construct()
    {
        parent::__construct();
    }

    //改变图片大小
    public function img(){
        $this->config->load("mob_image",true);
        $temp = $this->config->item("mob_image");
        $config = $temp['mob_config'];

        $img = $this->uri->uri_string;
        $tempUrl = explode('mob_img/img',$img);

        //自定义宽高，默认200*200
        if(strstr($tempUrl[1],'w/') || strstr($tempUrl[1],'h/')){
            $tempUrl[1] .= "/";
            $startW = strpos($tempUrl[1],'w/')?strpos($tempUrl[1],'w/'):0;
            $startH = strpos($tempUrl[1],'h/')?strpos($tempUrl[1],'h/'):0;
            if($startH && $startW){
                $startEnd = $startH>$startW?$startW:$startH;


            }elseif($startH && !$startW){
                $startEnd = $startH;
            }elseif(!$startH && $startW){
                $startEnd = $startW;
            }

            preg_match('/w\/(.+?)\//',$tempUrl[1],$temp);
            $wight = $temp[1];

            preg_match('/h\/(.+?)\//',$tempUrl[1],$temp);
            $hight = $temp[1];

            $config['width'] = $wight;//设置你想要得图像宽度。
            $config['height'] = $hight;//设置你想要得图像高度

            $thumb = substr($tempUrl[1],0,$startEnd-1);
            $imgUrl = "/webimage/img/www_motors_biz_com/public_html".$thumb;

        }else{
            $imgUrl = "/webimage/img/www_motors_biz_com/public_html".$tempUrl[1];
        }

//        $imgUrl = "E:/webimage/img/www_motorsbiz_com/public_html/ueditor/php/upload/image/20150828/1440730774753744.jpg";


        $this->load->library('image_lib');

        $config['source_image'] = $imgUrl;//(必须)设置原始图像的名字/路径


        $this->image_lib->initialize($config);
        $re = $this->image_lib->display_resize();
        header('Content-type: image/jpeg');
        imagejpeg($re);
    }
}