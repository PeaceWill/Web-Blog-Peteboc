<?php
include_once '../../lib/session.php';
include_once '../../lib/token.php';
Session::init();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $res = getHistoryLog();
    echo json_encode($res);
}

function getHistoryLog() {
    $access = Session::get('user');
    $response = array();
    if (!$access) {
        $response['status'] = 0;
        $response['message'] = 'Bạn không có quyền truy cập <3';
        return $response;
    }
    include_once '../../model/log.php';
    $log = new Log();
    $response = $log->getUserAction($access);
    return $response;
}
?>