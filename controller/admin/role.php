<?php

//角色管理
if($_A=='index'){
   
    //查询数据库
    $sql= "select * from role where 1";

    $arr = sql_list($mysqli,$sql);

    foreach ($arr as $key =>  $value) {


     $arr[$key]['remarks'] = empty($value['remarks'])?'NULL':$value['remarks'];

    }

    
    $sql_count = "select count('id') as count from role where 1";

    $count = sql_one($mysqli,$sql_count);

  
   include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

//添加页面
}else if($_A=='add'){

  if($_POST){

      $data['role_name'] = $_POST['role_name'];

     $sql_select = "select role_name from role where role_name='{$data['role_name']}'";//判断是否存在这个名字

     $name = sql_one($mysqli,$sql_select);
     

     if($name){
      script_error('角色名已存在，另外起一个呗');
     }

      $data['role_remarks'] = $_POST['role_remarks'];


      if($data['role_name'] == ''){
          
      script_error('带*号的内容不能为空');
      }

      $keys = '';

      $values = '';

      foreach ($data as $key => $value){

      $keys   .= $key.',';

      $values .= "'".$value."',";

      }

      $keys    = rtrim($keys,',');

      $values  = rtrim($values,',');

      $sql = "insert into role ($keys) values ($values)";
      /*var_dump($sql);*/
      $result = sql_insert($mysqli,$sql);
      /*var_dump($result);die;*/


      if($result){

        script_success('添加成功','index.php?mot=admin&ctl=role&act=index');

      }else{
        script_error('添加失败啊');

      }


  }else{


  include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

  }


//删除页面
}else if($_A=='del'){

   $id = $_GET['id'];
   /*var_dump($id);die;*/

   $sql = "delete from role where id={$id}";
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

    $data['role_name'] = $_POST['role_name'];

    $sql_select = "select role_name from role where role_name='{$data['role_name']}' and id != {$id}";//判断是否存在这个名字
    // var_dump($sql_select);die;

         $name = sql_one($mysqli,$sql_select);
        // var_dump($name);die;

         if($name){
          script_error('角色名已存在，另外起一个呗');
         }

    $data['role_remarks'] = $_POST['role_remarks'];

   
    if($data['role_name'] == ''){
          
      script_error('带*号的内容不能为空');
      }

    $keys = '';

    foreach ($data as $key => $value) {
      
      $keys .=$key."='".$value."',";

    }/*var_dump($keys);die;*/

    $keys = rtrim($keys,',');
    /*var_dump($keys);die;*/

    $sql = "update role set {$keys} where id={$id}";
   /* var_dump($sql);*/
    $result = sql_edit($mysqli,$sql);
    // var_dump($result);die;
    if($result){

      script_success('修改成功','index.php?mot=admin&ctl=role&act=index');

    }else{

      script_error('修改失败');
    }

   }else{

    //查询跳转过来当前ID数据
    $id = $_GET['id'];

    $sql = "select * from role where id={$id}";
    // var_dump($sql);die;

    $result = sql_one($mysqli,$sql);
    // var_dump($result);die;

     include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

   }

}

?>