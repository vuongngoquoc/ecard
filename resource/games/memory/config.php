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
|   Time: Wendnesday, 22 Steptember 2004 05:08 PM - Pacific Time
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
	$home_root ="$ecard_root/resource/games/memory";

	# Insert the Keycode to remove ePhotoHunt Logo & Link back to ePhotoHunt.com website.
	# Please come here to buy the Keycode : http://ePhotoHunt.com/buy.php
	$Keycode ="$cf_ephotohunt_keycode";

	#-------------------------------------------------------------------------------------------

	# Enter your own number here - You must change it
	$security_code ="12432523";

	# The Gamne won't run if you modify the credit below
	$Credit ="Memory Game by http://www.ePhotoHunt.com";

	# Email subject to player
	$subject ="You're not on the Memory Game High Score Board.";

	# Change Text message to your language here
	$Game_over ="GAME OVER.";

	$Loading_new_image ="<font color=red size=3>Loading new images<br>Please wait<br>...</font>";

	$Repeat_now ="Repeat Now";

	$Congratulations = "You must have a computer brain. Congratulations!";

	$Watch ="Watch";

?>