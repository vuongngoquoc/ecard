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

	$what = get_global_var(what);
	switch ($what){		
		case "export": 
			set_global_var("show_database_title","<h1><img border=0 src=html/07_icon_export_database2.gif align=absmiddle /> $database_txt_export_database</h1>");
			set_global_var("database_title","<img border=0 src=html/07_icon_export_database.gif align=absmiddle>$database_txt_export_database_to_text_files");
			set_global_var("database_message","$database_txt_this_tool_export_your_database_to_txt_files");
			set_global_var("print_object",get_html_from_layout("admin/html/show_database.html"));
			print_admin_header_footer_page();
			break;
		case "import": 
			set_global_var("show_database_title","<h1><img border=0 src=html/07_icon_import_database2.gif align=absmiddle /> $database_txt_import_database</h1>");
			set_global_var("database_title","<img border=0 src=html/07_icon_import_database.gif align=absmiddle>$database_txt_import_text_files_to_database");
			set_global_var("database_message","$database_txt_this_tool_will_import_txt_files_to_database");
			set_global_var("print_object",get_html_from_layout("admin/html/show_database.html"));
			print_admin_header_footer_page();
			break;
		case "export_now": 
			export_text($database_name);
			break;
		case "import_now":
			import_text_db($database_name);			
			break;					
		default:
			print "";
	}	
	
	//---------------------------------------------------------------------------------------
	//Exprot Database to text file
	function export_text($db){
		global $database_message_export_table_successfully,$database_message_export_warning,$database_txt_export_database;
		$ecard_root=get_global_var(ecard_root);

		chk_sql_backup();
		make_db_connect();
		$tb_list=get_table_list($db);
		 $HTML="";
		 mysql_select_db($db);
		 for($i=0;$i<count($tb_list);$i++){
		  $tb=$tb_list[$i];
		  $sql="SELECT * FROM $tb";
		  $result=mysql_query($sql);
		  $text_tb="";
		  $f=fopen($ecard_root . "/admin/sql_backup/" .$tb.".txt",'w+');
		  while ($rs=mysql_fetch_array($result)){
			$text_row="";
			for($j=0;$j<count($rs)/2;$j++){
				$rs[$j] =str_replace("\r\n","¿",$rs[$j]);
				if(mysql_field_type($result,$j)=="int"){
				 $text_row.=$rs[$j]."††";
				}else{
				 $text_row.="ˆ".$rs[$j]."ˆ††";
				}
			}
			$text_row=substr($text_row,0,strlen($text_row)-2);
			$text_tb.=$text_row."……";
		  }
		  $text_tb=substr($text_tb,0,strlen($text_tb)-2);
		  $text_tb=str_replace("\r\n","",$text_tb);
		  fwrite($f,$text_tb);
		  fclose($f);
		  $msg_export_ok = str_replace("%tb%","$tb",$database_message_export_table_successfully);
		  $HTML.=  $msg_export_ok;
		  mysql_free_result($result);
		 }
		$HTML.="<br /><span style=\"color:red;font-size:24pt\">$database_message_export_warning</span>";
		set_global_var("show_database_title","<h1><img border=0 src=html/07_icon_export_database2.gif align=absmiddle /> $database_txt_export_database</h1>");
		set_global_var("database_title","<img border=0 src=html/07_icon_export_database.gif align=absmiddle>$database_txt_export_database_to_text_files");
		set_global_var("database_message",$HTML);
		set_global_var("print_object",get_html_from_layout("admin/html/show_database.html"));
		print_admin_header_footer_page();
		 exit;
	}
	
	//---------------------------------------------------------------------------------------
	//Import text file to database
	function import_text_db($db){
		global $database_message_no_table_in_your_database;
		$ecard_root=get_global_var(ecard_root);

		make_db_connect();
	 $tb_list=get_table_list($db);
	 $HTML="";
	 if(count($tb_list)==0){
	  $HTML .= "$database_message_no_table_in_your_database";
	 }else{
	  for($i=0;$i<count($tb_list);$i++){
		$table=$tb_list[$i];
	   if(file_exists($ecard_root . "/admin/sql_backup/". $tb_list[$i].".txt")){
		 #load text file to import data
		 $fh=fopen($ecard_root . "/admin/sql_backup/". $tb_list[$i].".txt",'r');
		 $tb_text=@fread($fh,filesize($ecard_root . "/admin/sql_backup/". $tb_list[$i].".txt"));
		 fclose($fh);
		 mysql_select_db($db);
		 $delete_query="DELETE FROM $table";
		 mysql_query($delete_query);
		 if (strlen($tb_text)>0){
		 $rows_text=split("\…\…",$tb_text);
		  for($j=0;$j<count($rows_text);$j++){
			$row=split("\†\†",$rows_text[$j]);
			$insert_query="INSERT INTO $table VALUES(";
			for($k=0;$k<count($row);$k++){
			  $row[$k] =str_replace("¿","\n",$row[$k]);
			  $insert_query.=$row[$k].",";
			}
			$insert_query=substr($insert_query,0,strlen($insert_query)-1);
			$insert_query.=")";
			$insert_query=str_replace("'","\\'",$insert_query);
			$insert_query=str_replace("ˆ","'",$insert_query);
			if (mysql_query($insert_query)){
			//echo $insert_query."executed sucessfully! <br>";
			}else{
			$msg_query_failure = str_replace("%insert_query%","$insert_query",$database_message_query_execute_failure);
			echo $msg_query_failure;
			}
		   }
		  }
			$database_message_import_file_ok=str_replace("%tb_list%",$tb_list[$i],$database_message_import_file_ok);
			$HTML.=$database_message_import_file_ok;
	   }else{
			$database_message_import_file_fail=str_replace("%tb_list%",$tb_list[$i],$database_message_import_file_fail);
			$HTML.=$database_message_import_file_fail;
	   }
	  }// end for
	 }// end if
		set_global_var("show_database_title","<h1><img border=0 src=html/07_icon_import_database2.gif align=absmiddle /> $database_txt_import_database</h1>");
		set_global_var("database_title","<img border=0 src=html/07_icon_import_database.gif align=absmiddle>$database_txt_import_text_files_to_database");
		set_global_var("database_message",$HTML);
		set_global_var("print_object",get_html_from_layout("admin/html/show_database.html"));
		print_admin_header_footer_page();
	}// end function

	//---------------------------------------------------------------------------------------
	function chk_sql_backup(){
		global $database_txt_pease_chmod_files_folders,$database_txt_please_create_folder;
		
		$ecard_root=get_global_var(ecard_root);

		if (file_exists("$ecard_root/admin/sql_backup")) {
			if (!is_writable("$ecard_root/admin/sql_backup")) {
				print "<font face=Verdana size=2 color=red>$database_txt_pease_chmod_files_folders</font>";
				exit;
			}
		} 
		else {
			if (!is_writable("$ecard_root")) {
				$database_txt_please_create_folder=str_replace("%ecard_root%","$ecard_root",$database_txt_please_create_folder);
				print "<font face=Verdana size=2 color=red>$database_txt_please_create_folder</font>";
				exit;
			}
			else{	
				mkdir("$ecard_root/admin/sql_backup", 0777); 
			}
		}
	}

	//---------------------------------------------------------------------------------------
	function get_table_list($db){
	 $result = mysql_list_tables($db);
	 $i = 0;
	 while ($i < mysql_num_rows($result)) {
		$tb_names[$i] = mysql_tablename($result, $i);
		$i++;
	}
	return $tb_names;
	}	
?>