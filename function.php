<?php
//use Facebook\FacebookSession;
//use Facebook\FacebookRequest;
//use Facebook\GraphUser;
//use Facebook\FacebookRequestException;
//use Facebook\FacebookJavaScriptLoginHelper;

function connectDb(){
	try {
		return new PDO(DSN, DB_USER, DB_PASSWORD);
	} catch (PDOException $e){
		echo $e->getMessage();
		exit;
	}
}

function h($s) {
	return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

function setToken() {
	$token = sha1(uniqid(mt_rand(), true));
	$_SESSION['token'] = $token;
}

function checkToken() {
	if (empty($_SESSION['token']) || ($_SESSION['token'] != $_POST['token'])) {
		echo "不正な処理が行われました。";
		exit;
	}
}

function emailExist($email, $dbh){
	$sql = "select * from users where email = :email limit 1";
	$stmt = $dbh->prepare($sql);
	$stmt->execute(array(":email" => $email));
	$user = $stmt->fetch();
	return $user ? true : false;
}

function userExist($facebook_id, $dbh){
	$sql = "select * from users where facebook_id = :facebook_id limit 1";
	$stmt = $dbh->prepare($sql);
	$stmt->execute(array(":facebook_id" => $facebook_id));
	$user = $stmt->fetch();
	return $user ? true : false;
}



function getSha1Password($s){
	return (sha1(PASSWORD_KEY.$s));
}

/*
function facebookLogin(){

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



  echo "<script src='connect.js'></script>";
}

facebookLogin();
*/
function getuser($a) {
  $dbh = connectDb();
  $sql = "select * from users where id = ".$a;
  $stmt = $dbh->query($sql);
  $stmt->execute;
  $user = $stmt->fetch();
  return $user;
}

function getcategory($a){
  $dbh = connectDb();
  $sql = "select * from categories where id = ".$a;
  $stmt = $dbh->query($sql);
  $stmt->execute;
  $category = $stmt->fetch();
  return $category;
}

function getuniversity($a){
  $dbh = connectDb();
  $sql = "select * from universities where id = ".$a;
  $stmt = $dbh->query($sql);
  $stmt->execute;
  $university = $stmt->fetch();
  return $university;
}

function getimage($a){
  $dbh = connectDb();
  $sql = "select * from images where id = ".$a;
  $stmt = $dbh->query($sql);
  $stmt->execute;
  $image = $stmt->fetch();
  return $image;
}

function Login(){
session_start();
require_once __DIR__ . '/facebook-php-sdk-v4-5.0-dev/src/Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => APP_ID,
  'app_secret' => APP_SECRET,
  'default_graph_version' => 'v2.3',
  ]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://localhost/connect2015/signup.php', $permissions);
echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
}

