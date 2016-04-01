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

	if($what=="add_new"){
		//Add new price
		if($ppc_amount>0 && get_dbvalue("max_paypercard","ppc_amount","ppc_amount='$ppc_amount'")==""){
			$field_name ="(ppc_amount,ppc_buynow_title1,ppc_payment_method1,ppc_buynow_title2,ppc_payment_method2)";
			$field_value ="($ppc_amount,'$ppc_buynow_title1','$ppc_payment_method1','$ppc_buynow_title2','$ppc_payment_method2')";
			insert_data_to_db("max_paypercard",$field_name,$field_value);
			$show_info="<div class=\"OK_Message\">$ecard_ppc_message_new_price_added</div><br />";
		}
		else{
			$show_info="<div class=\"Error_Message\">$ecard_ppc_message_amount_entered_invalid</div><br />";
		}
	}
	elseif($what=="delete_price"){
		
		//Delete
		delete_row("max_paypercard","ppc_id='$ppc_id' LIMIT 1"); 

		//Get all cards that belong to this price and reset it
		$mylist=get_dblistvalue("max_ecard","ec_id","ec_ppc_id='$ppc_id'");
		foreach($mylist as $ec_id){
			update_field_in_db("max_ecard","ec_ppc_id","","ec_id='$ec_id' LIMIT 1");
		}

	}

	$list_data =set_array_from_query("max_paypercard","*","ppc_id<>'' Order by ppc_amount");
	$show_list_table="";
	foreach($list_data as $row_data){
		$val = $row_data[ppc_id] ;		
		
		//Show price
		$show_price="Price: $cf_currecy <input onkeypress=\"return isMoney(event)\" id=\"ppc_amount$val\" title=\"$ecard_ppc_tooltip_click_to_edit\" type=\"text\" value=\"$row_data[ppc_amount]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:50px;text-decoration:underline;color:green\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"CheckPaymentAmount(this.value,'$val');\" />";

		//Show buy now title 1 + link
		$show_buynow_title1="$ecard_ppc_txt_buy_now_title 1:<br /><input id=\"ppc_buynow_title1$val\" title=\"$ecard_ppc_tooltip_click_to_edit\" type=\"text\" value=\"$row_data[ppc_buynow_title1]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:330px;text-decoration:underline;color:green\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"Editme('index.php?step=edit_me&table=max_paypercard&edit_id=ppc_id&edit_id_value=$val&edit_key=ppc_buynow_title1&edit_value=',this.value,'1',original_value,this.id);\" /><br /><br />$ecard_ppc_txt_buy_now_link 1:<br /><textarea onkeypress=\"return noEnterKey(event)\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_paypercard&edit_id=ppc_id&edit_id_value=$val&edit_key=ppc_payment_method1&edit_value=',this.value,'1',original_value,this.id);\" name=\"ppc_payment_method1$val\" id=\"ppc_payment_method1$val\" style=\"width:330px;height:100px;\">$row_data[ppc_payment_method1]</textarea>";

		//Show buy now title 2 + link
		if($row_data[ppc_buynow_title2]=="")$row_data[ppc_buynow_title2]="N/A";
		if($row_data[ppc_payment_method2]=="")$row_data[ppc_payment_method2]="N/A";
		$show_buynow_title2="$ecard_ppc_txt_buy_now_title 2:<br /><input id=\"ppc_buynow_title2$val\" title=\"$ecard_ppc_tooltip_click_to_edit\" type=\"text\" value=\"$row_data[ppc_buynow_title2]\" style=\"border:0px;background-color:#EAEAEA;cursor:pointer;width:330px;text-decoration:underline;color:green\" onfocus=\"original_value=this.value;this.style.border='1px solid silver';this.style.textDecoration='none';this.style.cursor='text';\" onblur=\"this.style.border='0px';this.style.textDecoration='underline';this.style.cursor='pointer';\" onchange=\"Editme('index.php?step=edit_me&table=max_paypercard&edit_id=ppc_id&edit_id_value=$val&edit_key=ppc_buynow_title2&edit_value=',this.value,'0',original_value,this.id);\" /><br /><br />$ecard_ppc_txt_buy_now_link 2:<br /><textarea onkeypress=\"return noEnterKey(event)\" onfocus=\"original_value=this.value;\" onchange=\"Editme('index.php?step=edit_me&table=max_paypercard&edit_id=ppc_id&edit_id_value=$val&edit_key=ppc_payment_method2&edit_value=',this.value,'0',original_value,this.id);\" name=\"ppc_payment_method2$val\" id=\"ppc_payment_method2$val\" style=\"width:330px;height:100px;\">$row_data[ppc_payment_method2]</textarea>";

		//Delete link
		$delete="<input class=\"button\" type=\"button\" value=\"Delete\" onclick=\"document.getElementById('tr$val').style.backgroundColor='#E8E8DA';if (window.confirm('$ecard_ppc_message_confirm_to_delete_amount')){location.href='index.php?step=$step&what=delete_price&ppc_id=$val';}else{document.getElementById('tr$val').style.backgroundColor='#EAEAEA';}\" />";

		$show_list_table .="<tr id=\"tr$val\" style=\"background-color: #EAEAEA;line-height:20px\">\n";	
		$show_list_table .="<td valign=\"top\"  style=\"white-space:nowrap\">$show_price</td>\n";
		$show_list_table .="<td>$show_buynow_title1</td>\n";
		$show_list_table .="<td>$show_buynow_title2</td>\n";
		$show_list_table .="<td valign=\"top\" align=\"center\">$delete</td>\n";
		$show_list_table .="</tr>\n";
		$bk_id .="$val,";
	}
	if($bk_id{strlen($bk_id)-1} ==",") $bk_id = substr($bk_id, 0, strlen($bk_id)-1);

	set_global_var("show_onload_javascript","onkeypress=\"return noGlobalEnterKey(event)\"");
	set_global_var("print_object",get_html_from_layout("admin/html/admin_set_price_ppc.html"));
	print_admin_header_footer_page();

?>