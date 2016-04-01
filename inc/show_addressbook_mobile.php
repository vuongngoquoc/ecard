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
	if($action=="batch_load"){
	//global $cf_set_template,$was_imported_into_your_address_book_sucessfully,$items_was_added_into_your_address_book,$invalid_items,$already_exist_items_in_your_address_book,$cf_remider_before;
	$message="";
	$validnum=0;
	$invalidnum=0;
	$already_exist_num=0;
	$invalid="";
	$already_exist="";
	$owner=$_SESSION[ecardmax_user];
	$content=get_file_content($_FILES[addressfile][tmp_name]);
	$content=str_replace("\"","",$content);
	$addressbook=split("\n",$content);
	$str=str_replace(" ","_",$addressbook[0]);
	$str=str_replace("\"","",$str);
	$str=str_replace("-","",$str);
	$temp=split(",",$str);
	for($i=1;$i<count($addressbook);$i++){
		$item=split(",",$addressbook[$i]);
		for($k=0;$k<count($temp);$k++){
			$te=$temp[$k];
			$$te=$item[$k];
		}
		
		$book_phone="";
		if($Business_Phone!=""){
			$book_phone=$Business_Phone;
		}elseif ($Home_Phone!=""){
			$book_phone=$Home_Phone;
		}elseif($Mobile_Phone!=""){
			$book_phone=$Mobile_Phone;
		}
		$book_address1="";
		if($Business_Street!=""){
			$book_address1=$Business_Street;
		}else{
			$book_address1=$Home_Street;
		}
		$book_address2="";
		if($Business_Street_2!=""){
			$book_address2=$Business_Street_2;
		}else{
			$book_address2=$Home_Street_2;
		}
		$book_city="";
		if($Business_City!=""){
			$book_city=$Business_City;
		}else{
			$book_city=$Home_City;
		}
		
		$book_state="";
		if($Business_State!=""){
			$book_state=$Business_State;
		}else{
			$book_state=$Home_State;
		}
		
		$book_zip="";
		if($Business_Postal_Code!=""){
			$book_zip=$Business_Postal_Code;
		}else{
			$book_zip=$Home_Postal_Code;
		}
		$book_country="";
		if($Business_Country!=""){
			$book_country=$Business_Country;
		}else{
			$book_country=$Home_Country;
		}
		if($Birthday!=""){
			$br=split("/",$Birthday);
			$book_birth_mon=$br[0];
			$book_birth_mday=$br[1];
			$book_birth_year=$br[2];
		}else{
			/*
			$br=getdate();
			$book_birth_mon=$br[mon];
			$book_birth_mday=$br[mday];
			$book_birth_year=$br[year];
		*/
			$book_birth_mon=0;
			$book_birth_mday=0;
			$book_birth_year=0;

		}
		if($Email!=""){
			$Email_Address=$Email;
			$First_Name=$Name;
		}
		$mg_list="";
   	  $email1=get_dbvalue("max_addressbook","book_email","book_email='$Email_Address' AND book_user_name_id='$owner'");
		if(valid_email($Email_Address)){
		 if($email1==""){
		 	$Email_Address = trim($Email_Address);
		 	$First_Name = trim($First_Name);
		 	$Last_Name = trim($Last_Name);
			$fields="(book_fname,book_lname,book_nick,book_email,book_user_name_id,book_phone,book_address1,book_address2,book_city,book_state,book_zip,book_country,book_birth_mon,book_birth_mday,book_birth_year,book_reminder_yearly,book_datebefore,book_ag_relate_id)";
			$values="('$First_Name','$Last_Name','$First_Name','$Email_Address','$owner','$book_phone','$book_address1','$book_address2','$book_city','$book_state','$book_zip','$book_country','$book_birth_mon','$book_birth_mday','$book_birth_year','0','$cf_remider_before','$group_id')";
			$message.="<b><a href='mailto:$Email_Address' class=\"Menu_Link\">$Email_Address</a></b> $was_imported_into_your_address_book_sucessfully<br>";
			$mx_id=get_dbvalue("max_addressbook","MAX(book_id)","1=1");
			$mg_list.="$mx_id,";
			insert_data_to_db("max_addressbook",$fields,$values);
			$validnum++;
		 }else{
			$already_exist_num++;
			$already_exist.="<b><a href='mailto:$Email_Address' class=\"Menu_Link\">$Email_Address</a></b><br>";
		 }
		}else{
		 	$invalidnum++;
			if($Email_Address=="") $Email_Address="null";
			$invalid.="<b>$Email_Address</b><br>";
		}
	}
		//update_field_in_db2
		$message="$validnum $items_was_added_into_your_address_book<br>".$message;
		$invalid="<br>$invalidnum $invalid_items<br>".$invalid;
		$already_exist="$already_exist_num $already_exist_items_in_your_address_book<br>".$already_exist;
		set_global_var("show_info",$message.$invalid.$already_exist);
	}
	elseif($action=="add_new"){
		if($cf_show_date_option =="0"){ //MM DD YYYY
			list($book_birth_mon,$book_birth_mday,$book_birth_year)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="1"){ //DD MM YYYY
			list($book_birth_mday,$book_birth_mon,$book_birth_year)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="2"){ //YYYY DD MM
			list($book_birth_year,$book_birth_mday,$book_birth_mon)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="3"){ //YYYY MM DD
			list($book_birth_year,$book_birth_mon,$book_birth_mday)=split("\/",$time_end_textbox);
		}		
		if($book_birth_mon=="MM")$book_birth_mon=0;
		if($book_birth_mday=="DD")$book_birth_mday=0;
		if($book_birth_year=="YYYY")$book_birth_year=0;

		if($cf_show_date_option =="0"){ //MM DD YYYY
			list($book_special_mon,$book_special_mday,$book_special_year)=split("\/",$time_end_textbox_anni);
		}
		elseif($cf_show_date_option =="1"){ //DD MM YYYY
			list($book_special_mday,$book_special_mon,$book_special_year)=split("\/",$time_end_textbox_anni);
		}
		elseif($cf_show_date_option =="2"){ //YYYY DD MM
			list($book_special_year,$book_special_mday,$book_special_mon)=split("\/",$time_end_textbox_anni);
		}
		elseif($cf_show_date_option =="3"){ //YYYY MM DD
			list($book_special_year,$book_special_mon,$book_special_mday)=split("\/",$time_end_textbox_anni);
		}		
		if($book_special_mon=="MM")$book_special_mon=0;
		if($book_special_mday=="DD")$book_special_mday=0;
		if($book_special_year=="YYYY")$book_special_year=0;

		$field_name ="(book_fname,book_lname,book_nick,book_email,book_user_name_id,book_phone,book_address1,book_address2,book_city,book_state,book_zip,book_country,book_birthday_title,book_birth_mon,book_birth_mday,book_birth_year,book_special_day_title,book_special_mon,book_special_mday,book_special_year,book_datebefore,book_ag_relate_id)";
		$field_value ="('$book_fname','$book_lname','$book_nick','$book_email','$_SESSION[user_name_id]','$book_phone','$book_address1','$book_address2','$book_city','$book_state','$book_zip','$book_country','$book_fname $book_lname Birthday',$book_birth_mon,$book_birth_mday,$book_birth_year,'$book_fname $book_lname Anniversary',$book_special_mon,$book_special_mday,$book_special_year,$book_datebefore,'$book_ag_relate_id')";
		insert_data_to_db("max_addressbook",$field_name,$field_value);

		$show_info .="<div class=\"OK_Message\">$addressbook_show_info_new_contact_has_been_added</div><br />\n";
		$action="";
		$array_global_var_addressbook[action]="";
	}
	elseif($action=="delete_selected"){
		foreach($http_vars as $key=>$val){
			if(!(strpos($key,"mylist_id")===false)){ //if true
				$selected_id =str_replace("mylist_id","",$key);
				
				//Delete row in database
				delete_row("max_addressbook","book_id='$selected_id' LIMIT 1");
			}
		}
		$show_info .="<div class=\"OK_Message\">$addressbook_show_info_your_book_updated</div><br />\n";
		$action="";
		$array_global_var_addressbook[action]="";
	}
	elseif($action=="list_group_contact"){
		if($ag_id=="")$ag_id="0";
		$and_cond=" and book_ag_relate_id like '%,$ag_id,%' ";
		if($ag_id=="0"){
			$show_info="<div class=\"OK_Message\">$addressbook_show_info_view_all_in_group_default</div><br />";
		}
		else{
			$show_info="<div class=\"OK_Message\">$addressbook_show_info_view_all_in_group " . get_dbvalue("max_addressbook_group","ag_title","ag_id='$ag_id'")."</div><br />";
		}
	}
	elseif($action=="go_filter"){
		if($filter_field=="")$filter_field="book_lname";
		if($filter_alp=="0" || $filter_alp==""){
			$and_cond=" and $filter_field REGEXP '^[0-9]' ";
		}
		else{
			$and_cond=" and $filter_field like '$filter_alp%' ";
		}
		if($filter_field=="book_lname"){
			$addressbook_show_info_filter_by=str_replace("%show_name%",$addressbook_txt_last_name,$addressbook_show_info_filter_by);
		}
		elseif($filter_field=="book_fname"){
			$addressbook_show_info_filter_by=str_replace("%show_name%",$addressbook_txt_first_name,$addressbook_show_info_filter_by);
		}
		elseif($filter_field=="book_email"){
			$addressbook_show_info_filter_by=str_replace("%show_name%",$addressbook_txt_email,$addressbook_show_info_filter_by);
		}
		$addressbook_show_info_filter_by=str_replace("%show_key%",$filter_alp,$addressbook_show_info_filter_by);

		$show_info="<div class=\"OK_Message\">$addressbook_show_info_filter_by</div><br />";
	}
	elseif($action=="edit_me"){
		update_field_in_db("max_addressbook","$edit_key",$edit_key_value,"$edit_id='$edit_id_value' and book_user_name_id='$_SESSION[user_name_id]' LIMIT 1");
		exit;
	}
	elseif($action=="update_book_ag_relate_id"){
		$book_ag_relate_id=get_dbvalue("max_addressbook","book_ag_relate_id","book_id='$book_id' and book_user_name_id='$_SESSION[user_name_id]'");
		if($doaction=="add"){
			if((strpos($book_ag_relate_id,",$ag_id,")===false)){ //if false (not match)
				$book_ag_relate_id=",$ag_id$book_ag_relate_id";
			}					
		}
		else{
			$book_ag_relate_id=str_replace(",$ag_id,",",",$book_ag_relate_id);
		}				
		update_field_in_db("max_addressbook","book_ag_relate_id",$book_ag_relate_id,"book_id='$book_id' and book_user_name_id='$_SESSION[user_name_id]'");
		exit;
	}
	elseif($action=="validate_book_email"){
		//Check valid email address
		if(!valid_email($value)){
			print "<br />$myaccount_user_edit_email_error_msg_invalid $value";
			exit;
		}
		//Check if email has been used
		$chk_email=get_dbvalue("max_addressbook","book_id","book_email='$value' and book_user_name_id='$_SESSION[user_name_id]'");
		if($chk_email!=""){
			print "<br />$addressbook_show_info_email_already_added $value";
			exit;
		}
		//Update email
		update_field_in_db("max_addressbook","book_email",$value,"book_id='$book_id' and book_user_name_id='$_SESSION[user_name_id]'");
		exit;
	}
	elseif($action=="update_book_birthday"){
		if($cf_show_date_option =="0"){ //MM DD YYYY
			list($get_mon,$get_day,$get_year)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="1"){ //DD MM YYYY
			list($get_day,$get_mon,$get_year)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="2"){ //YYYY DD MM
			list($get_year,$get_day,$get_mon)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="3"){ //YYYY MM DD
			list($get_year,$get_mon,$get_day)=split("\/",$time_end_textbox);
		}		
		update_field_in_db2("max_addressbook","book_birth_mon='$get_mon',book_birth_mday='$get_day',book_birth_year='$get_year'", "book_id='$book_id' and book_user_name_id='$_SESSION[user_name_id]'");
		exit;
	}
	elseif($action=="update_book_anni"){
		if($cf_show_date_option =="0"){ //MM DD YYYY
			list($get_mon,$get_day,$get_year)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="1"){ //DD MM YYYY
			list($get_day,$get_mon,$get_year)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="2"){ //YYYY DD MM
			list($get_year,$get_day,$get_mon)=split("\/",$time_end_textbox);
		}
		elseif($cf_show_date_option =="3"){ //YYYY MM DD
			list($get_year,$get_mon,$get_day)=split("\/",$time_end_textbox);
		}
		update_field_in_db2("max_addressbook","book_special_mon='$get_mon',book_special_mday='$get_day',book_special_year='$get_year'", "book_id='$book_id' and book_user_name_id='$_SESSION[user_name_id]'");
		exit;
	}

	$keyword=stripslashes(trim($keyword));
	$keyword=str_replace("'","",$keyword);
	$keyword=str_replace("\"","",$keyword);

	if($row_number =="" || $row_number =="0" || !is_numeric($row_number)) $row_number = 15;
	$array_global_var_addressbook[row_number]=$row_number;
	$row_per_page = $row_number;

	if ($page < 1 || $page=="") $page =1;
	$start = ($page-1)* 1 * $row_per_page;
	$end = $start + 1 * $row_per_page;
	if($keyword==""){
		if($show_user_id==""){
			$list_data =set_array_from_query("max_addressbook","*","book_user_name_id='$_SESSION[user_name_id]' $and_cond Order by book_lname LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_addressbook","count(book_id)","book_user_name_id='$_SESSION[user_name_id]' $and_cond ");
		}
		else{
			$list_data =set_array_from_query("max_addressbook","*","book_user_name_id='$_SESSION[user_name_id]' and book_id='$show_user_id' Order by book_lname LIMIT $start,$row_per_page");
			$count_list=get_dbvalue("max_addressbook","count(book_id)","book_user_name_id='$_SESSION[user_name_id]' and book_id='$show_user_id' ");
		}
	}
	else{
		if($search_field == "all"){
			$cond= " book_user_name_id='$_SESSION[user_name_id]' and book_fname like '%$keyword%' or book_user_name_id='$_SESSION[user_name_id]' and book_lname like '%$keyword%' or book_user_name_id='$_SESSION[user_name_id]' and book_email like '%$keyword%' or book_user_name_id='$_SESSION[user_name_id]' and book_nick like '%$keyword%' or book_user_name_id='$_SESSION[user_name_id]' and book_phone like '%$keyword%' or book_user_name_id='$_SESSION[user_name_id]' and book_address1 like '%$keyword%' or book_user_name_id='$_SESSION[user_name_id]' and book_address2 like '%$keyword%' or book_user_name_id='$_SESSION[user_name_id]' and book_city like '%$keyword%' or book_user_name_id='$_SESSION[user_name_id]' and book_state like '%$keyword%' or book_user_name_id='$_SESSION[user_name_id]' and book_zip like '%$keyword%' or book_user_name_id='$_SESSION[user_name_id]' and book_country like '%$keyword%' ";
			$info=split(" ",$keyword);
			foreach($info as $key){
				$cond .= " or book_user_name_id='$_SESSION[user_name_id]' and book_fname like '%$key%' or book_user_name_id='$_SESSION[user_name_id]' and book_lname like '%$key%' or book_user_name_id='$_SESSION[user_name_id]' and book_email like '%$key%' or book_user_name_id='$_SESSION[user_name_id]' and book_nick like '%$key%' or book_user_name_id='$_SESSION[user_name_id]' and book_phone like '%$key%' or book_user_name_id='$_SESSION[user_name_id]' and book_address1 like '%$key%' or book_user_name_id='$_SESSION[user_name_id]' and book_address2 like '%$key%' or book_user_name_id='$_SESSION[user_name_id]' and book_city like '%$key%' or book_user_name_id='$_SESSION[user_name_id]' and book_state like '%$key%' or book_user_name_id='$_SESSION[user_name_id]' and book_zip like '%$key%' or book_user_name_id='$_SESSION[user_name_id]' and book_country like '%$key%' ";
			}			
		}
		elseif($search_field == "book_fname"){
			$cond= " book_user_name_id='$_SESSION[user_name_id]' and book_fname like '%$keyword%' ";	
			$info=split(" ",$keyword);
			foreach($info as $key){
				$cond .= " or book_user_name_id='$_SESSION[user_name_id]' and book_fname like '%$key%' ";
			}
		}
		elseif($search_field == "book_lname"){
			$cond= " book_user_name_id='$_SESSION[user_name_id]' and book_lname like '%$keyword%' ";	
			$info=split(" ",$keyword);
			foreach($info as $key){
				$cond .= " or book_user_name_id='$_SESSION[user_name_id]' and book_lname like '%$key%' ";
			}
		}
		elseif($search_field == "book_email"){
			$cond= " book_user_name_id='$_SESSION[user_name_id]' and book_email like '%$keyword%' ";	
			$info=split(" ",$keyword);
			foreach($info as $key){
				$cond .= " or book_user_name_id='$_SESSION[user_name_id]' and book_email like '%$key%' ";
			}
		}
		elseif($search_field == "book_nick"){
			$cond= " book_user_name_id='$_SESSION[user_name_id]' and book_nick like '%$keyword%' ";	
			$info=split(" ",$keyword);
			foreach($info as $key){
				$cond .= " or book_user_name_id='$_SESSION[user_name_id]' and book_nick like '%$key%' ";
			}
		}
		elseif($search_field == "book_phone"){
			$cond= " book_user_name_id='$_SESSION[user_name_id]' and book_phone like '%$keyword%' ";	
			$info=split(" ",$keyword);
			foreach($info as $key){
				$cond .= " or book_user_name_id='$_SESSION[user_name_id]' and book_phone like '%$key%' ";
			}
		}
		elseif($search_field == "book_address1"){
			$cond= " book_user_name_id='$_SESSION[user_name_id]' and book_address1 like '%$keyword%' ";	
			$info=split(" ",$keyword);
			foreach($info as $key){
				$cond .= " or book_user_name_id='$_SESSION[user_name_id]' and book_address1 like '%$key%' ";
			}
		}
		elseif($search_field == "book_address2"){
			$cond= " book_user_name_id='$_SESSION[user_name_id]' and book_address2 like '%$keyword%' ";	
			$info=split(" ",$keyword);
			foreach($info as $key){
				$cond .= " or book_user_name_id='$_SESSION[user_name_id]' and book_address2 like '%$key%' ";
			}
		}
		elseif($search_field == "book_city"){
			$cond= " book_user_name_id='$_SESSION[user_name_id]' and book_city like '%$keyword%' ";	
			$info=split(" ",$keyword);
			foreach($info as $key){
				$cond .= " or book_user_name_id='$_SESSION[user_name_id]' and book_city like '%$key%' ";
			}
		}
		elseif($search_field == "book_state"){
			$cond= " book_user_name_id='$_SESSION[user_name_id]' and book_state like '%$keyword%' ";	
			$info=split(" ",$keyword);
			foreach($info as $key){
				$cond .= " or book_user_name_id='$_SESSION[user_name_id]' and book_state like '%$key%' ";
			}
		}
		elseif($search_field == "book_zip"){
			$cond= " book_user_name_id='$_SESSION[user_name_id]' and book_zip like '%$keyword%' ";	
			$info=split(" ",$keyword);
			foreach($info as $key){
				$cond .= " or book_user_name_id='$_SESSION[user_name_id]' and book_zip like '%$key%' ";
			}
		}
		elseif($search_field == "book_country"){
			$cond= " book_user_name_id='$_SESSION[user_name_id]' and book_country like '%$keyword%' ";	
			$info=split(" ",$keyword);
			foreach($info as $key){
				$cond .= " or book_user_name_id='$_SESSION[user_name_id]' and book_country like '%$key%' ";
			}
		}
		$list_data =set_array_from_query("max_addressbook","*","$cond Order by book_lname LIMIT $start,$row_per_page");
		$count_list=get_dbvalue("max_addressbook","count(book_id)","$cond ");		
		$show_info ="<div class=\"OK_Message\">$addressbook_show_info_search_with_keyword $keyword</div><br />";
	}

	$list_bgroup =set_array_from_query("max_addressbook_group","*","ag_user_id='$_SESSION[user_id]' Order by ag_title");
	if ($end > $count_list) $end = $count_list;
	$xrow=0;
	for ($z=$start; $z<$end; $z++) {
		$val = $list_data[$xrow][book_id] ;
		$row_data=$list_data[$xrow];

		//Show group title, from name, from email
		if($row_data[book_nick]!=""){
			$show_nick="<br /><span class=\"book_nickname\">$row_data[book_nick]</span>";
		}
		else{
			$show_nick="";
		}
		$show_contact_title ="<div id=\"contact_title_email$val\"><span class=\"book_first_last_name\">$row_data[book_fname] $row_data[book_lname]</span><br /><span class=\"book_email\">$row_data[book_email]</span>$show_nick<br /><span class=\"book_phone\">$row_data[book_phone]</span></div>";

		//Show contact group
		$_ICON = "<i class='fa fa-share-square-o'></i>";
		$_LINK = "<a href='$ecard_url/index.php?step=$step&next_step=$next_step&action=list_group_contact&ag_id=0'>$_ICON</a>";
		if(!(strpos($row_data[book_ag_relate_id],",0,")===false)){ //if true (match)
			$_CHECK = "checked=\"checked\"";
		}
		$show_contact_group="<input onclick=\"if(this.checked){Editme('$ecard_url/index.php?step=$step&next_step=$next_step&action=update_book_ag_relate_id&doaction=add&book_id=$val&ag_id=','0',1,1,this.id);}else{Editme('$ecard_url/index.php?step=$step&next_step=$next_step&action=update_book_ag_relate_id&doaction=remove&book_id=$val&ag_id=','0',1,1,this.id);}\" type=\"checkbox\" name=\"change_bkg\" id=\"book_ag_relate_id0$val\" $_CHECK /> <strong>$addressbook_group_default_name</strong> $_LINK<br />";
		$show_contact_group2="<input type=\"checkbox\" name=\"my_ag_id0\" id=\"my_ag_id0\" value=\"0\" /> <strong>$addressbook_group_default_name</strong> <br />";
		$ck="0,";
		
		
		foreach($list_bgroup as $row_data_ag){
			$_HREF = "$ecard_url/index.php?step=$step&next_step=$next_step&action=list_group_contact&ag_id=$row_data_ag[ag_id]";
			$_LINK = "<a href='$_HREF'>$_ICON</a>";
			$_CHECK = "";
			if(!(strpos($row_data[book_ag_relate_id],",$row_data_ag[ag_id],")===false)){ //if true (match)
				$_CHECK = "checked=\"checked\"";
			}
			
			$show_contact_group.="<input onclick=\"if(this.checked){Editme('$ecard_url/index.php?step=$step&next_step=$next_step&action=update_book_ag_relate_id&doaction=add&book_id=$val&ag_id=','$row_data_ag[ag_id]',1,1,this.id);}else{Editme('$ecard_url/index.php?step=$step&next_step=$next_step&action=update_book_ag_relate_id&doaction=remove&book_id=$val&ag_id=','$row_data_ag[ag_id]',1,1,this.id);}\" type=\"checkbox\" name=\"change_bkg\" id=\"book_ag_relate_id$row_data_ag[ag_id]$val\" $_CHECK /> $row_data_ag[ag_title] $_LINK<br />";
			$show_contact_group2.="<input type=\"checkbox\" name=\"my_ag_id$row_data_ag[ag_id]\" id=\"my_ag_id$row_data_ag[ag_id]\" value=\"$row_data_ag[ag_id]\" /> $row_data_ag[ag_title]<br />";
			$ck .="$row_data_ag[ag_id],";
		}
		$show_contact_group = "<label class='input-inline'>".$show_contact_group."</label>";
		//Show birthday & anniversary reminder date
		if($cf_show_date_option =="0"){ //MM DD YYYY
			$ins_date_caption="MM/DD/YYYY";
			if($row_data[book_birth_mon]=="0" || $row_data[book_birth_mday]=="0"){
				$show_user_birthday="MM/DD/YYYY";
			}
			elseif($row_data[book_birth_mon]!="0" && $row_data[book_birth_mday]!="0" && $row_data[book_birth_year]=="0"){
				$show_user_birthday="$row_data[book_birth_mon]/$row_data[book_birth_mday]/$today_year";
			}
			elseif($row_data[book_birth_mon]!="0" && $row_data[book_birth_mday]!="0" && $row_data[book_birth_year]!="0"){
				$show_user_birthday="$row_data[book_birth_mon]/$row_data[book_birth_mday]/$row_data[book_birth_year]";
			}
		}
		elseif($cf_show_date_option =="1"){ //DD MM YYYY
			$ins_date_caption="DD/MM/YYYY";
			if($row_data[book_birth_mon]=="0" || $row_data[book_birth_mday]=="0"){
				$show_user_birthday="DD/MM/YYYY";
			}
			elseif($row_data[book_birth_mon]!="0" && $row_data[book_birth_mday]!="0" && $row_data[book_birth_year]=="0"){
				$show_user_birthday="$row_data[book_birth_mday]/$row_data[book_birth_mon]/$today_year";
			}
			elseif($row_data[book_birth_mon]!="0" && $row_data[book_birth_mday]!="0" && $row_data[book_birth_year]!="0"){
				$show_user_birthday="$row_data[book_birth_mday]/$row_data[book_birth_mon]/$row_data[book_birth_year]";
			}
		}
		elseif($cf_show_date_option =="2"){ //YYYY DD MM
			$ins_date_caption="YYYY/DD/MM";
			if($row_data[book_birth_mon]=="0" || $row_data[book_birth_mday]=="0"){
				$show_user_birthday="YYYY/DD/MM";
			}
			elseif($row_data[book_birth_mon]!="0" && $row_data[book_birth_mday]!="0" && $row_data[book_birth_year]=="0"){
				$show_user_birthday="$today_year/$row_data[book_birth_mday]/$row_data[book_birth_mon]";
			}
			elseif($row_data[book_birth_mon]!="0" && $row_data[book_birth_mday]!="0" && $row_data[book_birth_year]!="0"){
				$show_user_birthday="$row_data[book_birth_year]/$row_data[book_birth_mday]/$row_data[book_birth_mon]";
			}
		}
		elseif($cf_show_date_option =="3"){ //YYYY MM DD
			$ins_date_caption="YYYY/MM/DD";
			if($row_data[book_birth_mon]=="0" || $row_data[book_birth_mday]=="0"){
				$show_user_birthday="YYYY/MM/DD";
			}
			elseif($row_data[book_birth_mon]!="0" && $row_data[book_birth_mday]!="0" && $row_data[book_birth_year]=="0"){
				$show_user_birthday="$today_year/$row_data[book_birth_mon]/$row_data[book_birth_mday]";
			}
			elseif($row_data[book_birth_mon]!="0" && $row_data[book_birth_mday]!="0" && $row_data[book_birth_year]!="0"){
				$show_user_birthday="$row_data[book_birth_year]/$row_data[book_birth_mon]/$row_data[book_birth_mday]";
			}
		}	
		$_onClick = "calendar_what='birthday';InsertDate($val,this.value)";
		$show_important_date="<input onchange=\"$_onClick\" class=\"datepicker input_ajax_editable\" readonly=\"readonly\" type=\"text\" name=\"change_bkg\" id=\"time_end_textbox$val\" value=\"$show_user_birthday\" style=\"width:100px\" title=\"$ins_date_caption\"/><i class='fa fa-birthday-cake padding5' title='$addressbook_txt_reminder_birthday_tooltip'></i>";
		
		if($cf_show_date_option =="0"){ //MM DD YYYY
			$ins_date_caption="MM/DD/YYYY";
			if($row_data[book_special_mon]=="0" || $row_data[book_special_mday]=="0"){
				$show_user_anni="MM/DD/YYYY";
			}
			elseif($row_data[book_special_mon]!="0" && $row_data[book_special_mday]!="0" && $row_data[book_special_year]=="0"){
				$show_user_anni="$row_data[book_special_mon]/$row_data[book_special_mday]/$today_year";
			}
			elseif($row_data[book_special_mon]!="0" && $row_data[book_special_mday]!="0" && $row_data[book_special_year]!="0"){
				$show_user_anni="$row_data[book_special_mon]/$row_data[book_special_mday]/$row_data[book_special_year]";
			}
		}
		elseif($cf_show_date_option =="1"){ //DD MM YYYY
			$ins_date_caption="DD/MM/YYYY";
			if($row_data[book_special_mon]=="0" || $row_data[book_special_mday]=="0"){
				$show_user_anni="DD/MM/YYYY";
			}
			elseif($row_data[book_special_mon]!="0" && $row_data[book_special_mday]!="0" && $row_data[book_special_year]=="0"){
				$show_user_anni="$row_data[book_special_mday]/$row_data[book_special_mon]/$today_year";
			}
			elseif($row_data[book_special_mon]!="0" && $row_data[book_special_mday]!="0" && $row_data[book_special_year]!="0"){
				$show_user_anni="$row_data[book_special_mday]/$row_data[book_special_mon]/$row_data[book_special_year]";
			}
		}
		elseif($cf_show_date_option =="2"){ //YYYY DD MM
			$ins_date_caption="YYYY/DD/MM";
			if($row_data[book_special_mon]=="0" || $row_data[book_special_mday]=="0"){
				$show_user_anni="YYYY/DD/MM";
			}
			elseif($row_data[book_special_mon]!="0" && $row_data[book_special_mday]!="0" && $row_data[book_special_year]=="0"){
				$show_user_anni="$today_year/$row_data[book_special_mday]/$row_data[book_special_mon]";
			}
			elseif($row_data[book_special_mon]!="0" && $row_data[book_special_mday]!="0" && $row_data[book_special_year]!="0"){
				$show_user_anni="$row_data[book_special_year]/$row_data[book_special_mday]/$row_data[book_special_mon]";
			}
		}
		elseif($cf_show_date_option =="3"){ //YYYY MM DD
			$ins_date_caption="YYYY/MM/DD";
			if($row_data[book_special_mon]=="0" || $row_data[book_special_mday]=="0"){
				$show_user_anni="YYYY/MM/DD";
			}
			elseif($row_data[book_special_mon]!="0" && $row_data[book_special_mday]!="0" && $row_data[book_special_year]=="0"){
				$show_user_anni="$today_year/$row_data[book_special_mon]/$row_data[book_special_mday]";
			}
			elseif($row_data[book_special_mon]!="0" && $row_data[book_special_mday]!="0" && $row_data[book_special_year]!="0"){
				$show_user_anni="$row_data[book_special_year]/$row_data[book_special_mon]/$row_data[book_special_mday]";
			}
		}
		$_onClick = "calendar_what='anni';InsertDate($val,this.value)";
		$show_important_date.="<input onchange=\"$_onClick\" onchange='SetFormat(this.value);' class=\"datepicker input_ajax_editable middle-elm\" readonly=\"readonly\" type=\"text\" name=\"change_bkg\" id=\"time_end_textbox_anni$val\" value=\"$show_user_anni\" style=\"width:100px\" title=\"$ins_date_caption\"/><i class='fa fa-calendar padding5' title='$addressbook_txt_reminder_anni_tooltip'></i>";
		
		if($row_data[book_datebefore]=="0"){
			$datebefore_0="selected=\"selected\"";
			$datebefore_1="";
			$datebefore_2="";
			$datebefore_3="";
			$datebefore_7="";
			$datebefore_14="";
		}
		elseif($row_data[book_datebefore]=="1"){
			$datebefore_0="";
			$datebefore_1="selected=\"selected\"";
			$datebefore_2="";
			$datebefore_3="";
			$datebefore_7="";
			$datebefore_14="";
		}
		elseif($row_data[book_datebefore]=="2"){
			$datebefore_0="";
			$datebefore_1="";
			$datebefore_2="selected=\"selected\"";
			$datebefore_3="";
			$datebefore_7="";
			$datebefore_14="";
		}
		elseif($row_data[book_datebefore]=="3"){
			$datebefore_0="";
			$datebefore_1="";
			$datebefore_2="";
			$datebefore_3="selected=\"selected\"";
			$datebefore_7="";
			$datebefore_14="";
		}
		elseif($row_data[book_datebefore]=="7"){
			$datebefore_0="";
			$datebefore_1="";
			$datebefore_2="";
			$datebefore_3="";
			$datebefore_7="selected=\"selected\"";
			$datebefore_14="";
		}
		elseif($row_data[book_datebefore]=="14"){
			$datebefore_0="";
			$datebefore_1="";
			$datebefore_2="";
			$datebefore_3="";
			$datebefore_7="";
			$datebefore_14="selected=\"selected\"";
		}
		$show_important_date.="<select onchange=\"Editme('$ecard_url/index.php?step=$step&next_step=$next_step&action=edit_me&edit_id=book_id&edit_id_value=$val&edit_key=book_datebefore&edit_key_value=',this.value,1,1,this.id);\" title=\"$addressbook_txt_reminder_me\" size=\"1\" class=\"book_datebefore\" id=\"book_datebefore$val\"><option value=\"0\" $datebefore_0>$addressbook_txt_reminder_me_on_date</option><option value=\"1\" $datebefore_1>$addressbook_txt_reminder_me_1day_b4</option><option value=\"2\" $datebefore_2>$addressbook_txt_reminder_me_2day_b4</option><option value=\"3\" $datebefore_3>$addressbook_txt_reminder_me_3day_b4</option><option value=\"7\" $datebefore_7>$addressbook_txt_reminder_me_7day_b4</option><option value=\"14\" $datebefore_14>$addressbook_txt_reminder_me_14day_b4</option></select>";

		//Show contact detail table
		foreach($row_data as $key=>$value){
			$array_key[get_id]=$val;
			$array_key[$key]=$value;
			set_global_var2($array_key);
			$show_contact_detail_table_temp =get_html_from_layout("templates/$cf_set_template/show_addressbook_contact_detail.html");
		}
		$show_contact_detail_table.=$show_contact_detail_table_temp;


		//Show view edit contact icon
		$show_view_edit_icon="<i class='fa fa-user' onclick=\"showContactDetail('popup_detail$val',1);\" title=\"$addressbook_table_icon_tooltip_view_edit_contact\"></i>";
		//Show delete button
		$show_delete_button="<button onclick=\"document.getElementById('bk$val').checked='true';single_check_uncheck('tr$val','bk$val');CheckSelected();\" border=\"0\" src=\"$ecard_url/templates/$cf_set_template/icon_delete.gif\" title=\"$reminder_txt_event_delete\" class='btn btn-xs btn-default'><i class='fa fa-remove'></i></button>";

		$show_list_table .="<tr id=\"tr$val\" class=\"table_td_background\">\n";
		$show_list_table .="<td width=\"1%\" class='text-center' id=\"cell$val\">$show_view_edit_icon</td>\n";
		$show_list_table .="<td width=\"*\" onclick=\"showContactDetail('popup_detail$val',1);\" title=\"$addressbook_table_icon_tooltip_view_edit_contact\">$show_contact_title</td>\n";
		$show_list_table .="<td width=\"*\">$show_contact_group</td>\n";
		$show_list_table .="<td width=\"1%\" >$show_important_date</td>\n";		
		$show_list_table .="<td width=\"1%\" class='text-center'>$show_delete_button</td>\n";
		$show_list_table .="<td width=\"1%\" class='text-center'><input onclick=\"single_check_uncheck('tr$val','bk$val');\" type=\"checkbox\" id=\"bk$val\" name=\"mylist_id$val\" value=\"$val\" /></td>\n";
		$show_list_table .="</tr>\n";
		$bk_id .="$val,";
		$xrow++;
	}
	if($bk_id{strlen($bk_id)-1} ==",") $bk_id = substr($bk_id, 0, strlen($bk_id)-1);
	if($ck{strlen($ck)-1} ==",") $ck= substr($ck, 0, strlen($ck)-1);
	if($ck==""){
		$ck="0";
		$show_contact_group2="<input type=\"checkbox\" name=\"my_ag_id0\" id=\"my_ag_id0\" value=\"0\" /> <strong>$addressbook_group_default_name</strong> <br />";
	}
	
	$array_global_var_addressbook[show_contact_group]=$show_contact_group2;

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

			$display_page_number .="<br clear=\"all\" /><ul id=paging class='pagination'>";
			$display_page_number .="      <li>{A}</li>";
			$display_page_number .="      <li>{NUMBER}</li>";
			$display_page_number .="      <li>{B}</li>";
			$display_page_number .="</ul>";		
			
			$count_number =get_page_count_number2($page,$b);
			$display_page_number = str_replace("{NUMBER}", $count_number, $display_page_number);
			
			if ($page > 1) {
				$page_pr = $page - 1 ;				
				$dpn ="<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&action=$action&ag_id=$ag_id&row_number=$row_number&page=$page_pr&filter_field=$filter_field&filter_alp=$filter_alp&search_field=$search_field&keyword=$keyword\">&laquo;</a>";
				$display_page_number = str_replace("{A}", $dpn, $display_page_number);
			}
			else{
				$display_page_number = str_replace("{A}", "&laquo;", $display_page_number);
			}
			$y=get_global_var("d_num");
			if ($page < $y) {
				$page_ne = $page + 1 ;				
				$display_page_number = str_replace("{B}", "<a href=\"$ecard_url/index.php?step=$step&next_step=$next_step&action=$action&ag_id=$ag_id&row_number=$row_number&page=$page_ne&filter_field=$filter_field&filter_alp=$filter_alp&search_field=$search_field&keyword=$keyword\">&raquo;</a>", $display_page_number);
			}	
			else{
				$display_page_number = str_replace("{B}", "&raquo;", $display_page_number);
			}
		}
	}

	$array_global_var_addressbook["selected_search_field_".$search_field]="selected=\"selected\"";
	$array_global_var_addressbook["selected_filter_field_".$filter_field]="selected=\"selected\"";
	$array_global_var_addressbook["selected_filter_alp_".$filter_alp]="selected=\"selected\"";
	$array_global_var_addressbook[show_onload_javascript]="onkeypress=\"return noGlobalEnterKey(event)\"";
	set_global_var2($array_global_var_addressbook);

	//Display random banner HR & VT
	print_banner("0");
	print_banner("1");

	//Show date
	if($cf_show_date_option =="0"){ //MM DD YYYY
		$ins_date_caption="MM/DD/YYYY";
	}
	elseif($cf_show_date_option =="1"){ //DD MM YYYY
		$ins_date_caption="DD/MM/YYYY";
	}
	elseif($cf_show_date_option =="2"){ //YYYY DD MM
		$ins_date_caption="YYYY/DD/MM";
	}
	elseif($cf_show_date_option =="3"){ //YYYY MM DD
		$ins_date_caption="YYYY/MM/DD";
	}
	$data=set_array_from_query("max_addressbook_group","*","ag_user_id=$_SESSION[user_id]");
	if($group_id==0){
		$select_group_list="<option value=\"0\" selected>$default_group</option>";
	}else{
		$select_group_list="<option value=\"0\">$default_group</option>";
	}
	
	$select_group_list.=buildOptions($data,"ag_id","ag_title","$group_id");
	set_global_var("navigator_link","<a href=\"".get_global_var(url_home)."\">$txt_home</a> <img border=\"0\" alt=\"\" src=\"$ecard_url/templates/$cf_set_template/arrow_nav.gif\" style=\"vertical-align:middle\" /> <a href=\"".get_global_var(url_addressbook_home)."\">$txt_mtool_addressbook</a>");
	set_global_var("select_group_list",$select_group_list);
	$array_global_var[print_object]=get_html_from_layout("templates/$cf_set_template/show_addressbook.html") . $show_contact_detail_table;
	print_header_and_footer();

	//--------------------------------------------------------------------------------------
	function get_page_count_number2($page,$b){
		global $ecard_url,$step,$next_step,$row_number,$action,$ag_id,$filter_field,$filter_alp,$search_field,$keyword;
			
		$url="$ecard_url/index.php?step=$step&next_step=$next_step&action=$action&ag_id=$ag_id&row_number=$row_number&filter_field=$filter_field&filter_alp=$filter_alp&search_field=$search_field&keyword=$keyword";
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