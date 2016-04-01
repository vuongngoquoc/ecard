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
	
	if (!function_exists('json_encode')) {
		require_once("inc/jsonwrapper_inner.php");
	}
	
	if(ECARDMAX_USER!=1)exit;
	/*
	if($step=="get_music"){
		$list_data =set_array_from_query("max_music","*","ec_cat_id='$cat_id'");
		print_r(json_encode($list_data));
		exit;
	}
	*/
	$list_data =set_array_from_query("max_music_cat","*","1=1 order by cat_order,cat_name_display ASC");	
	$show_list_music .="";
	$show_list_music .="<div class=\"select_overflow_cell\" onclick=\"cs_music_filename='';GetMusicCode('','');\"><img border=\"0\" src=\"$ecard_url/templates/$cf_set_template/icon_no_music.gif\" alt=\"\" style=\"vertical-align:middle\"/> $sendcard_php_no_music</div>";
	foreach($list_data as $row_data){
		$count_total=get_dbvalue("max_music","count(music_id)","ec_cat_id='$row_data[cat_id]' AND music_active=1");
		
		if($count_total>0){
			$show_list_music .="<div class=\"select_overflow_cell\" onclick=\"getMusic('music$row_data[cat_id]')\">$row_data[cat_name_display] ($count_total)</div>";	
			
			$list_data1 =set_array_from_query("max_music","*","ec_cat_id='$row_data[cat_id]' AND music_active=1 Order by music_order");
			$show_list_music.="<div style='display:none' id='music$row_data[cat_id]' class='select_over_flow_cell_music'>";
			foreach($list_data1 as $row_data1){
				$music_name_display=str_replace("'","`",$row_data1[music_name_display]);
				if($row_data1[music_user_name_id]==""){
					$music_icon="<img border=\"0\" src=\"$ecard_url/templates/$cf_set_template/icon_play_music.gif\" alt=\"\" style=\"vertical-align:middle\"/>";
				}else{
					$music_icon="<img border=\"0\" src=\"$ecard_url/templates/$cf_set_template/icon_play_music_user.gif\" alt=\"\" style=\"vertical-align:middle\"/>";
				}
				if(file_exists("$ecard_root/resource/music/$row_data1[ec_cat_dir]/$row_data1[music_filename]")){
					$show_list_music .="<div class=\"select_overflow_cell1\" onclick=\"cs_music_id='$row_data1[music_id]';cs_music_filename='$row_data1[music_filename]';GetMusicCode('resource/music/$row_data1[ec_cat_dir]/$row_data1[music_filename]','$music_name_display','$row_data1[music_id]');\">$music_icon $row_data1[music_name_display]</div>";
				}
			}
			
			
			$show_list_music.="</div>";
		}
	}
	if($_SESSION[ecardmax_user]!=""){
	$my_music =set_array_from_query("max_music","*","music_user_name_id='$_SESSION[ecardmax_user]'");
	$c=count($my_music);
	if($c>0){
		$show_list_music .="<li class=\"select_overflow_cell\" onclick=\"getMusic('music_mymusic')\">$sendcard_php_my_upload ($c)</li>";	
		$show_list_music.="<li id='music_mymusic' class='select_over_flow_cell_music'></li>";
		foreach($my_music as $row_data1){
				$music_name_display=str_replace("'","`",$row_data1[music_name_display]);
				if($row_data1[music_user_name_id]==""){
					$music_icon="<i class='fa fa-music padding5'></i>";
				}else{
					$music_icon="<i class='fa fa-music padding5'></i>";
				}
				$dir = $row_data1[ec_cat_dir] != '' ? "$row_data1[ec_cat_dir]/" : '';
				$src = "resource/music/$dir$row_data1[music_filename]";
				if(file_exists("$ecard_root/$src")){
					$show_list_music .="<li class=\"select_overflow_cell\" onclick=\"cs_music_id='$row_data1[music_id]';cs_music_filename='$row_data1[music_filename]';GetMusicCode('$src','$music_name_display');\">$music_icon $row_data1[music_name_display]</li>";
				}
		}	
		//$show_list_music.="</div>";
	}
	}
	echo $show_list_music;
	exit;
print <<<EOF
<html>
	<head>
		<meta http-equiv='Content-Type' content='text/html; charset=$charset' />
		<style type="text/css">
			<!--
				@import url($ecard_url/templates/$cf_set_template/css/style.css);
			-->
		</style>
		<script type="text/javascript" src="tools.js"></script>
		<script type="text/javascript" src="popup.js"></script>
	</head>
	<body class="select_overflow" style='margin-top:4px;margin-left:4px;'>
		$show_list_music
	</body>
</html>
<script type="text/javascript">
	var cs_music_filename="";
	var cs_music_id="";
	function GetMusicCode(audioURL,audioTitle){
		self.parent.GetMusicCode(cs_music_filename,audioURL,cs_music_id,audioTitle);
	}
	function getMusic(id){
		if(document.getElementById(id).style.display=='none'){
			document.getElementById(id).style.display='block';
		}else{
			document.getElementById(id).style.display='none';
		}
	}
</script>
EOF;

?>