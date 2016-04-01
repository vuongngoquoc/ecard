<?php

/*
+--------------------------------------------------------------------------
|
|	WARNING: REMOVING THIS COPYRIGHT HEADER IS EXPRESSLY FORBIDDEN
|
|   @CARD MAX 2006 Full Version
|   ========================================
|   by Khoi Hong webmaster@cgi2k.com
|   (c) 1999 - 2006 ECARDMAX.COM - All right reserved 
|   http://www.ecardmax.com 
|   ========================================
|   Web: http://www.ecardmax.com
|   Email: webmaster@ecardmax.com
|   Purchase Info: http://www.ecardmax.com/purchase/
|   Request Installation: http://www.ecardmax.com/formxp/index.php?ecardmax
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

	require_once("../getvars.php");
	require_once "../function.php";
	$salt = $db_password;
	if ($salt == "") $salt ="38784035648867976";
	$crypt_pass = crypt($admin_password,$salt);		

	if ($uname != $crypt_pass){
		if ($step=="log_in2"){
			check_login_admin();			
			exit;
		}		
		else{
			log_in_admin();
			exit;
		}
	}

	$what = get_global_var(what);
	switch ($what){
		case "disable":
			disable();
			break;
		case "add": 
			cat_add();
			break;
		case "delete":
			delete();
			break;
		case "add2":
			//Auto remove spcial character for cat_dir (this a folder)
			$cat_dir = ereg_replace( "[^A-Za-z0-9]", "", $cat_dir);
			set_global_var("cat_dir",$cat_dir);

			//Check if Category name & folder is blank
			if(trim(strip_tags(get_global_var(cat_name_display))) =="")
				$print_error_msg .="You must enter Category name<br>\n";

			if(trim(strip_tags(get_global_var(cat_dir))) =="")
				$print_error_msg .="You must enter Category folder name<br>\n";

			//Check if cat_dir already exist
			$chk_cat_dir =get_dbvalue("max_music_cat","ms_cat_id","ms_cat_dir='$cat_dir'");
			if(file_exists("$ecard_root/resource/music/$cat_dir") || $chk_cat_dir !="")
				$print_error_msg .="Existing folder name $cat_dir. Please try again.<br>\n";

			//Check if folder picture is writeable
			if (!is_writable("$ecard_root/resource/music"))
				$print_error_msg .="You must chmod 777 folder name 'picture'<br>$ecard_root/resource/music.<br><a href=http://ecardmax.com/index.php?step=chmod target=_blank class=Menu_Link>Click here</a> for more information how to chmod 777 files or folders<br>\n";

			if ($print_error_msg !="" && $cat_id !=""){
				nospecialtags();
				set_global_var("suberror_msg","<br><br><font class=Error_Message>$print_error_msg</font>");
				cat_add();
				exit;
			}
			elseif ($print_error_msg !="" && $cat_id ==""){
				nospecialtags();
				set_global_var("error_msg","<br><br><font class=Error_Message>$print_error_msg</font>");
				cat_add();
				exit;
			}

			//Create new category here
			$cat_time = $time_stamp_now_admin;			
			$cat_name_display=str_replace("\"","&quot;",$cat_name_display);
			
			$mylist =get_list_file("$ecard_root/languages","_lang.php$");
			foreach($mylist as $val){
				if($val !=""){
					$val = str_replace(".php","",$val);
					$val = "cat_" . $val;
					$get_value = get_global_var($val);
					$get_value=str_replace("\"","&quot;",$get_value);
					$lang_field_name .=",$val";
					$lang_field_value .=",'$get_value'";
				}
			}

		//	if($cat_id ==""){ //Create Main category
					$field_name ="(ms_cat_description,ms_cat_keyword,ms_cat_name_display,ms_cat_dir,ms_cat_parent,ms_cat_active,ms_cat_time$lang_field_name)";
				$field_value ="('$cat_description','$cat_keyword','$cat_name_display','$cat_dir','$cat_parent','1','$cat_time'$lang_field_value)";
				insert_data_to_db("max_music_cat",$field_name,$field_value);
		
			//Make new dir 
			mkdir("$ecard_root/resource/music/$cat_dir",0777);
			chmod("$ecard_root/resource/music/$cat_dir",0777);			
			
			set_global_var("hidden_if_needed","style='display:none'");
			set_global_var("ec_cat_dir",$cat_dir);
			set_global_var("ec_cat_name_display",$cat_name_display);
			set_global_var("ec_cat_id",get_dbvalue("max_music_cat","ms_cat_id","ms_cat_dir='$cat_dir'"));
			nospecialtags();
			set_global_var("print_image_add_form",get_html_from_layout("admin/html/image_add.html"));
			print get_html_from_layout("admin/html/add_music_cat_complete.html");
			exit;
			
			break;		
		case "rename":
			cat_rename();
			break;
		case "rename2":
			//Check if cat_id = blank - cat_name_display = blank
			if(trim(strip_tags(get_global_var(cat_name_display))) =="")
				$error_msg .="You must enter Category name<br>\n";

			if(trim(strip_tags(get_global_var(ms_cat_id))) =="")
				$error_msg .="Error - Category ID not found<br>\n";

			if ($error_msg !=""){
				nospecialtags();
				set_global_var("error_msg","<br><br><font class=Error_Message>$error_msg</font>");
				cat_rename();
				exit;
			}
			
			$cat_name_display=str_replace("\"","&quot;",$cat_name_display);

			//Update field cat_name_display
			update_field_in_db("max_music_cat","ms_cat_name_display",$cat_name_display,"ms_cat_id='$ms_cat_id' LIMIT 1");

			//Update field cat_keyword
			update_field_in_db("max_music_cat","ms_cat_keyword",$cat_keyword,"ms_cat_id='$ms_cat_id' LIMIT 1");
			
			//Update field cat_description
			update_field_in_db("max_music_cat","ms_cat_description",$cat_description,"ms_cat_id='$ms_cat_id' LIMIT 1");
		
			$mylist =get_list_file("$ecard_root/languages","_lang.php$");
			foreach($mylist as $val){
				if($val !=""){
					$val = str_replace(".php","",$val);
					$val = "cat_" . $val;
					$get_value = get_global_var($val);
					$get_value=str_replace("\"","&quot;",$get_value);
					update_field_in_db("max_music_cat","$val",$get_value,"ms_cat_id='$ms_cat_id' LIMIT 1");
				}
			}
			
			nospecialtags();
			set_global_var("error_msg","<br><br><font class=OK_Message>Category has been renamed</font>");
			set_global_var("what","rename");
			cat_rename();
			exit;
			break;
		case "hide":
			cat_hide();
			break;
		case "show_hide":

			foreach($http_vars as $key=>$val){
				if(!(strpos($key,"cat_id")===false)){ //if true
					$cat_id =str_replace("cat_id","",$key);
					update_field_in_db("max_category","cat_active",$val,"cat_id='$cat_id' LIMIT 1");
				}
			}
			
			set_global_var("error_msg","<tr class=Normal_Table_Title_Background><td colspan=5><font class=OK_Message>Categories have been updated</font></td></tr>");
			cat_hide();
			break;
		case "hide_all":

			$list=get_dblistvalue("max_category","cat_id","cat_dir<>''");
			foreach($list as $val){
				update_field_in_db("max_category","cat_active","0","cat_id='$val' LIMIT 1");
			}
			
			set_global_var("error_msg","<tr class=Normal_Table_Title_Background><td colspan=5><font class=OK_Message>Categories have been updated</font></td></tr>");
			cat_hide();
			break;
		case "show_all":

			$list=get_dblistvalue("max_category","cat_id","cat_dir<>''");
			foreach($list as $val){
				update_field_in_db("max_category","cat_active","1","cat_id='$val' LIMIT 1");
			}
			
			set_global_var("error_msg","<tr class=Normal_Table_Title_Background><td colspan=5><font class=OK_Message>Categories have been updated</font></td></tr>");
			cat_hide();
			break;
		case "delete_selected":			
			foreach($http_vars as $key=>$val){
				if(!(strpos($key,"listcat_")===false)){ //if true
					$cat_id =str_replace("listcat_id","",$key);
					$cat_dir = get_dbvalue("max_category","cat_dir","cat_id='$cat_id'");
					$list =get_dblistvalue("max_ecard","ec_id","ec_cat_id='$cat_id'");
					foreach($list as $val2){
						$row=get_row("max_ecard","*","ec_id='$val2'");
						//Delete images files in folder cat_id
						if (is_writable("$ecard_root/resource/picture/$row[ec_cat_dir]/$row[ec_filename]")){
							@unlink("$ecard_root/resource/picture/$row[ec_cat_dir]/$row[ec_filename]");
						}
						else{
							$print_error_msg .="Can't delete file .../resource/picture/$row[ec_cat_dir]/$row[ec_filename] - permission denied. Use FTP to delete it<br>\n";
						}

						if (is_writable("$ecard_root/resource/picture/$row[ec_cat_dir]/$row[ec_thumbnail]")){
							@unlink("$ecard_root/resource/picture/$row[ec_cat_dir]/$row[ec_thumbnail]");
						}
						else{
							$print_error_msg .="Can't delete file .../resource/picture/$row[ec_cat_dir]/$row[ec_thumbnail] - permission denied. Use FTP to delete it<br>\n";
						}
						
						//Delete images files in database
						delete_row("max_ecard","ec_id='$val2' LIMIT 1");
					}				
					//Delete cat_id
					delete_row("max_category","cat_id='$cat_id' LIMIT 1");

					//Delete folder cat_id					
					if (is_writable("$ecard_root/resource/picture/$cat_dir")){
						@rmdir("$ecard_root/resource/picture/$cat_dir");
					}
					else{
						$print_error_msg .="Can't delete folder .../resource/picture/$row[ec_cat_dir] - permission denied. Use FTP to delete it<br>\n";
					}
				}
			}
			if($print_error_msg != "")
				$print_error_msg ="<br><br><font class=Error_Message>$print_error_msg</font>";

			set_global_var("error_msg","<tr class=Normal_Table_Title_Background><td colspan=5><font class=OK_Message>Categories have been updated</font>$print_error_msg</td></tr>");
			cat_hide();
			break;
		case "main_selected":
			foreach($http_vars as $key=>$val){
				if(!(strpos($key,"listcat_")===false)){ //if true
					$cat_id =str_replace("listcat_id","",$key);
								
					//Update cat_id as Main cat
					update_field_in_db("max_category","cat_parent","","cat_id='$cat_id' LIMIT 1");
				}
			}

			set_global_var("error_msg","<tr class=Normal_Table_Title_Background><td colspan=5><font class=OK_Message>Categories have been updated</font></td></tr>");
			cat_hide();
			break;
		case "sub_selected":
			//Get selected ID
			foreach($http_vars as $key=>$val){
				if(!(strpos($key,"listcat_")===false)){ //if true
					$selected_id =str_replace("listcat_id","",$key);
					$list_key .="$selected_id,";
					$list_key2 .="[$selected_id],";
				}
			}
			if($list_key{strlen($list_key)-1} ==","){
				$list_key = substr($list_key, 0, strlen($list_key)-1);
			}
			set_global_var("list_key",$list_key);

			if($list_key !=""){
				//Print list of category with Radio button
				$list=get_dblistvalue("max_category","cat_parent","cat_parent <>'' Order by cat_parent");
				$list=array_unique($list);
				$data="";
				foreach($list as $val){
					$cat_parent = get_dbvalue("max_category","cat_id","cat_dir ='$val'");
					$cat_child_list = get_dblistvalue("max_category","cat_id","cat_parent ='$val' Order by cat_name_display ASC");
					foreach($cat_child_list as $val2){
						$catchild = get_dbvalue("max_category","cat_id","cat_id='$val2'");
						$data .= "$cat_parent\n$catchild\n";
					}
				}
				$list = explode("\n",$data);
						
				$array=get_dblistvalue("max_category","cat_id","cat_parent ='' Order by cat_name_display ASC");
				foreach($array as $val){
					array_push($list, $val);
				}				
				
				$list=array_unique($list);

				$data="";

				foreach($list as $val){
					$val=trim($val);
					if($val !=""){
						$row =get_row("max_category","*","cat_id='$val'");
						$chk_parent = get_dbvalue("max_category","cat_parent","cat_dir='$row[cat_dir]'");
						$chk_parent_name = get_dbvalue("max_category","cat_name_display","cat_dir='$row[cat_parent]'");
						if($chk_parent != ""){//Child
							$show_catname ="<b>$chk_parent_name</b> &gt; $row[cat_name_display]";
							$show_catdir ="$row[cat_dir]";
						}
						else{//Parent
							$show_catname ="<span class=OK_Message><b>$row[cat_name_display]</b></span> ";
							$show_catdir ="<span class=OK_Message><b>$row[cat_dir]</b></span>";
						}
						
						$chk_catID = "["."$row[cat_id]"."]";
						if(!(strpos($list_key2,$chk_catID)===false)){ //if true
							$data .="<tr id=\"tr$val\" style=\"background:#FFFFDD\" >\n\n";
							$data .="<td>$show_catname</td>\n";
							$data .="<td>$show_catdir</td>\n";				
							$data .="<td align=center style=\"background:#6AC8F4\"></td>\n";
							$data .="</tr>\n";
						}
						else{
							$data .="<tr id=\"tr$val\" style=\"background:#FFFFDD\" >\n\n";
							$data .="<td>$show_catname</td>\n";
							$data .="<td>$show_catdir</td>\n";				
							$data .="<td align=center><input id=bk$val type=radio name=cat_id value=$val></td>\n";
							$data .="</tr>\n";
						}
					
					}
				}
				set_global_var("print_list_category","$data");
				set_global_var("what","sub_selected2");
				set_global_var("action_title","<font size=4><b>Assign the list of category ID below as a Sub category of...<br></b></font><br><font class=OK_Message>Card ID#: [$list_key]</font><br><br>Select Radio button then click Submit");
				print get_html_from_layout("admin/html/add_move_ecard_show_cat.html");
				exit;
			}
			else{
				set_global_var("error_msg","<tr class=Normal_Table_Title_Background><td colspan=5><font class=Error_Message>You must select category ID by checking the checkbox</font></td></tr>");
				cat_hide();
			}
			break;
		case "sub_selected2":
			$list_key =get_global_var(list_key);
			$list_key_info = split(",",$list_key);
			$cat_dir=get_dbvalue("max_category","cat_dir","cat_id='$cat_id'");
			foreach($list_key_info as $val){
				update_field_in_db("max_category","cat_parent",$cat_dir,"cat_id='$val' LIMIT 1");
			}

			set_global_var("error_msg","<tr class=Normal_Table_Title_Background><td colspan=5><font class=OK_Message>Categories have been updated</font></td></tr>");
			cat_hide();
			break;
		default:
			print "";
	}
	//End switch
	
	//---------------------------------------------------------------------------------------
	function cat_hide(){
		$ecard_url=get_global_var(ecard_url);			
		$list=get_dblistvalue("max_music_cat","ms_cat_id","1=1");
		$data="";
		foreach($list as $val){
			$val=trim($val);
			if($val !=""){
				$row =get_row("max_music_cat","*","ms_cat_id='$val'");
					$show_catname ="<span class=OK_Message><b>$row[ms_cat_name_display]</b></span>";
					$show_catdir ="<span class=OK_Message><b>$row[ms_cat_dir]</b></span>";
				
				if($row[ms_cat_active] ==1){
					$data .="<tr id=\"tr$val\" style=\"background:#FFFFDD\" >\n";
					$data .="<td><a href=\"index.php?step=admin_music_cat&what=delete&id=$val\">Delete</a></td>\n";
					$data .="<td>$show_catname-$show_catdir</td>\n";
					$data .="<td align=center><a href=\"index.php?step=admin_music_cat&what=disable&id=$val&active=0\">Hide</a></td>\n";
					$data .="</tr>\n";
				}
				else{
					$data .="<tr id=\"tr$val\" style=\"background:#FFFFDD\" >\n"; 
					$data .="<td><a href=\"index.php?step=admin_music_cat&what=delete&id=$val\">Delete</a></td>\n</td>\n";
					$data .="<td>$show_catname-$show_catdir</td>\n";
					$data .="<td align=center class=Normal_Table_Selected_Background><a href=\"index.php?step=admin_music_cat&what=disable&id=$val&active=1\">Show</a></td>\n";
					$data .="</tr>\n";
				}
				$bk_id .="$val,";
			}
		}
		if($bk_id{strlen($bk_id)-1} ==","){
			$bk_id = substr($bk_id, 0, strlen($bk_id)-1);
		}
		set_global_var("bk_id",$bk_id);
		set_global_var("print_list_category","$data");
	
		print get_html_from_layout("admin/html/category_show_hide1.html");
		exit;

	}

	//---------------------------------------------------------------------------------------
	function cat_rename(){
		$ms_cat_id=get_global_var(ms_cat_id);		
		$ecard_root=get_global_var(ecard_root);	
		set_global_var("category_menu",display_root_music_cat());

		if($ms_cat_id !=""){
			$row =get_row("max_music_cat","*","ms_cat_id='$ms_cat_id'");
			set_global_var("cat_name_display",$row[ms_cat_name_display]);
			
			set_global_var("cat_keyword",$row[ms_cat_keyword]);
			set_global_var("cat_description",$row[ms_cat_description]);

			$mylist =get_list_file("$ecard_root/languages","_lang.php$");
			foreach($mylist as $val){
				if($val !=""){
					$val = str_replace(".php","",$val);
					$val2 = str_replace("_lang","",$val);
					$val = "cat_" . $val;
					$get_value = $row[$val];
					$print_lang_translate .="<tr class=Normal_Table_NoSelected_Background>\n";
					$print_lang_translate .="<td>Translate into <b>$val2</b><br><input type=\"text\" name=\"$val\" size=\"31\" value=\"$get_value\"><br><br></td>\n";
					$print_lang_translate .="</tr>\n";
				}
			}

			set_global_var("print_lang_translate",$print_lang_translate);

			$html =get_html_from_layout("admin/html/category_rename_music_cat.html");
		}
		else{
			$html ="<blockquote><b>Rename Category or Edit Category keyword, description</b>.<p>Click category menu in your left side to start</blockquote>";
		}
		
		//$navigator_link=get_global_var(navigator_link);
		set_global_var("ms_cat_id",$ms_cat_id);
		set_global_var("print_object","$html");
		print get_html_from_layout("admin/html/page_with_category_menu.html");
		exit;
	}

	//------------------------------------------------------------------------------
	function cat_add(){
		$cat_id=get_global_var(cat_id);
		$ecard_root=get_global_var(ecard_root);
		//display_root_cat();
		$mylist =get_list_file("$ecard_root/languages","_lang.php$");
		foreach($mylist as $val){
			if($val !=""){
				$val = str_replace(".php","",$val);
				$val2 = str_replace("_lang","",$val);
				$val = "cat_" . $val;
				$get_value = get_global_var($val);
				$print_lang_translate .="<tr class=Normal_Table_NoSelected_Background>\n";
				$print_lang_translate .="<td>Translate into <b>$val2</b><br><input type=\"text\" name=\"$val\" size=\"31\" value=\"$get_value\"><br><br></td>\n";
				$print_lang_translate .="</tr>\n";
			}
		}

		set_global_var("print_lang_translate",$print_lang_translate);

		set_global_var("cat_id","");
		set_global_var("cat_keyword","");
		set_global_var("cat_description","");
		set_global_var("Main_Or_Sub_Cat","Add Main Category");
		$form_main_cat =get_html_from_layout("admin/html/category_add_ms_cat.html");
		set_global_var("print_object","$form_main_cat");
		print get_html_from_layout("admin/html/page_with_category_menu.html");
		exit;
	}
function display_root_music_cat(){
	$ms_cat_id=get_global_var(ms_cat_id);
	$what=get_global_var(what);
	$step=get_global_var(step);
	$page = get_global_var(page);
	$pic_per_row = get_global_var(cf_pic_per_row);
	$row_per_page= get_global_var(cf_row_per_page);
	$ecard_url= get_global_var(ecard_url);

	$chk_cat_id = $getrow[cat_dir];
	$list = get_dblistvalue("max_music_cat","ms_cat_id","ms_cat_active='1' Order by ms_cat_name_display ASC");
	
	foreach($list as $val){
		$row = get_row("max_music_cat","*","ms_cat_id='$val'");

		$iconsub ="<img border=0 src=html/icon_minus.gif>";

		if($ms_cat_id == $val){ //Hilight Current Cat
			$data .="<tr class=Category_Menu_Table_NoSelected_Background onMouseover=\"this.style.backgroundColor='#C6D3EF';\" onMouseout=\"this.style.backgroundColor='';\" ><td nowrap STYLE=\"cursor:hand;cursor: pointer\" ><a href='index.php?step=$step&what=$what&ms_cat_id=$row[ms_cat_id]&find_exact=$find_exact&keyword=$keyword&lang=$lang&orderby=$orderby&gsort=$gsort' style='text-decoration:none'>$iconsub $row[ms_cat_name_display]</a></td></tr>\n";
		}
		else{				
			$data .="<tr class=Category_Menu_Table_Selected_Background onMouseover=\"this.style.backgroundColor='#C6D3EF';\" onMouseout=\"this.style.backgroundColor='';\" ><td nowrap STYLE=\"cursor:hand;cursor: pointer\" ><a href='index.php?step=$step&what=$what&ms_cat_id=$row[ms_cat_id]&find_exact=$find_exact&keyword=$keyword&lang=$lang&orderby=$orderby&gsort=$gsort' style='text-decoration:none'>$iconsub $row[ms_cat_name_display]</a></td></tr>\n";
		}
	}
	$table_menu=<<<HTML_CODE
<table class=Category_Menu_Table_Main_Border width="150" >
	<tr>
		<td  valign=top>		
			<table width=100% >
				<tr>
					<td align=center >
					<form name=categorymenu method="get" action="index.php">
					<input type=hidden name=what value="$what">
					<input type=hidden name=step value="$step">
					<input type=hidden name=find_exact value="$find_exact">
					<input type=hidden name=keyword value="$keyword">
					<input type=hidden name=lang value="$lang">
					<input type=hidden name=orderby value="$orderby">
					<input type=hidden name=gsort value="$gsort">
					</form>
					</td>
				</tr>
				$data
			</table>
		</td>
	</tr>
</table>
HTML_CODE;
	
	return $table_menu;

}
function disable(){
		$id=get_global_var("id");
		$active=get_global_var("active");
		update_field_in_db("max_music_cat","ms_cat_active",$active,"ms_cat_id='$id'");
		cat_hide();
		
	}
function delete(){
		global $ecard_root;///resource/music/
		$id=get_global_var("id");
		$row=get_row("max_music_cat","*","ms_cat_id='$id'");
		$dir=$row[ms_cat_dir];
		if(deleteDirectory("$ecard_root/resource/music/$dir")){	
			delete_dbvalue("music","ms_cat_dir='$dir'");
			delete_dbvalue("max_music_cat","ms_cat_id='$id'");
		}
	
		cat_hide();
	}
	function deleteDirectory($dirname,$only_empty=false) {
    if (!is_dir($dirname))
        return false;
    $dscan = array(realpath($dirname));
    $darr = array();
    while (!empty($dscan)) {
        $dcur = array_pop($dscan);
        $darr[] = $dcur;
        if ($d=opendir($dcur)) {
            while ($f=readdir($d)) {
                if ($f=='.' || $f=='..')
                    continue;
                $f=$dcur.'/'.$f;
                if (is_dir($f))
                    $dscan[] = $f;
                else
                    unlink($f);
            }
            closedir($d);
        }
    }
    $i_until = ($only_empty)? 1 : 0;
    for ($i=count($darr)-1; $i>=$i_until; $i--) {
        echo "\nDeleting '".$darr[$i]."' ... ";
        if (rmdir($darr[$i]))
            echo "ok";
        else
            echo "FAIL";
    }
    return (($only_empty)? (count(scandir)<=2) : (!is_dir($dirname)));
}

?>
