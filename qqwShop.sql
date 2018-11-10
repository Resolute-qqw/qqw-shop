drop table if exists category;
create table category
(
    id int unsigned not null auto_increment comment 'ID',
    cat_name varchar(255) not null comment '分类名称',
    parent_id int unsigned not null default 0 comment '上级ID',
    path varchar(255) not null default '-' comment '所有上级分类的ID',
    primary key (id)
)engine=InnoDB comment='分类表';

TRUNCATE category;
INSERT INTO category VALUES
(1,'家用电器',0,'-'),
(2,'电视',1,'-1-'),
(3,'空调',1,'-1-'),
(4,'曲面电视',2,'-1-2-'),
(5,'超薄电视',2,'-1-2-'),
(6,'柜式空调',3,'-1-3-'),
(7,'中央空调',3,'-1-3-'),
(8,'电脑',0,'-'),
(9,'电脑整机',8,'-8-'),
(10,'电脑配件',8,'-8-'),
(11,'笔记本',9,'-8-9-'),
(12,'游戏本',9,'-8-9-'),
(13,'显示器',10,'-8-10-'),
(14,'CPU',10,'-8-10-');


drop table if exists brand;
create table brand
(
    id int unsigned not null auto_increment comment 'ID',
    brand_name varchar(255) not null comment '品牌名称',
    logo varchar(255) not null comment 'LOGO',
    primary key (id)
)engine=InnoDB comment='品牌表';

drop table if exists goods;
create table goods
(
    id int unsigned not null auto_increment comment 'ID',
    goods_name varchar(255) not null comment '商品名称',
    logo varchar(255) not null comment 'LOGO',
    is_on_sale enum('y','n') not null default 'y' comment '是否上架',
    description longtext not null comment '商品描述',
    cat1_id int unsigned not null comment '一级分类ID',
    cat2_id int unsigned not null comment '二级分类ID',
    cat3_id int unsigned not null comment '三级分类ID',
    brand_id int unsigned not null comment '品牌ID',
    created_at datetime not null default current_timestamp comment '添加时间',
    primary key (id)
)engine=InnoDB comment='商品表';

drop table if exists goods_attribute;
create table goods_attribute
(
    id int unsigned not null auto_increment comment 'ID',
    attr_name varchar(255) not null comment '属性名称',
    attr_value varchar(255) not null comment '属性值',
    goods_id int unsigned not null comment '所属的商品ID',
    primary key (id)
)engine=InnoDB comment='商品属性表';

drop table if exists goods_image;
create table goods_image
(
    id int unsigned not null auto_increment comment 'ID',
    goods_id int unsigned not null comment '所属的商品ID',
    path varchar(255) not null comment '图片的路径',
    primary key (id)
)engine=InnoDB comment='商品图片表';

drop table if exists goods_sku;
create table goods_sku
(
    id int unsigned not null auto_increment comment 'ID',
    goods_id int unsigned not null comment '所属的商品ID',
    sku_name varchar(255) not null comment 'SKU名称',
    stock int unsigned not null comment '库存量',
    price decimal(10,2) not null comment '价格',
    primary key (id)
)engine=InnoDB comment='商品SKU表';


-- RBAC
drop table if exists privilege;
create table privilege
(
    id int unsigned not null auto_increment comment 'ID',
    pri_name varchar(255) not null comment '权限名称',
    url_path varchar(255) not null comment '对应的URL地址，多个地址用,隔开',
    parent_id int unsigned not null default '0' comment '上级权限的ID',
    primary key (id)
)engine=InnoDB comment='权限表';

drop table if exists role_privlege;
create table role_privlege
(
    pri_id int unsigned not null comment '权限ID',
    role_id int unsigned not null comment '角色ID',
    key pri_id(pri_id),
    key role_id(role_id)
)engine=InnoDB comment='角色权限表';

drop table if exists role;
create table role
(
    id int unsigned not null auto_increment comment 'ID',
    role_name varchar(255) not null comment '角色名称',
    primary key (id)
)engine=InnoDB comment='角色表';

drop table if exists admin_role;
create table admin_role
(
    role_id int unsigned not null comment '角色ID',
    admin_id int unsigned not null comment '管理员ID',
    key role_id(role_id),
    key admin_id(admin_id)
)engine=InnoDB comment='管理员表';

drop table if exists admin;
create table admin
(
    id int unsigned not null auto_increment comment 'ID',
    username varchar(255) not null comment '用户名',
    password varchar(255) not null comment '密码',
    primary key (id)
)engine=InnoDB comment='管理员表';