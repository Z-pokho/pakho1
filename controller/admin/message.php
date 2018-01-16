
<?php

//留言板管理
if($_A=='index'){
   
    //查询数据库
    $sql= "select * from message where 1";

    $arr = sql_list($mysqli,$sql);

     foreach ($arr as $key =>  $value) {


     $arr[$key]['message'] = empty($value['message'])?'NULL':$value['message'];

    }

    $sql_count = "select count('id') as count from message where 1";

    $count = sql_one($mysqli,$sql_count);

  
   include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

//添加页面
}else if($_A=='add'){

  if($_POST){
    // var_dump($_POST);die;

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


      $data['name'] = $_POST['name'];

      $data['phone'] = $_POST['phone'];

      $data['email'] = $_POST['email'];

      $data['address'] = $_POST['address'];

      $data['message'] = $_POST['message'];

      $keys = '';

      $values = '';

      foreach ($data as $key => $value){

      $keys   .= $key.',';

      $values .= "'".$value."',";

      }

      $keys    = rtrim($keys,',');

      $values  = rtrim($values,',');

      $sql = "insert into message ($keys) values ($values)";
      // var_dump($sql);
      $result = sql_insert($mysqli,$sql);
      // var_dump($result);die;

      if($result){
              script_success('添加成功','index.php?mot=admin&ctl=message&act=index');
         }else{
              script_error('添加失败');
         }

    }else{


  include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

  }


//删除页面
}else if($_A=='del'){

   $id = $_GET['id'];
   /*var_dump($id);die;*/
   $sql = "delete from message where id={$id}";
  /* var_dump($sql);die;*/

   $result = sql_del($mysqli,$sql);
  /* var_dump($result);die;*/

    if($result){

    echo json_encode(1);
    die;

   }else{

    echo json_encode(0);
    die;
   }


//修改页面
}else if($_A=='edit'){

   if($_POST){

    $id = $_POST['id'];
   /* var_dump($id);die;*/

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


    $data['name'] = $_POST['name'];

    $data['phone'] = $_POST['phone'];

    $data['email'] = $_POST['email'];

    $data['address'] = $_POST['address'];

    $data['message'] = $_POST['message'];

    $keys = '';

    foreach ($data as $key => $value) {
      
      $keys .=$key."='".$value."',";

    }/*var_dump($keys);die;*/

    $keys = rtrim($keys,',');
    /*var_dump($keys);die;*/

    $sql = "update message set {$keys} where id={$id}";
   /* var_dump($sql);*/
    $result = sql_edit($mysqli,$sql);
    // var_dump($result);die;
    if($result){

      script_success('修改成功','index.php?mot=admin&ctl=message&act=index');

    }else{

      script_error('修改失败');
    }

   }else{

    //查询跳转过来当前ID数据
    $id = $_GET['id'];

    $sql = "select * from message where id={$id}";
    // var_dump($sql);die;

    $result = sql_one($mysqli,$sql);
    // var_dump($result);die;

     include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

   }

}

?>