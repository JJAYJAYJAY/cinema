<?php
/**
 * @var mysqli $dbc
 * @var User $nowUser
 */
require_once '../dataBase/mysqli_connect.php';
require_once '../class/User.php';
require_once 'webFun.php';
session_start();
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
$page = $_GET['page'] ?? 1;
$perPageSize = 10;
$offset = ($page - 1) * $perPageSize;
$users=safeSelectQuery($dbc,'select * from users where identity=? limit ?,?',['guest',$offset,$perPageSize]);
$totalPage = ceil(safeSelectQuery($dbc, 'select count(*) from users')->fetch_row()[0] / $perPageSize);
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
    <link rel="stylesheet" href="../../static/css/page.css">
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
            addUserCard($user);
        }
        ?>
    </table>
</div>
<div class="page">
    <?php
    echo addPagination($page, $totalPage);
    ?>
</div>
</body>
<script src="../../static/js/jquery-3.7.1.min.js"></script>
<script src="../../static/js/admin.js"></script>
</html>
<?php
