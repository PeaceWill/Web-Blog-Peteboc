<?php
if (session_id() == '') {
    session_start();
}
include_once '../../config/config.php';
include_once '../../lib/database.php';
include_once '../../lib/validate.php';
include_once '../../model/user.php';

if (isset($_SESSION['root']) and $_SESSION['root'] == 'true') {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $userClass = new UserClass($pdo);
        $res = $userClass->getAllUser();
        var_dump($res['admin']);
    }
} else {
    echo 'Bạn không có quyền truy cập link này <3';
}

?>