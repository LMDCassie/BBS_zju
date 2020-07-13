<?php
//发帖页

session_start();

include '../init.php';

//判断用户是否已经登录了 1.登录了跳转发帖页面 2.否则跳转登录界面后再发帖
if ( !isset($_SESSION['USER']) ) {
	jump('./login.php', '您还没有登录 !~');
	include DIR_VIEW . 'announcement.html';
}elseif( $_SESSION['USER']['UPriority']!=='Admin' ){
	jump('../index.php', '您不是系统管理员，不能发公告!');
}else {
	include DIR_VIEW . 'announcement.html';
}

