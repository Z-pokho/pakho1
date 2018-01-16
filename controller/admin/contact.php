<?php

if($_A=='index'){

  $sql = "select * from contact where 1";

  $arr = sql_list($mysqli,$sql);
  // var_dump($arr);

  foreach ($arr as $key =>  $value) {

     $footer1 = strip_tags(htmlspecialchars_decode($value['footer1']));
     $footer2 = strip_tags(htmlspecialchars_decode($value['footer2']));
     $footer3 = strip_tags(htmlspecialchars_decode($value['footer3']));
           //剥去字符串中的 HTML 标签  //把预定义的 HTML 实体 "<"（小于）和 ">"（大于）转换为字符
           
     // if(mb_strlen($content,'utf-8')){
      $arr[$key]['footer1'] = mb_substr($footer1, 0,150,'utf-8');
      $arr[$key]['footer2'] = mb_substr($footer2, 0,150,'utf-8');
      $arr[$key]['footer3'] = mb_substr($footer3, 0,150,'utf-8');
     // }

    }

  $sql_count = "select count('id') as count from contact where 1";

  $count = sql_one($mysqli,$sql_count);

	include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';


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

//QQ
// if(!preg_match("[1-9][0-9]{4,}",$_POST['QQ'])){//安全性
//     script_error('QQ号码不正确');
// }

// //邮箱

// if(!preg_match('^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$',$_POST['email'])){//安全性

//     script_error('邮箱号码不正确');
// }

    $data = $_POST;

    // $data['footer'] = htmlspecialchars($_POST['footer']);
                    //把预定义的字符 "<" （小于）和 ">" （大于）转换为 HTML 实体

   $array = ['image/jpeg','image/png','image/gif']; 

   if($_FILES['image']['name']){ //判断是否存在文件名

    if(in_array($_FILES['image']['type'],$array)){ //判断是否为图片文件

     if($_FILES['image']['size']<2097152){//判断大小范图
     // echo_print($_FILES['image']['name']);

     $ext = strripos($_FILES['image']['name'],'.');

     $exts = substr($_FILES['image']['name'],$ext);
     // var_dump($exts);die;
     
     $upload = 'upload/';

     if(!file_exists($upload)){

      mkdir($upload,0777); //生成目录 0777最高权限 可读 可写

     }

     $files = $upload.rand(10000,99999).date('Ymd',time()).$exts;

     $image = move_uploaded_file($_FILES['image']['tmp_name'],$files);

     $data['image']   = $files;
     // var_dump($image);die;
     }

  }

}
     $keys = '';
     $values = '';

     foreach ($data as $key => $value){

       $keys .= $key.',';
       $values .= "'".$value."',";

     }

     $keys = rtrim($keys,',');
     $values = rtrim($values,',');
     
     $sql = "insert into contact($keys) values($values)";
     // var_dump($sql);die;

     $result = sql_insert($mysqli,$sql);
     // var_dump($result);die;
     if($result){
          script_success('添加成功','index.php?mot=admin&ctl=contact&act=index');
     }else{
          script_error('添加失败');
     }

	}else{
   

    include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
	}


}else if($_A=='edit'){


   if($_POST){

  $id = $_POST['id'];

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

// //QQ
// if(!preg_match("[1-9][0-9]{4,}",$_POST['QQ'])){//安全性

//     script_error('QQ号码不正确');
// }

//邮箱

// if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/",$_POST['email'])){//安全性

//     script_error('邮箱号码不正确');
// }

   $data = $_POST;

   // $data['footer'] = htmlspecialchars($_POST['footer']);

   $array = ['image/jpeg','image/png','image/gif']; 

   if($_FILES['image']['name']){ //判断是否存在文件名

    if(in_array($_FILES['image']['type'],$array)){ //判断是否为图片文件

     if($_FILES['image']['size']<2097152){//判断大小范图
     // echo_print($_FILES['image']['name']);

     $ext = strripos($_FILES['image']['name'],'.');

     $exts = substr($_FILES['image']['name'],$ext);
     // var_dump($exts);die;
     
     $upload = 'upload/';

     if(!file_exists($upload)){

      mkdir($upload,0777); //生成目录 0777最高权限 可读 可写

     }

     $files = $upload.rand(10000,99999).date('Ymd',time()).$exts;

     $image = move_uploaded_file($_FILES['image']['tmp_name'],$files);

     $data['image']   = $files;
     // var_dump($image);die;
     }

  }

}
     $keys = '';

     foreach ($data as $key => $value){

       $keys .= $key."='".$value."',";

     }

     $keys = rtrim($keys,',');
     
     $sql = "update contact set $keys where id={$id}";
     // var_dump($sql);die;

     $result = sql_edit($mysqli,$sql);
     // var_dump($result);die;
     if($result){
          script_success('修改成功','index.php?mot=admin&ctl=contact&act=index');
     }else{
          script_error('修改失败');
     }

  }else{

   $id = $_GET['id'];

   $sql = "select * from contact where id={$id}";

   $result = sql_one($mysqli,$sql);

    include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
  }


}else if($_A=='del'){

  $id = $_GET['id'];

  $sql = "delete from contact where id={$id}";
  /*var_dump($sql);*/
  $result = sql_del($mysqli,$sql);
 /* var_dump($result);die;*/

  if($result){

    echo json_encode(1);
    die;
   }else{
    echo json_encode(0);
    die;
   }


}



?>