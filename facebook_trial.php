<?php

require_once('config.php');
require_once('function.php');


use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookJavaScriptLoginHelper;

  require '/Applications/MAMP/htdocs/connect2015/facebook-php-sdk-v4/autoload.php';

  FacebookSession::setDefaultApplication(APP_ID, APP_SECRET);

  // Add `use Facebook\FacebookJavaScriptLoginHelper;` to top of file
  $helper = new FacebookJavaScriptLoginHelper();
  try {
    $session = $helper->getSession();
  } catch(FacebookRequestException $ex) {
    // When Facebook returns an error
  } catch(\Exception $ex) {
    // When validation fails or other local issues
  }
  if ($session) {
    // Logged in
  }

  //var_dump($session);


  if($session) {
    try {
      $user_profile = (new FacebookRequest(
        $session, 'GET', '/me'
      ))->execute()->getGraphObject(GraphUser::className());
      $username = $user_profile->getName();    
      $user_url = $user_profile->getLink();
      $facebook_id = $user_profile->getId();
      
      //新規登録されてるかチェック
      $dbh = connectDb();
      //ユーザーがいなかったなら・・・
      if(!userExist($facebook_id,$dbh)){
      
        //新規登録処理ページへ飛ぶ
        //header('Location:'.SITE_URL.'signup.php');
      }
      

    } catch(FacebookRequestException $e) {
      echo "Exception occured, code: " . $e->getCode();
      echo " with message: " . $e->getMessage();
    }   
  }





var_dump($username);
var_dump($facebook_id);
var_dump($session);


?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>Top</title>
</head>
<body>

<fb:login-button scope="public_profile,email" onlogin="checkLoginState();" auto_logout_link="true">
</fb:login-button>

<div id="status">
</div>

<div id="status2">
</div>


<div id="profile">
</div>

<a href="<?php echo $user_url; ?>">userpage</a>

<div class="fb-comments" data-href="http://localhost/facebook_login/facebook.php" data-version="v2.3"></div>

<div class="fb-like" data-href="http://localhost/facebook_login/trial.php" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>

</body>
</html>

