<?php
/*
https://picplz.com/oauth2/authenticate?client_id=5V7W2HQLKMqfkjxWmu8q8wAzKLfJSwkv&response_type=code&redirect_uri=http://shirtgraph.com/callback.picplz.php
*/
session_start();

require_once('config.php');

//get access token
$url = 'https://picplz.com/oauth2/access_token';
$data = array_merge($picplz_config, array('code' => urlencode($_REQUEST['code'])));

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
print_r($token); echo '<hr />';
$_SESSION['PicplzAccessToken'] = urlencode($token['oauth_token']);

$url = 'https://api.picplz.com/api/v2/user.json?id=self&include_pics=1&oauth_token='.urlencode($token['oauth_token']);
$pics = json_decode(file_get_contents($url), true);
print_r($pics);
//header('Location: index.php?step=1');
//die();
?>