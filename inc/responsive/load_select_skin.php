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

	$list_data =set_array_from_query("max_skin","skin_id,skin_dirname,skin_name_display,skin_text_color","skin_active='1' Order by skin_order,skin_name_display");
	foreach($list_data as $row_data){
		$skin_name_display=str_replace("'","`",$row_data[skin_name_display]);
		if(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/skin.gif")){
			$src="$ecard_url/resource/skin/$row_data[skin_dirname]/skin.gif";				
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/skin.jpg")){
			$src="$ecard_url/resource/skin/$row_data[skin_dirname]/skin.jpg";			
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/skin.png")){
			$src="$ecard_url/resource/skin/$row_data[skin_dirname]/skin.png";			
		}

		if(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/bar.gif")){
			$bar="bar.gif";
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/bar.jpg")){
			$bar="bar.jpg";
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/bar.png")){
			$bar="bar.png";
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/bar.swf")){
			$bar="bar.swf";
		}
		list($barW,$barH)=getimagesize("$ecard_root/resource/skin/$row_data[skin_dirname]/$bar");

		if(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/bkg.gif")){
			$bkg="bkg.gif";
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/bkg.jpg")){
			$bkg="bkg.jpg";
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/bkg.png")){
			$bkg="bkg.png";
		}

		if(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/bottom.gif")){
			$bottom="bottom.gif";
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/bottom.jpg")){
			$bottom="bottom.jpg";
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/bottom.png")){
			$bottom="bottom.png";
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/bottom.swf")){
			$bottom="bottom.swf";
		}
		list($bottomW,$bottomH)=getimagesize("$ecard_root/resource/skin/$row_data[skin_dirname]/$bottom");

		if(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/icon.gif")){
			$icon="icon.gif";
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/icon.jpg")){
			$icon="icon.jpg";
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/icon.png")){
			$icon="icon.png";
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/icon.swf")){
			$icon="icon.swf";
		}
		list($iconW,$iconH)=getimagesize("$ecard_root/resource/skin/$row_data[skin_dirname]/$icon");

		if(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/top.gif")){
			$top="top.gif";
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/top.jpg")){
			$top="top.jpg";
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/top.png")){
			$top="top.png";
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/top.swf")){
			$top="top.swf";
		}
		list($topW,$topH)=getimagesize("$ecard_root/resource/skin/$row_data[skin_dirname]/$top");

		if(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/poem.gif")){
			$poem="poem.gif";
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/poem.jpg")){
			$poem="poem.jpg";
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/poem.png")){
			$poem="poem.png";
		}
		elseif(file_exists("$ecard_root/resource/skin/$row_data[skin_dirname]/poem.swf")){
			$poem="poem.swf";
		}
		list($poemW,$poemH)=getimagesize("$ecard_root/resource/skin/$row_data[skin_dirname]/$poem");
		$img_poem="$ecard_url/resource/skin/$ec_row[ec_skin]/$poem,$poem,$poem";
		
		$show_list_skin_icon .="<li onclick=\"cs_skin_name='$row_data[skin_dirname]';GetSkinCode('$ecard_url/resource/skin/$row_data[skin_dirname]/$bar,$barW,$barH','$ecard_url/resource/skin/$row_data[skin_dirname]/$bkg','$ecard_url/resource/skin/$row_data[skin_dirname]/$bottom,$bottomW,$bottomH','$ecard_url/resource/skin/$row_data[skin_dirname]/$icon,$iconW,$iconH','$ecard_url/resource/skin/$row_data[skin_dirname]/$top,$topW,$topH','$ecard_url/resource/skin/$row_data[skin_dirname]/$poem,$poemW,$poemH','$row_data[skin_text_color]');\">";
		$show_list_skin_icon .="<a href='#'><img src=\"$src\" alt=\"\" /></a></div>";		
	}
echo $show_list_skin_icon;
EOF;

?>