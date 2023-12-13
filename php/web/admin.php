<?php
/**
 * @var mysqli $dbc
 * @var User $nowUser
 */
require_once '../dataBase/mysqli_connect.php';
require_once '../class/User.php';
session_start();
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
$users=safeSelectQuery($dbc,'select * from users');
$usersArray=[];
while($user=$users->fetch_row()) {
    $usersArray[] = new User(...$user);
}
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
    <table class="user-list">
        <tr>
            <th>用户名</th>
            <th>权限</th>
            <th>邮箱</th>
            <th>手机号</th>
            <th>修改权限</th>
            <th>删除</th>
        </tr>
        <?php
        /**
         * @var User $user
         */
        foreach ($usersArray as $user){
            if($user->getPower()==='admin')
                continue;
            addUserCard($user);
        }
        ?>
    </table>
</div>
</body>
<script src="../../static/js/jquery-3.7.1.min.js"></script>
<script src="../../static/js/admin.js"></script>
</html>
<?php
function addUserCard($user)
{
    echo <<<EOF
    <tr class="user-card">
        <td>{$user->getUsername()}</td>
        <td>{$user->getPower()}</td>
        <td>{$user->getEmail()}</td>
        <td>{$user->getPhone()}</td>
        <td>
            <button class="change-button" data-id="{$user->getId()}">修改</button>
        </td>
        <td>
            <button class="delete-button" data-id="{$user->getId()}" data-id="{$user->getId()}">删除</button>
        </td>    
    </tr>
EOF;
}