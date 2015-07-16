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


//登録処理
if($_SERVER['REQUEST_METHOD'] != 'POST'){
// CSRF対策
    //setToken();
}else{
    //checkToken();

    $username = $_POST['username'];
    $email = $_POST['email'];
    $university_id = $_POST['university_id'];
    $self_introduction = $_POST['self_introduction'];
    $japanese_university = $_POST['japanese_university'];
    $study_start = $_POST['study_start'];
    $study_finish = $_POST['study_finish'];
    $study_grade = $_POST['study_grade'];
    $study_major = $_POST['study_major'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    

    $dbh = connectDb();


    $sql = 'Insert into users
        (username, email, university_id, self_introduction, japanese_university,
            study_start, study_finish, study_grade, study_major, birthday, gender, created, modified) 
        values
        (:username, :email, :university_id, :self_introduction, :japanese_university,
            :study_start, :study_finish, :study_grade, :study_major, :birthday, :gender, now(),now())';


    $sql="insert into users (username,gender) values(:username,:gender);";
    $stmt = $dbh->prepare($sql);

    $params = array(
        ':username'=> $username,
        /*':email'=>$email,
        ':university_id'=>$university_id,
        ':self_introduction'=> $self_introduction,
        ':japanese_university'=>$japanese_university,
        ':study_start'=>$study_start,
        ':study_finish'=> $study_finish,
        ':study_grade'=>$study_grade,
        ':study_major'=>$study_major,
        ':birthday'=> $birthday,*/
        ':gender'=>$gender
        );

    $stmt->execute($params);
    // $sql="select * from users;";
    
    // $stmt=$dbh->prepare($sql);
    
    var_dump($stmt->execute($params));
    
   

exit;

}



?>




<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Connect</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">

    <!-- Custom Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" type="text/css">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="css/animate.min.css" type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/creative.css" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container" style="padding:20px 0">
    
          <form class="form-horizontal" style="margin-bottom:15px;" action="" method="post">
            
            <div class="form-group">
              <label class="control-label col-sm-2" for="username">お名前</label>
              <div class="col-sm-6">
                <input type="text" name="username" class="form-control" placeholder="name">
              </div>
              <div class="col-sm-1">
                <h4><span class="label label-danger">必須</span></h4>
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-2" for="email">Eメール</label>
              <div class="col-sm-6">
                <input type="text" name="email" class="form-control" placeholder="email">
              </div>
              <div class="col-sm-1">
                <h4><span class="label label-danger">必須</span></h4>
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-2" for="university">留学先大学</label>
              <div class="col-sm-6">

                <select name="university_id" class="form-control">
                <option>未定</option>
                <?php foreach ($universities as $university) : ?>
                <option value="<?php echo $university['id']; ?>"><?php echo h($university['universityname']); ?></option>
                <?php endforeach; ?>
                </select>
              </div>
              <div class="col-sm-1">
                <h4><span class="label label-danger">必須</span></h4>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-2" for="japanese_university">日本の出身大学</label>
              <div class="col-sm-6">
                <input type="text" name="japanese_university" class="form-control" placeholder="japanese_university">
              </div>
            </div>
            
            
            <div class="form-group">
              <label class="control-label col-sm-2" for="self_introduction">自己紹介文</label>
              <div class="col-sm-6">
                <input type="text" name="self_introduction" class="form-control" placeholder="400字以内で記入" style="height:200px;">
              </div>
            </div>
            <!-- Email-->
            <div class="form-group">
              <label class="control-label col-sm-2" for="study_start">留学開始日</label>
              <div class="col-sm-6">
                <input type="date" name="study_start" class="form-control">
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-2" for="study_finish">留学終了日</label>
              <div class="col-sm-6">
                <input type="date" name="study_finish" class="form-control">
              </div>
            </div>
            
            <!-- Email-->
            <div class="form-group">
              <label class="control-label col-sm-2" for="study_grade">留学時の学年</label>
              <div class="col-sm-6">
                <select name="study_grade" class="form-control">
                <option value="学部１年">学部１年</option>
                <option value="学部２年">学部２年</option>
                <option value="学部３年">学部３年</option>
                <option value="学部４年">学部４年</option>
                <option value="修士１年">修士１年</option>
                <option value="修士２年">修士２年</option>
                <option value="ドクター・研究員">ドクター・研究員</option>
                </select>  
              </div>
            </div>
            <!-- Email-->
            <div class="form-group">
              <label class="control-label col-sm-2" for="study_major">留学時の専攻</label>
              <div class="col-sm-6">
                <input type="text" name="study_major" class="form-control" placeholder="study_major">
              </div>
            </div>
            <!-- Email-->
            <div class="form-group">
              <label class="control-label col-sm-2" for="birthday">生年月日</label>
              <div class="col-sm-6">
                <input type="date" name="birthday" class="form-control" placeholder="birthday">
              </div>
            </div>
            <!-- Email-->
            <div class="form-group">
              <label class="control-label col-sm-2" for="gender">性別</label>
              <div class="col-sm-6">
                <select name="study_grade" class="form-control">
                <option value="男性">男性</option>
                <option value="女性">女性</option>
                </select> 
            　</div>
            　<div class="col-sm-1">
                <h4><span class="label label-danger">必須</span></h4>
              </div>
            
            </div>
            
            <div class="form-group">
              <div class="col-sm-offset-7 col-sm-2">
                <input type="submit" value="submit" class="btn btn-primary">
              </div>
            </div>
          </form>
     
    </div>
    




    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/jquery.fittext.js"></script>
    <script src="js/wow.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/creative.js"></script>
    <script src="connect.js"></script>
   
</body>

</html>
