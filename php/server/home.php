<?php
/**
 * @var mysqli $dbc
 */
session_start();
require_once '../dataBase/mysqli_connect.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../../static/js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="../../static/css/meyer.css">
    <link rel="stylesheet" href="../../static/css/home.css">
    <link rel="stylesheet" href="../../static/icon/iconfont.css">
</head>
<body>
<h1>近期上新</h1>
<div class="card-box">
    <?php
    $cinemas=safeSelectQuery($dbc,
        'select * from cinema order by time desc limit 10');
    while($cinema=$cinemas->fetch_row()){
        addCinemaCard($dbc,$cinema[0]);
    }
    ?>
</div>
</body>
<script src="../../static/js/jquery-3.7.1.min.js"></script>
</html>
<?php

    function addCinemaCard($dbc,$name){
        $result=safeSelectQuery($dbc,
            'select * from images where name=?',
            [$name]);
        echo <<<EOF
        <div class="cinema-card">
            <div class="cinema-image">
                <img src="../../{$result->fetch_row()[1]}" alt="加载失败">
            </div>
            <div class="content">
                <div class="cinema-name">{$name}</div>
                <button>查看详情</button>   
            </div>
        </div>
EOF;

    }
