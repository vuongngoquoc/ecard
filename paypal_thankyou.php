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
define("ECARDMAX_USER", 1);
require_once ("config.php");
	session_start();
	ob_start();

if (isset($invoice) && ($invoice!="")) {
	$pay_ecqid=$invoice;
}
else {
	$pay_ecqid=$_SESSION[ecqid];
}

header("Location: $ecard_url/index.php?step=paypal_thankyou&pay_ecqid=$pay_ecqid");
ob_end_flush();
?>

