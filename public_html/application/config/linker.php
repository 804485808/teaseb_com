<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['linker']['member'] = array(
	array(
		'type'=>'hasone', //关联类型  hasone 一对一 hasmany 一对多 manytomany 多对多
		'map'=>'mcompany', //关联标识
		'mapkey'=>'userid',  //主表关联的字段名
		'ftable'=>'company', //对应表的表名
		'fkey'=>'userid', //对应主表的关联字段名
		'condition'=>'',
		'sort'=>'',
		'field'=>'',
		'limit'=>'',
		'enabled'=>TRUE, //是否开启
	),
	array(
		'type'=>'hasone',
		'map'=>'company_data',
		'mapkey'=>'userid',
		'ftable'=>'company_data',
		'fkey'=>'userid',
		'condition'=>'',
		'sort'=>'',
		'field'=>'',
		'limit'=>'',
		'enabled'=>TRUE,
	)
);
$config['linker']['sell'] = array(
	array(
		'type'=>'hasone',
		'map'=>'sell_data',
		'mapkey'=>'itemid',
		'ftable'=>'sell_data',
		'fkey'=>'itemid',
		'condition'=>'',
		'sort'=>'',
		'field'=>'',
		'limit'=>'',
		'enabled'=>TRUE,
	)
);
$config['linker']['inquiry'] = array(
		array(
				'type'=>'hasone',
				'map'=>'inquiry_data',
				'mapkey'=>'id',
				'ftable'=>'inquiry_data',
				'fkey'=>'id',
				'condition'=>'',
				'sort'=>'',
				'field'=>'',
				'limit'=>'',
				'enabled'=>TRUE,
		)
);