<?php
//logo
  $sql = "select image from contact order by id desc limit 1";
  $logo = sql_one($mysqli,$sql);

//导航栏

  $sql = "select * from menu where category_id=0 and distinction=2 and display=1";

  $menu = sql_list($mysqli,$sql);
  /*var_dump($menu);die;*/

  foreach ($menu as $key => $value){

    if(isset($value['controller']) or isset($value['action'])){

    	 $menu[$key]['urls'] = "index.php?mot={$_M}&ctl={$value['controller']}&act={$value['action']}";
    }
     
  	
  }


  $sql = "select * from menu where category_id=0 and distinction=2";

  $menus = sql_list($mysqli,$sql);

  foreach ($menus as $key => $value) {

  	if($_C==$value['controller']){

  		if($_A==$value['action'])

  		$title = $value['menu_name'];

  	}
  }



//轮播图
switch ($_C) {
  case 'index':
    $category_id =60;
    break;
  case 'about':
    $category_id =61;
    break;
  
  case 'news':
    $category_id =62;
    break;

    case 'product':
    $category_id =63;
    break;

    case 'contact':
    $category_id =64;
    break;

    case 'product_details':
    $category_id =66;
    break;

    case 'news_details':
    $category_id =67;
    break;
}

$sql = "select * from banner where category_id={$category_id}";
$banner = sql_list($mysqli,$sql);


//底部

$sql = "select footer1 from contact order by id desc limit 1";
$footer1 = sql_one($mysqli,$sql);

$sql = "select footer2 from contact order by id desc limit 1";
$footer2 = sql_one($mysqli,$sql);

$sql = "select footer3 from contact order by id desc limit 1";
$footer3 = sql_one($mysqli,$sql);

//头尾分离
require_once VIEW.$_M.'/header.html';
require_once VIEW.$_M.'/'.$_C.'.html';
require_once VIEW.$_M.'/footer.html';

?>