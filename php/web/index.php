<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../static/css/index.css">
</head>
<body>

<div class="container">
    <div class="div-description div-description-right">
        <img src="../../static/image/login.png" alt="加载失败">
    </div>
    <form action="../server/loginServer.php" class="form-login div-form-left">
        <h1>login</h1>
        <input type="text" placeholder="手机号或用户名" name="phoneOrName" id="phoneOrName">
        <input type="password" placeholder="密码" name="password">
        <button type="submit" id="loginButton">Login</button>
        <div class="control">
            <span>没有账号？<a href="#">Register</a></span>
        </div>
    </form>
    <form action="../server/registerServer.php" class="form-register div-form-hidden">
        <h1>Register</h1>
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
            <input type="password" placeholder="密码" name="password">
            <p class="input-message">请输入8~16个字符</p>
        </div>
        <div class="input-box">
            <input type="password" placeholder="确认密码" name="confirmPassword" id="confirmPassword">
            <p class="input-message">请确认密码</p>
        </div>
        <button type="submit" id="registerButton">Register</button>
        <div class="control">
            <span>已有账号？<a href="#">Login</a></span>
        </div>
    </form>
</div>
</body>
<script src="../../static/js/jquery-3.7.1.min.js"></script>
<script src="../../static/js/index.js"></script>
</html>
