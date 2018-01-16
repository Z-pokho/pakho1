<?php

if(!isset($_SESSION)){

    session_start();

}

define('DBHOST','127.0.0.1');
define('DBUSER','root');
define('DBPASSWORD','root');
define('DBNAME','pakho');
define('CHARSET','utf8');

include 'common.php';
include 'function.php';
include 'config.php';
include 'code.php';
include "page.php";

define('CONTROLLER','controller/');//控制器目录
define('VIEW','view/');//视图目录
define('TYPE',1);//切换路由
define('ADMIN','common/admin/');//资源目录 后台 js css font 



login();




if(TYPE==1){

    $_M = isset($_GET['mot'])?$_GET['mot']:'home';//模型
    $_C = empty($_GET['ctl'])?'index':$_GET['ctl'];//控制器
    $_A = empty($_GET['act'])?'index':$_GET['act'];//操作方法，控制分支

}


	// echo PUBLIC;die;
/*define('PHP_SELF',@empty($_SERVER['PHP_SELE'])?1:$_SERVER['PHP_SELE']);

define('QUEERY_STRING',@empty($_SERVER['QUEERY_STRING'])?1:$_SERVER['QUEERY_STRING']);*/

//前台

define('H_COMMON','common/home/');
define('INDEX','index.php?mot=home&ctl=index&act=index');
define('ABOUT','index.php?mot=home&ctl=about&act=index');
define('NEWS','index.php?mot=home&ctl=news&act=index');
define('PRODUCT','index.php?mot=home&ctl=product&act=index');
define('NEWS_DETAILS','index.php?mot=home&ctl=news_details&act=index');
define('PRO_DETAILS','index.php?mot=home&ctl=product_details&act=index');
define('CONTACT','index.php?mot=home&ctl=contact&act=index');
define('MAP','index.php?mot=home&ctl=map&act=index');