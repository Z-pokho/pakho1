<?php

//系统管理
if($_A=='admin'){
  
    $arr = category_tree(0,0,'&nbsp;|-','menu','*',array(),'menu_name','id','distinction=1');

    foreach ($arr as $key =>  $value) {
      
     $sql = "select * from menu where distinction=1 and id={$value['category_id']}";
     
     $data = sql_one($mysqli,$sql);
     // var_dump($data);

     $arr[$key]['category_id'] = $value['category_id']==0?'顶级分类':$data['menu_name'];

     $arr[$key]['distinction'] = $value['distinction']==1?'后台':'前台';

     $arr[$key]['display'] = $value['display']==1?'显示':'隐藏';

     $arr[$key]['controller'] = empty($value['controller'])?'NULL':$value['controller'];

     $arr[$key]['action'] = empty($value['action'])?'NULL':$value['action'];

    }


    $sql_count = "select count('id') as count from menu where distinction=1";
    $count = sql_one($mysqli,$sql_count);
         

  include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
}

//添加页面
else if($_A=='add'){

     if($_POST){
         //判断菜单名是否存在
         $data['menu_name']  = $_POST['menu_name'];

         $sql_select = "select menu_name from menu where menu_name='{$data['menu_name']}'";//判断是否存在这个名字

         $name = sql_one($mysqli,$sql_select);
         

         if($name){
          script_error('菜单名已存在，另外起一个呗');
         }
        //位置
         $pl  = intval($_POST['place']);

         $sql_select2 = "select place from menu where place=$pl";//判断位置是否存在
         
         $place = sql_one($mysqli,$sql_select2);
         

         if($place){
           script_error('位置已被占用，另外找一个呗');

         }

         if(!empty($_POST['controller'])){

          $data['controller']  = $_POST['controller'];
         }

        if(!empty($_POST['action'])){

          $data['action']      = $_POST['action'];
         }

         //存在数据库数据
         $data['category_id'] = $_POST['category_id'];

         $data['display']     = $_POST['display'];

         $data['place']       = $_POST['place'];

         $data['distinction'] = $_POST['distinction'];

         $data['icon'] = $_POST['icon'];

         $data['remarks'] = $_POST['remarks'];


        if($data['menu_name'] == '' or $data['category_id'] == '' or $data['place'] == null){
          
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
         
         $sql = "insert into menu($keys) values($values)";

         $result = sql_insert($mysqli,$sql);
         
         if($result){
           if($data['distinction']==1){
         	    script_success('添加成功','index.php?mot=admin&ctl=systems&act=admin');
           }else{
              script_success('添加成功','index.php?mot=admin&ctl=systems&act=home');
           }
         }else{
         	    script_error('添加失败');
         }

       }else{

         $sql = "select * from menu where category_id=0";

         $result = sql_list($mysqli,$sql);



         $arr = array();

         foreach ($result as $key => $value){

         $value['menu_name'] = '&nbsp;--'.$value['menu_name'];

         $arr[] = $value;

         $sql2  = "select * from menu where category_id={$value['id']}";

         $result2 = sql_list($mysqli, $sql2);

         foreach ($result2 as $k=> $v){

          $v['menu_name'] = '&nbsp;&nbsp;&nbsp;<b>-|</b>'.$v['menu_name'];
          
          $arr[] = $v;

         }
     }

        include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
   }



//删除页面
}else if($_A=='del'){

     $id = $_GET['id'];

     $sql = "delete from menu where id={$id}";
    
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
else if($_A=='edit')
{
     if($_POST){
      // echo_print($_POST);die;
          //判断菜单名是否存在
      $id = $_POST['id'];

     /* $id = !empty($_REQUEST['id'])?intval($_REQUEST['id']):9;*/
     /* var_dump($id);die;*/

      $data['menu_name']   = $_POST['menu_name'];

      $sql_select = "select menu_name from menu where id != {$id} and menu_name='{$data['menu_name']}'";//判断是否存在这个名字
      // echo $sql_select;die;
      $name  =  sql_one($mysqli,$sql_select);
    
      if($name){
         script_error('菜单名已存在，赶紧另外起一个');
      }
      /*位置**/
      $pl = empty($_POST['place']) ? script_error('排序不能为空，赶紧起一个') : intval($_POST['place']);

      $sql_select2 = "select place from menu where id != {$id} and place=$pl";//判断位置是否存在

      $place  =  sql_list($mysqli,$sql_select2);
      if($place){
         script_error('位置已被占用，赶紧去找一个');
      }

      /**存在数据库数据*/
     
      $data['category_id'] = $_POST['category_id'];

      $data['display']     = $_POST['display'];

      $data['place']       = $_POST['place'];

      $data['controller']  = $_POST['controller'];
      
      $data['action']      = $_POST['action'];

      $data['distinction'] = $_POST['distinction']; 

      empty($_POST['icon'])?'':$data['icon'] = $_POST['icon']; 

       if($data['menu_name'] == '' or $data['category_id'] == '' or $data['place'] == null){
          
        script_error('带*号的内容不能为空');
      }
      
      $keys   = '';
     
      foreach ($data as $key => $value) {
        $keys   .= $key."='".$value."',";
      
      }
     
      $keys   = rtrim($keys,',');
   
     
      $sql = "update menu set $keys where id={$id}";

      $result = sql_edit($mysqli,$sql);//添加


     if($result){
           if($data['distinction']==1){
              script_success('修改成功','index.php?mot=admin&ctl=systems&act=admin');
           }else{
              script_success('修改成功','index.php?mot=admin&ctl=systems&act=home');
           }
         }else{
              script_error('修改失败');
         }

     }else{
         // echo_print($_GET);
         // die;
      //查询跳转过来当前ID数据
        $id     = $_GET['id'];
       /* var_dump($id);die;*/

        $sql    = "select * from menu where id={$id}";

        $result = sql_one($mysqli,$sql);
         // var_dump($result);die;
        
        //下拉上一级菜单
        $sql = "select * from menu where category_id=0"; //查询分类ID等于O

        $results = sql_list($mysqli,$sql); 

        $arr = array();

        foreach ($results as $key => $value) {

          $value['menu_name'] = '&nbsp;--'.$value['menu_name'];

          $arr[]= $value;

          $sql2 = "select * from menu where category_id={$value['id']}";//查询分类ID=1，2，3下一级数据

            $result2 = sql_list($mysqli,$sql2);

            foreach ($result2 as $k=> $v) {  //加点字符串,输出区分格式

              $v['menu_name'] = '&nbsp;&nbsp;&nbsp;<b>|-</b>'.$v['menu_name'];

              $arr[] = $v;

            }

        }
        // var_dump($result);die;
        
        include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

     }


}else if($_A=='home'){
  
    $arr = category_tree(0,0,'&nbsp;|-','menu','*',array(),'menu_name','id','distinction=2');

    foreach ($arr as $key =>  $value) {
      
     $sql = "select * from menu where distinction=2 and id={$value['category_id']}";
     
     $data = sql_one($mysqli,$sql);

     $arr[$key]['category_id'] = $value['category_id']==0?'顶级分类':$data['menu_name'];

     $arr[$key]['distinction'] = $value['distinction']==1?'后台':'前台';

     $arr[$key]['display'] = $value['display']==1?'显示':'隐藏';

     $arr[$key]['controller'] = empty($value['controller'])?'NULL':$value['controller'];

     $arr[$key]['action'] = empty($value['action'])?'NULL':$value['action'];

    }


    $sql_count = "select count('id') as count from menu where distinction=2";
    $count = sql_one($mysqli,$sql_count);
         

  include  VIEW.$_M.'/'.$_C.'/'.'admin.html';
}



?>