<?php


//用户管理
if($_A=='index'){
     
         //查询数据库
       $sql= "select * from admin where 1";
       $arr = sql_list($mysqli,$sql);
       // var_dump($arr);

       foreach ($arr as $key => $value) {
       
       $arr[$key]['remarks_user'] = empty($value['remarks_user'])?'NULL':$value['remarks_user'];

       $sql = "select role_name from level where id = {$value['level_arr']}";
      
       $data = sql_one($mysqli,$sql);
       // var_dump($name['role_name']);
       $arr[$key]['level_arr'] =$data['role_name'];

       // $arr[$key]['level_arr'] = $name['role_name'];

       }
       // var_dump($name);
       // var_dump($arr[$key]['level_arr']);

	    $sql_count = "select count('id') as count from admin where 1";

        $count = sql_one($mysqli,$sql_count);

	include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

}

 //添加页面
else if($_A=='add'){

    if($_POST){

     /*var_dump($_POST);die;*/

     if($_POST['username'] == ''){
          
        script_error('用户名不能为空');
        die;
      }

     $data['username'] = trim($_POST['username']);

         $sql_select = "select username from admin where username='{$data['username']}'";//判断是否存在这个名字

         $name = sql_one($mysqli,$sql_select);
         

         if($name){
          script_error('用户名已存在，另外起一个呗');
          die;
         }

          if(empty($_POST['repassword'])){
          
        script_error('密码不能为空');
        die;
      }
       
        if(empty($_POST['level_arr'])){

         script_error('网站角色不能为空');
      die;
     }
     if($_POST['password'] != MD5($_POST['repassword'])){
      script_error('密码不一致');
      die;
     }

      $sql = "select username from admin where username='".$data['username']."'";
    /* var_dump($sql);die;*/
     $name = sql_one($mysqli,$sql);
     /*var_dump($name);die;*/

     if($name){
         script_error('用户名已存在，请另起名');
         die;
     }

     $data['password'] = MD5(trim($_POST['password']));
      // var_dump($data['password']);die;
     $repassword       = trim($_POST['repassword']);

     $data['role_name'] = trim($_POST['role_name']);

     $data['remarks_user']  = $_POST['remarks'];
     
     $data['time']     = date("Y-m-d H:i:s",time());

      $data['level_arr'] = $_POST['level_arr'];

     
         $keys = '';
         $values = '';

         foreach ($data as $key => $value){

           $keys .= $key.',';
           $values .= "'".$value."',";

         }

         $keys = rtrim($keys,',');
         $values = rtrim($values,',');
         
         $sql = "insert into admin($keys) values($values)";
         /*var_dump($sql);die;*/

         $result = sql_insert($mysqli,$sql);

         if($result){
         	    script_success('添加成功','index.php?mot=admin&ctl=user&act=index');
         }else{
         	    script_error('添加失败');
         }
     
       // }
    }else{

       $sql ="select * from level where 1";

        $result = sql_list($mysqli,$sql);

       /* var_dump($result);die;*/

      include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

  }
    
}

//删除页面
else if($_A=='del'){

   $id = $_GET['id'];
   /*var_dump($id);die;*/
   if($id==1){

    echo json_encode(2);
    die;
   }

   $sql = "delete from admin where id={$id}";

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

  if($_POST){
    // echo 123;die;
     $id = $_POST['id'];

     if($_POST['username'] == ''){
          
        script_error('用户名不能为空');
        die;
      }

     $data['username']      = trim($_POST['username']);

         $sql_select = "select username from admin where username='{$data['username']}' and id != {$id}";//判断是否存在这个名字

         $name = sql_one($mysqli,$sql_select);
         

         if($name){
          script_error('用户名已存在，另外起一个呗');
         }

         if($_POST['password']==''){

          script_error('初始密码不能为空');
         }


     $data['password']      = MD5(trim($_POST['newpassword']));

     $repassword            = trim($_POST['repassword']);

     $pass                  = MD5($_POST['password']);
     // var_dump($pass);
     $data['remarks_user']  = $_POST['remarks'];

     $data['time']          = date("Y-m-d H:i:s",time());

     if($data['username'] == '' and $data['password'] == ''){
          
        script_error('带*号的内容不能为空');
      }
     
     if(empty($_POST['level_arr'])){

         script_error('网站角色不能为空');

     }else{

     $data['level_arr'] = ($_POST['level_arr']);

      //用户和密码判断
      $sql = "select * from admin where id ={$id} and password='{$pass}'";

      // var_dump($sql);

      $user = sql_one($mysqli,$sql);
      // var_dump($user);die;


      // if(!$user){
      //   script_error('初始密码错误');

      // }

      // if(empty($data['password'])){
          
      //   script_error('请输入新密码');
      // }

      if(empty($repassword)){
          
        script_error('新密码/确认密码错误');
      }

      if($data['password'] !=MD5($repassword)){

        script_error('密码不一致');
      }



         $keys = '';

         foreach ($data as $key => $value){

             $keys .=$key."='".$value."',";

            }

         $keys = rtrim($keys,',');
         /*var_dump($keys);*/

         $sql = "update admin set $keys where id={$id}";
        /* var_dump($sql);*/

         $result = sql_edit($mysqli,$sql);
         /*var_dump($result);die;*/

         if($result){
                script_success('修改成功','index.php?mot=admin&ctl=user&act=index');
         }else{
                script_error('修改失败');
         
        }

    }

  }else{

     $id = $_GET['id'];

     $sql = "select * from admin where id={$id}";

     $result = sql_one($mysqli,$sql);
     // var_dump($result);die;

     
     //遍历角色
      $sql ="select * from level where 1";

        $results = sql_list($mysqli,$sql);

       /* var_dump($result);die;*/

        foreach($results as $key =>$value){

            $sql2 = "select * from level where category_id={$value['id']}";

            $r = sql_list($mysqli,$sql2);

            $results[$key]['children'] = $r;

}

    include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

  }


}

?>