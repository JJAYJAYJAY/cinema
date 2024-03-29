<?php
/**
 * @var User $user
 */
require_once '../class/User.php';

session_start();
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
$user=$_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>首页</title>
    <script src="../../static/js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="../../static/css/meyer.css">
    <link rel="stylesheet" href="../../static/css/homeTemplate.css">
</head>
<body>
<div class="header">
    <div class="greet">
        <?php echo "<p>Hello,{$user->getUsername()}</p>"?>
    </div>
</div>
<div class="content">
    <div class="left-menu">
        <ul>
            <li class="menu-item active">首页</li>
            <li class="menu-item ">所有电影</li>
            <li class="menu-item">搜索</li>
            <li class="menu-item">我的评论</li>
            <?php
            if($user->getPower()=='admin') {
                echo '<li class="menu-item">管理员</li>';
                echo '<li class="menu-item">电影管理</li>';
            }
            ?>
        </ul>
    </div>
    <div class="right-content">
        <iframe id="show" src="home.php"></iframe>
    </div>
</div>
</body>
<script src="../../static/js/jquery-3.7.1.min.js"></script>
<script src="../../static/js/homeTemplate.js"></script>
</html>