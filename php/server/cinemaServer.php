<?php
/**
 * @var mysqli $dbc
 */
require_once '../dataBase/mysqli_connect.php';
header("Content-Type: application/json;charset=utf-8");
session_start();
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
$edit=function ($dbc){
    if(safeBoolQuery($dbc,
        'update cinema set time=?,director=?,country=?,length=?,introduce=? where name=?',
        [$_POST['time'],$_POST['director'],$_POST['country'],$_POST['length'],$_POST['introduce'],$_POST['cinema']])){
        echo json_encode(['status'=>'success']);
    }
    else{
        echo json_encode(['status'=>'fail']);
    }
};
$delete=function ($dbc){
    $cinemaName=safeSelectQuery($dbc,'select name from cinema where id=?',[$_POST['id']])->fetch_row()[0];
    //删除图片
    $images=safeSelectQuery($dbc,'select url from images where name=?',[$cinemaName]);
    while($row=$images->fetch_row()){
        $image=$row[0];
        if(!unlink('../../'.$image)){
            echo json_encode(['status'=>'fail']);
            die('Error: ' . error_get_last()['message']);
        }
    }

    $comments=[];
    $commentsId=safeSelectQuery($dbc,'select id from comment where cinema=?',[$cinemaName]);
    while($row=$commentsId->fetch_row()){
        $comments[]=$row[0];
    }
    //删除评论
    foreach ($comments as $comment){
        if(safeBoolQuery($dbc,'delete from comment where id=? ', [$comment])&&
            safeBoolQuery($dbc, 'delete from user_good_link where comment_id=?', [$comment])){
            continue;
        }
        else {
            echo json_encode(['status'=>'fail']);
            die();
        }
    }
    //删除电影
    if(safeBoolQuery($dbc,'delete from cinema where id=? ', [$_POST['id']])&&
    safeBoolQuery($dbc,'delete from images where name=?',[$cinemaName])){
        echo json_encode(['status'=>'success','cinema'=>$cinemaName]);
    }
    else {
        echo json_encode(['status'=>'fail']);
    }
};
$add=function ($dbc){
    $file=$_FILES['image'];
    if($file['type']!='image/jpeg'&&$file['type']!='image/png'){
        echo json_encode(['status'=>'非法上传']);
        die();
    }
    if($file['size']>1024*1024*2){
        echo json_encode(['status'=>'文件过大']);
        die();
    }
    $cinemaName=$_POST['name'];
    $time=$_POST['time'];
    $director=$_POST['director'];
    $country=$_POST['country'];
    $length=$_POST['length'];
    $introduce=$_POST['introduce'];
    $imagePath='static/image/cinema/'.$file['name'];
    //检查是否有空数据
    if($cinemaName==''||$time==''||$director==''||$country==''||$length==''||$introduce==''){
        echo json_encode(['status'=>'请将数据填写完整']);
        die();
    }
    if(!move_uploaded_file($file['tmp_name'],'../../'.$imagePath)){
        echo json_encode(['status'=>'fail']);
        die('Error: ' . error_get_last()['message']);
    }
    if(safeBoolQuery($dbc,'insert into cinema(name,time,director,country,length,introduce) values(?,?,?,?,?,?)',
        [$cinemaName,$time,$director,$country,$length,$introduce])&&
        safeBoolQuery($dbc,'insert into images(name,url) values(?,?)',[$cinemaName,$imagePath])){
        echo json_encode(['status'=>'success']);
    }
    else{
        echo json_encode(['status'=>'fail']);
    }
};
$commands=array(
    'delete'=>$delete,
    'edit'=>$edit,
    'add'=>$add
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
