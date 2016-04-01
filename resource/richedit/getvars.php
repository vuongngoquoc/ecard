<?
	/*
+--------------------------------------------------------------------------
|
|	WARNING: REMOVING THIS COPYRIGHT HEADER IS EXPRESSLY FORBIDDEN
|
|   HOTEDITOR MOD FOR FORUM
|   ========================================
|   by Khoi Hong webmaster@cgi2k.com
|   (c) 1999 - 2004 CGI2K.COM - All right reserved 
|   http://www.cgi2k.com - http://hoteditor.com
|   ========================================
|   Web: http://www.cgi2k.com
|   Time: Thursday, 30 Dec 2004 05:08 PM - Pacific Time
|   Email: webmaster@cgi2k.com
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

	$step = get_global_var(step);
	
	if ($step =="set_default") set_default();

	//---------------------------------------------------------------------------------------------------------	
	//Set Cookie for Editor
	function set_default(){
		$editor= get_global_var(editor);

		if ($editor == "on"){
			setcookie("cookie_editor","on",time()+60*60*24*3650);
print<<<HTML_CODE
<p align="center"><b><font face="Verdana">Rich Text Editor has been set<br>as your default editor. </font></b></p>
<p align="center"><b><font face="Verdana">You will see Rich Text Editor each time you post your message</font></b></p>
<p align="center"><font face="Verdana" size="2">Close this window <br>and hit Preview button to see the change.</font></p><form>
<p align="center"><input type="button" value="Close Window" onClick="window.close()"></p></form>
HTML_CODE;
		}
		else{
			setcookie("cookie_editor","off",time()+60*60*24*3650);
print<<<HTML_CODE
<p align="center"><b><font face="Verdana">Normal Text Area has been set<br>as your default editor. </font></b></p>
<p align="center"><b><font face="Verdana">You will see normal Text Area each time you post your message</font></b></p>
<p align="center"><font face="Verdana" size="2">Close this window <br>and hit Preview button to see the change.</font></p><form>
<p align="center"><input type="button" value="Close Window" onClick="window.close()"></p></form>
HTML_CODE;
		}
		exit;

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

	
?>