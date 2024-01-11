<?php
/**
 * @var $dbc mysqli
 * @var $user User
 */
require_once '../class/User.php';
require_once '../dataBase/mysqli_connect.php';
require_once '../class/Comment.php';
require_once 'webFun.php';
session_start();
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
$user=$_SESSION['user'];
$page = $_GET['page'] ?? 1;
$perPageSize = 10;
$offset = ($page - 1) * $perPageSize;
$result=safeSelectQuery($dbc,'select * from comment where who=? order by time desc limit ?,?',[$user->getUsername(),$offset,$perPageSize]);
$comments=[];
while($row=$result->fetch_row()){
    $comments[]=new Comment(...$row);
}
$totalPage = ceil(safeSelectQuery($dbc, 'select count(*) from comment where who=?',[$user->getUsername()])->fetch_row()[0] / $perPageSize);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../../static/js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="../../static/css/meyer.css">
    <link rel="stylesheet" href="../../static/css/myComment.css">
    <link rel="stylesheet" href="../../static/css/page.css">
    <link rel="stylesheet" href="../../static/css/commentForm.css">
</head>
<body>
    <div class="header">我的评论</div>
    <div class="comment-box">
        <?php
        if(count($comments)>0){
           foreach ($comments as $comment) {
               echo addMyComment($comment);
           }
        }else{
            echo '<div style="text-align: center;width: 100%;color: #6e6e6e;margin-top: 20px">你还没有评论哦</div>';
        }
        ?>
    </div>
    <div class="page">
        <?php
        echo addPagination($page, $totalPage);
        ?>
    </div>
    <div class="overlay" id="overlay"></div>
    <form class="form comment-form" id="commentForm" action="../server/myCommentServer.php" method="post">
        <div class="form-header">
            <span>修改评论</span> <a class="formClose">x</a>
        </div>
        <div class="stars-box">
            <span>评价:</span>
            <div class="stars" id="formStars">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
                <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
            </div>
        </div>
        <input type="hidden" name="command" value="editComment">
        <input type="hidden" id="commentId" name="commentId" value="">
        <input type="hidden" name="score" id="starsInput" value="2">
        <div class="comment-label">简短评论:</div>
        <textarea class="form-comment" name="content" id="content" placeholder="写下你的评论..."></textarea>
        <input class="comment-button" type="submit" value="修改" id="commentButton">
    </form>
</body>
<script src="../../static/js/jquery-3.7.1.min.js"></script>
<script src="../../static/js/myComment.js"></script>
<script src="../../static/js/commentForm.js"> </script>
</html>
