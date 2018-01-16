<?php

function login(){
    global $mysqli;
	$mysqli = @mysqli_connect(DBHOST,DBUSER,DBPASSWORD,DBNAME);  //数据库连接

	mysqli_set_charset($mysqli,CHARSET);  //设置编码

	if(mysqli_connect_errno()){  //判断数据库是否连接成功 ， 失败后报错信息

		echo '数据库连接不上啊T^T：'.mysqli_connect_error();
	}
}



?>
