<?php
include 'EpiCurl.php';
include 'EpiOAuth.php';
include 'EpiTwitter.php';
include '../config.php';include '../config2.php';
$twitterObj = new EpiTwitter($cf_consumer_key, $cf_consumer_secret);
$request_link=$twitterObj->getAuthorizationUrl();
//header("Location:$request_link");
echo "<script>";
echo "location.href='$request_link';";
echo "</script>";
?>