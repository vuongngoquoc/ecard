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
	$show_list_music .="<li onclick=\"cs_music_filename='';GetMusicCode('','');\">";
	$show_list_music .="<a href='#'><i class='fa fa-remove padding5'></i>$sendcard_php_no_music</a></li>";
	foreach($list_data as $row_data){
		$count_total=get_dbvalue("max_music","count(music_id)","ec_cat_id='$row_data[cat_id]' AND music_active=1");
		
		if($count_total>0){
			$show_list_music .="<li class=\"dropdown-submenu\" onclick=\"toggleMe('music$row_data[cat_id]')\">";
			$show_list_music .= "<a href='#' tabindex='-1' data-toggle='dropdown' >$row_data[cat_name_display] ($count_total)</a></li>";	
			
			$list_data1 =set_array_from_query("max_music","*","ec_cat_id='$row_data[cat_id]' AND music_active=1 Order by music_order");
			//$show_list_music.="<li id='music$row_data[cat_id]' class='music$row_data[cat_id] elm-toggle-collapse'>";
			foreach($list_data1 as $row_data1){
				$music_name_display=str_replace("'","`",$row_data1[music_name_display]);
				if($row_data1[music_user_name_id]==""){
					$music_icon="<i class='fa fa-music padding5'></i>";
				}else{
					//user
					$music_icon="<i class='fa fa-music padding5'></i>";
				}
				$dir = $row_data1[ec_cat_dir] != '' ? "$row_data1[ec_cat_dir]/" : '';
				$src = "resource/music/$dir$row_data1[music_filename]";
				if(file_exists("$ecard_root/$src")){
					$show_list_music .="<li class='music$row_data[cat_id] elm-toggle-collapse' onclick=\"cs_music_id='$row_data1[music_id]';cs_music_filename='$row_data1[music_filename]';GetMusicCode('$src','$music_name_display','$row_data1[music_id]');\">";
					$show_list_music .="<a href='#' >$music_icon $row_data1[music_name_display]</a></li>";
				}
			}
			
			
			//$show_list_music.="</div>";
		}
	}
	if($_SESSION[ecardmax_user]!=""){
	$my_music =set_array_from_query("max_music","*","music_user_name_id='$_SESSION[ecardmax_user]'");
	$c=count($my_music);
	if($c>0){
		$show_list_music .="<li class='dropdown-submenu' onclick=\"toggleMe('my-music')\">";
		$show_list_music .="<a href='#' tabindex='-1' data-toggle='dropdown' >$sendcard_php_my_upload ($c)</a></li>";	
		//$show_list_music.="<li class='my-music'></li>";
		foreach($my_music as $row_data1){
				$music_name_display=str_replace("'","`",$row_data1[music_name_display]);
				if($row_data1[music_user_name_id]==""){
					$music_icon="<i class='fa fa-music padding5'></i>";
				}else{
					//user
					$music_icon="<i class='fa fa-music padding5'></i>";
				}
				$dir = $row_data1[ec_cat_dir] != '' ? "$row_data1[ec_cat_dir]/" : '';
				$src = "resource/music/$dir$row_data1[music_filename]";
				if(file_exists("$ecard_root/$src")){
					$show_list_music .="<li class='my-music elm-toggle-collapse' onclick=\"cs_music_id='$row_data1[music_id]';cs_music_filename='$row_data1[music_filename]';GetMusicCode('$src','$music_name_display');\">";
					$show_list_music .="<a href='#'>$music_icon $row_data1[music_name_display]</a></li>";
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