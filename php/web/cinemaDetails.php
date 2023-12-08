<?php
/**
 * @var mysqli $dbc
 * @var User $user
 */
require_once '../class/User.php';
require_once '../class/Comment.php';
require_once '../class/Cinema.php';
require_once '../dataBase/mysqli_connect.php';

session_start();
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
$user=$_SESSION['user'];
$name=$_GET['name'];
$cinema=new Cinema(...getMovie($dbc,$name));
$commentResult=safeSelectQuery($dbc,
    'select * from comment where cinema=?',
    [$name]);
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
    <link rel="stylesheet" href="../../static/icon/iconfont.css">
</head>
<body>
<div class="overlay" id="overlay"></div>
<div class="comment-form" id="commentForm">
    <form id="form" action="../server/detailsServer.php" method="post">
        <div class="form-header">
            <span>写评论</span> <a id="formClose">x</a>
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
        <input type="hidden" name="command" value="addComment">
        <input type="hidden" name="who" value="<?php echo $user->getUsername()?>">
        <input type="hidden" name="score" id="starsInput" value="2">
        <input type="hidden" name="cinema" value="<?php echo $name?>">
        <div class="comment-label">简短评论:</div>
        <textarea class="form-comment" name="content" id="content" placeholder="写下你的评论..."></textarea>
        <input class="comment-button" type="submit" value="提交" id="commentButton">
    </form>
</div>
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
            <img src="../../<?php echo getImages($dbc,$name)?>" alt="加载失败">
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
                    $average = 0;
                    if(count($comments)==0){
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
        </div>
    </div>
    <div class="cinema-introduce">
        <div class="title">电影简介:</div>
        <div class="introduce-content"><?php echo $cinema->getIntroduce()?></div>
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
            addCommentCard($comment);
        }
        ?>
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

/**
 * @param $comment Comment
 * @return void
 */
function addCommentCard($comment){
    global $user;
    echo <<<EOF
        <div class="comment-card">
            <div class="small-title">
                <span class="who">{$comment->getWho()}</span>
                <span class="stars">
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
                <span class="time">{$comment->getTime()}</span>
                <span class="good"><span class="count">{$comment->getGood()}</span><span class="good-button">赞</span></span>
                <span class="commentId" hidden>{$comment->getId()}</span>
            </div>
            <div class="comment-content">{$comment->getContent()}</div>
EOF;
    if($user->getPower()==='admin'){
        echo "<div class='delete-div'><a class='delete-button'>删除</a></div>";
    }
     echo   '</div>';
}


?>
