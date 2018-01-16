<?php

if($_A=='index'){

    $sql = "select * from company where 1";

    $arr = sql_list($mysqli,$sql);

    foreach ($arr as $key => $value) {

   $sql = "select * from category where id={$value['category_id']}";
   // var_dump($sql);
   $data = sql_one($mysqli,$sql);

   // var_dump($data);die;
     
    $arr[$key]['category_id'] = $data['cate_name'];


    $arr[$key]['display'] = $value['display']==1?'显示':'隐藏';

    $arr[$key]['remarks'] = empty($value['remarks'])?'NULL':$value['remarks'];

    $details = strip_tags(htmlspecialchars_decode($value['details']));
           //剥去字符串中的 HTML 标签  //把预定义的 HTML 实体 "<"（小于）和 ">"（大于）转换为字符
           
     // if(mb_strlen($content,'utf-8')){
      $arr[$key]['details'] = mb_substr($details, 0,50,'utf-8');

   }

  $sql_count = "select count('id') as count from company where 1";

  $count = sql_one($mysqli,$sql_count);

	include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';


}else if($_A=='add'){

	 if($_POST){

     $data = $_POST;
     // var_dump($data['details']);

     // $data['details'] = htmlspecialchars($_POST['details']);
     // var_dump($data['details']);die;
     $array = ['image/jpeg','image/png','image/gif']; 

   if($_FILES['image1']['name']){ //判断是否存在文件名

    if(in_array($_FILES['image1']['type'],$array)){ //判断是否为图片文件

     if($_FILES['image1']['size']<2097152){//判断大小范图
     // echo_print($_FILES['image']['name']);

     $ext = strripos($_FILES['image1']['name'],'.');

     $exts = substr($_FILES['image1']['name'],$ext);
     // var_dump($exts);die;
     
     $upload = 'upload/';

     if(!file_exists($upload)){

      mkdir($upload,0777); //生成目录 0777最高权限 可读 可写

     }

     $files = $upload.rand(10000,99999).date('Ymd',time()).$exts;

     $image = move_uploaded_file($_FILES['image1']['tmp_name'],$files);

     $data['image1']   = $files;
     // var_dump($image);die;
     }

  }

}

     $array = ['image/jpeg','image/png','image/gif']; 

   if($_FILES['image2']['name']){ //判断是否存在文件名

    if(in_array($_FILES['image2']['type'],$array)){ //判断是否为图片文件

     if($_FILES['image2']['size']<2097152){//判断大小范图
     // echo_print($_FILES['image']['name']);

     $ext = strripos($_FILES['image2']['name'],'.');

     $exts = substr($_FILES['image2']['name'],$ext);
     // var_dump($exts);die;
     
     $upload = 'upload/';

     if(!file_exists($upload)){

      mkdir($upload,0777); //生成目录 0777最高权限 可读 可写

     }

     $files = $upload.rand(10000,99999).date('Ymd',time()).$exts;

     $image = move_uploaded_file($_FILES['image2']['tmp_name'],$files);

     $data['image2']   = $files;
     // var_dump($image);die;
     }

  }

}

     $array = ['image/jpeg','image/png','image/gif']; 

   if($_FILES['image3']['name']){ //判断是否存在文件名

    if(in_array($_FILES['image3']['type'],$array)){ //判断是否为图片文件

     if($_FILES['image3']['size']<2097152){//判断大小范图
     // echo_print($_FILES['image']['name']);

     $ext = strripos($_FILES['image3']['name'],'.');

     $exts = substr($_FILES['image3']['name'],$ext);
     // var_dump($exts);die;
     
     $upload = 'upload/';

     if(!file_exists($upload)){

      mkdir($upload,0777); //生成目录 0777最高权限 可读 可写

     }

     $files = $upload.rand(10000,99999).date('Ymd',time()).$exts;

     $image = move_uploaded_file($_FILES['image3']['tmp_name'],$files);

     $data['image3']   = $files;
     // var_dump($image);die;
     }

  }

}


     $array = ['image/jpeg','image/png','image/gif']; 

   if($_FILES['image4']['name']){ //判断是否存在文件名

    if(in_array($_FILES['image4']['type'],$array)){ //判断是否为图片文件

     if($_FILES['image4']['size']<2097152){//判断大小范图
     // echo_print($_FILES['image']['name']);

     $ext = strripos($_FILES['image4']['name'],'.');

     $exts = substr($_FILES['image4']['name'],$ext);
     // var_dump($exts);die;
     
     $upload = 'upload/';

     if(!file_exists($upload)){

      mkdir($upload,0777); //生成目录 0777最高权限 可读 可写

     }

     $files = $upload.rand(10000,99999).date('Ymd',time()).$exts;

     $image = move_uploaded_file($_FILES['image4']['tmp_name'],$files);

     $data['image4']   = $files;
     // var_dump($image);die;
     }

  }

}

 
      if($data['category_id'] == '' or $data['details'] == ''){
          
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
     
     $sql = "insert into company($keys) values($values)";
     // var_dump($sql);die;

     $result = sql_insert($mysqli,$sql);
     // var_dump($result);die;
     if($result){
          script_success('添加成功','index.php?mot=admin&ctl=company&act=index');
     }else{
          script_error('添加失败');
     }

	}else{

   $array = category_tree(61,0,'&nbsp;|-','category','*',array(),'cate_name','id');

    include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
	}


}else if($_A=='edit'){


   if($_POST){

  $id = $_POST['id'];

   $data = $_POST;

     $array = ['image/jpeg','image/png','image/gif']; 

   if($_FILES['image1']['name']){ //判断是否存在文件名

    if(in_array($_FILES['image1']['type'],$array)){ //判断是否为图片文件

     if($_FILES['image1']['size']<2097152){//判断大小范图
     // echo_print($_FILES['image']['name']);

     $ext = strripos($_FILES['image1']['name'],'.');

     $exts = substr($_FILES['image1']['name'],$ext);
     // var_dump($exts);die;
     
     $upload = 'upload/';

     if(!file_exists($upload)){

      mkdir($upload,0777); //生成目录 0777最高权限 可读 可写

     }

     $files = $upload.rand(10000,99999).date('Ymd',time()).$exts;

     $image = move_uploaded_file($_FILES['image1']['tmp_name'],$files);

     $data['image1']   = $files;
     // var_dump($image);die;
     }

  }

}

     $array = ['image/jpeg','image/png','image/gif']; 

   if($_FILES['image2']['name']){ //判断是否存在文件名

    if(in_array($_FILES['image2']['type'],$array)){ //判断是否为图片文件

     if($_FILES['image2']['size']<2097152){//判断大小范图
     // echo_print($_FILES['image']['name']);

     $ext = strripos($_FILES['image2']['name'],'.');

     $exts = substr($_FILES['image2']['name'],$ext);
     // var_dump($exts);die;
     
     $upload = 'upload/';

     if(!file_exists($upload)){

      mkdir($upload,0777); //生成目录 0777最高权限 可读 可写

     }

     $files = $upload.rand(10000,99999).date('Ymd',time()).$exts;

     $image = move_uploaded_file($_FILES['image2']['tmp_name'],$files);

     $data['image2']   = $files;
     // var_dump($image);die;
     }

  }

}

     $array = ['image/jpeg','image/png','image/gif']; 

   if($_FILES['image3']['name']){ //判断是否存在文件名

    if(in_array($_FILES['image3']['type'],$array)){ //判断是否为图片文件

     if($_FILES['image3']['size']<2097152){//判断大小范图
     // echo_print($_FILES['image']['name']);

     $ext = strripos($_FILES['image3']['name'],'.');

     $exts = substr($_FILES['image3']['name'],$ext);
     // var_dump($exts);die;
     
     $upload = 'upload/';

     if(!file_exists($upload)){

      mkdir($upload,0777); //生成目录 0777最高权限 可读 可写

     }

     $files = $upload.rand(10000,99999).date('Ymd',time()).$exts;

     $image = move_uploaded_file($_FILES['image3']['tmp_name'],$files);

     $data['image3']   = $files;
     // var_dump($image);die;
     }

  }

}


     $array = ['image/jpeg','image/png','image/gif']; 

   if($_FILES['image4']['name']){ //判断是否存在文件名

    if(in_array($_FILES['image4']['type'],$array)){ //判断是否为图片文件

     if($_FILES['image4']['size']<2097152){//判断大小范图
     // echo_print($_FILES['image']['name']);

     $ext = strripos($_FILES['image4']['name'],'.');

     $exts = substr($_FILES['image4']['name'],$ext);
     // var_dump($exts);die;
     
     $upload = 'upload/';

     if(!file_exists($upload)){

      mkdir($upload,0777); //生成目录 0777最高权限 可读 可写

     }

     $files = $upload.rand(10000,99999).date('Ymd',time()).$exts;

     $image = move_uploaded_file($_FILES['image4']['tmp_name'],$files);

     $data['image4']   = $files;
     // var_dump($image);die;
     }

  }

}


     if($data['category_id'] == '' or $data['details'] == ''){
          
        script_error('带*号的内容不能为空');
      }

     $keys = '';

     foreach ($data as $key => $value){

       $keys .= $key."='".$value."',";

     }

     $keys = rtrim($keys,',');
     
     $sql = "update company set $keys where id={$id}";
     // var_dump($sql);die;

     $result = sql_edit($mysqli,$sql);
     // var_dump($result);die;
     if($result){
          script_success('修改成功','index.php?mot=admin&ctl=company&act=index');
     }else{
          script_error('修改失败');
     }

  }else{

   $id = $_GET['id'];

   $sql = "select * from company where id={$id}";

   $result = sql_one($mysqli,$sql);

   $array = category_tree(61,0,'&nbsp;|-','category','*',array(),'cate_name','id');

    include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
  }


}else if($_A=='del'){

  $id = $_GET['id'];

  $sql = "delete from company where id={$id}";
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