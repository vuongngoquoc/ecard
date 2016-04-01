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
	
	function make_png($IMAGE_WIDTH,$TEXT_ALIGN,$TEXT,$LINE_HEIGHT,$FONT_SIZE,$FONT_NAME,$BACKGORUND_COLOR,$TEXT_COLOR){
		global $ecard_root,$step;

		$array_text = explode("\n",$TEXT);

		$image_width=$IMAGE_WIDTH;
		$line_height= $LINE_HEIGHT;
		$image_height=sizeof($array_text)*$line_height;
		$font_size = $FONT_SIZE;

		// Create the image
		$im = imagecreatetruecolor($image_width, $image_height);

		// Create background & text colors
		if((strpos($BACKGORUND_COLOR,",")===false))
			$BACKGORUND_COLOR = get_RGB($BACKGORUND_COLOR);

		if((strpos($TEXT_COLOR,",")===false))
			$TEXT_COLOR = get_RGB($TEXT_COLOR);
		$info_bkg_color = split(",",$BACKGORUND_COLOR);
		$info_text_color = split(",",$TEXT_COLOR);
		$default_bkg_color= imagecolorallocate($im, $info_bkg_color[0], $info_bkg_color[1], $info_bkg_color[2]);
		$default_text_color= imagecolorallocate($im, $info_text_color[0], $info_text_color[1], $info_text_color[2]);
	
		//if($step !="showfont")imagecolortransparent($im,$default_bkg_color);
		imagefilledrectangle($im, 0, 0, $image_width, $image_height, $default_bkg_color);

		$font = $FONT_NAME;
		$font_size2=$font_size;
		for($i=0;$i<=sizeof($array_text);$i++) {
			//Center the text
			$font_size=$font_size2;
			$print_text = $array_text[$i];
			$info = split("\]",$print_text);
			$get_fsize="";
			$fontface="";
			$fontcolor="";

			if(count($info) >= 2){
				$docheck = $info[0];
				if($docheck{0} =="["){
					$docheck =str_replace("[","",$docheck);
					$docheck =str_replace("-","",$docheck);
					$docheck =str_replace("  "," ",$docheck);								
					$Pinfo = split(" ",$docheck);
					
					foreach($Pinfo as $val){
						if($val !=""){
							if((strpos($val,".ttf")===false) && (strpos($val,",")===false) && (strpos($val,"#")===false)){
								$get_fsize = $val;
							}
							if(!(strpos($val,".ttf")===false)){
								$fontface=$val;
							}
							if(!(strpos($val,",")===false)){
								$fontcolor=$val;
							}
							if(!(strpos($val,"#")===false)){
								$fontcolor=$val;
								$fontcolor = get_RGB($fontcolor);
							}
						}
					}

					if($get_fsize !=""){
						$font_size = $get_fsize;
					}
					else{
						$font_size = $font_size2;
					}
					
					if($fontface !=""){
						if(file_exists("$ecard_root/resource/invitation_fonts/$fontface")){
							$font2 = "$ecard_root/resource/invitation_fonts/$fontface";
						}
						elseif(file_exists("$ecard_root/resource/invitation_fonts/user_font/$fontface")){
							$font2 = "$ecard_root/resource/invitation_fonts/user_font/$fontface";
						}
						else{
							$font2=$font;
						}
					}
					else{
						$font2=$font;
					}

					if($fontcolor !=""){
						$get_info_text_color = split(",",$fontcolor);
						$text_color=imagecolorallocate($im, $get_info_text_color[0],$get_info_text_color[1],$get_info_text_color[2]);
					}
					else{
						$text_color = $default_text_color;
					}

					$print_text =str_replace($info[0] . "]","",$print_text) ;
				}
				else{
					$text_color = $default_text_color;
					$font2=$font;
					$font_size=$font_size2;
				}
			}
			else{
				$text_color = $default_text_color;
				$font2=$font;
				$font_size=$font_size2;
			}

			$size = imagettfbbox($font_size, 0, $font2, $print_text);
			$long_text = $size[2]+$size[0];
			if ($TEXT_ALIGN =="center"){
				$posx=($image_width-$long_text)/2;
			}
			else{
				$posx=0;
			}

			// Add the text
			imagettftext($im, $font_size, 0, $posx, ($line_height+$line_height*$i)+$extra_line, $text_color, $font2, $print_text);
		}

		header("Content-type: image/png");
		Imagepng($im);
		imagedestroy($im);

	}

	//-----------------------------------------------------------------------------------------
	function get_number($str=""){
		if($str == "A"){
			$myNum = 10;
		}
		else if($str == "B"){
			$myNum = 11;
		}
		else if	($str == "C"){
			$myNum = 12;
		}
		else if($str == "D"){
			$myNum = 13;
		}
		else if($str == "E"){
			$myNum = 14;
		}
		else if($str == "F"){
			$myNum = 15;
		}
		else{
			$myNum = $str;
		}
		return $myNum;
	}

	//-----------------------------------------------------------------------------------------
	function get_RGB($data=""){
		if(!(strpos($data,"#")===false)){
			$data = strtoupper($data);
			$data = str_replace("#","",$data);
			$str_1 = get_number($data{0});
			$str_2 = get_number($data{1});
			$str_3 = get_number($data{2});
			$str_4 = get_number($data{3});
			$str_5 = get_number($data{4});
			$str_6 = get_number($data{5});

			$Red = ($str_1 * 16) + $str_2;
			$Green = ($str_3 * 16) + $str_4;
			$Blue = ($str_5 * 16) + $str_6;

			return $Red . "," . $Green . "," . $Blue;
		}
		else{
			return $data;
		}
	}

?>