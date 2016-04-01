<?php
/*
+--------------------------------------------------------------------------
|
|	WARNING: REMOVING THIS COPYRIGHT HEADER IS EXPRESSLY FORBIDDEN
|
|   ECardMax Version 10.5 Full Version
|   ========================================
|   (c) 1999 - 2016 ECARDMAX.COM - All right reserved 
|	Software For Website, Inc.
|   http://www.ecardmax.com 
|   ========================================
|   Email: webmaster@ecardmax.com
|   Purchase Info: http://www.ecardmax.com/index.php?step=Purchase
|   Request Installation: http://www.ecardmax.com/ehelpmax/index.php
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
	$exist = get_dbvalue('max_config','config_value',"config_name='cf_logo_url'");
	$upload_dir ="$ecard_root/logo";
	if($what=="add_new"){		
		//Upload file
		$upload_dir ="$ecard_root/logo";
			$new_name="logo";
			$file_key_full="img_logo";
			$file_name_full = strtolower($POST_FILES[$file_key_full]['name']);
			$file_full_size = $POST_FILES[$file_key_full]['size'];
			if(!(strpos($file_name_full,".gif")===false)){ //If .gif 
				$file_name_full = $new_name .".gif";					
			}
			elseif(!(strpos($file_name_full,".jpg")===false)){ //If .jpg
				$file_name_full = $new_name .".jpg";
			}
			elseif(!(strpos($file_name_full,".swf")===false)){ //If .Flash
				$file_name_full = $new_name .".swf";
			}
			elseif(!(strpos($file_name_full,".png")===false)){ //If .png
				$file_name_full = $new_name .".png";
			}
			if ($exist === NULL)
			{
				$field_name = "(config_name,config_value)";
				$field_value = "('cf_logo_url','$file_name_full')";
				insert_data_to_db("max_config",$field_name,$field_value);
			} 
			else
			{
				if ($exist) {
					unlink("$upload_dir/$exist");
				}
				update_field_in_db("max_config","config_value",$file_name_full,"config_name='cf_logo_url' LIMIT 1");
			}	
			$file_upload_full = $upload_dir."/".$file_name_full;
			
			if($file_full_size > 0){
				if (!file_exists($file_upload_thumb) && !file_exists($file_upload_full)){
					move_uploaded_file($POST_FILES[$file_key_full]['tmp_name'],$file_upload_full);
					chmod($file_upload_full,0777);

					//Resize full size image if image width > 500
					$image_info = getimagesize($file_upload_full);
					$type=$image_info['mime'];
					$img_width =$image_info[0];
					$img_height=$image_info[1];
					if($type =="image/jpeg" || $type =="image/gif" || $type =="image/png"){
						if($img_width > get_global_var(cf_max_image_width))
							resize_myimage($type,$file_upload_full,$file_upload_full,"full");							
					}
				}
			}
		$what="";
		set_global_var("what","");
		header("Location: $ecard_url/admin/index.php?step=admin_option_logo");
	}
	set_global_var("logo","$ecard_url/logo/$exist");
	set_global_var("print_object",get_html_from_layout("admin/html/admin_option_logo.html"));	
	print_admin_header_footer_page();
	?>