<?php

$sql = "select * from category where category_id=63";
// var_dump($sql);

$pro_cate = sql_list($mysqli,$sql);
// var_dump($about_cate);


//跟随左边栏变化
$id = empty($_GET['cid'])?3:$_GET['cid'];
// var_dump($id);

$sql = "select * from category where id=$id";
// var_dump($sql);

$cate_name = sql_one($mysqli,$sql);
// var_dump($cate_name);

//分页
$p = empty($_GET['p'])? 1 :$_GET['p'];

$pro_list = pageData('goods',$p,12,"category_id={$id}");
  
// var_dump($pro_list);
$page  = page_home('goods',$p,12,"mot=home&ctl=product&cid={$id}",$showpage=5,"category_id={$id}");
// var_dump($page);die;

require_once 'common.php';

?>