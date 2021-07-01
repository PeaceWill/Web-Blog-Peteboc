<?php
include_once '../../lib/session.php';
Session::init();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $res = getAdminInfo();
        echo json_encode($res);
        break;
    case 'POST':
        if (isset($_POST['action']) and $_POST['action'] == 'change-password') {
            // Change admin passowrd
            $pw = isset($_POST['current__pw']) ?  $_POST['current__pw'] : '';
            $new_pw = isset($_POST['new__pw']) ? $_POST['new__pw'] : '';
            $confirm_pw = isset($_POST['re-new__pw']) ? $_POST['re-new__pw'] : '';
            $res = updateAdminPassword($pw, $new_pw, $confirm_pw);
            echo json_encode($res);
        }
        break;
    default:
        break;
}

/**  
 *  GET ADMIN INFO
*/
function getAdminInfo() {
    include_once '../../model/user.php';
    include_once '../../lib/session.php';
    $access = Session::get('root');
    if (!$access) {
        return false;
    }
    $userClass = new User();
    $response = $userClass->getUserByUsername($access);
    return $response;
}

function updateAdminPassword($pw, $new_pw, $confirm_pw) {
    include_once '../../model/user.php';
    include_once '../../lib/session.php';
    $access = Session::get('root');
    $userClass = new User();
    $response = array();
    if (!$access) {
        $response['status']  = 0;
        $response['message'] = 'Bạn không có quyền truy cập <3';
        return $response;
    }
    if (!isset($pw) or empty($pw) or !isset($new_pw) or empty($new_pw)) {
        $response['status'] = 0;
        $response['message'] = 'Vui lòng nhập mật khẩu hiện tại và mật khẩu mới';
        return $response;
    }
    if ($new_pw != $confirm_pw) {
        $response['status'] = 0;
        $response['message'] = 'Mật khẩu không khớp';
        return $response;
    }
    if (!$userClass->login_admin($access, $pw)) {
        $response['status'] = 0;
        $response['message'] = 'Mật khẩu không chính xác';
        return $response;
    }
    $userClass->updateUserPassword($access, $pw, $new_pw);
    $response['status'] = 1;
    $response['message'] = 'Cập nhập mật khẩu thành công';
    return $response;
}
?>