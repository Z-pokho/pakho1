<?php

$sql = "select * from category where category_id=62";
// var_dump($sql);

$news_cate = sql_list($mysqli,$sql);
// var_dump($about_cate);


//跟随左边栏变化
$id = empty($_GET['cate_id'])?1:$_GET['cate_id'];
// var_dump($id);

$sql = "select * from category where id=$id";
// var_dump($sql);

$cate_name = sql_one($mysqli,$sql);
// var_dump($cate_name);die;

//内容
$news_id = $_GET['nid'];
// var_dump($news_id);

$sql2 = "select * from news where id = $news_id";
// var_dump($sql2);
$news_list = sql_list($mysqli,$sql2);
// var_dump($news_list);


//翻页
$sql = "select * from news where category_id={$_GET['cate_id']} and (id < $news_id) order by id desc limit 1";
// var_dump($sql);
$prev = sql_one($mysqli,$sql);
// var_dump($prev);

$sql = "select * from news where category_id={$_GET['cate_id']} and (id > $news_id) order by id limit 1";
// var_dump($sql);
$next = sql_one($mysqli,$sql);
// var_dump($next);

require_once 'common.php';

?>