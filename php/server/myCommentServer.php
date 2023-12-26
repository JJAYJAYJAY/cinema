<?php
/**
 * @var mysqli $dbc
 */
require_once '../dataBase/mysqli_connect.php';
header("Content-Type: application/json;charset=utf-8");

$time=date('Y-m-d H:i:s');
$editComment=function ($dbc){
    global $time;
    if(safeBoolQuery($dbc,
        'update comment set content=?,score=?,time=? where id=?',
        [$_POST['content'],$_POST['score'],$time,$_POST['commentId']])){
        echo json_encode(['status'=>'success']);
    }
    else{
        echo json_encode(['status'=>'fail']);
    }
};
$deleteComment=function ($dbc){
    if(safeBoolQuery($dbc,'delete from comment where id=? ', [$_POST['commentId']])&&
        safeBoolQuery($dbc, 'delete from user_good_link where comment_id=?', [$_POST['commentId']])){
        echo json_encode(['status'=>'success','id'=>$_POST['commentId']]);
    }
    else {
        echo json_encode(['status'=>'fail']);
    }
};
$commands=array(
    'editComment'=>$editComment,
    'deleteComment'=>$deleteComment
);
function execute($dbc,$command){
    $command($dbc);
}
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])&&$_SERVER['REQUEST_METHOD']=='POST') {
    //如果这个key值存在$commands中则执行
    if (array_key_exists($_POST['command'], $commands)) {
        execute($dbc,$commands[$_POST['command']]);
    }
    else{
        echo json_encode(['status'=>'fail']);
    }
}
