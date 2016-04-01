<?php
$version ="10.5";
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
	
	//---------------------------------------------------------------------------------------------------------
	function price_format($price) {
		global $cf_currecy;
		if($price=="0.00")
		return "";
		//$decimal = 2;
		$price_format = 1;
		if ($cf_currecy=="đ") {
			$price_format = 2;
		}
		
		//$price = round($price,$decimal);
		
		// If $10
		if ($price_format == "1") {
			$price = $cf_currecy . $price;
		}
		elseif ($price_format == "2") { // If 10$
			$price = $price . $cf_currecy;
		}
		elseif ($price_format == "3") { // If USD 10
		
		}
		else { // If 10 USD
		
		}
		
		return $price;
	}
	
	//---------------------------------------------------------------------------------------------------------	
	function timestamp_gmt_output($time_zone){
		global $cf_dst,$_SESSION;
		if($_SESSION[user_dst]==""){
			$cf_dst_tmp=$cf_dst;
		}
		else{
			$cf_dst_tmp=$_SESSION[user_dst];
		}
		if($time_zone < 0){
			$sign = "-"; 
		}
		else{
			$sign = "+"; 
		}

		$h =str_replace("-","",$time_zone);
		$h =str_replace("+","",$h);

		// DETECT AND ADJUST FOR DAYLIGHT SAVINGS TIME
		if ($cf_dst_tmp=="1") {
		   $daylight_saving = date('I');
		   if ($daylight_saving){
				if ($sign == "-"){ 
					$h=$h-1;  
				}
				else { 
					$h=$h+1; 
				}
		   }
		}

		// FIND DIFFERENCE FROM GMT
		$hm = $h * 60;
		$ms = $hm * 60;		

		// SET CURRENT TIME
		if ($sign == "-"){ 
			$timestamp_output = time() -($ms);
		}
		else { 
			$timestamp_output = time() +($ms);
		}
//		print gmdate("m.d.Y. g:i A", $time_input);
		return $timestamp_output;
	}
	
	//---------------------------------------------------------------------------------------------------------
    function getGMTtimestamp() {
		global $cf_default_timezone;
		date_default_timezone_set($cf_default_timezone);
        return mktime(gmdate("H"),gmdate("i"),gmdate("s"),gmdate("n"),gmdate("j"),gmdate("Y"));
    }
    
    //---------------------------------------------------------------------------------------------------------
    function getServerTimeZone($gmttimestamp) {
        $delta_timestamp = time() - $gmttimestamp;
        $timezone = $delta_timestamp / 3600;
        return $timezone;
    }
    
    //---------------------------------------------------------------------------------------------------------
    // from current timestamp of server to user timestamp
    function adjust_timestamp($user_timezone) {
        global $server_timezone;
        
        if ($server_timezone=="") {
            $server_timezone = getServerTimeZone(getGMTtimestamp());
        }
        $server_timestamp = time();
        
        $saveTimeZone = date_default_timezone_get();
		$timezone = tzOffsetToName($user_timezone);
		date_default_timezone_set($timezone);
		$localtime = localtime($server_timestamp, true);
		date_default_timezone_set($saveTimeZone);
		
		if ($localtime['tm_isdst'] == 1) {
			$user_timezone += 1;
		}
        return $server_timestamp + ($user_timezone - $server_timezone) * 3600;
    }
    
    //---------------------------------------------------------------------------------------------------------
    // get timezone name from timezone offset
    function tzOffsetToName($offset, $isDst = null) {
		if ($isDst === null) {
			$isDst = date('I');
		}
	
		$offset *= 3600;
		$zone    = timezone_name_from_abbr('', $offset, $isDst);
	
		if ($zone === false) {
			foreach (timezone_abbreviations_list() as $abbr) {
				foreach ($abbr as $city) {
					if ((bool)$city['dst'] === (bool)$isDst && strlen($city['timezone_id']) > 0    && $city['offset'] == $offset) {
						$zone = $city['timezone_id'];
						break;
					}
				}
	
				if ($zone !== false) {
					break;
				}
			}
		}
	
		return $zone;
	}
    
    //---------------------------------------------------------------------------------------------------------
    // from a timestamp of server to user timestamp
    function adjust_timestamp_user($server_timestamp,$user_timezone) {
        global $server_timezone;
        
        if ($server_timezone=="") {
            $server_timezone = getServerTimeZone(getGMTtimestamp());
        }
        
	    $saveTimeZone = date_default_timezone_get();
		$timezone = tzOffsetToName($user_timezone);
		date_default_timezone_set($timezone);
		$localtime = localtime($server_timestamp, true);
		date_default_timezone_set($saveTimeZone);
		
		if ($localtime['tm_isdst'] == 1) {
			$user_timezone += 1;
		}
        return $server_timestamp + ($user_timezone - $server_timezone) * 3600;
    }
    
    //---------------------------------------------------------------------------------------------------------
    // from a user timestamp to server timestamp
    function adjust_timestamp_server($user_timestamp,$user_timezone) {
        global $server_timezone;
        
        if ($server_timezone=="") {
            $server_timezone = getServerTimeZone(getGMTtimestamp());
        }
        
        return $user_timestamp + ($server_timezone - $user_timezone) * 3600;
    }
    
    //---------------------------------------------------------------------------------------------------------
	// This function is to adjust timestamp belong to user timezone to timestamp belong to $cf_timezone. Because this website now has a bug regarding timezone, that is timezone saved to database is timezone of user registered. Take a look at index.php file where the line called "Calculate time". When this bug is solved, please do not use this function.
	function adjust_timestamp_1($timestamp,$time_zone) {
		global $cf_dst;
		
		if($time_zone < 0){
			$sign = "-"; 
		}
		else{
			$sign = "+"; 
		}

		$h =str_replace("-","",$time_zone);
		$h =str_replace("+","",$h);

		// DETECT AND ADJUST FOR DAYLIGHT SAVINGS TIME
		if ($cf_dst=="1") {
		   $daylight_saving = date('I');
		   if ($daylight_saving){
				if ($sign == "-"){ 
					$h=$h-1;  
				}
				else { 
					$h=$h+1; 
				}
		   }
		}

		// FIND DIFFERENCE FROM GMT
		$hm = $h * 60;
		$ms = $hm * 60;		

		// SET CURRENT TIME
		if ($sign == "-"){ 
			$timestamp_output = $timestamp -($ms);
		}
		else { 
			$timestamp_output = $timestamp +($ms);
		}
//		print gmdate("m.d.Y. g:i A", $time_input);
		return $timestamp_output;
	}
	//---------------------------------------------------------------------------------------
	function send_email($from_name,$from_email,$to,$email_subject,$email_msg,$format,$replyto=""){
		global $cf_sendmail_using_SMTP,$cf_email_plain_text;
		
		if ($format=="") {
			$format=$cf_email_plain_text;
		}
		//set email content type as html
		$format=1;
		if ($cf_sendmail_using_SMTP=="0") {
			Send_Mail_Att($from_name,$from_email,$to,$email_subject,$email_msg,$format,$replyto);
		}
		else {
			Send_Mail_SMTP($from_name,$from_email,$to,$email_subject,$email_msg,$format,$replyto);
		}
	}	

	//---------------------------------------------------------------------------------------
	function send_sms($from_name,$from_email,$to,$email_subject,$email_msg,$format,$replyto=""){
		global $cf_sendmail_using_SMTP,$cf_email_plain_text;
		
		if ($format=="") {
			$format=$cf_email_plain_text;
		}
		//set email content type as html
		$format=0;
		if ($cf_sendmail_using_SMTP=="0") {
			Send_Mail_Att($from_name,$from_email,$to,$email_subject,$email_msg,$format,$replyto);
		}
		else {
			Send_Mail_SMTP($from_name,$from_email,$to,$email_subject,$email_msg,$format,$replyto);
		}
	}	
	
	//---------------------------------------------------------------------------------------------------------	
	function Send_Mail_Att($From_name,$From,$To,$Subject,$Email_Mess,$Format="",$replyto=""){
		global $sending_email_footer,$charset, $cf_webmaster_email;

		$From_name=stripslashes($From_name);
		$From_name=str_replace("&quot;","''",$From_name);
		
		$headers  = "MIME-Version: 1.0\r\n";
		if($Format =="1"){
			$headers .= "Content-type: text/html; charset=$charset\r\n";
		}
		else{
			$Email_Mess = strip_tags($Email_Mess);
			$headers .= "Content-type: text/plain; charset=$charset\r\n";
		}

		$headers .= "X-Priority: 3\r\n";
		$headers .= "X-MSMail-Priority: Normal\r\n";
		$headers .= "X-Mailer: php\r\n";
		$headers .= "From: \"".$From_name."\" <".$From.">\r\n";
		
		if($replyto ==""){
			$replyto=$cf_webmaster_email;	
		}
		
		$headers .= "Reply-To: \"".$replyto."\" <".$replyto.">\r\n";
		$headers .= "Return-Path: \"".$replyto."\" <".$replyto.">\r\n";
		$Subject=stripslashes($Subject);
		$Subject=str_replace("&quot;","\"",$Subject);
		$Email_Mess=stripslashes($Email_Mess);
		$Email_Mess=str_replace("&quot;","\"",$Email_Mess);
		$Email_Mess=str_replace("%show_email_footer%",$sending_email_footer,$Email_Mess);
		
		mail($To,$Subject,$Email_Mess,$headers,'-f'.$replyto.'');

	}

	//---------------------------------------------------------------------------------------	
	function Send_Mail_SMTP($from_name,$from_email,$to,$email_subject,$email_msg,$format,$replyto="") {
		set_include_path('/');
		global $cf_SMTP_Host,$cf_SMTP_Port,$cf_SMTP_Authentication,$cf_SMTP_Username,$cf_SMTP_Password,$sending_email_footer,$charset;
						
		if ($from_name != "") {
			$headers["From"] = "\"$from_name\" <$from_email>";
		}
		else {
			$headers["From"] = $from_email;
		}
		
		$headers["To"] = $to;
		$headers["Subject"] = $email_subject;
		
		if ($format == "1") {
			$headers["Content-type"] = "text/html; charset=$charset\n";
		}
		else {
			$email_msg = strip_tags($email_msg);
			$headers["Content-type"] = "text/plain; charset=$charset\n";
		}
		
		/* SMTP server name, port, user/passwd */
		$smtpinfo["host"] = $cf_SMTP_Host;
		$smtpinfo["port"] = $cf_SMTP_Port;
		$smtpinfo["auth"] = ($cf_SMTP_Authentication == "1") ? (true) : (false);
		if ($smtpinfo["auth"]) {
			$smtpinfo["username"] = $cf_SMTP_Username;
			$smtpinfo["password"] = $cf_SMTP_Password;
			$headers["From"] = $from_name ? "\"$from_name\" <$cf_SMTP_Username>" : $cf_SMTP_Username;
		}			
		/* Create the mail object using the Mail::factory method */
		$mail_object =& Mail::factory("smtp", $smtpinfo);
		/* Ok send mail */
		$mail = $mail_object->send($to, $headers, $email_msg);
		if (PEAR::isError($mail)) {
			echo("<script type='text/javascript' language='javascript'>alert('SMTP error: ".$mail->getMessage()."');</script>");
		}
	}

	//---------------------------------------------------------------------------------------
	//Connect & Disconnect to the database
	$connect = false;
	function make_db_connect(){
		global $dbserver,$db_user,$db_password,$database_name,$connect;

		if($connect){
			//print "Return | ";
			return $connect;
		}
		else{
			//print "Do Connect | ";
	        $connect = mysql_connect ($dbserver,$db_user,$db_password) or die("MySQL problem. Connect failed to server: $dbserver");
		    mysql_select_db($database_name, $connect) or die("MySQL problem. Failed to select $database_name");
			return $connect;
		}	
	}

	//---------------------------------------------------------------------------------------
	function set_global_var_config($table_name) {		
		$array=set_array_from_query($table_name,"*");
		foreach ($array as $val){
			if ($val !=""){
				set_global_var($val[config_name],$val[config_value]);
			}
		}
	}

	//---------------------------------------------------------------------------------------
	function set_array_from_query($table_name,$column,$condition="") {
		if($condition !=""){
			$sql="SELECT $column FROM $table_name WHERE $condition";
		}
		else{
			$sql="SELECT $column FROM $table_name";
		}
//if ($table_name=="max_ecard_invite") {echo $sql;}
		$array = array();
		$result = mysql_query($sql,make_db_connect());
		if (!$result) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}

		if (mysql_num_rows($result) > 0){
			$x=0;
			while($row = mysql_fetch_row($result)){
				foreach($row as $i => $value) {
					$column = mysql_field_name($result,$i);
					$data["$column"] = $value;
					$array[$x] = $data;
				}
				$x++;
           }
		}
		return $array;
	}

	//---------------------------------------------------------------------------------------
	function set_array_from_query2($table_name,$column,$condition="") {
		if($condition !=""){
			$sql="SELECT $column FROM $table_name WHERE $condition";
		}
		else{
			$sql="SELECT $column FROM $table_name";
		}

		$array = array();
		$result = mysql_query($sql,make_db_connect());
		if (!$result) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}

		if (mysql_num_rows($result) > 0){
			$x=0;
			while($row = mysql_fetch_row($result)){
				foreach($row as $i => $value) {
					$column = mysql_field_name($result,$i);
					$data["$column"] = $value;
					$array[$column] = $data;
				}
				$x++;
           }
		}
		return $array;
	}

	//---------------------------------------------------------------------------------------------------------
	//Get a list of value
	function get_dblistvalue($table_name,$column,$condition=""){		
		$arr = set_array_from_query($table_name,$column,$condition);
		$array=array();
		$x=0;
		foreach($arr as $val){
			if($val !=""){
				foreach($val as $key => $value) {
					$array[$x++] ="$value";
				}
			}
		}
		return $array;
	}

	//---------------------------------------------------------------------------------------------------------
	//Get a list of value
	function get_dblistvalue2($arr,$whatkey){
		$array=array();
		$x=0;
		foreach($arr as $row_array){
			if($row_array !=""){
				foreach($row_array as $key => $value) {
					if($key==$whatkey)$array[$x++] ="$value";
				}
			}
		}
		return $array;
	}

	//---------------------------------------------------------------------------------------------------------
	//Get all colum in a row
	function get_row($table_name,$column,$condition=""){
		$arr = set_array_from_query2($table_name,$column,$condition);
		$array=array();
		foreach($arr as $val){
			if($val !=""){
				foreach($val as $key => $value) {
					$array[$key] ="$value";
				}
			}
		}
		return $array;
	}
	
	//---------------------------------------------------------------------------------------------------------	
	//Random value in db
	function get_dbrandvalue($table_name,$column,$condition=""){
		$list_value = get_dblistvalue($table_name,$column,$condition);
		shuffle($list_value);
		$data = $list_value[0];
		return $data;
	}

	//---------------------------------------------------------------------------------------------------------	
	//Get 1 field value
	function get_dbvalue($table_name,$column,$condition=""){
		$arr = set_array_from_query($table_name,$column,$condition); 
		$data=$arr[0][$column];
		return $data;
	}

	//---------------------------------------------------------------------------------------------------------
	//Insert to database
	function insert_data_to_db($table_name,$field_name,$field_value){
		$mysql_version = substr(mysql_version(), 0, 1);
		if ($mysql_version == "5") {
			//$field_value=str_replace("''","",$field_value);
			make_insert_statement_compatible_with_mysql5x($table_name,$field_name,$field_value);
		}
		else {
			$field_value=str_replace("?","",$field_value);
		}
		
		$sql="Insert into $table_name $field_name values $field_value";
//if ($table_name=="max_user_invite") {		print $sql; }
		mysql_query($sql,make_db_connect());
	}
	
	//---------------------------------------------------------------------------------------------------------
	//get mysql server info
	function mysql_version() {
		$version = mysql_get_server_info();
		return substr($version, 0, strpos($version, "-"));
	}
	
	//---------------------------------------------------------------------------------------------------------
	// Make insert statement compatible with mysql5x
	function make_insert_statement_compatible_with_mysql5x($table_name,&$field_name,&$field_value) {
		// strip ( and ) in $field_name & $field_value
		$field_name = rtrim(ltrim($field_name, "("), ")");
		$field_value = rtrim(ltrim($field_value, "("), ")");
		
		$field_name_arr = explode(",", $field_name);
		$field_value_arr = explode(",", $field_value);
		
		$result = mysql_query("SHOW FIELDS FROM $table_name");
		
		foreach ($field_name_arr as $index => $field) {
			if ($field_value_arr[$index] == "") {
				mysql_data_seek($result, 0);
				$field_attribute = get_field_attribute($result, $field);
				// field type is int , smallint , mediumint , tinyint
				if (preg_match("/int/", $field_attribute["Type"])) {
					// assign default value
					$field_value_arr[$index] = ($field_attribute["Default"] == "") ? "0" : $field_attribute["Default"];
				}
				elseif (preg_match("/char/", $field_attribute["Type"])) {
					// assign default value
					$field_value_arr[$index] = "'" . $field_attribute["Default"] . "'";
				}
				else {
					// assign default value
					$field_value_arr[$index] = "'" . $field_attribute["Default"] . "'";
				}
			}
		}
		
		// make field_value
		$i = 1;
		$total = count($field_value_arr);
		$field_value = "";
		foreach ($field_value_arr as $value) {
			$field_value .= $value;
			if ($i < $total) {
				$field_value .= ",";
			}
			$i++;
		}
		$field_value = "(" . $field_value . ")";
		$field_name = "(" . $field_name . ")";
	}
	
	//---------------------------------------------------------------------------------------------------------
	// get field
	function get_field_attribute($result, $field_name) {
		while ($row = mysql_fetch_array($result)) {
			if ($row["Field"] == $field_name) {
				break;
			}
		}
		return $row;
	}

	//---------------------------------------------------------------------------------------------------------
	//Update field value
	function update_field_in_db2($table_name,$what,$condition){		
		$sql="Update ". $table_name. " set ". $what . " Where " . $condition;				
		mysql_query($sql,make_db_connect());
	}

	//---------------------------------------------------------------------------------------------------------
	//Update field value
	function update_field_in_db($table_name,$field_name,$new_value,$condition){		
		if (is_string($new_value) && !is_int($new_value))
			$new_value="'".$new_value."'";
		$sql="Update ". $table_name. " set ". $field_name . "=" . $new_value. " Where " . $condition;				
		mysql_query($sql,make_db_connect());
	}
	
	//---------------------------------------------------------------------------------------------------------
	//Delete value
	function delete_row($table_name,$condition){				
		$sql="Delete from  $table_name   Where  $condition";		
		$dbh = make_db_connect();		
		mysql_query($sql,make_db_connect());
	}

	//---------------------------------------------------------------------------------------------------------
	//Truncate file name 
	function truncate_dir($dir){
		while ((strlen($dir)>0) && ((substr($dir,0,1)==".") || (substr($dir,0,1)=="/"))){
			$dir =substr($dir,1);
		}
		return $dir;
	}
	
	//---------------------------------------------------------------------------------------------------------
	//Write content to file
	function set_file_content($file_name,$content,$flag=""){
		$res =TRUE;
		if($flag=="")$flag="w+";
		if (($file_name =="") || ($content=="")){
			$res =FALSE;
		}
		else{
			$fh = @fopen($file_name,$flag);
			if ($fh){
				flock( $fh, LOCK_EX);
				fwrite($fh,$content);
				flock( $fh, LOCK_UN);
			}
			else{
				$res = FALSE;
			}
		}
		return $res;
	}
	
	//---------------------------------------------------------------------------------------------------------
	//Get file content
	/*function get_file_content($file_name){
		global $error,$File_does_not_exist;
		$data="";		
		if (file_exists($file_name) && is_file($file_name)){
			$fh = fopen ($file_name, "r");
			if ($fh!=FALSE){
				while (!feof ($fh)) {
					$data .= fgets($fh, 4096);
				}
				fclose ($fh);
			}
		}
		else{
			print "Error - File not found $file_name";
		}
		return $data;
	}*/
	
	//---------------------------------------------------------------------------------------------------------
	//Get file content
	function get_file_content($file_name){
		global $error,$File_does_not_exist;
		$data="";		
		if (file_exists($file_name) && is_file($file_name)){
			$data=file_get_contents($file_name);
		}
		else{
			print "Error - File not found $file_name";
		}
		return $data;
	}
	
	//---------------------------------------------------------------------------------------------------------
	//Random value in file list or dir list
	function get_randfile($dir,$is_getdir=FALSE,$pattern=""){
		if ($is_getdir){
			$list_value = get_list_dir($dir,$pattern);
		}
		else{
			$list_value = get_list_file($dir,$pattern);
		}
		shuffle($list_value);
		$data = $list_value[0];
		return $data;		
	}

	//---------------------------------------------------------------------------------------------------------
	//Get list dir
	function get_list_dir($dir,$pattern=""){
		$array = array();
		if (is_dir("$dir")) {
			if ($fh = opendir("$dir")) {
				while (($file = readdir($fh)) !== false){ 
					if (is_dir("$dir/$file")){
						if ($pattern !=""){
							if ($file != "." && $file != ".." && preg_match ("/$pattern/i", "$file")) { 
								$array[]=$file;
							} 
						}
						else{
							if ($file != "." && $file != ".."){ 
								$array[]=$file;
							} 						
						}
					}
				}
				closedir($fh); 
			}
		}
		sort($array);
		return $array;
	}
	
	//---------------------------------------------------------------------------------------------------------
	//Get list file 
	function get_list_file($path,$pattern="",$cond=""){
		$res =array();				
		$get_file="";		
		if (is_dir("$path")) {
			if ($fh = opendir("$path")){
				if ($pattern !=""){
					while (($file = readdir($fh)) !== false){ 					
						if (is_file("$path/$file")){
							if($cond!=""){
								if ($file != "." && $file != ".." && $file != ".htaccess" && $file != "passwd" && !preg_match ("/$pattern/i", "$file")){ 
									$res[]=$file;
								} 
							}
							else{
								if ($file != "." && $file != ".." && $file != ".htaccess" && $file != "passwd" && preg_match ("/$pattern/i", "$file")){ 
									$res[]=$file;
								} 
							}
						}
					}
				}
				else{
					while (($file = readdir($fh)) !== false){ 					
						if (is_file("$path/$file")){					
							if ($file != "." && $file != ".." && $file != ".htaccess" && $file != "passwd"){ 
								$res[]=$file;
							} 
						}
					}						
				}
				closedir($fh); 
			}
		}			
		sort($res);
		return $res;
	}

	//---------------------------------------------------------------------------------------------------------	
	//Get template from file
	function get_template_from_layout($layout_name,$isfile=TRUE) {
		global $ecard_url,$ecard_root,$cf_easy_edit_template;
		if ($isfile){
			$layout_dir = "$ecard_root";
			$layout_content = get_file_content("$layout_dir/$layout_name");
		}
		else{
			$layout_content =$layout_name;
		}
		
		return $layout_content;
	}

	//---------------------------------------------------------------------------------------------------------	
	//Build html from layout
	function get_html_from_layout($layout_name,&$the_template="",$isfile=TRUE,$list_value=""){
		global $ecard_url,$ecard_root,$cf_easy_edit_template;
		if($ecard_root=="")$ecard_root=get_global_var(ecard_root);
		//global $cc;
		if ($the_template=="") {//echo $cc++;
			$the_template=get_template_from_layout($layout_name,$isfile);
		}
		
		$layout_content=$the_template;

		$replace_symbols =array();
		if ($layout_content !=""){
			$replace_symbols = get_replace_symbols($layout_content);
		}		
		$i=0;
		if (count($replace_symbols)>0){
			if (is_array($list_value) && (count($list_value) > 0)){
				foreach ($replace_symbols as $symbol){
					// $tmp = "{''$symbol''}"; # use this line code to fix the bug when building html from layout
					$tmp = "{'$symbol'}";			
					if (isset($list_value[$symbol])){			
						$layout_content = str_replace($tmp,$list_value[$symbol],$layout_content);
					}
					else{
						$layout_content = str_replace($tmp,"",$layout_content);
					}				
				}
			}
			else {
				foreach ($replace_symbols as $symbol){
					// $tmp = "{''$symbol''}"; # use this line code to fix the bug when building html from layout
					$tmp = "{'$symbol'}";			
					$layout_content = str_replace($tmp,get_global_var($symbol),$layout_content);
				}
			}
		}
		
		$layout_content =str_replace("%print_language_box%","",$layout_content);		

		if ($cf_easy_edit_template== 1 && !(strpos($layout_name,"templates/")===false)){
			$div_id = rand();
			return "<img style=\"cursor: pointer\" onmouseover=\"document.getElementById('$div_id').style.border='2px solid red';\" onmouseout=\"document.getElementById('$div_id').style.border='';\" onclick=\"alert('Edit file: $layout_name\\n\\nThis info will tell you which html file name you need to edit while you design your own template.\\n\\nYou need to turn this off when you go live your site\\n\\nTo turn this feature off, login to Admin and select Easy Edit Template Feature = No')\" border=\"0\" src=\"$ecard_url/templates/page_info.gif\" title=\"Edit file: $layout_name\" alt=\"Edit file: $layout_name\"><!-- BEGIN $layout_name --><div id=\"$div_id\">" . $layout_content."</div><!-- END $layout_name -->";
		}
		else{
			return $layout_content;
		}
	}
	
	//---------------------------------------------------------------------------------------------------------	
	//Get html replace names to build html content
	function get_replace_symbols($layout_content){		
		//preg_match_all ("/({([\w]+)})/", $layout_content, $matches);
		// preg_match_all ("/{''([\w]+)''}/", $layout_content, $matches); # use this line to fix the bug when building html from layout
		preg_match_all ("/{'([\w]+)'}/", $layout_content, $matches);		
		$res=array();
		if (count($matches[0]) > 0)
			$res= $matches[0];
		$c= count($res);
		for ($i=0;$i<$c;$i++){
			/* $res[$i] = str_replace("{''","",$res[$i]); # use this block of code to fix the bug when building html from layout
			$res[$i] = str_replace("''}","",$res[$i]); */
			$res[$i] = str_replace("{'","",$res[$i]);
			$res[$i] = str_replace("'}","",$res[$i]);
		}		
		return $res;
	}
	
	//---------------------------------------------------------------------------------------------------------
	//Check valid email
	function valid_email($email){
		$email = strtolower($email);
		$email2 = split("@", $email);
		$part1 = $email2[0];
		$part1 = str_replace ("_","",$part1);
		$part2 = $email2[1];
		$email = "$part1@$part2";
		if (ereg("^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,4}$",$email)) {
			return TRUE;
		} 
		return FALSE;
	} 	

	//---------------------------------------------------------------------------------------------------------	
	function DateFormat($Stamp,$notime="") {
		global $cf_show_date_option,$Jan,$Feb,$Mar,$Apr,$May,$Jun,$Jul,$Aug,$Sep,$Oct,$Nov,$Dec;
	
		if($notime ==""){
			$print_time = " - ". date('g:i:s A', $Stamp);
		}
		elseif($notime =="2"){
			$print_time = "<br />". date('g:i:s A', $Stamp);
		}
		else{
			$print_time = "";
		}
		
		if($cf_show_date_option =="0"){ //MM DD YYYY
			return date("M d Y", $Stamp) . $print_time ;
		}
		elseif($cf_show_date_option =="1"){ //DD MM YYYY
			return date("d M Y", $Stamp) . $print_time ;
		}
		elseif($cf_show_date_option =="2"){ //YYYY DD MM
			return date("Y d M", $Stamp) . $print_time ;
		}
		elseif($cf_show_date_option =="3"){ //YYYY MM DD
			return date("Y M d", $Stamp) . $print_time ;
		}
	}

	//------------------------------------------------------------------
	function resize_myimage($type,$src,$new_file,$what){
		global $cf_album_max_stamp_width,$cf_album_max_stamp_height,$cf_thumb_width_member_card,$cf_thumb_height_member_card,$cf_max_image_width;
		
		$img_size = @getimagesize ("$src"); 
		$WIDTH = $img_size[0];
		$HEIGHT = $img_size[1];

		if($what =="full"){
			if ($WIDTH > $cf_max_image_width){
				$gwidth = $WIDTH;
				$gheight = $HEIGHT;
				$a = $gwidth - $cf_max_image_width;
				$b = $gwidth / $a ;
				$c = $gheight / $b;
				$newwidth = $cf_max_image_width;
				$newheight = intval($gheight - $c);
			}
			else{
				$newwidth = $WIDTH;
				$newheight = $HEIGHT;
			}
		}
		elseif($what =="stamp"){
			if ($WIDTH > $cf_album_max_stamp_width){
				$gwidth = $WIDTH;
				$gheight = $HEIGHT;
				$a = $gwidth - $cf_album_max_stamp_width;
				$b = $gwidth / $a ;
				$c = $gheight / $b;
				$newwidth = $cf_album_max_stamp_width;
				$newheight = intval($gheight - $c);
			}
			else{
				$newwidth = $WIDTH;
				$newheight = $HEIGHT;
			}
		}
		else{
			if ($WIDTH > $cf_thumb_width_member_card){
				$gwidth = $WIDTH;
				$gheight = $HEIGHT;
				$a = $gwidth - $cf_thumb_width_member_card;
				$b = $gwidth / $a ;
				$c = $gheight / $b;
				$newwidth = $cf_thumb_width_member_card;
				$newheight = intval($gheight - $c);
			}
			else{
				$newwidth = $WIDTH;
				$newheight = $HEIGHT;
			}			
		}		

		// Load
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		
		// Output
		if($type =="image/jpeg"){
			$source = imagecreatefromjpeg($src);	
			imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $WIDTH, $HEIGHT);
			imagejpeg($thumb,$new_file,100);
		}
		elseif($type =="image/gif"){
			$source = imagecreatefromgif($src);	
			imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $WIDTH, $HEIGHT);
			imagegif($thumb,$new_file,100);
		}
		elseif($type =="image/png"){
			$source = imagecreatefrompng($src);	
			imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $WIDTH, $HEIGHT);
			imagepng($thumb,$new_file,100);
		}

		chmod($new_file,0777);
	}

	//------------------------------------------------------------------
	function watermark_myimage($type,$src){
		/*
		$bg = imagecreatefromjpeg($src);
		$over = imagecreatefrompng('D:/watermark_logo.png');
		imagealphablending($bg, true);
		imagesavealpha($bg, true);
		imagecopy($bg, $over, 276, 300, 0, 0, 123, 119);
		Header("Content-type: image/png");
		imagepng($bg);
		die;
		*/
		global $cf_watermark_opacity,$cf_watermark_pos,$cf_watermark_pos2,$ecard_root,$what;
		
		if($type =="image/jpeg"){
			$fullsize = imageCreateFromJpeg("$src");
		}
		elseif($type =="image/gif"){
			$fullsize = imagecreateFromGif("$src");
		}
		elseif($type =="image/png"){
			$fullsize = imagecreateFromPng("$src");
		}		

		$logo = imagecreatefrompng("$ecard_root/templates/watermark_logo.png");
		//$bgcolor=imagecolorexact($logo, 255, 255, 255);
		//imagecolortransparent($logo,$bgcolor);
		imagealphablending($logo, true);
		imagesavealpha($logo, true);
		$logoWidth = imagesx($logo);
		$logoHeight = imagesy($logo);
		$fulsizeWidth = imagesx($fullsize);
		$fulsizeHeight = imagesy($fullsize);

		if($cf_watermark_pos == "1"){
			//Top Left
			$logoX= 0;
			$logoY= 0;
		}
		elseif($cf_watermark_pos == "2"){
			//Top Center
			$logoX = ($fulsizeWidth - $logoWidth) / 2;
			$logoY= 0;
		}
		elseif($cf_watermark_pos == "3"){
			//Top Right
			$logoX = $fulsizeWidth - $logoWidth;
			$logoY= 0;
		}
		elseif($cf_watermark_pos == "4"){
			//Middle Left
			$logoX = 0;
			$logoY= ($fulsizeHeight - $logoHeight) / 2;
		}
		elseif($cf_watermark_pos == "5"){
			//Middle Center
			$logoX = ($fulsizeWidth - $logoWidth) / 2;
			$logoY= ($fulsizeHeight - $logoHeight) / 2;
		}
		elseif($cf_watermark_pos == "6"){
			//Middle Right
			$logoX = $fulsizeWidth - $logoWidth;
			$logoY= ($fulsizeHeight - $logoHeight) / 2;
		}
		elseif($cf_watermark_pos == "7"){
			//Bottom Left
			$logoX = 0;
			$logoY= $fulsizeHeight - $logoHeight;
		}
		elseif($cf_watermark_pos == "8"){
			//Bottom Center
			$logoX = ($fulsizeWidth - $logoWidth) / 2;
			$logoY= $fulsizeHeight - $logoHeight;
		}
		elseif($cf_watermark_pos == "9"){
			//Bottom Right
			$logoX = $fulsizeWidth - $logoWidth;
			$logoY= $fulsizeHeight - $logoHeight;
		}
		
		if($cf_watermark_pos != "10"){
			//imagecopymerge($fullsize, $logo, $logoX,$logoY,0,0,$logoWidth,$logoHeight,$cf_watermark_opacity);
			imagecopy($fullsize, $logo, $logoX,$logoY,0,0,$logoWidth,$logoHeight);
		}
		elseif($cf_watermark_pos == "10"){
			//Tile over image
			$numXtile = ceil($fulsizeWidth / $logoWidth );
			$numYtile = ceil($fulsizeHeight / $logoHeight );
			$startX =($fulsizeWidth -($numXtile * $logoWidth)) / 2;
			$startY =($fulsizeHeight -($numYtile * $logoHeight)) / 2;

			for($cols=0;$cols<$numXtile;$cols++){
				for($rows=0;$rows<$numYtile;$rows++){
					//imagecopymerge($fullsize, $logo, $startX + ($logoWidth * $cols),$startY + ($logoHeight *  $rows),0,0,$logoWidth,$logoHeight,$cf_watermark_opacity);
					imagecopy($fullsize, $logo, $startX + ($logoWidth * $cols),$startY + ($logoHeight *  $rows),0,0,$logoWidth,$logoHeight);
				}
			}
		}
		
		
		// Output
		if($type =="image/jpeg"){
			Header("Content-type: image/jpeg");
			imagejpeg($fullsize, null, 100);
		}
		elseif($type =="image/gif"){
			Header("Content-type: image/gif");
			imagegif($fullsize);
		}
		elseif($type =="image/png"){
			Header("Content-type: image/png");
			imagepng($fullsize);
		}

	}	
	
function buildOptions($data,$key="",$value="",$default=""){
    $html="";
    foreach($data as $item){
    //    print_r($item);
        if($key=="" && $value==""){
            $kv=$item;
            $vl=$item;
        }else{
            $kv=$item[$key];
            $vl=$item[$value];
        }
        if($kv==$default){
            $html.="<option value=\"$kv\" selected>$vl</option>";
        }else{
            $html.="<option value=\"$kv\">$vl</option>";
        }
    }
    return $html;
}

function resizeCalculatingImage($org_width, $org_height, $new_width = NULL, $new_height= NULL){
	if($org_width === null)
	return array(NULL, NULL);
	if($new_height > $org_height) $new_height = $org_height;	
	$new_width = $new_height*$org_width/$org_height;
	
	if($new_width > $org_width) $new_width = $org_width;	
	$new_height = $new_width*$org_height/$org_width;
	
	$fullsize_height = round($new_height);
	$fullsize_width = round($new_width);
	
	return array($fullsize_width, $fullsize_height);
}
function Connection_facebook(){
	
	global $ecard_url,$login_fb,$facebook,$facebook_appid,$db,$gmt_timestamp_now,$_SESSION,$txt_welcome_back_user,$array_global_var,$cf_enable_fb_login;
// Connection...
	$user = $facebook->getUser();
	if($user)
	 { 
		$fb_data=get_row("max_ecuser","*","facebook_id ='$user'");
		
	   if(!empty($fb_data)){
		    if($fb_data['user_name_id']==$fb_data['facebook_id'])
			          		$_SESSION['ecardmax_user']=$fb_data['facebook_id'];
						else
							$_SESSION['ecardmax_user']=$fb_data['user_name_id'];
						foreach($fb_data as $key=>$val){
							$_SESSION[$key]=$val;
						}
						//Set member group
						$mg_row=get_row("max_member_group","*","mg_id='$_SESSION[user_mg_id]'");
						foreach($mg_row as $key=>$val){
							$_SESSION[$key]=$val;
						}					
						//Set language
						$_SESSION[ecardmax_lang]=$fb_data[user_lang];		
						//Say hello user
						$_SESSION[hello_user]="$txt_welcome_back_user $fb_data[user_name] $fb_data[user_last_name]";
						$array_global_var[hello_user]="$_SESSION[hello_user]";
						update_field_in_db2("max_ecuser","user_beclosed='0',user_lastlogin='$gmt_timestamp_now',user_lastlogin2='$fb_data[user_lastlogin]'","user_id='$fb_data[user_id]' LIMIT 1");
						unset($fb_count,$result,$fb_data);					
			   	        header("Location: ".$_SERVER['HTTP_REFERER']);
	   }
	   else{   
	   	 $logoutUrl = $facebook->getLogoutUrl();
			 try {
			 $userdata = $facebook->api('/me');
			 } catch (FacebookApiException $e) {
			error_log($e);
			$user = null;
			 }
			
			
			 $access_token_title='fb_'.$facebook_appid.'_access_token';
			 $access_token=$_SESSION[$access_token_title];
				
				//$_SESSION['facebook']=$_SESSION;
				//$_SESSION['userdata'] = $userdata;
				//$_SESSION['logout'] =  $logoutUrl;
		
			   $fb_data=get_row("max_ecuser","*","facebook_id ='$user'");
			   $email_user=get_row("max_ecuser","user_id","user_email='$userdata[email]'");
			   if(!empty($fb_data)){
			   	//login
						if($fb_data['user_name_id']==$fb_data['facebook_id'])
			          		$_SESSION['ecardmax_user']=$fb_data['facebook_id'];
						else
							$_SESSION['ecardmax_user']=$fb_data['user_name_id'];
						foreach($fb_data as $key=>$val){
							$_SESSION[$key]=$val;
						}
						//Set member group
						$mg_row=get_row("max_member_group","*","mg_id='$_SESSION[user_mg_id]'");
						foreach($mg_row as $key=>$val){
							$_SESSION[$key]=$val;
						}					
						//Set language
						$_SESSION[ecardmax_lang]=$fb_data[user_lang];		
						//Say hello user
						$_SESSION[hello_user]="$txt_welcome_back_user $fb_data[user_name] $fb_data[user_last_name]";
						$array_global_var[hello_user]="$_SESSION[hello_user]";
						update_field_in_db2("max_ecuser","user_beclosed='0',user_lastlogin='$gmt_timestamp_now',user_lastlogin2='$fb_data[user_lastlogin]'","user_id='$fb_data[user_id]' LIMIT 1");
						unset($fb_count,$result,$fb_data);					
			   	        header("Location: ".$_SERVER['HTTP_REFERER']);
			   }
			   else if(!empty($email_user))
			   {
				   update_field_in_db2("max_ecuser","facebook_id='$userdata[id]',network_type='facebook'","user_email='$userdata[email]' LIMIT 1");
				   $fb_data=get_row("max_ecuser","*","user_email='$userdata[email]'");
				   if(!empty($fb_data)){
				   	//login
				            $_SESSION['ecardmax_user']=$fb_data['user_name_id'];
							foreach($fb_data as $key=>$val){
								$_SESSION[$key]=$val;
							}
							//Set member group
							$mg_row=get_row("max_member_group","*","mg_id='$_SESSION[user_mg_id]'");
							foreach($mg_row as $key=>$val){
								$_SESSION[$key]=$val;
							}					
							//Set language
							$_SESSION[ecardmax_lang]=$fb_data[user_lang];	
							$_SESSION[hello_user]="$txt_welcome_back_user $fb_data[user_name] $fb_data[user_last_name]";
							$array_global_var[hello_user]="$_SESSION[hello_user]";
							update_field_in_db2("max_ecuser","user_beclosed='0',user_lastlogin='$gmt_timestamp_now',user_lastlogin2='$fb_data[user_lastlogin]'","user_id='$fb_data[user_id]' LIMIT 1");
							unset($fb_count,$result,$fb_data);
				   	        header("Location: ".$_SERVER['HTTP_REFERER']);
				   }
			   }
			   else{   
			   $field_name="(user_name_id,user_mg_id,user_beclosed,user_dateclose,user_lastlogin,user_lastlogin2,user_name,user_last_name,user_email, user_gender,user_active,facebook_id,network_type,access_token,user_date_signup)" ;
		$field_value= "('$userdata[id]',2,0,0,$gmt_timestamp_now,$gmt_timestamp_now,'$userdata[first_name]','$userdata[last_name]','$userdata[email]','$userdata[gender]',1,'$userdata[id]','facebook','$access_token',$gmt_timestamp_now)";
			   insert_data_to_db("max_ecuser",$field_name,$field_value);
			   $fb_data=get_row("max_ecuser","*","facebook_id ='$userdata[id]'");
				   if(!empty($fb_data)){
				   	//login
				            $_SESSION['ecardmax_user']=$fb_data['facebook_id'];
							foreach($fb_data as $key=>$val){
								$_SESSION[$key]=$val;
							}
							//Set member group
							$mg_row=get_row("max_member_group","*","mg_id='$_SESSION[user_mg_id]'");
							foreach($mg_row as $key=>$val){
								$_SESSION[$key]=$val;
							}					
							//Set language
							$_SESSION[ecardmax_lang]=$fb_data[user_lang];	
							$_SESSION[hello_user]="$txt_welcome_back_user $fb_data[user_name] $fb_data[user_last_name]";
							$array_global_var[hello_user]="$_SESSION[hello_user]";
							update_field_in_db2("max_ecuser","user_beclosed='0',user_lastlogin='$gmt_timestamp_now',user_lastlogin2='$fb_data[user_lastlogin]'","user_id='$fb_data[user_id]' LIMIT 1");
							unset($fb_count,$result,$fb_data);
				   	        header("Location: ".$_SERVER['HTTP_REFERER']);
				   }
			}
	   }
	}
	if($_SESSION['ecardmax_user']=="" && $cf_enable_fb_login==1)
	{
		$icon = '';
		global $isResponsive;
		if($isResponsive) $icon = '<i class="fa fa-facebook-official"></i>';
		$loginUrl = $facebook->getLoginUrl(array( 'scope' => 'email,user_birthday'));
		set_global_var("loginUrl",'<li id="loginfb"><a  target="_blank" href="'.$loginUrl.'">'.$icon.' Login with facebook</a></li>');
	}
}

function curPageURL() {
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}
function print_image($data){
	$arr = split(",",$data);
	$img = $arr[0];
	$w = $arr[1];
	$h = $arr[2];
	$res='<img border="0" alt="'.$img.'" src="'.$img.'" width="'.$w.'" height="'.$h.'" />';
	return $res;
}

?>