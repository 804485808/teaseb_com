<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['mob_config']['image_library'] = 'gd2';//(必须)设置图像库
$config['mob_config']['dynamic_output'] = true;//决定新图像的生成是要写入硬盘还是动态的存在
$config['mob_config']['quality'] = '90%';//设置图像的品质。品质越高，图像文件越大
$config['mob_config']['width'] = 200;//(必须)设置你想要得图像宽度。
$config['mob_config']['height'] = 200;//(必须)设置你想要得图像高度
$config['mob_config']['create_thumb'] = TRUE;//让图像处理函数产生一个预览图像(将_thumb插入文件扩展名之前)
$config['mob_config']['thumb_marker'] = '_thumb';//指定预览图像的标示。它将在被插入文件扩展名之前。例如，mypic.jpg 将会变成 mypic_thumb.jpg
$config['mob_config']['maintain_ratio'] = TRUE;//维持比例
$config['mob_config']['master_dim'] = 'auto';//auto, width, height 指定主轴线