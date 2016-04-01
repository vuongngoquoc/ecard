<?php
include 'EpiCurl.php';
include 'EpiOAuth.php';
include 'EpiTwitter.php';
include '../config.php';include '../config2.php';
include '../function.php';
session_start();
$id=$_SESSION[my_cardid];
$twitterObj = new EpiTwitter($cf_consumer_key, $cf_consumer_secret);
//print_r($_SESSION);
//echo "location.href=\"../greetings/index.php?step=sendcard&ec_id=$id\"";exit;
/** TEST **/
/** END TEST **/

if($_SESSION['ec_oauth_token']=="" || $_SESSION['ec_oauth_secret']==""){
	
	$twitterObj->setToken($_GET['oauth_token']);
	$token = $twitterObj->getAccessToken();
	$_SESSION['ec_oauth_token']=$token->oauth_token;
	$_SESSION['ec_oauth_secret']=$token->oauth_token_secret;
	//$ec_user=$_SESSION[ecardmax_user];
	$twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);
	$twitterInfo= $twitterObj->get_accountVerify_credentials();
	$tw_act=$twitterInfo->screen_name;		$_SESSION[twitter_screen_name]="@".$tw_act;
	if($_SESSION[ecardmax_user]!=""){
		update_field_in_db2("max_ecuser","ec_tw_user='$tw_act',ec_oauth_token='$token->oauth_token',ec_oauth_secret='$token->oauth_token_secret'","user_name_id='$_SESSION[ecardmax_user]'");
	}
	$id=$_SESSION[my_cardid];
	echo "<script>";
	echo "location.href=\"$ecard_url/index.php?step=sendcard&ec_id=$id\"";
	echo "</script>";

}else{
	//print_r($_SESSION);
	//echo "existing !";exit;
	$id=$_SESSION[my_cardid];
	//header("Location:$ecard_url/index.php?step=sendcard&ec_id=$id\n");
	//exit;
	echo "<script>";
	echo "location.href=\"$ecard_url/index.php?step=sendcard&ec_id=$id\"";
	echo "</script>";
}
//$twitterObj->setToken($_SESSION[oauth_token], $_SESSION[oauth_token_secret]);	
//$rs= $twitterObj->getUserInfo();
//$params[text]="Hi, Idiot !";
//$params[user]="mrdanhhuynh";
//$rs=$twitterObj->post_statusesUpdate($params);//$twitterObj->updateStatus("My test status");
//$rs=$twitterObj->post_direct_messagesNew($params);//$twitterObj->updateStatus("My test status");
//print_r($rs->response);
//$twitterInfo= $twitterObj->getUserInfo();//get_accountVerify_credentials();
//$twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);
//echo "Your twitter username is {$twitterInfo->screen_name} and your profile picture is <img src=\"{$twitterInfo->profile_image_url}\">";
//$tok = file_put_contents('tok', $token->oauth_token);
//$sec = file_put_contents('sec', $token->oauth_token_secret);
?>