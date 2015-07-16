<?php

require_once('config.php');
require_once('function.php');


//大学のidを取得
// $id = $_GET['id'];
$id = 1;

//データベースに接続
$dbh = connectDb();

//大学情報の取得
$sql['university'] = "select * from universities where id = :id limit 1";
$stmt = $dbh->prepare($sql['university']);
$stmt->execute(array(":id" => $id));
$university = $stmt->fetch();

//ユーザー一覧の取得
$users = array();
$sql = "select * from users where university_id = $id";
foreach($dbh->query($sql) as $row){
    array_push($users,$row);
}

//ユーザーのpostsを取得(新しい順)
$posts = array();
$sql = "select * from posts where university_id = $id order by modified desc limit 5";
foreach($dbh->query($sql) as $row){
    array_push($posts,$row);
}
var_dump($posts);

//ユーザーのreviewsを取得
$reviews = array();
$sql = "select * from reviews where university_id = $id order by modified desc limit 5";
foreach($dbh->query($sql) as $row){
    array_push($reviews,$row);
}

//ユーザーとreviewの情報をひもづける
$a = array();
foreach($reviews as $review){
    $sql = "select * from users where id =".$review['user_id'];
    $stmt = $dbh->query($sql);
    $b = $stmt->fetch(); //ユーザーの情報のarray
    $row = array_merge($review, $b);
    array_push($a, $row);
}
$reviews = $a;

//カテゴリーの情報読み込み
$categories = array();
$sql = "select * from categories";
foreach ($dbh->query($sql) as $row) {
    array_push($categories, $row);
}

//平均点の算出
$averages = array();
foreach ($categories as $category) :
$sum = 0;
$scorenumber = 0;
foreach ($reviews as $review):
if ($review['category_id'] == $category['id']){
$sum = $sum + $review['score'];
$scorenumber = $scorenumber + 1;
}
endforeach;
$average = $sum / $scorenumber;
$newaverage = array($category['categoryname']=>$average);

$averages = array_merge($averages,$newaverage);
endforeach; 

?>


<!DOCTYPE html>
<html lang="en">
<script src="https://www.google.com/jsapi"></script>
<script>
    google.load('visualization', '1.0', {'packages':['corechart']});
    google.setOnLoadCallback(drawChart);
    
    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'カテゴリー');
        data.addColumn('number', 'スコア');
        
        <?php foreach ($categories as $category) :?>
         data.addRows([
            ['<?php echo $category['categoryname'];?>', <?php echo $averages[$category['categoryname']];?>]
        ]);
        
        <?php endforeach;?>
        // グラフのオプションを指定する
        var options = {
            title: 'ゲント大学スコア',
            width: 300,
            height: 200
        };

        // 描画する
        var chart = new google.visualization.ColumnChart(document.getElementById('chart'));
        chart.draw(data, options);
    }
</script>

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

<body id="top">

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="row">
                <div class="navbar-header col-sm-5">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand page-scroll" href="">Connect</a>
                </div>
                <div class="navbar-brand topnav" id="bs-example-navbar-collapse-2 col-sm-2　text-center">
                    <a class="page-scroll" href="#top"><? echo $university['universityname'] ?></a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1  col-sm-5">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a class="page-scroll" href="#score">Score</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#review">Review</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#blog">Blog</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#student">Student</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <header>
        <div class="header-content">
            <h1><? echo $university['universityname'] ?></h1>
            <br>
            <br>
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 col-xs-6 text-center" >
                        <a href="#score" class="btn btn-primary btn-xl wow tada page-scroll" style="margin:10px">Score</a>
                    </div>
                    <div class="col-sm-3 col-xs-6 text-center">
                        <a href="#review" class="btn btn-primary btn-xl wow page-scroll" style="margin:10px">Review</a>
                    </div>
                    <div class="col-sm-3 col-xs-6 text-center">
                        <a href="#blog" class="btn btn-primary btn-xl wow tada page-scroll" style="margin:10px">Blog</a>
                    </div>
                    <div class="col-sm-3 col-xs-6 text-center">
                        <a href="#student" class="btn btn-primary btn-xl wow tada page-scroll" style="margin:10px">Student</a>
                    </div>           
                </div>
            </div>
        </div>
    </header>

<!-- score -->
    <section id="score" style="padding:0px">
        <aside class="bg-primary">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="section-heading">Score</h2>
                        <hr class="light">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-6 text-center">
                        <div class="service-box">
                            <div id="chart"></div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 text-center">
                        <div class="service-box">
                            <i class="fa fa-4x wow bounceIn text-primary" data-wow-delay=".1s" style="color:white">
                                <p>カテゴリ</p>
                                <p>項目1</p>
                                <p>項目2</p>
                                <p>項目3</p>
                                <p>項目4</p>
                                <p>項目5</p>
                                <p>項目6</p>
                                <p>項目7</p>
                                <p>項目8</p>
                            </i>
                        </div>
                    </div>
                </div>
            </div>
         </aside>
     </section>
    

<!-- Review -->
    <aside class="bg-default">
        <section class="no-padding" id="review">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="section-heading">Review</h2>
                        <hr class="primary">
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">

                    <? foreach ($categories as $category):?>
                    <div class="col-sm-3 col-xs-6 text-center" >
                        <a href="#" class="btn btn-primary btn-xl wow tada" style="margin:10px"><? echo $category['categoryname']; ?></a>
                    </div>
                    <? endforeach; ?>

                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <p>　</p>
                        <h2>Pickup Review</h2>
                        <hr class="primary">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <? foreach($posts as $post) : ?>
                        <i class="fa fa-user fa-5x wow col-sm-5 text-center"></i>
                        <div class="balloon-wrapper col-sm-7 text-left">
                            <div class="row">
                                <? 
                                $i = 0;

                                while ($i == count($posts)) {
                                    echo $i;
                                    if($i == $review[$i]['category_id']) {
                                        break;
                                    }
                                    $i++;
                                }
                                ?>
                                <p class="col-sm-7 text-left" style="margin:0px"><? echo $categories[$i-1]['categoryname']?></p>
                                <p class="col-sm-3 text-right" style="margin:0px">2015/7/15</p>
                            </div>
                            <p class="balloon-left">
                                <? echo $post['category_id']; ?>

                            </p>
                        </div>
                    <? endforeach ; ?>
                </div>
            </div>
        </section>
    </aside>

<!-- Blog -->
<aside class="bg-primary" style="padding:0px">
    <section id="blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Blog</h2>
                    <hr class="light">
                </div>
            </div>
        </div>
        <? foreach($posts as $post) :?>
        <div class="container">
            <div class="row">
                <div class=" col-sm-8 col-sm-offset-2">
                    <div class="panel panel-primary"> 
                        <div class="panel-heading" >
                            <? echo $post['title'] ?>
                            <span style="float:right">by 
                                <a href=""></a>
                            </span>
                        </div>
                        <div class="panel-body" style="color:#191970">本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    <? endforeach;?>
    </section>
</aside>

<!-- Student -->
    <section class="no-padding" id="student">
       <aside class="bg-default">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 text-center">
                        <h2 class="section-heading">Student</h2>
                        <hr class="primary">
                        <p>you can contact them</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 text-center">
                        <i class="fa fa-user fa-5x wow bounceIn"></i>
                        <p>名前</p>
                    </div>
                    <div class="col-sm-3 text-center">
                        <i class="fa fa-user fa-5x wow bounceIn"></i>
                        <p>名前</p>
                    </div>
                    <div class="col-sm-3 text-center">
                        <i class="fa fa-user fa-5x wow bounceIn"></i>
                        <p>名前</p>
                    </div>
                    <div class="col-sm-3 text-center">
                        <i class="fa fa-user fa-5x wow bounceIn"></i>
                        <p>名前</p>
                    </div>
                    <div class="col-sm-3 text-center">
                        <i class="fa fa-user fa-5x wow bounceIn"></i>
                        <p>名前</p>
                    </div>
                    <div class="col-sm-3 text-center">
                        <i class="fa fa-user fa-5x wow bounceIn"></i>
                        <p>名前</p>
                    </div>
                    <div class="col-sm-3 text-center">
                        <i class="fa fa-user fa-5x wow bounceIn"></i>
                        <p>名前</p>
                    </div>
                    <div class="col-sm-3 text-center">
                        <i class="fa fa-user fa-5x wow bounceIn"></i>
                        <p>名前</p>
                    </div>
                </div>
            </div>
        </aside>
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

</body>

</html>
