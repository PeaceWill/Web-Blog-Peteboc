<?php
if (session_id() == '') {
    session_start();
}
require_once '../../model/user.php';
require_once '../../lib/session.php';
$userClass = new User();
if (Session::checkSession('root')) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (isset($_GET['action']) and $_GET['action'] == 'count') {
                $res = array(
                    'all' => $userClass->countAllUser(),
                    'online' => $userClass->countOnlineUser(),
                    'create_week' => $userClass->countUserCreateWeek()
                );
                echo json_encode($res);
            }
            else if (isset($_GET['username'])) {
                $res = $userClass->getUserByUsername($_GET['username']);
                echo json_encode($res);
            } else {
                $res = $userClass->getUserAll();
                echo json_encode($res);
            }
            break;
        case 'POST':
            if (isset($_POST['action']) and $_POST['action'] == 'create') {
                $user = array(
                    'username' => isset($_POST['username']) ? $_POST['username'] : '',
                    'password' => isset($_POST['password']) ? $_POST['password'] : '',
                    'level' => isset($_POST['level']) ? $_POST['level'] : '',
                    'email' => isset($_POST['email']) ? $_POST['email'] : '',
                    'realname' => isset($_POST['realname']) ? $_POST['realname'] : '',
                    'phone' => isset($_POST['phone']) ? $_POST['phone'] : '',
                    'address' => isset($_POST['address']) ? $_POST['address'] : '',
                    'gender' => isset($_POST['gender']) ? $_POST['gender'] : '',
                    'link' => isset($_POST['link']) ? $_POST['link'] : '',
                    'description' => isset($_POST['description']) ? $_POST['description'] : '', 
                );
                $res = createUser($user);
                echo json_encode($res);
            } else if (isset($_FILES['avatar']) and isset($_GET['username'])) {
                $avatar = array(
                    'name' => $_FILES['avatar']['name'],
                    'tmp_name' => $_FILES['avatar']['tmp_name']
                );
                $res = $userClass->updateAvatar($_GET['username'], $avatar);
                echo json_encode($res);
            }
            break;
    }
} else {
    echo 'Bạn cần đăng nhập admin để truy cập thông tin này <3';
}

function createUser($user) {
    include_once '../../model/user.php';
    $userClass = new User();
    if (empty($user['username'])) {
        $response = array(
            'status' => 0,
            'message' => 'Vui lòng nhập tên tài khoản'
        );
        return $response;
    } else if (empty($user['password'])) {
        $response = array(
            'status' => 0,
            'message' => 'Vui lòng nhập tên mật khẩu'
        );
        return $response;
    } else if (empty($user['email'])) {
        $response = array(
            'status' => 0,
            'message' => 'Vui lòng nhập tên tài khoản'
        );
        return $response;
    } else if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
        $response = array(
            'status' => 0,
            'message' => 'Email không hợp lệ'
        );
        return $response;
    } else if (empty($user['realname'])) {
        $response = array(
            'status' => 0,
            'message' => 'Vui lòng nhập tên họ tên'
        );
        return $response;
    } else {
        if ($userClass->getUserByUsername($user['username'])) {
            $response = array(
                'status' => 0,
                'message' => 'Tài khoản đã tồn tại'
            );
            return $response;
        } else if ($userClass->isEmailExisted($user['email'])) {
            $response = array(
                'status' => 0,
                'message' => 'Email đã tồn tại'
            );
            return $response;
        } else {
            $userClass->insertUser($user);
            $userClass->insertUserInfo($user);
            $response = array(
                'status' => 1,
                'message' => 'Thêm tài khoản thành công'
            );
            return $response;
        }
    }
}

?>
