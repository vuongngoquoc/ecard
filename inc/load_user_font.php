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
	$sender = $sender ? $sender : $_SESSION[user_name_id];
	$list_userfonts=set_array_from_query("max_user_font","*","font_user_name_id='$sender'");
	$show_list_of_user_fonts = '';
	$list_of_user_fonts_name = array();
	foreach($list_userfonts as $array){
		$font_id=$array[font_id];
		$font_filename=$array[font_filename];
		$font_name=$array[font_name];
		$show_list_of_user_fonts.=<<<EOF
@font-face {
  font-family: '$font_name';
  src: url($ecard_url/resource/invitation_fonts/user_font/$font_filename);
}
EOF;
		$list_of_user_fonts_name[] = $font_name;
	}
	if($what == 'select') {
		echo json_encode($list_of_user_fonts_name);
	} else {
		print($show_list_of_user_fonts);
	}
	header("Content-type: text/css");
?>