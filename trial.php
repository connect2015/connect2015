 <?php 
require_once('config.php');
require_once('function.php');

//データベースに接続
$dbh = connectDb();

//universityの情報を取得
$universities = array();
$sql = "select * from universities";
foreach($dbh->query($sql) as $row){
    array_push($universities,$row);
}

//var_dump($universities);
?>

<html>
<head>
</head>
<body>
<ul>
                            <?php foreach ($universities as $university) :?>
                            <li>
                            <a href="university.php?id=<?php echo $university['id'];?>">
                            <?php echo $university['universityname']; ?></a>
                            </li>
                            <?php endforeach; ?>
                        </ul>

<fb:login-button scope="public_profile,email" onlogin="checkLoginState();" auto_logout_link="true">
</fb:login-button>
</body>


                        </html>