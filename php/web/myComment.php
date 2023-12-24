<?php
/**
 * @var $dbc mysqli
 * @var $user User
 */
require_once '../class/User.php';
require_once '../dataBase/mysqli_connect.php';
require_once '../class/Comment.php';
session_start();
$user=$_SESSION['user'];

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
    <link rel="stylesheet" href="../../static/css/commentForm.css">
</head>
<body>
    <div class="header">我的评论</div>
    <div class="comment-box">
        <?php
        $result=safeSelectQuery($dbc,
            'select * from comment where who=? order by time desc',
            [$user->getUsername()]);
        if($result->num_rows>0){
            while ($row=$result->fetch_row()){
                $comment=new Comment(...$row);
                addMyComment($comment);
            }
        }else{
            echo '<div style="text-align: center;width: 100%;color: #6e6e6e">你还没有评论哦</div>';
        }
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
<?php
/**
 * @param $comment Comment
 * @return void
 */
function addMyComment(Comment $comment){
    echo <<<EOF
    <div class="comment-card">
        <div class="comment-header">
            <span class="comment-user">
                <span>{$comment->getWho()}</span>
            </span>
            <span class="delete-comment" comment-id="{$comment->getId()}">删除</span>
            <span class="edit-comment" comment-id="{$comment->getId()}">修改</span>
        </div>
        <div class="comment-content">
            <span class="stars">
            <span class="score" hidden>{$comment->getScore()}</span>
EOF;
            $n=$comment->getScore()/2;
            for($i=0;$i<5;$i++){
                if($i<$n)
                    echo '<img class="star" src="../../static/image/star_onmouseover.png" alt="">';
                else
                    echo '<img class="star" src="../../static/image/star_hollow_hover.png" alt="">';
            }
    echo <<<EOF
            </span>
            <div class="comment-text">
                <span>{$comment->getContent()}</span>
            </div>
        </div>
        <div class="comment-tail">
             <span class="comment-time">{$comment->getTime()}</span>·
             <span>{$comment->getCinema()}</span>·
            <span>{$comment->getGood()}赞</span>
        </div>
    </div>
EOF;
}