<?php

/**
 @$table 数据表
 @$p  当前面
 @$where  查询条件
 @$field 字段
 @
 @
**/

   function pageData($table,$p,$num=5,$where='',$field='*',$order='id desc'){
   	   // $p = isset($_GET['p'])?$_GET['p']:1;//当前页 get url
	    // $num = 3;//每页显示条数
	    $totalnum = CountNum($table,$where);//总条数
        // var_dump($totalnum);die;
	    $total_page = ceil($totalnum['count']/$num);//总条数/当前页的多少条数据 ceil 向上取 floor 向下取
	    // echo $total_page;
	    if($p<1){ //当前页少于1
	    	$p=1;
	    }
	    if($p>$total_page){ //当前页大于1

	    	$p=$total_page;
	    }
	    if($total_page<1){ //数据为空时 

	    	$total_page =1;
	    }

	    
	    $start_page = ($p-1)*$num;//起始页 第一页 $start_page =0 第二页 $start_page=2

	    $map = "$start_page,$num";//limit 起始页，显示条数 
       
	    $data =  sql_all($table,$where,$order,$map,$field);
                

	    return $data;
	 
   }
   function pageJoinData($table1,$table2,$p,$on,$order='id desc',$field='*',$num=5,$where='',$join='INNER JOIN'){
   	   // $p = isset($_GET['p'])?$_GET['p']:1;//当前页 get url
	    // $num = 3;//每页显示条数
   	
	    $totalnum = count_total($table1,$where);//总条数

	    $total_page = ceil($totalnum['count']/$num);//总条数/当前页的多少条数据 ceil 向上取 floor 向下取
	    // echo $total_page;
	    if($p<1){ //当前页少于1
	    	$p=1;
	    }
	    if($p>$total_page){ //当前页大于1

	    	$p=$total_page;
	    }
	    if($total_page<1){ //数据为空时 

	    	$total_page =1;
	    }

	    

	    $start_page = ($p-1)*$num;//起始页 第一页 $start_page =0 第二页 $start_page=2

	    $map = "$start_page,$num";//limit 起始页，显示条数 
       
	    $data =  JoinData($table1,$table2,$on,$map,$order,$join,$field);
	    // JoinData($table1,$table2,$where,$limit,$order,$join='INNER JOIN',$field='*')
	    // "SELECT {$field} FROM {$table1} {$join} {$table2} ON {$where}";
	    return $data;
	 
   }
  /** 分页页码数
 
  @$table 数据表
  @$p  当前面
  @$where  查询条件
  @$field 字段
  @
  @

  **/

   function page($table,$p,$num=5,$url,$showpage=5,$where='',$field='*'){

        $totalnum = CountNum($table,$where);//总条数//总条数

	    $total_page = ceil($totalnum['count']/$num);//总条数/当前页的多少条数据
	    // echo $total_page;
	    if($p<1){ //当前页小于1 
	    	$p=1;
	    }
	    if($p>$total_page){ //当前页大于1
	    	$p=$total_page;
	    }
	    if($total_page<1){  //数据为空时 
	    	$total_page =1;
	    }
        $offset = floor($showpage/2); //如果是5页，
        if($showpage<$total_page){ //总页数大于显示页码数
	        if($p<=$offset){//前三前页 起始页 结束页 当前页少于偏移量
	           $start_page =1;//偏移量-2+1 当前页页码最小码数，
	           $end_page   =$showpage;  //偏移量-2+1 当前页页码最大码数， 
	        }elseif($p>$offset){  //大于3页后 起始页 结束页 当前页大于偏移量
	           $start_page = $p-$offset;
	           $end_page   = $p+$offset;
	           if($p>=$total_page-$offset){ //最后三页的偏移量的处理

	           	  $start_page = $total_page-$showpage+1;

	           	  $end_page = $total_page;

	           }
	           if($p<$total_page-$offset) { 
		           	if($showpage%2==0){ //如果显示所有的页码数为偶数时
		              $start_page = $p-$offset+1; 
		              $end_page   = $p+$offset;
		            }
	           }
	           
	        }
        }else{ //总页数少于显示页
           $start_page =1;//偏移量-2+1 当前页页码最小码数，
           $end_page   =$total_page;  //偏移量-2+1 当前页页码最大码数， 
        }
        
	    $prev = $p-1; //上一页

	    if($prev<1){  //上一页小于1
	    	$prev = 1;
	    }
	    
	    $next = $p+1; //下一页

	    if($next>$total_page){ //下一页大于总页数
	    	$next = $total_page;
	    	
	    }

	    $page ='';

	    $page .= '<a href="index.php?'.$url.'&p=1">首页</a>';
	    $page .= '<a href="index.php?'.$url.'&p='.$prev.'#jb">上一页</a>';

	    if($showpage !=$total_page){
	    	if($showpage%2==0){
               if($p>1 && $p>$offset){	    		

		    	  	$page .= '...';	    	  
		    	   
		        }
	    	}else{
                if($p>1 && $p>$offset+1){	    		

		    	  	$page .= '...';	    	  
		    	   
		        }
	    	}
	    	
	    }
	    
	    for ($i=$start_page; $i <=$end_page; $i++) { 
	    	if($i==$p){
                $page .= '<a class="on" href="index.php?'.$url.'&p='.$i.'#jb">'.$i.'</a>';
	    	}else{
	    		$page .= '<a href="index.php?'.$url.'&p='.$i.'">'.$i.'#jb</a>';
	    	}
	    	
	    }
	    if($showpage != $total_page){
	    	if($p<$total_page && $p>$offset+1 && $p < $total_page-$offset)
	       {
	    	    $page .= '...';
	       }
	    }
	    
	    $page .= '<a href="index.php?'.$url.'&p='.$next.'#jb">下一页</a>';
	    $page .= '<a href="index.php?'.$url.'&p='.$total_page.'#jb">尾页</a>';
	    // echo '<br>';
	    return $page;
   }


   /** 分页页码数
 
  @$table 数据表
  @$p  当前面
  @$where  查询条件
  @$field 字段
  @
  @

  **/

   function page_home($table,$p,$num=5,$url,$showpage=5,$where='',$field='*'){

        $totalnum = CountNum($table,$where);//总条数//总条数

	    $total_page = ceil($totalnum['count']/$num);//总条数/当前页的多少条数据
	    // echo $total_page;
	    if($p<1){ //当前页小于1 
	    	$p=1;
	    }
	    if($p>$total_page){ //当前页大于1
	    	$p=$total_page;
	    }
	    if($total_page<1){  //数据为空时 
	    	$total_page =1;
	    }
        $offset = floor($showpage/2); //如果是5页，
        if($showpage<$total_page){ //总页数大于显示页码数
	        if($p<=$offset){//前三前页 起始页 结束页 当前页少于偏移量
	           $start_page =1;//偏移量-2+1 当前页页码最小码数，
	           $end_page   =$showpage;  //偏移量-2+1 当前页页码最大码数， 
	        }elseif($p>$offset){  //大于3页后 起始页 结束页 当前页大于偏移量
	           $start_page = $p-$offset;
	           $end_page   = $p+$offset;
	           if($p>=$total_page-$offset){ //最后三页的偏移量的处理

	           	  $start_page = $total_page-$showpage+1;

	           	  $end_page = $total_page;

	           }
	           if($p<$total_page-$offset) { 
		           	if($showpage%2==0){ //如果显示所有的页码数为偶数时
		              $start_page = $p-$offset+1; 
		              $end_page   = $p+$offset;
		            }
	           }
	           
	        }
        }else{ //总页数少于显示页
           $start_page =1;//偏移量-2+1 当前页页码最小码数，
           $end_page   =$total_page;  //偏移量-2+1 当前页页码最大码数， 
        }
        
	    $prev = $p-1; //上一页

	    if($prev<1){  //上一页小于1
	    	$prev = 1;
	    }
	    
	    $next = $p+1; //下一页

	    if($next>$total_page){ //下一页大于总页数
	    	$next = $total_page;
	    	
	    }

	    $page ='';

	    $page .= '<li class="index"><a href="index.php?'.$url.'&p=1#jb">首页</a></li>';
	    $page .= '<li class="prev"><a href="index.php?'.$url.'&p='.$prev.'#jb">上一页</a></li>';

	    if($showpage !=$total_page){
	    	if($showpage%2==0){
               if($p>1 && $p>$offset){	    		

		    	  	$page .= '...';	    	  
		    	   
		        }
	    	}else{
                if($p>1 && $p>$offset+1){	    		

		    	  	$page .= '...';	    	  
		    	   
		        }
	    	}
	    	
	    }
	    
	    for ($i=$start_page; $i <=$end_page; $i++) { 
	    	if($i==$p){
                $page .= '<li><a class="on" href="index.php?'.$url.'&p='.$i.'">'.$i.'</a></li>';
	    	}else{
	    		$page .= '<li><a href="index.php?'.$url.'&p='.$i.'#jb">'.$i.'</a></li>';
	    	}
	    	
	    }
	    if($showpage != $total_page){
	    	if($p<$total_page && $p>$offset+1 && $p < $total_page-$offset)
	       {
	    	    $page .= '...';
	       }
	    }
	    
	    $page .= '<li class="prev"><a href="index.php?'.$url.'&p='.$next.'#jb">下一页</a></li>';
	    if($p>1){
	    $page .= '<li><a href="index.php?'.$url.'&p='.$total_page.'#jb">尾页</a></li>';	
	    }
	    
	    // echo '<br>';
	    return $page;
   }