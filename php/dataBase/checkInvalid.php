<?php
function checkUsername($dbc,$username){
    $query="select * from users where username='$username'";
    $result=mysqli_query($dbc,$query);
    if(mysqli_num_rows($result)==0){
        return true;
    }else{
        return "用户名已存在";
    }
}

function checkEmail($dbc,$email){
    $query="select * from users where email='$email'";
    $result=mysqli_query($dbc,$query);
    if(mysqli_num_rows($result)==0){
        return true;
    }else{
        return "邮箱已使用";
    }
}

function checkPhone($dbc,$phone){
    $query="select * from users where phone='$phone'";
    $result=mysqli_query($dbc,$query);
    if(mysqli_num_rows($result)==0){
        return true;
    }else{
        return "手机号已使用";
    }
}

function safeQuery($dbc, $query, $params) {
    $stmt = $dbc->prepare($query);
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}
function waf($str){
    $str=trim($str);
    $str=stripslashes($str);
    $str=htmlspecialchars($str);
    return $str;
}