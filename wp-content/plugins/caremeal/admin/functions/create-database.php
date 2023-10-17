<?php
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
global $wpdb;
//Tạo DB nguyên liệu
$sql_nguyen_lieu = 'CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.'cm_nguyen_lieu (
    id bigint(20) not null auto_increment,
    ten varchar(20) UNIQUE,
    nhom varchar(20),
    nang_luong varchar(20),
    protein varchar(20),
    lipid varchar(20),
    glucid varchar(20),
    anh_av varchar(200),
    anh_if varchar(200),
    anh_av_id varchar(200),
    anh_if_id varchar(200),
    url varchar(100),
    nl_f1 int(20), 
    nl_f2 int(20), 
    nl_f3 int(20), 
    nl_f4 int(20), 
    nl_f5 int(20), 
    nl_f6 int(20), 
    nl_f7 int(20), 
    nl_f8 int(20), 
    nl_f9 int(20), 
    nl_f10 int(20), 
    primary key (id)
) default character set utf8mb4 collate utf8mb4_unicode_ci;
';
dbDelta( $sql_nguyen_lieu );

//Tạo DB năng lượng
$sql_nang_luong = 'CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.'cm_nang_luong (
    id bigint(20) not null auto_increment,
    tuoi varchar(200),
    gioi_tinh varchar(20),
    nang_luong varchar(20),
    protein varchar(20),
    glucid varchar(20),
    lipid varchar(20),
    primary key (id)
) default character set utf8mb4 collate utf8mb4_unicode_ci;
';
dbDelta( $sql_nang_luong );

//Tạo DB món ăn
$sql_mon_an = 'CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.'cm_mon_an (
    id bigint(20) not null auto_increment,
    ten varchar(20) UNIQUE,
    nhom varchar(255),
    nguyen_lieu varchar(250),
    nang_luong varchar(20),
    protein varchar(20),
    glucid varchar(20),
    lipid varchar(20),
    anh_av varchar(200),
    anh_av_id varchar(200),
    url varchar(100),
    bs_f1 int(20), 
    bs_f2 int(20), 
    bs_f3 int(20), 
    bs_f4 int(20), 
    bs_f5 int(20), 
    bs_f6 int(20), 
    bs_f7 int(20), 
    bs_f8 int(20), 
    bs_f9 int(20), 
    bs_f10 int(20),
    primary key (id)
) default character set utf8mb4 collate utf8mb4_unicode_ci;
';
dbDelta( $sql_mon_an );

//Tạo DB thống kê
$sql_thong_ke = 'CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.'cm_thong_ke (
    id bigint(20) not null auto_increment,
    user_id varchar(20),
    ngay varchar(20),  
    thang varchar(20), 
    an_sang varchar(250),
    an_sang_nang_luong varchar(20), 
    an_sang_protein varchar(20),
    an_sang_glucid varchar(20),
    an_sang_lipid varchar(20),
    an_trua varchar(250),
    an_trua_nang_luong varchar(20), 
    an_trua_protein varchar(20),
    an_trua_glucid varchar(20),
    an_trua_lipid varchar(20),
    an_toi varchar(250),
    an_toi_nang_luong varchar(20), 
    an_toi_protein varchar(20),
    an_toi_glucid varchar(20),
    an_toi_lipid varchar(20),
    phu_toi varchar(250),
    phu_toi_nang_luong varchar(20), 
    phu_toi_protein varchar(20),
    phu_toi_glucid varchar(20),
    phu_toi_lipid varchar(20),
    tong varchar(250),
    tong_nang_luong varchar(20), 
    tong_protein varchar(20),
    tong_glucid varchar(20),
    tong_lipid varchar(20),
    primary key (id)
) default character set utf8mb4 collate utf8mb4_unicode_ci;
';
dbDelta( $sql_thong_ke );

//Tạo DB thực đơn
$sql_thuc_don = 'CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.'cm_thuc_don (
    id bigint(20) not null auto_increment,
    ngay varchar(20),  
    thu varchar(20), 
    mon_an varchar(250),
    nang_luong varchar(20), 
    protein varchar(20),
    glucid varchar(20),
    lipid varchar(20),
    primary key (id)
) default character set utf8mb4 collate utf8mb4_unicode_ci;
';
dbDelta( $sql_thuc_don );

