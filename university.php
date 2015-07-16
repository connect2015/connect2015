<?

require_once('config.php');
require_once('function.php');


//大学のidを取得
$id = $_GET['id'];

//データベースに接続
$dbh = connectDb();

//大学情報の取得
$sql['university'] = "select * from universities where id = :id limit 1";
$stmt = $dbh->prepare($sql['university']);
$stmt->execute(array(":id" => $id));
$university = $stmt->fetch();

//ユーザーのpostsを取得(新しい順)
$posts = array();
$sql = "select * from posts where university_id = $id order by modified desc limit 5";
foreach($dbh->query($sql) as $row){
    array_push($posts,$row);
}

//ユーザーのreviewsを取得
$reviews = array();
$sql = "select * from reviews where university_id = $id order by modified desc limit 5";
foreach($dbh->query($sql) as $row){
    array_push($reviews,$row);
}

//カテゴリーの情報読み込み
$categories = array();
$sql = "select * from categories";
foreach ($dbh->query($sql) as $row) {
    array_push($categories, $row);
}

//ユーザーの情報読み込み
$users = array();
$sql = "select * from users where university_id = $id";
foreach ($dbh->query($sql) as $row) {
    array_push($users, $row);
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
        
        <? foreach ($categories as $category) :?>
         data.addRows([
            ['<? echo $category['categoryname'];?>', <? echo $averages[$category['categoryname']];?>]
        ]);
        
        <? endforeach;?>
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

<body id="page-top">

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
                    <a class="navbar-brand" href="<? echo SITE_URL?>">Connect</a>
                </div>
                <div class="navbar-header col-sm-2 text-center">
                    <a class="navbar-brand page-scroll" href="#page-top"><? echo $university['universityname'];?></a>
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
                    <div class="col-sm-5 col-md-6 text-center">
                        <div class="service-box">
                            <div id="chart"></div>
                        </div>
                    </div>
                    <div class="col-sm-5 col-md-6 text-center">
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
                    <? foreach ($reviews as $review): ?>
                        <div class="col-sm-4">
                            <div class="thumbnail">
                                <a href=""><img src="images/168bd8802ac6de1a2515f9df0ad37e937ee45825jpg" alt=""></a>
                                <div class="caption">
                                    <h3 class="text-center">
                                        <a href="user.php?id=<? echo $review['user_id']; ?>">
                                            <? 
                                            $a = getuser($review['user_id']);
                                            echo $a['username'];
                                            ?>   
                                        </a>
                                    </h3>
                                    <h2 class="text-center" style="background-color:#191970" style="padding:5px">
                                        <a style="color:white" href="user.php?id=<? echo $review['category_id'] ?>">
                                            <?
                                            $b = getcategory($review['category_id']);
                                            echo $b['categoryname'];
                                            ?>
                                        </a>
                                    </h2>
                                    <p><? echo $review['body']; ?></p>
                                </div>
                            </div>
                         </div>
                     <? endforeach; ?>
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
                            <? echo $post['title'] ?>　by
                            <a href="user.php?id=<? echo $post['user_id']; ?>">
                                <?

                                $c = getuser($post['user_id']);
                                echo $c['username'];
                                ?>
                            </a>
                            <span style="float:right">
                                <?php echo " posted on ". $post['created'];?>
                            </span>
                        </div>
                        <div class="panel-body" style="color:#191970">
                            <? echo $post['body']?>
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
                    <? foreach ($users as $user) : ?>
                    <div class="col-sm-3 text-center">
                        <i class="fa fa-user fa-5x wow bounceIn"></i>
                        <p>
                            <a href="user.php?id=<? echo $user['id']?>">
                                <? echo $user['username']?>
                            </a>
                        </p>
                    </div>
                <? endforeach; ?>
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
