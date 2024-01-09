<?php
/**
 * @var mysqli $dbc
 */
session_start();
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
require_once '../dataBase/mysqli_connect.php';
require_once 'webFun.php'
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
    <link rel="stylesheet" href="../../static/css/cinemaCard.css">
</head>
<body>
<h1 class="header">近期上新</h1>
<div class="card-box">
    <?php
    $cinemas=safeSelectQuery($dbc,
        'select * from cinema order by time desc limit 8');
    while($cinema=$cinemas->fetch_row()){
        addCinemaCard($dbc,$cinema[1]);
    }
    ?>
</div>
</body>
<script src="../../static/js/jquery-3.7.1.min.js"></script>
</html>


