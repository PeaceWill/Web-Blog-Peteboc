<?php
if (session_id() == '') {
	session_start();
}

include_once '../../lib/session.php';
include_once '../../model/about.php';
$aboutClass = new About();
if (Session::checkSession('root')) {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['content'])) {
			var_dump($_POST['content']);
		}
	}
} else {
	echo 'Bạn không có quyền thực hiện thao tác này <3';
}
?>