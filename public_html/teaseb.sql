# Host: localhost  (Version: 5.5.40-log)
# Date: 2015-11-06 18:31:42
# Generator: MySQL-Front 5.3  (Build 4.120)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "wl_area"
#

DROP TABLE IF EXISTS `wl_area`;
CREATE TABLE `wl_area` (
  `areaid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `areaname` varchar(50) NOT NULL DEFAULT '',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0',
  `arrparentid` varchar(255) NOT NULL DEFAULT '',
  `child` tinyint(1) NOT NULL DEFAULT '0',
  `arrchildid` text,
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`areaid`)
) ENGINE=MyISAM AUTO_INCREMENT=110 DEFAULT CHARSET=utf8 COMMENT='地区';

#
# Data for table "wl_area"
#

/*!40000 ALTER TABLE `wl_area` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_area` ENABLE KEYS */;

#
# Structure for table "wl_attrtag"
#

DROP TABLE IF EXISTS `wl_attrtag`;
CREATE TABLE `wl_attrtag` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tag` varchar(150) NOT NULL,
  `linkurl` varchar(255) NOT NULL,
  `catid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tag` (`tag`)
) ENGINE=MyISAM AUTO_INCREMENT=73061 DEFAULT CHARSET=utf8;

#
# Data for table "wl_attrtag"
#

/*!40000 ALTER TABLE `wl_attrtag` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_attrtag` ENABLE KEYS */;

#
# Structure for table "wl_banword"
#

DROP TABLE IF EXISTS `wl_banword`;
CREATE TABLE `wl_banword` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `replacefrom` varchar(255) NOT NULL DEFAULT '' COMMENT '查找',
  `replaceto` varchar(255) NOT NULL DEFAULT '' COMMENT '替换',
  `deny` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否拦截',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=356 DEFAULT CHARSET=utf8 COMMENT='词语过滤';

#
# Data for table "wl_banword"
#

/*!40000 ALTER TABLE `wl_banword` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_banword` ENABLE KEYS */;

#
# Structure for table "wl_brand"
#

DROP TABLE IF EXISTS `wl_brand`;
CREATE TABLE `wl_brand` (
  `brandId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '品牌名称',
  `thumb` varchar(255) DEFAULT NULL COMMENT 'logo图片',
  `hits` int(11) DEFAULT '0' COMMENT '点击量',
  `addtime` int(11) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`brandId`),
  KEY `brand_name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=30255 DEFAULT CHARSET=utf8 COMMENT='品牌表';

#
# Data for table "wl_brand"
#

/*!40000 ALTER TABLE `wl_brand` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_brand` ENABLE KEYS */;

#
# Structure for table "wl_brand_value"
#

DROP TABLE IF EXISTS `wl_brand_value`;
CREATE TABLE `wl_brand_value` (
  `bvalueId` int(11) NOT NULL AUTO_INCREMENT,
  `itemid` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `value` varchar(50) DEFAULT NULL COMMENT '品牌',
  `did` int(11) NOT NULL DEFAULT '0',
  `catid` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
  PRIMARY KEY (`bvalueId`)
) ENGINE=MyISAM AUTO_INCREMENT=802380 DEFAULT CHARSET=utf8 COMMENT='品牌_商品关系表';

#
# Data for table "wl_brand_value"
#

/*!40000 ALTER TABLE `wl_brand_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_brand_value` ENABLE KEYS */;

#
# Structure for table "wl_category"
#

DROP TABLE IF EXISTS `wl_category`;
CREATE TABLE `wl_category` (
  `catid` int(10) NOT NULL AUTO_INCREMENT,
  `catname` varchar(50) NOT NULL DEFAULT '',
  `catdir` varchar(50) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `letter` varchar(1) NOT NULL DEFAULT '',
  `level` tinyint(1) NOT NULL DEFAULT '0',
  `item` bigint(20) NOT NULL DEFAULT '0',
  `parentid` smallint(6) NOT NULL DEFAULT '0',
  `arrparentid` varchar(255) NOT NULL DEFAULT '',
  `child` tinyint(1) NOT NULL DEFAULT '0',
  `arrchildid` text NOT NULL,
  `listorder` int(10) NOT NULL DEFAULT '0',
  `collect` smallint(6) NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`catid`),
  KEY `catname` (`catname`),
  KEY `item` (`parentid`,`item`),
  KEY `catid` (`catid`,`item`),
  KEY `parentid` (`parentid`),
  KEY `parentid_letter` (`parentid`,`letter`)
) ENGINE=MyISAM AUTO_INCREMENT=2296 DEFAULT CHARSET=utf8;

#
# Data for table "wl_category"
#

/*!40000 ALTER TABLE `wl_category` DISABLE KEYS */;
INSERT INTO `wl_category` VALUES (1,'化妆品','','','','',0,0,0,'0,1',0,'1,2',0,0,0),(2,'面部护肤','','','','',0,0,1,'0,1,2',0,',3',0,0,0),(3,'洁面','','','','',0,0,2,'0,1,2,3',0,',4',0,0,0),(4,'洁面乳','','','','',0,0,3,'0,1,2,3,4',0,'',0,0,0);
/*!40000 ALTER TABLE `wl_category` ENABLE KEYS */;

#
# Structure for table "wl_category_default_option"
#

DROP TABLE IF EXISTS `wl_category_default_option`;
CREATE TABLE `wl_category_default_option` (
  `id` bigint(20) NOT NULL DEFAULT '0' COMMENT '手动生成ID',
  `value` varchar(255) NOT NULL DEFAULT '' COMMENT '默认的属性值(categroy表默认属性值的分表)',
  `catid` int(10) NOT NULL DEFAULT '0' COMMENT '属性值对应的分类ID',
  `num` int(10) NOT NULL DEFAULT '0' COMMENT '分类下属性对应的产品个数',
  `oid` int(10) NOT NULL DEFAULT '0' COMMENT '属性值对应的oid',
  KEY `id` (`id`),
  KEY `value_2` (`value`,`catid`,`oid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "wl_category_default_option"
#

/*!40000 ALTER TABLE `wl_category_default_option` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_category_default_option` ENABLE KEYS */;

#
# Structure for table "wl_category_new"
#

DROP TABLE IF EXISTS `wl_category_new`;
CREATE TABLE `wl_category_new` (
  `catid` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) DEFAULT NULL COMMENT '父类id',
  `catname` varchar(55) DEFAULT NULL COMMENT '分类名称',
  `level` int(5) DEFAULT NULL COMMENT '级别',
  `listorder` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` int(1) DEFAULT '0' COMMENT '0:不显示 1：显示',
  `style` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`catid`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='新闻分类';

#
# Data for table "wl_category_new"
#

/*!40000 ALTER TABLE `wl_category_new` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_category_new` ENABLE KEYS */;

#
# Structure for table "wl_category_option"
#

DROP TABLE IF EXISTS `wl_category_option`;
CREATE TABLE `wl_category_option` (
  `oid` bigint(20) NOT NULL AUTO_INCREMENT,
  `catid` int(10) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `required` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否必填',
  `name` varchar(50) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  `listorder` int(10) NOT NULL DEFAULT '0',
  `item` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`oid`),
  KEY `catid` (`name`,`catid`),
  KEY `catid_2` (`catid`,`required`)
) ENGINE=MyISAM AUTO_INCREMENT=851477 DEFAULT CHARSET=utf8;

#
# Data for table "wl_category_option"
#

/*!40000 ALTER TABLE `wl_category_option` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_category_option` ENABLE KEYS */;

#
# Structure for table "wl_category_option_value"
#

DROP TABLE IF EXISTS `wl_category_option_value`;
CREATE TABLE `wl_category_option_value` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `oid` bigint(20) NOT NULL,
  `value` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `oid` (`oid`,`value`)
) ENGINE=MyISAM AUTO_INCREMENT=2847 DEFAULT CHARSET=utf8;

#
# Data for table "wl_category_option_value"
#

/*!40000 ALTER TABLE `wl_category_option_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_category_option_value` ENABLE KEYS */;

#
# Structure for table "wl_category_value"
#

DROP TABLE IF EXISTS `wl_category_value`;
CREATE TABLE `wl_category_value` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `oid` bigint(20) NOT NULL DEFAULT '0',
  `itemid` bigint(20) NOT NULL DEFAULT '0',
  `value` varchar(255) NOT NULL DEFAULT '',
  `did` bigint(20) NOT NULL DEFAULT '0' COMMENT '对应default_option表中的 id',
  `catid` int(10) NOT NULL DEFAULT '0' COMMENT 'category表的catid',
  PRIMARY KEY (`id`),
  KEY `oid` (`oid`,`itemid`),
  KEY `oid_2` (`itemid`,`oid`)
) ENGINE=MyISAM AUTO_INCREMENT=11931268 DEFAULT CHARSET=utf8;

#
# Data for table "wl_category_value"
#

/*!40000 ALTER TABLE `wl_category_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_category_value` ENABLE KEYS */;

#
# Structure for table "wl_check_news"
#

DROP TABLE IF EXISTS `wl_check_news`;
CREATE TABLE `wl_check_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cmd5` char(32) NOT NULL DEFAULT '',
  `nid` int(11) NOT NULL COMMENT 'news_id',
  PRIMARY KEY (`id`),
  KEY `cmd5` (`cmd5`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='检测news数据表';

#
# Data for table "wl_check_news"
#

/*!40000 ALTER TABLE `wl_check_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_check_news` ENABLE KEYS */;

#
# Structure for table "wl_check_sell"
#

DROP TABLE IF EXISTS `wl_check_sell`;
CREATE TABLE `wl_check_sell` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cmd5` char(32) NOT NULL DEFAULT '',
  `sid` int(11) NOT NULL COMMENT 'sell_id',
  PRIMARY KEY (`id`),
  KEY `cmd5` (`cmd5`)
) ENGINE=MyISAM AUTO_INCREMENT=837066 DEFAULT CHARSET=utf8 COMMENT='检测sell数据表';

#
# Data for table "wl_check_sell"
#

/*!40000 ALTER TABLE `wl_check_sell` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_check_sell` ENABLE KEYS */;

#
# Structure for table "wl_comment"
#

DROP TABLE IF EXISTS `wl_comment`;
CREATE TABLE `wl_comment` (
  `itemid` bigint(20) NOT NULL AUTO_INCREMENT,
  `itemid_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '暂时对应sell表的 ID',
  `itemid_title` varchar(255) NOT NULL DEFAULT '' COMMENT '暂时对应sell表的 title',
  `itemid_linkurl` varchar(255) NOT NULL DEFAULT '' COMMENT '暂时对应sell表的\r\nlinkurl ',
  `itemid_username` varchar(255) NOT NULL DEFAULT '' COMMENT '暂时对应sell表的\r\nusername',
  `star` tinyint(4) NOT NULL DEFAULT '0' COMMENT '评价',
  `content` text NOT NULL COMMENT '评论内容',
  `qid` bigint(20) NOT NULL DEFAULT '0' COMMENT '引用ID',
  `quotation` text NOT NULL COMMENT '引用内容',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `hidden` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否匿名评论',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '评论时间',
  `quote` int(11) NOT NULL DEFAULT '0' COMMENT '引用数量',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '评论状态 是否已经审核',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "wl_comment"
#

/*!40000 ALTER TABLE `wl_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_comment` ENABLE KEYS */;

#
# Structure for table "wl_comment_stat"
#

DROP TABLE IF EXISTS `wl_comment_stat`;
CREATE TABLE `wl_comment_stat` (
  `sid` bigint(20) NOT NULL AUTO_INCREMENT,
  `itemid` bigint(20) NOT NULL DEFAULT '0' COMMENT '暂时对应sell表中的itemid',
  `comment` int(11) NOT NULL DEFAULT '0' COMMENT '评论数',
  `star1` int(11) NOT NULL DEFAULT '0' COMMENT '评星等级 好评',
  `star2` int(11) NOT NULL DEFAULT '0' COMMENT '评星等级 中评',
  `star3` int(11) NOT NULL DEFAULT '0' COMMENT '评星等级 差评',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "wl_comment_stat"
#

/*!40000 ALTER TABLE `wl_comment_stat` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_comment_stat` ENABLE KEYS */;

#
# Structure for table "wl_company"
#

DROP TABLE IF EXISTS `wl_company`;
CREATE TABLE `wl_company` (
  `userid` bigint(20) NOT NULL COMMENT '用户ID',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '公司认证',
  `groupid` smallint(4) NOT NULL DEFAULT '0' COMMENT '用户组ID',
  `company` varchar(150) NOT NULL DEFAULT '' COMMENT '公司名称',
  `vip` smallint(2) NOT NULL DEFAULT '0' COMMENT 'Vip的指数',
  `vipt` smallint(2) NOT NULL DEFAULT '0' COMMENT 'VIP指数理论值',
  `vipr` smallint(2) NOT NULL DEFAULT '0' COMMENT 'VIP修正理论值',
  `ctype` varchar(100) NOT NULL DEFAULT '' COMMENT '公司类型 个人或者企业单位',
  `catid` int(11) NOT NULL DEFAULT '0' COMMENT '公司行业分类ID',
  `areaid` int(11) NOT NULL DEFAULT '0' COMMENT '地区ID',
  `mode` varchar(100) NOT NULL DEFAULT '' COMMENT '经营模式',
  `capital` float NOT NULL DEFAULT '0' COMMENT '注册资本',
  `regunit` varchar(15) NOT NULL DEFAULT '' COMMENT '注册资本货币单位',
  `size` varchar(100) NOT NULL DEFAULT '' COMMENT '公司规模 员工人数',
  `regyear` varchar(4) NOT NULL DEFAULT '' COMMENT '注册年份',
  `regcity` varchar(60) NOT NULL DEFAULT '' COMMENT '注册城市',
  `business` varchar(255) NOT NULL DEFAULT '' COMMENT '主要经营范围',
  `telephone` varchar(50) NOT NULL DEFAULT '' COMMENT '电话',
  `fax` varchar(50) NOT NULL DEFAULT '' COMMENT '传真',
  `mail` varchar(50) NOT NULL DEFAULT '' COMMENT '公司的mail 对外公开',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '公司地址',
  `zipcode` varchar(20) NOT NULL DEFAULT '' COMMENT '邮编',
  `homepage` varchar(255) NOT NULL DEFAULT '' COMMENT '公司主页',
  `fromtime` int(11) NOT NULL DEFAULT '0' COMMENT 'VIP开始时间',
  `totime` int(11) NOT NULL DEFAULT '0' COMMENT 'VIP过期时间',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '公司 Logo图或形象图',
  `introduce` varchar(255) NOT NULL DEFAULT '' COMMENT '公司简要介绍 ',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '公司访问次数',
  `linkurl` varchar(255) NOT NULL DEFAULT '' COMMENT '公司首页地址一般伪静态时使用',
  `markets` varchar(255) DEFAULT '' COMMENT '主要市场',
  `volume` varchar(100) DEFAULT '' COMMENT '年销售额',
  `export` varchar(100) DEFAULT '' COMMENT '出口百分比',
  `icp` varchar(100) DEFAULT '' COMMENT '管理体系认证',
  `regno` varchar(100) DEFAULT '' COMMENT '注册号',
  `authority` varchar(100) DEFAULT '' COMMENT '发证机关',
  PRIMARY KEY (`userid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "wl_company"
#

/*!40000 ALTER TABLE `wl_company` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_company` ENABLE KEYS */;

#
# Structure for table "wl_company_data"
#

DROP TABLE IF EXISTS `wl_company_data`;
CREATE TABLE `wl_company_data` (
  `userid` bigint(20) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "wl_company_data"
#

/*!40000 ALTER TABLE `wl_company_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_company_data` ENABLE KEYS */;

#
# Structure for table "wl_comurl"
#

DROP TABLE IF EXISTS `wl_comurl`;
CREATE TABLE `wl_comurl` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `company` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司url表';

#
# Data for table "wl_comurl"
#

/*!40000 ALTER TABLE `wl_comurl` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_comurl` ENABLE KEYS */;

#
# Structure for table "wl_friend"
#

DROP TABLE IF EXISTS `wl_friend`;
CREATE TABLE `wl_friend` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `truename` varchar(100) NOT NULL,
  `typeid` int(11) NOT NULL,
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "wl_friend"
#

/*!40000 ALTER TABLE `wl_friend` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_friend` ENABLE KEYS */;

#
# Structure for table "wl_friend_type"
#

DROP TABLE IF EXISTS `wl_friend_type`;
CREATE TABLE `wl_friend_type` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `tname` varchar(100) NOT NULL,
  `listorder` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "wl_friend_type"
#

/*!40000 ALTER TABLE `wl_friend_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_friend_type` ENABLE KEYS */;

#
# Structure for table "wl_info"
#

DROP TABLE IF EXISTS `wl_info`;
CREATE TABLE `wl_info` (
  `itemid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '商品名称',
  `explain` text COMMENT '使用说明',
  `option_value` varchar(255) DEFAULT NULL COMMENT '属性',
  `category_str` varchar(255) DEFAULT NULL COMMENT '分类',
  `content` text COMMENT '详情',
  `yuanurl` varchar(255) DEFAULT NULL COMMENT '原Url',
  `num1` varchar(100) DEFAULT NULL COMMENT '数量1',
  `num2` varchar(100) DEFAULT NULL COMMENT '数量2',
  `num3` varchar(100) DEFAULT NULL COMMENT '数量3',
  `price1` varchar(50) DEFAULT NULL COMMENT '价格1',
  `price2` varchar(50) DEFAULT NULL COMMENT '价格2',
  `price3` varchar(50) DEFAULT NULL COMMENT '价格3',
  `thumb` varchar(255) DEFAULT NULL COMMENT '图片',
  `option1` varchar(50) DEFAULT NULL COMMENT 'option1',
  `option2` varchar(50) DEFAULT NULL COMMENT 'option2',
  `option3` varchar(50) DEFAULT NULL COMMENT 'option3',
  `option4` varchar(50) DEFAULT NULL COMMENT 'option4',
  `option5` varchar(50) DEFAULT NULL COMMENT 'option5',
  `option6` varchar(50) DEFAULT NULL COMMENT 'option6',
  `option7` varchar(50) DEFAULT NULL COMMENT 'option7',
  `option8` varchar(50) DEFAULT NULL COMMENT 'option8',
  `option9` varchar(50) DEFAULT NULL COMMENT 'option9',
  `option10` varchar(50) DEFAULT NULL COMMENT 'option10',
  `option11` varchar(50) DEFAULT NULL COMMENT 'option11',
  `option12` varchar(50) DEFAULT NULL COMMENT 'option12',
  `value1` varchar(50) DEFAULT NULL COMMENT 'value1',
  `value2` varchar(50) DEFAULT NULL COMMENT 'value2',
  `value3` varchar(50) DEFAULT NULL COMMENT 'value3',
  `value4` varchar(50) DEFAULT NULL COMMENT 'value4',
  `value5` varchar(50) DEFAULT NULL COMMENT 'value5',
  `value6` varchar(50) DEFAULT NULL COMMENT 'value6',
  `value7` varchar(50) DEFAULT NULL COMMENT 'value7',
  `value8` varchar(50) DEFAULT NULL COMMENT 'value8',
  `value9` varchar(50) DEFAULT NULL COMMENT 'value9',
  `value10` varchar(50) DEFAULT NULL COMMENT 'value10',
  `value11` varchar(50) DEFAULT NULL COMMENT 'value11',
  `value12` varchar(50) DEFAULT NULL COMMENT 'value12',
  `business_model` varchar(255) DEFAULT NULL COMMENT '经营模式',
  `company_area` varchar(255) DEFAULT NULL COMMENT '公司地址',
  `telphone` varchar(50) DEFAULT NULL COMMENT '电话',
  `company_name` varchar(255) DEFAULT NULL COMMENT '公司名称',
  `company_username` varchar(255) DEFAULT NULL COMMENT '联系人名称',
  `company_name1` varchar(255) DEFAULT NULL,
  `company_username1` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='采集';

#
# Data for table "wl_info"
#

/*!40000 ALTER TABLE `wl_info` DISABLE KEYS */;
INSERT INTO `wl_info` VALUES (1,'Cetaphil丝塔芙洁面乳 237ml','适合所有肤质使用的温和产品，体验前所未有的温和享受！237ml的丝塔芙洁面乳，不含香料及酒精，是你值得拥有的洁面产品！敏感肌肤可以使用。','品牌:丝塔芙 (Cetaphil)&功效:清洁,保湿,补水,舒缓,温和&产品包装:全新正品，无外盒无塑封&适用人群:适用于所有肤质的人群&产品规格:237ml&保质期限:24个月（具体日期以收到实物为准）&原产国家:加拿大','化妆品,面部护肤,洁面,洁面乳','<a href=\"http://cetaphil.jumei.com/?site=bj\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164325337.jpg\" width=\"660\" height=\"401\" alt=\"\" /></a><br /><map name=\"Map\"><area shape=\"rect\" coords=\"10,53,617,260\" href=\"http://mall.jumei.com/cetaphil/\" target=\"_blank\" /></map><p>\r\n\t<br />\r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164330354.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164334373.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164335259.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164429818.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164429857.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164430990.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164434140.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164435645.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164445969.jpg\" alt=\"\" /> \r\n</p>','http://item.jumei.com/6936.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_2_2',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015164255449.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015164256529.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'Cetaphil丝塔芙洁面乳 118ml','反复洁面又担心伤肤？Cetaphil丝塔芙洁面乳118ml，通过所含的乳化络合物来实现对皮肤的深层净化，温和去除杂质。由于含有可减少刺激性的成分，可广泛适用于各种敏感性皮肤。在温和清洁同时，在肌肤表面敷上薄薄保湿修复膜，温和调理肌肤至水润无瑕健康状态！','品牌:丝塔芙 (Cetaphil)&功效:清洁,滋润,修护,温和&适用人群:适用任何肌肤的人群&产品规格:118ml&保质期限:24个月（具体日期以收到实物为准）&原产国家:加拿大&特别说明:全新正品，无外盒无塑封。两款包装随机发货，具体以收到实物为准。介意的人士慎购！','化妆品,面部护肤,洁面,洁面乳','<a href=\"http://cetaphil.jumei.com/?site=bj\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164526686.jpg\" width=\"660\" height=\"401\" alt=\"\" /></a><br /><map name=\"Map\"><area shape=\"rect\" coords=\"10,53,617,260\" href=\"http://mall.jumei.com/cetaphil/\" target=\"_blank\" /></map><p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164534890.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164535555.jpg\" alt=\"\" style=\"line-height:1.5;\" /> \r\n</p>\r\n<p>\r\n\t<br />\r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164536725.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164537223.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164539701.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164539861.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164543558.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164544559.jpg\" alt=\"\" />&nbsp;\r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164545927.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164550273.jpg\" alt=\"\" /> \r\n</p>','http://item.jumei.com/6935.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_2_7',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015164447871.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015164518864.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'丝塔芙洁面乳  473ml','温和不刺激，敏感肌适用的洁面！以温和的配方而受顾客的青睐，丝塔芙温和洗面奶473ml，用于脸部和颈部的清洁和卸妆，甚至适用于眼部等娇嫩肌肤。','品牌:丝塔芙 (Cetaphil)&功效:清洁,滋润,温和&产品规格:473ml&保质期限:24个月（具体日期以收到实物为准）&原产国家:加拿大&特别说明:全新正品，无外盒无塑封。新老包装随机发货，具体以收到实物为准。介意的人士慎购！','化妆品,面部护肤,洁面,洁面乳','<a href=\"http://cetaphil.jumei.com/?site=bj\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164555854.jpg\" width=\"660\" height=\"401\" alt=\"\" /></a><br /><map name=\"Map\"><area shape=\"rect\" coords=\"10,53,617,260\" href=\"http://mall.jumei.com/cetaphil/\" target=\"_blank\" /></map><p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164556192.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164557150.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164559164.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164600548.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164603342.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164607968.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov201516460844.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164609505.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164610894.jpg\" alt=\"\" /> \r\n</p>','http://item.jumei.com/8141.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_2_15',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015164552685.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015164553213.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'伊丽莎白雅顿 (Elizabeth Arden)双效洁肤露 150ml(绿色)','伊丽莎白雅顿 (Elizabeth Arden)双效洁肤露 150ml(绿色)，主要成分包括鼠尾草，迷迭香以及金缕梅，天然的搭配给你的肌肤带来最舒适的享受！','品牌:伊丽莎白雅顿 (Elizabeth Arden)&功效:清洁,收敛毛孔,舒缓&适用人群:混合性和偏油性皮肤，尤其是处在紧张忙碌生活与工作中的都市女性&产品规格:150ml&保质期限:3年（具体日期以收到实物为准）&原产国家:美国（具体产地以收到实物为准）&特别说明:本产品为全新正品，无外盒无塑封。','化妆品,面部护肤,洁面,洁面乳','<style>\r\n#flahship_header a.btn_authorize {\r\ndisplay: none;\r\n}\r\n</style><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164619365.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164623161.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164623887.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164626568.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164627859.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164628749.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164629975.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164629551.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164634750.jpg\" alt=\"\" />','http://item.jumei.com/374.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_2_20',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015164611398.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015164612406.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015164613713.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,'菲诗小铺(the face shop)米水润亮泽洁颜泡沫150ml','菲诗小铺(the face shop)米水润亮泽洁颜泡沫150ml，浓缩米水清洁成分，轻松卸妆的同时，深层洁净肌肤，泡沫丰富，清洁亮泽，温和，唤醒肌肤活力，令肌肤光亮。','品牌:菲诗小铺 (The Face Shop)&功效:清洁,保湿,修护肌肤,补水,滋润&产品规格:150ml&保质期限:3年（具体日期以收到实物为准）&原产国家:韩国&特别说明:正品，有盒无塑封。两款包装随机发货，具体以收到实物为准。介意的人士慎购！&适合肤质:敏感性、中干性肌肤','化妆品,面部护肤,洁面,洁面乳','','http://item.jumei.com/3500.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_2_21',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015164635826.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015164636726.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015164637696.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,'相宜本草金缕梅控油净白洗颜泥 100g','相宜本草金缕梅控油净白洗颜泥 100g，从金缕梅、茶树油中成功萃取出“智慧控油因子”有效渗透肌肤深层，智慧调节并平衡水油含量，一直肌肤分泌过多油脂，避免了过分剥夺表层油脂对皮脂膜造成的破坏。','品牌:相宜本草&功效:清洁,保湿,滋润,收敛毛孔,净肤&生产地区:上海&产品规格:100g&保质期限:三年（具体日期以收到产品为准）&特别说明:本产品为全新正品，无外盒无塑封，介意的MM慎购哦，两款包装随机发货！&适合肤质:适合易泛油光，毛孔粗大的油性，混合性肌肤。','化妆品,面部护肤,洁面,洁面乳','','http://item.jumei.com/1967.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_2_29',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015164638419.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015164645836.jpg&/img/teaseb/sell_img/2015-11-06/06Nov201516465061.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015164650813.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,'百雀羚草本水润保湿洁面乳95g','百雀羚草本水润保湿洁面乳95g，蕴含丰富的芦荟和海藻精华。水润细腻，深层去污，清爽不紧绷，还你水感透亮肌肤，整天清爽不紧绷！','品牌:百雀羚&功效:清洁,保湿,补水,滋润,缩小毛孔&产品包装:全新正品&生产地区:上海/江苏&适用人群:适用于所有肌肤，特别适合干燥，需要滋养的肌肤。&产品规格:95g&保质期限:3年半（具体日期以收到产品为准）','化妆品,面部护肤,洁面,洁面乳','<a href=\"http://baiqueling.jumei.com/\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164916131.jpg\" width=\"660\" height=\"130\" alt=\"\" /></a><br /><a href=\"http://item.jumei.com/1763848.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164917451.jpg\" width=\"331\" height=\"176\" alt=\"\" /></a><a href=\"http://item.jumei.com/1052093.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164918799.jpg\" width=\"329\" height=\"176\" alt=\"\" /></a><br /><a href=\"http://item.jumei.com/22545.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164919355.jpg\" width=\"221\" height=\"183\" alt=\"\" /></a><a href=\"http://item.jumei.com/1248824.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164920809.jpg\" width=\"220\" height=\"183\" alt=\"\" /></a><a href=\"http://item.jumei.com/1660.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164920819.jpg\" width=\"219\" height=\"183\" alt=\"\" /></a><br /><a href=\"http://item.jumei.com/22546.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164921950.jpg\" width=\"221\" height=\"211\" alt=\"\" /></a><a href=\"http://item.jumei.com/1693402.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164922752.jpg\" width=\"220\" height=\"211\" alt=\"\" /></a><a href=\"http://item.jumei.com/1263441.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164922236.jpg\" width=\"219\" height=\"211\" alt=\"\" /></a><p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164922192.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164923372.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164924385.jpg\" alt=\"\" /> \r\n</p>\r\n<p style=\"white-space:normal;\">\r\n\t<strong><span style=\"font-size:16px;color:#333333;font-family:SimSun;\">蕴含丰富的保湿精华</span></strong> \r\n</p>\r\n<p style=\"white-space:normal;\">\r\n\t<span style=\"font-size:small;color:#666666;\"><span style=\"font-size:12px;\">补充肌肤水份，同时形成锁水保护膜，令肌肤滋润不干燥。海藻可增加肌肤的保水性及紧缩性，可改善干性及油性肌肤的分泌状态，促使毛孔收缩细致。</span>&nbsp;</span>\r\n</p>','http://item.jumei.com/22532.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_2_30',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015164912725.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015164913454.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,'凡茜仙人掌无s洗面奶 126ml','S即为SLES/SLS，SLS/SLES会令表皮细胞发育不成熟，结构松散，令表皮层变薄，易受外界刺激，且角化异常，使皮肤粗糙暗淡，防御力下降，加速细胞老化。其清洁能力很强，但刺激性也高，长期使用有S洗面奶肌肤越洗越薄，越来越脆弱，毛孔越来越粗大，脸上出现红血丝，甚至于年龄不相符的肌肤老化！凡茜仙人掌无S洗面奶126ml，无S添加，肌肤不受S伤害，采用谷氨酸温和清洁因子同样达到深层清洁的效果！','品牌:凡茜&功效:清洁,修护肌肤,补水,净化&产品包装:全新正品，有盒无塑封。两款包装随机发货，具体以收到实物为准。介意的人士慎购！&生产地区:北京&适用人群:适合所有想要通过温和不刺激的方式清洁肌肤的人群，尤其是敏感肌肤&产品规格:126ml&保质期限:3年（具体日期以收到实物为准）','化妆品,面部护肤,洁面,洁面乳','<a href=\"http://fanxishop.jumei.com\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164932837.jpg\" width=\"223\" height=\"328\" alt=\"\" /></a><a href=\"http://xuanqi.jumei.com\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164933787.jpg\" width=\"219\" height=\"328\" alt=\"\" /></a><a href=\"http://zuji.jumei.com\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164933839.jpg\" width=\"218\" height=\"328\" alt=\"\" /></a><br /><p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164934364.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov201516493581.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164935548.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164936315.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164937952.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164938393.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov20151649390.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164939931.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164940757.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164940308.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164940419.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164941739.jpg\" alt=\"\" /> \r\n</p>','http://item.jumei.com/17454.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_2_31',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov201516492652.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015164929586.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015164930285.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015164931991.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,'伊丽莎白雅顿 (Elizabeth Arden)保湿微粒洁面乳 150ml','伊丽莎白雅顿(Elizabeth Arden)保湿微粒洁面乳150ml，补充肌肤的胶原蛋白含量，维持和增强肌肤的弹性，让肌肤长期保持柔滑紧致！丰富植物成分的无酒精配方，温和去除面部剩余杂质与化妆品残留的同时为肌肤锁住必要的水分，提升肌肤自身的保湿能力。即使是敏感性肌肤在用后也能感觉柔软、舒缓和清新！','品牌:伊丽莎白雅顿 (Elizabeth Arden)&功效:清洁,保湿,补水&适用人群:适用于任何肌肤，尤其是干燥缺水的肤质&产品规格:150ml&保质期限:3年（具体日期以收到实物为准）&原产国家:美国（具体产地以收到实物为准）&特别说明:本产品为全新正品，无外盒无塑封。','化妆品,面部护肤,洁面,洁面乳','<style>\r\n#flahship_header a.btn_authorize {\r\ndisplay: none;\r\n}\r\n</style><p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164944253.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164945630.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164945916.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164946174.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164947465.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164948660.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164948572.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164949729.jpg\" alt=\"\" /> \r\n</p>','http://item.jumei.com/2229.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_2_35',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015164941497.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015164942533.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015164943593.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(10,'Cetaphil丝塔芙洁面乳 591ml','Cetaphil丝塔芙洁面乳591ml，采用温和配方、不含任何香精，不含皂，无刺激性清洁成分，柔和清洁；弱酸配方，接近人体正常肌肤需求；不含香料、色素，不刺激，适用于敏感肌肤；清洗后留有薄薄一层保护膜，给肌肤即刻柔润保护；水洗、干洗皆宜。','品牌:丝塔芙 (Cetaphil)&功效:清洁,保湿,滋润,温和,改善肤质&适用人群:适用于所有人群，尤其是敏感性肌肤。&产品规格:591ml&保质期限:24个月（具体日期以收到实物为准）&原产国家:加拿大&特别说明:全新正品，无外盒。','化妆品,面部护肤,洁面,洁面乳','<a href=\"http://cetaphil.jumei.com/?site=bj\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164952606.jpg\" width=\"660\" height=\"401\" alt=\"\" /></a><br /><map name=\"Map\"><area shape=\"rect\" coords=\"10,53,617,260\" href=\"http://mall.jumei.com/cetaphil/\" target=\"_blank\" /></map><p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015164953297.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165002126.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165003257.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165004532.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165004638.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165005232.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov201516500694.jpg\" alt=\"\" style=\"white-space:normal;\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165007940.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165008528.jpg\" alt=\"\" /> \r\n</p>','http://item.jumei.com/14910.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_2_36',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015164950820.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015164951755.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,'美肤宝自然亮肤洗面奶75ml*2','配方温和，质地柔和舒适，可柔和的清洁肌肤，并在肌肤表皮形成保护膜。令皮肤光滑细腻，不紧绷，泡沫丰富细腻，营造丝滑柔润的洁肤感受。','品牌:美肤宝&功效:清洁,补水,控油,净化&产品包装:全新正品，有外盒&适用人群:任何肤质人群&产品规格:75ml*2&保质期限:3年（具体日期以收到实物为准）&特别说明:新老包装随机发货，具体以收到实物为准。介意的人士慎购！','化妆品,面部护肤,洁面,洁面乳','','http://item.jumei.com/24901.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_3_3',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015165010615.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165011610.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165011925.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(12,'凡茜仙人掌无s洗面奶 246ml','为了降低洁面产品对皮肤的伤害，凡茜不采用常用的高刺激性SLES/SLS，而是经过多次试验，发现一种温和清洁因子——谷氨酸清洁因子，它能清洁皮肤表面及毛孔内油脂污垢，又不刺激皮肤。因此而研制出仙人掌无s洗面奶！','品牌:凡茜&功效:清洁,保湿,补水,温和&产品包装:全新正品，有外盒无塑封&生产地区:北京&适用人群:适合所有想要通过温和不刺激的方式清洁肌肤的人群，尤其是敏感肌肤&产品规格:246ml&保质期限:3年（具体日期以收到实物为准）&特别说明:新老包装随机发货，具体以收到实物为准。介意的人士慎购！','化妆品,面部护肤,洁面,洁面乳','<a href=\"http://fanxishop.jumei.com\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165023797.jpg\" width=\"223\" height=\"328\" alt=\"\" /></a><a href=\"http://xuanqi.jumei.com\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165023924.jpg\" width=\"219\" height=\"328\" alt=\"\" /></a><a href=\"http://zuji.jumei.com\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov201516502482.jpg\" width=\"218\" height=\"328\" alt=\"\" /></a><br /><p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov201516502443.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165026207.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov201516502632.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165027746.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165028107.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165029793.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov201516502993.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165031624.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165031710.jpg\" alt=\"\" />\r\n</p>','http://item.jumei.com/14827.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_3_4',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015165014305.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165018915.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165020605.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165021883.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(13,'百雀羚水嫩净透精华洁面乳95g','百雀羚水嫩净透精华洁面乳95g，蕴含红景天、益母草、忍冬花等天然五行本草精华，注入鲜活的本草能量，维护肌肤的宝石屏障，绽放水嫩剔透的健康神采。精华膏体，泡沫丰富细腻，温和平衡油脂分泌，调节肌肤水循环，洗后清爽不紧绷。','品牌:百雀羚&功效:清洁,补水,净肤&生产地区:上海&适用人群:18岁以上所有人群&产品规格:95g&保质期限:3年半（具体时间以收到实物为准）&特别说明:全新正品，无外盒。两款包装随机发货，具体以收到实物为准。介意的人士慎购！','化妆品,面部护肤,洁面,洁面乳','<a href=\"http://baiqueling.jumei.com/\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165039143.jpg\" width=\"660\" height=\"130\" alt=\"\" /></a><br /><a href=\"http://item.jumei.com/1763848.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov201516504224.jpg\" width=\"331\" height=\"176\" alt=\"\" /></a><a href=\"http://item.jumei.com/1052093.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165043937.jpg\" width=\"329\" height=\"176\" alt=\"\" /></a><br /><a href=\"http://item.jumei.com/22545.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165044847.jpg\" width=\"221\" height=\"183\" alt=\"\" /></a><a href=\"http://item.jumei.com/1248824.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165044716.jpg\" width=\"220\" height=\"183\" alt=\"\" /></a><a href=\"http://item.jumei.com/1660.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165045172.jpg\" width=\"219\" height=\"183\" alt=\"\" /></a><br /><a href=\"http://item.jumei.com/22546.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165045529.jpg\" width=\"221\" height=\"211\" alt=\"\" /></a><a href=\"http://item.jumei.com/1693402.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov201516504632.jpg\" width=\"220\" height=\"211\" alt=\"\" /></a><a href=\"http://item.jumei.com/1263441.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov201516504656.jpg\" width=\"219\" height=\"211\" alt=\"\" /></a><p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165047114.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165048866.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165049379.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165051377.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165052745.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165054149.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165058144.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165059845.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165101271.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165110144.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<strong><span style=\"font-size:16px;\">蕴含红景天.益母草.忍冬花等天然五行本草精华</span></strong> \r\n</p>\r\n<span style=\"color:#666666;\">粗糙.黯沉.干纹等缺水问题,多源于肌肤能量不均衡。水嫩倍现能量精华面膜专为肌肤的平衡保水而制。</span><br />\r\n<p align=\"left\">\r\n\t<span style=\"color:#666666;\">[清透]</span><span style=\"color:#666666;\">洗净脸部污垢，残妆和杂质。吸附去除面部多余油脂和老化角质，保持肌肤洁净柔滑.</span> \r\n</p>\r\n<p align=\"left\">\r\n\t<span style=\"color:#666666;\">[平衡]</span><span style=\"color:#666666;\">精华膏体 泡沫丰富细腻，温和平衡油脂分泌，调节肌肤水循环，洗后清爽不紧绷.</span> \r\n</p>\r\n<p align=\"left\">\r\n\t<span style=\"color:#666666;\">[水嫩]</span><span style=\"color:#666666;\">蕴含红景天、益母草、忍冬花等天然五行本草精华，注入鲜活的本草能量，维护肌肤的宝石屏障，绽放水嫩剔透的健康神采.</span> \r\n</p>','http://item.jumei.com/22545.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_3_5',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015165034233.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(14,'韩束 (KanS)芦荟舒缓洁面乳','韩束芦荟舒缓洁面乳320ml，芦荟，天然，无添加，高浓度，韩束芦荟舒缓洁面乳，绵密低泡，温润洁面，改善粗糙肤质，提升肌肤透明度，恢复健康肌肤的清爽通透。','品牌:韩束 (KanS)&功效:清洁,补水,舒缓,净肤&产品包装:全新正品，无外盒&生产地区:苏州&产品规格:320ml&保质期限:5年（具体日期以收到实物为准）','化妆品,面部护肤,洁面,洁面乳','<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165216928.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165217273.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165218327.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165227417.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165251326.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165252751.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165253451.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165254633.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165254135.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165255291.jpg\" alt=\"\" />','http://item.jumei.com/446506.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_3_6',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015165149875.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165214438.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165215137.jpg&/img/teaseb/sell_img/2015-11-06/06Nov201516521690.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(15,'雅诗兰黛 (Estee Lauder)鲜亮焕采泡沫洁面乳 125ml','雅诗兰黛 (Estee Lauder)鲜亮焕采泡沫洁面乳 125ml，全新红石榴果莓复合精粹，及4大圣果红石榴、蓝莓、枸杞、蔓越莓，经雅诗兰黛独家冷压萃取，生物发酵，升级排浊力，环境损伤、累积浊质、疲惫黯沉，一一清空，肌肤回复最初的内在健康，焕活鲜亮光采。','品牌:雅诗兰黛 (Estee Lauder)&功效:清洁,保湿,滋润,控油&适用人群:想要肌肤焕发活力，得到深层清洁的人群&产品规格:125ml&保质期限:3年(具体日期以收到实物为准)&原产国家:美国(具体产地以收到实物为准)&特别说明:全新正品，有外盒包装','化妆品,面部护肤,洁面,洁面乳','<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165305244.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165309562.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165309334.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov20151653104.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov201516531133.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165346324.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165417355.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<strong style=\"color:#333333;font-size:16px;line-height:1.5;\"><strong style=\"font-size:16px;line-height:1.5;\">吸附功效</strong>与清洁面</strong><strong style=\"color:#333333;font-size:16px;line-height:1.5;\">膜的双重结合，体验磁铁般神奇</strong> \r\n</p>\r\n<p>\r\n\t<span style=\"color:#666666;font-size:12px;\">充满惊喜地明星配方，神奇的二合一功效，即是洁面乳，又是清洁面膜，将阻碍美丽的表面杂质统统清走。富含负电荷磁性土，早上是温和的泡沫洁面乳，晚上升格为深层清洁面膜，可帮肌肤抵御外界刺激和污染，让日积约累的杂质不再停留，找回洁净轻柔的鲜活肌肤。 &nbsp;</span> \r\n</p>','http://item.jumei.com/185540.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_3_7',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015165256920.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165257995.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165258619.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165302492.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,'花印(HANAJIRUSHI)水漾洁净洗面乳 120g','花印水漾洁净洗面乳120g，洁面同时会补充肌肤水分，使肌肤干净通透，不紧绷。享受清爽、莹透的洁面体验！温和清洁，肌肤干净通透！','品牌:花印（HANAJIRUSHI）&功效:清洁,保湿,补水,收敛毛孔&适用人群:一般肌肤&产品规格:120g&保质期限:5年，开盖后保质期为12个月（具体日期以收到的实物为准）&原产国家:日本&特别说明:新老包装随机发货，具体以收到实物为准，介意的人士慎购！','化妆品,面部护肤,洁面,洁面乳','','http://item.jumei.com/68578.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_3_8',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015165419343.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165420276.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165451690.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(17,'丝塔芙（Cetaphil）净颜控油泡沫洁面乳 236ml','丝塔芙新品泡沫洁面乳！丰富泡沫慕斯质地，深入肌肤底层彻底去除多余油脂和污垢，肌底调理控油+表面智慧吸油，调理肌肤重回水油平衡，无畏油光！','品牌:丝塔芙 (Cetaphil)&功效:清洁,保湿,滋润,控油,净肤,温和&产品包装:由于产品外包装可能更新，请以收到的实物为准&适用人群:适用于任何人群，尤其是油性肌肤人士&产品规格:236ml&保质期限:2年（具体日期以收到实物为准）&原产国家:加拿大','化妆品,面部护肤,洁面,洁面乳','<a href=\"http://cetaphil.jumei.com/?site=bj\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165623495.jpg\" width=\"660\" height=\"401\" alt=\"\" /></a><br /><map name=\"Map\"><area shape=\"rect\" coords=\"10,53,617,260\" href=\"http://mall.jumei.com/cetaphil/\" target=\"_blank\" /></map><p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165623536.jpg\" alt=\"\" style=\"line-height:1.5;\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165624311.jpg\" alt=\"\" style=\"line-height:1.5;\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165625636.jpg\" alt=\"\" style=\"line-height:1.5;\" />\r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165625173.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165626150.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165628580.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165650332.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov201516565084.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165653885.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<br />\r\n</p>\r\n<p>\r\n\t<br />\r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165702559.jpg\" alt=\"\" /> \r\n</p>\r\n<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov201516570375.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165703106.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165704202.jpg\" alt=\"\" /> \r\n</p>','http://item.jumei.com/774072.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_3_12',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015165455583.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165457414.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(18,'菲诗小铺（The Face Shop）每日草本芦荟泡沫洁面膏 170g','库拉索芦荟叶提取物：有效舒缓肌肤，持久保湿；对皮肤有缓解肌肤疲劳作用。','品牌:菲诗小铺 (The Face Shop)&功效:清洁,保湿,补水,滋润,温和&产品包装:全新正品，无盒有塑封&生产地区:浙江或上海（具体产地以收到实物为准）&适用人群:任何肤质的人士&产品规格:170g&保质期限:3年（具体日期以收到实物为准）&特别说明:此产品不同批次产地有浙江和上海两种批次，有疑虑的顾客谨慎购买。','化妆品,面部护肤,洁面,洁面膏/霜','','http://item.jumei.com/6046.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_3_13',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015165705237.jpg&/img/teaseb/sell_img/2015-11-06/06Nov201516570618.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165706553.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(19,'倩碧(Clinique)温和液体洁面皂 30ml','倩碧(Clinique)温和液体洁面皂 30ml，肌肤的自然更新周期为28天。其间，一部分死皮细胞会自动脱落，但剩余的就会依附在肌肤表层，阻碍健康细胞的营养吸收，加速肌肤老化，安全有效的洁面皂，是倩碧护肤三步骤的第一步，不仅有效清洁肌肤，更能适度软化角质，为下一步皮层清理作准备。','品牌:倩碧 (Clinique)&功效:清洁,保湿,温和&生产地区:美国（具体产地以收到实物为准）&适用人群:适合任何肌肤，特别是想要拥有无暇肤质的人群&产品规格:30ml&保质期限:3年（具体日期以收到的实物为准）&温馨提示:具体产品请以收到实物为准。&特别说明:全新正品，无盒无塑封，产品为全新中样，有不单独出售字样，介意的mm慎选，多款包装随机发货哦！','化妆品,面部护肤,洁面,洁面乳','<h4>\r\n</h4>\r\n<h4>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165709795.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165710460.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165710916.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165711657.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165712217.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165715349.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165716530.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165717707.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165718156.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165833966.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165834289.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165835881.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165835461.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov201516583647.jpg\" alt=\"\" /><br />\r\n</h4>\r\n<p>\r\n\t<span style=\"font-size:16px;color:#333333;\"><strong>不含化学清洁剂，不伤害肌肤</strong></span><br />\r\n<span style=\"color:#666666;\">不让肌肤干燥，含丰富植物橄榄油，清洁的同时适度滋润；低泡配方，不含蜡质，容易清洗，更不会在皮肤表面留下让肌肤干燥的残留物，真空高压制成，不含空气，经久耐用亦不会变质。</span> \r\n</p>','http://item.jumei.com/71.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_3_14',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015165707627.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165708524.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165709941.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(20,'相宜本草百合高保湿洁面乳130g','温和洁净，柔润保湿！相宜本草百合高保湿洁面乳，内含丰富的百合多糖和粘液质，舒缓肌肤，还你洁净清透好肤质。蕴含百合、玉竹等本草成分。天然本色，美在相宜本草！','品牌:相宜本草&功效:清洁,保湿,补水,控油&产品容量:130g&产品包装:全新正品，无外盒，由于产品外包装可能更新，请以收到实物为准！&生产地区:上海&保质期限:3年（具体时间以收到实物为准）','化妆品,面部护肤,洁面,洁面乳','','http://item.jumei.com/16429.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_3_15',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015165902453.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165906100.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165910824.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165911927.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(21,'OLAY玉兰油多效修护洁面乳 100g','OLAY玉兰油多效修护洁面乳100g，深入清洁，促进肌肤更新。减淡细纹，淡化毛孔，水润平衡，保持肌肤柔软，焕发健康光泽。','品牌:玉兰油 (OLAY)&功效:清洁,滋润,修护&产品包装:全新正品，无外盒无塑封&适用人群:适用于想要对抗皱纹、细嫩肌肤、长效水润肌肤的MM&产品规格:100g&保质期限:3年（具体日期以收到实物为准）&特别说明:新老包装随机发货，具体以收到实物为准。介意的人士慎购！','化妆品,面部护肤,洁面,洁面乳','<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165923890.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165927503.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165927658.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165928250.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165929678.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165930148.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165931883.jpg\" alt=\"\" />\r\n</p>','http://item.jumei.com/11164.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_3_18',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015165918703.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165919525.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(22,'相宜本草控油净化洗颜泥100g（新老包装随机发货）','相宜本草控油净化洗颜泥，深层清洁肌肤，深层溶解积累在毛孔内的污垢，净化毛孔，预防黑头，粉刺、暗疮滋生，更新肌肤。','品牌:相宜本草&功效:清洁,去角质&生产地区:上海&产品规格:60g或100g，随机发货&保质期限:3年（具体日期以收到的实物为准）&特别说明:全新正品，无外盒，新老包装随机发货(老包装规格为：60g，新包装规格为：100g)，具体以收到实物为准，介意的人士慎购！','化妆品,面部护肤,洁面,洁面乳','','http://item.jumei.com/1396.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_3_19',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015165932520.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165937738.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165940240.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165941134.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(23,'韩后（Hanhoo）乳清蛋白洁颜乳 120g','韩后(Hanhoo)乳清蛋白洁颜乳120g，幼滑质地，加水乳化揉搓后形成细腻泡沫，可轻柔洗净面部残妆、污垢、多余油脂和老化角质。添加黄瓜、芦荟等提取成分，洁面同时赋予肌肤充足水分，令洁后肌肤无干涩紧绷的感觉，肌肤柔滑细腻，倍感舒适。','品牌:韩后（Hanhoo）&功效:清洁,保湿,补水&生产地区:广东&适用人群:所有肤质适用&产品规格:120g&保质期限:3年（具体日期以收到产品为准）&温馨提示:新老包装随机发，介意的人士慎买。新包装规格为120g，旧包装为120ml，不影响产品品质，可放心购买！','化妆品,面部护肤,洁面,洁面乳','<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"660\"><tbody><tr>    <td colspan=\"4\"><a href=\"http://hanhoo.jumei.com/\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165949910.jpg\" alt=\"\" /></a></td>    </tr><tr>    <td colspan=\"4\"><a href=\"http://mall.jumei.com/hanhoo/product_1429314.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165950747.jpg\" alt=\"\" /></a></td>  </tr><tr>    <td colspan=\"2\" width=\"330\"><a href=\"http://mall.jumei.com/hanhoo/product_1429309.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015165950710.jpg\" alt=\"\" /></a></td>    <td colspan=\"2\" width=\"330\"><a href=\"http://mall.jumei.com/hanhoo/product_1003384.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170000656.jpg\" alt=\"\" /></a></td>  </tr><tr>    <td width=\"219\"><a href=\"http://mall.jumei.com/hanhoo/product_484193.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov201517000432.jpg\" alt=\"\" /></a></td>        <td colspan=\"2\" width=\"218\"><a href=\"http://mall.jumei.com/hanhoo/product_484192.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170004596.jpg\" alt=\"\" /></a></td>        <td width=\"223\"><a href=\"http://mall.jumei.com/hanhoo/product_484208.html\" target=\"_blank\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170008323.jpg\" alt=\"\" /></a></td>  </tr></tbody></table><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170009890.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170010442.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov201517001139.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170012950.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170012227.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170013512.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170017380.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170017900.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170018579.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170022493.jpg\" alt=\"\" />','http://item.jumei.com/484193.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_3_20',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015165946791.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165947890.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165948761.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015165948529.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(24,'珀莱雅(PROYA)靓白肌密泡沫洁面乳120ml','珀莱雅(PROYA)靓白肌密泡沫洁面乳120ml，质地幼滑，泡沫细腻。蕴含大西洋红藻美白精萃、海洋深层水等珍贵海洋护肤成分，温和洁净肌肤，洗后柔滑不紧绷。','品牌:珀莱雅(PROYA)&功效:清洁,保湿,滋润&生产地区:浙江&适用人群:任何肤质适用，特别是想美白补水，温和清洁，扫除肌肤暗沉的人群&产品规格:120ml&保质期限:3年 (具体日期以收到实物为准)&特别说明:全新正品，有外盒。新老包装随机发货，具体以收到实物为准。介意的人士慎购！','化妆品,面部护肤,洁面,洁面乳','<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170028145.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170032586.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170032914.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170036314.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170040445.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170043112.jpg\" alt=\"\" /><br />','http://item.jumei.com/230830.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_3_23',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015170023397.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015170023754.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(25,'雅漾 (Avene)活泉修护/修护洁面乳 200ml','肌肤总难免会出现各种各样的问题，但是肌肤敏感一直令好多MM头疼不已，敏感的肌肤连每天的基础护理都会受阻，更何况是相对刺激较大的彩妆类产品。雅漾一直是业内抗敏感的典范，这次聚美为您带来的是雅漾(Avene)活泉修护/修护洁面乳200ml，免洗设计，洁净的同时降低肌肤敏感度，形成保护皮肤的屏障。','品牌:雅漾 (Avene)&功效:清洁,保湿,滋润&产品容量:200ml&适用人群:需要呵护肌肤的人士&保质期限:3年（具体日期以收到实物为准）&原产国家:法国（具体产地以收到实物为准）&特别说明:本产品为全新正品，有外盒包装。产品名称更新中，具体以收到实物为准，请介意的人士慎重购买。','化妆品,面部护肤,洁面,洁面乳','<p>\r\n\t<strong> <img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170053848.jpg\" alt=\"雅漾(Avene)修护洁面乳200ml，温和养肤。\" height=\"428\" width=\"660\" /></strong> \r\n</p>\r\n<p>\r\n\t<span style=\"color:#666666;font-size:small;font-family:宋体;\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170053358.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170057483.jpg\" alt=\"雅漾(Avene)修护洁面乳200ml，聚美实验室。\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170058840.jpg\" alt=\"\" /> </span> \r\n</p>\r\n<p>\r\n\t<span style=\"color:#666666;font-size:small;font-family:宋体;\"> </span> \r\n</p>\r\n<p style=\"white-space:normal;\">\r\n\t<span style=\"font-family:\'sans serif\', tahoma, verdana, helvetica;font-size:16px;line-height:1.5;color:#333333;\"><strong>极度敏感、受损肌肤卸妆乳</strong></span> \r\n</p>\r\n<p style=\"white-space:normal;\">\r\n\t<span style=\"color:#666666;font-size:12px;\">适用于先天和后天敏感皮肤，受损和耐受性差的肌肤，后天侵害（污染、气候、刺激、压力）导致的敏感皮肤表现为刺痒、有紧绷感。</span> \r\n</p>','http://item.jumei.com/876.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_3_24',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015170048801.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(26,'欧莱雅 (L\'Oreal)复颜洁面乳125ml','欧莱雅复颜洁面乳，富含LHA温和辛酰水杨酸，快速卸除彩妆，深层清洁，呈现洁净清爽肌肤。GLYCERIN保湿成分，温和带走粗糙，令肌肤更加光滑细腻。柔软丰盈乳液质地，加水轻柔即可产生丰富泡沫，温和柔软感觉，易于冲洗，肌肤舒适清洗体验。','品牌:欧莱雅 (L\'Oreal)&功效:清洁,保湿,抗皱&产品容量:125ml&产品包装:全新正品，无外盒无塑封&生产地区:江苏&适用人群:适合任何肌肤，尤其是想要保湿的人群&保质期限:3年（具体日期以收到实物为准）&特别说明:由于产品外包装可能更新，请以收到实物为准。','化妆品,面部护肤,洁面,洁面乳','<p>&nbsp;<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170105198.jpg\" width=\"658\" height=\"415\" alt=\"\" /></p><p>\r\n\t<strong><span style=\"font-size:medium;color:#333333;\"><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170106801.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170106519.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170116615.jpg\" alt=\"\" /><br />\r\n</span> </strong> \r\n</p>\r\n<p>\r\n\t<br />\r\n</p>','http://item.jumei.com/21836.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_3_25',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015170100159.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015170100482.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015170101444.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(27,'雅诗兰黛 (Estee Lauder) 鲜亮焕采泡沫洁面乳30ml','一支双用。雅诗兰黛 (Estee Lauder) 鲜亮焕采泡沫洁面乳30ml，蕴含强吸附力\"磁性粘土\"，深入清洁肌肤，肌肤自内透现鲜亮光采。红石榴果莓复合精粹，轻敷数分钟，令肌肤倍感清新舒适，效果显著。没有油腻的关爱，只需要清新的保护！','品牌:雅诗兰黛 (Estee Lauder)&功效:清洁,保湿,控油&适用人群:想要肌肤焕发活力，得到深层清洁的人群&产品规格:30ml&保质期限:3年（具体日期以收到产品为准）&原产国家:美国（具体产地以收到实物为准）&特别说明:产品为全新正品，无外盒包装','化妆品,面部护肤,洁面,洁面乳','<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170144365.jpg\" alt=\"\" /><img src=\"\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170334489.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170334287.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170344243.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170407111.jpg\" alt=\"\" /><br />\r\n<p style=\"white-space:normal;\">\r\n\t<strong style=\"color:#333333;font-size:16px;line-height:1.5;\">与清洁面膜的双重结合，体验磁铁般神奇吸附功效&nbsp;</strong> \r\n</p>\r\n<p style=\"white-space:normal;\">\r\n\t<span style=\"color:#666666;\">充满惊喜地明星配方，神奇的二合一功效，即是洁面乳，又是清洁面膜，将阻碍美丽的表面杂质统统清走。早上是温和的泡沫洁面乳，晚上升格为清洁面膜，轻敷5分钟，即可帮肌肤抵御外界刺激和污染，让日积约累的杂质不再停留，找回洁净轻柔的鲜活肌肤。</span><span style=\"color:#666666;\">&nbsp;</span><span style=\"color:#666666;\">&nbsp;</span> \r\n</p>','http://item.jumei.com/1331555.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_3_26',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015170117582.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015170121402.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015170122828.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(28,'相宜本草红石榴鲜活亮白洁颜乳 100g','去黄排毒，保湿美白。相宜本草红石榴鲜活亮白洁颜乳让你一步到位！相宜本草红石榴鲜活亮白洁颜乳，绵密柔澈的泡沫，能够温和溶解毛孔深处的污垢和老废角质，清除暗黄的自由基，均匀提亮你的肤色，让你的肌肤漾现通透。','品牌:相宜本草&功效:均匀肤色,保湿,滋润&产品容量:100g&生产地区:上海&适用人群:肌肤黯沉、晦黄的MM&保质期限:3年（具体日期以收到实物为准）&特别说明:新老包装随机发货，具体以收到实物为准。介意的人士慎购！','化妆品,面部护肤,洁面,洁面乳','','http://item.jumei.com/8857.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_3_27',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015170409570.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015170419183.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015170429774.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015170432487.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(29,'倩碧(Clinique)清爽液体洁面皂（混合偏油至油性肌肤）/清爽液体洁面皂(３号) 200ml','令肌肤洗后倍感水嫩，柔滑！倩碧(Clinique)清爽液体洁面皂（混合偏油至油性肌肤）/清爽液体洁面皂(３号) 200ml，清新自然，温和洁净肌肤，不会夺去肌肤水分，清理尘垢、杂质和多余油脂，能够清洁表皮老化角质，令肌肤倍感洁净清爽。给你能洗“净”的温和！真正的温和清洁！','品牌:倩碧 (Clinique)&功效:紧致,清洁,保湿,净肤&适用人群:混合偏油至油性肌肤的MM&产品规格:200ml&保质期限:3年（具体日期以收到实物为准）&原产国家:英国（具体产地以收到实物为准）&特别说明:全新正品，无盒无塑封。产品名称更新中，具体以收到实物为准。介意的人士慎购！','化妆品,面部护肤,洁面,洁面乳','<p>\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170649606.jpg\" alt=\"\" /><img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170717445.jpg\" alt=\" 倩碧 (Clinique)液体洁面皂（清爽型） 200ml\" height=\"394\" width=\"660\" /> \r\n</p>\r\n<p>\r\n\t<strong><span style=\"color:#333333;\"><span style=\"font-size:medium;\">深层洁净，软化角质</span></span></strong> \r\n</p>\r\n<p class=\"cjk\" align=\"JUSTIFY\">\r\n\t<span style=\"color:#666666;\"><span>洁面是倩碧完美肌肤的第一步，倩碧的皮肤医学专家特别配置了安全有效的洁面皂，它是三步骤的第一步，不仅深层清洁肌肤，更能适度软化角质，为下一步皮层清理作准备。</span></span> \r\n</p>\r\n<p class=\"cjk\" align=\"JUSTIFY\">\r\n\t<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170757168.jpg\" alt=\" 倩碧 (Clinique)液体洁面皂（清爽型） 200ml\" height=\"466\" width=\"660\" /> <img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170831371.jpg\" alt=\"\" /> \r\n</p>\r\n<p class=\"cjk\" align=\"JUSTIFY\">\r\n\t<strong> <span style=\"color:#333333;\"> <span style=\"font-size:medium;\">泡沫细致，温和无刺激</span> </span> </strong> \r\n</p>\r\n<p class=\"cjk\" align=\"JUSTIFY\">\r\n\t<span style=\"color:#666666;\"><span>含丰富植物橄榄油，清洁的同时适度滋润；低泡配方，不含蜡质，容易清洗，更不会在皮肤表面留下让肌肤干燥的残留物。</span></span> \r\n</p>\r\n<p class=\"cjk\" align=\"JUSTIFY\">\r\n\t<br />\r\n</p>\r\n<img src=\"/img/teaseb/sell_img/2015-11-06/06Nov2015170832857.jpg\" alt=\" 倩碧 (Clinique)液体洁面皂（清爽型） 200ml\" height=\"530\" width=\"660\" />','http://item.jumei.com/3044.html?from=sr_%E6%B4%97%E9%9D%A2%E5%A5%B6_3_28',NULL,NULL,NULL,NULL,NULL,NULL,'/img/teaseb/sell_img/2015-11-06/06Nov2015170437154.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015170447998.jpg&/img/teaseb/sell_img/2015-11-06/06Nov2015170448894.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `wl_info` ENABLE KEYS */;

#
# Structure for table "wl_inquiry"
#

DROP TABLE IF EXISTS `wl_inquiry`;
CREATE TABLE `wl_inquiry` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `touser` varchar(30) NOT NULL,
  `fromuser` varchar(30) DEFAULT '',
  `company` varchar(100) NOT NULL,
  `country` varchar(50) DEFAULT '',
  `truename` varchar(30) NOT NULL,
  `telephone` varchar(20) DEFAULT '',
  `mobile` varchar(20) DEFAULT '0',
  `email` varchar(50) DEFAULT '',
  `sid` bigint(20) unsigned NOT NULL,
  `ip` varchar(15) NOT NULL,
  `postdate` int(11) NOT NULL,
  `status` smallint(1) NOT NULL DEFAULT '0',
  `pid` bigint(20) NOT NULL DEFAULT '0' COMMENT '询盘父ID',
  PRIMARY KEY (`id`),
  KEY `usrename` (`touser`),
  KEY `sid` (`sid`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM AUTO_INCREMENT=282 DEFAULT CHARSET=utf8;

#
# Data for table "wl_inquiry"
#

/*!40000 ALTER TABLE `wl_inquiry` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_inquiry` ENABLE KEYS */;

#
# Structure for table "wl_inquiry_data"
#

DROP TABLE IF EXISTS `wl_inquiry_data`;
CREATE TABLE `wl_inquiry_data` (
  `id` int(11) unsigned NOT NULL,
  `message` text NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "wl_inquiry_data"
#

/*!40000 ALTER TABLE `wl_inquiry_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_inquiry_data` ENABLE KEYS */;

#
# Structure for table "wl_inquiry_notice"
#

DROP TABLE IF EXISTS `wl_inquiry_notice`;
CREATE TABLE `wl_inquiry_notice` (
  `id` int(11) unsigned NOT NULL COMMENT '对应询单id',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '会员名',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '操作时间',
  `note` text NOT NULL COMMENT '备注',
  `status` smallint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='询单通知';

#
# Data for table "wl_inquiry_notice"
#

/*!40000 ALTER TABLE `wl_inquiry_notice` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_inquiry_notice` ENABLE KEYS */;

#
# Structure for table "wl_ip"
#

DROP TABLE IF EXISTS `wl_ip`;
CREATE TABLE `wl_ip` (
  `StartIP` varchar(20) DEFAULT '',
  `EndIP` varchar(20) DEFAULT NULL,
  `Country` varchar(30) DEFAULT NULL,
  `Local` varchar(50) DEFAULT NULL,
  UNIQUE KEY `StartIP` (`StartIP`),
  KEY `IP` (`StartIP`,`EndIP`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "wl_ip"
#

/*!40000 ALTER TABLE `wl_ip` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_ip` ENABLE KEYS */;

#
# Structure for table "wl_member"
#

DROP TABLE IF EXISTS `wl_member`;
CREATE TABLE `wl_member` (
  `userid` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `company` varchar(150) NOT NULL DEFAULT '' COMMENT '公司名称',
  `passport` varchar(30) NOT NULL DEFAULT '' COMMENT '通行证',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '用户密码',
  `payword` varchar(32) NOT NULL DEFAULT '' COMMENT '支付密码',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '用户email 不公开的，用于邮件验证和接收系统邮件',
  `message` smallint(6) NOT NULL DEFAULT '0' COMMENT '用户站内（新）短信数',
  `online` tinyint(4) NOT NULL DEFAULT '0' COMMENT '用户是否在线 1为在线 0为离线或隐身',
  `gender` tinyint(4) NOT NULL DEFAULT '0' COMMENT '性别',
  `truename` varchar(50) NOT NULL DEFAULT '' COMMENT '姓名',
  `mobile` varchar(30) NOT NULL DEFAULT '' COMMENT '移动电话',
  `qq` varchar(50) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '' COMMENT '阿里旺旺',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `department` varchar(30) NOT NULL DEFAULT '' COMMENT '部门',
  `career` varchar(30) NOT NULL DEFAULT '' COMMENT '职位',
  `admin` tinyint(4) NOT NULL DEFAULT '0' COMMENT '否为管理员',
  `groupid` smallint(4) DEFAULT '6' COMMENT '当前用户组ID',
  `regid` smallint(4) DEFAULT '6' COMMENT '注册用户组ID',
  `areaid` int(11) NOT NULL DEFAULT '0' COMMENT '区域ID',
  `credit` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `edittime` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `regip` varchar(50) NOT NULL DEFAULT '' COMMENT '注册IP',
  `regtime` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `loginip` varchar(50) NOT NULL DEFAULT '' COMMENT '登入IP',
  `logintime` int(11) NOT NULL DEFAULT '0' COMMENT '登入时间',
  `logintimes` int(11) NOT NULL DEFAULT '0' COMMENT '登入次数',
  `black` varchar(255) NOT NULL DEFAULT '' COMMENT '站内信息黑名单',
  `send` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否允许站内信转发到认证的邮箱 ',
  `auth` varchar(32) NOT NULL DEFAULT '' COMMENT '验证码',
  `authvalue` varchar(100) NOT NULL DEFAULT '' COMMENT '验证内容说明',
  `authtime` int(11) NOT NULL DEFAULT '0' COMMENT '验证时间',
  `vmail` tinyint(4) NOT NULL DEFAULT '0' COMMENT '邮件认证',
  `vtruename` tinyint(4) NOT NULL DEFAULT '0' COMMENT '实名认证',
  `vcompany` tinyint(4) NOT NULL DEFAULT '0' COMMENT '公司认证',
  `inviter` varchar(30) NOT NULL DEFAULT '' COMMENT '推荐人',
  `lastip` varchar(50) NOT NULL DEFAULT '' COMMENT '上一次登入IP',
  `lasttime` int(11) NOT NULL DEFAULT '0' COMMENT '上一次登入时间',
  `status` int(1) DEFAULT '3' COMMENT '0：删除，1：待审，2：拒绝，3：通过，4：过期',
  PRIMARY KEY (`userid`),
  KEY `regtime` (`regtime`),
  KEY `username` (`username`),
  KEY `vmail_company_regtime` (`vmail`,`company`,`regtime`),
  KEY `company` (`company`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=15492 DEFAULT CHARSET=utf8;

#
# Data for table "wl_member"
#

/*!40000 ALTER TABLE `wl_member` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_member` ENABLE KEYS */;

#
# Structure for table "wl_member_group"
#

DROP TABLE IF EXISTS `wl_member_group`;
CREATE TABLE `wl_member_group` (
  `groupid` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` varchar(50) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL,
  PRIMARY KEY (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='会员组';

#
# Data for table "wl_member_group"
#

/*!40000 ALTER TABLE `wl_member_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_member_group` ENABLE KEYS */;

#
# Structure for table "wl_message"
#

DROP TABLE IF EXISTS `wl_message`;
CREATE TABLE `wl_message` (
  `mid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `typeid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `fromuser` varchar(30) NOT NULL DEFAULT '',
  `touser` varchar(160) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `isread` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `issend` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `feedback` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `auth` varchar(32) NOT NULL DEFAULT '' COMMENT '验证信息',
  `iid` bigint(20) NOT NULL DEFAULT '0' COMMENT '对应询盘表的ID',
  `isdel_r` smallint(1) unsigned NOT NULL DEFAULT '0' COMMENT '收件人是否删除 0为未\r\n删除,1为已删除',
  `isdel_s` smallint(1) unsigned NOT NULL DEFAULT '0' COMMENT '发件人是否删除 0为未\r\n删除,1为已删除',
  PRIMARY KEY (`mid`),
  KEY `touser` (`touser`),
  KEY `typeid` (`typeid`,`fromuser`,`touser`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='站内信件';

#
# Data for table "wl_message"
#

/*!40000 ALTER TABLE `wl_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_message` ENABLE KEYS */;

#
# Structure for table "wl_news"
#

DROP TABLE IF EXISTS `wl_news`;
CREATE TABLE `wl_news` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `subtitle` text NOT NULL,
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` text NOT NULL COMMENT '产品属性',
  `author` varchar(50) NOT NULL DEFAULT '',
  `source` varchar(30) NOT NULL DEFAULT '',
  `fromurl` varchar(255) NOT NULL DEFAULT '',
  `voteid` varchar(100) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间',
  `ip` varchar(50) NOT NULL,
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL DEFAULT '',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '作者ID',
  `copyfrom` varchar(100) DEFAULT NULL COMMENT '咨询来源',
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`),
  KEY `username` (`username`),
  KEY `status` (`status`),
  KEY `hits` (`hits`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='资讯';

#
# Data for table "wl_news"
#

/*!40000 ALTER TABLE `wl_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_news` ENABLE KEYS */;

#
# Structure for table "wl_news_data"
#

DROP TABLE IF EXISTS `wl_news_data`;
CREATE TABLE `wl_news_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='资讯内容';

#
# Data for table "wl_news_data"
#

/*!40000 ALTER TABLE `wl_news_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_news_data` ENABLE KEYS */;

#
# Structure for table "wl_news_review"
#

DROP TABLE IF EXISTS `wl_news_review`;
CREATE TABLE `wl_news_review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemid` int(11) NOT NULL DEFAULT '0' COMMENT '新闻id',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '评论者id',
  `content` text COMMENT '评论内容',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1：显示，2：屏蔽',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '评论时间',
  `level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '级别',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='新闻评论';

#
# Data for table "wl_news_review"
#

/*!40000 ALTER TABLE `wl_news_review` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_news_review` ENABLE KEYS */;

#
# Structure for table "wl_page_set"
#

DROP TABLE IF EXISTS `wl_page_set`;
CREATE TABLE `wl_page_set` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `mode` varchar(50) NOT NULL DEFAULT '' COMMENT '模块',
  `in_page` varchar(50) NOT NULL DEFAULT '' COMMENT '所在页面',
  `num` varchar(10) NOT NULL DEFAULT '' COMMENT '显示数目',
  `conditions` varchar(100) NOT NULL DEFAULT '' COMMENT '查询条件',
  `sort` varchar(100) NOT NULL DEFAULT '' COMMENT '排序',
  `fields` varchar(255) NOT NULL DEFAULT '' COMMENT '显示字段',
  `mlength` tinyint(1) DEFAULT '0' COMMENT 'sphinx匹配度',
  `edittime` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `editip` varchar(20) NOT NULL DEFAULT '' COMMENT '修改IP',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '修改者',
  PRIMARY KEY (`id`),
  KEY `mode` (`mode`),
  KEY `in_page` (`in_page`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

#
# Data for table "wl_page_set"
#

/*!40000 ALTER TABLE `wl_page_set` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_page_set` ENABLE KEYS */;

#
# Structure for table "wl_password_find"
#

DROP TABLE IF EXISTS `wl_password_find`;
CREATE TABLE `wl_password_find` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '会员邮箱',
  `auth` varchar(32) NOT NULL DEFAULT '' COMMENT '随机md5值',
  `totime` int(11) NOT NULL DEFAULT '0' COMMENT '过期时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "wl_password_find"
#

/*!40000 ALTER TABLE `wl_password_find` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_password_find` ENABLE KEYS */;

#
# Structure for table "wl_sell"
#

DROP TABLE IF EXISTS `wl_sell`;
CREATE TABLE `wl_sell` (
  `itemid` bigint(20) NOT NULL AUTO_INCREMENT,
  `subtitle` varchar(255) DEFAULT NULL,
  `catid` int(11) NOT NULL DEFAULT '0' COMMENT '所属分类ID',
  `mycatid` bigint(20) NOT NULL DEFAULT '0' COMMENT '自定义分类ID',
  `typeid` smallint(2) DEFAULT '0' COMMENT '供应类型',
  `areaid` smallint(6) NOT NULL DEFAULT '0' COMMENT '地区ID',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '推荐等级 1 表示推荐',
  `elite` tinyint(4) NOT NULL DEFAULT '0' COMMENT '公司首页推荐',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `style` varchar(50) NOT NULL DEFAULT '' COMMENT '标题颜色',
  `fee` float NOT NULL DEFAULT '0' COMMENT '收费积分',
  `introduce` varchar(255) NOT NULL DEFAULT '' COMMENT '内容简介',
  `model` varchar(100) NOT NULL DEFAULT '' COMMENT '产品型号',
  `standard` varchar(100) NOT NULL DEFAULT '' COMMENT '产品规格',
  `brand` varchar(100) NOT NULL DEFAULT '' COMMENT '产品品牌',
  `unit` varchar(30) NOT NULL DEFAULT '' COMMENT '产品单位',
  `minprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最小产品价格',
  `maxprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最大产品价格',
  `currency` varchar(15) NOT NULL DEFAULT '' COMMENT '货币单位',
  `minamount` float NOT NULL DEFAULT '0' COMMENT '最小起订量',
  `amount` float NOT NULL DEFAULT '0' COMMENT '供货总量',
  `days` smallint(3) NOT NULL DEFAULT '0' COMMENT '发货时间',
  `keyword` varchar(255) NOT NULL COMMENT '产品关键字',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '访问次数',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '产品图片',
  `thumb1` varchar(255) NOT NULL,
  `thumb2` varchar(255) NOT NULL,
  `pptword` text NOT NULL COMMENT '产品属性',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `groupid` int(11) NOT NULL DEFAULT '0' COMMENT '用户组ID',
  `company` varchar(150) NOT NULL DEFAULT '' COMMENT '公司名称',
  `vip` smallint(2) NOT NULL DEFAULT '0' COMMENT 'vip指数',
  `validated` tinyint(4) NOT NULL DEFAULT '0' COMMENT '公司是否认证 ',
  `truename` varchar(50) NOT NULL DEFAULT '' COMMENT '联系人',
  `telephone` varchar(50) NOT NULL DEFAULT '' COMMENT '电话',
  `mobile` varchar(30) NOT NULL DEFAULT '' COMMENT '移动电话',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '公司地址',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '公司mail',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `totime` int(11) NOT NULL DEFAULT '0' COMMENT '过期时间',
  `edittime` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `editdate` varchar(50) NOT NULL DEFAULT '' COMMENT '修改日期 例如 2013-03-09',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加日期',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '发布状态',
  `linkurl` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `aliid` bigint(20) NOT NULL DEFAULT '0',
  `add_sitemap` smallint(1) NOT NULL,
  `port` varchar(255) DEFAULT NULL COMMENT '港口',
  `payment` varchar(20) DEFAULT NULL COMMENT '支付方式',
  `num_price` varchar(255) DEFAULT NULL COMMENT '订购量对应价格',
  PRIMARY KEY (`itemid`),
  KEY `elite` (`elite`,`username`),
  KEY `mycatid` (`mycatid`,`username`,`status`),
  KEY `catid` (`catid`,`status`,`itemid`),
  KEY `status` (`status`,`itemid`),
  KEY `status_addtime` (`status`,`addtime`),
  KEY `areaid` (`areaid`),
  KEY `addtime` (`addtime`),
  KEY `totime` (`totime`),
  KEY `username` (`username`,`hits`)
) ENGINE=MyISAM AUTO_INCREMENT=837289 DEFAULT CHARSET=utf8;

#
# Data for table "wl_sell"
#

/*!40000 ALTER TABLE `wl_sell` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_sell` ENABLE KEYS */;

#
# Structure for table "wl_sell_data"
#

DROP TABLE IF EXISTS `wl_sell_data`;
CREATE TABLE `wl_sell_data` (
  `itemid` bigint(20) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "wl_sell_data"
#

/*!40000 ALTER TABLE `wl_sell_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_sell_data` ENABLE KEYS */;

#
# Structure for table "wl_tagindex"
#

DROP TABLE IF EXISTS `wl_tagindex`;
CREATE TABLE `wl_tagindex` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(100) NOT NULL COMMENT '关键词',
  `totalcc` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '总访问量',
  `weekcc` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '周访问量',
  `monthcc` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '月访问量',
  `weekup` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '周时间',
  `monthup` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '月时间',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `byname` char(1) NOT NULL DEFAULT '',
  `catid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属分类ID',
  `note` varchar(30) NOT NULL COMMENT '备注',
  `linkurl` varchar(100) NOT NULL,
  `collect` tinyint(1) NOT NULL DEFAULT '0',
  `item` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `byname` (`byname`),
  KEY `tag` (`tag`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM AUTO_INCREMENT=14412 DEFAULT CHARSET=utf8;

#
# Data for table "wl_tagindex"
#

/*!40000 ALTER TABLE `wl_tagindex` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_tagindex` ENABLE KEYS */;

#
# Structure for table "wl_type"
#

DROP TABLE IF EXISTS `wl_type`;
CREATE TABLE `wl_type` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `tname` varchar(100) NOT NULL DEFAULT '',
  `listorder` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`),
  KEY `tname` (`tname`,`userid`),
  KEY `userid` (`userid`),
  KEY `tid` (`tid`,`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=37425 DEFAULT CHARSET=utf8;

#
# Data for table "wl_type"
#

/*!40000 ALTER TABLE `wl_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_type` ENABLE KEYS */;

#
# Structure for table "wl_validate"
#

DROP TABLE IF EXISTS `wl_validate`;
CREATE TABLE `wl_validate` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '认证类型',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '图片附件',
  `thumb1` varchar(255) NOT NULL DEFAULT '' COMMENT '图片附件1',
  `thumb2` varchar(255) NOT NULL DEFAULT '' COMMENT '图片附件2',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '会员名',
  `addtime` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `editor` varchar(30) NOT NULL DEFAULT '' COMMENT '编辑',
  `edittime` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `ip` varchar(50) NOT NULL DEFAULT '' COMMENT 'ip',
  `status` smallint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='资料认证';

#
# Data for table "wl_validate"
#

/*!40000 ALTER TABLE `wl_validate` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_validate` ENABLE KEYS */;

#
# Structure for table "wl_webpage"
#

DROP TABLE IF EXISTS `wl_webpage`;
CREATE TABLE `wl_webpage` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(30) NOT NULL DEFAULT '' COMMENT '所属分组',
  `areaid` int(10) unsigned NOT NULL COMMENT '地区ID',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '级别',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `style` varchar(50) NOT NULL DEFAULT '' COMMENT '颜色',
  `content` mediumtext NOT NULL COMMENT '内容',
  `seo_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO关键词',
  `seo_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `editor` varchar(30) NOT NULL DEFAULT '' COMMENT '编辑',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `listorder` smallint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `hits` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '外部链接',
  `linkurl` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `domain` varchar(255) NOT NULL COMMENT '绑定域名',
  `template` varchar(30) NOT NULL DEFAULT '' COMMENT '模板',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='单网页';

#
# Data for table "wl_webpage"
#

/*!40000 ALTER TABLE `wl_webpage` DISABLE KEYS */;
/*!40000 ALTER TABLE `wl_webpage` ENABLE KEYS */;

#
# Structure for table "新表"
#

DROP TABLE IF EXISTS `新表`;
CREATE TABLE `新表` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "新表"
#

/*!40000 ALTER TABLE `新表` DISABLE KEYS */;
/*!40000 ALTER TABLE `新表` ENABLE KEYS */;
