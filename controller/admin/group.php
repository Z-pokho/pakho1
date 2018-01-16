<?php

//权限组管理
if($_A=='index'){
   
   //查询数据库
   $sql= "select * from level where 1";
// var_dump($sql);
   $arr = sql_list($mysqli,$sql);
// var_dump($arr);

   foreach ($arr as $key => $value) {

    $arr[$key]['remarks'] = empty($value['remarks'])?'NULL':$value['remarks'];

     $l_arr = json_decode($value['level_arr']);

     $array=[];

     foreach($l_arr as $keys => $values){
        // var_dump($values);
       $sql = "select menu_name from menu where id={$values}";
       // var_dump($sql);
       $menu_name = sql_one($mysqli,$sql);

       $array[$keys] = $menu_name['menu_name'];
       // $l_arr[$keys] = $values;
     }
    
      $array = implode('&nbsp;|&nbsp;',$array);
     
      $arr[$key]['level_arr'] = $array;
  }
  // var_dump($arr);die;
    $sql_count = "select count('id') as count from level where 1";

    $count = sql_one($mysqli,$sql_count);

  
   include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

//添加页面
}else if($_A=='add'){

  if($_POST){
       

       $data['role_name'] = $_POST['role_name'];

         if($data['role_name'] == ''){
          
        script_error('角色名不能为空');
        die;
      }else{

       $sql_select = "select role_name from level where role_name='{$data['role_name']}'";//判断是否存在这个名字

         $name = sql_one($mysqli,$sql_select);
         
         if($name){
          script_error('角色名已存在，另外起一个呗');
         }

       $data['remarks'] = $_POST['remarks'];

        if(empty($_POST['level_arr'])){

        script_error('请选择权限');
        die;
       }

       $data['level_arr'] = $_POST['level_arr'];
       // var_dump($data['level_arr']);die;
       $data['level_arr'] = json_encode($data['level_arr']);

       $keys = '';

       $values = null;

       foreach ($data as $key => $value){

         $keys   .= $key.',';

         $values .= "'".$value."',";

       }

       $keys   = rtrim($keys,',');

       $values = rtrim($values,',');

       $sql = "insert into level ($keys) values($values)";
       // echo $sql;
       $result = sql_insert($mysqli,$sql);
       // var_dump($result);die;
        if($result){

            script_success('添加成功','index.php?mot=admin&ctl=group&act=index');
        }else{

            script_error('添加失败');
        }
      }
    }else{

        $sql ="select * from menu where category_id=0 and distinction=1";
         // var_dump($sql);
        $result = sql_list($mysqli,$sql);

        // var_dump($result);die;

        foreach($result as $key =>$value){

            $sql2 = "select * from menu where category_id={$value['id']} and distinction=1";

            $r = sql_list($mysqli,$sql2);

            $result[$key]['children'] = $r;

            // var_dump($result[$key]['children']);die;
      }


      include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

  }
    

    
//删除页面
}else if($_A=='del'){

 $id = $_GET['id'];
   /*var_dump($id);die;*/
   if($id==1){

    echo json_encode(2);
    die;
   }

   $sql = "delete from level where id={$id}";

   $result = sql_del($mysqli,$sql);

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
 /*  var_dump($id);die;*/

    $data['role_name'] = $_POST['role_name'];

     if($data['role_name'] == ''){
          
        script_error('角色名不能为空');
        die;
      }else{

    $sql_select = "select role_name from level where role_name='{$data['role_name']}' and id != {$id}";//判断是否存在这个名字
    // var_dump($sql_select);die;

         $name = sql_one($mysqli,$sql_select);
        // var_dump($name);die;

         if($name){
          script_error('角色名已存在，另外起一个呗');
         }

  if(empty($_POST['level_arr'])){

        script_error('请选择权限');
        die;
       }else{

   $data['level_arr'] = json_encode($_POST['level_arr']);

   $data['remarks'] = $_POST['remarks'];

   $keys = '';

   foreach ($data as $key => $value){

    $keys .=$key."='".$value."',";

   /* $keys[] .= "`{$keys}`='{$value}'";*/
    /*var_dump($keys);die;*/
   }

   $keys = rtrim($keys,',');
   

   $sql = "update level set $keys where id={$id}";

  /* var_dump($sql);die;*/

   $result = sql_edit($mysqli,$sql);
   /*var_dump($result);;die;*/

     if($result){

      script_success('修改成功','index.php?mot=admin&ctl=group&=act=index');

     }else{

      script_error('修改失败');

     }

  }

}

  }else{

    //查询跳转过来当前ID数据
     $id = $_GET['id'];


     $sql = "select * from level where id={$id}";

     $result = sql_one($mysqli,$sql);
    // var_dump($result);die;
     //遍历
      $sql2 ="select * from menu where category_id=0 and distinction=1";

        $result2 = sql_list($mysqli,$sql2);

       /* var_dump($result);die;*/

        foreach($result2 as $key =>$value){

            $sql3 = "select * from menu where category_id={$value['id']} and distinction=1";

            $r = sql_list($mysqli,$sql3);

            $result2[$key]['children'] = $r;

       }

   include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

 }

}

?>