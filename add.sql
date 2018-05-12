
-- house
  CREATE TABLE `tp_house` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `cat_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类',
  `house_name` varchar(120) NOT NULL DEFAULT '' COMMENT '商品名称',
  `click_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击数',
  `comment_count` smallint(5) DEFAULT '0' COMMENT '商品评论数',
  `volume` double(10,4) unsigned NOT NULL DEFAULT '0.0000' COMMENT '商品体积。单位立方米',
  `shop_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '本店价',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '商品关键词',
  `house_remark` varchar(255) NOT NULL DEFAULT '' COMMENT '商品简单描述',
  `house_content` text DEFAULT '' COMMENT '商品详细描述',
  `original_img` varchar(255) NOT NULL DEFAULT '' COMMENT '商品上传原始图',
  `is_on_sale` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否上架',
  `on_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品上架时间',
  `sort` smallint(4) unsigned NOT NULL DEFAULT '50' COMMENT '商品排序',
  `is_spec_sale` tinyint(1) DEFAULT '0' COMMENT '是否热卖',
  `sales_sum` int(11) DEFAULT '0' COMMENT '商品销量',
  `is_deleted` tinyint(1) DEFAULT '0',
  `is_add` tinyint(1) DEFAULT '0',
  `house_introduce` varchar(255) NOT NULL DEFAULT '',
  `around_introduce` varchar(255) NOT NULL DEFAULT '',
  `in_house_time`  char(50) NOT NULL DEFAULT '',
  `out_house_time` char(50) NOT NULL DEFAULT '',
  `whole_house_time` char(50) NOT NULL DEFAULT '',
  `living_people`  int(11) unsigned NOT NULL DEFAULT '0',
  `out_strategy`   varchar(255) NOT NULL DEFAULT '退订策略',
  `guest_notice`   varchar(255) NOT NULL DEFAULT '客人须知',
  `house_standard` char(50) NOT NULL DEFAULT '整套 · 1室2厅1厨1卫',
  `province`  varchar(255) NOT NULL DEFAULT '',
  `city`  varchar(255) NOT NULL DEFAULT '',
  `area`  varchar(255) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `add_people` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

  -- city
  CREATE TABLE `tp_city_area` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0',
  `pname` varchar(255) NOT NULL DEFAULT '',
  `pcode` varchar(255) NOT NULL DEFAULT '',
  `cityname` varchar(255) NOT NULL DEFAULT '',
  `citycode` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `pcode` (`pcode`),
  KEY `citycode` (`citycode`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

  -- city
  CREATE TABLE `tp_house_img` (
  `img_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `hid` int(11) unsigned NOT NULL DEFAULT '0',
  `img_path` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`img_id`),
  KEY `hid` (`hid`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;