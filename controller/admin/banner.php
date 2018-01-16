<?php
//banner图管理

if($_A=='index'){

    $sql = "select * from banner where 1";

    $arr = sql_list($mysqli,$sql);

    foreach ($arr as $key => $value) {

   $sql = "select * from menu where id={$value['category_id']}";
   // var_dump($sql);
   $data = sql_one($mysqli,$sql);

   // var_dump($data);die;
     
    $arr[$key]['category_id'] = $data['menu_name'];


     $arr[$key]['display'] = $value['display']==1?'显示':'隐藏';

     $arr[$key]['remarks'] = empty($value['remarks'])?'NULL':$value['remarks'];

   }

    $sql_count = "select count('id') as count from banner where 1";

    $count = sql_one($mysqli,$sql_count);

	include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';


}else if($_A=='add'){

	if($_POST){
    
    // var_dump($_POST);die;
    


     if(!is_numeric($_POST['place'])){

    		script_error('位置必须是数字');
    	}

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

     if($data['category_id'] == '' or $data['image_name'] == ''){
          
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
     
     $sql = "insert into banner($keys) values($values)";
     // var_dump($sql);die;

     $result = sql_insert($mysqli,$sql);
     // var_dump($result);die;
     if($result){
     	    script_success('添加成功','index.php?mot=admin&ctl=banner&act=index');
     }else{
     	    script_error('添加失败');
     }

  }else{

   $array = category_tree(0,0,'&nbsp;|-','menu','*',array(),'menu_name','id','distinction=2');
    // var_dump($result);die;

    include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

   }

}else if($_A=='edit'){

     if($_POST){
    
    // var_dump($_POST);die;
    
     $id = $_POST['id'];

      

     if(!is_numeric($_POST['place'])){

    		script_error('位置必须是数字');
    	}

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

     if($data['category_id'] == '' or $data['image_name'] == ''){
          
        script_error('带*号的内容不能为空');
      }

     $keys = '';

     foreach ($data as $key => $value){

       $keys .= $key."='".$value."',";
  

     }

     $keys = rtrim($keys,',');
   
     $sql = "update banner set $keys where id={$id}";
     // var_dump($sql);die;

     $result = sql_edit($mysqli,$sql);
     // var_dump($result);die;
     if($result){
     	    script_success('修改成功','index.php?mot=admin&ctl=banner&act=index');
     }else{
     	    script_error('修改失败');
     }

  }else{

    $id = $_GET['id'];
    // var_dump($id);die;

    $sql = "select * from banner where id={$id}";
        // var_dump($sql);

    $result = sql_one($mysqli,$sql);

   $array = category_tree(0,0,'&nbsp;|-','menu','*',array(),'menu_name','id','distinction=2');
    // var_dump($result);die;

    include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

   }


}else if($_A=='del'){

   $id = $_GET['id'];

   $sql = "delete from banner where id={$id}";

   $result = sql_del($mysqli,$sql);

    if($result){

    echo json_encode(1);
    die;
   }else{
    echo json_encode(0);
    die;
   }


}

?>