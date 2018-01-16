<?php

//联系我们

 $sql = "select * from contact where 1";
 // var_dump($sql);
 $contact = sql_one($mysqli,$sql);
// var_dump($contact);


//联系我们-留言板

if($_A=='index'){

    if($_POST){
      // var_dump($_POST);die;
      
    if($_POST['code']==''){

    script_error('验证码不能为空');

   }else if(strtolower($_POST['code']) !=$_SESSION['vcode'])
    {
      script_error('验证码不正确');

   }
    

//正则表达式
 //作者的手机号码,如果有疑问可以电话联系我,或者QQ联系我,我的QQ是mezongzi@qq.com
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

//邮箱

if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/",$_POST['email'])){//安全性

    script_error('邮箱号码不正确');
}


      $datas['name'] = $_POST['name'];

      $datas['phone'] = $_POST['phone'];

      // var_dump($_POST['phone']);
      $datas['message'] = $_POST['message'];
        // var_dump($_POST['message']);die;

      $datas['email'] = $_POST['email'];

      $datas['address'] = $_POST['address'];
        
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

        script_success('提交成功','index.php?mot=home&ctl=contact&act=index');

      }else{
        script_error('提交失败');

      }

   }

}else if($_A=='code'){

  include "lib/code.php";

  vcode();
}

require_once 'common.php';


?>