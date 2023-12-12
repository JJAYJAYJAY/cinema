<?php
/**
 * @var  mysqli $dbc
 */
require_once '../class/User.php';
require_once '../dataBase/mysqli_connect.php';
require_once '../dataBase/checkInvalid.php';

header('Content-Type:application/json; charset=utf-8');

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])&&$_SERVER['REQUEST_METHOD']=='POST') {
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
    if(safeBoolQuery($dbc, 'insert into users (username,password,identity,email,phone) values (?,?,?,?,?)', [$_POST['username'],$_POST['password'],'guest',$_POST['email'],$_POST['phone']])) {
        echo json_encode(['status' => 'success', 'message' => '注册成功！']);
    }
}
function checkInput($dbc, $input, $checkFunction, $errorMessage): bool
{
    if ($checkFunction($dbc, $input)) {
        echo json_encode(['status' => 'fail', 'message' => $errorMessage]);
        return true;
    }
    return false;
}


