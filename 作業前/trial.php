<?php	

//session_start();

require_once('config.php');
require_once('function.php');

}

//CSFR対策
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	$title = '';
	$body = '';
	setToken();

} else {
	checkToken();

	$title = $_POST['title'];
	$body = $_POST['body'];
	$image = $_FILES['image'];


	//postsテーブルに情報を保存
	$dbh = connectDb();
	$sql = "insert into posts 
			(user_id, university_id, title, body, created, modified)
			values
			(:user_id, :university_id, :title, :body, now(), now())";
	$stmt = $dbh->prepare($sql);
	$params = array(
		":user_id" => $_SESSION['me']['id'],
		":university_id" => $_SESSION['me']['university_id'],
		":title" => $title,
		":body" => $body
		);
	$stmt->execute($params);

	echo '<p>投稿が完了しました！</p>';
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>投稿</title>
</head>
<body>

	<h1>投稿</h1>
	<form action="" method="POST" enctype="multipart/form-data">
		<p>タイトル：<input type="text" name="title" value="<?php echo h($title); ?>"><?php echo h($err['title']); ?></p>
		<p>本文：<input type="textarea" name="body" value="<?php echo h($body); ?>"><?php echo h($err['body']); ?></p>
		<p>ファイル：<input type="file" name="image"></p>
		<input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
		<p><input type="submit" value='投稿'></p>
	</form>
</body>
</html>


