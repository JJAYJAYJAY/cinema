<?php
require_once '../dataBase/mysqli_connect.php';
/**
 * @param $dbc mysqli
 * @param $username string
 * @return string|false
 */
function checkUsername($dbc,$username){
    $result=safeSelectQuery($dbc, 'select * from users where username=?', [$username]);
    if(mysqli_num_rows($result)==0){
        return false;
    }else{
        return "用户名已存在";
    }
}

/**
 * @param $dbc
 * @param $email
 * @return string|false
 */
function checkEmail($dbc,$email){
    $result=safeSelectQuery($dbc, 'select * from users where email=?', [$email]);
    if(mysqli_num_rows($result)==0){
        return false;
    }else{
        return "邮箱已使用";
    }
}
/**
 * @param $dbc
 * @param $phone
 * @return string|false
 */
function checkPhone($dbc,$phone){
    $result=safeSelectQuery($dbc, 'select * from users where phone=?', [$phone]);
    if(mysqli_num_rows($result)==0){
        return false;
    }else{
        return "手机号已使用";
    }
}



