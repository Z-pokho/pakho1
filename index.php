<?php
header("content-type:text/html;charset=utf-8");
  include 'model/int.php';
 
 
$url =CONTROLLER.'/'.$_M.'/'.$_C.'.php';

//file_exists() 函数检查文件或目录是否存在,
//如果指定的文件或目录存在则返回 true，否则返回 false。
if(file_exists( $url )){
      include $url;
}else{
	return false;
}
