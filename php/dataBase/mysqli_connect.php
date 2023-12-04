<?php
//链接数据库
const DB_USER = 'root';
const DB_PASSWORD = 'root';
const DB_HOST = 'localhost';
const DB_NAME = 'cinema';
$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
OR die('Could not connect to MySQL:'.mysqli_connect_error());
mysqli_set_charset($dbc, 'utf8');


/**
 * 安全查询
 * @param $dbc mysqli
 * @param $query string
 * @param $params array
 * @return mysqli_result
 */
function safeSelectQuery($dbc, $query, $params=[]) {
    $stmt = $dbc->prepare($query);
    if($params  != [])
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}
function safeBoolQuery($dbc, $query, $params) {
    $stmt = $dbc->prepare($query);
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}