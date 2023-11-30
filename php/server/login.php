<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../../static/js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="../../static/css/meyer.css">
    <link rel="stylesheet" href="../../static/css/login.css">
    <link rel="stylesheet" href="../../static/icon/iconfont.css">
</head>
<body>
<form class="login-box" action="login.php" method="post">
    <div class="login-photo">
        <img src="../../static/image/login.png" alt="加载失败">
    </div>
    <div class="right">
        <h1>电影网</h1>
        <h2>你好，欢迎！</h2>
        <div class="input-box">
            <span class="iconfont">&#xe605;</span>
            <input type="text" placeholder="用户名称" name="username" id="username">
        </div>
        <div class="input-box">
            <span class="iconfont">&#xe604;</span>
            <input type="password" placeholder="密码" name="password" id="password">
        </div>
        <input class="login-button" type="submit" value="登录">
        <div class="register">
            <a href="register.php">没有账号？立即注册</a>
        </div>
    </div>
</form>
</body>
</html>

<?php
    require_once '../class/User.php';
    $user=new User($_POST['username'],$_POST['password']);
?>
