<?php
/**
 * @var mysqli $dbc
 * @var User $user
 */
require_once '../class/User.php';
require_once '../dataBase/mysqli_connect.php';
session_start();
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: loginServer.php');
    exit;
}
$user=$_SESSION['user'];
$name=$_GET['name'];
$cinema=getMovie($dbc,$name);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>电影详情</title>
    <script src="../../static/js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="../../static/css/meyer.css">
    <link rel="stylesheet" href="../../static/css/cinemaDetails.css">
    <link rel="stylesheet" href="../../static/icon/iconfont.css">
</head>
<body>
<div class="header">
    <div class="greet">
        <?php echo 'Hello,'.$user->getUsername(); ?>
    </div>
</div>
<div class="content">
    <div class="cinema-name">
        <?php echo $name; ?>
    </div>
    <div class="cinema-box">
        <div class="left">
            <img src="../../<?php echo getImages($dbc,$name)?>" alt="加载失败">
        </div>
        <div class="middle">
            <?php
            addCinemaItems('电影名称:',$cinema[1]);
            addCinemaItems('上映时间:',$cinema[2]);
            addCinemaItems('导演:',$cinema[3]);
            addCinemaItems('制片国家/地区:',$cinema[4]);
            addCinemaItems('电影时长:',$cinema[5].'分钟');
            ?>
        </div>
        <div class="right">
            <div class="title">
                评分
            </div>
            <div class="score">
                7.2
            </div>
            <div class="stars">
            </div>
        </div>
    </div>
    <div class="clearfix">
        <div>
            <span>评价:</span>
            <div class="stars" id="stars">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
            </div>
        </div>

    </div>
    <div class="cinema-introduce">
        <div class="title">电影简介:</div>
        <div class="introduce-content"><?php echo $cinema[6]?></div>
    </div>
    <div class="commits-box">

    </div>
</div>
</body>
<script src="../../static/js/jquery-3.7.1.min.js"></script>
<script src="../../static/js/cinemaDetails.js"></script>
</html>

<?php
function getImages($dbc,$name){
    $result=safeSelectQuery($dbc,
        'select * from images where name=?',
        [$name]);
    return $result->fetch_row()[1];
}
function getMovie($dbc,$name){
    $result=safeSelectQuery($dbc,
        'select * from cinema where name=?',
        [$name]);
    return $result->fetch_row();
}

function addCinemaItems($title,$content){
    echo <<<EOF
    <div class="cinema-item">
        <div class="cinema-item-title">$title</div>
        <div class="cinema-item-content">$content</div>
    </div>
EOF;
}
