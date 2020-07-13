<?php

$config = include '../config/config.php';

//数据库连接
$servername = "localhost";
$username = "root";
$password = "lch666";
$dbname = "bbs1";
 
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
 
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
$sql = "insert into user values (null,'123456','123456',default)";
$result = $conn->query($sql);
if($result) echo "连接成功";

?>