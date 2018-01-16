<?php

$sql = "select * from category where category_id=63";
// var_dump($sql);

$pro_cate = sql_list($mysqli,$sql);
// var_dump($pro_cate);


//跟随左边栏变化
$id = empty($_GET['cate_id'])?3:$_GET['cate_id'];
// var_dump($id);

$sql = "select * from category where id=$id";
// var_dump($sql);

$cate_name = sql_one($mysqli,$sql);
// var_dump($cate_name);

//内容
$pro_id = $_GET['cid'];
// var_dump($pro_id);

$sql2 = "select * from goods where id = $pro_id";
// var_dump($sql2);
$pro_list = sql_list($mysqli,$sql2);
// var_dump($pro_list);


require_once 'common.php';

?>