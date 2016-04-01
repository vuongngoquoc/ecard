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

	$purchase_message=<<<EOF
<div style="font-family: Tahoma,Verdana, Arial;font-size:9pt;font-weight:bold;padding:4px">This feature is for eCardMAX Standard Package or eCardMAX Gold Package only</div>
<div style="font-family: Tahoma,Verdana, Arial;font-size:8pt;padding:4px">You are using <strong>eCardMAX Gold or Standard</strong>. <a href="http://www.ecardmax.com/purchase/">Click here</a> to buy the update.</div>	
EOF;
	
	set_global_var("print_object",$purchase_message);	
	print_admin_header_footer_page();	

?>