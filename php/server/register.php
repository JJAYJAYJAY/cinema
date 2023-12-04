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
<form class="register-box" action="register.php" method="post" id="register-form">
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

<?php
/**
 * @var  mysqli $dbc
 */
require_once '../class/User.php';
require_once '../dataBase/mysqli_connect.php';
require_once '../dataBase/checkInvalid.php';

// TODO:请检测用户输入的合法性 //已完成

if(isset($_POST['username'])){
    $username=$_POST['username'];
    if(checkInput($dbc,$username,'checkUsername','用户名已存在！')){
        return;
    }
    $email=$_POST['email'];
    if(checkInput($dbc,$email,'checkEmail','邮箱已使用！')){
        return;
    }
    $phone=$_POST['phone'];
    if(checkInput($dbc,$phone,'checkPhone','手机号已使用！')){
        return;
    }
    $password=$_POST['password'];
    $confirmPassword=$_POST['confirmPassword'];
    if($password!=$confirmPassword){
        echo "<script>alert('两次密码不一致！');history.go(-1);</script>";
        return;
    }
    $user=new User($_POST['username'],$_POST['password'],'guest',$_POST['email'],$_POST['phone']);
    $user->register($dbc);
}
function checkInput($dbc, $input, $checkFunction, $errorMessage) {
    if ($checkFunction($dbc, $input)) {
        echo "<script>alert('$errorMessage');history.go(-1);</script>";
        return true;
    }
    return false;
}
?>

