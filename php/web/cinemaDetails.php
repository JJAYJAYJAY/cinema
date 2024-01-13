<?php
/**
 * @var mysqli $dbc
 * @var User $user
 */
require_once '../class/User.php';
require_once '../class/Comment.php';
require_once '../class/Cinema.php';
require_once '../dataBase/mysqli_connect.php';
require_once 'webFun.php';
session_start();
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
$user=$_SESSION['user'];
$name=$_GET['name'];
try {
    $cinema=new Cinema(...getMovie($dbc,$name));
}catch (Exception $e){
    header('Location: homeTemplate.php');
    exit;
}
$commentResult=safeSelectQuery($dbc,
    'select * from comment where cinema_id=? order by time desc',
    [$cinema->getId()]);
$comments=[];
while($comment=$commentResult->fetch_row()){
    $comments[]=new Comment(...$comment);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $name?></title>
    <script src="../../static/js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="../../static/css/meyer.css">
    <link rel="stylesheet" href="../../static/css/cinemaDetails.css">
    <link rel="stylesheet" href="../../static/css/commentForm.css">
</head>
<body>
<div class="overlay" id="overlay"></div>
<form class="form comment-form" id="commentForm" action="../server/detailsServer.php" method="post">
    <div class="form-header">
        <span>写评论</span> <a class="formClose">x</a>
    </div>
    <div class="stars-box">
        <span>评价:</span>
        <div class="stars" id="formStars">
            <img class="star" src="../../static/image/star_onmouseover.png" alt="">
            <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
            <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
            <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
            <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
        </div>
    </div>
    <input type="hidden" name="command" value="addComment">
    <input type="hidden" name="who" value="<?php echo $user->getUsername()?>">
    <input type="hidden" name="score" id="starsInput" value="2">
    <input type="hidden" name="cinema" value="<?php echo $name?>">
    <input type="hidden" name="cinemaId" value="<?php echo $cinema->getId()?>">
    <div class="comment-label">简短评论:</div>
    <label for="content"></label><textarea class="form-comment" name="content" id="content" placeholder="写下你的评论..."></textarea>
    <input class="comment-button" type="submit" value="提交" id="commentButton">
</form>
<div class="header">
    <div class="greet">
        <?php echo 'Hello,'.$user->getUsername(); ?>
        <span id="userid" hidden><?php echo $user->getId()?></span>
    </div>
</div>
<div class="content">
    <div class="cinema-name">
        <?php echo $name; ?>
    </div>
    <div class="cinema-box">
        <div class="left">
            <img src="../../<?php echo getImages($dbc,$cinema->getId())?>" alt="加载失败">
        </div>
        <div class="middle">
            <?php
            addCinemaItems('电影名称:',$cinema->getName());
            addCinemaItems('上映时间:',$cinema->getTime());
            addCinemaItems('导演:',$cinema->getDirector());
            addCinemaItems('制片国家/地区:',$cinema->getCountry());
            addCinemaItems('电影时长:',$cinema->getLength().'分钟');
            ?>
        </div>
        <div class="right">
            <div class="title">
                评分
            </div>
            <div class="score">
                <?php
                    $count=count($comments);
                    $average = 0;
                    if($count==0){
                        echo "暂无评分";
                    }else {
                        /**
                         * @var Comment $comment
                         */
                        foreach ($comments as $comment) {
                            $average += (int) $comment->getScore();
                        }
                        $average = round($average / count($comments), 1);
                        echo $average;
                    }
                ?>
            </div>
            <div class="stars">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
            </div>
            <div class="stars yellow" style="clip-path: inset(0  <?php echo (100-$average*10).'%' ?> 0 0 )">
                <img class="star" src="../../static/image/star_onmouseover.png" alt="">
                <img class="star" src="../../static/image/star_onmouseover.png" alt="">
                <img class="star" src="../../static/image/star_onmouseover.png" alt="">
                <img class="star" src="../../static/image/star_onmouseover.png" alt="">
                <img class="star" src="../../static/image/star_onmouseover.png" alt="">
            </div>
            <div class="count">总计<?php echo $count?>条评论</div>
        </div>
    </div>
    <div class="cinema-introduce">
        <div class="title"><span>电影简介:</span><?php if($user->getPower()==='admin') echo '<span class="edit-button">修改</span>'?></div>
        <div class="introduce-content"><?php echo nl2br(str_replace(' ', '&nbsp;', $cinema->getIntroduce()))?></div>
    </div>
    <div class="clearfix">
        <div class="stars-box">
            <span>评价:</span>
            <div class="stars" id="stars">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
            </div>
        </div>
        <div class="small-box" id="writeComment">
            写评论
        </div>
    </div>
    <div class="comments-box">
        <?php
        foreach ($comments as $comment){
            echo addCommentCard($comment);
        }
        ?>
    </div>
</div>
<?php
if($user->getPower()==='admin'){
    addEditFrom($cinema,'../server/detailsServer.php');
}
?>
<script src="../../static/js/jquery-3.7.1.min.js"></script>
<script src="../../static/js/cinemaDetails.js"></script>
<script src="../../static/js/commentForm.js"> </script>
</body>
</html>


