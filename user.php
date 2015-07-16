 <?php 
require_once('config.php');
require_once('function.php');

//データベースに接続
$dbh = connectDb();

//ユーザーのidを取得
//$id = $_GET['id'];
$id = 1;



//ユーザー一覧の取得
$sql= "select * from users where id = :id limit 1";
$stmt = $dbh->prepare($sql);
$stmt->execute(array(":id" => $id));
$user = $stmt->fetch();

//所属大学情報の取得
$sql = "select * from universities where id = :id limit 1";
$stmt = $dbh->prepare($sql);
$stmt->execute(array(":id" => $user['university_id']));
$university = $stmt->fetch();

//そのユーザーのpostsを取得(新しい順)
$posts = array();
$sql = "select * from posts where user_id = $id order by modified desc limit 10";
foreach($dbh->query($sql) as $row){
    array_push($posts,$row);
}

//そのユーザーのreviewsを取得
$reviews = array();
$sql = "select * from reviews where user_id = $id";
foreach($dbh->query($sql) as $row){
    array_push($reviews,$row);
}

//そのユーザーの写真を取得
$images = array();
$sql = "select * from images where user_id = $id";
foreach($dbh->query($sql) as $row){
    array_push($images,$row);
}


//カテゴリーの情報読み込み
$categories = array();
$sql = "select * from categories";
foreach ($dbh->query($sql) as $row) {
    array_push($categories, $row);
}

//var_dump($reviews);

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
    <link rel="stylesheet" href="css/new_creative.css" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://www.google.com/jsapi"></script>
<script>
    google.load('visualization', '1.0', {'packages':['corechart']});
    google.setOnLoadCallback(drawChart);
    
    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'カテゴリー');
        data.addColumn('number', 'スコア');
        
        <?php foreach ($categories as $category) :?>

        <?php 
        foreach ($reviews as $review) {
            if($category['id']==$review['category_id']){
            $score = $review['score'];
        }
        }
        ?>
         data.addRows([
            ['<?php echo $category['categoryname'];?>', <?php echo $score;?>]
        ]);
        
        <?php endforeach;?>
        // グラフのオプションを指定する
        var options = {
            title: "<?php echo $user['username'];?>"+"のスコアグラフ",
            width: 300,
            height: 300
        };

        // 描画する
        var chart = new google.visualization.ColumnChart(document.getElementById('chart'));
        chart.draw(data, options);
    }

</script>



</head>

<body id="page-top">

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="index.php">Connect</a>
            </div>

            <div class="nav　navbar-nav navbar-center">
                <a class="navbar-brand page-scroll" href="#page-top"><?php echo $user['username'];?></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" margin-right:10px>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="#page-top">profile</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#review">review</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#blog">blog</a>
                    </li>
                </ul>
                    
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <header>
        <div class="header-content">
            <div class="header-content-inner">
                <div>
                    <img src="kohei.jpg" width="200px" height="180px">
                </div>
                <!--
                <h1><?php echo $user['username'];?></h1>
                <hr>
                
                <div class="container" >
                    <div clsss="row">    
                        <div class="col-sm-6">
                        <p>留学先大学：</p>
                        <p>留学期間：</p>
                        <p>留学時の学年：</p>
                        <p>留学時の専攻：</p>
                        </div>
                        <div class="col-sm-6">
                        <p>性別：</p>
                        <p>生年月日：</p>
                        <p>自己紹介文：</p>
                        </div>
                    </div>
                </div>
                -->
                <div class="panel panel-default">
                  <!-- Default panel contents -->
                  <div class="panel-heading"><?php echo $user['username'];?></div>
                  <div class="panel-body">
                    <p>自己紹介文：</p>
                  </div>

                  <!-- List group -->
                  <ul class="list-group">
                    <li class="list-group-item">留学先大学：</li>
                    <li class="list-group-item">留学期間：</li>
                    <li class="list-group-item">留学時の学年：</li>
                    <li class="list-group-item">留学時の専攻：</li>
                    <li class="list-group-item">性別：</li>
                  </ul>
                </div>



                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 text-center">
                        <a href="#review" class="btn btn-primary btn-xl page-scroll">レビュー一覧へ</a>
                        </div>

                        <div class="col-sm-6 text-center">
                        <a href="#blog" class="btn btn-primary btn-xl page-scroll">ブログ一覧へ</a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </header>

    <section class="bg-primary" id="review">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Review</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-5 col-sm-offset-1 text-center">
                    <div id="chart" class="pull-right"　style="margin:10px;"></div>                    
                </div>
                <div class="col-sm-5 text-center">
                    <h3>スコア項目</h3>
                    <table class="table table-bordered table-hover bg-info">
                        <thead>
                          <tr><th>スコア項目</th><th>内容</th></tr>
                        </thead>
                        <tbody>
                          <tr><td>city</td><td>町の様子</td></tr>
                          <tr><td>university</td><td>大学の質など</td></tr>
                          <tr><td>food</td><td>ご飯について</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="container" style="margin-top:30px;">
            <div class="row">
                <?php foreach ($reviews as $review) :?>
                <div class="col-sm-5 col-sm-offset-1 text-center">
                    <div class="panel panel-primary">
                        <div class="panel-heading">

                            <?php 
                            foreach ($categories as $category) {
                            if($category['id']==$review['category_id']){
                                echo $category['categoryname'];
                            }
                            }?>
                            
                        </div>
                        <div class="panel-body panel-color">
                          <?php echo $review['body'];?>
                        </div>
                        <hr class="primary">
                        <div class="fb-comments" data-href="http://localhost/connect2015/post.php?id=1" data-version="v2.3" data-width="300"></div>
                        <div class="fb-like" data-href="http://localhost/facebook_login/trial.php" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"　></div>
                    </div>
                </div>
                <?php endforeach;?>   
                
                
            </div>
        </div>
    </section>

    <section id="blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Blog</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text-center">
                    <?php foreach ($posts as $post):?>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                          <span class="text-center"><?php echo $post['title'];?></span>
                          <span style="float:right"><?php echo " posted on ". $post['created'];?></span>
                        </div>
                        <div class="panel-body"> 
                          <?php echo $post['body'];?>  
                        </div>
                        <hr class="primary">
                        <div class="fb-comments" data-href="http://localhost/connect2015/post.php?id=1" data-version="v2.3"></div>
                        <div class="fb-like" data-href="http://localhost/facebook_login/trial.php" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>

                    </div>
                    
                    <?php endforeach;?>
                                   
            </div>
        </div>
    </section>

    
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
