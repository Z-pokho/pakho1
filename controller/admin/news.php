<?php
if(empty($_SESSION['username'])){
	echo "<script>alert('非法登录，请到登录页');window.location.href='index.php?mot=admin&ctl=login';</script>";
}
//新闻列表 
if($_A=='index'){

      $sql = "select * from news where 1";

    $arr = sql_list($mysqli,$sql);
    // var_dump($arr);die;
    
    foreach ($arr as $key =>  $value) {

     $arr[$key]['display'] = $value['display']==1?'显示':'隐藏';

     $arr[$key]['remarks'] = empty($value['remarks'])?'NULL':$value['remarks'];

     $sql = "select cate_name from category where id = {$value['category_id']} ";
     // var_dump($sql);
     $name = sql_one($mysqli,$sql);
     /*var_dump($name);die;*/

     $arr[$key]['category_id'] = $name['cate_name'];

     $content = strip_tags(htmlspecialchars_decode($value['content']));
           //剥去字符串中的 HTML 标签  //把预定义的 HTML 实体 "<"（小于）和 ">"（大于）转换为字符
           
     // if(mb_strlen($content,'utf-8')){
      $arr[$key]['content'] = mb_substr($content, 0,50,'utf-8');
     // }

    }

    $sql_count = "select count('id') as count from news where 1";
    $count = sql_one($mysqli,$sql_count);
         

  include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';



//新闻添加
}else if($_A=='add'){

   if($_POST){

/*echo_print($_FILES);*/
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
     
    $data['title'] = $_POST['title'];

    $data['category_id'] = $_POST['category_id'];

    $data['author'] = $_POST['author'];
  
    $data['content'] = htmlspecialchars($_POST['content']);
                    //把预定义的字符 "<" （小于）和 ">" （大于）转换为 HTML 实体
    $data['create_time'] = date("Y-m-d H:i:s",time());

    $data['update_time']  = date("Y-m-d H:i:s",time());

    $data['display'] = $_POST['display'];

    $data['remarks']      =$_POST['remarks'];


     if($data['title'] =='' or $data['content'] ==''){
          
        script_error('带*号的内容不能为空');
      }

    $keys = '';
    $values = '';

    foreach ($data as $key => $value){

    $keys .= $key.',';
    $values .="'".$value."',";

    }

    $keys = rtrim($keys,',');

    $values = rtrim($values,',');
    
    //插入
    $sql = "insert into news($keys) values($values)";
    /*var_dump($sql);die;*/

    $result = sql_insert($mysqli,$sql);

    if($result){

      script_success('添加成功','index.php?mot=admin&ctl=news&act=index');
    }else{

      script_error('添加失败');
    }

    

  }else{


      $array = category_tree(62,0,'&nbsp;|-','category','*',array(),'cate_name','id');
      

      include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

   }


}

//删除页面
else if($_A=='del'){

    $id = $_GET['id'];

    $sql ="delete from news where id={$id}";
    /*var_dump($sql);die;*/

    $result = sql_del($mysqli,$sql);

     if($result){

    echo json_encode(1);
    die;
   }else{
    echo json_encode(0);
    die;
   }

}

//修改页面
else if($_A=='edit'){

    if ($_POST){

      /*echo_print($_FILES);*/
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


     $id = $_POST['id'];
     /* var_dump($id);die;*/

     /**存在数据库数据*/
    $data['title']       = $_POST['title'];

    $data['author']      = $_POST['author'];

    $data['category_id'] = $_POST['category_id'];

    $data['content'] = htmlspecialchars($_POST['content']);
                    //把预定义的字符 "<" （小于）和 ">" （大于）转换为 HTML 实体

    $data['create_time'] = date("Y-m-d H:i:s",time());

    $data['update_time']  = date("Y-m-d H:i:s",time());

    $data['display'] = $_POST['display'];

    $data['remarks']      =$_POST['remarks'];


    if($data['title'] =='' or $data['content'] ==''){
          
        script_error('带*号的内容不能为空');
      }

    $keys ='';

    foreach ($data as $key => $value){

      $keys .=$key."='".$value."',";

    }

      $keys = rtrim($keys,',');  

      $sql = "update news set $keys where id={$id}";
      // var_dump($sql);die;

      $result = sql_edit($mysqli,$sql);
      // var_dump($result);die;

      if($result){
        script_success('修改成功','index.php?mot=admin&ctl=news&act=index');
      }else{
        script_error('修改失败');
      }
      
    }else{

    //查询跳转过来当前ID数据
     $id = $_GET['id'];
    /* var_dump($id);die;*/

     $sql = "select * from news where id={$id}";
     // var_dump($sql);

     $result = sql_one($mysqli,$sql);
     // var_dump($result)

     $result['content'] = htmlspecialchars_decode($result['content']);

     


     $array = category_tree(62,0,'&nbsp;|-','category','*',array(),'cate_name','id');


     include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

    }

}
