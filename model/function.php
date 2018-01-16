<?php



function sql_one($mysqli,$sql,$pri=2){

     // 查询一条数据  
      if($pri==1){
           echo_sql($sql);
           exit('数据库语名打印');
        }
    $result  = mysqli_query($mysqli,$sql); //执业sql语句

    // var_dump($result);
        if($result){

          return mysqli_fetch_assoc($result); //取出结果集一条数据  有数据会取出结果，没数据输出一个NULL值

        }else{

          return false;
        }
    
}


function sql_list($mysqli,$sql){
    //查询多条
    $result  = mysqli_query($mysqli,$sql); //执业sql语句

    $arr = [];
    if($result){
      
      while($row =mysqli_fetch_assoc($result)){
          $arr[]= $row;
      }
    }else{
            $arr = false;
    }
    return $arr;
}

/**
   *添加新数据
**/
function sql_insert($mysqli,$sql){

  $result = mysqli_query($mysqli,$sql);
  // var_dump($result);

    if($result){
      $row = mysqli_insert_id($mysqli);
    }else{
      $row = false;
    }
    return $row;

}

/**
   *修改数据
   *@prama $myslqi 数据库连接
   *@prama $sql  sql语句
**/

function sql_edit($mysqli,$sql){

  $result = mysqli_query($mysqli,$sql);
/*  var_dump($result);*/
    if($result){
      return $result;
    }else{
      return false;
    }

}
/**删除数据**/

function sql_del($mysqli,$sql){

  $result = mysqli_query($mysqli,$sql);
    if($result){
      return $result;
    }else{
      return false;
    }
}


/**查询语句，有数据过滤数据**/


// function sql_check($msyqli,$sql,$string,$string){
   
//     $stmt = mysqli_prepare($mysqli,$sql);
//     mysqli_stmt_bind_param($stmt,'ss',$string,$string);
//     mysqli_stmt_execute($stmt);
//     mysqli_stmt_bind_result()
// }



function category_tree($pid =0,$num =0,$str = '&nbsp;|-',$table='menu',$filed='*',$arr=array(),$file='menu_name',$id='id',$where=''){

  static $arr;
  global $mysqli;

  $sql = "select {$filed} from {$table} where category_id={$pid}";

  if($where !=''){
    $sql .= " and $where";
  }

  $result = sql_list($mysqli,$sql);

    $num++;
       
          foreach ($result as $key => $value) {
            
           /* $value[$file] = str_repeat($str,$num).$value[$file];*/
            
            $arr[]= $value;

             category_tree($value[$id],$num,$str,$table,$filed,$arr,$file,$id,$where);

       }
         return $arr;
}


/*function insert_into($table,$data){*/

   /* global $mysqli;

    $keys = '';
    $values = '';

    foreach ($data as $key => $value){

          $keys .= $key.',';

          $values .="'".$value."',";
       }

    $keys = rtrim($keys,',');

    $values = rtrim($values,',');

    $sql = "insert into news($keys) values($values)";*/

      /* echo $sql;die;*/

  /*  return sql_insert($mysqli,$sql);  //添加用户*/



function CountNum($table,$where='',$count='count',$filed='id'){
   // $where ='';
   global $mysqli;

    $sql = "select count($filed) as $count from $table";
     // echo $sql;
   if($where != ''){
    $sql .=" where $where";

   }

   $result = mysqli_query($mysqli,$sql);
   // var_dump($result);die;
   //执行sql语句
   if($result){

     return mysqli_fetch_assoc($result);
     //取出结果集一条数据  有数据会取出结果，没数据输出一个NULL值
   }else{

    return false;
   }

}



function sql_all($table,$where='',$order='',$limit='',$filed='*'){
    //查询多条
    global $mysqli;

    $sql ="select $filed from $table";
    
    if($where != ''){
       $sql .=" where $where";
    }

    $sql .= $order != ''? " order by $order"  :'';
    $sql .= $limit != ''? " limit $limit"  :'';


    $result  = mysqli_query($mysqli,$sql); //执业sql语句

    $arr = [];
    if($result){
      
      while($row =mysqli_fetch_assoc($result)){
          $arr[]= $row;
      }
    }else{
            $arr = false;
    }
    return $arr;
}