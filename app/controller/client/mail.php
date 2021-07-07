<?php
include_once '../../lib/session.php';
include_once '../../lib/token.php';
Session::init();

if (isset($_POST['email'])) {
    $res = getEmail($_POST['email']);
    echo json_encode($res);
}

if (isset($_GET['email']) and isset($_GET['token']) and isset($_GET['e'])) {
    authToken($_GET['email'], $_GET['token'], $_GET['e']);
}

/** 
 *  SEND EMAIL
 */
function getEmail($email)
{
    include_once '../../model/user.php';
    include_once '../../model/recover.php';
    $userClass = new User();
    $recover = new RecoverPassword();
    $response = array();
    if ($userClass->isEmail($email) == false) {
        $response['status'] = 0;
        $response['message'] = 'Email không tồn tại';
        return $response;
    } else {
        include_once '../../model/mail.php';
        $token = Token::generateRecoverToken();
        $expired = Token::setRecoverTokenExpired();
        $mail = new Mail($email, $token, $expired);
        if ($mail) {
            $recover->insertToken($email, $token, $expired);
            $response['status'] = 1;
            $response['message'] = 'Kiểm tra email của bạn';
        } else {
            $response['status'] = 0;
            $response['message'] = 'Đã có lỗi xảy ra';
        }
        return $response;
    }
}

function authToken($email, $token, $expired) {
    include_once '../../model/recover.php';
    $recover = new RecoverPassword();
    $result = $recover->getToken($token, $email);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $now = date('Y-m-d H:i:s');
    $nowTimestamp = strtotime($now);
    if ($token != $result['token'] or $result['expired'] < $nowTimestamp or $result['expired'] != $expired) {
        unset($_SESSION['auth-recover']);
        header('location: ../../recover-pw.html');
    } else {
        Session::set('auth-recover', true);
        Session::set('email', $email);
        $recover->deleteToken($email);
        header('location: ../../reset-pw.php');
    }
}
?>