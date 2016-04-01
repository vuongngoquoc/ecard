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
	$list_data =set_array_from_query("max_stamp","stamp_id,stamp_filename,stamp_name_display","stamp_active='1' and stamp_user_name_id='' or stamp_active='1' and stamp_user_name_id='$_SESSION[user_name_id]' Order by stamp_user_name_id DESC,stamp_order,stamp_name_display");	
	$show_list_stamp_icon ="<li onclick=\"GetStampCode('');\">";
	$show_list_stamp_icon .="<a href='javascript:;'><i class='fa fa-remove padding5'></i>$sendcard_php_no_stamp</a></li>";
	foreach($list_data as $row_data){
		$stamp_name_display=str_replace("'","`",$row_data[stamp_name_display]);
		if(file_exists("$ecard_root/resource/stamp/$row_data[stamp_filename]")){
			$show_list_stamp_icon .="<li onclick=\"cs_stamp_filename='$row_data[stamp_filename]';GetStampCode('$ecard_url/resource/stamp/$row_data[stamp_filename]');\">";
			$show_list_stamp_icon .="<a href='javascript:;'><img src=\"$ecard_url/resource/stamp/$row_data[stamp_filename]\" alt=\"\" /> $row_data[stamp_name_display]</a></li>";
		}
	}
	echo $show_list_stamp_icon;

?>