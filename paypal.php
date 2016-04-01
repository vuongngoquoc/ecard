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


	require_once ("config.php");
	require_once ("config2.php");
	require_once("getvars.php");
	require_once("function.php"); 
	
	//set_file_content("$ecard_root/admin/temp/pp.txt",json_encode($_POST));
	//Get System Configuration 
	/*$list_cf=set_array_from_query("max_config","*");
	set_file_content("$ecard_root/admin/temp/pp1.txt","paypay run");
	foreach($list_cf as $array_cf){
		$$array_cf[config_name]=$array_cf[config_value];
	}
	
	*/
	
	//set_file_content("$ecard_root/admin/temp/pp1.1.txt","paypay run");
	include("$ecard_root/languages/$cf_language");
	//set_file_content("$ecard_root/admin/temp/pp1.2.txt","paypay run");
	if ($cf_enable_paypal_test_mode==1) { $paypal_email_login = $cf_paypal_test_email; }
	else { $paypal_email_login = $cf_paypal_primary_email; }
	//set_file_content("$ecard_root/admin/temp/pp1.3.txt","paypay run");
	
	// read the post from PayPal system and add 'cmd'
	$req = 'cmd=_notify-validate';
////set_file_content("$ecard_root/admin/temp/pp1.4.txt","paypay run");
/*	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$req .= "&$key=$value";
	}*/
//set_file_content("$ecard_root/admin/temp/pp2.txt",$errstr);
	// post back to PayPal system to validate
	$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
//set_file_content("$ecard_root/admin/temp/pp3.txt",$errstr);
	//if ($cf_enable_paypal_test_mode==1) { $fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30); }
	//else { $fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30); }
	/*if ($cf_enable_paypal_test_mode==1) { $fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30); }
	else { $fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30); }*/
//set_file_content("$ecard_root/admin/temp/pp4.txt",$errstr);
	// assign posted variables to local variables
	$item_name = isset($_POST['item_name']) ? $_POST['item_name'] : '';
	$item_number =  isset($_POST['item_number']) ? $_POST['item_number'] : '';
	$custom = isset($_POST['custom']) ? $_POST['custom'] : '' ;
	$invoice= isset($_POST['invoice']) ? $_POST['invoice'] : '';
	//$payment_status = isset($_POST['payer_status']) ? $_POST['payer_status'] : '';//$_POST['payment_status'];  verified
	$payment_status = isset($_POST['payment_status']) ? $_POST['payment_status'] : '';//$_POST['payment_status'];  verified
	//$payment_amount = isset($_POST['amount3']) ? $_POST['amount3'] : '0'; //$_POST['mc_gross'];
	$payment_amount = isset($_POST['mc_gross']) ? $_POST['mc_gross'] : '0'; //$_POST['mc_gross'];
	$payment_currency = isset($_POST['mc_currency']) ? $_POST['mc_currency'] : 'USD';
	//$txn_id = isset($_POST['subscr_id']) ? $_POST['subscr_id'] : '';//$_POST['txn_id']
	$txn_id = isset($_POST['txn_id']) ? $_POST['txn_id'] : '';//
	$receiver_email = isset($_POST['receiver_email']) ? $_POST['receiver_email']: '';
	$payer_email = isset($_POST['payer_email']) ? $_POST['payer_email']: '';
	$first_name = isset($_POST['first_name']) ? $_POST['first_name']: '';
	$last_name = isset($_POST['last_name']) ? $_POST['last_name']: '';
	$address_street = isset($_POST['address_street']) ? $_POST['address_street']: '';
	$address_city = isset($_POST['address_city']) ? $_POST['address_city']: '';
	$address_state = isset($_POST['address_state']) ? $_POST['address_state']: '';
	$address_zip = isset($_POST['address_zip']) ? $_POST['address_zip']: '';
	$address_country = isset($_POST['address_country']) ? $_POST['address_country']: '';
	$lang= isset($_POST['lang']) ? $_POST['lang']: '';
	$ecqid= $invoice;
	/*
	$item_name = "Upgrade Account To Individual $14.95";
	$item_number = "UpgradeAccount";
	$custom = "anthony,3";
	$invoice= "f9626349";
	$payment_status = "verified";//$_POST['payment_status'];  verified
	$payment_amount = "0.01"; //$_POST['mc_gross'];
	$payment_currency = "USD";
	$txn_id = "S-90G53803BH9960457";//$_POST['txn_id']
	$receiver_email = "webmaster@ecardmax.com";
	$payer_email = "thaihang@hellokitty.com";
	$first_name = "haylie";
	$last_name = "nguyen";
	$address_street = "";
	$address_city = "";
	$address_state = "";
	$address_zip = "";
	$address_country = "";
	$lang= "English";
	$ecqid= "f9626349";
	
	*/
	
	list($user_name_id,$getID)=split(",",$custom);
	if($item_number=="PayPerCard"){
		$ec_id=$getID;
		$pay_mg_id=0;
		$pay_what=0;
	}
	else{
		$pay_mg_id=$getID;
		$ec_id=0;
		$pay_what=1;
	}	

// For testing only 
/*
$data=<<<EOF
e-num = $errno
e-string = $errstr
Item name = $item_name
Item number = $item_number
Custom = $custom;
Invoice= $invoice;
Payment status = $payment_status
Payment amount = $payment_amount
Payment currency = $payment_currency
Order Number = $txn_id
Receiver email =$receiver_email
Paypal email =$paypal_email_login
Payer email = $payer_email
First name = $first_name
Last name = $last_name
pay_mg_id=$pay_mg_id
ecqid=$ecqid
ec_id=$ec_id
EOF;
set_file_content("$ecard_root/admin/temp/pp5.txt",$data);*/

//set_file_content("$ecard_root/admin/temp/pp8.txt",$payment_amount);
					if (strtolower($payment_status) == "completed" || strtolower($payment_status) == "verified") {
						// check the payment_status is Completed
						
//set_file_content("$ecard_root/admin/temp/pp9.txt",$payment_amount);
						// check that txn_id has not been previously processed
						/*$
						
						chk_proc =get_dbvalue("max_payment","pay_id","pay_order_number='$txn_id'");
						if ($chk_proc != ""){ 
							$error = "Time: ".date("H:i:s - d/m/Y",time());
							$error .= "\n chk_proc: $chk_proc\n";
							set_file_content("$ecard_root/admin/temp/error.txt",$error);
								
							exit; 
						}*/
//set_file_content("$ecard_root/admin/temp/pp10.txt",$payment_amount);
						// check that receiver_email is your Primary PayPal email
						if ($receiver_email != $paypal_email_login) {
							$error = "Time: ".date("H:i:s - d/m/Y",time());
							$error .= "\n Receiver email: $receiver_email\n";
							$error .= "\n Paypal email login: $paypal_email_login\n";
							$error .= "\n => They must be the same.\n";
							set_file_content("$ecard_root/admin/temp/error.txt",$error);
							exit; 
						}
							//	set_file_content("$ecard_root/admin/temp/pp11.txt",$payment_amount);
					
						// check that PayPal's payment_amount & $your_payment_amount are correct
						if (!isset($ec_id) || $ec_id=="" ){
							$your_payment_amount=get_dbvalue("max_member_group","mg_payment_amount","mg_id='$pay_mg_id'");
								//set_file_content("$ecard_root/admin/temp/pp12.a.txt",$payment_amount);
						}
						else{
							$ppc_id=get_dbvalue("max_ecard","ec_ppc_id","ec_id='$ec_id'");
							$your_payment_amount=get_dbvalue("max_paypercard","ppc_amount","ppc_id='$ppc_id'");
							//	set_file_content("$ecard_root/admin/temp/pp12.b.txt",$payment_amount);
						}
						if ($your_payment_amount=="") { 
							//set_file_content("$ecard_root/admin/temp/pp13.txt",$payment_amount);
							exit;
						}

						// process payment
						//set_file_content("$ecard_root/admin/temp/pp14.txt",$payment_amount);
						$gmt_timestamp_now=timestamp_gmt_output($cf_timezone);
						$field_name ="(pay_user_name_id,pay_what,pay_ecqid,pay_ec_id,pay_via,pay_order_number,pay_amount,pay_date,pay_status,pay_name,pay_email,pay_mg_id)";
						$field_value ="('$user_name_id',$pay_what,'$ecqid',$ec_id,'PayPal','$txn_id',$payment_amount,$gmt_timestamp_now,1,'$first_name $last_name','$payer_email',$pay_mg_id)";
						//set_file_content("$ecard_root/admin/temp/pp15.txt",$field_value);
						
						insert_data_to_db("max_payment",$field_name,$field_value);

						if($pay_what==1){//Upgrade acct
							$mg_dateclose=get_dbvalue("max_member_group","mg_dateclose", "mg_id='$pay_mg_id'");
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

							}
						}
						else{//Pay per card
							$current_balance=get_dbvalue("max_ecuser","user_balance","user_name_id='$user_name_id'");
							update_field_in_db("max_ecuser","user_balance",$payment_amount+$current_balance,"user_name_id='$user_name_id' LIMIT 1");
							
						}
					}
					else {
						$error = "Time: ".date("H:i:s - d/m/Y",time());
						$error .= "\n Payment status: $payment_status\n";
						set_file_content("$ecard_root/admin/temp/error.txt",$error);
						exit; 
						// check the payment_status is Completed
						if ($payment_status != "Completed") {
							$error = "Time: ".date("H:i:s - d/m/Y",time());
							$error .= "\n Payment status: $payment_status\n";
							set_file_content("$ecard_root/admin/temp/error.txt",$error);
							exit; 
						}

						// check that txn_id has not been previously processed
						$chk_proc =get_dbvalue("max_payment","pay_id","pay_order_number='$txn_id'");
						if ($chk_proc != ""){ 
							$error = "Time: ".date("H:i:s - d/m/Y",time());
							$error .= "\n chk_proc: $chk_proc\n";
							set_file_content("$ecard_root/admin/temp/error.txt",$error);
							exit; 
						}

						// check that receiver_email is your Primary PayPal email
						if ($receiver_email != $paypal_email_login) {
							$error = "Time: ".date("H:i:s - d/m/Y",time());
							$error .= "\n Receiver email: $receiver_email\n";
							$error .= "\n Paypal email login: $paypal_email_login\n";
							$error .= "\n => They must be the same.\n";
							set_file_content("$ecard_root/admin/temp/error.txt",$error);
							exit; 
						}

						// check that PayPal's payment_amount & $your_payment_amount are correct
						if($ec_id==""){
							$your_payment_amount=get_dbvalue("max_member_group","mg_payment_amount","mg_id='$pay_mg_id'");
							
						}
						else{
							$ppc_id=get_dbvalue("max_ecard","ec_ppc_id","ec_id='$ec_id'");
							$your_payment_amount=get_dbvalue("max_paypercard","ppc_amount","ppc_id='$ppc_id'");
							
						}
						if ($your_payment_amount=="") { 
							exit;
						}

						// process payment
						$gmt_timestamp_now=timestamp_gmt_output($cf_timezone);
						$field_name ="(pay_user_name_id,pay_what,pay_ecqid,pay_ec_id,pay_via,pay_order_number,pay_amount,pay_date,pay_status,pay_name,pay_email,pay_mg_id)";
						$field_value ="('$user_name_id',$pay_what,'$ecqid',$ec_id,'PayPal','$txn_id',$payment_amount,$gmt_timestamp_now,1,'$first_name $last_name','$payer_email',$pay_mg_id)";
						set_file_content("$ecard_root/admin/temp/sql.txt","insert into max_payment $field_name values $field_value");
						
						insert_data_to_db("max_payment",$field_name,$field_value);
						
						if($pay_what==1){//Upgrade acct
							$mg_dateclose=get_dbvalue("max_member_group","mg_dateclose","mg_payment_amount='$payment_amount' and mg_id='$pay_mg_id'");
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
							}
						}
						else{//Pay per card
						
						
							$current_balance=get_dbvalue("max_ecuser","user_balance","user_name_id='$user_name_id'");
							update_field_in_db("max_ecuser","user_balance",$payment_amount+$current_balance,"user_name_id='$user_name_id' LIMIT 1");

						}
					}
	
	
?>