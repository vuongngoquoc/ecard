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
	
	if($action=="add_new"){	
		//Upload file
		$upload_dir ="$ecard_root/resource/picture/user_picture";
		$number_card = 0;
		for($i=1;$i<=7;$i++){
			
			$file_key="file$i";
			$rand_id = "user".$_SESSION[user_id].substr(md5(uniqid(rand(),1)), 0, 8);
			$file_name = $POST_FILES[$file_key]['name'];
			$file_upload_size = $POST_FILES[$file_key]['size'];
			if($file_upload_size > 0){
				$ext="";
				$show_info="";
				$file_name =strtolower($file_name);
				if(substr($file_name, strlen($file_name)-4, strlen($file_name))==".gif")$ext =".gif";
				if(substr($file_name, strlen($file_name)-4, strlen($file_name))==".jpg")$ext =".jpg";
				if(substr($file_name, strlen($file_name)-4, strlen($file_name))==".png")$ext =".png";
				if(substr($file_name, strlen($file_name)-4, strlen($file_name))==".swf")$ext =".swf";
				if(substr($file_name, strlen($file_name)-4, strlen($file_name))==".mov")$ext =".mov";
				if(substr($file_name, strlen($file_name)-4, strlen($file_name))==".dcr")$ext =".dcr";

				$file_upload_name = "$ecard_root/resource/picture/user_picture/$rand_id$ext";
				$file_upload_name_thumb = "$ecard_root/resource/picture/user_picture/$rand_id" . "_thumb" . "$ext";
				$fullsize_filename="$rand_id$ext";
				$thumbnail_filename="$rand_id" . "_thumb" . "$ext";
				
				if($ext!=".gif" && $ext!=".jpg" && $ext!=".png" && $ext!=".swf" && $ext!=".mov" && $ext!=".dcr" )
					$show_info .="<div class=\"Error_Message\">$myalbum_image_error_msg_image_Type</div><br />\n";
				
				if($file_upload_size > $cf_image_upload_max_size)
					$show_info .="<div class=\"Error_Message\">$myalbum_image_error_msg_image_FileSize_Big</div><br />\n";

				$count_user_image = get_dbvalue("max_ecard","count(ec_id)","ec_user_name_id='$_SESSION[user_name_id]'");	
				if($cf_album_max_image > 0 && $count_user_image>= $cf_album_max_image)
					$show_info .="<div class=\"Error_Message\">$myalbum_image_error_msg_image_Over_Limit</div><br />\n";	

				if($show_info==""){					
					//Upload and Add image to database
					if(move_uploaded_file($POST_FILES[$file_key]['tmp_name'],$file_upload_name)){
						$number_card++;
						chmod($file_upload_name,0777);

						$image_info = getimagesize($file_upload_name);
						$type=$image_info['mime'];
						$img_width =$image_info[0];
						$img_height=$image_info[1];
						if($type =="image/jpeg" || $type =="image/gif" || $type =="image/png"){
							if($img_width > $cf_max_image_width)
								resize_myimage($type,$file_upload_name,$file_upload_name,"full");
			
							if($img_width > $cf_thumb_width_member_card){
								resize_myimage($type,$file_upload_name,$file_upload_name_thumb,"thumb");
							}
							else{
								copy($file_upload_name, $file_upload_name_thumb);								
							}
						}
						else{
							$thumbnail_filename="";
						}
			
						$field_name ="(ec_filename,ec_thumbnail,ec_cat_dir,ec_user_name_id,ec_group_relate_id)";
						$field_value ="('$fullsize_filename','$thumbnail_filename','user_picture','$_SESSION[user_name_id]',',1,')";
						insert_data_to_db("max_ecard",$field_name,$field_value);
						
						// Get the new id of picture, then insert into max_album_picture with the album_id
						$ec_id = mysql_insert_id();
						$field_name ="(album_id,ec_id)";
						$field_value ="('$albums_list','$ec_id')";
						insert_data_to_db("max_album_picture",$field_name,$field_value);
					}
				}
			}
		}
		if($number_card>0)$show_info .="<div class=\"OK_Message\">$myalbum_image_msg_New_Image_Added ($number_card)</div><br />\n";
		$action="";
		set_global_var("action","");
		$album_id=$albums_list;
	}	
	elseif($action=="delete_selected"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);
				
				//Delete photo
				$row=get_row("max_ecard","*","ec_id='$selected_id'");
				if(is_writable("$ecard_root/resource/picture/$row[ec_cat_dir]/$row[ec_thumbnail]") && is_writable("$ecard_root/resource/picture/$row[ec_cat_dir]/$row[ec_filename]")){
					@unlink("$ecard_root/resource/picture/$row[ec_cat_dir]/$row[ec_thumbnail]");
					@unlink("$ecard_root/resource/picture/$row[ec_cat_dir]/$row[ec_filename]");					
				}
				//Delete row in database
				delete_row("max_ecard","ec_id='$selected_id' LIMIT 1");
				delete_row("max_album_picture","ec_id='$selected_id' LIMIT 1");
			}
		}
		$show_info .="<div class=\"OK_Message\">$myalbum_msg_Image_updated</div><br />\n";
		$action="";
		set_global_var("action","");
		$album_id=$_GET[album_id];
	}
	elseif($action=="add_new_album") {
		$field_name ="(album_name,album_desc,album_user_id,album_private)";
		$field_value ="('$album_name_added','$album_desc','$_SESSION[user_id]','1')";
		insert_data_to_db("max_album",$field_name,$field_value);
		
		$show_info .="<div class=\"OK_Message\">$myalbum_image_msg_New_Album_Added</div><br />\n";
		$action="";
		set_global_var("action","");
	}
	elseif($action=="delete_selected_albums") {
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);
				
				// remove pictures from max_album_picture with the album_id
				$list_data =set_array_from_query("max_album_picture","*","album_id='$selected_id'");
				$xrow=0;
				for ($z=$start; $z<$end; $z++) {
					$val = $list_data[$xrow][ec_id];					
					$row=get_row("max_ecard","*","ec_id='$val'");
					
					if(is_writable("$ecard_root/resource/picture/user_picture/$row[ec_thumbnail]") && is_writable("$ecard_root/resource/picture/user_picture/$row[ec_filename]")){
						@unlink("$ecard_root/resource/picture/user_picture/$row[ec_thumbnail]");
						@unlink("$ecard_root/resource/picture/user_picture/$row[ec_filename]");					
					}
					
					//Delete row in database
					delete_row("max_ecard","ec_id='$val' LIMIT 1");
					delete_row("max_album_picture","ec_id='$val' LIMIT 1");
					
					$xrow++;					
				}
				
				// remove album from table max_album
				delete_row("max_album","album_id='$selected_id' LIMIT 1");
			}
		}
		$show_info .="<div class=\"OK_Message\">Album has been deleted</div><br />\n";
		$action="";
		set_global_var("action","");
	}
	elseif($action=="edit_me_album") {
		update_field_in_db("max_album","$edit_key",$edit_key_value,"$edit_id='$edit_id_value' and album_user_id='$_SESSION[user_id]' LIMIT 1");		
		exit;
	}

	if ($album_id && $album_id!="") {
		require_once("show_myalbum_photo_list_pictures.php");
	}
	else {
		require_once("show_myalbum_photo_list_albums.php");
	}	
	
	//Count total photo
	$total_count=get_dbvalue("max_album","count(album_id)","album_user_id='$_SESSION[user_id]'");

	//if($isResponsive) $_CLS = "btn btn-default btn-xs";
	//Display buttons 
	if(!$isResponsive)
	{
		if($cf_member_can_upload_image=="1"){
			$_ICON = "<img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_member_upload_photo.gif\" style=\"vertical-align:middle\" />";
			if($isResponsive)
			$_ICON = "<i class='fa fa-photo padding5'></i>";
			$button_myalbum_photo="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=photo\" class=\"button_link_style1 $_CLS\">$_ICON $myalbum_button_goto_photo</a>";
		}
		if($cf_member_can_upload_music=="1"){
			$_ICON = "<img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_member_upload_audio.gif\" style=\"vertical-align:middle\" />";
			if($isResponsive)
			$_ICON = "<i class='fa fa-music padding5'></i>";
			$button_myalbum_music="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=music\" class=\"button_link_style1 $_CLS\">$_ICON $myalbum_button_goto_music</a>";
		}
		if($cf_option_select_poem=="1"){
			$_ICON = "<img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_member_upload_poem.gif\" style=\"vertical-align:middle\" />";
			if($isResponsive)
			$_ICON = "<i class='fa fa-edit padding5'></i>";
			$button_myalbum_poem="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=poem\" class=\"button_link_style1 $_CLS\">$_ICON $myalbum_button_goto_poem</a>";
		}
		if($cf_member_can_upload_stamp=="1"){
			$_ICON = "<img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_member_upload_stamp.gif\" style=\"vertical-align:middle\" />";
			if($isResponsive)
			$_ICON = "<i class='fa fa-barcode padding5'></i>";
			$button_myalbum_stamp="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=stamp\" class=\"button_link_style1 $_CLS\">$_ICON $myalbum_button_goto_stamp</a>";
		}
		if($cf_member_can_upload_font=="1"){
			$_ICON = "<img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_member_upload_font.gif\" style=\"vertical-align:middle\" />";
			if($isResponsive)
			$_ICON = "<i class='fa fa-fonticons padding5'></i>";
			$button_myalbum_font="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&what=font\" class=\"button_link_style1 $_CLS\">$_ICON $myalbum_button_goto_font</a>";
		}
	}
	$show_onload_javascript="onkeypress=\"return noGlobalEnterKey(event)\"";
	$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/show_myalbum_photo.html");
	print_header_and_footer();
	
	//--------------------------------------------------------------------------------------
	function get_page_count_number2($page,$b){
		global $step,$next_step,$row_number;
			
		$url="$ecard_url/index.php?step=$step&next_step=$next_step&what=photo&row_number=$row_number";
		$count_number ="";
		
		$y=0;
		if ($b <10){
			for($a_num=1; $a_num<=$b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";					
				}
				else {
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
		}
		elseif(($page > 3) && ($page < ($b-3))){
			for($a_num=1; $a_num<=3; $a_num++) {
				$y++;
				$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
			}
			$count_number .="...";
			for($a_num = $page-1; $a_num<=$page+1; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";
				}
				else {		
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
			$count_number .="...";
			for($a_num = $b-2; $a_num<=$b; $a_num++) {
				$y++;
				$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
			}
		}
		else{
			for($a_num=1; $a_num<=4; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";
				}
				else {
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
			$count_number .="...";			
			for($a_num=$b-3; $a_num<=$b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";
				}
				else {	
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
		}
		set_global_var("d_num",$b);
		return $count_number;
	}
	
	//--------------------------------------------------------------------------------------
	function get_page_count_number4($page,$b){
		global $step,$next_step,$row_number,$ecard_url;
			
		$url="$ecard_url/index.php?step=$step&next_step=$next_step&what=photo&row_number=$row_number";
		$count_number ="";
		
		$y=0;
		if ($b <10){
			for($a_num=1; $a_num<=$b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";					
				}
				else {
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
		}
		elseif(($page > 3) && ($page < ($b-3))){
			for($a_num=1; $a_num<=3; $a_num++) {
				$y++;
				$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
			}
			$count_number .="...";
			for($a_num = $page-1; $a_num<=$page+1; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";
				}
				else {		
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
			$count_number .="...";
			for($a_num = $b-2; $a_num<=$b; $a_num++) {
				$y++;
				$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
			}
		}
		else{
			for($a_num=1; $a_num<=4; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";
				}
				else {
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
			$count_number .="...";			
			for($a_num=$b-3; $a_num<=$b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";
				}
				else {	
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
		}
		set_global_var("d_num",$b);
		return $count_number;
	}
	
	//--------------------------------------------------------------------------------------
	function get_page_count_number3($page,$b){
		global $step,$next_step,$row_number,$ecard_url,$album_id;
			
		$url="$ecard_url/index.php?step=$step&next_step=$next_step&what=photo&row_number=$row_number&album_id=$album_id";
		$count_number ="";
		
		$y=0;
		if ($b <10){
			for($a_num=1; $a_num<=$b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";					
				}
				else {
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
		}
		elseif(($page > 3) && ($page < ($b-3))){
			for($a_num=1; $a_num<=3; $a_num++) {
				$y++;
				$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
			}
			$count_number .="...";
			for($a_num = $page-1; $a_num<=$page+1; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";
				}
				else {		
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
			$count_number .="...";
			for($a_num = $b-2; $a_num<=$b; $a_num++) {
				$y++;
				$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
			}
		}
		else{
			for($a_num=1; $a_num<=4; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";
				}
				else {
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
			$count_number .="...";			
			for($a_num=$b-3; $a_num<=$b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>$a_num</span>";
				}
				else {	
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">$a_num</a>";
				}
			}
		}
		set_global_var("d_num",$b);
		return $count_number;
	}
?>