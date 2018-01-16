<?php

if($_A=='index'){

   $sql= "select * from category where 1";

   $arr = sql_list($mysqli,$sql);

   foreach ($arr as $key => $value) {

   $sql = "select * from menu where id={$value['category_id']}";
   // var_dump($sql);
   $data = sql_one($mysqli,$sql);

   // var_dump($data);die;
     
     $arr[$key]['category_id'] = $data['menu_name'];

     $arr[$key]['static'] = $value['static']==1?'显示':'隐藏';

     $arr[$key]['remarks'] = empty($value['remarks'])?'NULL':$value['remarks'];

   
   }

    $sql_count = "select count('id') as count from category where 1";

    $count = sql_one($mysqli,$sql_count);

	include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

}else if($_A=='add'){

    if($_POST){

    	$data = $_POST;

      $data['cate_name']  = $_POST['cate_name'];

         $sql_select = "select cate_name from category where cate_name='{$data['cate_name']}'";//判断是否存在这个名字

         $name = sql_one($mysqli,$sql_select);
         

         if($name){
          script_error('分类名已存在，另外起一个呗');
         }

      $data['create_time']     = date("Y-m-d H:i:s",time());

    	if(!empty($data['cate_id'])){

    		$data['category_id'] = $data['cate_id'];
        
    	}
      unset($data['cate_id']);
    	
       if($data['cate_name'] == '' or $data['category_id'] == ''){
          
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

    	$sql = "insert into category($keys) values($values)";

    	$result = sql_insert($mysqli,$sql);

        if($result){

       	  script_success('添加成功','index.php?mot=admin&ctl=category&act=index');

       }else{

       	  script_error('添加失败');
       }

    }else{

    	$sql = "select * from menu where static=1 and distinction=2 and category_id=0";

    	$arr = sql_list($mysqli,$sql);

    	include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
    }

}else if($_A=='edit'){

	 if($_POST){
        // var_dump($_POST);die;
        $id = $_POST['id'];
        // var_dump($id);die;

        $data = $_POST;

        if(!empty($data['cate_id'])){

            $data['category_id'] = $data['cate_id'];
        }

        unset($data['cate_id']);

        if($data['cate_name'] == '' or $data['category_id'] == ''){
          
        script_error('带*号的内容不能为空');
      }

        $keys = '';

      

        foreach ($data as $key => $value){

            $keys .= $key."='".$value."',";

           
        }

        $keys = rtrim($keys,',');

        

        $sql = "update category set {$keys} where id={$id}";
        // var_dump($sql);
        $result = sql_edit($mysqli,$sql);
        // var_dump($results);die;

        if($result){

          script_success('修改成功','index.php?mot=admin&ctl=category&act=index');

       }else{

          script_error('修改失败');
       }

    }else{

        $id = $_GET['id'];

        // var_dump($id);die;
        
        $sql = "select * from category where id={$id}";
        // var_dump($sql);

        $result = sql_one($mysqli,$sql);
        // var_dump($result);die;

       $sql2 = "select * from menu where static=1 and distinction=2 and category_id=0";
       // var_dump($sql2);
       $results = sql_list($mysqli,$sql2);
       // var_dump($results);die;

       


        include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

    }

}else if($_A=='del'){

  $id = $_GET['id'];

  $sql = "delete from category where id={$id}";
  // var_dump($sql);
  $result = sql_del($mysqli,$sql);
  // var_dump($result);die;

  if($result){

    echo json_encode(1);
    die;
   }else{
    echo json_encode(0);
    die;
   }
}



?>