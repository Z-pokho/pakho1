<?php

if($_A=='index'){

	$sql= "select * from goods where 1";

	$arr = sql_list($mysqli,$sql);
  // var_dump($arr);
  foreach ($arr as $key => $value ){

  $sql = "select cate_name from category where id = {$value['category_id']} ";

  $data = sql_one($mysqli,$sql);
 
  $arr[$key]['category_id'] = $data['cate_name'];

  $arr[$key]['display'] = $value['display']==1?'显示':'隐藏';

  $arr[$key]['remarks'] = empty($value['remarks'])?'NULL':$value['remarks'];

  $details = strip_tags(htmlspecialchars_decode($value['details']));
           //剥去字符串中的 HTML 标签  //把预定义的 HTML 实体 "<"（小于）和 ">"（大于）转换为字符
           
     // if(mb_strlen($content,'utf-8')){
      $arr[$key]['details'] = mb_substr($details, 0,50,'utf-8');
     // }
     

  }
// var_dump($arr[$key]['details']);
    $sql_count = "select count('id') as count from goods where 1";

    $count = sql_one($mysqli,$sql_count);

  include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';


}else if($_A=='add'){

  if($_POST){
    

    $data = $_POST;
  
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

    $data['create_time'] = date("Y-m-d H:i:s",time());

    $data['update_time'] = date("Y-m-d H:i:s",time());

    if($data['pro_name'] =='' or $data['category_id'] ==''){
          
        script_error('带*号的内容不能为空');
      }

     $keys = '';
     $values = '';

     foreach ($data as $key => $value){

       $keys .= $key.',';
       $values .= "'".$value."',";

     }

     $keys = rtrim($keys,',');
     $values = rtrim($values,',');
     
     $sql = "insert into goods($keys) values($values)";
     // var_dump($sql);die;

     $result = sql_insert($mysqli,$sql);
     // var_dump($result);die;
     if($result){
          script_success('添加成功','index.php?mot=admin&ctl=goods&act=index');
     }else{
          script_error('添加失败');
     }

  }else{

    $array = category_tree(63,0,'&nbsp;|-','category','*',array(),'cate_name','id');
    // var_dump($array);die;

    include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

   }


}else if($_A=='edit'){


  if($_POST){

   $id = $_POST['id'];

   $data = $_POST;

   // $data['details'] = htmlspecialchars($_POST['details']);
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

    $data['create_time'] = date("Y-m-d H:i:s",time());

    $data['update_time'] = date("Y-m-d H:i:s",time());

    if($data['pro_name'] =='' or $data['category_id'] ==''){
          
        script_error('带*号的内容不能为空');
      }

     $keys = '';

     foreach ($data as $key => $value){

       $keys .= $key."='".$value."',";

     }

     $keys = rtrim($keys,',');
     
     $sql = "update goods set $keys where id={$id}";
     // var_dump($sql);die;

     $result = sql_edit($mysqli,$sql);
     // var_dump($result);die;
     if($result){
          script_success('修改成功','index.php?mot=admin&ctl=goods&act=index');
     }else{
          script_error('修改失败');
     }

  }else{

     $id = $_GET['id'];


     $sql = "select * from goods where id={$id}";

     $result = sql_one($mysqli,$sql);

    $array = category_tree(63,0,'&nbsp;|-','category','*',array(),'cate_name','id');
    // var_dump($array);die;

    include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

   }


}else if($_A=='del'){

  $id = $_GET['id'];

  $sql = "delete from goods where id={$id}";
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