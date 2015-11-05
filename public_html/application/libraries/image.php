<?php
class image{
    /*
    * 下载图片
    */
    public function getImage($url){
        $filename = '';
        if($url==""):return false;endif;
        if($filename=="") {
            $ext=strrchr($url,".");
            if($ext!=".gif" && $ext!=".jpg"):return false;endif;
            $filename=date("dMYHis").rand(0,999).$ext;
            $directory = $_SERVER['DOCUMENT_ROOT']."/img/teaseb/sell_img/".date('Y-m-d',time());
            if(!is_dir($directory)){
                if(mkdir($directory,777,true)){
                    echo "创建目录失败";die;
                }
            }

        }
        $filename = $directory."/".$filename;
        ob_start();
       if(readfile($url)) {
           $img = ob_get_contents();
           ob_end_clean();
           $size = strlen($img);
           $fp2 = @fopen($filename, "a");
           fwrite($fp2, $img);
           fclose($fp2);
           return $filename;
       }else{
           return false;
       }
    }

    /*

    * 功能：PHP图片水印 (水印支持图片或文字)

    * 参数：

    *$groundImage 背景图片，即需要加水印的图片，暂只支持GIF,JPG,PNG格式；

    *$waterPos水印位置，有10种状态，0为随机位置；

    *1为顶端居左，2为顶端居中，3为顶端居右；

    *4为中部居左，5为中部居中，6为中部居右；

    *7为底端居左，8为底端居中，9为底端居右；

    *$waterImage图片水印，即作为水印的图片，暂只支持GIF,JPG,PNG格式；

    *$waterText文字水印，即把文字作为为水印，支持ASCII码，不支持中文；

    *$textFont文字大小，值为1、2、3、4或5，默认为5；

    *$textColor文字颜色，值为十六进制颜色值，默认为#FF0000(红色)；

    *

    * 注意：Support GD 2.0，Support FreeType、GIF Read、GIF Create、JPG 、PNG

    *$waterImage 和 $waterText 最好不要同时使用，选其中之一即可，优先使用 $waterImage。

    *当$waterImage有效时，参数$waterString、$stringFont、$stringColor均不生效。

    *加水印后的图片的文件名和 $groundImage 一样。

    * 作者：

    */
    function imageWaterMark($groundImage,$waterPos=0,$waterImage="",$waterText="",$textFont=5,$textColor="#FF0000")

    {
//        header('Content-Type:text/html;charset=UTF-8');
        $isWaterImage = FALSE;

        $formatMsg = "暂不支持该文件格式，请用图片处理软件将图片转换为GIF、JPG、PNG格式。";

        //读取水印文件

        if(!empty($waterImage) && file_exists($waterImage))

        {

            $isWaterImage = TRUE;

            $water_info = getimagesize($waterImage);

            $water_w = $water_info[0];//取得水印图片的宽

            $water_h = $water_info[1];//取得水印图片的高

            switch($water_info[2])//取得水印图片的格式

            {

                case 1:$water_im = imagecreatefromgif($waterImage);break;

                case 2:$water_im = imagecreatefromjpeg($waterImage);break;

                case 3:$water_im = imagecreatefrompng($waterImage);break;

                default:die($formatMsg);

            }

        }

        //读取背景图片

        if(!empty($groundImage) && file_exists($groundImage))

        {

            $ground_info = getimagesize($groundImage);

            $ground_w = $ground_info[0];//取得背景图片的宽

            $ground_h = $ground_info[1];//取得背景图片的高

            switch($ground_info[2])//取得背景图片的格式

            {

                case 1:$ground_im = imagecreatefromgif($groundImage);break;

                case 2:$ground_im = imagecreatefromjpeg($groundImage);break;

                case 3:$ground_im = imagecreatefrompng($groundImage);break;

                default:die($formatMsg);

            }

        }

        else

        {

            die("需要加水印的图片不存在！");

        }

        //水印位置

        if($isWaterImage)//图片水印

        {

            $w = $water_w;

            $h = $water_h;

            $label = "图片的";

        }

        else//文字水印

        {

            $temp = imagettfbbox(ceil($textFont*5),0,"./cour.ttf",$waterText);//取得使用 TrueType 字体的文本的范围

            $w = $temp[2] - $temp[6];

            $h = $temp[3] - $temp[7];

            unset($temp);

            $label = "文字区域";

        }


        switch($waterPos)

        {

            case 0://随机

                $posX = rand(0,($ground_w - $w));

                $posY = rand(0,($ground_h - $h));

                break;

            case 1://1为顶端居左

                $posX = 0;

                $posY = 0;

                break;

            case 2://2为顶端居中

                $posX = ($ground_w - $w) / 2;

                $posY = 0;

                break;

            case 3://3为顶端居右

                $posX = $ground_w - $w;

                $posY = 0;

                break;

            case 4://4为中部居左

                $posX = 0;

                $posY = ($ground_h - $h) / 2;

                break;

            case 5://5为中部居中

                $posX = ($ground_w - $w) / 2;

                $posY = ($ground_h - $h) / 2;

                break;

            case 6://6为中部居右

                $posX = $ground_w - $w;

                $posY = ($ground_h - $h) / 2;

                break;

            case 7://7为底端居左

                $posX = 0;

                $posY = $ground_h - $h;

                break;

            case 8://8为底端居中

                $posX = ($ground_w - $w) / 2;

                $posY = $ground_h - $h;

                break;

            case 9://9为底端居右

                $posX = $ground_w - $w - 10;   // -10 是距离右侧10px 可以自己调节

                $posY = $ground_h - $h - 10;   // -10 是距离底部10px 可以自己调节

                break;

            default://随机

                $posX = rand(0,($ground_w - $w));

                $posY = rand(0,($ground_h - $h));

                break;

        }

        //设定图像的混色模式

        imagealphablending($ground_im, true);

        if($isWaterImage)//图片水印

        {

            imagecopymerge($ground_im, $water_im, $posX, $posY, 0, 0, $water_w,$water_h,60);//拷贝水印到目标文件
//            imagecopymerge($ground_im, $water_im, 0, $posY, 0, 0, $ground_w,$water_h,50);//拷贝水印到目标文件

        }

        else//文字水印

        {

            if( !emptyempty($textColor) && (strlen($textColor)==7) )

            {

                $R = hexdec(substr($textColor,1,2));

                $G = hexdec(substr($textColor,3,2));

                $B = hexdec(substr($textColor,5));

            }

            else

            {

                die("水印文字颜色格式不正确！");

            }

            imagestring ( $ground_im, $textFont, $posX, $posY, $waterText, imagecolorallocate($ground_im, $R, $G, $B));

        }

        //生成水印后的图片

        @unlink($groundImage);

        switch($ground_info[2])//取得背景图片的格式

        {

            case 1:imagegif($ground_im,$groundImage);break;

            case 2:imagejpeg($ground_im,$groundImage);break;

            case 3:imagepng($ground_im,$groundImage);break;

            default:die($errorMsg);

        }

        //释放内存

        if(isset($water_info)) unset($water_info);

        if(isset($water_im)) imagedestroy($water_im);

        unset($ground_info);

        imagedestroy($ground_im);

    }
}