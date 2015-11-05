<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "main";
$route['404_override'] = '';
$route['products_(\d+)[/]?(.*?)'] = "slist/index/$1/$2";
$route['items'] = "sell_list/index";
$route['item/(:any)'] = "sell_detail/index/$1";
$route['items/(:any)'] = "sell_list/index/$1";
$route['attr/(:any)'] = "attr_list/index/$1";
$route['category/(:any)'] = "catalog/index/$1";
//$route['home'] = "company/index";
$route['products_list'] = "company/sell_list";
$route['products_list/(:any)'] = "company/sell_list/$1";
$route['information'] = "company/info";
$route['contact'] = "company/contact";
$route['search/([a-z0-9A-Z\-]+)[/]?(.*?)'] = "search/index/$1";



$route['sitemap'] = "sitemap/index";
$route['sitemap/(:any)'] = "sitemap/index/$1";

$route['news_(\d+)/(:any)'] = "news/index/$1";
$route['regstep2'] = "reg_login/register_step2";
$route['regstep3/(:any)'] = "reg_login/register_step3/$1";
$route['register'] = "reg_login/register";
$route['login'] = "reg_login/login_in";
/* End of file routes.php */
/* Location: ./application/config/routes.php */