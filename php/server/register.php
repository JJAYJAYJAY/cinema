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
<form class="register-box" action="register.php" method="post">
    <div class="title">
        <h2>欢迎来到电影网</h2>
    </div>
    <div class="input-box">
        <input type="text" placeholder="用户名称" name="username" id="username">
    </div>
    <div class="input-box">
        <input type="text" placeholder="邮箱" name="username" id="username">
    </div>
    <div class="input-box">
        <input type="text" placeholder="手机号" name="username" id="username">
    </div>
    <div class="input-box">
        <input type="password" placeholder="密码" name="password" id="password">
    </div>
    <div class="input-box">
        <input type="password" placeholder="确认密码" name="confirmPassword" id="password">
    </div>
    <input class="register-button" type="submit" value="注册">
</form>
</body>
</html>

<?php
/**
 * @var  mysqli $dbc
 */
require_once '../class/User.php';
require_once '../dataBase/mysqli_connect.php';

$username=$_POST['username'];
$password=$_POST['password'];
$confirmPassword=$_POST['confirmPassword'];


$user=new User($_POST['username'],$_POST['password']);
?>

