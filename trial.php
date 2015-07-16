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

<html>

<head>
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
            width: 500,
            height: 500
        };

        // 描画する
        var chart = new google.visualization.ColumnChart(document.getElementById('chart'));
        chart.draw(data, options);
    }

</script>

</head>
<body>

<div id="chart"></div>


<div  style ="background-color:blue; width:200px; height:200px;">
<div style = "background-color:red; width:300px; height:300px;">

</div>

</div>

</body>
</html>