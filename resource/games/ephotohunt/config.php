<?php
	/*
+--------------------------------------------------------------------------
|
|	WARNING: REMOVING THIS COPYRIGHT HEADER IS EXPRESSLY FORBIDDEN
|
|   ePHOTOHUNT GAME 2005 Full Version
|   ========================================
|   by Khoi Hong webmaster@cgi2k.com
|   (c) 1999 - 2004 CGI2K.COM - All right reserved 
|   http://www.cgi2k.com 
|   ========================================
|   Web: http://www.ephotohunt.com
|   Time: Feb 11 2005 05:08 PM - Pacific Time
|   Email: webmaster@ephotohunt.com
|   Purchase Info: http://www.ephotohunt.com/buy
|   Request Installation: http://www.ephotohunt.com/efeedback/efeedbackV4.php?install
|
|   > Script file name: config.php
|   > Script written by Khoi Hong
|   > Date started: July 07 2004
|	
|	WARNING //--------------------------
|
|	Selling the code for this program without prior written consent is expressly forbidden. 
|	This computer program is protected by copyright law. 
|	Unauthorized reproduction or distribution of this program, or any portion of if,
|	may result in severe civil and criminal penalties and will be prosecuted to 
|	the maximum extent possible under the lzaw.
+--------------------------------------------------------------------------
*/	
	require_once("../../../config.php");
	require_once("../../../config2.php");

	# Your website URL
	$mysite = $ecard_url;
	
	# URL of ePhotoHunt game
	$home_url ="$ecard_url/index.php?step=play_games";

	# Server path to folder game
	$home_root ="$ecard_root/resource/games/ephotohunt";
	
	#Your email address
	$webmaster_email ="webmaster@ephotohunt.com";

	# Insert the Keycode to remove ePhotoHunt Logo & Link back to ePhotoHunt.com website.
	# Please come here to buy the Keycode : http://ePhotoHunt.com/buy.php
	$Keycode ="$cf_ephotohunt_keycode";

	#-------------------------------------------------------------------------------------------

	# Date install the ePhotoHunt (use for Counter)
	$date_install_ephotohunt ="Dec 01, 2004";

	# New special feature: The Game will random to scare the player by showing off the ghost face + scary sound. Say "yes" if you want to enable this feature. 
	$scare_player ="yes"; 

	# The Gamne won't run if you modify the credit below
	$Credit ="PhotoHunt Game by http://www.ePhotoHunt.com";

	# Tun ON or OFF banner ad
	$turn_banner ="ON" ; # or OFF

	# Tun ON or OFF music level
	$turn_music_level ="ON" ; # or OFF

	# Email subject to player
	$subject ="You're not on the PhotoHunt High Score Board.";

	# Time Bonus: Player will get extra point if he plays fast.
	# For example player found 5 spots in 20 seconds - The script will add extra point like this: 
	# ROUND [(100 sec - 20 sec) * $extra_point_time_bonus / 1000]
	$extra_point_time_bonus = 20 ; #


	# Timer bar will goes faster when user hit to the wrong spot
	$timer_wrong_hit = 2 ; # Max = 5

	# Score add if player click to the right spot
	$score_add = 500;

	# Score deduct if player click to the wrong spot
	$score_deduct = 200;

	# Score deduct if player use Hint
	$score_deduct_hint = 100;

	# Score will be added for each level if hint unused (Bonus point for player)
	$score_add_unused_hint = 100;

	# Score limit 1 & timer limit 1.
	# This mean if player's score < = 10000 then they will have 90 seconds to find all the spots
	$score_limit_1 = 10000;
	$timer_limit_1 = 2250 ; # 90 seconds 2250

	# Score limit 2 & timer limit 2.
	# This mean if player's score > 10000 and less than 15000 then they will have 85 seconds to find all the spots
	$score_limit_2 = 15000;
	$timer_limit_2 = 2125 ;

	# Score limit 3 & timer limit 3.
	$score_limit_3 = 20000;
	$timer_limit_3 = 2000 ; # 80 seconds

	# Score limit 4 & timer limit 4.
	$score_limit_4 = 25000;
	$timer_limit_4 = 1875 ; # 75 seconds

	# Score limit 5 & timer limit 5.
	$score_limit_5 = 30000;
	$timer_limit_5 = 1750 ; # 70 second

	# Score limit 6 & timer limit 6.
	$score_limit_6 = 35000;
	$timer_limit_6 = 1625 ; # 65 seconds

	# Score limit 7 & timer limit 7. 
	$score_limit_7 = 40000;
	$timer_limit_7 = 1500 ; # 60 seconds

	# Score limit 8 & timer limit 8. 
	$score_limit_8 = 45000;
	$timer_limit_8 = 1375 ; # 55 seconds 

	# Score limit 9 & timer limit 9. 
	$score_limit_9 = 50000;
	$timer_limit_9 = 1250 ; # 50 seconds

	# Score limit 10 & timer limit 10. 
	$score_limit_10 = 55000;
	$timer_limit_10 = 1125 ; # 45 seconds 

	# Score limit 11 & timer limit 11.
	$score_limit_11 = 60000;
	$timer_limit_11 = 1000 ; # 40 seconds 

	# Score limit 12 & timer limit 12. 
	$score_limit_12 = 65000;
	$timer_limit_12 = 875 ; # 35 seconds 

	# You can adjust the X , Y of the Red circle mark here if you don't see it show up right position.
	$Red_X = 0;
	$Red_Y = 165;

	# Change PopUp message to your language here
	$GAME_OVER ="GAME OVER MAN - GAME OVER";

	$CHECK_HINT_THEN_HIT_OK ="Check the black circle mark then hit OK to continue.";
?>