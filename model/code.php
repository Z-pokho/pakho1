<?php
/**验证码**/

function verify($size=20,$number=4,$ttf=array('common/fonts/FZZQJW.TTF'),$str='0123456789qwertyuiopasdfghjklzxcvbnm'){

	$w=$size*10;
	$h=$size*5;

	$image = imagecreatetruecolor($w,$h);

	$color = imagecolorallocate($image,mt_rand(160,200),mt_rand(160,200),mt_rand(100,200));

	$png = imagefiledrectanle($image,0,0,200,100,$color);

    $vcode ='';

    for ($i=0;$i < $number;$i++){

    	$wit = $size*($i+0.5);//设置文字的X轴定位

    	$hei = mt_rand($size*($i+0.5),$size*3);//随机获取文字的Y轴定位

    	$length = strlen($str);
    	$le_one = $str[mt_rand(0,$length-1)];

    	$vcode .=$le_one;

    	$color1 = imagecolorallocate($im,rand(0,40),rand(0,40),rand(0,40));
    	$font = count($ttf)-1;

    	imagettftext($image,20,90,100,50,$color1,$ttf,$le_one);
    }

    if(empty($_SESSION)){

      session_start();
    }

    $_SESSION['vcode'] = $vcode;
    	ob_clean();
    	header("Cache-Control:max-age=1,s-maxage=1,no-cache,must-revalidate");

    	header("Content-type: image/png;charset=utf8");

    	imagepng($image);
    	imagedestroy($image);//通常与生成图片连用
    }

   /**
 * [vcode 生成验证码图片]
 * @param  [自然数] $number [验证码字符个数]
 * @param  [自然数] $size   [验证码字体大小]
 * @param  [自然数] $width  [验证码图片宽度]
 * @param  [自然数] $height [验证码图片高度]
 * @param  [字符串]  $str    [验证码字符串源]
 * @param  [数组]   $font   [字体文件路径数组]
 */

  function vcode($number=2,$size=20,$width=0,$hight=0,$str="1234567890qwertyuiopasdfghjklzxcvbnm",$font=array('common/fonts/FZZQJW.TTF','common/fonts/STHUPO.TTF')){

if($width==0){

  $width=($number+1.5)*$size;
}

if($hight==0){

   	$height=$size*2;
   }

   $im = imagecreatetruecolor($width,$height);

   $randTintColor=imagecolorallocate($im,rand(160,255),rand(160,255),rand(160,255));

   imagefilledrectangle($im,0,0,$width,$height,$randTintColor);

   $vcode='';

   $fontMaxIndex=count($font)-1;
   for($i=0; $i<$number;$i++){

    $wx=$size*0.5+$size*$i;
   	$wy=rand($size*1.5,$size*2);
    $strMaxIndex=strlen($str)-1;
    $code=$str[rand(0,$strMaxIndex)];
   
   $vcode.=$code;

   $randColor1=imagecolorallocate($im,rand(0,40),rand(0,40),rand(0,40));

   imagettftext($im,$size,rand(-40,10),$wx,$wy,$randColor1,$font[rand(0,$fontMaxIndex)],$code);

   }

   $pn=$size*5;
   for($i=0 ; $i < $pn; $i++){

    $randColor=imagecolorallocate($im,rand(10,50),rand(10,50),rand(10,50));

    $wwx= rand(0,$width);

    $wwy= rand(0,$height);

    imagesetpixel($im,$wwx,$wwy,$randColor);
   }

   if(!isset($_SESSION)){

    session_start();
   }

   $_SESSION['vcode']=strtolower($vcode);

   header("Content-type: image/png;charset=utf-8");
   ob_clean();
   imagepng($im);
   imagedestroy($im);
}






?>