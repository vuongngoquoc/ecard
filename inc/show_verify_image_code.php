<?php
/*
+--------------------------------------------------------------------------
|
|	WARNING: REMOVING THIS COPYRIGHT HEADER IS EXPRESSLY FORBIDDEN
|
|   ECardMax Version 10.5
|   ========================================
|   (c) 1999 - 2016 ECARDMAX.COM - All right reserved 
|	Software For Website, Inc.
|   http://www.ecardmax.com 
|   ========================================
|   Email: webmaster@ecardmax.com
|   Purchase Info: http://www.ecardmax.com/purchase/
|   Request Installation: http://ecardmax.com/ehelpmax/
|	
|	WARNING //--------------------------
|
|	Selling the code for this program without prior written consent is expressly forbidden. 
|	This computer program is protected by copyright law. 
|	Unauthorized reproduction or distribution of this program, or any portion of if,
|	may result in severe civil and criminal penalties and will be prosecuted to 
|	the maximum extent possible under the law.
+--------------------------------------------------------------------------
*/
	if(ECARDMAX_USER!=1)exit;
	
	// Check to see if GD has been supported. If no, display error
	$gd_failed = false;
	$error_message = "";
	if (!function_exists("imagecreatefrompng") || !function_exists("imagecopymerge") || !function_exists("imagepng") || !function_exists("imagedestroy")) {
		$gd_failed = true;
		$error_message .= "PNG support: NO<br>";
	}
	if (!function_exists("imagecolorexact") || !function_exists("imagecolortransparent") || !function_exists("imagecreatetruecolor") || !function_exists("imagecolorallocate")) {
		$gd_failed = true;
		$error_message .= "Color support: NO<br>";
	}
	if (!function_exists("imagesx") || !function_exists("imagesy")) {
		$gd_failed = true;
		$error_message .= "Function imagesx and imagesy support: NO<br>";
	}
	if (!function_exists("imagefilledrectangle")) {
		$gd_failed = true;
		$error_message .= "Function imagefilledrectangle: NO<br>";
	}
	if (!function_exists("imagettfbbox") || !function_exists("imagettftext")) {
		$gd_failed = true;
		$error_message .= "FreeType Library support: NO<br>";
	}
	
	if ($gd_failed) {
		echo $error_message;
		echo "<br>";
		echo "GD failed! Please contact your hosting provider for GD support.";
		exit;
	}

	// Set the content-type
	header("Content-type: image/png");
	
	//Config here
	$image_Width=200;
	$image_Height=50;
	$font_size=30;
	$line_height=40;
	$cf_watermark_opacity=85;
	$cf_security_image_fontcolor="255,255,255";
	$cf_security_image_backgroundcolor="0,0,0";
	$font ="$ecard_root/resource/image_font/Verdana.ttf";	
	$logo = imagecreatefrompng("$ecard_root/resource/image_font/watermark.png");

	$bgcolor=imagecolorexact($logo, 255, 255, 255);
	imagecolortransparent($logo,$bgcolor);
	$logoWidth = imagesx($logo);
	$logoHeight = imagesy($logo);

	$logoX = ($image_Width - $logoWidth) / 2;
	$logoY= 0;

	// Create the image
	$im = imagecreatetruecolor($image_Width, $image_Height);

	// Create Text colors
	$info_text_color = split(",",$cf_security_image_fontcolor);
	$text_color = imagecolorallocate($im, $info_text_color[0], $info_text_color[1], $info_text_color[2]);
	
	// Create Background colors
	$info_background_color = split(",",$cf_security_image_backgroundcolor);
	$background_color = imagecolorallocate($im, $info_background_color[0], $info_background_color[1], $info_background_color[2]);
		
	imagefilledrectangle($im, 0, 0, $image_Width, $image_Height, $background_color);

	// The text to draw
	if ($for && $for=="user_comment") {
		$text = $_SESSION['random_code_comment'];
	}
	else {
		$text = $_SESSION['random_code'];
	}

	$size = imagettfbbox($font_size, 0, $font, $text);
	$long_text = $size[2]+$size[0];
	$posx=($image_Width-$long_text)/2;

	// Add the text
	imagettftext($im, $font_size, 0, $posx, $line_height, $text_color, $font, $text);

	imagecopymerge($im, $logo, $logoX,$logoY,0,0,$logoWidth,$logoHeight,$cf_watermark_opacity);

	// Using imagepng() results in clearer text compared with imagejpeg()
	imagepng($im);
	imagedestroy($im);

?> 