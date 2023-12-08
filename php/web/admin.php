<?php
/**
 * @var mysqli $dbc
 */
session_start();
require_once '../dataBase/mysqli_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../../static/js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="../../static/css/meyer.css">
    <link rel="stylesheet" href="../../static/css/admin.css">
    <link rel="stylesheet" href="../../static/icon/iconfont.css">
</head>
<body>
<div class="header">用户管理</div>
<div class="user-box">
    <table class="userList">
        <tr>
            <th>用户名</th>
            <th>权限</th>
            <th>操作</th>
        </tr>
    </table>
</div>
</body>
<script src="../../static/js/jquery-3.7.1.min.js"></script>
<script src="../../static/js/admin.js"></script>
</html>

