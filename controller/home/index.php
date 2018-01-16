<?php


//首页-公司介绍

$sql = "select * from company where category_id = 13 order by id desc limit 1";
$image = sql_one($mysqli,$sql);
 // var_dump($image);
$image['details'] = strip_tags(htmlspecialchars_decode($image['details']));
// var_dump($about_cate);
$cate_id = empty($_GET['category_id'])?13:$_GET['category_id'];

// var_dump($id);

$sql = "select * from category where id=$cate_id";
// var_dump($sql);

$cate_name = sql_one($mysqli,$sql);
// var_dump($cate_name);die;



$sql2 = "select * from company where category_id = 14 order by id desc limit 1";

$image2 = sql_one($mysqli,$sql2);
 // var_dump($image);
$image2['details'] = strip_tags(htmlspecialchars_decode($image2['details']));
// var_dump($about_cate);
$cate_id2 = empty($_GET['category_id'])?14:$_GET['category_id'];

// var_dump($id2);

$sql2 = "select * from category where id=$cate_id2";
// var_dump($sql2);

$cate_name2 = sql_one($mysqli,$sql2);
// var_dump($cate_name2);die;


$sql3 = "select * from company where category_id = 15 order by id desc limit 1";

$image3 = sql_one($mysqli,$sql3);
 // var_dump($image);
$image3['details'] = strip_tags(htmlspecialchars_decode($image3['details']));
// var_dump($about_cate);
$cate_id3 = empty($_GET['category_id'])?15:$_GET['category_id'];

// var_dump($id2);

$sql3 = "select * from category where id=$cate_id3";
// var_dump($sql2);

$cate_name3 = sql_one($mysqli,$sql3);
// var_dump($cate_name2);die;



//首页-产品中心

 $sql4 = "select * from goods order by id desc limit 0,8";
 // var_dump($sql4);
 $pro = sql_list($mysqli,$sql4);
 // var_dump($pro);

foreach ($pro as $key => $value) {

   $pid = $value['category_id'];

   $sql5 = "select * from category where id=$pid";
   // var_dump($sql5);

  $dd = sql_one($mysqli,$sql5);
  
  $pro[$key]['cate_name'] = $dd['cate_name'];
}


//首页-新闻中心

 $sql6 = "select * from news order by id desc limit 1";
 // var_dump($sql6);
 $n = sql_one($mysqli,$sql6);
 // var_dump($n);
$nid = empty($_GET['nid'])?1:$_GET['nid'];
// var_dump($nid);
$sql7 = "select * from news order by id desc limit 0,4";
// var_dump($sql7);

$news = sql_list($mysqli,$sql7);
// var_dump($newss);

foreach ($news as $key => $value) {

  $content = strip_tags(htmlspecialchars_decode($value['content']));

    if(mb_strlen($content,'utf-8')>1){
      $news[$key]['content'] = mb_substr($content, 0,65,'utf-8');
     }
}


//首页-留言板

if($_A=='index'){

    if($_POST){
      // var_dump($_POST);die;
      
      if($_POST['code']==''){

    script_error('验证码不能为空');

   }else if(strtolower($_POST['code']) !=$_SESSION['vcode'])
    {
      script_error('验证码不正确');

   }

      $datas['name'] = $_POST['name'];

//正则表达式
//$tel = "15558530459"; //作者的手机号码,如果有疑问可以电话联系我,或者QQ联系我,我的QQ是mezongzi@qq.com
if (strlen($_POST['phone']) == "11") {
  //上面部分判断长度是不是11位
  // var_dump($_POST['phone']);die;
  preg_match_all("/13[123569]{1}\d{8}|15[1235689]\d{8}|188\d{8}/", $_POST['phone']);
  // 接下来的正则表达式("/131,132,133,135,136,139开头随后跟着任意的8为数字 '|'(或者的意思)
  //  * 151,152,153,156,158.159开头的跟着任意的8为数字
  //  * 或者是188开头的再跟着任意的8为数字,匹配其中的任意一组就通过了
  //  * /")
} else {
  
  script_error("手机号码格式不正确");
}
/*
 * 虽然看起来复杂点,清楚理解!
 * 如果有更好的,可以贴出来,分享快乐!
 * */

      $datas['phone'] = $_POST['phone'];

      // var_dump($_POST['phone']);
      $datas['message'] = $_POST['message'];
        // var_dump($_POST['message']);die;

      $keys = '';

      $values = '';

      foreach ($datas as $key => $value){

      $keys   .= $key.',';

      $values .= "'".$value."',";

      }

      $keys    = rtrim($keys,',');
      // var_dump($keys);die;

      $values  = rtrim($values,',');

      $sql = "insert into message ($keys) values ($values)";
      // var_dump($sql);
      $result = sql_insert($mysqli,$sql);
      // var_dump($result);die;


      if($result){

        script_success('提交成功','index.php?mot=home&ctl=index&act=index');

      }else{
        script_error('提交失败');

      }

   }

}else if($_A=='code'){

  include "lib/code.php";

  vcode();
}

 $sql = "select * from contact where 1";
 // var_dump($sql);
 $contact = sql_one($mysqli,$sql);
// var_dump($contact);



require_once 'common.php';

?>