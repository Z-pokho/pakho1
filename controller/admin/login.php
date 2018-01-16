<?php

//登录页面
if($_A=='index'){
  
   if($_POST){

   if($_POST['code']==''){

    script_success('验证码不能为空');

   }else if(strtolower($_POST['code']) !=$_SESSION['vcode'])
    {
      script_error('验证码不正确');

   }

   $username = $_POST['username'];

   if(!preg_match('/^[a-zA-Z][a-zA-Z0-9_]{4,15}$/',$username)){//安全性

    script_error('命名要以字母开头，5-16字符，可以是字母或者数字或者_');
   }

   $password = MD5($_POST['password']);

   $check    = empty($_POST['online'])?'':$_POST['online'];//是否选中记住我们

   $sql = "select * from admin where username='{$username}'and password='{$password}'";

   $result =sql_one($mysqli,$sql);


   if($result){

      /* if($result['id']!=1){

      $sql = "select * from admin_role inner join role_menu on admin_role.role_id=role_menu.role_id where admin_role.user_id={$result['id']}";

      $_SESSION['level'] = sql_list($mysqli,$sql);
    }*/

       $_SESSION['username'] = $result['username'];//记住用户名 做登录验证权限

       /*$_SESSION['uid']      = $result['id'];*/

       if($check == 1){//判断有选中记住 checkbox 复选框

          setcookie('username',$username,time()+3600);
//记住用户名
          setcookie('password',$_POST['password'],time()+3600);//记住密码

       }else{

          setcookie('username','',time()-3600);
//删除用户名
          setcookie('password',null,time()-3600);
//删除密码
       }
       
      script_success('欢迎使用H-ui.admin后台模板','index.php?mot=admin&ctl=index');

   }else{

      script_error('你的信息不正确，请重新登录');

   }

   }else{

        include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
   }


}else if($_A=='code'){

  include "lib/code.php";

  vcode();
}


?>