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
	
	$list_data=set_array_from_query("max_member_group","*","mg_id<>'1' and mg_id<>'2' Order by mg_payment_amount DESC");
	foreach($list_data as $row_data){
		$show_table_group .="<table class=\"table_border\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tr><td>";
		$show_table_group .="<div class=\"table_title_bar\">$update_your_account_join_group_name $row_data[mg_title] (".price_format($row_data[mg_payment_amount]).")</div><div style=\"padding:4px;margin-left:15px\"><br />";
		
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_max_recipient</div><span class=\"OK_Message\">$row_data[mg_number_recipient]</span><br /><br />";
		if($row_data[mg_number_recipient_per_hour]=="0"){
			$show_mg_number_recipient_per_hour=$myaccount_txt_unlimited;
		}
		else{
			$show_mg_number_recipient_per_hour=$row_data[mg_number_recipient_per_hour];
		}
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_max_recipient_per_hour</div><span class=\"OK_Message\">$show_mg_number_recipient_per_hour</span><br /><br />";
		
		if($row_data[mg_number_recipient_per_day]=="0"){
			$show_mg_number_recipient_per_day=$myaccount_txt_unlimited;
		}
		else{
			$show_mg_number_recipient_per_day=$row_data[mg_number_recipient_per_day];
		}
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_max_recipient_per_day</div><span class=\"OK_Message\">$show_mg_number_recipient_per_day</span><br /><br />";
		
		if($row_data[mg_show_watermark]=="1"){
			$show_yes_no=$myaccount_txt_yes;
		}
		else{
			$show_yes_no=$myaccount_txt_no;
		}
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_show_watermark</div>$show_yes_no<br /><br />";

		if($row_data[mg_show_banner]=="1"){
			$show_yes_no=$myaccount_txt_yes;
		}
		else{
			$show_yes_no=$myaccount_txt_no;
		}
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_show_banner</div>$show_yes_no<br /><br />";

		if($row_data[mg_allow_game]=="1"){
			$show_yes_no=$myaccount_txt_yes;
		}
		else{
			$show_yes_no=$myaccount_txt_no;
		}
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_allow_game</div>$show_yes_no<br /><br />";

		if($row_data[mg_allow_grabber]=="1"){
			$show_yes_no=$myaccount_txt_yes;
		}
		else{
			$show_yes_no=$myaccount_txt_no;
		}
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_allow_grabber</div>$show_yes_no<br /><br />";

		if($row_data[mg_allow_search]=="1"){
			$show_yes_no=$myaccount_txt_yes;
		}
		else{
			$show_yes_no=$myaccount_txt_no;
		}
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_allow_search</div>$show_yes_no<br /><br />";

		if($row_data[mg_allow_futuredate]=="1"){
			$show_yes_no=$myaccount_txt_yes;
		}
		else{
			$show_yes_no=$myaccount_txt_no;
		}
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_allow_futuredate</div>$show_yes_no<br /><br />";

		if($row_data[mg_allow_rate]=="1"){
			$show_yes_no=$myaccount_txt_yes;
		}
		else{
			$show_yes_no=$myaccount_txt_no;
		}
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_allow_rate</div>$show_yes_no<br /><br />";

		if($row_data[mg_allow_viewfullsize]=="1"){
			$show_yes_no=$myaccount_txt_yes;
		}
		else{
			$show_yes_no=$myaccount_txt_no;
		}
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_allow_viewfullsize</div>$show_yes_no<br /><br />";

		if($row_data[mg_allow_myaccount]=="1"){
			$show_yes_no=$myaccount_txt_yes;
		}
		else{
			$show_yes_no=$myaccount_txt_no;
		}
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_allow_myaccount</div>$show_yes_no<br /><br />";

		if($row_data[mg_allow_addressbook]=="1"){
			$show_yes_no=$myaccount_txt_yes;
		}
		else{
			$show_yes_no=$myaccount_txt_no;
		}
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_allow_addressbook</div>$show_yes_no<br /><br />";

		if($row_data[mg_allow_reminder]=="1"){
			$show_yes_no=$myaccount_txt_yes;
		}
		else{
			$show_yes_no=$myaccount_txt_no;
		}
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_allow_reminder</div>$show_yes_no<br /><br />";

		if($row_data[mg_allow_calendar]=="1"){
			$show_yes_no=$myaccount_txt_yes;
		}
		else{
			$show_yes_no=$myaccount_txt_no;
		}
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_allow_calendar</div>$show_yes_no<br /><br />";

		if($row_data[mg_allow_myalbum]=="1"){
			$show_yes_no=$myaccount_txt_yes;
		}
		else{
			$show_yes_no=$myaccount_txt_no;
		}
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_allow_myalbum</div>$show_yes_no<br /><br />";

		if($row_data[mg_allow_favorite]=="1"){
			$show_yes_no=$myaccount_txt_yes;
		}
		else{
			$show_yes_no=$myaccount_txt_no;
		}
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_allow_favorite</div>$show_yes_no<br /><br />";
		
		if($row_data[mg_allow_history]=="1"){
			$show_yes_no=$myaccount_txt_yes;
		}
		else{
			$show_yes_no=$myaccount_txt_no;
		}
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_allow_history</div>$show_yes_no<br /><br />";

		if($row_data[mg_allow_birthdayalert]=="1"){
			$show_yes_no=$myaccount_txt_yes;
		}
		else{
			$show_yes_no=$myaccount_txt_no;
		}
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_allow_birthdayalert</div>$show_yes_no<br /><br />";
		
		if($row_data[mg_allow_2subaccount]=="1"){
			$show_yes_no=$myaccount_txt_yes;
		}
		else{
			$show_yes_no=$myaccount_txt_no;
		}
		$show_table_group .="<div style=\"float:left;width:85%;border-bottom:1px dashed silver\">$myaccount_allow_2subaccount</div>$show_yes_no<br /><br />";

		$show_table_group .="<div>$sign_in_become_member_send_free_ecard</div>";

		$show_table_group .= "<div style=\"float:left;width:100%\">".print_thumbnail("mg_card$row_data[mg_id]") ."</div><br>";
		
		$show_table_group .="<div style=\"float:left;width:100%;border-bottom:1px dashed silver\">  $myaccount_payment_amount</div><span class=\"OK_Message\">".price_format($row_data[mg_payment_amount])."</span><br /><br />";
		
		$_SESSION[ecqid]= substr(md5(uniqid(rand(),1)), 0, 8);
		if(!(strpos($row_data[mg_payment_method1],"2checkout.com")===false)){ //if 2CO sell link
			$row_data[mg_payment_method1].="&fixed=Y&mg_id=$row_data[mg_id]&ecqid=$_SESSION[ecqid]&user_name_id=$_SESSION[user_name_id]";
			if($cf_enable_2co_test_mode=="1")$row_data[mg_payment_method1].="&demo=Y";
		}
		elseif(!(strpos($row_data[mg_payment_method1],"paypal.com")===false)){ //if Paypal sell link
			// rewrite payment URL according to mode
			if ($cf_enable_paypal_test_mode==1) { 
				$row_data[mg_payment_method1] = str_replace("www.paypal.com","www.sandbox.paypal.com",$row_data[mg_payment_method1]);
				$row_data[mg_payment_method1] = str_replace($cf_paypal_primary_email,$cf_paypal_test_email,$row_data[mg_payment_method1]);
			}
			else {
				$row_data[mg_payment_method1] = str_replace("www.sandbox.paypal.com","www.paypal.com",$row_data[mg_payment_method1]);
				$row_data[mg_payment_method1] = str_replace($cf_paypal_test_email,$cf_paypal_primary_email,$row_data[mg_payment_method1]);
			}
			$row_data[mg_payment_method1].="&item_number=UpgradeAccount&invoice=$_SESSION[ecqid]&custom=$_SESSION[user_name_id],$row_data[mg_id]";
		}

		if($row_data[mg_buynow_title1]!="" && $row_data[mg_payment_method1]!=""){
			$button_buynow1="<a href=\"$row_data[mg_payment_method1]\" class=\"button_link_style1\">$row_data[mg_buynow_title1] <strong>".price_format($row_data[mg_payment_amount])."</strong></a>";
		}
		else{
			$button_buynow1="";
		}

		if(!(strpos($row_data[mg_payment_method2],"2checkout.com")===false)){ //if 2CO sell link
			$row_data[mg_payment_method2].="&fixed=Y&mg_id=$row_data[mg_id]&ec_id=$ec_id&ecqid=$_SESSION[ecqid]&user_name_id=$_SESSION[user_name_id]";
			if($cf_enable_2co_test_mode=="1")$row_data[mg_payment_method2].="&demo=Y";
		}
		elseif(!(strpos($row_data[mg_payment_method2],"paypal.com")===false)){ //if Paypal sell link
			// rewrite payment URL according to mode
			if ($cf_enable_paypal_test_mode==1) { 
				$row_data[mg_payment_method2] = str_replace("www.paypal.com","www.sandbox.paypal.com",$row_data[mg_payment_method2]);
				$row_data[mg_payment_method2] = str_replace($cf_paypal_primary_email,$cf_paypal_test_email,$row_data[mg_payment_method2]);
			}
			else {
				$row_data[mg_payment_method2] = str_replace("www.sandbox.paypal.com","www.paypal.com",$row_data[mg_payment_method2]);
				$row_data[mg_payment_method2] = str_replace($cf_paypal_test_email,$cf_paypal_primary_email,$row_data[mg_payment_method2]);
			}			
			$row_data[mg_payment_method2].="&item_number=UpgradeAccount&invoice=$_SESSION[ecqid]&custom=$_SESSION[user_name_id],$row_data[mg_id]";
		}

		if($row_data[mg_buynow_title2]!="" && $row_data[mg_payment_method2]!=""){
			$button_buynow2="<a href=\"$row_data[mg_payment_method2]\" class=\"button_link_style2\">$row_data[mg_buynow_title2] <strong>".price_format($row_data[mg_payment_amount])."</strong></a>";
		}
		else{
			$button_buynow2="";
		}
		
		$show_table_group .="<div>$button_buynow1  $button_buynow2</div><br />";

		$show_table_group .="</div></td></tr></table><br />";
	}
	$display_thumbnail=$show_table_group;
?>