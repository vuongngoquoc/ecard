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

	$list_data =set_array_from_query("max_java_applet","java_id,java_dirname,java_name_display","java_active='1' Order by java_order,java_name_display");
	$list_of_java_icon="";
	foreach($list_data as $row_data){
		$java_name_display=str_replace("'","`",$row_data[java_name_display]);
		if(file_exists("$ecard_root/resource/applet/$row_data[java_dirname]/thumb_icon.gif")){
			$java_dirname=$row_data[java_dirname];
			$java_id=$row_data[java_id];
			$java_name_display=$row_data[java_name_display];
			$thumbnail_icon="$ecard_url/resource/applet/$row_data[java_dirname]/thumb_icon.gif";
			
			$list_of_java_icon.=get_html_from_layout("templates/$cf_set_template/load_select_java_item.html",$the_template_list_of_java_icon);
		}
		else{
			$java_dirname=$row_data[java_dirname];
			$java_id=$row_data[java_id];
			$java_name_display=$row_data[java_name_display];
			$thumbnail_icon="$ecard_url/templates/$cf_set_template/icon_no_icon_java.gif";
			
			$list_of_java_icon.=get_html_from_layout("templates/$cf_set_template/load_select_java_item.html",$the_template_list_of_java_icon);
		}

		//Load java code.txt to <textarea> with an id  			
		$get_pixel="width=$fullW height=$fullH";
		$centerX=round(500/2);
		$centerY=round(375/2);
		$applet_code=get_file_content("$ecard_root/resource/applet/$row_data[java_dirname]/code.txt");
		$applet_code=str_replace("\r\n",' ',$applet_code);
		$applet_code=str_replace("\"","'",$applet_code);
		$applet_code = str_replace("anfy_key", $cf_anfy_java_keycode, $applet_code) ;
		$applet_code = str_replace("ds_key", $cf_ds_java_keycode, $applet_code) ;
		$applet_code = str_replace("cgi2k_key", $cf_cgi2k_java_keycode, $applet_code) ;
		$applet_code = str_replace("codebase", "codebase=$ecard_url/resource/applet/$row_data[java_dirname]", $applet_code) ;
		$applet_code = str_replace("change_pixel", $get_pixel, $applet_code) ;
		$applet_code = str_replace("centerX", $centerX, $applet_code) ;
		$applet_code = str_replace("centerY", $centerY, $applet_code) ;
		$applet_code = str_replace("change_path", "$ecard_url/resource/applet/$row_data[java_dirname]", $applet_code) ;
		$applet_code.="<br /><br />$sendcard_txt_download_java";
		$java_code .="<textarea id=\"java_code$row_data[java_id]\" style=\"position:absolute;display:none;top=-5px;left:-5px;width:1px;height:1px\">$applet_code</textarea>";
	}
	$show_list_java_icon=<<<EOF
<div class="select_overflow_cell" onclick="cs_java=-1;GetJavaCode('-1');">
	<img border="0" src="$ecard_url/templates/$cf_set_template/icon_no_java.gif" alt="" style="vertical-align:middle"/> $sendcard_php_no_java_applet
</div>
$list_of_java_icon	
EOF;

print <<<EOF
<html>
	<head>
		<meta http-equiv='Content-Type' content='text/html; charset=$charset' />
		<style type="text/css">
			<!--
				@import url(templates/$cf_set_template/css/style.css);
			-->
		</style>
	</head>
	<body class="select_overflow" style='margin-top:4px;margin-left:4px;'>
		$show_list_java_icon$java_code
	</body>
</html>
<script type="text/javascript">
	var cs_java="";
	function GetJavaCode(java_id){
		java_applet="";
		if(java_id!=-1){
			var id="java_code"+java_id;
			java_applet=document.getElementById(id).value;
		}
		self.parent.GetJavaCode(cs_java,java_applet);
	}
</script>
EOF;

?>