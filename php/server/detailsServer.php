<?php
/**
 * @var mysqli $dbc
 */
header("Content-Type: application/json;charset=utf-8");
require_once '../dataBase/mysqli_connect.php';

$addComment=function ($dbc){
    $time=date('Y-m-d H:i:s');
    if(safeBoolQuery($dbc,
        'insert into comment (who,cinema,score,time,good,content) values (?,?,?,?,?,?)',
        [$_POST['who'], $_POST['cinema'], (int)$_POST['score'], $time, 0, $_POST['content']])){
        echo json_encode(['status'=>'success']);
    }
    else{
        echo json_encode(['status'=>'fail']);
    }
};

$addGood=function ($dbc){
    if(safeBoolQuery($dbc,
        'insert into user_good_link (userid, comment_id) VALUE (?,?)',
            [$_POST['userid'],$_POST['commentId']])){
        if(safeBoolQuery($dbc,
            'update comment set good=good+1 where time=? and cinema=? and who=?',
            [$_POST['time'],$_POST['cinema'],$_POST['who']])){
            echo json_encode(['status'=>'success','error'=>$dbc->error]);
        }
        else{
            echo json_encode(['status'=>'fail']);
        }
    }else{
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
    'addComment'=>$addComment,
    'addGood'=>$addGood,
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



