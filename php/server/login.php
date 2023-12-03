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
    /**
     * @var mysqli $dbc
     */
    session_start();
    require_once '../class/User.php';
    require_once '../dataBase/mysqli_connect.php';

    if(isset($_POST['username'])&&isset($_POST['password'])){
        $username=$_POST['username'];
        $password=$_POST['password'];
        //查询数据库
        $result=safeSelectQuery($dbc,
            'select * from users where username=? and password=?',
            [$username,$password]);
        if(mysqli_num_rows($result)==1){
            //登录成功
            $user=new User(...$result->fetch_row());
            $_SESSION['user']=$user;
            $user->login();
        }else{
            //弹窗提示登录失败
            echo "<script>alert('登录失败！');history.go(-1);</script>";
        }
    }
?>