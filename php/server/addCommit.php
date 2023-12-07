<?php
/**
 * @var mysqli $dbc
 */
header("Content-Type: application/json;charset=utf-8");
require_once '../dataBase/mysqli_connect.php';
$time=date('Y-m-d');

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])&&$_SERVER['REQUEST_METHOD']=='POST') {
   if(safeBoolQuery($dbc,
        'insert into commits (who,cinema,score,time,good,content) values (?,?,?,?,?,?)',
        [$_POST['who'], $_POST['cinema'], (int)$_POST['score'], $time, 0, $_POST['content']])){
         echo json_encode(['status'=>'success']);
   }
   else{
       echo json_encode(['status'=>'fail']);
   }
}

