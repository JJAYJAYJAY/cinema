<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../../static/js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="../../static/css/meyer.css">
    <link rel="stylesheet" href="../../static/css/register.css">
    <link rel="stylesheet" href="../../static/icon/iconfont.css">
</head>
<body>
<form class="register-box" action="../server/registerServer.php" method="post" id="register-form">
    <div class="title">
        <h2>欢迎来到电影网</h2>
    </div>
    <div class="input-box">
        <input type="text" placeholder="用户名称" name="username" id="username">
        <p class="input-message">请输入1~10个字符</p>
    </div>
    <div class="input-box">
        <input type="text" placeholder="邮箱" name="email" id="email">
        <p class="input-message">请输入正确的邮箱</p>
    </div>
    <div class="input-box">
        <input type="text" placeholder="手机号" name="phone" id="phone">
        <p class="input-message">请输入正确的手机号</p>
    </div>
    <div class="input-box">
        <input type="password" placeholder="密码" name="password" id="password">
        <p class="input-message">请输入8~16个字符</p>
    </div>
    <div class="input-box">
        <input type="password" placeholder="确认密码" name="confirmPassword" id="confirmPassword">
        <p class="input-message">请确认密码</p>
    </div>
    <input class="register-button" type="submit" value="注册" id="register">
</form>
</body>
<script src="../../static/js/jquery-3.7.1.min.js"></script>
<script src="../../static/js/register.js"></script>
</html>