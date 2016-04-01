<?php
/*
+--------------------------------------------------------------------------
|
|	WARNING: REMOVING THIS COPYRIGHT HEADER IS EXPRESSLY FORBIDDEN
|
|   ECARDMAX 2010 Full Version
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
		$field_name ="(ag_title,ag_user_id)";
		$field_value ="('$ag_title',$_SESSION[user_id])";
		insert_data_to_db("max_addressbook_group",$field_name,$field_value);

		//Insert email to database
		if($email !=""){
			$array_email=split("\n",$email);
			$field_name ="(book_email,book_user_name_id,book_ag_relate_id,book_fname,book_lname,book_nick,book_phone)";
			$field_value="";
			$ag_id=get_dbvalue("max_addressbook_group","max(ag_id)");
			foreach($array_email as $each_line){
				$each_line=trim($each_line);
				list($email,$firstname,$lastname,$nickname,$phonenumber)=split(",",$each_line);
				$email = trim($email);
				$firstname = trim($firstname);
				$lastname = trim($lastname);
				$nickname = trim($nickname);
				$phonenumber = trim($phonenumber);
				$email_row=get_row("max_addressbook","*","book_email='$email' and book_user_name_id='$_SESSION[user_name_id]'");
				if(valid_email($email) && $email_row[book_id]=="" && $firstname!="" && $lastname!=""){//New contact email
					$field_value .="('$email','$_SESSION[user_name_id]',',$ag_id,','$firstname','$lastname','$nickname','$phonenumber'),";
				}
				elseif($email_row[book_id]!=""){
					$my_book_ag_relate_id=$email_row[book_ag_relate_id];
					if((strpos($my_book_ag_relate_id,",$ag_id,")===false)){ //if false (not match)
						$book_ag_relate_id=",$ag_id$my_book_ag_relate_id";
						$field_what="book_ag_relate_id='$book_ag_relate_id',";
						if($firstname!="")$field_what.="book_fname='$firstname',";
						if($lastname!="")$field_what.="book_lname='$lastname',";
						if($nickname!="")$field_what.="book_nick='$nickname',";
						if($phonenumber!="")$field_what.="book_phone='$phonenumber',";
						if($field_what{strlen($field_what)-1} ==",") $field_what = substr($field_what, 0, strlen($field_what)-1);
						update_field_in_db2("max_addressbook","$field_what","book_email='$email' and book_user_name_id='$_SESSION[user_name_id]' LIMIT 1");
					}
				}
			}
			if($field_value!=""){
				if($field_value{strlen($field_value)-1} ==",") $field_value = substr($field_value, 0, strlen($field_value)-1);
				insert_data_to_db("max_addressbook",$field_name,$field_value);
			}
		}

		$show_info .="<div class=\"OK_Message\">$addressbook_show_info_new_group_has_been_added</div><br />\n";
		$action="";
		$array_global_var_addressbook_group[action]="";
	}
	elseif($action=="quick_add_contact"){
		//Insert email to database
		if($quick_email !=""){
			$array_email=split("\n",$quick_email);
			$field_name ="(book_email,book_user_name_id,book_ag_relate_id,book_fname,book_lname,book_nick,book_phone)";
			$field_value="";
			foreach($array_email as $each_line){
				$each_line=trim($each_line);
				list($email,$firstname,$lastname,$nickname,$phonenumber)=split(",",$each_line);
				$email = trim($email);
				$firstname = trim($firstname);
				$lastname = trim($lastname);
				$nickname = trim($nickname);
				$phonenumber = trim($phonenumber);
				$email_row=get_row("max_addressbook","*","book_email='$email' and book_user_name_id='$_SESSION[user_name_id]'");
				if(valid_email($email) && $email_row[book_id]=="" && $firstname!="" && $lastname!=""){//New contact email
					$field_value .="('$email','$_SESSION[user_name_id]',',$ag_id,','$firstname','$lastname','$nickname','$phonenumber'),";
				}
				elseif($email_row[book_id]!=""){
					$my_book_ag_relate_id=$email_row[book_ag_relate_id];
					if((strpos($my_book_ag_relate_id,",$ag_id,")===false)){ //if false (not match)
						$book_ag_relate_id=",$ag_id$my_book_ag_relate_id";
						$field_what="book_ag_relate_id='$book_ag_relate_id',";
						if($firstname!="")$field_what.="book_fname='$firstname',";
						if($lastname!="")$field_what.="book_lname='$lastname',";
						if($nickname!="")$field_what.="book_nick='$nickname',";
						if($phonenumber!="")$field_what.="book_phone='$phonenumber',";
						if($field_what{strlen($field_what)-1} ==",") $field_what = substr($field_what, 0, strlen($field_what)-1);
						update_field_in_db2("max_addressbook","$field_what","book_email='$email' and book_user_name_id='$_SESSION[user_name_id]' LIMIT 1");
					}
					else{
						if($firstname!="")$field_what="book_fname='$firstname',";
						if($lastname!="")$field_what.="book_lname='$lastname',";
						if($nickname!="")$field_what.="book_nick='$nickname',";
						if($phonenumber!="")$field_what.="book_phone='$phonenumber',";
						if($field_what{strlen($field_what)-1} ==",") $field_what = substr($field_what, 0, strlen($field_what)-1);
						update_field_in_db2("max_addressbook","$field_what","book_email='$email' and book_user_name_id='$_SESSION[user_name_id]' LIMIT 1");
					}
				}
			}
			if($field_value!=""){
				if($field_value{strlen($field_value)-1} ==",") $field_value = substr($field_value, 0, strlen($field_value)-1);
				insert_data_to_db("max_addressbook",$field_name,$field_value);
			}
			$show_info .="<div class=\"OK_Message\">Contact Group $ag_title has been updated</div><br />\n";
		}
		$action="";
		$array_global_var_addressbook_group[action]="";
	}
	elseif($action=="delete_selected"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);
				//Move all contacts in this group to GROUP DEFAULT (NO GROUP)
				$list_contact=set_array_from_query("max_addressbook","book_id,book_ag_relate_id","book_ag_relate_id like '%,$selected_id,%' and book_user_name_id='$_SESSION[user_name_id]'");
				foreach($list_contact as $array_contact){
					$book_ag_relate_id=str_replace(",$selected_id,","",$array_contact[book_ag_relate_id]);
					if($book_ag_relate_id==""){
						$book_ag_relate_id=",0,";
					}
					else{
						if($book_ag_relate_id{strlen($book_ag_relate_id)-1} !=",") $book_ag_relate_id="$book_ag_relate_id,";
						if($book_ag_relate_id{0} !=",") $book_ag_relate_id=",$book_ag_relate_id";
					}
					update_field_in_db("max_addressbook","book_ag_relate_id",$book_ag_relate_id,"book_id='$array_contact[book_id]' LIMIT 1");
				}
				
				//Delete row in database
				delete_row("max_addressbook_group","ag_id='$selected_id' LIMIT 1");
			}
		}
		$show_info .="<div class=\"OK_Message\">Contact Group $ag_title has been updated</div><br />\n";
		$action="";
		$array_global_var_addressbook_group[action]="";
	}
	elseif($action=="edit_me"){
		update_field_in_db("max_addressbook_group","$edit_key",$edit_key_value,"$edit_id='$edit_id_value' and ag_user_id='$_SESSION[user_id]' LIMIT 1");
		exit;
	}

	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	$array_global_var_addressbook_group[row_number]=$row_number;
	$row_per_page = $row_number;

	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;

	$list_data =set_array_from_query("max_addressbook_group","*","ag_user_id='$_SESSION[user_id]' Order by ag_title LIMIT $start,$row_per_page");
	$count_list=get_dbvalue("max_addressbook_group","count(ag_id)","ag_user_id='$_SESSION[user_id]'");
	
	//Show NO GROUP on top
	//Count $total_email_this_group
	$total_email_this_group=get_dbvalue("max_addressbook","count(book_id)","book_user_name_id='$_SESSION[user_name_id]' and book_ag_relate_id like '%,0,%'");
	
	if($isResponsive)
	{
		//Show view contact icon
		$show_view_icon="<a href=\"$ecard_url/index.php?step=$step&next_step=show_addressbook&action=list_group_contact&ag_id=0\"><i class='fa fa-users'></i></a>";
		//Show add contact icon 
		$show_add_icon="<i title=\"$addressbook_tooltip_add_contact_to_group\" class='fa fa-user-plus'></i>";	
	}
	else
	{
		//Show view contact icon
		$show_view_icon="<a href=\"$ecard_url/index.php?step=$step&next_step=show_addressbook&action=list_group_contact&ag_id=0\"><img border=\"0\" alt=\"$addressbook_tooltip_view_contact_detail\" title=\"$addressbook_tooltip_view_contact_detail\" src=\"$ecard_url/templates/$cf_set_template/icon_view_contact.gif\" /></a>";
		//Show add contact icon 
		$show_add_icon="<img border=\"0\" alt=\"$addressbook_tooltip_add_contact_to_group\" title=\"$addressbook_tooltip_add_contact_to_group\" src=\"$ecard_url/templates/$cf_set_template/icon_add_contact.gif\" />";
	}
	$show_list_table ="<tr id=\"\" class=\"table_td_background\">\n";
	$show_list_table .="<td width=\"*\" style=\"padding:7px;\" class=\"OK_Message\">$addressbook_group_default_name</td>\n";
	$show_list_table .="<td width=\"1%\" align=\"center\">$total_email_this_group</td>\n";

	if($_SESSION[mg_allow_send_birthday_to_group]==1){
		$group_id=-1;
		$ec_id=get_dbvalue("max_birthday_card","cs_ec_id","cs_group_id='$group_id' AND cs_user_name_id='$_SESSION[user_name_id]'");
		$cs_id=get_dbvalue("max_birthday_card","cs_id","cs_group_id='$group_id' AND cs_user_name_id='$_SESSION[user_name_id]'");
		//index.php?step=$step&next_step=show_addressbook&action=birtday_card&ag_id=\
		if($isResponsive)
		$show_list_table.="<td width=\"1%\" align=\"center\"><a href=\"javascript:showBirthdaySetting('$group_id','$cs_id','$ec_id')\"><i title=\"$set_birthday_card\" class='fa fa-birthday-cake'></i></a></td>";
		else
		$show_list_table.="<td width=\"1%\" align=\"center\"><a href=\"javascript:showBirthdaySetting('$group_id','$cs_id','$ec_id')\"><img border=\"0\" alt=\"$addressbook_tooltip_view_contact_detail\" title=\"$set_birthday_card\" src=\"$ecard_url/templates/$cf_set_template/icon_birthday_alert_icon.gif\" /></a></td>";
	}	
	else {
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;cursor:pointer;\" id=\"cell$val\" >-</td>\n";
	}

	$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;cursor:pointer;\" >$show_view_icon</td>\n";
	$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;cursor:pointer;\" onclick=\"HideItAll();ShowAddContactBox('0');\">$show_add_icon</td>\n";
	$show_list_table .="<td width=\"1%\" align=\"center\">-</td>\n";
	$show_list_table .="<td width=\"1%\" align=\"center\">-</td>\n";
	$show_list_table .="</tr>\n";

	if ($end > $count_list) $end = $count_list;
	$xrow=0;
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][ag_id] ;
		$row_data=$list_data[$xrow];

		//Show group title, from name, from email
		$show_ag_title ="<input id=\"ag_title$val\" name=\"change_bkg\" title=\"$txt_tooltip_click_to_edit\" type=\"text\" value=\"$row_data[ag_title]\" style=\"width:300px;\" class=\"input_ajax_editable\" onfocus=\"original_value=this.value;if(document.getElementById('tr$val').className=='table_td_background'){this.className='input_ajax_editable_focus';}else{this.className='input_when_select_all_checkbox_checked';this.style.cursor='text';}\" onblur=\"if(document.getElementById('tr$val').className=='table_td_background'){this.className='input_ajax_editable';}else{this.className='input_when_select_all_checkbox_checked';this.style.cursor='pointer';}\" onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&action=edit_me&edit_id=ag_id&edit_id_value=$val&edit_key=ag_title&edit_key_value=',this.value,'1',original_value,this.id);\" />";

		//Total email this group
		$total_email_this_group=get_dbvalue("max_addressbook","count(book_id)","book_ag_relate_id like '%,$val,%'");

		if($isResponsive)
		{
			//Show view contact icon
			$show_view_icon="<a href=\"$ecard_url/index.php?step=$step&next_step=show_addressbook&action=list_group_contact&ag_id=$val\"><i title=\"$addressbook_tooltip_view_contact_detail\" class='fa fa-users'></i></a>";

			//Show add contact icon 
			$show_add_icon="<i title=\"$addressbook_tooltip_add_contact_to_group\" class='fa fa-user-plus'></i>";

			//Show delete button
			$show_delete_button="<span class='btn btn-default btn-xs' onclick=\"document.getElementById('bk$val').checked='true';single_check_uncheck('tr$val','bk$val');CheckSelected();\" title=\"$addressbook_txt_group_delete_contact\" ><i class='fa fa-remove'></i></span>";
		}
		else
		{
			//Show view contact icon
			$show_view_icon="<a href=\"$ecard_url/index.php?step=$step&next_step=show_addressbook&action=list_group_contact&ag_id=$val\"><img border=\"0\" alt=\"$addressbook_tooltip_view_contact_detail\" title=\"$addressbook_tooltip_view_contact_detail\" src=\"$ecard_url/templates/$cf_set_template/icon_view_contact.gif\" /></a>";

			//Show add contact icon 
			$show_add_icon="<img border=\"0\" alt=\"$addressbook_tooltip_add_contact_to_group\" title=\"$addressbook_tooltip_add_contact_to_group\" src=\"$ecard_url/templates/$cf_set_template/icon_add_contact.gif\" />";

			//Show delete button
			$show_delete_button="<img onclick=\"document.getElementById('bk$val').checked='true';single_check_uncheck('tr$val','bk$val');CheckSelected();\" border=\"0\" src=\"$ecard_url/templates/$cf_set_template/icon_delete.gif\" style=\"cursor:pointer\" alt=\"$addressbook_txt_group_delete_contact\" title=\"$addressbook_txt_group_delete_contact\" />";
		}
		$show_list_table .="<tr id=\"tr$val\" class=\"table_td_background\">\n";
		$show_list_table .="<td width=\"*\" style=\"padding:7px;\">$show_ag_title</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\"><span id=\"update_number$val\">$total_email_this_group</span></td>\n";
		if($_SESSION[mg_allow_send_birthday_to_group]){
			$group_id=$val;
			
			$ec_id=get_dbvalue("max_birthday_card","cs_ec_id","cs_group_id='$group_id' AND cs_user_name_id='$_SESSION[user_name_id]'");
			$cs_id=get_dbvalue("max_birthday_card","cs_id","cs_group_id='$group_id' AND cs_user_name_id='$_SESSION[user_name_id]'");
			if($isResponsive)
			$show_list_table .="<td width=\"*\" align=\"center\"><a href=\"javascript:showBirthdaySetting('$group_id','$cs_id','$ec_id')\"><i title=\"$set_birthday_card\" class='fa fa-birthday-cake'></i></a></td>\n";
			else
			$show_list_table .="<td width=\"1%\" align=\"center\"><a href=\"javascript:showBirthdaySetting('$group_id','$cs_id','$ec_id')\"><img title=\"$set_birthday_card\" src=\"$ecard_url/templates/$cf_set_template/icon_birthday_alert_icon.gif\" border=\"0\"/></a></td>\n";
		}
		else {
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;cursor:pointer;\" id=\"cell$val\" >-</td>\n";
		}

		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;cursor:pointer;\" id=\"cell$val\" >$show_view_icon</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\" style=\"padding:7px;cursor:pointer;\" id=\"cell_add$val\" onclick=\"HideItAll();ShowAddContactBox('$val');\">$show_add_icon</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\">$show_delete_button</td>\n";
		$show_list_table .="<td width=\"1%\" align=\"center\"><input class=\"input_ajax_editable\" onclick=\"single_check_uncheck('tr$val','bk$val');\" type=\"checkbox\" id=\"bk$val\" name=\"mylist_id$val\" value=\"$val\" /></td>\n";
		$show_list_table .="</tr>\n";
		$bk_id .="$val,";
		$xrow++;
	}
	if($bk_id{strlen($bk_id)-1} ==",") $bk_id = substr($bk_id, 0, strlen($bk_id)-1);

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
			
			$display_page_number .="<br /><table class=\"page_number_table\">\n";
			$display_page_number .="    <tr>\n";
			$display_page_number .="      <td width=\"10%\" align=\"left\">{A}</td>\n";
			$display_page_number .="      <td width=\"33%\" align=\"center\">{NUMBER}</td>\n";
			$display_page_number .="      <td width=\"10%\" align=\"right\">{B}</td>\n";
			$display_page_number .="    </tr>\n";
			$display_page_number .="</table>\n";
			
			$count_number =get_page_count_number2($page,$b);
			$display_page_number = str_replace("{NUMBER}", $count_number, $display_page_number);
			
			if ($page > 1) {
				$page_pr = $page - 1 ;
				$dpn ="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&row_number=$row_number&page=$page_pr\"><img border=0 src=\"$ecard_url/templates/$cf_set_template/prv.gif\" style='vertical-align:middle' title='Page # $page_pr' alt='Page # $page_pr' /></a>";
				$display_page_number = str_replace("{A}", $dpn, $display_page_number);
			}
			else{
				$display_page_number = str_replace("{A}", "<img src=\"$ecard_url/templates/$cf_set_template/prv_disable.gif\" alt='' style='vertical-align:middle' />", $display_page_number);
			}
			$y=get_global_var("d_num");
			if ($page < $y) {
				$page_ne = $page + 1 ;
				$display_page_number = str_replace("{B}", "<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&row_number=$row_number&page=$page_ne\"><img border=0 src=\"$ecard_url/templates/$cf_set_template/next.gif\" style='vertical-align:middle' title='Page # $page_ne' alt='Page # $page_ne' /></a>", $display_page_number);
			}
			else{
				$display_page_number = str_replace("{B}", "<img src=templates/$cf_set_template/next_disable.gif alt='' style='vertical-align:middle' />", $display_page_number);
			}
		}
	}
	$array_global_var_addressbook_group[show_onload_javascript]="onkeypress=\"return noGlobalEnterKey(event)\"";
	set_global_var2($array_global_var_addressbook_group);

	//Display random banner HR & VT
	print_banner("0");
	print_banner("1");

	$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/show_addressbook_group.html");
	print_header_and_footer();
	
	//--------------------------------------------------------------------------------------
	function get_page_count_number2($page,$b){
		global $ecard_url,$step,$next_step,$row_number;
		$url="$ecard_url/index.php?step=$step&next_step=$next_step&row_number=$row_number";
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