<?php

//搜索处理

session_start();

include '../init.php';

include DIR_CORE . 'mysqlDB.php';

$search_result = $_SESSION['SEARCH'];

//数据库操作
while($row = $search_result){
	echo $row['PTitle'];
	echo $row['PContent'];
	echo $row['POwner'];
}

