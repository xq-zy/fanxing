


--管理员表--
CREATE TABLE `fs_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL COMMENT '管理员名称',
  `password` char(32) NOT NULL COMMENT '密码',
  `salt` char(6) NOT NULL COMMENT '密钥',
  `private` int(1) NOT NULL DEFAULT '1' COMMENT '管理员权限，0为最高级权限，1为普通权限',
  `regist_time` int(20) NOT NULL COMMENT '注册时间',
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '用户状态，0为删除，1为正常',
  `login` int(10) NOT NULL DEFAULT '0' COMMENT '登录次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员表';

--角色表--
CREATE TABLE `fs_role` (
  `role_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) NOT NULL COMMENT '角色名称',
  `role_auth_ids` varchar(128) NOT NULL DEFAULT '' COMMENT '权限ids',
  `role_auth_ac` text COMMENT '控制器-操作方法',
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '正常为1，删除为0',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色表';

--权限表--
CREATE TABLE `fs_auth` (
  `auth_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `auth_name` varchar(20) NOT NULL COMMENT '权限名称',
  `auth_pid` smallint(6) unsigned NOT NULL COMMENT '父权限id',
  `auth_c` varchar(32) NOT NULL DEFAULT '' COMMENT '控制器',
  `auth_a` varchar(32) NOT NULL DEFAULT '' COMMENT '操作方法',
  `auth_level` int(1) NOT NULL DEFAULT '0' COMMENT '权限等级',
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '正常为1，删除为0',
  PRIMARY KEY (`auth_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限表';

--商品表--
CREATE TABLE `fs_goods` (
  `goods_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `goods_name` varchar(128) NOT NULL COMMENT '商品名称',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `goods_members_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `goods_number` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '商品数量',
  `goods_weight` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品重量',
  `type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '类型id',
  `goods_introduce` text COMMENT '商品详情介绍',
  `goods_big_logo` char(100) NOT NULL DEFAULT '' COMMENT '图片logo大图',
  `goods_small_logo` char(100) NOT NULL DEFAULT '' COMMENT '图片logo小图',
  `add_time` int(11) NOT NULL COMMENT '添加商品时间',
  `edit_time` int(11) NOT NULL COMMENT '修改商品时间',
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '商品状态 1正常 0删除',
  PRIMARY KEY (`goods_id`),
  UNIQUE KEY `goods_name` (`goods_name`),
  KEY `goods_price` (`goods_price`),
  KEY `add_time` (`add_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品表';

--商品-属性关联表--
CREATE TABLE `fs_goods_attr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `attr_id` smallint(5) unsigned NOT NULL COMMENT '属性id',
  `attr_value` varchar(32) NOT NULL COMMENT '商品对应属性的值',
  PRIMARY KEY (`id`),
  KEY `attr_id` (`attr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品-属性关联表';

--商品-相册关联表--
CREATE TABLE `fs_goods_pics` (
  `pics_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `pics_big` char(128) NOT NULL DEFAULT '' COMMENT '相册大图800*800',
  `pics_mid` char(128) NOT NULL DEFAULT '' COMMENT '相册中图350*350',
  `pics_sma` char(128) NOT NULL DEFAULT '' COMMENT '相册小图50*50',
  PRIMARY KEY (`pics_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品-相册关联表';

--类型表--
CREATE TABLE `fs_type` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `type_name` varchar(32) NOT NULL COMMENT '类型名称',
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '类型状态 1正常 0删除',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='类型表';

--属性表--
CREATE TABLE `fs_attribute` (
  `attr_id` smallint unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `attr_name` varchar(32) NOT NULL COMMENT '属性名称',
  `type_id` smallint unsigned NOT NULL COMMENT '外键，类型id',
  `attr_sel` int NOT NULL DEFAULT '1' COMMENT '1:输入框(唯一)  2:后台下拉列表/前台单选框',
  `attr_write` int NOT NULL DEFAULT '1' COMMENT '1:手工录入  2:从列表选择',
  `attr_vals` varchar(256) NOT NULL DEFAULT '' COMMENT '可选值列表信息,例如颜色：白色,红色,绿色,多个可选值通过逗号分隔',
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '属性状态 1正常 0删除',
  PRIMARY KEY (`attr_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='属性表';

--会员级别--
CREATE TABLE `fs_member_level` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `level_name` varchar(30) NOT NULL COMMENT '级别名称',
  `level_rate` tinyint(3) unsigned NOT NULL DEFAULT '100' COMMENT '折扣率，100=10折 98=9.8折 90=9折，用时除100',
  `jifen_bottom` mediumint(8) unsigned NOT NULL COMMENT '积分下限',
  `jifen_top` mediumint(8) unsigned NOT NULL COMMENT '积分上限',
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '会员级别状态 1正常 0删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员级别';

--会员表--
CREATE TABLE `fs_user` (
  `user_id` int NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `username` varchar(128) NOT NULL DEFAULT '' COMMENT '登录名',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `salt` char(6) NOT NULL COMMENT '密钥',
  `user_email` varchar(64) NOT NULL DEFAULT '' COMMENT '邮箱',
  `user_sex` tinyint NOT NULL DEFAULT '1' COMMENT '性别',
  `user_qq` varchar(32) NOT NULL DEFAULT '' COMMENT 'qq',
  `user_tel` varchar(32) NOT NULL DEFAULT '' COMMENT '手机',
  `user_xueli` tinyint NOT NULL DEFAULT '1' COMMENT '学历',
  `user_hobby` varchar(32) NOT NULL DEFAULT '' COMMENT '爱好',
  `user_introduce` text COMMENT '简介',
  `user_time` int(11) DEFAULT NULL COMMENT '注册时间',
  `last_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员表';