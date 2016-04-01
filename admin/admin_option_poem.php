<?php
/*
+--------------------------------------------------------------------------
|
|	WARNING: REMOVING THIS COPYRIGHT HEADER IS EXPRESSLY FORBIDDEN
|
|   ECardMax Version 10.5
|   ========================================
|   (c) 1999 - 2014 ECARDMAX.COM - All right reserved 
|	Software For Website, Inc.
|   http://www.ecardmax.com 
|   ========================================
|   Email: webmaster@ecardmax.com
|   Purchase Info: http://www.ecardmax.com/home/Purchase.html
|   Request Installation: http://www.ecardmax.com/home/Support.html
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
		$poem_order=get_dbvalue("max_poem","count(poem_id)","poem_user_name_id=''")+1;
		$field_name ="(poem_cat,poem_title,poem_author,poem_body,poem_active,poem_order,poem_user_name_id)";
		$field_value ="('$poem_cat','$poem_title','$poem_author','$poem_body',1,$poem_order,'')";
		
		$field_name ="(poem_title,poem_author,poem_body,poem_active,poem_order,poem_user_name_id)";
		$field_value ="('$poem_title','$poem_author','$poem_body',1,$poem_order,'')";
		
		insert_data_to_db("max_poem",$field_name,$field_value);
		echo 
		$show_info .="<span class=OK_Message>$poem_message_new_poem_added</span><br />\n";	
	}	
	elseif($what=="add_new_cat"){
		$field_name ="(name,parent)";
		//if(empty($cat_parent))
		$cat_parent=0;
		$field_value ="('$poem_cat_name',$cat_parent)";
		insert_data_to_db("max_poem_category",$field_name,$field_value);
		$show_info .="<span class=OK_Message>$poem_message_new_poem_cat_added</span><br />\n";	
	}
	elseif($what=="delete_selected"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);					
				//Delete row in database
				delete_row("max_poem","poem_id='$selected_id' LIMIT 1");
			}
		}
		RefreshSortOrder();
	}
	elseif($what=="delete_selected_cat"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id_cat")===false)){ //if true
				$selected_id =str_replace("mylist_id_cat","",$key);					
				//Delete row in database
				delete_row("max_poem_category","id='$selected_id' LIMIT 1");
			}
		}
		//RefreshSortOrder();
	}
	elseif($what=="set_sort_order"){
		$list_sort=set_array_from_query("max_poem","poem_id,poem_order","poem_user_name_id='' Order by poem_order,poem_title");		
		foreach($list_sort as $array_sort){
			if($current_sort > $sort_number){
				if($array_sort[poem_order]>=$sort_number){			
					update_field_in_db("max_poem","poem_order",$array_sort[poem_order]+1,"poem_id='$array_sort[poem_id]' LIMIT 1");
				}
			}
			else{
				if($array_sort[poem_order]<=$sort_number){			
					update_field_in_db("max_poem","poem_order",$array_sort[poem_order]-1,"poem_id='$array_sort[poem_id]' LIMIT 1");
				}
			}
		}		
		update_field_in_db("max_poem","poem_order",$sort_number,"poem_id='$poem_id' LIMIT 1");
		
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

	$list_data =set_array_from_query("max_poem","*","poem_user_name_id='' Order by poem_order,poem_title LIMIT $start,$row_per_page");
	$count_list=get_dbvalue("max_poem","count(poem_id)","poem_user_name_id=''");

	if ($end > $count_list) $end = $count_list;
	$show_list_table="";
	$xrow=0;
	$show_category=array();
	$show_option="";
	
	$show_categogy_parent="<select name='cat_parent'>";
	$option_category_add="<select name='poem_cat'>";
	$show_categogy_parent.="<option value=\"0\" >-- Select --</option>\n";
	//$show_list_cat_table="<tr>\n";
	$list_data_category_parent =set_array_from_query("max_poem_category","*","parent=0 Order by name");
	foreach($list_data_category_parent as $value){
		$show_categogy_parent.="<option value=\"".$value[id]."\" >$value[name]</option>\n";
		$option_category_add.="<option value=\"".$value[id]."\" >$value[name]</option>\n";
		//$show_list_cat_table .="<td width=\"1%\" align=\"left\"><input type='text' onblur=\"editPoemCat($value[id],this.value);\" value=\"$value[name]\" /></td>\n";
		$show_category[]=array('key'=>$value[id],'val'=>$value[name],'isChild'=>0,'parent'=>$value['parent']);
		$list_data_category =set_array_from_query("max_poem_category","*","parent=$value[id] Order by name");
		foreach($list_data_category as $_value){
			//$show_list_cat_table .="<td width=\"1%\" align=\"left\"><input type='text' onblur=\"editPoemCat($_value[id],this.value);\" value=\"$_value[name]\" /></td>\n";
			$option_category_add.="<option value=\"".$_value[id]."\" >-- $_value[name]</option>\n";
			$show_category[]=array('key'=>$_value[id],'val'=>$_value[name],'isChild'=>1,'parent'=>$_value['parent']);
		}
	}
	//$show_list_cat_table.="</tr>\n";
	$show_categogy_parent.="</select>";
	$option_category_add.="</select>";
	$show_list_cat_table="";
	$bk_id_cat=array();
	foreach($show_category as $value){
		$show_list_cat_table.="<tr id=\"tr_cat$value[key]\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
		$show_list_cat_table .="<td width=\"1%\" align=\"left\"><input class='input_cat' type='text' onblur=\"editPoemCat($value[key],this.value);\" value=\"$value[val]\" /></td>\n";
		$_option="<select onchange=\"setCategoryParent($value[key],this.value)\" id=\"category_parent_$value[id]\">";
		$_option.="<option value=\"0\" >-- Select --</option>\n";
		foreach($list_data_category_parent as $_value){
			if($value['parent']==$_value[id]){
				$_option.="<option value=\"$_value[id]\" selected=\"selected\">$_value[name]</option>\n";
			}
			else{
				$_option.="<option value=\"$_value[id]\" >$_value[name]</option>\n";
			}
		}
		$_option.="</select>";
		//$show_list_cat_table.="<td width=\"1%\" align=\"left\">$_option</td>\n";
		$show_list_cat_table .="<td width=\"1%\" align=\"center\"><input onclick=\"if(this.checked){document.getElementById('tr_cat$value[key]').style.backgroundColor='#E4E4D3';}else{document.getElementById('tr_cat$val').style.backgroundColor='#EAEAEA';}\" type=\"checkbox\" id=\"bk_cat$value[key]\" name=\"mylist_id_cat$value[key]\" value=\"$value[key]\" /></td>\n";
		$show_list_cat_table.="</tr>\n";
		$bk_id_cat[]=$value[key];
	}
	$bk_id_cat=join(",",$bk_id_cat);
	set_global_var("bk_id_cat",$bk_id_cat);
	set_global_var("show_list_cat_table",$show_list_cat_table);
	set_global_var("show_categogy_parent",$show_categogy_parent);
	set_global_var("option_category_add",$option_category_add);
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][poem_id] ;
		$row_data=$list_data[$xrow];

		//Show sort order dropdown menu
		$show_sort="<select size=\"1\" name=\"poem_order$val\" id=\"poem_order$val\" onchange=\"location.href='index.php?step=$step&what=set_sort_order&poem_id=$val&current_sort=$row_data[poem_order]&sort_number='+this.value;\">";
		for($i=1;$i<=$count_list;$i++){
			if($row_data[poem_order]==$i){
				$show_sort.="<option value=\"$i\" selected=\"selected\">$i</option>\n";
			}
			else{
				$show_sort.="<option value=\"$i\" >$i</option>\n";
			}
		}
		$show_sort.="</select>";
		$show_option="<select onchange=\"setCategory($row_data[poem_id],this.value)\" id=\"category_$_value[key]\">";
		foreach($show_category as $_value){
			$_catName=$_value[val];
			if($_value[isChild]==1) $_catName="-- ".$_value[val];
			if($row_data[poem_cat]==$_value[key]){
				$show_option.="<option value=\"$_value[key]\" selected=\"selected\">$_catName</option>\n";
			}
			else{
				$show_option.="<option value=\"$_value[key]\" >$_catName</option>\n";
			}
		}
		$show_option.="</select>";
		
		//Show icon
		$show_icon ="<img border=\"0\" src=\"html/07_icon_upload_poem2.gif\" alt=\"\" />";

		//Show Poem Title
		$show_title="<input onkeypress=\"return noEnterKey(event);\" id=\"poem_title$val\" title=\"$poem_tooltip_click_here_to_edit\" type=\"text\" value=\"$row_data[poem_title]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:600px;text-decoration:underline;font-weight:bold;font-size:14px;text-align:center\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"Editme('index.php?step=edit_me&table=max_poem&edit_id=poem_id&edit_id_value=$val&edit_key=poem_title&edit_value=',this.value,'1',original_value,this.id);\" />";

		//Show poem Author
		$show_author="<input onkeypress=\"return noEnterKey(event);\" id=\"poem_author$val\" title=\"$poem_tooltip_click_here_to_edit\" type=\"text\" value=\"$row_data[poem_author]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:600px;text-decoration:underline;font-size:10px;text-align:center\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"Editme('index.php?step=edit_me&table=max_poem&edit_id=poem_id&edit_id_value=$val&edit_key=poem_author&edit_value=',this.value,'1',original_value,this.id);\" />";

		//Show poem Body
		$row_data[poem_body]=str_replace("<br>","\n",$row_data[poem_body]);
		$show_body="<textarea id=\"poem_body$val\" title=\"$poem_tooltip_click_here_to_edit\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:600px;height:70px;text-align:center\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.cursor='text';this.style.height='300px';\" onblur=\"this.style.border='0px';this.style.cursor='pointer';this.style.height='70px';\" onchange=\"Editme('index.php?step=edit_me&table=max_poem&edit_id=poem_id&edit_id_value=$val&edit_key=poem_body&edit_value=',this.value,'1',original_value,this.id);\" >$row_data[poem_body]</textarea>";
						
		//Show on/off checkbox
		if($row_data[poem_active]=="1"){
			$checked_it ="checked=\"checked\"";
		}
		else{
			$checked_it ="";
		}

		//Show delete button
		$show_delete_button="<img onclick=\"document.getElementById('tr$val').style.backgroundColor='#E4E4D3';document.getElementById('bk$val').checked='true';CheckSelected();\" border=\"0\" src=\"html/07_icon_delete.gif\" style=\"cursor:pointer\" alt=\"$poem_tooltip_delete\" title=\"$poem_tooltip_delete\" />";
			
		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" valign=\"top\" style=\"padding:7px;cursor:pointer;\" title=\"$poem_tooltip_click_here_to_view_poem\" id=\"cell$val\" onclick=\"HideItAll();this.style.backgroundColor='#FAEDC8';this.style.border='thick solid #FCAA03';ShowPoem('$val');\">$show_icon</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\">$show_option</td>\n";
		$show_list_table .="<td width=\"*\" style=\"padding:4px;\" align=\"center\">$show_title<br />$show_author<br /><br />$show_body</td>\n";
		$show_list_table .="<td width=\"12%\" align=\"center\"><input $checked_it type=\"checkbox\" value=\"1\" onclick=\"ShowLoaderImage('$poem_message_updating');if(this.checked){UpdateDataTable('index.php?step=edit_me&table=max_poem&edit_id=poem_id&edit_id_value=$val&edit_key=poem_active&edit_value=1');}else{UpdateDataTable('index.php?step=edit_me&table=max_poem&edit_id=poem_id&edit_id_value=$val&edit_key=poem_active&edit_value=0');}\" /></td>\n";		
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
				$dpn ="<a href=\"index.php?step=$step&row_number=$row_number&page=$page_pr\"><img border=0 src=html/prv.gif style='vertical-align:middle' title='Page # $page_pr' alt='Page # $page_pr' /></a>";
				$display_page_number = str_replace("{A}", $dpn, $display_page_number);
			}
			else{
				$display_page_number = str_replace("{A}", "<img src=html/prv_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
			}
			$y=get_global_var("d_num");
			if ($page < $y) {
				$page_ne = $page + 1 ;				
				$display_page_number = str_replace("{B}", "<a href=\"index.php?step=$step&row_number=$row_number&page=$page_ne\"><img border=0 src=html/next.gif style='vertical-align:middle' title='Page # $page_ne' alt='Page # $page_ne' /></a>", $display_page_number);
			}	
			else{
				$display_page_number = str_replace("{B}", "<img src=html/next_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
			}
		}
	}
	set_global_var("display_page_number",$display_page_number);	 
	
	if($db_change =="1"){
		set_global_var("show_info","<span class=\"OK_Message\">Mysql table poem has been updated<br /><br /></span>");	
	}
	else{
		set_global_var("show_info","<span class=\"Error_Message\">$show_info<br /></span>");	
	}

	set_global_var("count_total",$count_list);		
	set_global_var("print_object",get_html_from_layout("admin/html/admin_option_poem.html"));	
	print_admin_header_footer_page();	

	//--------------------------------------------------------------------------------------
	function get_page_count_number($page,$b){
		global $step,$what,$row_number;
			
		$url="index.php?step=$step&row_number=$row_number";
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
	function RefreshSortOrder(){
		$list_sort=set_array_from_query("max_poem","poem_id,poem_order","poem_user_name_id='' Order by poem_order,poem_title");
		$xorder=0;
		foreach($list_sort as $array_sort){
			$xorder++;
			update_field_in_db("max_poem","poem_order",$xorder,"poem_id='$array_sort[poem_id]' LIMIT 1");
		}
	}

?>