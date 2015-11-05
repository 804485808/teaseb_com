<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['pattern']=array();
$config['replace']=array();

$config['pattern'][0]='/slist\/index\/(\d+)\/(.*)/isU';
$config['replace'][0]='/products_$1/$3';

$config['pattern'][1]='/sell_list\/index/isU';
$config['replace'][1]='/items';

$config['pattern'][2]='/sell_detail\/index\//isU';
$config['replace'][2]='/item/';

$config['pattern'][3]='/catalog\/index\//isU';
$config['replace'][3]='/category/';

//$config['pattern'][4]='/company\/index\//isU';
//$config['replace'][4]='';

$config['pattern'][5]='/company\/sell_list/isU';
$config['replace'][5]='/products_list';

$config['pattern'][6]='/company\/info/isU';
$config['replace'][6]='/information';

$config['pattern'][7]='/company\/contact/isU';
$config['replace'][7]='/contact';

$config['pattern'][8]='/sitemap\/index/isU';
$config['replace'][8]='/sitemap';

$config['pattern'][9]='/news\/index\/(\d+)\//isU';
$config['replace'][9]='/news_$1/';

$config['pattern'][10]='/reg_login\/register_step2/isU';
$config['replace'][10]='regstep2';
$config['pattern'][11]='/reg_login\/register_step3/isU';
$config['replace'][11]='regstep3';
$config['pattern'][12]='/reg_login\/register/isU';
$config['replace'][12]='register';
$config['pattern'][13]='/reg_login\/login_in/isU';
$config['replace'][13]='login';
$config['pattern'][14]='/attr_list\/index/isU';
$config['replace'][14]='/attr';

$config['pattern'][15]='/company\/index/isU';
$config['replace'][15]='/company/companyDetail';

$config['pattern'][16]='/company\/companyInfo/isU';
$config['replace'][16]='/company/companyInfo';