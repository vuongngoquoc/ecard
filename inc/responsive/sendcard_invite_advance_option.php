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
|   Purchase Info: http://www.ecardmax.com/purchase
|   Request Installation: http://www.ecardmax.com/ehelpmax
|	
|	WARNING //--------------------------
|
|	Selling the code for this program without prior written consent is expressly forbidden. 
|	This computer program is protected by copyright law. 
|	Unauthorized reproduction or distribution of this program, or any portion of if,
|	may result in severe civil and criminal penalties and will be prosecuted to 
|	the maximum extent possible under the law.
+--------------------------------------------------------------------------
Note: This product includes GeoLite data created by MaxMind, available from  http://www.maxmind.com 
*/
	if(ECARDMAX_USER!=1)exit;

	//Create button Select Font face
	$list_files=get_list_file("$ecard_root/resource/invitation_fonts",".ttf$");
	
	//Load User font
	$img_font="";
	$show_list_of_user_fonts="";
	$list_userfonts=set_array_from_query("max_user_font","*","font_user_name_id='$_SESSION[user_name_id]'");
	foreach($list_userfonts as $array){
		$font_id=$array[font_id];
		$font_filename=$array[font_filename];
		$font_name=$array[font_name];  
		$show_list_of_user_fonts.=<<<EOF
<li onmouseover="this.className='select_overflow_cell_hover';document.getElementById('userfont$font_id').src='$ecard_url/index.php?step=$step&what=show_font&user_font=1&font_filename=$font_filename&font_name=$font_name';ShowDiv('div_select_fontface','userfont$font_id',210,-200,1);" onmouseout="this.className='select_overflow_cell';showid2('userfont$font_id','none');showid2('hidden_iframe','none');" onclick="document.getElementById('show_selected_font').innerHTML='[$font_name]';myfontface_default='$font_filename';SetSession('iv_fontname','$font_filename');">
	<a href="#"><span class="OK_Message">$font_name</span><span class="caret"></span></a>
</li>		
EOF;
		$img_font.=<<<EOF
<img border="0" alt="" src="" class="div_menu_layer" id="userfont$font_id" />		
EOF;
		$list_fontface.="$array[font_filename]|$array[font_name],";
	}
	$xfont=0;
	$show_list_of_system_fonts="";
	foreach($list_files as $file_name){
		$xfont++;
		$file_name2=str_replace(".ttf","",$file_name);
		$show_list_of_system_fonts.=<<<EOF
<li onmouseover="this.className='select_overflow_cell_hover';document.getElementById('font$xfont').src='$ecard_url/index.php?step=$step&what=show_font&user_font=0&font_filename=$file_name&font_name=$file_name2';ShowDiv('div_select_fontface','font$xfont',210,-200,1);" onmouseout="this.className='select_overflow_cell';showid2('font$xfont','none');showid2('hidden_iframe','none');" onclick="document.getElementById('show_selected_font').innerHTML='[$file_name2]';myfontface_default='$file_name';SetSession('iv_fontname','$file_name');"><a href="#">$file_name2</a></li>		
EOF;
		$img_font.=<<<EOF
<img border="0" alt="" src="" class="div_menu_layer" id="font$xfont" />		
EOF;
		$list_fontface.="$file_name|$file_name2,";
	}
	
	$font_default=str_replace(".ttf","",$_SESSION[iv_fontname]);
	$button_select_fontface=<<<EOF
<li class="dropdown">
	<a data-toggle="dropdown" href="#" >
	$invite_button_fontface <span id="show_selected_font" style="font-weight:bold">[$font_default]</span>
	<span class="caret"></span></a>
	<ul class="dropdown-menu popup-sendcard">$show_list_of_user_fonts $show_list_of_system_fonts</ul>
	$img_font
</li>	
EOF;
	$myfontface_default=$_SESSION[iv_fontname];

	//Create button Select Font Size
	$show_div_fontsize="";
	for($i=10;$i<=40;$i++){
		$size=$i;
		$show_div_fontsize.=<<<EOF
<li onclick="document.getElementById('show_selected_fontsize').innerHTML='[$size]';myfontsize_default='$size';SetSession('iv_fontsize','$size');"><a href='#'>$size</a></li>		
EOF;
		$list_fontsize.="$i,";
	}
	$iv_fontsize=$_SESSION[iv_fontsize];
	$button_select_fontsize=<<<EOF
<li class="dropdown">
<a data-toggle="dropdown" href="#" id="button_select_fontsize" >$invite_button_fontsize
	<span id="show_selected_fontsize" style="font-weight:bold">[$iv_fontsize]</span><span class="caret"></span>
</a>
<ul class="dropdown-menu popup-sendcard">$show_div_fontsize</ul>
</li>	
EOF;
	$myfontsize_default=$_SESSION[iv_fontsize];

	//Create button Select Line Height
	$show_div_lineheight="";
	for($i=20;$i<=60;$i++){
		$line_height=$i;
		$show_div_lineheight.=<<<EOF
<li onclick="document.getElementById('show_selected_lineheight').innerHTML='[$line_height]';SetSession('iv_line_height','$line_height');"><a href='#'>$line_height</a></li>		
EOF;
	}
	$iv_line_height=$_SESSION[iv_line_height];
	$button_select_lineheight=<<<EOF
<li class="dropdown">
<a data-toggle="dropdown" href="#" >$invite_button_line_height
	<span id="show_selected_lineheight" style="font-weight:bold">[$iv_line_height]</span>
<span class="caret"></span></a>
<ul class="dropdown-menu popup-sendcard">$show_div_lineheight</ul>
</li>	
EOF;

	//Create button Select Font Color	
	$iv_fontcolor2=get_file_content("$ecard_root/resource/invitation/$_SESSION[iv_cat_dir]/$_SESSION[iv_thumbnail]/RGB_text_color.txt");
	if($iv_fontcolor2=="")$iv_fontcolor2="0,0,0";
	if($_SESSION[user_design_invite]=="1" && $_SESSION[udi_invite_fontcolor]!="" && $_SESSION[udi_iv_id]==$iv_row[iv_id]){
		$iv_fontcolor=$_SESSION[udi_invite_fontcolor];
	}
	elseif($_SESSION[user_design_invite]!="1"){
		$iv_fontcolor=$iv_fontcolor2;
	}
	$_SESSION[invite_fontcolor]=$iv_fontcolor;

	if(!(strpos($_SESSION[invite_fontcolor],"#")===false)){
		$show_default_color= get_RGB($_SESSION[invite_fontcolor]);
	}
	else{
		$show_default_color= $_SESSION[invite_fontcolor];
	}
	$color_table_js=get_html_from_layout("templates/$cf_set_template/color_table.html");
	$button_select_fontcolor=<<<EOF
<li class="dropdown">
<a data-toggle="dropdown" href="#">$invite_button_fontcolor
	<span id="show_selected_fontcolor" style="background-color:rgb($show_default_color)">&nbsp;&nbsp;&nbsp;&nbsp;</span>
<span class="caret"></span></a>
<ul class="dropdown-menu popup-sendcard div-color">$color_table_js</ul>
</li>	
EOF;
	$array_color[0] ="#FFFFFF";$array_color[1] ="#000000";$array_color[2] ="#EEECE1";$array_color[3] ="#1F497D";$array_color[4] ="#4F81BD";$array_color[5] ="#C0504D";$array_color[6] ="#9BBB59";$array_color[7] ="#8064A2";$array_color[8] ="#4BACC6";$array_color[9] ="#F79646";
	$array_color[10] ="#F2F2F2";$array_color[11] ="#7F7F7F";$array_color[12] ="#DDD9C3";$array_color[13] ="#C6D9F0";$array_color[14] ="#DBE5F1";$array_color[15] ="#F2DCDB";$array_color[16] ="#EBF1DD";$array_color[17] ="#E5E0EC";$array_color[18] ="#DBEEF3";$array_color[19] ="#FDEADA";
	$array_color[20] ="#D8D8D8";$array_color[21] ="#595959";$array_color[22] ="#C4BD97";$array_color[23] ="#8DB3E2";$array_color[24] ="#B8CCE4";$array_color[25] ="#E5B9B7";$array_color[26] ="#D7E3BC";$array_color[27] ="#CCC1D9";$array_color[28] ="#B7DDE8";$array_color[29] ="#FBD5B5";
	$array_color[30] ="#BFBFBF";$array_color[31] ="#3F3F3F";$array_color[32] ="#938953";$array_color[33] ="#548DD4";$array_color[34] ="#95B3D7";$array_color[35] ="#D99694";$array_color[36] ="#C3D69B";$array_color[37] ="#B2A2C7";$array_color[38] ="#92CDDC";$array_color[39] ="#FAC08F";
	$array_color[40] ="#A5A5A5";$array_color[41] ="#262626";$array_color[42] ="#494429";$array_color[43] ="#17365D";$array_color[44] ="#366092";$array_color[45] ="#953734";$array_color[46] ="#76923C";$array_color[47] ="#5F497A";$array_color[48] ="#31859B";$array_color[49] ="#E36C09";
	$array_color[50] ="#7F7F7F";$array_color[51] ="#0C0C0C";$array_color[52] ="#1D1B10";$array_color[53] ="#0F243E";$array_color[54] ="#244061";$array_color[55] ="#632423";$array_color[56] ="#4F6128";$array_color[57] ="#3F3151";$array_color[58] ="#205867";$array_color[59] ="#974806";
	$array_color[60] ="#C00000";$array_color[61] ="#FF0000";$array_color[62] ="#FFC000";$array_color[63] ="#FFFF00";$array_color[64] ="#92D050";$array_color[65] ="#00B050";$array_color[66] ="#00B0F0";$array_color[67] ="#0070C0";$array_color[68] ="#002060";$array_color[69] ="#7030A0";
	$show_list_fontcolor.="<option value=\"$_SESSION[invite_fontcolor]\" style=\"background-color:rgb($show_default_color)\">$_SESSION[invite_fontcolor]</option>";
	for($i=0;$i<=69;$i++){
		$show_list_fontcolor.="<option value=\"$array_color[$i]\" style=\"background-color:$array_color[$i];color:$array_color[$i]\">$array_color[$i]</option>";
	}
	$myfontcolor_default=$show_default_color;
	
	//Create button Edit Message
	$button_edit_message="<span class=\"btn_invite_2\" onclick=\"showid2('div_edit_message','none');showid2('div_invite_image','none');showid2('div_textbox','block');\">$invite_button_click_change_message</span>";

	//Create button Rate card
	//Print button Rate card
	if($_SESSION[mg_allow_rate]=="1"){		
		$button_rate_card=<<<EOF
<li id="button_rate_card" >
		<img title='½' onclick="gorate('5');" onmouseout='rateme_out();' onMouseover="rateme_over('5');" id="img5" border="0" src="$ecard_url/templates/$cf_set_template/rateme0_l.gif"><img onclick="gorate('10');" onMouseover="rateme_over('10');" title='1' onmouseout='rateme_out()' id="img10" src="$ecard_url/templates/$cf_set_template/rateme0_r.gif"><img title='1½' onclick="gorate('15');" onMouseover="rateme_over('15');" onmouseout='rateme_out()' id="img15" border="0" src="$ecard_url/templates/$cf_set_template/rateme0_l.gif"><img onclick="gorate('20');" onMouseover="rateme_over('20');" title='2' onmouseout='rateme_out()' id="img20" src="$ecard_url/templates/$cf_set_template/rateme0_r.gif"><img title='2½' onclick="gorate('25');" onMouseover="rateme_over('25');" onmouseout='rateme_out()' id="img25" border="0" src="$ecard_url/templates/$cf_set_template/rateme0_l.gif"><img onclick="gorate('30');" onMouseover="rateme_over('30');" title='3' onmouseout='rateme_out()' id="img30" src="$ecard_url/templates/$cf_set_template/rateme0_r.gif"><img title='3½' onclick="gorate('35');" onMouseover="rateme_over('35');" onmouseout='rateme_out()' id="img35" border="0" src="$ecard_url/templates/$cf_set_template/rateme0_l.gif"><img onclick="gorate('40');" onMouseover="rateme_over('40');" title='4' onmouseout='rateme_out()' id="img40" src="$ecard_url/templates/$cf_set_template/rateme0_r.gif"><img title='4½' onclick="gorate('45');" onMouseover="rateme_over('45');" onmouseout='rateme_out()' id="img45" border="0" src="$ecard_url/templates/$cf_set_template/rateme0_l.gif"><img onclick="gorate('50');" onMouseover="rateme_over('50');" title='5' onmouseout='rateme_out()' id="img50" src="$ecard_url/templates/$cf_set_template/rateme0_r.gif">
</li>
EOF;
	}
	else {
		$button_rate_card="";
	}

	//Print button Select music
	if($cf_option_user_select_music=="1"){
		$count_list=get_dbvalue("max_music","count(music_id)","music_active='1' and music_user_name_id='' or music_user_name_id='$_SESSION[user_name_id]'");		
		$button_select_music=<<<EOF
<li class="dropdown">
<a data-toggle="dropdown" href="#" onclick="CallMusicFrameSrc();">
$sendcard_php_button_select_music<span class="caret"></span></a>
<ul class="dropdown-menu popup-sendcard" id="load_music" ></ul>
</li>		
EOF;
	}
	else {
		$button_select_music="";
	}
?>