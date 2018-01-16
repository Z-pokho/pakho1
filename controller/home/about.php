<?php

//左边栏

$sql = "select * from category where category_id=61 ";
// var_dump($sql);

$about_cate = sql_list($mysqli,$sql);
// var_dump($about_cate);


//左边栏id

$cid = empty($_GET['category_id'])?13:$_GET['category_id'];

//跟随左边栏变化
if(@!$_GET['category_id']){

	$id = empty($_GET['id'])?14:$_GET['id'];
	// var_dump($id);
	$sql = "select * from category where id=$id";
	// var_dump($sql);

	$cate_name = sql_one($mysqli,$sql);
	// var_dump($cate_name);die;

}else{

	$id = empty($_GET['category_id'])?14:$_GET['category_id'];
	// var_dump($id);
	$sql = "select * from category where id=$id";
	// var_dump($sql);

	$cate_name = sql_one($mysqli,$sql);
	// var_dump($cate_name);die;

}

//主要内容
if(@!$_GET['category_id']){
	$sql2 = "select * from company where category_id={$id} order by id desc limit 1";
	// var_dump($sql2);
	$about_list = sql_list($mysqli,$sql2);
	// var_dump($about_list);
  }else{
    $sql2 = "select * from company where category_id={$cid} order by id desc limit 1";
	// var_dump($sql2);
	$about_list = sql_list($mysqli,$sql2);
	// var_dump($about_list);

  }
require_once 'common.php';

?>