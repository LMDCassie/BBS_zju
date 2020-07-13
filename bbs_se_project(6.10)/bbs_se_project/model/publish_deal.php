<?php

//发帖处理

session_start();

include '../init.php';

include DIR_CORE . 'mysqlDB.php';

//接收发帖数据
//过滤标签内容
$pub_title = escapeString( $_POST['pub_title'] );
$pub_content = escapeString( $_POST['pub_content'] );
$session_name = escapeString( $_POST['session_name'] );

//获取当前发帖者的个人信息
$pub_owner = $_SESSION['USER']['UName'];

//获取当前的发帖时间
$pub_time = time();


//数据库操作
$sql = "insert into Post values (null,'$pub_title','$pub_content', '$pub_owner', '$session_name', '$pub_time', 0) ";


//发帖的业务逻辑

if ( empty("$pub_title") || empty("$pub_content") ) {
	jump('./publish.php', '内容和标题不能为空 ！~~~');
}else {
	$result = $conn->query($sql);

	if ( $result ) {
		if($session_name==1){
			jump('./list_father.php?new_session=1', '发帖成功 ！~ 正在跳转 1s...' );
		}elseif ($session_name==2) {
			jump('./list_father.php?new_session=2', '发帖成功 ！~ 正在跳转 1s...' );
		}elseif ($session_name==3) {
			jump('./list_father.php?new_session=3', '发帖成功 ！~ 正在跳转 1s...' );
		}elseif ($session_name==4) {
			jump('./list_father.php?new_session=4', '发帖成功 ！~ 正在跳转 1s...' );
		}
	} else {
		jump('./publish.php', '发生未知错误QAQ~');
	}
}

