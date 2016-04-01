<?php
/*
+--------------------------------------------------------------------------
|
|	WARNING: REMOVING THIS COPYRIGHT HEADER IS EXPRESSLY FORBIDDEN
|
|   ECardMax Version 10.5 Full Version
|   ========================================
|   (c) 1999 - 2016 ECARDMAX.COM - All right reserved 
|	Software For Website, Inc.
|   http://www.ecardmax.com 
|   ========================================
|   Email: webmaster@ecardmax.com
|   Purchase Info: http://www.ecardmax.com/index.php?step=Purchase
|   Request Installation: http://www.ecardmax.com/ehelpmax/index.php
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
	if(ECARDMAX!=1)exit;
	if ($admin_login != $crypt_pass){
		//Show login page
		print get_html_from_layout("admin/html/show_login.html");
		exit;
	}	

	if($what=="add_new"){		
		//Upload file
		$upload_dir ="$ecard_root/resource/picture/$cat_dir";
		$number_card = 0;
		for($i=1;$i<=7;$i++){
			$file_key_thumb = "thumb_file$i";
			$file_key_full = "full_file$i";
			$new_name = substr(md5(uniqid(rand(),1)), 0, 10);
			$file_name_thumb = strtolower($POST_FILES[$file_key_thumb]['name']);	
			$file_thumb_size = $POST_FILES[$file_key_thumb]['size'];

			if(!(strpos($file_name_thumb,".gif")===false)){ //If .gif 
				$file_name_thumb = $new_name ."_thumb.gif";
			}
			elseif(!(strpos($file_name_thumb,".jpg")===false)){ //If .jpg
				$file_name_thumb = $new_name ."_thumb.jpg";
			}
			elseif(!(strpos($file_name_thumb,".png")===false)){ //If .png
				$file_name_thumb = $new_name ."_thumb.png";
			}
			$ec_thumbnail = $file_name_thumb;

			$file_name_full = strtolower($POST_FILES[$file_key_full]['name']);
			$file_full_size = $POST_FILES[$file_key_full]['size'];
			if(!(strpos($file_name_full,".gif")===false)){ //If .gif 
				$file_name_full = $new_name .".gif";					
			}
			elseif(!(strpos($file_name_full,".jpg")===false)){ //If .jpg
				$file_name_full = $new_name .".jpg";
			}
			elseif(!(strpos($file_name_full,".swf")===false)){ //If .Flash
				$file_name_full = $new_name .".swf";
			}
			elseif(!(strpos($file_name_full,".mov")===false)){ //If .QuickTime
				$file_name_full = $new_name .".mov";
			}
			elseif(!(strpos($file_name_full,".m4v")===false)){ //If .QuickTime
				$file_name_full = $new_name .".m4v";
			}
			elseif(!(strpos($file_name_full,".mp4")===false)){ //If .QuickTime
				$file_name_full = $new_name .".mp4";
			}
			elseif(!(strpos($file_name_full,".dcr")===false)){ //If .Shockware
				$file_name_full = $new_name .".dcr";
			}
			elseif(!(strpos($file_name_full,".html")===false)){ //If .QuickTime
				$file_name_full = $new_name .".html";
				$field_value ="('$file_name_full','$file_name_thumb',$cat_id,'$cat_dir','$cat_name_display',$gmt_timestamp_now,'28119998,ee187fd5','$ec_group_relate_id','')";
				$field_name ="(ec_filename,ec_thumbnail,ec_cat_id,ec_cat_dir,ec_cat_name_display,ec_time,ec_cat_relate_id,ec_group_relate_id,ec_user_name_id)";
				insert_data_to_db1("max_ecard",$field_name,$field_value);
			}
			elseif(!(strpos($file_name_full,".png")===false)){ //If .png
				$file_name_full = $new_name .".png";
			}
			$ec_filename=$file_name_full;
						
			$file_upload_thumb = $upload_dir."/".$file_name_thumb;
			$file_upload_full = $upload_dir."/".$file_name_full;
			$ec_private = $cf_new_card_for_free;
			$ec_time = $time_stamp_now_admin;
			
			if($file_thumb_size > 0 && $file_full_size > 0){
				if (!file_exists($file_upload_thumb) && !file_exists($file_upload_full)){
					$number_card ++;
					move_uploaded_file($POST_FILES[$file_key_thumb]['tmp_name'],$file_upload_thumb);
					chmod($file_upload_thumb,0777);

					move_uploaded_file($POST_FILES[$file_key_full]['tmp_name'],$file_upload_full);
					chmod($file_upload_full,0777);

					//Resize full size image if image width > 500
					$image_info = getimagesize($file_upload_full);
					$type=$image_info['mime'];
					$img_width =$image_info[0];
					$img_height=$image_info[1];
					if($type =="image/jpeg" || $type =="image/gif" || $type =="image/png"){
						if($img_width > get_global_var(cf_max_image_width))
							resize_myimage($type,$file_upload_full,$file_upload_full,"full");							
					}
				}
			}
			elseif($file_thumb_size <= 0 && $file_full_size > 0){
				if(!(strpos($file_name_full,".gif")===false) || !(strpos($file_name_full,".jpg")===false) || !(strpos($file_name_full,".png")===false)){
					$number_card ++;
					move_uploaded_file($POST_FILES[$file_key_full]['tmp_name'],$file_upload_full);
					chmod($file_upload_full,0777);

					//Resize full size image if image width > 500
					$image_info = getimagesize($file_upload_full);
					$type=$image_info['mime'];
					$img_width =$image_info[0];
					$img_height=$image_info[1];
					if($type =="image/jpeg" || $type =="image/gif" || $type =="image/png"){
						if($img_width > get_global_var(cf_max_image_width))
							resize_myimage($type,$file_upload_full,$file_upload_full,"full");							
					}
				}
			}
		}
		$show_info=load_ecard_2db($cat_id);
		$what="";
		set_global_var("what","");
	}
	/*---------youtube link------------*/
	elseif($what=="add_youtube_link")
	{
		for($i=1;$i<=3;$i++){
			$youtube_link_i= ("youtube_link" . $i);
			$youtube_link=$$youtube_link_i;
			if($youtube_link!=""){
				$field_value ="('$youtube_link','',$cat_id,'$cat_dir','$cat_name_display',$gmt_timestamp_now,'28119998,ee187fd5','$ec_group_relate_id','')";
				$field_name ="(ec_filename,ec_thumbnail,ec_cat_id,ec_cat_dir,ec_cat_name_display,ec_time,ec_cat_relate_id,ec_group_relate_id,ec_user_name_id)";
				insert_data_to_db1("max_ecard",$field_name,$field_value);
			}
			$youtube_link="";
		}
	}
	
	/*---------end---------------------*/
	elseif($what=="set_card_points"){
		update_field_in_db("max_ecard","ec_points","$ec_points","ec_id='$ec_id' LIMIT 1");
		exit;
	}
	elseif($what=="delete_selected"){				
		$sql_where="";
		$array_list_id=split(",",$list_id);
		foreach($array_list_id as $ec_id){
			if($ec_id!=""){
				$sql_where .="ec_id='$ec_id',";
			}
		}
		if($sql_where{strlen($sql_where)-1} ==",") $sql_where = substr($sql_where, 0, strlen($sql_where)-1);
		$sql_where=str_replace(","," or ",$sql_where);
		$list_selected =set_array_from_query("max_ecard","ec_id,ec_filename,ec_thumbnail,ec_cat_dir"," $sql_where ");
		foreach($list_selected as $row_data){
			//if youtube link
			if($row_data[ec_thumbnail]==""){
				delete_row("max_ecard","ec_id='$row_data[ec_id]' LIMIT 1");
				$fav_list=get_dblistvalue("max_favorite","fv_id","fv_ec_id ='$row_data[ec_id]' ");	
				foreach($fav_list as $item2){
				delete_row("max_favorite","fv_id='$item2' LIMIT 1");
				}
	
				$ecard_add_remove_message_card_has_been_deleted=str_replace("%ec_id%",$row_data[ec_id],$ecard_add_remove_message_card_has_been_deleted);
				$show_info .="<span class=\"OK_Message\">$ecard_add_remove_message_card_has_been_deleted</span><br />";	
			}
			else{	
				if((is_writable("$ecard_root/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_filename]") && is_writable("$ecard_root/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_thumbnail]")) || (!file_exists($ecard_root/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_filename]) && !file_exists("$ecard_root/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_thumbnail]") )){
					$count_same_card=get_dbvalue("max_ecard","count(ec_id)","ec_filename='$row_data[ec_filename]' and ec_thumbnail='$row_data[ec_thumbnail]' and ec_id<>'$row_data[ec_id]'");
					if($count_same_card=="0"){
						//Permission OK & no cross over card -> delete thumb + fullsize and row database
						@unlink("$ecard_root/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_filename]");
						@unlink("$ecard_root/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_thumbnail]");					
					}
					//Delete row in database
					delete_row("max_ecard","ec_id='$row_data[ec_id]' LIMIT 1");
	
					//Delete fv_id inside max_favorite 
					$fav_list=get_dblistvalue("max_favorite","fv_id","fv_ec_id ='$row_data[ec_id]' ");	
					foreach($fav_list as $item2){
						delete_row("max_favorite","fv_id='$item2' LIMIT 1");
					}
	
					$ecard_add_remove_message_card_has_been_deleted=str_replace("%ec_id%",$row_data[ec_id],$ecard_add_remove_message_card_has_been_deleted);
					$show_info .="<span class=\"OK_Message\">$ecard_add_remove_message_card_has_been_deleted</span><br />";
				}
				else{
					//Permission denied -> can't delete card so we have to set them inactive 
					update_field_in_db("max_ecard","ec_active","0","ec_id='$row_data[ec_id]' LIMIT 1");
					$ecard_add_remove_message_server_cant_delete_card=str_replace("%ec_id%",$row_data[ec_id],$ecard_add_remove_message_server_cant_delete_card);
					$ecard_add_remove_message_server_cant_delete_card=str_replace("%ec_filename%","resource/picture/$row_data[ec_cat_dir]/$row_data[ec_filename]",$ecard_add_remove_message_server_cant_delete_card);
					$show_info .="<span class=\"Error_Message\">$ecard_add_remove_message_server_cant_delete_card</span><br />";
				}
			}
		}
		RefreshSortOrder();
		$what="";
		set_global_var("what","");
	}
	elseif($what=="set_card_mg"){
		if($action=="add"){			
			$current_ec_group_relate_id="$ec_group_relate_id," . get_dbvalue("max_ecard","ec_group_relate_id","ec_id='$ec_id'");
			$array=split(",",$current_ec_group_relate_id);
			$array=array_unique($array);
			foreach($array as $eachid){
				if($eachid!="")$new_ec_group_relate_id.="$eachid,";
			}
			update_field_in_db("max_ecard","ec_group_relate_id",",".$new_ec_group_relate_id,"ec_id='$ec_id' LIMIT 1");			
		}
		else{
			$current_ec_group_relate_id=get_dbvalue("max_ecard","ec_group_relate_id","ec_id='$ec_id'");
			$array=split(",",$current_ec_group_relate_id);
			foreach($array as $eachid){
				if($eachid!="" && $eachid!=$ec_group_relate_id){
					$new_ec_group_relate_id.="$eachid,";
				}
			}
			update_field_in_db("max_ecard","ec_group_relate_id",",".$new_ec_group_relate_id,"ec_id='$ec_id' LIMIT 1");
		}
		exit;
	}
	elseif($what=="load_ecard_2db"){
		$show_info=load_ecard_2db($cat_id);
		RefreshSortOrder();
		$what="";
		set_global_var("what","");
	}
	elseif($what=="set_member_group_all_ecards"){
		if($ec_group_relate_id!="" && $cat_id!=""){
			$list_all_ecards=get_dblistvalue("max_ecard","ec_id","ec_cat_id='$cat_id' and ec_user_name_id=''");
			foreach($list_all_ecards as $ec_id){
				update_field_in_db("max_ecard","ec_group_relate_id",$ec_group_relate_id,"ec_id='$ec_id' LIMIT 1");
			}
		}
		$what="";
		set_global_var("what","");
	}
	elseif($what=="set_price_all_ecards"){
		if(($ppc_id>0 || $ppc_id=="0.00") && $cat_id!=""){
			$list_all_ecards=get_dblistvalue("max_ecard","ec_id","ec_cat_id='$cat_id' and ec_user_name_id=''");
			foreach($list_all_ecards as $ec_id){
				update_field_in_db("max_ecard","ec_ppc_id",$ppc_id,"ec_id='$ec_id' LIMIT 1");
				//update_field_in_db("max_ecard","ec_points",$ppc_id,"ec_id='$ec_id' LIMIT 1");
			}
		}
		$what="";
		set_global_var("what","");
	}
	elseif($what=="set_sort_order"){
		$list_sort=set_array_from_query("max_ecard","ec_id,ec_order","ec_user_name_id='' and ec_cat_id='$cat_id' Order by ec_active DESC,ec_order,ec_id");		
		foreach($list_sort as $array_sort){
			if($current_sort > $sort_number){
				if($array_sort[ec_order]>=$sort_number){			
					update_field_in_db("max_ecard","ec_order",$array_sort[ec_order]+1,"ec_id='$array_sort[ec_id]' LIMIT 1");
				}
			}
			else{
				if($array_sort[ec_order]<=$sort_number){			
					update_field_in_db("max_ecard","ec_order",$array_sort[ec_order]-1,"ec_id='$array_sort[ec_id]' LIMIT 1");
				}
			}
		}		
		update_field_in_db("max_ecard","ec_order",$sort_number,"ec_id='$ec_id' LIMIT 1");
		
		RefreshSortOrder();
		$what="";
		set_global_var("what","");
	}
	elseif($what=="move_selected"){
		if($cat_id==$current_cat_id)$cat_id="";

		if($cat_id==""){//Main category
			$list_data=set_array_from_query("max_category","*","cat_parent='' Order by cat_order,cat_name_display");
		}
		else{
			$cat_row=get_row("max_category","*","cat_id='$cat_id'");
			$list_data=set_array_from_query("max_category","*","cat_parent='$cat_row[cat_dir]' Order by cat_order,cat_name_display");
		}

		//Show cat navigator
		$array=split(",",$cat_row[cat_relate_id]);
		$where="";
		foreach($array as $cat_dir_id){
			$where .="cat_dir_id='$cat_dir_id',";
		}
		if($where{strlen($where)-1} ==",") $where = substr($where, 0, strlen($where)-1);
		$where=str_replace(","," or ",$where);
		$list_array=set_array_from_query("max_category","cat_id,cat_dir_id,cat_name_display","$where");
		$show_cat_nav="";		
		foreach($array as $cat_dir_id){
			$show_cat_nav_tmp="";
			foreach($list_array as $array_nav){
				if($cat_dir_id==$array_nav[cat_dir_id]){
					$array_nav[cat_name_display]=str_replace("|","/",$array_nav[cat_name_display]);
					$show_cat_nav_tmp .= " <a href=\"index.php?step=$step&cat_id=$array_nav[cat_id]&current_cat_id=$current_cat_id&list_id=$list_id&what=move_selected\">$array_nav[cat_name_display]</a>|";
				}
			}
			$show_cat_nav .= $show_cat_nav_tmp;
		}
		if($show_cat_nav{strlen($show_cat_nav)-1} =="|") $show_cat_nav = substr($show_cat_nav, 0, strlen($show_cat_nav)-1);		
		$show_cat_nav=str_replace("|"," <img border=\"0\" alt=\"\" src=\"html/2rightarrow12.gif\" />",$show_cat_nav);
		set_global_var("show_cat_nav",$show_cat_nav);

		foreach($list_data as $row_data){
			$val = $row_data[cat_id] ;
						
			//Detect sub category
			$chk_sub=get_dbvalue("max_category","count(cat_id)","cat_relate_id like '%$row_data[cat_dir_id]%'") - 1;
			if($chk_sub > 0){
				if($current_cat_id==$val){
					$show_folder_icon="<img border=\"0\" alt=\"$ecard_add_remove_tooltip_current_category\" title=\"$ecard_add_remove_tooltip_current_category\" src=\"html/07_icon_stop.gif\" /> $row_data[cat_name_display]";
					$show_list_table .="<tr id=\"tr$val\" style=\"background-image: url(html/07_title_background2.gif);line-height:20px\">\n";		
					$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" title=\"$ecard_add_remove_tooltip_current_category\" onclick=\"alert('$ecard_add_remove_tooltip_current_category')\">$show_folder_icon</td>\n";
					$show_list_table .="</tr>\n";
				}
				else{
					$ecard_add_remove_tooltip_click_here_to_open_category=str_replace("%cat_name_display%",$row_data[cat_name_display],$ecard_add_remove_tooltip_click_here_to_open_category);
					$show_folder_icon="<img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_open_category\" title=\"$ecard_add_remove_tooltip_click_here_to_open_category\" src=\"html/07_icon_open_folder.gif\" /> $row_data[cat_name_display]";
					$show_list_table .="<tr id=\"tr$val\" style=\"background-image: url(html/07_title_background2.gif);line-height:20px\">\n";		
					$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" onclick=\"location.href='index.php?step=$step&what=move_selected&current_cat_id=$current_cat_id&cat_id=$val&list_id=$list_id';\">$show_folder_icon</td>\n";
					$show_list_table .="</tr>\n";
				}
			}
			else{
				if($current_cat_id==$val){
					$show_folder_icon="<img border=\"0\" alt=\"$ecard_add_remove_tooltip_current_category\" title=\"$ecard_add_remove_tooltip_current_category\" src=\"html/07_icon_stop.gif\" /> $row_data[cat_name_display]";
					$show_list_table .="<tr id=\"tr$val\" style=\"background-image: url(html/07_title_background2.gif);line-height:20px\">\n";		
					$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" title=\"$ecard_add_remove_tooltip_current_category\" onclick=\"alert('$ecard_add_remove_tooltip_current_category')\">$show_folder_icon</td>\n";
					$show_list_table .="</tr>\n";
				}
				else{
					$ecard_add_remove_tooltip_click_here_to_open_category=str_replace("%cat_name_display%",$row_data[cat_name_display],$ecard_add_remove_tooltip_click_here_to_open_category);
					$show_folder_icon="<img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_open_category\" title=\"$ecard_add_remove_tooltip_click_here_to_open_category\" src=\"html/07_icon_open_folder_empty.gif\" /> $row_data[cat_name_display]";
					$show_list_table .="<tr id=\"tr$val\" style=\"background-image: url(html/07_title_background2.gif);line-height:20px\">\n";		
					$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" onclick=\"location.href='index.php?step=$step&what=move_selected&current_cat_id=$current_cat_id&cat_id=$val&list_id=$list_id';\">$show_folder_icon</td>\n";
					$show_list_table .="</tr>\n";
				}				
			}			
		}		
		
		if($cat_id==""){
			$show_list_table .="<tr id=\"tr$val\" style=\"background-color: white;line-height:20px;font-weight:bold\">\n";		
			$ecard_add_remove_txt_please_select_a_category_to_move=str_replace("%list_id%",$list_id,$ecard_add_remove_txt_please_select_a_category_to_move);
			$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\">$ecard_add_remove_txt_please_select_a_category_to_move</td>\n";
			$show_list_table .="</tr>\n";
		}
		else{
			$show_list_table .="<tr id=\"tr$val\" style=\"background-color: white;line-height:20px;font-weight:bold\">\n";		
			$ecard_add_remove_txt_click_here_to_move_selected_cards=str_replace("%cat_name_display%",$cat_row[cat_name_display],$ecard_add_remove_txt_click_here_to_move_selected_cards);
			$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" onclick=\"location.href='index.php?step=$step&what=move_selected2&cat_id=$cat_id&current_cat_id=$current_cat_id&list_id=$list_id';\"><img alt=\"\" border=\"0\" src=\"html/07_icon_open_folder.gif\" /> <span style=\"color:green\">$cat_row[cat_name_display]</span> || <span style=\"text-decoration:underline;\">$ecard_add_remove_txt_click_here_to_move_selected_cards</span></td>\n";
			$show_list_table .="</tr>\n";
		}
		set_global_var("show_list_table",$show_list_table);
		print get_html_from_layout("admin/html/admin_manage_ecard_move_ecards.html");			
		exit;
	}
	elseif($what=="move_selected2"){
		$sql_where="";
		$array_list_id=split(",",$list_id);
		foreach($array_list_id as $ec_id){
			if($ec_id!=""){
				$sql_where .="ec_id='$ec_id',";
			}
		}
		if($sql_where{strlen($sql_where)-1} ==",") $sql_where = substr($sql_where, 0, strlen($sql_where)-1);
		$sql_where=str_replace(","," or ",$sql_where);
		$list_selected =set_array_from_query("max_ecard","*"," $sql_where ");
		$cat_row=get_row("max_category","*","cat_id='$cat_id'");
		foreach($list_selected as $row_data){
			if($cat_id != $row_data[ec_cat_id] && $row_data[ec_user_name_id]==""){
				//Move files
				if(@rename("$ecard_root/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_thumbnail]", "$ecard_root/resource/picture/$cat_row[cat_dir]/$row_data[ec_thumbnail]") && @rename("$ecard_root/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_filename]", "$ecard_root/resource/picture/$cat_row[cat_dir]/$row_data[ec_filename]") ){
					update_field_in_db2("max_ecard","ec_cat_name_display='$cat_row[cat_name_display]',ec_cat_id='$cat_row[cat_id]',ec_cat_dir='$cat_row[cat_dir]',ec_cat_relate_id='$cat_row[cat_relate_id]'","ec_id='$row_data[ec_id]' LIMIT 1");
					$ecard_add_remove_mesage_images_have_been_moved=str_replace("%cat_name_display%",$cat_row[cat_name_display],$ecard_add_remove_mesage_images_have_been_moved);
					$show_info .= "<div class=\"OK_Message\">$ecard_add_remove_mesage_images_have_been_moved</div>";
				}
				else{
					$ecard_add_remove_mesage_permission_denied_cant_move_selected_cards=str_replace("%cat_dir%","resource/picture/$cat_row[cat_dir]",$ecard_add_remove_mesage_permission_denied_cant_move_selected_cards);
					$show_info .= "<div class=\"Error_Message\">$ecard_add_remove_mesage_permission_denied_cant_move_selected_cards</div>";
				}				
			}
		}				
		$cat_id=$current_cat_id;
		RefreshSortOrder();
		$what="";
		set_global_var("what","");
	}
	elseif($what=="copy_selected"){
		if($cat_id==$current_cat_id)$cat_id="";

		if($cat_id==""){//Main category
			$list_data=set_array_from_query("max_category","*","cat_parent='' Order by cat_order,cat_name_display");
		}
		else{
			$cat_row=get_row("max_category","*","cat_id='$cat_id'");
			$list_data=set_array_from_query("max_category","*","cat_parent='$cat_row[cat_dir]' Order by cat_order,cat_name_display");
		}

		//Show cat navigator
		$array=split(",",$cat_row[cat_relate_id]);
		$where="";
		foreach($array as $cat_dir_id){
			$where .="cat_dir_id='$cat_dir_id',";
		}
		if($where{strlen($where)-1} ==",") $where = substr($where, 0, strlen($where)-1);
		$where=str_replace(","," or ",$where);
		$list_array=set_array_from_query("max_category","cat_id,cat_dir_id,cat_name_display","$where");
		$show_cat_nav="";		
		foreach($array as $cat_dir_id){
			$show_cat_nav_tmp="";
			foreach($list_array as $array_nav){
				if($cat_dir_id==$array_nav[cat_dir_id]){
					$array_nav[cat_name_display]=str_replace("|","/",$array_nav[cat_name_display]);
					$show_cat_nav_tmp .= " <a href=\"index.php?step=$step&cat_id=$array_nav[cat_id]&current_cat_id=$current_cat_id&list_id=$list_id&what=copy_selected\">$array_nav[cat_name_display]</a>|";
				}
			}
			$show_cat_nav .= $show_cat_nav_tmp;
		}
		if($show_cat_nav{strlen($show_cat_nav)-1} =="|") $show_cat_nav = substr($show_cat_nav, 0, strlen($show_cat_nav)-1);		
		$show_cat_nav=str_replace("|"," <img border=\"0\" alt=\"\" src=\"html/2rightarrow12.gif\" />",$show_cat_nav);
		set_global_var("show_cat_nav",$show_cat_nav);

		foreach($list_data as $row_data){
			$val = $row_data[cat_id] ;
						
			//Detect sub category
			$chk_sub=get_dbvalue("max_category","count(cat_id)","cat_relate_id like '%$row_data[cat_dir_id]%'") - 1;
			if($chk_sub > 0){
				if($current_cat_id==$val){
					$show_folder_icon="<img border=\"0\" alt=\"$ecard_add_remove_tooltip_current_category\" title=\"$ecard_add_remove_tooltip_current_category\" src=\"html/07_icon_stop.gif\" /> $row_data[cat_name_display]";
					$show_list_table .="<tr id=\"tr$val\" style=\"background-image: url(html/07_title_background2.gif);line-height:20px\">\n";		
					$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" title=\"$ecard_add_remove_tooltip_current_category\" onclick=\"alert('$ecard_add_remove_tooltip_current_category')\">$show_folder_icon</td>\n";
					$show_list_table .="</tr>\n";
				}
				else{
					$ecard_add_remove_tooltip_click_here_to_open_category=str_replace("%cat_name_display%",$row_data[cat_name_display],$ecard_add_remove_tooltip_click_here_to_open_category);
					$show_folder_icon="<img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_open_category\" title=\"$ecard_add_remove_tooltip_click_here_to_open_category\" src=\"html/07_icon_open_folder.gif\" /> $row_data[cat_name_display]";
					$show_list_table .="<tr id=\"tr$val\" style=\"background-image: url(html/07_title_background2.gif);line-height:20px\">\n";		
					$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" onclick=\"location.href='index.php?step=$step&what=copy_selected&current_cat_id=$current_cat_id&cat_id=$val&list_id=$list_id';\">$show_folder_icon</td>\n";
					$show_list_table .="</tr>\n";
				}
			}
			else{
				if($current_cat_id==$val){
					$show_folder_icon="<img border=\"0\" alt=\"$ecard_add_remove_tooltip_current_category\" title=\"$ecard_add_remove_tooltip_current_category\" src=\"html/07_icon_stop.gif\" /> $row_data[cat_name_display]";
					$show_list_table .="<tr id=\"tr$val\" style=\"background-image: url(html/07_title_background2.gif);line-height:20px\">\n";		
					$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" title=\"$ecard_add_remove_tooltip_current_category\" onclick=\"alert('$ecard_add_remove_tooltip_current_category')\">$show_folder_icon</td>\n";
					$show_list_table .="</tr>\n";
				}
				else{
					$ecard_add_remove_tooltip_click_here_to_open_category=str_replace("%cat_name_display%",$row_data[cat_name_display],$ecard_add_remove_tooltip_click_here_to_open_category);
					$show_folder_icon="<img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_open_category\" title=\"$ecard_add_remove_tooltip_click_here_to_open_category\" src=\"html/07_icon_open_folder_empty.gif\" /> $row_data[cat_name_display]";
					$show_list_table .="<tr id=\"tr$val\" style=\"background-image: url(html/07_title_background2.gif);line-height:20px\">\n";		
					$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" onclick=\"location.href='index.php?step=$step&what=copy_selected&current_cat_id=$current_cat_id&cat_id=$val&list_id=$list_id';\">$show_folder_icon</td>\n";
					$show_list_table .="</tr>\n";
				}				
			}			
		}		
		
		if($cat_id==""){
			$show_list_table .="<tr id=\"tr$val\" style=\"background-color: white;line-height:20px;font-weight:bold\">\n";		
			$ecard_add_remove_txt_please_select_a_category_to_copy=str_replace("%list_id%",$list_id,$ecard_add_remove_txt_please_select_a_category_to_copy);
			$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\">$ecard_add_remove_txt_please_select_a_category_to_copy</td>\n";
			$show_list_table .="</tr>\n";
		}
		else{
			$show_list_table .="<tr id=\"tr$val\" style=\"background-color: white;line-height:20px;font-weight:bold\">\n";		
			$ecard_add_remove_txt_click_here_to_copy_selected_cards=str_replace("%cat_name_display%",$cat_row[cat_name_display],$ecard_add_remove_txt_click_here_to_copy_selected_cardss);
			$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" onclick=\"location.href='index.php?step=$step&what=copy_selected2&cat_id=$cat_id&current_cat_id=$current_cat_id&list_id=$list_id';\"><img alt=\"\" border=\"0\" src=\"html/07_icon_open_folder.gif\" /> <span style=\"color:green\">$cat_row[cat_name_display]</span> || <span style=\"text-decoration:underline;\">$ecard_add_remove_txt_click_here_to_copy_selected_cards</span></td>\n";
			$show_list_table .="</tr>\n";
		}
		set_global_var("show_list_table",$show_list_table);
		print get_html_from_layout("admin/html/admin_manage_ecard_copy_ecards.html");
		exit;
	}
	elseif($what=="copy_selected2"){
		$sql_where="";
		$array_list_id=split(",",$list_id);
		foreach($array_list_id as $ec_id){
			if($ec_id!=""){
				$sql_where .="ec_id='$ec_id',";
			}
		}
		if($sql_where{strlen($sql_where)-1} ==",") $sql_where = substr($sql_where, 0, strlen($sql_where)-1);
		$sql_where=str_replace(","," or ",$sql_where);
		$list_selected =set_array_from_query("max_ecard","*"," $sql_where ");
		$cat_row=get_row("max_category","*","cat_id='$cat_id'");
		foreach($list_selected as $row_data){
			$field_name ="(";
			$field_value="(";
			foreach($row_data as $col=>$col_value){
				if($col!="ec_id"){
					$field_name .="$col,";
					if($col=="ec_cat_id")$col_value=$cat_row[cat_id];
					if($col=="ec_cat_name_display")$col_value=$cat_row[cat_name_display];
					if($col=="ec_cat_relate_id")$col_value=$cat_row[cat_relate_id];
					$col_value=str_replace("'","''",$col_value);
					$field_value .="'$col_value',";
				}
			}
			$field_name .=")";
			$field_value .=")";
			$field_name=str_replace(",)",")",$field_name);
			$field_value=str_replace(",)",")",$field_value);

			if($cat_id != $row_data[ec_cat_id] && $row_data[ec_user_name_id]==""){
				//Copy ec_id
				insert_data_to_db("max_ecard",$field_name,$field_value);
			}
		}
		$ecard_add_remove_message_selected_images_have_been_copied=str_replace("%cat_name_display%",$cat_row[cat_name_display],$ecard_add_remove_message_selected_images_have_been_copied);
		$show_info .= "<div class=\"OK_Message\">$ecard_add_remove_message_selected_images_have_been_copied</div>";
		$cat_id=$current_cat_id;
		RefreshSortOrder();
		$what="";
		set_global_var("what","");
	}
	elseif($what=="change_selected"){
		$sql_where="";
		$array_list_id=split(",",$list_id);
		foreach($array_list_id as $ec_id){
			if($ec_id!=""){
				$sql_where .="ec_id='$ec_id',";
			}
		}
		if($sql_where{strlen($sql_where)-1} ==",") $sql_where = substr($sql_where, 0, strlen($sql_where)-1);
		$sql_where=str_replace(","," or ",$sql_where);
		$list_selected =set_array_from_query("max_ecard","*"," $sql_where ");
		foreach($list_selected as $row_data){
			$dummy=substr(md5(uniqid(rand(),1)), 0, 10);
			$thumbpath ="$ecard_url/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_thumbnail]?$dummy";
			$list_table_img .="<div style=\"margin-left:30px;width:500px;\">";
			$list_table_img .="<table width=\"100%\" style=\"background-color:silver\" cellspacing=\"1\" cellpadding=\"4\">";
			$list_table_img .="<tr style=\"background-color: #EAEAEA;line-height:17px\"><td colspan=\"2\" style=\"padding:4px;line-height:20px;background-image: url(html/07_title_background.gif);font-weight:bold\">Card ID #: $row_data[ec_id]</td></tr>";
			$list_table_img .="<tr style=\"background-color: #EAEAEA;line-height:17px\"><td width=\"25%\"><img border=\"0\" alt=\"\" src=\"$thumbpath\" /><br /><br />$row_data[ec_thumbnail]<br />$row_data[ec_filename]</td>";
			$ecard_add_remove_txt_new_thumbnail=str_replace("%ec_thumbnail%",$ec_thumbnail,$ecard_add_remove_txt_new_thumbnail);
			$ecard_add_remove_txt_new_fullsize=str_replace("%ec_filename%",$ec_filename,$ecard_add_remove_txt_new_fullsize);
			$list_table_img .="<td width=\"65%\"><p>$ecard_add_remove_txt_new_thumbnail<br /><input type=\"file\" name=\"thumb_file$row_data[ec_id]\" size=\"30\"><p>$ecard_add_remove_txt_new_fullsize<br /><input type=\"file\" name=\"full_file$row_data[ec_id]\" size=\"30\"></td></tr>";
			$list_table_img .="<table width=\"100%\">";
			$list_table_img .="</table>";
			$list_table_img .="</div><br />";
		}
		set_global_var("show_list_table",$show_list_table);
		print get_html_from_layout("admin/html/admin_manage_ecard_edit_ecards.html");
		exit;

	}
	elseif($what=="change_selected2"){
		$upload_dir ="$ecard_root/resource/picture";
		$sql_where="";
		$array_list_id=split(",",$list_id);
		foreach($array_list_id as $ec_id){
			if($ec_id!=""){
				$sql_where .="ec_id='$ec_id',";
			}
		}
		if($sql_where{strlen($sql_where)-1} ==",") $sql_where = substr($sql_where, 0, strlen($sql_where)-1);
		$sql_where=str_replace(","," or ",$sql_where);
		$list_selected =set_array_from_query("max_ecard","*"," $sql_where ");
		foreach($list_selected as $row_imgchange){
			$i=$row_imgchange[ec_id];
			$ec_thumbnail_info =split("\.",$row_imgchange[ec_thumbnail]);
			$ec_filename_info =split("\.",$row_imgchange[ec_filename]);

			$ext_thumb = $ec_thumbnail_info[1];
			$ext_full = $ec_filename_info[1];

			$file_key_thumb = "thumb_file$i";
			$file_key_full = "full_file$i";
			
			$file_name_thumb = strtolower($POST_FILES[$file_key_thumb]['name']);	
			$file_thumb_size = $POST_FILES[$file_key_thumb]['size'];
			$file_name_thumb =$row_imgchange[ec_thumbnail];				
			$ec_thumbnail = $file_name_thumb;

			$file_name_full = strtolower($POST_FILES[$file_key_full]['name']);
			$file_full_size = $POST_FILES[$file_key_full]['size'];
			$ec_filename=$file_name_full;
			$file_name_full =$row_imgchange[ec_filename];
			
			$file_upload_thumb = $upload_dir."/".$row_imgchange[ec_cat_dir]."/".$file_name_thumb;
			$file_upload_full = $upload_dir."/".$row_imgchange[ec_cat_dir]."/".$file_name_full;

			if(!(strpos($file_name_full,$ext_full)===false)){
				if($file_thumb_size > 0 && $file_full_size > 0){//If upload thumb + full
					//Delete old file
					@unlink("$ecard_root/resource/picture/$row_imgchange[ec_cat_dir]/$row_imgchange[ec_thumbnail]");
					@unlink("$ecard_root/resource/picture/$row_imgchange[ec_cat_dir]/$row_imgchange[ec_filename]");
					
					//Create new file					
					move_uploaded_file($POST_FILES[$file_key_thumb]['tmp_name'],$file_upload_thumb);
					chmod($file_upload_thumb,0777);

					move_uploaded_file($POST_FILES[$file_key_full]['tmp_name'],$file_upload_full);
					chmod($file_upload_full,0777);

					//Resize full size image if image width > 500
					$image_info = getimagesize($file_upload_full);
					$type=$image_info['mime'];
					$img_width =$image_info[0];
					$img_height=$image_info[1];
					if($type =="image/jpeg" || $type =="image/gif" || $type =="image/png"){
						if($img_width > $cf_max_image_width)
							resize_myimage($type,$file_upload_full,$file_upload_full,"full");							
					}
					
				}
				elseif($file_thumb_size <= 0 && $file_full_size > 0){ //Upload fullsize only --> auto create thumbnail
					if(!(strpos($file_name_full,".gif")===false) || !(strpos($file_name_full,".jpg")===false) || !(strpos($file_name_full,".png")===false)){
						move_uploaded_file($POST_FILES[$file_key_full]['tmp_name'],$file_upload_full);
						chmod($file_upload_full,0777);

						//Resize full size image if image width > 500
						$image_info = getimagesize($file_upload_full);
						$type=$image_info['mime'];
						$img_width =$image_info[0];
						$img_height=$image_info[1];
						if($type =="image/jpeg" || $type =="image/gif" || $type =="image/png"){
							if($img_width > $cf_max_image_width)
								resize_myimage($type,$file_upload_full,$file_upload_full,"full");							
						}

						//Create thumbnail
						if($img_width > $cf_thumb_width_member_card){
							resize_myimage($type,$file_upload_full,$file_upload_thumb,"thumb");
						}
						else{
							copy($file_upload_full, $file_upload_thumb);								
						}
					}
				}
			}
			else{
				$ecard_add_remove_message_error_card_id_will_be_skip=str_replace("%i%",$i,$ecard_add_remove_message_error_card_id_will_be_skip);
				$show_info .= "<div class=\"Error_Message\">$ecard_add_remove_message_error_card_id_will_be_skip</div>";
			}
		}
		$what="";
		set_global_var("what","");
	}
	
	if($cat_id==""){//Main category
		print $ecard_add_remove_message_you_must_select_a_category;
		exit;
	}

	$cat_row=get_row("max_category","*","cat_id='$cat_id'");
	$cat_dir=$cat_row[cat_dir];
	$cat_name_display=$cat_row[cat_name_display];

	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	set_global_var("row_number",$row_number);
	$row_per_page = $row_number;
				
	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;

	$list_data =set_array_from_query("max_ecard","*","ec_user_name_id='' and ec_cat_id='$cat_id' Order by ec_active DESC,ec_order,ec_id LIMIT $start,$row_per_page");
	$count_list=get_dbvalue("max_ecard","count(ec_id)","ec_user_name_id='' and ec_cat_id='$cat_id'");
	
	//Get list member group checkbox
	$list_mg=set_array_from_query("max_member_group","mg_id,mg_title");	

	//Get list pay per card
	$list_ppc=set_array_from_query("max_paypercard","ppc_id,ppc_amount","ppc_id<>'' Order by ppc_amount");	

	//Get language files
	$list_lang_file=get_list_file("$ecard_root/languages","_lang.php$");

	if ($end > $count_list) $end = $count_list;
	$show_list_table="";
	$xrow=0;
	for ($z=$start; $z<$end; $z++) {
		//$val = $list_data[$xrow][ec_id] ;
		$row_data=$list_data[$xrow];
		$val=$row_data[ec_id];
		$xrow++;
		//Show sort order dropdown menu
		$show_sort="<select style=\"font-size:8pt;\" size=\"1\" name=\"ec_order$val\" id=\"ec_order$val\" onchange=\"location.href='index.php?step=$step&what=set_sort_order&page=$page&row_number=$row_number&cat_id=$cat_id&ec_id=$val&current_sort=$row_data[ec_order]&sort_number='+this.value;\">";
		for($i=1;$i<=$count_list;$i++){
			if($row_data[ec_order]==$i){
				$show_sort.="<option value=\"$i\" selected=\"selected\">$i</option>\n";
			}
			else{
				$show_sort.="<option value=\"$i\" >$i</option>\n";
			}
		}
		$show_sort.="</select>";

		//Photo detail
		list($fullsize_width, $fullsize_height, $fullsize_type, $fullsize_attr) = @getimagesize("$ecard_root/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_filename]");

		//Show thumbnail and date added
		$dummy=substr(md5(uniqid(rand(),1)), 0, 10);
		$ec_time=DateFormat($row_data[ec_time],1);
		$ecard_add_remove_tooltip_card_id_click_to_preview_fullsize=str_replace("%ec_id%",$row_data[ec_id],$ecard_add_remove_tooltip_card_id_click_to_preview_fullsize);
		//if youtube link
		if($row_data[ec_thumbnail]=="")
		{
			$youtube_link=$row_data[ec_filename];;
			if(strpos($youtube_link,'&')!=0)
			{
				$vitri=strlen($youtube_link)-strpos($youtube_link,'&');
				$youtube_link_strim=substr($youtube_link,strpos($youtube_link,'v=')+2,-$vitri);
			}
			else
			{
				$youtube_link_strim=substr($youtube_link,strpos($youtube_link,'v=')+2);
			}
		
			//$show_thumbnail_and_date_add="<img onclick=\"HideItAll();HighLightCell('$val');self.parent.ShowFullsize('http://img.youtube.com/vi/$youtube_link_strim/0.jpg','$fullsize_width','$fullsize_height');\" border=\"0\" alt=\"$ecard_add_remove_tooltip_card_id_click_to_preview_fullsize\" title=\"$ecard_add_remove_tooltip_card_id_click_to_preview_fullsize\" src=\"http://img.youtube.com/vi/$youtube_link_strim/1.jpg\" style=\"border:1px solid silver;cursor:pointer;\" /><br /><span style=\"font-size:8pt\">$ecard_add_remove_txt_added_on_date:<br />$ec_time</span>";
			$show_thumbnail_and_date_add="<img onclick=\"HideItAll();HighLightCell('$val');self.parent.ShowFullsize('$youtube_link',0,0);\" border=\"0\" alt=\"$ecard_add_remove_tooltip_card_id_click_to_preview_fullsize\" title=\"$ecard_add_remove_tooltip_card_id_click_to_preview_fullsize\" src=\"http://img.youtube.com/vi/$youtube_link_strim/1.jpg\" style=\"border:1px solid silver;cursor:pointer;\" /><br /><span style=\"font-size:8pt\">$ecard_add_remove_txt_added_on_date:<br />$ec_time</span>";
		}//end youtube link
		else
		{
			if(!(strpos($row_data[ec_filename],".html")===false))
			{
				//$htmlfullsize=print get_html_from_layout('$ecard_url/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_filename]'); 
				$show_thumbnail_and_date_add="<img onclick=\"HideItAll();HighLightCell('$val');self.parent.ShowFullsize('$ecard_url/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_filename]','1','1');\" border=\"0\" alt=\"$ecard_add_remove_tooltip_card_id_click_to_preview_fullsize\" title=\"$ecard_add_remove_tooltip_card_id_click_to_preview_fullsize\" src=\"$ecard_url/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_thumbnail]?dummy=$dummy\" style=\"border:1px solid silver;cursor:pointer;\" /><br /><span style=\"font-size:8pt\">$ecard_add_remove_txt_added_on_date:<br />$ec_time</span>";
			}
			else
			{
				$show_thumbnail_and_date_add="<img onclick=\"HideItAll();HighLightCell('$val');self.parent.ShowFullsize('$ecard_url/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_filename]?dummy=$dummy','$fullsize_width','$fullsize_height');\" border=\"0\" alt=\"$ecard_add_remove_tooltip_card_id_click_to_preview_fullsize\" title=\"$ecard_add_remove_tooltip_card_id_click_to_preview_fullsize\" src=\"$ecard_url/resource/picture/$row_data[ec_cat_dir]/$row_data[ec_thumbnail]?dummy=$dummy\" style=\"border:1px solid silver;cursor:pointer;\" /><br /><span style=\"font-size:8pt\">$ecard_add_remove_txt_added_on_date:<br />$ec_time</span>";
			}
		}
		//<br /><textarea onchange=\"Editme('index.php?step=edit_me&table=max_ecard&edit_id=ec_id&edit_id_value=$val&edit_key=ec_message&edit_value=',this.value,'1',1,this.id);\" id=\"area_message$val\" class=\"area_message\">$row_data[ec_message]</textarea>
		//Show on/off ecard active checkbox
		if($row_data[ec_active]=="1"){
			$checked_it ="checked=\"checked\"";
		}
		else{
			$checked_it ="";
		}

		//Show on/off feature ecard checkbox
		if($row_data[ec_feature_card]=="1"){
			$checked_it_feature ="checked=\"checked\"";
		}
		else{
			$checked_it_feature ="";
		}
		if($row_data[ec_embed]){
			$checked_eb="checked=\"checked\"";
		}else{
			$checked_eb="";
		}
		//Show member group checkbox
		$show_mg="";
		$disable_checkbox="";
		$info=split(",",$row_data[ec_group_relate_id]);
		$list_mgid="";
		foreach($list_mg as $array_mg){
			$list_mgid.="$array_mg[mg_id],";
			if(in_array($array_mg[mg_id],$info) && $array_mg[mg_id]=="1"){
				$show_mg .="<input onclick=\"if(this.checked){ControlMGCheckbox('$val',true);self.parent.Editme('index.php?step=$step&what=set_card_mg&action=add&ec_id=$val&ec_group_relate_id=','1',1,1,this.id);}else{ControlMGCheckbox('$val',false);self.parent.Editme('index.php?step=$step&what=set_card_mg&action=remove&ec_id=$val&ec_group_relate_id=','1',1,1,this.id);}\" checked=\"checked\" type=\"checkbox\" name=\"mg$val$array_mg[mg_id]\" id=\"mg$val$array_mg[mg_id]\" value=\"$array_mg[mg_id]\" /> <span style=\"font-size:8pt\">$array_mg[mg_title]</span><br />";
				$disable_checkbox=" disabled=\"disabled\" ";
			}
			elseif(!in_array($array_mg[mg_id],$info) && $array_mg[mg_id]=="1"){
				$show_mg .="<input onclick=\"if(this.checked){ControlMGCheckbox('$val',true);self.parent.Editme('index.php?step=$step&what=set_card_mg&action=add&ec_id=$val&ec_group_relate_id=','1',1,1,this.id);}else{ControlMGCheckbox('$val',false);self.parent.Editme('index.php?step=$step&what=set_card_mg&action=remove&ec_id=$val&ec_group_relate_id=','1',1,1,this.id);}\" type=\"checkbox\" name=\"mg$val$array_mg[mg_id]\" id=\"mg$val$array_mg[mg_id]\" value=\"$array_mg[mg_id]\" /> <span style=\"font-size:8pt\">$array_mg[mg_title]</span><br />";
			}
			elseif(in_array($array_mg[mg_id],$info)){
				$show_mg .="<input onclick=\"if(this.checked){self.parent.Editme('index.php?step=$step&what=set_card_mg&action=add&ec_id=$val&ec_group_relate_id=','$array_mg[mg_id]',1,1,this.id);}else{self.parent.Editme('index.php?step=$step&what=set_card_mg&action=remove&ec_id=$val&ec_group_relate_id=','$array_mg[mg_id]',1,1,this.id);}\" $disable_checkbox checked=\"checked\" type=\"checkbox\" name=\"mg$val$array_mg[mg_id]\" id=\"mg$val$array_mg[mg_id]\" value=\"$array_mg[mg_id]\" /> <span style=\"font-size:8pt\">$array_mg[mg_title]</span><br />";
			}
			else{
				$show_mg .="<input onclick=\"if(this.checked){self.parent.Editme('index.php?step=$step&what=set_card_mg&action=add&ec_id=$val&ec_group_relate_id=','$array_mg[mg_id]',1,1,this.id);}else{self.parent.Editme('index.php?step=$step&what=set_card_mg&action=remove&ec_id=$val&ec_group_relate_id=','$array_mg[mg_id]',1,1,this.id);}\" $disable_checkbox type=\"checkbox\" name=\"mg$val$array_mg[mg_id]\" id=\"mg$val$array_mg[mg_id]\" value=\"$array_mg[mg_id]\" /> <span style=\"font-size:8pt\">$array_mg[mg_title]</span><br />";
			}
		}

	//Show pay per card drop down money
		$show_ppc="<br /><span style=\"font-size:8pt;font-weight:bold\">Pay Per Card:</span> <select style=\"font-size:8pt;\" size=\"1\" title=\"Set price for this card\" id=\"ec_ppc_id$val\" name=\"ec_ppc_id$val\" onchange=\"Editme('index.php?step=edit_me&table=max_ecard&edit_id=ec_id&edit_id_value=$val&edit_key=ec_ppc_id&edit_value=',this.value,'1',1,this.id);\" >";
		$show_price_all_ecards="<br />Pay Per Card: <select size=\"1\" title=\"Set price for all cards in this category\" id=\"ec_ppc_id_all\" name=\"ec_ppc_id_all\" ><option value=\"0.00\">".price_format("0.00")."</option>";
		
		if ($row_data[ec_ppc_id]=="") {
			$show_ppc.="<option selected=\"selected\" value=\"0.00\">".price_format("0.00")."</option>";
		}
		else {
			$show_ppc.="<option value=\"0.00\">".price_format("0.00")."</option>";
		}
		
		foreach($list_ppc as $array_ppc){			
			if($array_ppc[ppc_id]==$row_data[ec_ppc_id]){
				$show_ppc.="<option selected=\"selected\" value=\"$array_ppc[ppc_id]\">".price_format($array_ppc[ppc_amount])."</option>";
			}
			else{
				$show_ppc.="<option value=\"$array_ppc[ppc_id]\">".price_format($array_ppc[ppc_amount])."</option>";
			}
			$show_price_all_ecards.="<option value=\"$array_ppc[ppc_id]\">".price_format($array_ppc[ppc_amount])."</option>";
		}
		$show_ppc.="</select>";
		$show_price_all_ecards.="</select>";		
		//Show div edit ecard caption and detail
		$div_ecard_detail="<div id=\"popup_detail$val\" style=\"display:none;position:absolute;top:0;left:0;z-index:9;width:600px;\"><div style=\"border:thick solid #FCAA03;\"><table border=\"0\" width=\"100%\" cellspacing=\"1\" cellpadding=\"4\" style=\"background-color:silver\"><tr style=\"background-color: #B1D3FF;background-image: url(html/07_title_background.gif);line-height:17px;font-weight:bold\"><td colspan=\"2\" style=\"cursor:pointer;\" onclick=\"HideItAll();\"><div style=\"float:left\">$ecard_add_remove_txt_edit_card_detail</div><img border=\"0\" src=\"html/07_icon_button_close.gif\" title=\"$ecard_add_remove_tooltip_close_hide\" alt=\"$ecard_add_remove_tooltip_close_hide\" style=\"vertical-align:middile;float:right;\" /></td></tr>";		
		$div_ecard_detail.="<tr style=\"background-color: #FAEDC8;line-height:17px\"><td style=\"white-space:nowrap;font-weight:bold\">$ecard_add_remove_txt_card_detail</td><td><input id=\"ec_detail$val\" title=\"$ecard_add_remove_tooltip_click_here_to_edit\" type=\"text\" value=\"$row_data[ec_detail]\" style=\"width:350px;\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_ecard&edit_id=ec_id&edit_id_value=$val&edit_key=ec_detail&edit_value=',this.value,'1',original_value,this.id);\" /></td></tr>";

		$div_ecard_caption="<div id=\"popup_caption$val\" style=\"display:none;position:absolute;top:0;left:0;z-index:9;width:600px;\"><div style=\"border:thick solid #FCAA03;\"><table border=\"0\" width=\"100%\" cellspacing=\"1\" cellpadding=\"4\" style=\"background-color:silver\"><tr style=\"background-color: #B1D3FF;background-image: url(html/07_title_background.gif);line-height:17px;font-weight:bold\"><td colspan=\"2\" style=\"cursor:pointer;\" onclick=\"HideItAll();\"><div style=\"float:left\">$ecard_add_remove_txt_edit_card_caption</div><img border=\"0\" src=\"html/07_icon_button_close.gif\" title=\"$ecard_add_remove_tooltip_close_hide\" alt=\"$ecard_add_remove_tooltip_close_hide\" style=\"vertical-align:middile;float:right;\" /></td></tr>";
		$div_ecard_caption.="<tr style=\"background-color: #FAEDC8;line-height:17px\"><td style=\"white-space:nowrap;font-weight:bold\">$ecard_add_remove_txt_card_caption</td><td><input id=\"ec_caption$val\" title=\"$ecard_add_remove_tooltip_click_here_to_edit\" type=\"text\" value=\"$row_data[ec_caption]\" style=\"width:350px;\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_ecard&edit_id=ec_id&edit_id_value=$val&edit_key=ec_caption&edit_value=',this.value,'1',original_value,this.id);\" /></td></tr>";
			//Show language
			$show_list_language_table="";
			$show_list_language_table2="";
			foreach($list_lang_file as $mylang){
				$cap_lang_name="ec_caption_".str_replace(".php","",$mylang);
				$cap_lang_name_value=$row_data[$cap_lang_name];
				if($cf_language==$mylang && $cap_lang_name_value==""){
					$cap_lang_name_value=$row_data[ec_caption];
				}
				
				$ecard_add_remove_txt_translate_into_language_temp=str_replace("%language_to_translate%",ucwords(str_replace("_lang.php","",$mylang)),$ecard_add_remove_txt_translate_into_language);
				$mylang_name=$ecard_add_remove_txt_translate_into_language_temp;
			
				$show_list_language_table.="<tr style=\"background-color: #EAEAEA;line-height:17px\">\n";
				$show_list_language_table.="<td style=\"white-space:nowrap\">$mylang_name</td>\n";
				$show_list_language_table.="<td ><input type=\"text\" name=\"$cap_lang_name$val\" id=\"$cap_lang_name$val\" value=\"$cap_lang_name_value\" style=\"width:350px\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&lang=$mylang&table=max_ecard&edit_id=ec_id&edit_id_value=$val&edit_key=$cap_lang_name&edit_value=',this.value,'0',original_value,this.id);\" /></td>\n";
				$show_list_language_table.="</tr>\n";

				$cap_lang_name2="ec_detail_".str_replace(".php","",$mylang);
				$cap_lang_name_value2=$row_data[$cap_lang_name2];
				if($cf_language==$mylang && $cap_lang_name_value2==""){
					$cap_lang_name_value2=$row_data[ec_detail];
				}

				$show_list_language_table2.="<tr style=\"background-color: #EAEAEA;line-height:17px\">\n";
				$show_list_language_table2.="<td style=\"white-space:nowrap\">$mylang_name</td>\n";
				$show_list_language_table2.="<td ><input type=\"text\" name=\"$cap_lang_name2$val\" id=\"$cap_lang_name2$val\" value=\"$cap_lang_name_value2\" style=\"width:350px\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&lang=$mylang&table=max_ecard&edit_id=ec_id&edit_id_value=$val&edit_key=$cap_lang_name2&edit_value=',this.value,'0',original_value,this.id);\" /></td>\n";
				$show_list_language_table2.="</tr>\n";
			}

		$div_ecard_caption.="$show_list_language_table</table></div></div>";
		$div_ecard_detail.="$show_list_language_table2</table></div></div>";

		//Show div keyword
		$div_ecard_keyword="<div id=\"popup_keyword$val\" style=\"display:none;position:absolute;top:0;left:0;z-index:9;width:600px;\"><div style=\"border:thick solid #FCAA03;\"><table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"4\" style=\"background-color:silver\"><tr style=\"background-color: #B1D3FF;background-image: url(html/07_title_background.gif);line-height:17px;font-weight:bold\"><td colspan=\"2\" style=\"cursor:pointer;\" onclick=\"HideItAll();\"><div style=\"float:left\">$ecard_add_remove_txt_edit_card_keyword</div><img border=\"0\" src=\"html/07_icon_button_close.gif\" title=\"$ecard_add_remove_tooltip_close_hide\" alt=\"$ecard_add_remove_tooltip_close_hide\" style=\"vertical-align:middile;float:right;\" /></td></tr>";		
		$div_ecard_keyword.="<tr style=\"background-color: #FAEDC8;line-height:17px\"><td style=\"white-space:nowrap;font-weight:bold\">$ecard_add_remove_txt_enter_keyword</td></tr>";
		$div_ecard_keyword.="<tr style=\"background-color: #FAEDC8;line-height:17px\"><td style=\"white-space:nowrap;font-weight:bold\"><textarea id=\"ec_keyword$val\" title=\"$ecard_add_remove_tooltip_click_here_to_edit\" style=\"width:100%;height:200px\" onfocus=\"original_value=this.value;\" onkeypress=\"return noEnterKey(event);\"  onchange=\"Editme('index.php?step=edit_me&table=max_ecard&edit_id=ec_id&edit_id_value=$val&edit_key=ec_keyword&edit_value=',this.value,'1',original_value,this.id);\" />$row_data[ec_keyword]</textarea></td></tr>";
		$div_ecard_keyword.="</table></div></div>";

		//Show edit ecard caption (title) icon
		$show_edit_caption_icon="<img style=\"cursor:pointer;\" onclick=\"HideItAll();HighLightCell('$val');ShowDivCenterPage('popup_caption$val',1);\" border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_edit_card_caption\" title=\"$ecard_add_remove_tooltip_click_here_to_edit_card_caption\"  src=\"html/07_icon_ec_edit_caption.gif\" />";

		//Show edit ecard keyword icon
		$show_edit_keyword_icon="<img style=\"cursor:pointer;\" onclick=\"HideItAll();HighLightCell('$val');ShowDivCenterPage('popup_keyword$val',1);\" border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_edit_card_keyword\" title=\"$ecard_add_remove_tooltip_click_here_to_edit_card_keyword\" src=\"html/07_icon_ec_edit_keyword.gif\" />";

		//Show edit ecard detail icon
		$show_edit_detail_icon="<img style=\"cursor:pointer;\" onclick=\"HideItAll();HighLightCell('$val');ShowDivCenterPage('popup_detail$val',1);\" border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_edit_card_detail\" title=\"$ecard_add_remove_tooltip_click_here_to_edit_card_detail\" src=\"html/07_icon_ec_edit_detail.gif\" />";

		//Show java applet icon if found
		if($row_data[ec_applet]!=""){
			if(file_exists("$ecard_root/resource/applet/$row_data[ec_applet]/thumb_icon.gif")){
				$ecard_add_remove_tooltip_click_here_to_set_default_applet=str_replace("%ec_applet%",$row_data[ec_applet],$ecard_add_remove_tooltip_click_here_to_set_default_applet);
				$show_java_applet_icon="<div id=\"change_icon_java$val\" style=\"cursor:pointer;\" onclick=\"ec_id=$val;HideItAll();HighLightCell('$val');ShowDivCenterPage('view_table_java_applet_icon',1);\"><img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_set_default_applet\" title=\"$ecard_add_remove_tooltip_click_here_to_set_default_applet\" src=\"$ecard_url/resource/applet/$row_data[ec_applet]/thumb_icon.gif\" /></div>";
			}
			else{
				$ecard_add_remove_tooltip_click_here_to_set_default_applet_icon_not_found=str_replace("%ec_applet%",$row_data[ec_applet],$ecard_add_remove_tooltip_click_here_to_set_default_applet_icon_not_found);
				$show_java_applet_icon="<div id=\"change_icon_java$val\" style=\"cursor:pointer;\" onclick=\"ec_id=$val;HideItAll();HighLightCell('$val');ShowDivCenterPage('view_table_java_applet_icon',1);\"><img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_set_default_applet_icon_not_found\" title=\"$ecard_add_remove_tooltip_click_here_to_set_default_applet_icon_not_found\" src=\"html/07_icon_no_icon_java.gif\" /></div>";
			}
		}
		else{
			$show_java_applet_icon="<div id=\"change_icon_java$val\" style=\"cursor:pointer;\" onclick=\"ec_id=$val;HideItAll();HighLightCell('$val');ShowDivCenterPage('view_table_java_applet_icon',1);\"><img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_set_default_applet_no_java\" title=\"$ecard_add_remove_tooltip_click_here_to_set_default_applet_no_java\" src=\"html/07_icon_no_java.gif\" /></div>";
		}

		if(!(strpos($row_data[ec_filename],".swf")===false)){
			$show_java_applet_icon="<div onclick=\"alert('$ecard_add_remove_message_cannt_apply_applet_to_flash_card')\"><img border=\"0\" alt=\"$ecard_add_remove_message_cannt_apply_applet_to_flash_card\" title=\"$ecard_add_remove_message_cannt_apply_applet_to_flash_card\" src=\"html/07_icon_no_java.gif\" style=\"filter: Alpha(Opacity=40);-moz-opacity:0.4;opacity:0.4;\" /></div>";
		}
		
		
		//Show skin for each ecard - no skin was set then default skin will be used.
		if($row_data[ec_skin]!=""){
			
			if(file_exists("$ecard_root/resource/skin/$row_data[ec_skin]/skin.gif")){
				$ecard_add_remove_tooltip_click_here_to_set_skin_background_default=str_replace("%ec_skin%",$row_data[ec_skin],ecard_add_remove_tooltip_click_here_to_set_skin_background_default);
				$show_skin_icon="<div id=\"change_icon_skin$val\" style=\"cursor:pointer;\" onclick=\"ec_id=$val;HideItAll();HighLightCell('$val');ShowDivCenterPage('view_table_skin_icon',1);\"><img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_set_skin_background_default\" title=\"$ecard_add_remove_tooltip_click_here_to_set_skin_background_default\" src=\"$ecard_url/resource/skin/$row_data[ec_skin]/skin.gif\" style=\"border:1px solid silver\" /></div>";
			}
			elseif(file_exists("$ecard_root/resource/skin/$row_data[ec_skin]/skin.jpg")){
				$ecard_add_remove_tooltip_click_here_to_set_skin_background_default=str_replace("%ec_skin%",$row_data[ec_skin],$ecard_add_remove_tooltip_click_here_to_set_skin_background_default);
				$show_skin_icon="<div id=\"change_icon_skin$val\" style=\"cursor:pointer;\" onclick=\"ec_id=$val;HideItAll();HighLightCell('$val');ShowDivCenterPage('view_table_skin_icon',1);\"><img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_set_skin_background_default\" title=\"$ecard_add_remove_tooltip_click_here_to_set_skin_background_default\" src=\"$ecard_url/resource/skin/$row_data[ec_skin]/skin.jpg\" style=\"border:1px solid silver\" /></div>";
			}
			if(file_exists("$ecard_root/resource/skin/$row_data[ec_skin]/skin.png")){
				$ecard_add_remove_tooltip_click_here_to_set_skin_background_default=str_replace("%ec_skin%",$row_data[ec_skin],$ecard_add_remove_tooltip_click_here_to_set_skin_background_default);
				$show_skin_icon="<div id=\"change_icon_skin$val\" style=\"cursor:pointer;\" onclick=\"ec_id=$val;HideItAll();HighLightCell('$val');ShowDivCenterPage('view_table_skin_icon',1);\"><img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_set_skin_background_default\" title=\"$ecard_add_remove_tooltip_click_here_to_set_skin_background_default\" src=\"$ecard_url/resource/skin/$row_data[ec_skin]/skin.png\" style=\"border:1px solid silver\" /></div>";
			}
			if($show_skin_icon==""){
				if(file_exists("$ecard_root/resource/skin/$cf_default_skin/skin.gif")){
					$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1=str_replace("%cf_default_skin%",$cf_default_skin,$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1);
					$show_skin_icon="<div id=\"change_icon_skin$val\" style=\"cursor:pointer;\" onclick=\"ec_id=$val;HideItAll();HighLightCell('$val');ShowDivCenterPage('view_table_skin_icon',1);\"><img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1\" title=\"$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1\" src=\"$ecard_url/resource/skin/$cf_default_skin/skin.gif\" style=\"border:1px solid silver\" /></div>";
				}
				elseif(file_exists("$ecard_root/resource/skin/$cf_default_skin/skin.jpg")){
					$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1=str_replace("%cf_default_skin%",$cf_default_skin,$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1);
					$show_skin_icon="<div id=\"change_icon_skin$val\" style=\"cursor:pointer;\" onclick=\"ec_id=$val;HideItAll();HighLightCell('$val');ShowDivCenterPage('view_table_skin_icon',1);\"><img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1\" title=\"$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1\" src=\"$ecard_url/resource/skin/$cf_default_skin/skin.jpg\" style=\"border:1px solid silver\" /></div>";
				}
				elseif(file_exists("$ecard_root/resource/skin/$cf_default_skin/skin.png")){
					$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1=str_replace("%cf_default_skin%",$cf_default_skin,$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1);
					$show_skin_icon="<div id=\"change_icon_skin$val\" style=\"cursor:pointer;\" onclick=\"ec_id=$val;HideItAll();HighLightCell('$val');ShowDivCenterPage('view_table_skin_icon',1);\"><img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1\" title=\"$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1\" src=\"$ecard_url/resource/skin/$cf_default_skin/skin.png\" style=\"border:1px solid silver\" /></div>";
				}else{
					$show_skin_icon="ERROR ";
				}
			}
		}
		else{
			if(file_exists("$ecard_root/resource/skin/$cf_default_skin/skin.gif")){
				$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1=str_replace("%cf_default_skin%",$cf_default_skin,$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1);
				$show_skin_icon="<div id=\"change_icon_skin$val\" style=\"cursor:pointer;\" onclick=\"ec_id=$val;HideItAll();HighLightCell('$val');ShowDivCenterPage('view_table_skin_icon',1);\"><img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1\" title=\"$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1\" src=\"$ecard_url/resource/skin/$cf_default_skin/skin.gif\" style=\"border:1px solid silver\" /></div>";
			}
			elseif(file_exists("$ecard_root/resource/skin/$cf_default_skin/skin.jpg")){
				$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1=str_replace("%cf_default_skin%",$cf_default_skin,$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1);
				$show_skin_icon="<div id=\"change_icon_skin$val\" style=\"cursor:pointer;\" onclick=\"ec_id=$val;HideItAll();HighLightCell('$val');ShowDivCenterPage('view_table_skin_icon',1);\"><img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1\" title=\"$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1\" src=\"$ecard_url/resource/skin/$cf_default_skin/skin.jpg\" style=\"border:1px solid silver\" /></div>";
			}
			elseif(file_exists("$ecard_root/resource/skin/$cf_default_skin/skin.png")){
				$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1=str_replace("%cf_default_skin%",$cf_default_skin,$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1);
				$show_skin_icon="<div id=\"change_icon_skin$val\" style=\"cursor:pointer;\" onclick=\"ec_id=$val;HideItAll();HighLightCell('$val');ShowDivCenterPage('view_table_skin_icon',1);\"><img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1\" title=\"$ecard_add_remove_tooltip_click_here_to_set_skin_background_default_1\" src=\"$ecard_url/resource/skin/$cf_default_skin/skin.png\" style=\"border:1px solid silver\" /></div>";
			}
			else{
				$show_skin_icon="ERROR ";
			}
		}
		
		//Show default poem icon
		if ($row_data[ec_poem_id]!="0") {
			$show_default_poem_icon="<div id=\"change_default_poem$val\" style=\"cursor:pointer;\" onclick=\"ec_id=$val;HideItAll();HighLightCell('$val');ShowDivCenterPage('view_table_poem_icon',1);\"><img width=\"42\" border=\"1\" alt=\"$row_data[ec_poem_id] - $ecard_add_remove_tooltip_click_here_to_set_default_poem\" title=\"$row_data[ec_poem_id] - $ecard_add_remove_tooltip_click_here_to_set_default_poem\" src=\"$ecard_url/templates/$cf_set_template/icon_poem.gif\" /></div>";
		}
		else {
			$show_default_poem_icon="<div id=\"change_default_poem$val\" style=\"cursor:pointer;\" onclick=\"ec_id=$val;HideItAll();HighLightCell('$val');ShowDivCenterPage('view_table_poem_icon',1);\"><img width=\"42\" border=\"1\" alt=\"$row_data[ec_poem_id] - $ecard_add_remove_tooltip_click_here_to_set_default_poem\" title=\"$row_data[ec_poem_id] - $ecard_add_remove_tooltip_click_here_to_set_default_poem\" src=\"$ecard_url/templates/$cf_set_template/icon_no_poem.gif\" /></div>";
		}

		//Show stamp for each ecard - no stamp was set then default stamp will be used.
		if($row_data[ec_stamp_filename]!=""){
			$ecard_add_remove_tooltip_click_here_to_set_stamp_default=str_replace("%ec_stamp_filename%",$row_data[ec_stamp_filename],$ecard_add_remove_tooltip_click_here_to_set_stamp_default);
			$show_stamp_icon="<div id=\"change_icon_stamp$val\" style=\"cursor:pointer;\" onclick=\"ec_id=$val;HideItAll();HighLightCell('$val');ShowDivCenterPage('view_table_stamp_icon',1);\"><img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_set_stamp_default\" title=\"$ecard_add_remove_tooltip_click_here_to_set_stamp_default\" src=\"$ecard_url/resource/stamp/$row_data[ec_stamp_filename]\" /></div>";
		}
		else{
			$ecard_add_remove_tooltip_click_here_to_set_stamp_default=str_replace("%ec_stamp_filename%",$cf_default_stamp,$ecard_add_remove_tooltip_click_here_to_set_stamp_default);
			$show_stamp_icon="<div id=\"change_icon_stamp$val\" style=\"cursor:pointer;\" onclick=\"ec_id=$val;HideItAll();HighLightCell('$val');ShowDivCenterPage('view_table_stamp_icon',1);\"><img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_set_stamp_default\" title=\"$ecard_add_remove_tooltip_click_here_to_set_stamp_default\" src=\"$ecard_url/resource/stamp/$cf_default_stamp\" /></div>";
		}

		//Show music file
		if($row_data[ec_music_filename]!=""){
			$ecard_add_remove_tooltip_click_here_to_set_music_default=str_replace("%ec_music_filename%",$row_data[ec_music_filename],$ecard_add_remove_tooltip_click_here_to_set_music_default);
			$show_music_icon="<div id=\"change_icon_music$val\" style=\"cursor:pointer;\" onclick=\"ec_id=$val;HideItAll();HighLightCell('$val');ShowDivCenterPage('view_table_music_icon',1);\"><img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_set_music_default\" title=\"$ecard_add_remove_tooltip_click_here_to_set_music_default\" src=\"html/07_icon_play_audio_file.gif\" /></div>";
		}
		else{			
			$show_music_icon="<div id=\"change_icon_music$val\" style=\"cursor:pointer;\" onclick=\"ec_id=$val;HideItAll();HighLightCell('$val');ShowDivCenterPage('view_table_music_icon',1);\"><img border=\"0\" alt=\"$ecard_add_remove_tooltip_click_here_to_set_music_default_no_default_music\" title=\"$ecard_add_remove_tooltip_click_here_to_set_music_default_no_default_music\" src=\"html/07_icon_play_audio_file.gif\" style=\"filter: Alpha(Opacity=40);-moz-opacity:0.4;opacity:0.4;\" /></div>";
		}

		//Show preview icon
		$show_preview_icon="<a href=\"$ecard_url/index.php?step=sendcard&ec_id=$val\" target=\"_blank\"><img border=\"0\" src=\"html/07_icon_search_keyword.gif\" alt=\"\" /></a>";
		
		//Show delete button
		$show_delete_button="<img onclick=\"document.getElementById('tr$val').style.backgroundColor='#E4E4D3';document.getElementById('bk$val').checked='true';CheckSelected('delete_selected');\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$ecard_add_remove_tooltip_delete\" title=\"$ecard_add_remove_tooltip_delete\" />";		

		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;vertical-align:top\">$show_sort</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" valign=\"top\" id=\"cell$val\" style=\"padding:4px\">$show_thumbnail_and_date_add</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" valign=\"top\" id=\"active_cell$val\" style=\"padding:4px\"><input $checked_it type=\"checkbox\" value=\"1\" onclick=\"self.parent.ShowLoaderImage('$ecard_add_remove_mesage_updating');if(this.checked){self.parent.UpdateDataTable('index.php?step=edit_me&table=max_ecard&edit_id=ec_id&edit_id_value=$val&edit_key=ec_active&edit_value=1');}else{self.parent.UpdateDataTable('index.php?step=edit_me&table=max_ecard&edit_id=ec_id&edit_id_value=$val&edit_key=ec_active&edit_value=0');}\" /></td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" valign=\"top\" id=\"ec_embed$val\" style=\"padding:4px\"><input $checked_eb type=\"checkbox\" value=\"1\" onclick=\"self.parent.ShowLoaderImage('$ecard_add_remove_mesage_updating');if(this.checked){self.parent.UpdateDataTable('index.php?step=edit_me&table=max_ecard&edit_id=ec_id&edit_id_value=$val&edit_key=ec_embed&edit_value=1');}else{self.parent.UpdateDataTable('index.php?step=edit_me&table=max_ecard&edit_id=ec_id&edit_id_value=$val&edit_key=ec_embed&edit_value=0');}\" /></td>\n";
		//$show_list_table .="<td width=\"1%\" align=\"center\" valign=\"top\" id=\"active_cell$val\" style=\"padding:4px\">xxx</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" valign=\"top\" id=\"feature_cell$val\" style=\"padding:4px\"><input $checked_it_feature type=\"checkbox\" value=\"1\" onclick=\"self.parent.ShowLoaderImage('$ecard_add_remove_mesage_updating');if(this.checked){self.parent.UpdateDataTable('index.php?step=edit_me&table=max_ecard&edit_id=ec_id&edit_id_value=$val&edit_key=ec_feature_card&edit_value=1');}else{self.parent.UpdateDataTable('index.php?step=edit_me&table=max_ecard&edit_id=ec_id&edit_id_value=$val&edit_key=ec_feature_card&edit_value=0');}\" /></td>\n";
		$show_list_table .="<td width=\"*\" valign=\"top\" style=\"padding:4px;\">$show_mg$show_ppc</td>\n";

		$show_list_table .="<td width=\"1%\" valign=\"top\" style=\"padding:4px;\">$show_edit_caption_icon$div_ecard_caption$div_ecard_detail$div_ecard_keyword</td>\n";
		$show_list_table .="<td width=\"1%\" valign=\"top\" style=\"padding:4px;\">$show_edit_keyword_icon</td>\n";
		$show_list_table .="<td width=\"1%\" valign=\"top\" style=\"padding:4px;\">$show_edit_detail_icon</td>\n";
		$show_list_table .="<td width=\"1%\" valign=\"top\" style=\"padding:4px;\">$show_default_poem_icon</td>\n";
		$show_list_table .="<td width=\"1%\" valign=\"top\" style=\"padding:4px;\">$show_java_applet_icon</td>\n";
		$show_list_table .="<td width=\"1%\" valign=\"top\" style=\"padding:4px;\">$show_skin_icon</td>\n";
		$show_list_table .="<td width=\"2%\" valign=\"top\" style=\"padding:4px;\">$show_stamp_icon</td>\n";				
		$show_list_table .="<td width=\"1%\" align=\"center\" valign=\"top\" style=\"padding:4px;\">$show_music_icon</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" valign=\"top\" style=\"padding:4px;\"id=\"preview_cell$val\">$show_preview_icon</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" valign=\"top\" style=\"padding:4px;\">$show_delete_button</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" valign=\"top\" style=\"padding:4px;\"><input onclick=\"if(this.checked){document.getElementById('tr$val').style.backgroundColor='#E4E4D3';}else{document.getElementById('tr$val').style.backgroundColor='#EAEAEA';}\" type=\"checkbox\" id=\"bk$val\" name=\"mylist_id$val\" value=\"$val\" /></td>\n";
		$show_list_table .="</tr>\n";
		$bk_id .="$val,";
		$show_skin_icon="";
	}
	if($bk_id{strlen($bk_id)-1} ==",") $bk_id = substr($bk_id, 0, strlen($bk_id)-1);
	set_global_var("bk_id",$bk_id);
	if($list_mgid{strlen($list_mgid)-1} ==",") $list_mgid = substr($list_mgid, 0, strlen($list_mgid)-1);
	set_global_var("list_mgid",$list_mgid);
	set_global_var("show_list_table",$show_list_table);

	//---------------------------------------------------------------------------------------
	//Print page here
	//Output sample: << 1 | 2 | 3 >>	
	$cat_name_display=urlencode($cat_name_display);

	if ($page < 1 || $page=="") 
		$page = 1;
	if ($list_data ==""){
		$display_page_number = "";
	}
	else{
		$display_page_number ="";

		if ($count_list > ($row_per_page)){	
			$c = $count_list / $row_per_page;
			if (gettype($c) =="integer"){
				$b = $c;
			}
			else{
				$b = intval(($count_list / $row_per_page) + 1);
			}				
			
			$display_page_number .="<br /><table class=page_number_table>\n";
			$display_page_number .="    <tr>\n";
			$display_page_number .="      <td width='10%' align=left>{A}</td>\n";
			$display_page_number .="      <td width='33%' align=center>{NUMBER}</td>\n";
			$display_page_number .="      <td width='10%' align=right>{B}</td>\n";
			$display_page_number .="    </tr>\n";
			$display_page_number .="</table>\n";
			
			$count_number =get_page_count_number($page,$b);
			$display_page_number = str_replace("{NUMBER}", $count_number, $display_page_number);						
			if ($page > 1) {
				$page_pr = $page - 1 ;				
				$dpn ="<a href=\"index.php?step=$step&what=$what&row_number=$row_number&page=$page_pr&cat_id=$cat_id&cat_dir=$cat_dir&cat_name_display=$cat_name_display\"><img border=0 src=html/prv.gif style='vertical-align:middle' title='Page # $page_pr' alt='Page # $page_pr' /></a>";
				$display_page_number = str_replace("{A}", $dpn, $display_page_number);
			}
			else{
				$display_page_number = str_replace("{A}", "<img src=html/prv_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
			}
			$y=get_global_var("d_num");
			if ($page < $y) {
				$page_ne = $page + 1 ;				
				$display_page_number = str_replace("{B}", "<a href=\"index.php?step=$step&what=$what&row_number=$row_number&page=$page_ne&cat_id=$cat_id&cat_dir=$cat_dir&cat_name_display=$cat_name_display\"><img border=0 src=html/next.gif style='vertical-align:middle' title='Page # $page_ne' alt='Page # $page_ne' /></a>", $display_page_number);
			}	
			else{
				$display_page_number = str_replace("{B}", "<img src=html/next_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
			}
		}
	}
	set_global_var("display_page_number",$display_page_number);	 
	
	//Disable add new files Submit button if folder resource/picture/cat_dir is not writable
	if (!is_writable("$ecard_root/resource/picture/$cat_dir")){
		set_global_var("disable_submit_button","disabled=\"disabled\" style=\"filter: Alpha(Opacity=40);-moz-opacity:0.4;opacity:0.4;\" ");
		$ecard_add_remove_mesage_disable_submit_button_message=str_replace("%cat_dir%",$cat_dir,$ecard_add_remove_mesage_disable_submit_button_message);
		$ecard_add_remove_mesage_disable_submit_button_message=str_replace("%physical_cat_dir%","$ecard_root/resource/picture/$cat_dir",$ecard_add_remove_mesage_disable_submit_button_message);
		$ecard_add_remove_mesage_disable_submit_button_message=str_replace("%url%","index.php?step=$step&cat_id=$cat_id&cat_dir=$cat_dir&cat_name_display=$cat_name_display",$ecard_add_remove_mesage_disable_submit_button_message);
		set_global_var("disable_submit_button_message",$ecard_add_remove_mesage_disable_submit_button_message);
	}

	//Count total ecard in this cat
	$count_total=get_dbvalue("max_ecard","count(ec_id)","ec_user_name_id='' and ec_cat_id='$cat_id'");
	set_global_var("count_total",$count_total);

	//Show show_list_java_icon
	$list_data =set_array_from_query("max_java_applet","java_id,java_dirname,java_name_display","java_active='1' Order by java_order,java_name_display");
	$show_list_java_icon="<div style=\"border:1px solid silver;background-color:#E4E4D3;padding:4px;cursor:pointer\" onmouseover=\"this.style.background='#B1D3FF';\" onmouseout=\"this.style.background='#E4E4D3';\" onclick=\"SetJavaDefault('','html/07_icon_no_java.gif','No Java');\"><img border=\"0\" src=\"html/07_icon_no_java.gif\" alt=\"\" style=\"vertical-align:middle\"/> $ecard_add_remove_txt_no_java_applet</div><div style=\"line-height:4px\">&nbsp;</div>";
	foreach($list_data as $row_data){
		$java_name_display=str_replace("'","`",$row_data[java_name_display]);
		if(file_exists("$ecard_root/resource/applet/$row_data[java_dirname]/thumb_icon.gif")){
			$show_list_java_icon .="<div style=\"border:1px solid silver;background-color:#E4E4D3;padding:4px;cursor:pointer\" onmouseover=\"this.style.background='#B1D3FF';\" onmouseout=\"this.style.background='#E4E4D3';\" onclick=\"SetJavaDefault('$row_data[java_dirname]','$ecard_url/resource/applet/$row_data[java_dirname]/thumb_icon.gif','$java_name_display');\"><img border=\"0\" src=\"$ecard_url/resource/applet/$row_data[java_dirname]/thumb_icon.gif\" alt=\"\" style=\"vertical-align:middle\"/> $row_data[java_name_display]</div><div style=\"line-height:4px\">&nbsp;</div>";
		}
		else{
			$show_list_java_icon .="<div style=\"border:1px solid silver;background-color:#E4E4D3;padding:4px;cursor:pointer\" onmouseover=\"this.style.background='#B1D3FF';\" onmouseout=\"this.style.background='#E4E4D3';\" onclick=\"SetJavaDefault('$row_data[java_dirname]','html/07_icon_no_icon_java.gif','$java_name_display');\"><img border=\"0\" src=\"html/07_icon_no_icon_java.gif\" alt=\"$ecard_add_remove_tooltip_icon_not_found\" title=\"$ecard_add_remove_tooltip_icon_not_found\" style=\"vertical-align:middle\"/> $row_data[java_name_display]</div><div style=\"line-height:4px\">&nbsp;</div>";
		}
	}
	set_global_var("show_list_java_icon",$show_list_java_icon);

	//Show show_list_skin_icon
	$list_data =set_array_from_query("max_skin","skin_id,skin_dirname,skin_name_display","skin_active='1' Order by skin_order,skin_name_display");
	$show_list_skin_icon="";
	foreach($list_data as $row_data){
		if($cf_default_skin==$row_data[skin_dirname]){
			$skin_default=" <span class=\"OK_Message\">$ecard_add_remove_txt_default</span>";
		}
		else{
			$skin_default="";
		}
		$skin_name_display=str_replace("'","`",$row_data[skin_name_display]);
		if(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/skin.gif")){
			$src="$ecard_url/resource/skin/$row_data[skin_dirname]/skin.gif";
			
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/skin.jpg")){
			$src="$ecard_url/resource/skin/$row_data[skin_dirname]/skin.jpg";			
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/skin.png")){
			$src="$ecard_url/resource/skin/$row_data[skin_dirname]/skin.png";			
		}
		$show_list_skin_icon .="<div style=\"border:1px solid silver;background-color:#E4E4D3;padding:4px;cursor:pointer\" onmouseover=\"this.style.background='#B1D3FF';\" onmouseout=\"this.style.background='#E4E4D3';\" onclick=\"SetSkinDefault('$row_data[skin_dirname]','$src','$skin_name_display');\"><img border=\"0\" src=\"$src\" alt=\"\" style=\"vertical-align:middle\"/> $row_data[skin_name_display]$skin_default</div><div style=\"line-height:4px\">&nbsp;</div>";
	}
	set_global_var("show_list_skin_icon",$show_list_skin_icon);

	//Show show_list_stamp_icon
	$list_data =set_array_from_query("max_stamp","stamp_id,stamp_filename,stamp_name_display","stamp_active='1' Order by stamp_order,stamp_name_display");
	$show_list_stamp_icon="";
	foreach($list_data as $row_data){
		$stamp_name_display=str_replace("'","`",$row_data[stamp_name_display]);
		if(file_exists("$ecard_root/resource/stamp/$row_data[stamp_filename]")){
			$show_list_stamp_icon .="<div style=\"border:1px solid silver;background-color:#E4E4D3;padding:4px;cursor:pointer\" onmouseover=\"this.style.background='#B1D3FF';\" onmouseout=\"this.style.background='#E4E4D3';\" onclick=\"SetStampDefault('$row_data[stamp_filename]','$ecard_url/resource/stamp/$row_data[stamp_filename]','$stamp_name_display');\"><img border=\"0\" src=\"$ecard_url/resource/stamp/$row_data[stamp_filename]\" alt=\"\" style=\"vertical-align:middle\"/> $row_data[stamp_name_display]</div><div style=\"line-height:4px\">&nbsp;</div>";
		}
	}
	set_global_var("show_list_stamp_icon",$show_list_stamp_icon);
	
	//Show show_list_poem_icon
	$list_data =set_array_from_query("max_poem","poem_id,poem_title,poem_author,poem_body","poem_active='1' AND poem_user_name_id='' Order by poem_order,poem_title");
	$show_list_poem_icon="<div style=\"border:1px solid silver;background-color:#E4E4D3;padding:4px;cursor:pointer\" onmouseover=\"this.style.background='#B1D3FF';\" onmouseout=\"this.style.background='#E4E4D3';\" onclick=\"SetPoemDefault('','No Poem','$ecard_url/templates/$cf_set_template/icon_no_poem.gif');\"><table width=\"100%\" border=\"0\"><tr><td width=\"1%\"><img border=\"0\" style=\"vertical-align: middle;\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_no_poem.gif\"></td><td width=\"*\" style=\"font-size: 8pt;\"><strong>$ecard_add_remove_txt_no_poem</td></tr></table></div><div style=\"line-height:4px\">&nbsp;</div>";
	foreach($list_data as $row_data){
		$poem_title=str_replace("'","`",$row_data[poem_title]);
		$show_list_poem_icon .="<div style=\"border:1px solid silver;background-color:#E4E4D3;padding:4px;cursor:pointer\" onmouseover=\"this.style.background='#B1D3FF';\" onmouseout=\"this.style.background='#E4E4D3';\" onclick=\"SetPoemDefault('$row_data[poem_id]','$poem_title','$ecard_url/templates/$cf_set_template/icon_poem.gif');\"><table width=\"100%\" border=\"0\"><tr><td width=\"1%\"><img border=\"0\" style=\"vertical-align: middle;\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/icon_poem.gif\"></td><td width=\"*\" style=\"font-size: 8pt;\"><strong>$poem_title</strong><br>$row_data[poem_author]</td></tr></table></div><div style=\"line-height:4px\">&nbsp;</div>";
	}
	set_global_var("show_list_poem_icon",$show_list_poem_icon);

	//Show show_list_music_icon
	$list_data =set_array_from_query("max_music","music_id,music_filename,music_name_display,ec_cat_dir","music_active='1' and music_user_name_id='' and ec_cat_id<>'0' Order by music_order,music_name_display");
	$show_list_music_icon="<div style=\"border:1px solid silver;background-color:#E4E4D3;padding:4px;cursor:pointer\" onmouseover=\"this.style.background='#B1D3FF';\" onmouseout=\"this.style.background='#E4E4D3';\" onclick=\"SetMusicDefault('','','disabled','$ecard_add_remove_txt_no_default_music');\"><img border=\"0\" src=\"html/07_icon_play_audio_file.gif\" alt=\"\" style=\"vertical-align:middle;filter: Alpha(Opacity=40);-moz-opacity:0.4;opacity:0.4;\"/> $ecard_add_remove_txt_no_default_music</div><div style=\"line-height:4px\">&nbsp;</div>";
	foreach($list_data as $row_data){
		$music_name_display=str_replace("'","`",$row_data[music_name_display]);
		if(file_exists("$ecard_root/resource/music/$row_data[ec_cat_dir]/$row_data[music_filename]")){
			$show_list_music_icon .="<div style=\"border:1px solid silver;background-color:#E4E4D3;padding:4px;cursor:pointer\" onmouseover=\"this.style.background='#B1D3FF';\" onmouseout=\"this.style.background='#E4E4D3';\" onclick=\"SetMusicDefault('$row_data[music_filename]','$row_data[music_id]','enabled','$music_name_display');\"><img border=\"0\" src=\"html/07_icon_play_audio_file.gif\" alt=\"\" style=\"vertical-align:middle\"/> $row_data[music_name_display]</div><div style=\"line-height:4px\">&nbsp;</div>";
		}
	}
	set_global_var("show_list_music_icon",$show_list_music_icon);

	//Show checkbox member group
	foreach($list_mg as $array_mg){
		if($array_mg[mg_id]=="1"){
			$show_member_group_all_ecards .="<div style=\"text-align:left;margin-left:30px\"><input onclick=\"if(this.checked){ControlMGCheckbox2('$array_mg[mg_id]',true);}else{ControlMGCheckbox2('$array_mg[mg_id]',false);}\" type=\"checkbox\" name=\"mg_list$array_mg[mg_id]\" id=\"mg_list$array_mg[mg_id]\" value=\"$array_mg[mg_id]\" /> $array_mg[mg_title]<br /></div>";
		}
		else{
			$show_member_group_all_ecards .="<div style=\"text-align:left;margin-left:30px\"><input type=\"checkbox\" name=\"mg_list$array_mg[mg_id]\" id=\"mg_list$array_mg[mg_id]\" value=\"$array_mg[mg_id]\" /> $array_mg[mg_title]<br /></div>";
		}
	}

	set_global_var("show_info","<br />$show_info<br />");
	
	$ecard_add_remove_txt_add_remove_ecards_total=str_replace("%count_total%",$count_total,$ecard_add_remove_txt_add_remove_ecards_total);
	set_global_var("ecard_add_remove_txt_add_remove_ecards_total",$ecard_add_remove_txt_add_remove_ecards_total);
	
	$ecard_add_remove_txt_how_to_add_new_ecards_by_ftp_guide=str_replace("%cat_dir_physical_path%","$ecard_root/resource/picture/$cat_dir",$ecard_add_remove_txt_how_to_add_new_ecards_by_ftp_guide);
	$ecard_add_remove_txt_how_to_add_new_ecards_by_ftp_guide=str_replace("%cat_dir%","$cat_dir",$ecard_add_remove_txt_how_to_add_new_ecards_by_ftp_guide);
	$ecard_add_remove_txt_how_to_add_new_ecards_by_ftp_guide=str_replace("%url%","index.php?step=$step&what=load_ecard_2db&cat_id=$cat_id&page=$page",$ecard_add_remove_txt_how_to_add_new_ecards_by_ftp_guide);
	set_global_var("ecard_add_remove_txt_how_to_add_new_ecards_by_ftp_guide",$ecard_add_remove_txt_how_to_add_new_ecards_by_ftp_guide);
	
	print get_html_from_layout("admin/html/admin_manage_ecard_add_remove.html");

	//--------------------------------------------------------------------------------------
	function get_page_count_number($page,$b){
		global $step,$what,$row_number,$cat_id,$keyword,$cmd_button,$cat_dir,$cat_name_display;

		$url="index.php?step=$step&row_number=$row_number&cat_id=$cat_id&what=$what&keyword=$keyword&cmd_button=$cmd_button&cat_dir=$cat_dir&cat_name_display=$cat_name_display";
		$count_number ="";
		
		$y=0;
		if ($b <10){
			for($a_num=1; $a_num<=$b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="<span style=\"cursor: default;\" class='page_active'>&nbsp;$a_num&nbsp;</span>&nbsp;";					
				}
				else {
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">&nbsp;$a_num&nbsp;</a>&nbsp;";
				}
			}
		}
		elseif(($page > 3) && ($page < ($b-3))){
			for($a_num=1; $a_num<=3; $a_num++) {
				$y++;
				$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">&nbsp;$a_num&nbsp;</a>&nbsp;";
			}
			$count_number .="...";
			for($a_num = $page-1; $a_num<=$page+1; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="&nbsp;<span style=\"cursor: default;\" class='page_active'>&nbsp;$a_num&nbsp;</span>&nbsp;";
				}
				else {		
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">&nbsp;$a_num&nbsp;</a>&nbsp;";
				}
			}
			$count_number .="...";
			for($a_num = $b-2; $a_num<=$b; $a_num++) {
				$y++;
				$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">&nbsp;$a_num&nbsp;</a>&nbsp;";
			}
		}
		else{
			for($a_num=1; $a_num<=4; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="&nbsp;<span style=\"cursor: default;\" class='page_active'>&nbsp;$a_num&nbsp;</span>&nbsp;";
				}
				else {
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">&nbsp;$a_num&nbsp;</a>&nbsp;";
				}
			}
			$count_number .="...";			
			for($a_num=$b-3; $a_num<=$b; $a_num++) {
				$y++;
				if ($a_num == $page) {
					$count_number .="&nbsp;<span style=\"cursor: default;\" class='page_active'>&nbsp;$a_num&nbsp;</span>&nbsp;";
				}
				else {	
					$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num\">&nbsp;$a_num&nbsp;</a>&nbsp;";
				}
			}
		}
		set_global_var("d_num",$b);
		return $count_number;
	}

	//--------------------------------------------------------------------------------------
	function load_ecard_2db($cat_id){
		global $ecard_root,$gmt_timestamp_now,$cf_new_card_for_free,$cf_thumb_width_member_card;
		$cat_row=get_row("max_category","cat_relate_id,cat_name_display,cat_dir","cat_id='$cat_id'");

		//Auto create thumbnail
		auto_thumbnail($cat_row);

		if($cf_new_card_for_free=="0"){
			$ec_group_relate_id=",1,";
		}
		else{
			$ec_group_relate_id=",2,";
		}
		$cat_row[cat_name_display] = str_replace("'","''",$cat_row[cat_name_display]);
		$list_thumb = get_list_file("$ecard_root/resource/picture/$cat_row[cat_dir]","_thumb");
		$list_thumb=array_unique($list_thumb);
		$list_filename=get_dblistvalue("max_ecard","ec_filename","ec_cat_dir ='$cat_row[cat_dir]' and ec_user_name_id=''");
		$field_name ="(ec_filename,ec_thumbnail,ec_cat_id,ec_cat_dir,ec_cat_name_display,ec_time,ec_cat_relate_id,ec_group_relate_id,ec_user_name_id)";
		foreach ($list_thumb as $aThumb){
			$field_value="";
			$file = str_replace("_thumb","",$aThumb);
			$name = substr($file,0,strlen($file)-4);
			$file2="";
			if (file_exists("$ecard_root/resource/picture/$cat_row[cat_dir]/$name.jpg"))
				$file2 ="$name.jpg"; 
			if (file_exists("$ecard_root/resource/picture/$cat_row[cat_dir]/$name.gif"))
				$file2 ="$name.gif"; 
			if (file_exists("$ecard_root/resource/picture/$cat_row[cat_dir]/$name.png"))
				$file2 ="$name.png"; 
			if (file_exists("$ecard_root/resource/picture/$cat_row[cat_dir]/$name.swf"))
				$file2 ="$name.swf";	
			if (file_exists("$ecard_root/resource/picture/$cat_row[cat_dir]/$name.mov"))
				$file2 ="$name.mov";
			if (file_exists("$ecard_root/resource/picture/$cat_row[cat_dir]/$name.m4v"))
				$file2 ="$name.m4v";	
			if (file_exists("$ecard_root/resource/picture/$cat_row[cat_dir]/$name.mp4"))
				$file2 ="$name.mp4";
			if (file_exists("$ecard_root/resource/picture/$cat_row[cat_dir]/$name.dcr"))
				$file2 ="$name.dcr";	
			
			//Check ec_filename - if it is not exist then add files to database
			if($file2 !="" && !in_array($file2,$list_filename)){
				$field_value .="('$file2','$aThumb',$cat_id,'$cat_row[cat_dir]','$cat_row[cat_name_display]',$gmt_timestamp_now,'$cat_row[cat_relate_id]','$ec_group_relate_id','')";
				$ecard_add_remove_message_load_thumbnail_full_size=str_replace("%aThumb%",$aThumb,$ecard_add_remove_message_load_thumbnail_full_size);
				$ecard_add_remove_message_load_thumbnail_full_size=str_replace("%file2%",$file2,$ecard_add_remove_message_load_thumbnail_full_size);
				$ecard_add_remove_message_load_thumbnail_full_size=str_replace("%cat_name_display%",$cat_row[cat_name_display],$ecard_add_remove_message_load_thumbnail_full_size);
				$show_info .="<span class=\"OK_Message\">$ecard_add_remove_message_load_thumbnail_full_size</span><br />\n";
			}
			insert_data_to_db("max_ecard",$field_name,$field_value);
			
			$inserted_ec_id=mysql_insert_id();
			$field_name_1="(ec_id,ec_cat_id)";
			$field_value_1="('$inserted_ec_id','$cat_id')";
			insert_data_to_db("max_ecard_category",$field_name_1,$field_value_1);
		}

		//Delete row from database if thumbnail or full size image not found on server
		//$list_data =set_array_from_query("max_ecard","ec_id,ec_thumbnail,ec_filename","ec_cat_dir='$cat_row[cat_dir]' and ec_user_name_id=''");
		$list_data =set_array_from_query("max_ecard","ec_id,ec_thumbnail,ec_filename","ec_cat_dir='$cat_row[cat_dir]' and ec_user_name_id='' and ec_filename not like '%.mp4%' and ec_filename not like '%.MP4%' and ec_filename not like '%.html%' and ec_filename not like '%.HTML%'"); // not mp4
		foreach ($list_data as $row){
			$val=$row[ec_id];
			if(!file_exists("$ecard_root/resource/picture/$cat_row[cat_dir]/$row[ec_thumbnail]") || !file_exists("$ecard_root/resource/picture/$cat_row[cat_dir]/$row[ec_filename]")){
				delete_row("max_ecard","ec_id='$val' LIMIT 1");
				delete_row("max_ecard_category","ec_id='$val' LIMIT 1");
				$ecard_add_remove_message_remove_card_id_from_database=str_replace("%val%",$val,$ecard_add_remove_message_remove_card_id_from_database);
				$ecard_add_remove_message_remove_card_id_from_database=str_replace("%ec_thumbnail%",$row[ec_thumbnail],$ecard_add_remove_message_remove_card_id_from_database);
				$ecard_add_remove_message_remove_card_id_from_database=str_replace("%ec_filename%",$row[ec_filename],$ecard_add_remove_message_remove_card_id_from_database);
				$ecard_add_remove_message_remove_card_id_from_database=str_replace("%cat_dir%","$ecard_root/resource/picture/$cat_row[cat_dir]",$ecard_add_remove_message_remove_card_id_from_database);
				$show_info .="<span class=\"Error_Message\">$ecard_add_remove_message_remove_card_id_from_database</span><br />\n";
			}
		}

		//Refresh sort order - new files will stay on top
		RefreshSortOrder();
		return $show_info;
	}

	//--------------------------------------------------------------------------------------
	function auto_thumbnail($cat_row){
		global $ecard_root,$cf_thumb_width_member_card;

		//Auto create thumbnail if not found 
		$list = get_list_file("$ecard_root/resource/picture/$cat_row[cat_dir]","(_thumb|swf)","donotmatch");//list all files but not thumbnail and flash .swf
		foreach($list as $val){
			$getfilename = $val;
			$getfilename = preg_replace ("/(\.jpg|\.gif|\.png)/i","", $getfilename);			
			$file_exists ="0";

			if(file_exists("$ecard_root/resource/picture/$cat_row[cat_dir]/$getfilename" ."_thumb.gif"))
				$file_exists = "1";
			if(file_exists("$ecard_root/resource/picture/$cat_row[cat_dir]/$getfilename" ."_thumb.jpg"))
				$file_exists = "1";
			if(file_exists("$ecard_root/resource/picture/$cat_row[cat_dir]/$getfilename" ."_thumb.png"))
				$file_exists = "1";
			if(file_exists("$ecard_root/resource/picture/$cat_row[cat_dir]/$getfilename" ."_thumb.Gif"))
				$file_exists = "1";
			if(file_exists("$ecard_root/resource/picture/$cat_row[cat_dir]/$getfilename" ."_thumb.Jpg"))
				$file_exists = "1";
			if(file_exists("$ecard_root/resource/picture/$cat_row[cat_dir]/$getfilename" ."_thumb.Png"))
				$file_exists = "1";
			if(file_exists("$ecard_root/resource/picture/$cat_row[cat_dir]/$getfilename" ."_thumb.GIF"))
				$file_exists = "1";
			if(file_exists("$ecard_root/resource/picture/$cat_row[cat_dir]/$getfilename" ."_thumb.JPG"))
				$file_exists = "1";
			if(file_exists("$ecard_root/resource/picture/$cat_row[cat_dir]/$getfilename" ."_thumb.PNG"))
				$file_exists = "1";

			if($file_exists =="0"){//Thumbnail not found
				$file_upload_name ="$ecard_root/resource/picture/$cat_row[cat_dir]/$val";
				$check_file_type =strtolower($val);
				if(!(strpos($check_file_type,".gif")===false))
					$file_upload_name_thumb = $getfilename . "_thumb.gif";
				if(!(strpos($check_file_type,".jpg")===false))
					$file_upload_name_thumb = $getfilename . "_thumb.jpg";
				if(!(strpos($check_file_type,".png")===false))
					$file_upload_name_thumb = $getfilename . "_thumb.png";				

				$file_upload_name_thumb ="$ecard_root/resource/picture/$cat_row[cat_dir]/$file_upload_name_thumb";
				
				$image_info = getimagesize($file_upload_name);
				$type=$image_info['mime'];
				$img_width =$image_info[0];
				$img_height=$image_info[1];
				if($type =="image/jpeg" || $type =="image/gif" || $type =="image/png"){
					if($img_width > $cf_thumb_width_member_card){
						resize_myimage($type,$file_upload_name,$file_upload_name_thumb,"thumb");
					}
					else{
						copy($file_upload_name, $file_upload_name_thumb);								
					}
				}
			}			
		}
	}

	//--------------------------------------------------------------------------------------
	function RefreshSortOrder(){
		global $cat_id;
		$list_sort=set_array_from_query("max_ecard","ec_id,ec_order","ec_user_name_id='' and ec_cat_id='$cat_id' Order by ec_active DESC,ec_order,ec_id");
		$xorder=0;
		foreach($list_sort as $array_sort){
			$xorder++;
			update_field_in_db("max_ecard","ec_order",$xorder,"ec_id='$array_sort[ec_id]' LIMIT 1");
		}
	}
	function insert_data_to_db1($table_name,$field_name,$field_value){
		$sql="Insert into $table_name $field_name values $field_value";
//if ($table_name=="max_user_invite") {		print $sql; }
		mysql_query($sql,make_db_connect());
	}
?>