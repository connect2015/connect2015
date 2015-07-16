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
                <a class="navbar-brand page-scroll" href="#page-top">Connect</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" margin-right:10px>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="#about">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#services">Services</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#universities">Universities</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#about-us">About us</a>
                    </li>
                    <li>
                        <fb:login-button scope="public_profile,email" onlogin="checkLoginState();" auto_logout_link="true" >
                        </fb:login-button>
                    </li>
                </ul>
                    
            </div>
            <!-- /.navbar-collapse -->
            <div>

                
            </div>
        </div>
        <!-- /.container-fluid -->
    </nav>

    <header>
        <div class="header-content">
            <div class="header-content-inner">
                <h1>Connect</h1>
                <hr>
                <p>海外留学生のための海外大学のレビュー、コミュニティーサイト</p>
                <a href="#universities" class="btn btn-primary btn-xl page-scroll">対象大学一覧へ</a>
            </div>
        </div>
    </header>

    <section class="bg-primary" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">What is Connect?</h2>
                    <hr class="light">
                    <p class="text-faded">Connectは海外大学のレビューサイトです。留学経験者がその経験を書き込み、留学を考えている学生がその情報を参照する事ができます。留学してみたいけど、どこの大学に申し込むか決められない。という方は大勢いらっしゃると思います。またその大学に留学した人の意見を聞いてみたいと思うと思います。Connectはそんな課題を解決する事を目指しています。</p>
                    <a href="#services" class="btn btn-default btn-xl">サービス内容へ</a>
                </div>
            </div>
        </div>
    </section>

    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Our Services</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-user-plus wow bounceIn text-primary"></i>
                        <h3>留学経験者向け機能</h3>
                        <ul>
                            <li>留学の体験レビューの書き込み</li>
                            <li>留学のBlog投稿</li>
                            <li>留学の相談に乗る</li>
                        </ul>
                        <p class="text-muted">留学経験者の皆様には、ぜひConnectを通じて、その貴重な体験をシェアしていただきたいと思っています。あたなの貴重な体験を必要としている人は大勢います。またConnectを通してご自身の留学の記録として活用していただければと思います。<br>
                        具体的には、与えられた項目に対してスコアとご自身の意見を書いていく、”レビュー書き込み”。そして、留学期間中のBlog投稿としても活用できます。留学を通して感じたことを書き溜め、留学の興味のある人にだけみてもらうことができます。また、Connectを通じてご自身の経験をもとに、留学に関する相談にのっていただけたらと思います。
                        </p>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-users wow bounceIn text-primary" data-wow-delay=".1s"></i>
                        <h3>留学を検討している方向け機能</h3>
                        <ul>
                            <li>海外大学の比較</li>
                            <li>留学体験者への相談</li>
                        </ul>
                        <p class="text-muted">留学に行きたいと思っても、どこの大学に留学するかについて悩むことがあると思います。そんな時は、留学の先輩たちに聞くことが一番です。文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章文章</p>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <section class="bg-primary" id="universities">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <h2 class="section-heading">掲載留学一覧</h2>
                    <hr class="light">
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="service-box">
                        <h3>アジア</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="service-box">
                        <h3>北米</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="service-box">
                        <h3>ヨーロッパ</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="service-box">
                        <h3>オセアニア</h3>
                        </div>
                    </div>

                    <div>
                            <?php foreach ($universities as $university) :?>
                            <h3>
                            <a href="university.php?id=<?php echo $university['id'];?>" class ="university">
                            <?php echo $university['universityname']; ?></a>
                            </h3>
                            <?php endforeach; ?>
                        
                    </div>
                    
                    
                    <div style="padding: 50px;">
                    <a href="#services" class="btn btn-default btn-xl">お探しの大学がない場合はこちらへ</a>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <section id="about-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">About us</h2>
                    <hr class="primary">
                    <p>Connectは新居航平・萩原大地の二人の大学生によって運営されています。</p>
                </div>
                <div class="col-lg-6 text-center">
                    <h3>新居航平</h3><br>
                    <p>東京工業大学経営システム工学科学部４年<br>
                    2014年9月〜2015年6月までベルギーのゲント大学に交換留学を経験。ゲント大学在学中に、留学に対する情報が散らばりすぎている。と強く問題意識を感じ、独学でプログラミングを学びこのサービスの開発を始める。留学をした人のその貴重な体験が、Conncetを通じて、下の世代に受け継がれていって欲しい。また留学をきっかけとした、先輩・後輩のような助け合える関係性が自然に構築されていくことを願っている。
                    </p>
                </div>
                <div class="col-lg-6 text-center">
                     <h3>萩原大地</h3><br>
                    東京工業大学経営システム工学科学部４年<br>
                    2014年9月〜2015年6月までベルギーのゲント大学に交換留学を経験。ゲント大学在学中に、留学に対する情報が散らばりすぎている。と強く問題意識を感じ、独学でプログラミングを学びこのサービスの開発を始める。留学をした人のその貴重な体験が、Conncetを通じて、下の世代に受け継がれていって欲しい。また留学をきっかけとした、先輩・後輩のような助け合える関係性が自然に構築されていくことを願っている。
                    
                </div>
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
