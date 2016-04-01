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

	$row=get_row("max_banner","*","banner_id='$banner_id'");

	if(!(strpos($row[banner_img_url],".swf")===false)){

$code=<<<HTML_CODE
document.write("<div style=\"text-align:center\"><OBJECT classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://active.macromedia.com/flash2/cabs/swflash.cab#version=4,0,0,0' ID=postcard WIDTH=$row[banner_width] HEIGHT=$row[banner_height]>");
document.write("<PARAM NAME=movie VALUE='$row[banner_img_url]'>");
document.write("<PARAM NAME=quality VALUE=high>");
document.write("<embed src='$row[banner_img_url]' quality=high WIDTH=$row[banner_width] HEIGHT=$row[banner_height] TYPE='application/x-shockwave-flash' PLUGINSPAGE='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'>");
document.write("</OBJECT></div>");
HTML_CODE;

	}
	else{

$code=<<<HTML_CODE
document.write("<div style=\"text-align:center\"><table align=\"center\" class=\"table_border\"><tr><td><" + "a href=" + "$ecard_url/index.php?step=gotourl&banner_id=$banner_id" + " target=_blank>" + "<" + "img src=" + "$row[banner_img_url]" + " border=0 width=$row[banner_width] height=$row[banner_height]></a></td></tr></table></div><br />");
HTML_CODE;

	}

print $code;
?>