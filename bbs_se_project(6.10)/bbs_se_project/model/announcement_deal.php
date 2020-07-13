<?php

//发帖处理

session_start();

include '../init.php';

include DIR_CORE . 'mysqlDB.php';

//接收发帖数据
//过滤标签内容
$ann_title = escapeString( $_POST['ann_title'] );
$ann_content = escapeString( $_POST['ann_content'] );

//获取当前发帖者的个人信息
$ann_owner = $_SESSION['USER']['UName'];
echo $_SESSION['USER']['UName'];

//数据库操作
$sql = "insert into Announcement values (null,'$ann_title','$ann_content', '$ann_owner') ";

echo $ann_owner;
//发帖的业务逻辑

if ( empty("$ann_title") || empty("$ann_content") ) {
	jump('./announcement.php', '内容和标题不能为空 ！~~~');
}else {
	$result = $conn->query($sql);

	if ( $result ) {
		jump('../index.php', '发公告成功 ！~ 正在跳转 1s...' );
	} else {
		jump('./announcement.php', '发生未知错误QAQ~');
	}
}

