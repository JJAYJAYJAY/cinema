<?php
/**
 * @var mysqli $dbc
 */
require_once '../class/User.php';
require_once '../class/Cinema.php';
require_once '../dataBase/mysqli_connect.php';
require_once 'webFun.php';
$page = $_GET['page'] ?? 1;
$perPageSize = 10;
$offset = ($page - 1) * $perPageSize;
$result=safeSelectQuery($dbc,'select * from cinema limit ?,?',[$offset,$perPageSize]);
$cinemas=[];
while($row=$result->fetch_row()){
    $cinemas[]=new Cinema(...$row);
}
$totalPage = ceil(safeSelectQuery($dbc, 'select count(*) from cinema')->fetch_row()[0] / $perPageSize);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>首页</title>
    <script src="../../static/js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="../../static/css/meyer.css">
    <link rel="stylesheet" href="../../static/css/cinema.css">
    <link rel="stylesheet" href="../../static/css/page.css">
    <link rel="stylesheet" href="../../static/css/commentForm.css">
</head>
<body>
    <div class="header">电影管理</div>
    <div class="cinema-box">
        <?php
        /**
         * @var Cinema $cinema
         */
        foreach ($cinemas as $cinema){
            $image=getImages($dbc,$cinema->getName());
            echo "<div class='cinema-item'>
                    <div class='cinema-image'><img src='../../$image' alt=''></div>
                    <div class='cinema-info'>
                        <div>电影名称：<span class='cinema-name'>{$cinema->getName()}</span></div>
                        <div>导演：<span class='cinema-director'>{$cinema->getDirector()}</span></div>
                        <div>上映时间：<span class='cinema-time'>{$cinema->getTime()}</span></div>
                        <div>国家/地区：<span class='cinema-country'>{$cinema->getCountry()}</span></div>
                        <div>片长：<span class='cinema-length'>{$cinema->getLength()}</span>分钟</div>
                        <div hidden><span class='cinema-introduce'>{$cinema->getIntroduce()}</span></div>
                    </div>
                    
                    <div class='cinema-operation'>
                        <div class='delete-button' data-id='{$cinema->getId()}'>删除</div>
                        <div class='change-button' data-id='{$cinema->getId()}'>修改</div>
                    </div>
                </div>";
        }
        ?>
    </div>
    <div class="page">
        <?php
        echo addPagination($page, $totalPage);
        ?>
    </div>
    <?php
        addEditFrom($cinemas[0],'../server/cinemaServer.php');
    ?>
    <div class="overlay" id="overlay"></div>
</body>
<script src="../../static/js/jquery-3.7.1.min.js"></script>
<script src="../../static/js/cinema.js"></script>
</html>