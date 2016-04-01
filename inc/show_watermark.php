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
	if (!function_exists("imagecreatefromjpeg") || !function_exists("imagejpeg")) {
		$gd_failed = true;
		$error_message .= "JPEG support: NO<br>";
	}
	if (!function_exists("imagecreatefromgif") || !function_exists("imagegif")) {
		$gd_failed = true;
		$error_message .= "GIF support: NO<br>";
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
	
	if (!function_exists("imagecreatefrompng") || !function_exists("imagecopymerge") || !function_exists("imagepng") || !function_exists("imagedestroy")) {
		$gd_failed = true;
		$error_message .= "PNG support: NO<br>";
	}
	
	$row_data=get_row("max_ecard","ec_cat_dir,ec_filename","ec_id='$ec_id'");
	
	$src ="$ecard_root/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_filename]";
	if(file_exists($src)){
		$image_info = getimagesize($src);
		$type=$image_info['mime'];
		$img_width =$image_info[0];
		$img_height=$image_info[1];
		if($type =="image/jpeg" || $type =="image/gif" || $type =="image/png"){
			watermark_myimage($type,$src);															
		}
	}

?>