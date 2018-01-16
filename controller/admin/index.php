<?php

//welcome页面

  $sql_n_count = "select count('id') as count from news where 1";

  $n_count = sql_one($mysqli,$sql_n_count);//新闻总条数


  $sql_p_count = "select count('id') as count from goods where 1";

  $p_count = sql_one($mysqli,$sql_p_count);//产品总条数


  $sql_m_count = "select count('id') as count from menu where 1";

  $m_count = sql_one($mysqli,$sql_m_count);//菜单总条数


  $sql_c_count = "select count('id') as count from category where 1";

  $c_count = sql_one($mysqli,$sql_c_count);//菜单总条数


  $sql_a_count = "select count('id') as count from message where 1";

  $a_count = sql_one($mysqli,$sql_a_count); //留言板总条数


  $sql_u_count = "select count('id') as count from admin where 1";

  $u_count = sql_one($mysqli,$sql_u_count);//管理员


  $total = $n_count['count']+$p_count['count']+$m_count['count']+$c_count['count']+$a_count['count']+$u_count['count'];


 $hostname = $_SERVER["HTTP_HOST"]; //获取计算机名

 $ip = GetHostByName($_SERVER['SERVER_NAME']);//获取服务器IP

 $https = $_SERVER["HTTP_HOST"];//获取服务器域名（主机名）

 $server = $_SERVER['SERVER_PORT'];//获取服务器Web端口

 $uname = php_uname();

 $file = dirname(__FILE__); //获取当前文件绝对路径

 $language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];//获取服务器语言

 // session_start();
 // print("<html><b>");
 // 
 $sid = session_id(); //获取当前Session的ID

 // print("Session ID returned by session_id(): ".$sid."\n");
 // $sid = SID;
 // print("Session ID returned by SID: ".$sid."\n");
 // $mysite = $_SESSION["mysite"];
 // print("Value of mysite has been retrieved: ".$mysite."\n");
 // print("</b></html>\n");

  $user = Get_Current_User();//当前系统用户名


//首页
if(empty($_SESSION['username'])){
    echo"<script>alert('非法登录,请到登录页面');window.location.href='index.php?mot=admin&ctl=login';</script>";
}

//遍历左边导航栏
if($_A=='index'){

     $sql = "select * from menu where display=1 and distinction=1 and category_id=0  order by place asc";
     $result = sql_list($mysqli,$sql);
    /* var_dump($result);die;*/

    foreach ($result as $Key => $value) {
      
              $sql2 = "select * from menu where display=1 and distinction=1

              and category_id={$value['id']} order by place asc";


             $r = sql_list($mysqli,$sql2);
             // var_dump($r);die;
             $arr ='';
           if(is_array($value)){
               foreach  ($r as $k=> $v) {
                 /*$result[$Key]['next'] = sql_list($mysqli,$sql2);*/
                 $r[$k]['urls']  = "index.php?mot=admin&ctl={$v['controller']}&act={$v['action']}";
               // var_dump($r[$k]['urls']);die;
               }
            
          }
           $result[$Key]['next'] = $r;
     }

    include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
}

//退出登录
else if($_A=='out'){

      // $_SESSION =($_SESSION['username']);
      
      $_SESSION =array();

      
      @session_destroy($_SESSION['username']);

      echo"<script> alert('退出成功');window.location.href='index.php?mot=admin&ctl=login';</script>";
       
         exit;
      

}else if($_A=='welcome'){

  include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';


}else if($_A=='selects'){

   $id = $_POST['id'];

   if($id){

    $sql = "select * from category where category_id = {$id}";

    $result = sql_list($mysqli,$sql);

    $selects = '';

    if($result){

    $selects .= '<div class="formControls col-xs-8 col-sm-2"><span class="select-box"><select class="select" size="1" name="cate_id" > <option value="">请选择分类</option>';

      for ($i=0; $i < count($result); $i++){
        $selects .=  '<option value="'.$result[$i]['id'] .'">'.$result[$i]['cate_name'].'</option>';
      }

      /*for($i=0; $i <count($result); $i++){

        $selects .= '<option vallue="'.$result[$i]['cid'] .'">'.$result[$i]['cate_name'].'</option>';

      }*/
    $selects .='</select></span></div>';
    echo $selects;
    exit();

    }

   }

}



