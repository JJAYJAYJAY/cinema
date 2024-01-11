<?php
/**
 * @var mysqli $dbc
 */
require_once '../class/Cinema.php';
require_once '../dataBase/mysqli_connect.php';
require_once 'webFun.php';
session_start();
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
$page = $_GET['page'] ?? 1;
$perPageSize = 8;
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
    <title>Document</title>
    <link rel="stylesheet" href="../../static/css/meyer.css">
    <link rel="stylesheet" href="../../static/css/home.css">
    <link rel="stylesheet" href="../../static/css/page.css">
    <link rel="stylesheet" href="../../static/css/cinemaCard.css">

</head>
<body>
<div class="card-box">
    <?php
    foreach ($cinemas as $cinema) {
        addCinemaCard($dbc,$cinema->getName());
    }
    ?>
</div>
<div class="page" style="margin-left: 75px">
    <?php echo addPagination($page,$totalPage) ?>
</div>
</body>
<script src="../../static/js/jquery-3.7.1.min.js"></script>
</html>