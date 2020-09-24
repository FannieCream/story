<?php
$sqlutf='set names utf8 ';
$servername = "localhost";
$username = "root";
$password = "quanxiangou";
$dbname = "story";
 
// 创建连接
$mysqli = new mysqli($servername, $username, $password, $dbname);
$mysqli->query("SET NAMES utf8");

if ($mysqli->connect_error) {
    die("连接失败: " . $mysqli->connect_error);
} 
?>