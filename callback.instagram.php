<?php
/*
https://api.instagram.com/oauth/authorize/?client_id=f3e12f85a4884e07ae96264b49aae3ee&redirect_uri=http://shirtgraph.com/callback.instagram.php&response_type=code
*/
session_start();

require_once('config.php');

//get access token
$url = 'https://api.instagram.com/oauth/access_token';
$data = array_merge($instagram_config, array('code' => urlencode($_REQUEST['code'])));

//open connection
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_POST, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, $data);

//execute post
$token = json_decode(curl_exec($ch), true);
//close connection
curl_close($ch);

$_SESSION['InstagramAccessToken'] = $token['access_token'];

header('Location: index.php?step=1');
die();
?>
