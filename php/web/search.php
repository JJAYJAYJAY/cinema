<?php
session_start();
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../static/css/meyer.css">
    <link rel="stylesheet" href="../../static/css/search.css">
    <link rel="stylesheet" href="../../static/css/cinemaCard.css">
</head>
<body>
<div class="header">
    <form id="searchForm" action="../server/searchServer.php" class="search">
        <input type="text" placeholder="请输入搜索内容" name="search" class="search-input">
        <button class="search-btn">搜索</button>
    </form>
</div>
<div class="search-result">
    <div style="text-align: center;width: 100%;color: #6e6e6e">每次搜索都有新发现~~</div>
</div>
</body>
<script src="../../static/js/jquery-3.7.1.min.js"></script>
<script src="../../static/js/search.js"></script>
</html>