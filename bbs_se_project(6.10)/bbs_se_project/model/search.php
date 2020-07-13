<?php


session_start();

include '../init.php';

if ( isset($_SESSION['USER']) ) {
	include DIR_VIEW . 'search.html';
}else {
	jump('./login.php', '您还没有登录 !~');
}

