<?php
/**
 * @var mysqli $dbc
 */
require_once '../dataBase/mysqli_connect.php';
header("Content-Type: application/json;charset=utf-8");
session_start();
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: ../web/login.php');
}
$changePower=function ($dbc){
    if(safeBoolQuery($dbc,
        'update users set identity=? where id=?',
        ["admin",$_POST['id']])){
        echo json_encode(['status'=>'success']);
    }
    else{
        echo json_encode(['status'=>'fail']);
    }
};

$deleteUser=function ($dbc){
    if(safeBoolQuery($dbc,
        'delete from users where id=?',
        [$_POST['id']])){
        echo json_encode(['status'=>'success']);
    }
    else{
        echo json_encode(['status'=>'fail']);
    }
};

$commands=array(
    'changePower'=>$changePower,
    'deleteUser'=>$deleteUser
);

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])&&$_SERVER['REQUEST_METHOD']=='POST') {
    //如果这个key值存在$commands中则执行
    if(array_key_exists($_POST['command'],$commands)){
        $commands[$_POST['command']]($dbc);
    }
    else{
        echo json_encode(['status'=>'fail']);
    }
}