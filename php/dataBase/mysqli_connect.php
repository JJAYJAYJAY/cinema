<?php
const DB_USER = 'root';
const DB_PASSWORD = 'root';
const DB_HOST = 'localhost';
const DB_NAME = 'cinema';
$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
OR die('Could not connect to MySQL:'.mysqli_connect_error());
mysqli_set_charset($dbc, 'utf8');