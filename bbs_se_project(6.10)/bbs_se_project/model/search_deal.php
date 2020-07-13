<?php

//搜索处理

session_start();

include '../init.php';

include DIR_CORE . 'mysqlDB.php';

$search_content = escapeString( $_POST['search_content'] );
$search_way = escapeString( $_POST['search_way'] );

//获取当前发帖者的个人信息
$pub_owner = $_SESSION['USER']['UName'];

//获取当前的发帖时间
$pub_time = time();

//数据库操作
if ($search_way == '帖子标题搜索'){
	$sql = "SELECT * FROM Post WHERE PTitle like '%$search_content%' ORDER BY LOCATE('$search_content',PTitle) ";
}
elseif ($search_way == '帖子内容搜索') {
	$sql = "SELECT * FROM Post WHERE PContent like '%$search_content%' ORDER BY LOCATE('$search_content',PContent) ";
}
else{
	$sql = "SELECT * FROM Post WHERE POwner like '%$search_content%' ORDER BY LOCATE('$search_content',POwner) ";
}

//发帖的业务逻辑

if ( empty("$search_content") ) {
	jump('./search.php', '搜索内容不能为空 ！~~~');
}else {
	$result = $conn->query($sql);

	if ( !$result ) {
		jump('./publish.php', '发生未知错误QAQ~');
	} else {
		// 接收当前页码数
		$pageNum = isset($_GET['num']) ? $_GET['num'] : 1;
		// 定义每一页显示的记录数
		$rowsPerPage = 5;
		// 查询总记录数
		$rowCount = 0;
		while($result->fetch_assoc()){
			$rowCount = $rowCount + 1; // 得到总记录数
		}
		echo $rowCount;
		// 计算总页数
		$pages = ceil($rowCount / $rowsPerPage);

		// 拼凑出页码字符串
		$strPage = '';
		// 拼凑出“首页”
		$strPage .= "<a href='./list_father.php?num=1'>首页</a>";
		// 拼凑出“上一页”
		$preNum = $pageNum == 1 ? 1 : $pageNum - 1;
		if($pageNum != 1) {
			$strPage .= "<a href='./list_father.php?num=$preNum'><<上一页</a>";
		}

		// 确定显示的第1个页码$startNum的值
		if($pageNum <= 3) {
			$startNum = 1;
		}else {
			$startNum = $pageNum - 2;
		}
		// 确定$startNum的最大值
		if($startNum > $pages - 4) {
			$startNum = $pages - 4;
		}
		// 防止$startNum出现负值
		if($startNum <= 1) {
			$startNum = 1;
		}
		// 确定显示的最后1个页码$endNum的值
		$endNum = $startNum + 4;
		// 防止$endNum越界
		if($endNum > $pages) {
			$endNum = $pages;
		}

		// 拼凑出中间的页码
		for($i=$startNum;$i<=$endNum;$i++) {
			if($i == $pageNum) {
				$strPage .= "<a href='./list_father.php?num=$i' style='background:#105cb6;color:white;'>$i</a>";
			}else {
				$strPage .= "<a href='./list_father.php?num=$i'>$i</a>";
			}	
		}
		// 拼凑出“下一页”
		$nextNum = $pageNum == $pages ? $pages : $pageNum + 1;
		if($pageNum != $pages) {
			$strPage .= "<a href='./list_father.php?num=$nextNum'>下一页>></a>";
		}
		// 拼凑出“尾页”
		$strPage .= "<a href='./list_father.php?num=$pages'>尾页</a>";
		// 拼凑出“总页数”
		$strPage .= "总页数:$pages";

		// 分页到此结束

		// 3, 提取publish表的数据
		$offset = ($pageNum - 1) * $rowsPerPage;
		$result = $conn->query($sql);
		if ( $result->num_rows == 0 ) {
			$row  = array('pub_content' => '信息消失了~', 'pub_owner' => '');
		}


		include DIR_VIEW . 'list_father.html';

	}
}

