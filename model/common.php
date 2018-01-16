<?php

/**成功跳转**/
function script_success($mgs,$url){
    
    echo "<script>alert('".$mgs."');window.location.href='".$url."';</script>";
    
	exit();
}

/**失败跳转**/
function script_error($mgs,$url='history.back();'){
	echo "<script>alert('".$mgs."');".$url."</script>";
	exit();
}



/**读取视图方法**/
function  view($model,$controller,$action,$data=array()){
    extract($data);
	include VIEW.$model.'/'.$controller.'/'.$action.'.html';
}

/**打印sql语句**/
function echo_sql($sql){
	echo '<pre>';
    echo $sql;
    echo '</pre>';
    exit();
}

/**获取数据文件路径**/
function path_info($filepath)   
{   
    $path_parts = array();   
    $path_parts ['dirname'] = rtrim(substr($filepath, 0, strrpos($filepath, '/')),"/")."/";   
    $path_parts ['basename'] = ltrim(substr($filepath, strrpos($filepath, '/')),"/");   
    $path_parts ['extension'] = substr(strrchr($filepath, '.'), 1);   
    $path_parts ['filename'] = ltrim(substr($path_parts ['basename'], 0, strrpos($path_parts ['basename'], '.')),"/");   
    return $path_parts;   
}


/**输出数据**/

function echo_print($name,$type=1){

    if(is_string($name)){
        echo '<pre>';
        echo $name;
        echo '</pre>';
        die;
    }
    elseif(is_array($name) && $type==1){
        echo '<pre>';
        echo '<div style="width:80%;border:2px solid #000;box-shadow:20%；border-radius:20%">';
        print_r($name);
        echo '</div>';
        echo '</pre>';
        die;
    }
    else if(is_array($name)){
        echo '<pre>';
        echo '<div style="width:80%;border:2px solid #000;box-shadow:20%">';
        var_dump($name);
        echo '</div>';
        echo '</pre>';
        die;
    }
}