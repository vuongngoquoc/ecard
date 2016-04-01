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
	session_start();
	define("ECARDMAX_USER", 1);
	require_once ("config.php");
	require_once("getvars.php");
	require_once("function.php");
	//Get System Configuration 
	$list_cf=set_array_from_query("max_config","*");
	foreach($list_cf as $array_cf){
		$$array_cf[config_name]=$array_cf[config_value];
	}
	include("$ecard_root/languages/$_SESSION[ecardmax_lang]");

	# Check $payment_status

	$credit_card_processed = get_global_var("credit_card_processed");

	if ($cf_enable_2co_test_mode !="1"){
		if ($credit_card_processed != "Y" || preg_match("/y/si",$demo)){
			print "<script language=javascript>\n";
			print "alert('There is something wrong with your order. You cannot create account at this time');\n";
			print "location.href='$ecard_url';\n";
			print "</script>";	
			exit();
		}
	}	


	# Create passcode - Get random ID
	$user_name_id= get_global_var("user_name_id");
	$order_number = get_global_var("order_number");
	$email = get_global_var("email");
	$card_holder_name = get_global_var("card_holder_name");
	$street_address = get_global_var("street_address");
	$city = get_global_var("city");
	$state = get_global_var("state");
	$zip = get_global_var("zip");
	$country = get_global_var("country");
	$phone = get_global_var("phone");
	$payment_amount = get_global_var("total");
	$key = get_global_var("key");
	$lang = get_global_var("lang");
	$pay_mg_id= get_global_var("mg_id");
	if($pay_mg_id=="")$pay_mg_id=0;
	$ecqid= get_global_var("ecqid");
	$ec_id= get_global_var("ec_id");
	if($ec_id==""){
		$ec_id=0;
		$pay_what=1;//Upgrade acct
	}
	else{
		$pay_what=0;//Paypercard
	}
	$secret_word = $cf_2co_secret_word;
	$vendor_number = $cf_2co_sid_number;
	if ($cf_enable_2co_test_mode =="1"){
		$order_number2 = "1";
	}
	else{
		$order_number2 = $order_number;
	}

	$str="$secret_word$vendor_number$order_number2$payment_amount";
	$key2 = md5($str);
	$key=strtoupper($key);
	$key2=strtoupper($key2);

	if ($key != $key2){
		print "<script language=javascript>\n";
		print "alert('Sorry! There is something wrong with your order. Please contact admin for more information');\n";
		print "location.href='$ecard_url/index.php?lang=$lang';\n";
		print "</script>";	
		exit();
	}	
	
	//Insert to database
	$gmt_timestamp_now=timestamp_gmt_output($cf_timezone);
	$field_name ="(pay_user_name_id,pay_what,pay_ecqid,pay_ec_id,pay_via,pay_order_number,pay_amount,pay_date,pay_status,pay_name,pay_email,pay_mg_id)";
	$field_value ="('$user_name_id',$pay_what,'$ecqid',$ec_id,'2CheckOut','$order_number',$payment_amount,$gmt_timestamp_now,1,'$card_holder_name','$email',$pay_mg_id)";
	insert_data_to_db("max_payment",$field_name,$field_value);

	if($pay_what==1){//Upgrade acct
		$mg_row=get_row("max_member_group","*","mg_payment_amount='$payment_amount' and mg_id='$pay_mg_id'");
		$mg_dateclose=$mg_row[mg_dateclose];
		if($mg_dateclose!=""){
			if($mg_dateclose=="1"){
				$time_input = $gmt_timestamp_now + (86400*30);//1 mon
				$set_user_beclosed=3;
			}
			elseif($mg_dateclose=="2"){
				$time_input = $gmt_timestamp_now + (86400*30*3);//3 mon
				$set_user_beclosed=3;
			}
			elseif($mg_dateclose=="3"){
				$time_input = $gmt_timestamp_now + (86400*30*6);//6 mon
				$set_user_beclosed=3;
			}
			elseif($mg_dateclose=="4"){
				$time_input = $gmt_timestamp_now + (86400*365);//1 year
				$set_user_beclosed=3;
			}
			elseif($mg_dateclose=="5"){
				$time_input = $gmt_timestamp_now + (86400*365*2);//2 years
				$set_user_beclosed=3;
			}
			else{
				$time_input=0;
				$set_user_beclosed=0;
			}
			update_field_in_db2("max_ecuser","user_mg_id='$pay_mg_id',user_beclosed='$set_user_beclosed',user_dateclose='$time_input'", "user_name_id='$user_name_id'");
			$row_user=get_row("max_ecuser","*","user_name_id='$user_name_id'");
			foreach($row_user as $ukey=>$uval){
				$_SESSION[$ukey]=$uval;
			}
			foreach($mg_row as $mkey=>$mval){
				$_SESSION[$mkey]=$mval;
			}
			header("Location:$ecard_url/index.php?step=sign_in&next_step=show_myaccount\n");
		}
	}
	else{//Pay per card
		$current_balance=get_dbvalue("max_ecuser","user_balance","user_name_id='$user_name_id'");
		update_field_in_db("max_ecuser","user_balance",$payment_amount+$current_balance,"user_name_id='$user_name_id' LIMIT 1");
		if($_SESSION[iv_id]!=""){
			header("Location:$ecard_url/index.php?step=sendcard_invite&iv_id=$_SESSION[iv_id]\n");
		}
		elseif($_SESSION[ec_id]!=""){
			header("Location:$ecard_url/index.php?step=sendcard&ec_id=$_SESSION[ec_id]\n");
		}
	}	
?>