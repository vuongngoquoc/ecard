<?php
	/*
+--------------------------------------------------------------------------
|
|	WARNING: REMOVING THIS COPYRIGHT HEADER IS EXPRESSLY FORBIDDEN
|
|   ePHOTOHUNT GAME 2005 Full Version
|   ========================================
|   by Khoi Hong webmaster@cgi2k.com
|   (c) 1999 - 2004 CGI2K.COM - All right reserved 
|   http://www.cgi2k.com 
|   ========================================
|   Web: http://www.ephotohunt.com
|   Time: Wendnesday, 22 Steptember 2004 05:08 PM - Pacific Time
|   Email: webmaster@ephotohunt.com
|   Purchase Info: http://www.ephotohunt.com/buy
|   Request Installation: http://www.ephotohunt.com/efeedback/efeedbackV4.php?install
|
|   > Script file name: getvars.php
|   > Script written by Khoi Hong
|   > Date started: July 07 2004
|	
|	WARNING //--------------------------
|
|	Selling the code for this program without prior written consent is expressly forbidden. 
|	This computer program is protected by copyright law. 
|	Unauthorized reproduction or distribution of this program, or any portion of if,
|	may result in severe civil and criminal penalties and will be prosecuted to 
|	the maximum extent possible under the lzaw.
+--------------------------------------------------------------------------
*/	

	$parser_version = phpversion();
	$http_vars = array();
	if ($parser_version <= "4.1.0") { 
		$GET_VARS      	= $HTTP_GET_VARS ;
		$POST_VARS     	= $HTTP_POST_VARS;
		$SERVER_VARS   	= $HTTP_SERVER_VARS;
		$COOKIES  	 	= $HTTP_COOKIE_VARS;
	}	
	else{ 
		$GET_VARS      	= $_GET;
		$POST_VARS     	= $_POST;
		$SERVER_VARS   	= $_SERVER;
		$COOKIES  		= $_COOKIE;
	}
	
	if ($SERVER_VARS['REQUEST_METHOD'] == "POST"){
		foreach ($POST_VARS as $key => $val){		  
			if ($key !="user")
		  		$http_vars[$key] = $val;
		}
	}
	elseif($SERVER_VARS['REQUEST_METHOD'] == "GET"){
		foreach ($GET_VARS as $key => $val){
			if ($key !="user")	
			  $http_vars[$key] = $val;
		}
	}
		
	foreach($COOKIES as $key => $val){
		$http_vars[$key] = $val;
	}

	$http_vars['remote_addr'] = $SERVER_VARS['REMOTE_ADDR'];
	$http_vars['user_agent'] = $SERVER_VARS['HTTP_USER_AGENT'];
	$http_vars['server_name'] = $SERVER_VARS['SERVER_NAME'] ;	
	$http_vars['http_referer'] = $SERVER_VARS['HTTP_REFERER'] ;
	$http_vars['http_host'] = $SERVER_VARS['HTTP_HOST'] ;
	$http_vars['query_string'] = $SERVER_VARS['QUERY_STRING'] ;

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
	//Build html from layout
	function get_html_from_layout($layout_name,$isfile=TRUE,$list_value=""){

		$home_root = get_global_var("home_root");
		$layout_path ="layout";		
		if ($isfile){
			$layout_dir = "$home_root";
			$layout_content = get_file_content("$layout_dir/$layout_name");
			if ($layout_content ==""){
				print "Layout content is null [$layout_name]<br>";
			}
		}
		else{
			$layout_content =$layout_name;
		}
		$replace_symbols =array();
		if ($layout_content !=""){
			$replace_symbols = get_replace_symbols($layout_content);
		}		
		$i=0;
		if (count($replace_symbols)>0){
			if (is_array($list_value) && (count($list_value) > 0)){
				foreach ($replace_symbols as $symbol){
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
					$tmp = "{'$symbol'}";			
					$layout_content = str_replace($tmp,get_global_var($symbol),$layout_content);
				}
			}
		}
		return $layout_content;
	}

	//---------------------------------------------------------------------------------------------------------
	//Get file content
	function get_file_content($file_name){
		global $error;
		$data="";		
		if (file_exists($file_name) && is_file($file_name)){
			$fh = fopen ($file_name, "r");
			if ($fh!=FALSE){
				while (!feof ($fh)) {
					$data1 = fgets($fh, 4096);
					if ($data1 != "" || $data1 != "\n" ) {
						$data .= $data1;
					}
				}
				fclose ($fh);
			}
		}
		else
			$error = "File does not exsit " . $file_name;
		return $data;
	}

	//---------------------------------------------------------------------------------------------------------	
	//Get html replace names to build html content
	function get_replace_symbols($layout_content){		
		//preg_match_all ("/({([\w]+)})/", $layout_content, $matches);		
		preg_match_all ("/{'([\w]+)'}/", $layout_content, $matches);		
		$res=array();
		if (count($matches[0]) > 0)
			$res= $matches[0];
		$c= count($res);
		for ($i=0;$i<$c;$i++){
			$res[$i] = str_replace("{'","",$res[$i]);
			$res[$i] = str_replace("'}","",$res[$i]);
		}		
		return $res;
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
								$folder .="$file\n"; 
							} 
						}
						else{
							if ($file != "." && $file != ".."){ 
								$folder .="$file\n"; 
							} 						
						}
					}
				}
				closedir($fh); 
			}
			$array = explode("\n", $folder);			
		}		
		return $array;
	}

	//---------------------------------------------------------------------------------------------------------
	//Get list file 
	function get_list_file($path,$pattern){
		$res =array();				
		$get_file="";		
		if (is_dir("$path")) {
			if ($fh = opendir("$path")){
				if ($pattern !=""){
					while (($file = readdir($fh)) !== false){ 					
						if (is_file("$path/$file")){
							if ($file != "." && $file != ".." && preg_match ("/$pattern/i", "$file")){ 
								$get_file .="$file\n"; 
							} 
						}
					}
				}
				else{
					while (($file = readdir($fh)) !== false){ 					
						if (is_file("$path/$file")){					
							if ($file != "." && $file != ".."){ 
								$get_file .="$file\n"; 
							} 
						}
					}						
				}
				$res = explode("\n", $get_file);	
				closedir($fh); 
			}
		}			
		return $res;
	}	

?>