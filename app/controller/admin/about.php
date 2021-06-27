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
			$result = $aboutClass->updateAboutContent($_POST['content']);
			if ($result) {
				$res = array(
					'status' => 1,
					'message' => 'Update thành công'
				);
			} else {
				$res = array(
					'status' => 0,
					'message' => 'Update không thất bại'
				);
			}
			echo json_encode($res);
		}
	}
} else {
	echo 'Bạn không có quyền thực hiện thao tác này <3';
}
?>