<?php
/**
 * @var mysqli $dbc
 */
session_start();
require_once '../class/User.php';
require_once '../dataBase/mysqli_connect.php';
header('Content-Type:application/json; charset=utf-8');
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])&&$_SERVER['REQUEST_METHOD']=='POST') {
    $phoneOrName = $_POST['phoneOrName'];
    $password = $_POST['password'];
    $result = safeSelectQuery($dbc,
        'select * from users where (phone=? or username=?) and password=?',
        [$phoneOrName, $phoneOrName, $password]);
    if (mysqli_num_rows($result) == 1) {
        //登录成功
        $user = new User(...$result->fetch_row());
        $_SESSION['user'] = $user;
        $_SESSION['is_logged_in'] = true;
        echo json_encode(['status' => 'success']);
    } else {
        //弹窗提示登录失败
        echo json_encode(['status' => 'fail']);
    }
}