<?php

$sql = "select * from category where category_id=62";
// var_dump($sql);

$news_cate = sql_list($mysqli,$sql);
// var_dump($news_cate);


//跟随左边栏变化
$id = empty($_GET['nid'])?1:$_GET['nid'];
// var_dump($id);

$sql = "select * from category where id=$id";
// var_dump($sql);

$cate_name = sql_one($mysqli,$sql);
// var_dump($cate_name);

//分页
$p = empty($_GET['p'])? 1 :$_GET['p'];

$news_list = pageData('news',$p,5,"category_id={$id}");
  
// var_dump($new_list);
$page  = page_home('news',$p,5,"mot=home&ctl=news&nid={$id}",$showpage=5,"category_id={$id}");
// var_dump($page);die;

require_once 'common.php';
?>