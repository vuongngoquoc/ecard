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
	if(ECARDMAX!=1)exit;
	if ($admin_login != $crypt_pass){
		//Show login page
		print get_html_from_layout("admin/html/show_login.html");
		exit;
	}		

	//Update new language database
	$list_lang_file=get_list_file("$ecard_root/languages","_lang.php$");
	make_db_connect();
	foreach($list_lang_file as $val){
		$val = str_replace(".php","",$val);
		$ec_caption_val = "ec_caption_" . $val;
		$ec_detail_val = "ec_detail_" . $val;

		$iv_caption_val = "iv_caption_" . $val;
		$iv_detail_val = "iv_detail_" . $val;
		$iv_default_message_val = "iv_default_message_" . $val;

		$val = "cat_" . $val;

		$query = mysql_query("SHOW COLUMNS FROM max_category LIKE '$val'") or die(mysql_error()); 
		if (mysql_num_rows($query) == 0) {     
			$sql = "ALTER TABLE `max_category` ADD `$val` VARCHAR( 100 ) NULL" ;
			mysql_query($sql);
		}

		$query = mysql_query("SHOW COLUMNS FROM max_ecard LIKE '$ec_caption_val'") or die(mysql_error()); 
		if (mysql_num_rows($query) == 0) {     
			$sql = "ALTER TABLE `max_ecard` ADD `$ec_caption_val` VARCHAR( 100 ) NULL" ;
			mysql_query($sql);
		}

		$query = mysql_query("SHOW COLUMNS FROM max_ecard LIKE '$ec_detail_val'") or die(mysql_error()); 
		if (mysql_num_rows($query) == 0) {     
			$sql = "ALTER TABLE `max_ecard` ADD `$ec_detail_val` VARCHAR( 255 ) NULL" ;
			mysql_query($sql);
		}

/*		$query = mysql_query("SHOW COLUMNS FROM max_category_invite LIKE '$val'") or die(mysql_error()); 
		if (mysql_num_rows($query) == 0) {     
			$sql = "ALTER TABLE `max_category_invite` ADD `$val` VARCHAR( 100 ) NULL" ;
			mysql_query($sql);
		}

		$query = mysql_query("SHOW COLUMNS FROM max_ecard_invite LIKE '$iv_default_message_val'") or die(mysql_error()); 
		if (mysql_num_rows($query) == 0) {     
			$sql = "ALTER TABLE `max_ecard_invite` ADD `$iv_default_message_val`  TEXT NULL" ;
			mysql_query($sql);
		}

		$query = mysql_query("SHOW COLUMNS FROM max_ecard_invite LIKE '$iv_caption_val'") or die(mysql_error()); 
		if (mysql_num_rows($query) == 0) {     
			$sql = "ALTER TABLE `max_ecard_invite` ADD `$iv_caption_val` VARCHAR( 100 ) NULL" ;
			mysql_query($sql);
		} 

		$query = mysql_query("SHOW COLUMNS FROM max_ecard_invite LIKE '$iv_detail_val'") or die(mysql_error()); 
		if (mysql_num_rows($query) == 0) {     
			$sql = "ALTER TABLE `max_ecard_invite` ADD `$iv_detail_val` VARCHAR( 255 ) NULL" ;
			mysql_query($sql);
		}
*/
	}

	if($what=="add_new"){		
		//Create new folder $cat_dir
		//Check if cat_dir already exist
		$chk_cat_dir =get_dbvalue("max_category","cat_id","cat_dir='$cat_dir'");
		if(file_exists("$ecard_root/resource/picture/$cat_dir") || $chk_cat_dir !=""){
			$cat_dir=$cat_dir.substr(md5(uniqid(rand(),1)), 0, 8);
		}
		mkdir("$ecard_root/resource/picture/$cat_dir",0777);
		chmod("$ecard_root/resource/picture/$cat_dir",0777);

		//Create cat_dir_id
		$cat_dir_id=substr(md5(uniqid(rand(),1)), 0, 8);

		//Create cat_relate_id
		if($cat_id!=""){//Sub cat
			$row_data=get_row("max_category","*","cat_id='$cat_id'");
			$cat_relate_id="$row_data[cat_relate_id],$cat_dir_id";			
			$cat_order=get_dbvalue("max_category","max(cat_order)","cat_parent='$row_data[cat_parent]'") + 1;
		}
		else{//Main cat
			$cat_relate_id=$cat_dir_id;
			$cat_order=get_dbvalue("max_category","max(cat_order)","cat_parent=''") + 1;
		}

		$field_name ="(cat_relate_id,cat_dir_id,cat_order,cat_name_display,cat_dir,cat_parent,cat_active,cat_time,cat_keyword,cat_description,cat_title)";
		$field_value ="('$cat_relate_id','$cat_dir_id',$cat_order,'$cat_name_display','$cat_dir','$row_data[cat_dir]',$cat_active,$gmt_timestamp_now,'$cat_keyword','$cat_description','$cat_title')";
		insert_data_to_db("max_category",$field_name,$field_value);
		$show_info .="<br /><span class=OK_Message>$ecard_manage_message_new_category_added</span><br />\n";
		$what="";
		set_global_var("what","");
	}
	elseif($what=="delete_selected"){				
		//Find all ecards in this cat & delete them
		$list_all=set_array_from_query("max_ecard","ec_id,ec_filename,ec_thumbnail,ec_cat_dir","ec_cat_relate_id like '%$cat_dir_id%'");
		$show_info="";
		foreach($list_all as $array){
			//Delete thumbnail ecard
			if(is_writable("$ecard_root/resource/picture/$array[ec_cat_dir]/$array[ec_thumbnail]") && is_writable("$ecard_root/resource/picture/$array[ec_cat_dir]/$array[ec_filename]")){
				//Delete files 
				@unlink("$ecard_root/resource/picture/$array[ec_cat_dir]/$array[ec_thumbnail]");
				@unlink("$ecard_root/resource/picture/$array[ec_cat_dir]/$array[ec_filename]");

				//Delete row database
				delete_row("max_ecard","ec_id='$array[ec_id]' LIMIT 1");
			}
			else{
				//Permission denied - can't delete file so we have to set database ecard inactive
				update_field_in_db("max_ecard","ec_active",0,"ec_id='$array[ec_id]' LIMIT 1");
				$ecard_manage_message_server_cant_delete_files=str_replace("%ec_thumbnail%","resource/picture/$array[ec_cat_dir]/$array[ec_thumbnail]",$ecard_manage_message_server_cant_delete_files);
				$ecard_manage_message_server_cant_delete_files=str_replace("%ec_filename%","$array[ec_filename]",$ecard_manage_message_server_cant_delete_files);
				$show_info .="<span class=\"Error_Message\">$ecard_manage_message_server_cant_delete_files</span><br />";
			}
		}

		//Find all ecard's folders in this cat & delete them
		$list_all=set_array_from_query("max_category","cat_id,cat_dir,cat_name_display","cat_relate_id like '%$cat_dir_id%'");
		foreach($list_all as $array){
			if(is_writable("$ecard_root/resource/picture/$array[cat_dir]")){
				@rmdir("$ecard_root/resource/picture/$array[cat_dir]");				
			}
		}

		//Delete database cat_id
		foreach($list_all as $array){
			if(!file_exists("$ecard_root/resource/picture/$array[cat_dir]")){
				//All folders were deleted successful -> delete cat_id
				delete_row("max_category","cat_dir='$array[cat_dir]' LIMIT 1");				
				$ecard_manage_message_category_name_deleted=str_replace("%cat_name_display%","$array[cat_name_display]",$ecard_manage_message_category_name_deleted);
				$show_info .="<span class=\"OK_Message\">$ecard_manage_message_category_name_deleted</span><br />";
			}
			else{
				//Server can't delete folder? we have to set cat_id inactive
				update_field_in_db("max_category","cat_active",0,"cat_dir='$array[cat_dir]' LIMIT 1");
				$ecard_manage_message_cant_delete_category_folder_name=str_replace("%ec_cat_dir%","$array[ec_cat_dir]",$ecard_manage_message_cant_delete_category_folder_name);
				$show_info .="<span class=\"Error_Message\"> $ecard_manage_message_cant_delete_category_folder_name</span><br />";
			}
		}
		$what="";
		set_global_var("what","");
	}
	elseif($what=="set_sort_order"){
		if($cat_id==""){//Main category
			$list_sort=set_array_from_query("max_category","cat_id,cat_order","cat_parent='' Order by cat_order,cat_name_display");
		}
		else{//Sub
			$cat_dir=get_dbvalue("max_category","cat_dir","cat_id='$cat_id'");
			$list_sort=set_array_from_query("max_category","cat_id,cat_order","cat_parent='$cat_dir' Order by cat_order,cat_name_display");
		}
		foreach($list_sort as $array_sort){
			if($current_sort > $sort_number){
				if($array_sort[cat_order]>=$sort_number){			
					update_field_in_db("max_category","cat_order",$array_sort[cat_order]+1,"cat_id='$array_sort[cat_id]' LIMIT 1");
				}
			}
			else{
				if($array_sort[cat_order]<=$sort_number){			
					update_field_in_db("max_category","cat_order",$array_sort[cat_order]-1,"cat_id='$array_sort[cat_id]' LIMIT 1");
				}
			}
		}		
		update_field_in_db("max_category","cat_order",$sort_number,"cat_id='$cat_id_sort' LIMIT 1");
		$what="";
		set_global_var("what","");
	}
	elseif($what=="move_cat2"){
		
		$array_cat_id_move = get_row('max_category', '*', "cat_id='$cat_id_move'");
		/*
		$array_2cat=set_array_from_query("max_category","*","cat_id='$cat_id' or cat_id='$cat_id_move'");
		if($array_2cat[0][cat_id]==$cat_id){
			$array_cat_id=$array_2cat[0];
			$array_cat_id_move=$array_2cat[1];
		}
		else{
			$array_cat_id=$array_2cat[1];
			$array_cat_id_move=$array_2cat[0];
		}
		*/
		
		if($cat_id==""){//cat_id_move will become MAIN ROOT cat
			if($array_cat_id_move[cat_parent]!=""){
				// cat_id_move current status is not a main root -> then make it a main root / otherwise do nothing
				$list_all_cat_id_move=set_array_from_query("max_category","*","cat_relate_id like '%$array_cat_id_move[cat_relate_id]%' and cat_id<>'$cat_id_move' ");
				foreach($list_all_cat_id_move as $array_me){
					$new_cat_relate_id=str_replace($array_cat_id_move[cat_relate_id],$array_cat_id_move[cat_dir_id],$array_me[cat_relate_id]);
					update_field_in_db("max_category","cat_relate_id","$new_cat_relate_id","cat_id='$array_me[cat_id]' LIMIT 1");
				}
				$last_cat_order=get_dbvalue("max_category","count(cat_id)","cat_parent=''")+1;
				update_field_in_db2("max_category","cat_relate_id='$array_cat_id_move[cat_dir_id]',cat_parent='',cat_order=$last_cat_order", "cat_id='$cat_id_move' LIMIT 1");

				//update table max_ecard (ec_cat_relate_id)
				$list_all_ec_id=set_array_from_query("max_ecard","ec_id,ec_cat_relate_id","ec_cat_relate_id like '%$array_cat_id_move[cat_relate_id]%'");
				foreach($list_all_ec_id as $array_me){
					$new_cat_relate_id=str_replace($array_cat_id_move[cat_relate_id],$array_cat_id_move[cat_dir_id],$array_me[ec_cat_relate_id]);
					update_field_in_db("max_ecard","ec_cat_relate_id","$new_cat_relate_id","ec_id='$array_me[ec_id]' LIMIT 1");
				}
				$ecard_manage_message_category_and_subcate_removed=str_replace("%cat_name_display%","$array_cat_id_move[cat_name_display]",$ecard_manage_message_category_and_subcate_removed);
				$show_info ="<br /><span class=OK_Message>$ecard_manage_message_category_and_subcate_removed</span><br />\n";
			}
		}
		else{//cat_id_move will become a sub cat 
			$array_cat_id = get_row('max_category', '*', "cat_id='$cat_id'");
			$list_all_cat_id_move=set_array_from_query("max_category","*","cat_relate_id like '%$array_cat_id_move[cat_relate_id]%' and cat_id<>'$cat_id_move' ");
			
			foreach($list_all_cat_id_move as $array_me){
				$new_cat_relate_id=str_replace($array_cat_id_move[cat_relate_id],$array_cat_id[cat_relate_id].",$array_cat_id_move[cat_dir_id]",$array_me[cat_relate_id]);
				update_field_in_db("max_category","cat_relate_id","$new_cat_relate_id","cat_id='$array_me[cat_id]' LIMIT 1");
			}
			$last_cat_order=get_dbvalue("max_category","count(cat_id)","cat_parent='$array_cat_id[cat_dir]'")+1;
			
			update_field_in_db2("max_category","cat_relate_id='$array_cat_id[cat_relate_id],$array_cat_id_move[cat_dir_id]',cat_parent='$array_cat_id[cat_dir]',cat_order=$last_cat_order", "cat_id='$cat_id_move' LIMIT 1");
			
			//update table max_ecard (ec_cat_relate_id)
			$list_all_ec_id=set_array_from_query("max_ecard","ec_id,ec_cat_relate_id","ec_cat_relate_id like '%$array_cat_id_move[cat_relate_id]%'");
			foreach($list_all_ec_id as $array_me){
				$new_cat_relate_id=str_replace($array_cat_id_move[cat_relate_id],$array_cat_id[cat_relate_id].",$array_cat_id_move[cat_dir_id]",$array_me[ec_cat_relate_id]);
				update_field_in_db("max_ecard","ec_cat_relate_id","$new_cat_relate_id","ec_id='$array_me[ec_id]' LIMIT 1");
			}
			$ecard_manage_message_category_and_subcate_removed=str_replace("%cat_name_display%","$array_cat_id_move[cat_name_display]",$ecard_manage_message_category_and_subcate_removed);
			$show_info ="<br /><span class=OK_Message>$ecard_manage_message_category_and_subcate_removed</span><br />\n";
		}
		$what="";//reset
		set_global_var("what","");
	}
	
	if($cat_id==""){//Main category
		if($what=="move_cat"){
			$list_data=set_array_from_query("max_category","*","cat_parent='' and cat_id<>'$cat_id_move' Order by cat_order,cat_name_display");
		}
		else{
			$list_data=set_array_from_query("max_category","*","cat_parent='' Order by cat_order,cat_name_display");
		}
		
		//Show up one level icon
		set_global_var("show_up_one_level","");

		//Hide bar add ecard
		set_global_var("hide_this_div","display:none;");

		//Show sub oro main
		set_global_var("show_sub_or_main","Main");
	}
	else{//Sub	
		$cat_row=get_row("max_category","*","cat_id='$cat_id'");
		//print_r($cat_row);
		if($what=="move_cat"){
			$list_data=set_array_from_query("max_category","*","cat_parent='$cat_row[cat_dir]' and cat_id<>'$cat_id_move' Order by cat_order,cat_name_display");
		}
		else{
			$list_data=set_array_from_query("max_category","*","cat_parent='$cat_row[cat_dir]' Order by cat_order,cat_name_display");
		}
		
		//Show up one level icon
		$get_parent_id=get_dbvalue("max_category","cat_id","cat_dir='$cat_row[cat_parent]'");
		set_global_var("show_up_one_level","<a href=\"index.php?step=$step&cat_id=$get_parent_id&cat_id_move=$cat_id_move&what=$what\"><img border=\"0\" title=\"$ecard_manage_tooltip_up_one_level\" alt=\"$ecard_manage_tooltip_up_one_level\" src=\"html/07_icon_up1level.gif\" style=\"vertical-align:middle;\" /></a>");

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
					$show_cat_nav_tmp .= " <a href=\"index.php?step=$step&cat_id=$array_nav[cat_id]&cat_id_move=$cat_id_move&what=$what\">$array_nav[cat_name_display]</a>,";
				}
			}
			$show_cat_nav .= $show_cat_nav_tmp;
		}
		$show_cat_nav_no_link=strip_tags($show_cat_nav);
		$show_cat_nav_no_link=str_replace(","," <img border=\"0\" alt=\"\" src=\"html/2rightarrow12.gif\" />",$show_cat_nav_no_link);
		if($show_cat_nav{strlen($show_cat_nav)-1} ==",") $show_cat_nav = substr($show_cat_nav, 0, strlen($show_cat_nav)-1);		
		$show_cat_nav=str_replace(","," <img border=\"0\" alt=\"\" src=\"html/2rightarrow12.gif\" />",$show_cat_nav);
		set_global_var("show_cat_nav",$show_cat_nav);		

		//Show bar add ecard
		set_global_var("hide_this_div","display:block;");
		//set_global_var("show_cat_name_display",$cat_row[cat_name_display]);
		set_global_var("show_cat_name_display",str_replace("'","\\'",$cat_row[cat_name_display]));
		$show_cat_name_display2=str_replace("'","\\'",$cat_row[cat_name_display]);
		set_global_var("show_cat_name_display2",$show_cat_name_display2);
		set_global_var("show_cat_dir",$cat_row[cat_dir]);

		//Show sub or main
		set_global_var("show_sub_or_main","Sub");
	}

	if($what=="move_cat"){
		$cat_row=get_row("max_category","*","cat_id='$cat_id_move'");
		set_global_var("cat_name_display",$cat_row[cat_name_display]);

		foreach($list_data as $row_data){
			$val = $row_data[cat_id] ;
						
			//Detect sub category
			$chk_sub=get_dbvalue("max_category","count(cat_id)","cat_relate_id like '%$row_data[cat_dir_id]%'") - 1;
			if($chk_sub > 0){
				$ecard_manage_tooltip_click_to_open_category=str_replace("%cat_name_display%","$row_data[cat_name_display]",$ecard_manage_tooltip_click_to_open_category);
				$show_folder_icon="<img border=\"0\" alt=\"$ecard_manage_tooltip_click_to_open_category\" title=\"$ecard_manage_tooltip_click_to_open_category\" src=\"html/07_icon_open_folder.gif\" /> $row_data[cat_name_display]";
			}
			else{
				$ecard_manage_tooltip_click_to_open_category=str_replace("%cat_name_display%","$row_data[cat_name_display]",$ecard_manage_tooltip_click_to_open_category);
				$show_folder_icon="<img border=\"0\" alt=\"$ecard_manage_tooltip_click_to_open_category\" title=\"$ecard_manage_tooltip_click_to_open_category\" src=\"html/07_icon_open_folder_empty.gif\" /> $row_data[cat_name_display]";
			}
			
			$show_list_table .="<tr id=\"tr$val\" style=\"background-image: url(html/07_title_background2.gif);line-height:20px\">\n";		
			$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" onclick=\"location.href='index.php?step=$step&cat_id=$val&cat_id_move=$cat_id_move&what=$what';\">$show_folder_icon</td>\n";
			$show_list_table .="</tr>\n";
		}

		$show_list_table .="<tr id=\"tr$val\" style=\"background-image: url(html/07_title_background2.gif);line-height:20px\">\n";		
		$show_list_table .="<td width=\"100%\" style=\"padding:4px;font-weight:bold;color:green\"><img border=\"0\" alt=\"\" src=\"html/07_icon_move_category.gif\" style=\"vertical-align:middle\"/> $cat_row[cat_name_display]</td>\n";
		$show_list_table .="</tr>\n";

		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: white;line-height:20px;font-weight:bold\">\n";		
		$ecard_manage_txt_click_to_move_category_and_subcat_to_position=str_replace("%cat_name_display%","$cat_row[cat_name_display]",$ecard_manage_txt_click_to_move_category_and_subcat_to_position);
		$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;text-decoration:underline;\" onclick=\"location.href='index.php?step=$step&what=move_cat2&cat_id_move=$cat_id_move&cat_id=$cat_id';\"><img alt=\"\" border=\"0\" src=\"html/07_icon_upper.gif\" /> $ecard_manage_txt_click_to_move_category_and_subcat_to_position</td>\n";
		$show_list_table .="</tr>\n";

		set_global_var("show_list_table",$show_list_table);

		set_global_var("print_object",get_html_from_layout("admin/html/admin_manage_ecard_move_cat.html"));	
		print_admin_header_footer_page();
		exit;
	}

	set_global_var("show_cat_nav_no_link","$ecard_manage_txt_main_root <img border=\"0\" alt=\"\" src=\"html/2rightarrow12.gif\" /> $show_cat_nav_no_link");
	$count_sort=count($list_data);
	
	$xorder=0;
	foreach($list_data as $row_data){
		$val = $row_data[cat_id] ;
		
		//Update cat_order
		$xorder++;
		if($xorder!=$row_data[cat_order]){
			update_field_in_db("max_category","cat_order",$xorder,"cat_id='$val' LIMIT 1");
		}
		
		//Show active
		if($row_data[cat_active]=="1"){
			$checked_it ="checked=\"checked\"";
		}
		else{
			$checked_it ="";
		}

		//Show birthday icon if cat was set a birthday category
		if($cf_birthday_cat_id==$val){
			$ecard_manage_tooltip_click_to_set_category_as_birthday=str_replace("%cat_name_display%","$row_data[cat_name_display]",$ecard_manage_tooltip_click_to_set_category_as_birthday);
			$show_birthday_icon="<img id=\"birthday_cake$val\" border=\"0\" alt=\"$ecard_manage_tooltip_click_to_set_category_as_birthday\" title=\"$ecard_manage_tooltip_click_to_set_category_as_birthday\" src=\"html/07_icon_set_birthday_cat_ac.gif\" style=\"cursor:pointer;\" onclick=\"SetBirthdayCat('$val');\" />";			
		}
		else{
			$ecard_manage_tooltip_click_to_set_category_as_birthday=str_replace("%cat_name_display%","$row_data[cat_name_display]",$ecard_manage_tooltip_click_to_set_category_as_birthday);
			$show_birthday_icon="<img id=\"birthday_cake$val\" border=\"0\" alt=\"$ecard_manage_tooltip_click_to_set_category_as_birthday\" title=\"$ecard_manage_tooltip_click_to_set_category_as_birthday\" src=\"html/07_icon_set_birthday_cat_in.gif\" style=\"cursor:pointer;\" onclick=\"SetBirthdayCat('$val');\" />";
		}
		
		//Detect sub category
		$chk_sub=get_dbvalue("max_category","count(cat_id)","cat_relate_id like '%$row_data[cat_dir_id]%'") - 1;
		if($chk_sub > 0){
			$ecard_manage_tooltip_click_to_open_category=str_replace("%cat_name_display%","$row_data[cat_name_display]",$ecard_manage_tooltip_click_to_open_category);
			$show_folder_icon="<a href=\"index.php?step=$step&cat_id=$val\"><img border=\"0\" alt=\"$ecard_manage_tooltip_click_to_open_category\" title=\"$ecard_manage_tooltip_click_to_open_category\" src=\"html/07_icon_open_folder.gif\" /></a>";
		}
		else{
			$ecard_manage_tooltip_click_to_open_category=str_replace("%cat_name_display%","$row_data[cat_name_display]",$ecard_manage_tooltip_click_to_open_category);
			$show_folder_icon="<a href=\"index.php?step=$step&cat_id=$val\"><img border=\"0\" alt=\"$ecard_manage_tooltip_click_to_open_category\" title=\"$ecard_manage_tooltip_click_to_open_category\" src=\"html/07_icon_open_folder_empty.gif\" /></a>";
		}

		//Show category name + meta tag keyword & description
		$show_cat_name ="$show_folder_icon<input id=\"cat_name_display$val\" title=\"$ecard_manage_tooltip_click_to_edit\" type=\"text\" value=\"$row_data[cat_name_display]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:300px;text-decoration:underline;\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"Editme('index.php?step=edit_me&table=max_category&edit_id=cat_id&edit_id_value=$val&edit_key=cat_name_display&edit_value=',this.value,'1',original_value,this.id);\" />";
		if ($row_data[cat_dir_id]=='51feac2bttt') {
			//$a = set_array_from_query("max_ecard","*","ec_cat_relate_id LIKE '%51feac2b%'");print_r($a);
			$show_total_ecard_this_cat=get_dbvalue("max_ecard","count(*)","ec_cat_relate_id LIKE '%51feac2b%'");print_r($show_total_ecard_this_cat);die;
		}		

		//Show total ecard for each category
		$show_total_ecard_this_cat=get_dbvalue("max_ecard","count(ec_id)","ec_cat_relate_id like '%$row_data[cat_dir_id]%'");

		//Show delete button
		$show_delete_button="<img onclick=\"document.getElementById('tr$val').style.backgroundColor='#E4E4D3';if(window.confirm('$ecard_manage_message_confirm_to_delete')){location.href='index.php?step=$step&what=delete_selected&cat_id_select=$val&cat_id=$cat_id&cat_dir_id=$row_data[cat_dir_id]&cat_dir=$row_data[cat_dir]';}else{document.getElementById('tr$val').style.backgroundColor='#EAEAEA';}\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$ecard_manage_tooltip_delete_account\" title=\"$ecard_manage_tooltip_delete_account\" />";

		//Show sort order dropdown menu
		$show_sort="<select size=\"1\" name=\"cat_order$val\" id=\"cat_order$val\" onchange=\"location.href='index.php?step=$step&what=set_sort_order&cat_id_sort=$val&cat_id=$cat_id&current_sort=$xorder&sort_number='+this.value;\">";
		for($i=1;$i<=$count_sort;$i++){
			if($xorder==$i){
				$show_sort.="<option value=\"$i\" selected=\"selected\">$i</option>\n";
			}
			else{
				$show_sort.="<option value=\"$i\" >$i</option>\n";
			}
		}
		$show_sort.="</select>";

		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";		
		$show_list_table .="<td width=\"*\" style=\"padding:4px;\">$show_cat_name</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;\">$chk_sub</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;\">$show_total_ecard_this_cat</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;\">$show_birthday_icon</td>\n";				
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;\"><input $checked_it type=\"checkbox\" value=\"1\" onclick=\"ShowLoaderImage('$ecard_manage_message_updating');if(this.checked){UpdateDataTable('index.php?step=edit_me&table=max_category&edit_id=cat_id&edit_id_value=$val&edit_key=cat_active&edit_value=1');}else{UpdateDataTable('index.php?step=edit_me&table=max_category&edit_id=cat_id&edit_id_value=$val&edit_key=cat_active&edit_value=0');}\" /></td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;\">$show_delete_button</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;\">$show_sort</td>\n";
		$show_list_table .="</tr>\n";
		$bk_id .="$val,";
	}
	if($bk_id{strlen($bk_id)-1} ==",") $bk_id = substr($bk_id, 0, strlen($bk_id)-1);
	set_global_var("bk_id",$bk_id);
	set_global_var("show_list_table",$show_list_table);

	//Disable add new category Submit button if folder resource/picture is not writable
	if (!is_writable("$ecard_root/resource/picture")){
		set_global_var("disable_submit_button","disabled=\"disabled\" style=\"filter: Alpha(Opacity=40);-moz-opacity:0.4;opacity:0.4;\" ");
		$ecard_manage_message_disable_submit_button=str_replace("%picture_path%","$ecard_root/resource/picture",$ecard_manage_message_disable_submit_button);
		$ecard_manage_message_disable_submit_button=str_replace("%url%","index.php?step=$step&cat_id=$cat_id",$ecard_manage_message_disable_submit_button);
		set_global_var("disable_submit_button_message","$ecard_manage_message_disable_submit_button");
	}

	//Fill out value to textbox edit meta keyword, description, title
	set_global_var("edit_cat_keyword",$cat_row[cat_keyword]);
	set_global_var("edit_cat_description",$cat_row[cat_description]);
	set_global_var("edit_cat_title",$cat_row[cat_title]);

	//Count total category and total ecard
	$total_count_category_and_ecard =get_dbvalue("max_category","count(cat_id)") . " categories - " . get_dbvalue("max_ecard","count(ec_id)","ec_user_name_id=''") . " ecards";

	//Show input textbox for translate language	
	$show_list_language_table="";
	foreach($list_lang_file as $mylang){
		$cat_lang_name="cat_".str_replace(".php","",$mylang);
		$cat_lang_name_value=$cat_row[$cat_lang_name];
		if($cf_language==$mylang && $cat_lang_name_value==""){
			$cat_lang_name_value=$cat_row[cat_name_display];
		}

		$mylang_name="Translate <span class=\"OK_Message\">$cat_row[cat_name_display]</span> into " .ucwords(str_replace("_lang.php","",$mylang));
		$show_list_language_table.="<tr style=\"background-color: #EAEAEA;line-height:17px\">\n";
		$show_list_language_table.="<td width=\"30%\">$mylang_name</td>\n";
		$show_list_language_table.="<td width=\"70%\"><input type=\"text\" name=\"$cat_lang_name\" id=\"$cat_lang_name\" value=\"$cat_lang_name_value\" style=\"width:500px\" maxlength=\"100\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&lang=$mylang&table=max_category&edit_id=cat_id&edit_id_value=$cat_id&edit_key=$cat_lang_name&edit_value=',this.value,'0',original_value,this.id);\" /></td>\n";
		$show_list_language_table.="</tr>\n";
	}
	set_global_var("show_list_language_table",$show_list_language_table);

	set_global_var("total_count_category_and_ecard",$total_count_category_and_ecard);
	set_global_var("show_info","<br />$show_info<br />");
	
	$ecard_manage_txt_create_new_category=str_replace("%show_sub_or_main%","$show_sub_or_main",$ecard_manage_txt_create_new_category);
	set_global_var("ecard_manage_txt_create_new_category",$ecard_manage_txt_create_new_category);
	
	$ecard_manage_txt_add_new_category=str_replace("%show_sub_or_main%","$show_sub_or_main",$ecard_manage_txt_add_new_category);
	set_global_var("ecard_manage_txt_add_new_category",$ecard_manage_txt_add_new_category);
	
	$ecard_manage_txt_click_here_to_translate_to_other_language=str_replace("%show_cat_name_display%","$show_cat_name_display",$ecard_manage_txt_click_here_to_translate_to_other_language);
	set_global_var("ecard_manage_txt_click_here_to_translate_to_other_language",$ecard_manage_txt_click_here_to_translate_to_other_language);
	
	$ecard_manage_txt_translate_to_other_language=str_replace("%show_cat_name_display%","$show_cat_name_display",$ecard_manage_txt_translate_to_other_language);
	set_global_var("ecard_manage_txt_translate_to_other_language",$ecard_manage_txt_translate_to_other_language);
	
	$ecard_manage_txt_click_to_move_category=str_replace("%show_cat_name_display%","$show_cat_name_display",$ecard_manage_txt_click_to_move_category);
	set_global_var("ecard_manage_txt_click_to_move_category",$ecard_manage_txt_click_to_move_category);
	
	$ecard_manage_txt_click_to_add_remove_ecard_in_this_category=str_replace("%show_cat_name_display%","$show_cat_name_display",$ecard_manage_txt_click_to_add_remove_ecard_in_this_category);
	set_global_var("ecard_manage_txt_click_to_add_remove_ecard_in_this_category",$ecard_manage_txt_click_to_add_remove_ecard_in_this_category);
	
	set_global_var("print_object",get_html_from_layout("admin/html/admin_manage_ecard.html"));	
	print_admin_header_footer_page();	

?>