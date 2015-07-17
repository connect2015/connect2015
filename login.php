<?php
session_start();
require_once __DIR__ . '/facebook-php-sdk-v4-5.0-dev/src/Facebook/autoload.php';


$fb = new Facebook\Facebook([
  'app_id' => '436865333162259',
  'app_secret' => 'e5734ceef09b1e70dbaea90660ede073',
  'default_graph_version' => 'v2.3',
  ]);


$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://localhost/connect2015/signup.php', $permissions);


echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
?>