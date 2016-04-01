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
	
	//Auto add new music to database if found
	$list_dir_database=get_dblistvalue("max_music","music_filename","ec_cat_id='$cat_id'");
	$list_dir=get_list_file("$ecard_root/resource/music/$cat_dir");
	$db_change ="";
	$music_order=1000;
	/*print "$ecard_root/resource/music/$cat_dir";
	echo "<pre>";print_r($list_dir);echo "</pre>";
	echo "<pre>";print_r($list_dir_database);echo "</pre>";*/
	
	foreach($list_dir as $dir){
		if (!in_array($dir, $list_dir_database)){
			//Insert new music to database
			$music_order++;
			$music_name_display=str_replace("_"," ",$dir);
			$field_name ="(music_name_display,music_filename,music_order,music_user_name_id,ec_cat_id,ec_cat_dir)";
			$field_value ="('$music_name_display','$dir',$music_order,'','$cat_id','$cat_dir')";
			insert_data_to_db("max_music",$field_name,$field_value);
			$db_change ="1";
		}
	}

	//Auto remove music from mysql if it's not found on server
	/*
	foreach($list_dir_database as $dir_mysql){
		if (!in_array($dir_mysql, $list_dir)){
			//Remove from database
			delete_row("max_music","music_filename='$dir_mysql'");
			$db_change ="1";
		}
	}
	*/
	if($db_change=="1")RefreshSortOrder();

	if($what=="add_new"){		
		if (!is_writable("$ecard_root/resource/music")){
			$show_info=$music_message_you_must_chmod_music_folder;
		}
		else{			
			$music_order=get_dbvalue("max_music","count(music_id)","music_user_name_id=''");
			//Upload image
			$upload_dir ="$ecard_root/resource/music/$cat_dir";
			for($i=1;$i<=7;$i++){
				$file_key = "file$i";
				$file_name = $POST_FILES[$file_key]['name'];
				$st_caption = str_replace(".gif","",$file_name);
				$st_caption = str_replace(".jpg","",$st_caption);
				$st_caption = str_replace(".png","",$st_caption);
				$st_caption = str_replace("_"," ",$st_caption);
				$st_caption = str_replace("\"","&quot;",$st_caption);				
				$file_upload_name = $upload_dir."/".$file_name;
				
				if($file_name !=""){
					if (!file_exists($file_upload_name)){
						if(move_uploaded_file($POST_FILES[$file_key]['tmp_name'],$file_upload_name)){
							$music_order++;
							chmod($file_upload_name,0777);							
							$field_name ="(music_name_display,music_filename,music_active,music_order,ec_cat_id,ec_cat_dir)";
							$field_value ="('$st_caption','$file_name','1',$music_order,'$cat_id','$cat_dir')";
							insert_data_to_db("max_music",$field_name,$field_value);
							$music_message_music_filename_added=str_replace("%file_name%",$file_name,$music_message_music_filename_added);
							$show_info .="<span class=OK_Message>$music_message_music_filename_added</span><br />\n";
						}
						else{
							$music_message_can_not_upload_file=str_replace("%file_name%",$file_name,$music_message_can_not_upload_file);
							$show_info .="$music_message_can_not_upload_file<br />\n";
						}
					}
					else{
						$music_message_can_not_upload_file_exist=str_replace("%file_name%",$file_name,$music_message_can_not_upload_file_exist);
						$show_info .="CAN'T uploaded $file_name - File name exists<br />\n";
					}
				}
			}			
		}		
	}
	elseif($what=="load_audio"){
		print "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=$charset' /></head><body style='margin-top:0px;margin-left:0px'><embed src=\"$ecard_url/$src\" autostart=true width=400 height=120 loop=0 hidden=false></embed></body></html>";
		exit;
	}
	elseif($what=="close_player"){
		print "";
		exit;
	}
	elseif($what=="delete_selected"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);
				//Delete files
				//$cat_dir
				$music_filename=get_dbvalue("max_music","music_filename","music_id='$selected_id'");
				$cat_dir=get_dbvalue("max_music","ec_cat_dir","music_id='$selected_id'");				
				if (is_writable("$ecard_root/resource/music/$cat_dir/$music_filename")){
					@unlink("$ecard_root/resource/music/$cat_dir/$music_filename");
					$music_message_music_filename_removed=str_replace("%music_filename%",$music_filename,$music_message_music_filename_removed);
					$show_info .="<span class=\"OK_Message\">$music_message_music_filename_removed</span><br />\n";
				}
				else{
					$music_message_music_filename_cannt_deleted=str_replace("%music_filename%","$ecard_root/resource/music/$cat_dir/$music_filename",$music_message_music_filename_cannt_deleted);
					$show_info .="$music_message_music_filename_cannt_deleted<br />\n";
				}

				//Delete row in database
				delete_row("max_music","music_id='$selected_id' LIMIT 1");
			}
		}
		RefreshSortOrder();
	}
	elseif($what=="set_sort_order"){
		$list_sort=set_array_from_query("max_music","music_id,music_order","music_user_name_id='' and ec_cat_id='$cat_id' Order by music_order,music_name_display");		

		foreach($list_sort as $array_sort){
			if($current_sort > $sort_number){
				if($array_sort[music_order]>=$sort_number){			
					update_field_in_db("max_music","music_order",$array_sort[music_order]+1,"music_id='$array_sort[music_id]' LIMIT 1");
				}
			}
			else{
				if($array_sort[music_order]<=$sort_number){			
					update_field_in_db("max_music","music_order",$array_sort[music_order]-1,"music_id='$array_sort[music_id]' LIMIT 1");
				}
			}
		}
	
		update_field_in_db("max_music","music_order",$sort_number,"music_id='$music_id' LIMIT 1");
		
		RefreshSortOrder();
		$what="";
		set_global_var("what","");
	//MOVE SELECTED CARDS TO ANOTHER FOLDER..	
	}elseif($what=="move_selected"){
		if($cat_id==$current_cat_id)$cat_id="";

		if($cat_id==""){//Main category
			$list_data=set_array_from_query("max_music_cat","*","cat_parent='' Order by cat_order,cat_name_display");
		}
		else{
			$cat_row=get_row("max_music_cat","*","cat_id='$cat_id'");
			$list_data=set_array_from_query("max_music_cat","*","cat_parent='$cat_row[cat_dir]' Order by cat_order,cat_name_display");
		}

		//Show cat navigator
		$array=split(",",$cat_row[cat_relate_id]);
		$where="";
		foreach($array as $cat_dir_id){
			$where .="cat_dir_id='$cat_dir_id',";
		}
		if($where{strlen($where)-1} ==",") $where = substr($where, 0, strlen($where)-1);
		$where=str_replace(","," or ",$where);
		$list_array=set_array_from_query("max_music_cat","cat_id,cat_dir_id,cat_name_display","$where");
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
			$chk_sub=get_dbvalue("max_music_cat","count(cat_id)","cat_relate_id like '%$row_data[cat_dir_id]%'") - 1;
			if($chk_sub > 0){
				if($current_cat_id==$val){
					$show_folder_icon="<img border=\"0\" alt=\"$music_tooltip_current_category\" title=\"$music_tooltip_current_category\" src=\"html/07_icon_stop.gif\" /> $row_data[cat_name_display]";
					$show_list_table .="<tr id=\"tr$val\" style=\"background-image: url(html/07_title_background2.gif);line-height:20px\">\n";		
					$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" title=\"$music_tooltip_current_category\" onclick=\"alert('$music_tooltip_current_category')\">$show_folder_icon</td>\n";
					$show_list_table .="</tr>\n";
				}
				else{
					$music_tooltip_click_to_open_category=str_replace("%cat_name_display%",$row_data[cat_name_display],$music_tooltip_click_to_open_category);
					$show_folder_icon="<img border=\"0\" alt=\"$music_tooltip_click_to_open_category\" title=\"$music_tooltip_click_to_open_category\" src=\"html/07_icon_open_folder.gif\" /> $row_data[cat_name_display]";
					$show_list_table .="<tr id=\"tr$val\" style=\"background-image: url(html/07_title_background2.gif);line-height:20px\">\n";		
					$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" onclick=\"location.href='index.php?step=$step&what=move_selected&current_cat_id=$current_cat_id&cat_id=$val&list_id=$list_id';\">$show_folder_icon</td>\n";
					$show_list_table .="</tr>\n";
				}
			}
			else{

				if($current_cat_id==$val){
					$show_folder_icon="<img border=\"0\" alt=\"$music_tooltip_current_category\" title=\"$music_tooltip_current_category\" src=\"html/07_icon_stop.gif\" /> $row_data[cat_name_display]";
					$show_list_table .="<tr id=\"tr$val\" style=\"background-image: url(html/07_title_background2.gif);line-height:20px\">\n";		
					$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" title=\"$music_tooltip_current_category\" onclick=\"alert('$music_tooltip_current_category')\">$show_folder_icon</td>\n";
					$show_list_table .="</tr>\n";
				}
				else{
					$music_tooltip_click_to_open_category=str_replace("%cat_name_display%",$row_data[cat_name_display],$music_tooltip_click_to_open_category);
					$show_folder_icon="<img border=\"0\" alt=\"$music_tooltip_click_to_open_category\" title=\"$music_tooltip_click_to_open_category\" src=\"html/07_icon_open_folder_empty.gif\" /> $row_data[cat_name_display]";
					$show_list_table .="<tr id=\"tr$val\" style=\"background-image: url(html/07_title_background2.gif);line-height:20px\">\n";		
					$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" onclick=\"location.href='index.php?step=$step&what=move_selected&current_cat_id=$current_cat_id&cat_id=$val&list_id=$list_id';\">$show_folder_icon</td>\n";
					$show_list_table .="</tr>\n";
				}				
			}			
		}		
		
		if($cat_id==""){
			$show_list_table .="<tr id=\"tr$val\" style=\"background-color: white;line-height:20px;font-weight:bold\">\n";		
			$music_txt_please_select_a_category_to_move=str_replace("%list_id%",$list_id,$music_txt_please_select_a_category_to_move);
			$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\">$music_txt_please_select_a_category_to_move</td>\n";
			$show_list_table .="</tr>\n";
		}
		else{
			$show_list_table .="<tr id=\"tr$val\" style=\"background-color: white;line-height:20px;font-weight:bold\">\n";		
			$music_txt_click_here_to_move=str_replace("%cat_name_display%",$cat_row[cat_name_display],$music_txt_click_here_to_move);
			$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" onclick=\"location.href='index.php?step=$step&what=move_selected2&cat_id=$cat_id&current_cat_id=$current_cat_id&list_id=$list_id';\"><img alt=\"\" border=\"0\" src=\"html/07_icon_open_folder.gif\" /> <span style=\"color:green\">$cat_row[cat_name_display]</span> || <span style=\"text-decoration:underline;\">$music_txt_click_here_to_move</span></td>\n";
			$show_list_table .="</tr>\n";
		}
		set_global_var("show_list_table",$show_list_table);
		print get_html_from_layout("admin/html/admin_manage_music_move_ecards.html");			
		exit;
	}elseif($what=="move_selected2"){
		$sql_where="";
		$array_list_id=split(",",$list_id);
		foreach($array_list_id as $music_id){
			if($music_id!=""){
				$sql_where .="music_id='$music_id',";
			}
		}
		if($sql_where{strlen($sql_where)-1} ==",") $sql_where = substr($sql_where, 0, strlen($sql_where)-1);
		$sql_where=str_replace(","," or ",$sql_where);
		$list_selected =set_array_from_query("max_music","*"," $sql_where ");
		$cat_row=get_row("max_music_cat","*","cat_id='$cat_id'");
		foreach($list_selected as $row_data){
			if($cat_id != $row_data[ec_cat_id] && $row_data[ec_user_name_id]==""){
				//Move files
				if(@rename("$ecard_root/resource/music/$row_data[ec_cat_dir]/$row_data[music_filename]", "$ecard_root/resource/music/$cat_row[cat_dir]/$row_data[music_filename]")){
					update_field_in_db2("max_music","ec_cat_id='$cat_row[cat_id]',ec_cat_dir='$cat_row[cat_dir]'","music_id='$row_data[music_id]' LIMIT 1");
					$music_message_your_selected_music_has_been_moved=str_replace("%cat_name_display%",$cat_row[cat_name_display],$music_message_your_selected_music_has_been_moved);
					$show_info .= "<div class=\"OK_Message\">$music_message_your_selected_music_has_been_moved<br /></div>";
				}
				else{
					$music_message_permission_denied_cannt_move_selected=str_replace("%cat_dir%","resource/music/$cat_row[cat_dir]",$music_message_permission_denied_cannt_move_selected);
					$show_info .= "<div class=\"Error_Message\">$music_message_permission_denied_cannt_move_selected<br /></div>";
				}				
			}
		}				
		$cat_id=$current_cat_id;
		RefreshSortOrder();
		$what="";
		set_global_var("what","");
	}elseif($what=="copy_selected"){
		if($cat_id==$current_cat_id)$cat_id="";

		if($cat_id==""){//Main category
			$list_data=set_array_from_query("max_music_cat","*","cat_parent='' Order by cat_order,cat_name_display");
		}
		else{
			$cat_row=get_row("max_music_cat","*","cat_id='$cat_id'");
			$list_data=set_array_from_query("max_music_cat","*","cat_parent='$cat_row[cat_dir]' Order by cat_order,cat_name_display");
		}

		//Show cat navigator
		$array=split(",",$cat_row[cat_relate_id]);
		$where="";
		foreach($array as $cat_dir_id){
			$where .="cat_dir_id='$cat_dir_id',";
		}
		if($where{strlen($where)-1} ==",") $where = substr($where, 0, strlen($where)-1);
		$where=str_replace(","," or ",$where);
		$list_array=set_array_from_query("max_music_cat","cat_id,cat_dir_id,cat_name_display","$where");
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
			$chk_sub=get_dbvalue("max_music_cat","count(cat_id)","cat_relate_id like '%$row_data[cat_dir_id]%'") - 1;
			if($chk_sub > 0){
				if($current_cat_id==$val){
					$show_folder_icon="<img border=\"0\" alt=\"$music_tooltip_current_category\" title=\"$music_tooltip_current_category\" src=\"html/07_icon_stop.gif\" /> $row_data[cat_name_display]";
					$show_list_table .="<tr id=\"tr$val\" style=\"background-image: url(html/07_title_background2.gif);line-height:20px\">\n";		
					$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" title=\"Current category\" onclick=\"alert('$music_tooltip_current_category')\">$show_folder_icon</td>\n";
					$show_list_table .="</tr>\n";
				}
				else{
					$music_tooltip_click_to_open_category=str_replace("%cat_name_display%",$row_data[cat_name_display],$music_tooltip_click_to_open_category);
					$show_folder_icon="<img border=\"0\" alt=\"$music_tooltip_click_to_open_category\" title=\"$music_tooltip_click_to_open_category\" src=\"html/07_icon_open_folder.gif\" /> $row_data[cat_name_display]";
					$show_list_table .="<tr id=\"tr$val\" style=\"background-image: url(html/07_title_background2.gif);line-height:20px\">\n";		
					$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" onclick=\"location.href='index.php?step=$step&what=copy_selected&current_cat_id=$current_cat_id&cat_id=$val&list_id=$list_id';\">$show_folder_icon</td>\n";
					$show_list_table .="</tr>\n";
				}
			}
			else{
				if($current_cat_id==$val){
					$show_folder_icon="<img border=\"0\" alt=\"$music_tooltip_current_category\" title=\"$music_tooltip_current_category\" src=\"html/07_icon_stop.gif\" /> $row_data[cat_name_display]";
					$show_list_table .="<tr id=\"tr$val\" style=\"background-image: url(html/07_title_background2.gif);line-height:20px\">\n";		
					$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" title=\"$music_tooltip_current_category\" onclick=\"alert('$music_tooltip_current_category')\">$show_folder_icon</td>\n";
					$show_list_table .="</tr>\n";
				}
				else{
					$music_tooltip_click_to_open_category=str_replace("%cat_name_display%",$row_data[cat_name_display],$music_tooltip_click_to_open_category);
					$show_folder_icon="<img border=\"0\" alt=\"$music_tooltip_click_to_open_category\" title=\"$music_tooltip_click_to_open_category\" src=\"html/07_icon_open_folder_empty.gif\" /> $row_data[cat_name_display]";
					$show_list_table .="<tr id=\"tr$val\" style=\"background-image: url(html/07_title_background2.gif);line-height:20px\">\n";		
					$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" onclick=\"location.href='index.php?step=$step&what=copy_selected&current_cat_id=$current_cat_id&cat_id=$val&list_id=$list_id';\">$show_folder_icon</td>\n";
					$show_list_table .="</tr>\n";
				}				
			}			
		}		
		
		if($cat_id==""){
			$show_list_table .="<tr id=\"tr$val\" style=\"background-color: white;line-height:20px;font-weight:bold\">\n";		
			$music_txt_please_select_a_category_to_move=str_replace("%list_id%",$list_id,$music_txt_please_select_a_category_to_move);
			$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\">$music_txt_please_select_a_category_to_move</td>\n";
			$show_list_table .="</tr>\n";
		}
		else{
			$show_list_table .="<tr id=\"tr$val\" style=\"background-color: white;line-height:20px;font-weight:bold\">\n";		
			$music_txt_click_here_to_copy=str_replace("%cat_name_display%",$cat_row[cat_name_display],$music_txt_click_here_to_copy);
			$show_list_table .="<td width=\"100%\" style=\"padding:4px;cursor:pointer;\" onclick=\"location.href='index.php?step=$step&what=copy_selected2&cat_id=$cat_id&current_cat_id=$current_cat_id&list_id=$list_id';\"><img alt=\"\" border=\"0\" src=\"html/07_icon_open_folder.gif\" /> <span style=\"color:green\">$cat_row[cat_name_display]</span> || <span style=\"text-decoration:underline;\">$music_txt_click_here_to_copy</span></td>\n";
			$show_list_table .="</tr>\n";
		}
		set_global_var("show_list_table",$show_list_table);
		print get_html_from_layout("admin/html/admin_manage_music_copy_ecards.html");
		exit;
	}
	elseif($what=="copy_selected2"){
		$sql_where="";
		$array_list_id=split(",",$list_id);
		foreach($array_list_id as $music_id){
			if($music_id!=""){
				$sql_where .="music_id='$music_id',";
			}
		}
		if($sql_where{strlen($sql_where)-1} ==",") $sql_where = substr($sql_where, 0, strlen($sql_where)-1);
		$sql_where=str_replace(","," or ",$sql_where);
		$list_selected =set_array_from_query("max_music","*"," $sql_where ");
		$cat_row=get_row("max_music_cat","*","cat_id='$cat_id'");
		foreach($list_selected as $row_data){
			$field_name ="(";
			$field_value="(";
			foreach($row_data as $col=>$col_value){
				if($col!="music_id"){
					$field_name .="$col,";
					if($col=="ec_cat_id")$col_value=$cat_row[cat_id];
					$col_value=str_replace("'","''",$col_value);
					$field_value .="'$col_value',";
				}
			}
			$field_name .=")";
			$field_value .=")";
			$field_name=str_replace(",)",")",$field_name);
			$field_value=str_replace(",)",")",$field_value);

			if($cat_id != $row_data[ec_cat_id] && $row_data[ec_user_name_id]==""){
			    if(@copy("$ecard_root/resource/music/$row_data[ec_cat_dir]/$row_data[music_filename]", "$ecard_root/resource/music/$cat_row[cat_dir]/$row_data[music_filename]")){
				//Copy ec_id
				//	print "$field_name,$field_value<br/>";exit;
					insert_data_to_db("max_music",$field_name,$field_value);
					$music_message_your_selected_music_has_been_copied=str_replace("%cat_name_display%",$cat_row[cat_name_display],$music_message_your_selected_music_has_been_copied);
					$show_info .= "<div class=\"OK_Message\">$music_message_your_selected_music_has_been_copied<br /></div>";
				}else{
					$music_message_permission_denied_cannt_copy_selected=str_replace("%cat_dir%","resource/music/$cat_row[cat_dir]",$music_message_permission_denied_cannt_copy_selected);
					$show_info .= "<div class=\"Error_Message\">$music_message_permission_denied_cannt_copy_selected<br /></div>";
				}
			}
		}
		
		$cat_id=$current_cat_id;
		RefreshSortOrder();
		$what="";
		set_global_var("what","");
	}

	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	set_global_var("row_number",$row_number);
	$row_per_page = $row_number;
				
	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;

	$list_data =set_array_from_query("max_music","*","music_user_name_id='' and ec_cat_id='$cat_id' Order by music_order,music_name_display LIMIT $start,$row_per_page");
	$count_list=get_dbvalue("max_music","count(music_id)","music_user_name_id='' and ec_cat_id='$cat_id'");

	if ($end > $count_list) $end = $count_list;
	$show_list_table="";
	$xrow=0;
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][music_id] ;
		$row_data=$list_data[$xrow];

		//Show sort order dropdown menu
		$show_sort="<select size=\"1\" name=\"music_order$val\" id=\"music_order$val\" onchange=\"location.href='index.php?step=$step&what=set_sort_order&page=$page&cat_id=$cat_id&cat_dir=$cat_dir&cat_name_display=$cat_name_display&music_id=$val&current_sort=$row_data[music_order]&sort_number='+this.value;\">";
		for($i=1;$i<=$count_list;$i++){
			if($row_data[music_order]==$i){
				$show_sort.="<option value=\"$i\" selected=\"selected\">$i</option>\n";
			}
			else{
				$show_sort.="<option value=\"$i\" >$i</option>\n";
			}
		}
		$show_sort.="</select>";

		//Show icon
		$show_icon ="<img border=\"0\" src=\"html/07_icon_play_audio_file.gif\" alt=\"\" />";

		//Show title
		$show_title="<input id=\"music_name_display$val\" title=\"$music_tooltip_click_here_to_rename\" type=\"text\" value=\"$row_data[music_name_display]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:350px;text-decoration:underline;\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"Editme('index.php?step=edit_me&table=max_music&edit_id=music_id&edit_id_value=$val&edit_key=music_name_display&edit_value=',this.value,'1',original_value,this.id);\" />";		
						//ss
		//Show on/off checkbox
		if($row_data[music_active]=="1"){
			$checked_it ="checked=\"checked\"";
		}
		else{
			$checked_it ="";
		}

		//Show delete button
		$show_delete_button="<img onclick=\"document.getElementById('tr$val').style.backgroundColor='#E4E4D3';document.getElementById('bk$val').checked='true';CheckSelected1();\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$music_tooltip_delete\" title=\"$music_tooltip_delete\" />";
			
		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;cursor:pointer\" title=\"$music_tooltip_click_to_listen\" id=\"cell$val\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';ShowPlayer('resource/music/$cat_dir/$row_data[music_filename]','music_name_display$val');\">$show_icon</td>\n";
		$show_list_table .="<td width=\"*\" style=\"padding:4px;\">$show_title</td>\n";
		$show_list_table .="<td width=\"20%\">$row_data[music_filename]</td>\n";
		$show_list_table .="<td width=\"12%\" align=\"center\"><input $checked_it type=\"checkbox\" value=\"1\" onclick=\"ShowLoaderImage('$music_message_updating');if(this.checked){UpdateDataTable('index.php?step=edit_me&table=max_music&edit_id=music_id&edit_id_value=$val&edit_key=music_active&edit_value=1');}else{UpdateDataTable('index.php?step=edit_me&table=max_music&edit_id=music_id&edit_id_value=$val&edit_key=music_active&edit_value=0');}\" /></td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:4px;\">$show_sort</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\">$show_delete_button</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\"><input onclick=\"if(this.checked){document.getElementById('tr$val').style.backgroundColor='#E4E4D3';}else{document.getElementById('tr$val').style.backgroundColor='#EAEAEA';}\" type=\"checkbox\" id=\"bk$val\" name=\"mylist_id$val\" value=\"$val\" /></td>\n";
		$show_list_table .="</tr>\n";
		$bk_id .="$val,";
		$xrow++;
	}
	if($bk_id{strlen($bk_id)-1} ==",") $bk_id = substr($bk_id, 0, strlen($bk_id)-1);
	set_global_var("bk_id",$bk_id);
	set_global_var("show_list_table",$show_list_table);

	//---------------------------------------------------------------------------------------
	//Print page here
	//Output sample: << 1 | 2 | 3 >>	

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
				$dpn ="<a href=\"index.php?step=$step&row_number=$row_number&page=$page_pr&cat_id=$cat_id\"><img border=0 src=html/prv.gif style='vertical-align:middle' title='Page # $page_pr' alt='Page # $page_pr' /></a>";
				$display_page_number = str_replace("{A}", $dpn, $display_page_number);
			}
			else{
				$display_page_number = str_replace("{A}", "<img src=html/prv_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
			}
			$y=get_global_var("d_num");
			if ($page < $y) {
				$page_ne = $page + 1 ;				
				$display_page_number = str_replace("{B}", "<a href=\"index.php?step=$step&row_number=$row_number&page=$page_ne&cat_id=$cat_id\"><img border=0 src=html/next.gif style='vertical-align:middle' title='Page # $page_ne' alt='Page # $page_ne' /></a>", $display_page_number);
			}	
			else{
				$display_page_number = str_replace("{B}", "<img src=html/next_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
			}
		}
	}
	set_global_var("display_page_number",$display_page_number);	 
	
	if($db_change =="1"){
		set_global_var("show_info","<span class=\"OK_Message\">Mysql table music has been updated<br /><br /></span>");	
	}
	else{
		set_global_var("show_info","<span class=\"Error_Message\">$show_info<br /></span>");	
	}
	set_global_var("count_total",$count_list);	
	set_global_var("show_onload_javascript","onkeypress=\"return noGlobalEnterKey(event)\"");
	//set_global_var("print_object",get_html_from_layout("admin/html/admin_option_music.html"));	
	//print_admin_header_footer_page();	
	$count_total=get_dbvalue("max_music","count(music_id)","music_user_name_id='' and ec_cat_id='$cat_id'");
	set_global_var("count_total",$count_total);
	set_global_var("cat_name_display",get_dbvalue("max_music_cat","cat_name_display","cat_id='$cat_id'"));
	$music_txt_how_to_add_new_music_by_using_ftp_content=str_replace("%cat_dir%","$ecard_root/resource/music/$cat_dir",$music_txt_how_to_add_new_music_by_using_ftp_content);
	$music_txt_how_to_add_new_music_by_using_ftp_content=str_replace("%insert_music_url%","index.php?step=$step&page=$page&cat_id=$cat_id&cat_dir=$cat_dir",$music_txt_how_to_add_new_music_by_using_ftp_content);
	set_global_var("music_txt_how_to_add_new_music_by_using_ftp_content",$music_txt_how_to_add_new_music_by_using_ftp_content);
	print get_html_from_layout("admin/html/admin_option_music.html");
	//--------------------------------------------------------------------------------------
	function get_page_count_number($page,$b){
		global $step,$what,$row_number,$cat_id,$cat_dir;
			
		$url="index.php?step=$step&row_number=$row_number&cat_id=$cat_id&cat_dir=$cat_dir";
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
				$count_number .="<a class=\"page_other\" href=\"$url&page=$a_num&cat_id=\">$a_num</a>";
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
	function RefreshSortOrder(){
		$cats=get_dblistvalue("max_music_cat","cat_id","1=1");
		foreach($cats as $cat_id){
			$list_sort=set_array_from_query("max_music","music_id,music_order","music_user_name_id='' AND ec_cat_id='$cat_id' Order by music_order,music_name_display");
			$xorder=0;
			foreach($list_sort as $array_sort){
				$xorder++;
				update_field_in_db("max_music","music_order",$xorder,"music_id='$array_sort[music_id]' LIMIT 1");
			}
		}
	}

?>