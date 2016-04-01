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

	$parser_version = phpversion();
	$http_vars = array();
	if ($parser_version <= "4.1.0") { 
		$GET_VARS      	= $HTTP_GET_VARS ;
		$POST_VARS     	= $HTTP_POST_VARS;
		$SERVER_VARS   	= $HTTP_SERVER_VARS;
		$COOKIES  	 	= $HTTP_COOKIE_VARS;
		$POST_FILES		= $HTTP_POST_FILES;
	}	
	else{ 
		$GET_VARS      	= $_GET;
		$POST_VARS     	= $_POST;
		$SERVER_VARS   	= $_SERVER;
		$COOKIES  		= $_COOKIE;
		$POST_FILES		= $_FILES;
	}
	
	if ($SERVER_VARS['REQUEST_METHOD'] == "POST"){
		foreach ($POST_VARS as $key => $val){		  
			$val=str_replace("\"","&quot;",$val);
			if (!get_magic_quotes_gpc()) { 
				$val = addslashes($val); 
			} 
			if ($key !="user")
		  		$http_vars[$key] = $val;
		}
	}
	elseif($SERVER_VARS['REQUEST_METHOD'] == "GET"){
		foreach ($GET_VARS as $key => $val){
			$val=str_replace("\"","&quot;",$val);
			if (!get_magic_quotes_gpc()) { 
				$val = addslashes($val); 
			} 
			if ($key !="user")	
			  $http_vars[$key] = $val;
		}
	}
		
	foreach($COOKIES as $key => $val){
		$val=str_replace("\"","&quot;",$val);
		if (!get_magic_quotes_gpc()) { 
			$val = addslashes($val); 
		}
		
		if($key!="lang"){
			$http_vars[$key] = $val;
		}
	}

	$http_vars['remote_addr'] = $SERVER_VARS['REMOTE_ADDR'];
	$http_vars['user_agent'] = $SERVER_VARS['HTTP_USER_AGENT'];
	$http_vars['server_name'] = $SERVER_VARS['SERVER_NAME'] ;	
	$http_vars['http_referer'] = $SERVER_VARS['HTTP_REFERER'] ;
	$http_vars['query_string'] = $SERVER_VARS['QUERY_STRING'] ;
	$http_vars['script_filename'] = $SERVER_VARS['SCRIPT_FILENAME'] ;

	foreach($http_vars as $key=>$val){
		if($key!="cs_message")$val=strip_tags($val);
		$$key = $val;
	}

	//---------------------------------------------------------------------------------------------------------	
	//get a variable from list
	function get_global_var($key){
		global $config_vars,$http_vars;
		if (isset($http_vars[$key]) && ($http_vars[$key] !="")){
			$res = $http_vars[$key];
		}
		elseif (isset($config_vars[$key]) && ($config_vars[$key]!="")){
			$res = $config_vars[$key];
		}
		elseif (isset($GLOBALS[$key])){
			$res = $GLOBALS[$key];
		}
		else{
			$res="";
		}
		return $res;
	}	
	
	//---------------------------------------------------------------------------------------------------------	
	//set global var
	function set_global_var($key,$value){
		global $http_vars;
		if ($key !="")
			$http_vars[$key] = $value;
		if (isset($GLOBALS[$key]))
			$GLOBALS[$key] =$value;
				
	}

	//---------------------------------------------------------------------------------------------------------	
	//set global var
	function set_global_var2($array){
		global $http_vars;
		foreach($array as $key=>$value){
			if ($key !="")
				$http_vars[$key] = $value;
			if (isset($GLOBALS[$key]))
				$GLOBALS[$key] =$value;
		}						
	}
	
	//---------------------------------------------------------------------------------------------------------	
	function get_rand_str(){
		return substr(md5(uniqid(rand(),1)), 0, 10);
	}
	
	//---------------------------------------------------------------------------------------------------------	
	function URLopen($url) { 

		$handle = @fopen("$url",'rb'); 
		$result='';
		if ($handle != ""){			
			while (!feof($handle)) {
				$result .= @fread($handle, 8192);
			}
			fclose($handle);
		}
		
		else{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec ($ch);
			curl_close ($ch); 
		}
		
		return $result; 
	} 

?>