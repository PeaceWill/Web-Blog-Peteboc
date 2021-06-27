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
                // Insert User
                $receive = json_decode($_POST['data']);
                $data = array();
                foreach($receive as $key => $value) {
                    $data[$key] = $value;
                }
                $data['avatar'] = isset($_FILES['avatar']['name']) ? $_FILES['avatar']['name'] : '';
                $data['avatar_save'] = isset($_FILES['avatar']['tmp_name']) ? $_FILES['avatar']['tmp_name'] : null;
                $res = createUser($data);
                echo json_encode($res);
            } else if (isset($_POST['action']) and $_POST['action'] == 'update') {
                // Update User
                $receive = json_decode($_POST['data']);
                $data = array();
                foreach($receive as $key => $value) {
                    $data[$key] = $value;
                }
                $data['avatar'] = isset($_FILES['avatar']['name']) ? $_FILES['avatar']['name'] : '';
                $data['avatar_save'] = isset($_FILES['avatar']['tmp_name']) ? $_FILES['avatar']['tmp_name'] : null;
                $res = updateUser($data);
                echo json_encode($res);
            }
            break;
    }
} else {
    echo 'Bạn cần đăng nhập admin để truy cập thông tin này <3';
}

function createUser($user) 
{
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
        if ($userClass->isUsernameExisted($user['username'])) {
            $response = array(
                'status' => 0,
                'message' => 'Tài khoản đã tồn tại'
            );
            return $response;
        } else if ($userClass->isEmailExisted($user['username'], $user['email'])) {
            $response = array(
                'status' => 0,
                'message' => 'Email đã tồn tại'
            );
            return $response;
        } else {
            $image = array(
                'name' => $user['avatar'],
                'tmp_name' => $user['avatar_save']
            );

            $imageType = pathinfo($image['name'], PATHINFO_EXTENSION);
            $valid_type = array('jpg', 'png', 'jpeg');
            if (!in_array(strtolower($imageType), $valid_type) ) {
                $response = array(
                    'status' => 0,
                    'message' => 'File upload không hợp lệ'
                );
                return $response;
            } else {
                $userClass->insertUser($user);
                $userClass->insertUserInfo($user);
                $userClass->updateAvatar($user['username'], $image);
                $response = array(
                    'status' => 1,
                    'message' => 'Thêm tài khoản thành công'
                );
                return $response;
            }
        }
    }
}

function updateUser($user)
{
    include_once '../../model/user.php';
    $userClass = new User();
    if (empty($user['username'])) {
        $response = array(
            'status' => 0,
            'message' => 'Vui lòng sử dụng 1 tài khoản'
        );
    } else if (empty($user['realname'])) {
        $response = array(
            'status' => 0,
            'message' => 'Vui lòng nhập họ tên'
        );
    } else if (empty($user['email'])) {
        $response = array(
            'status' => 0,
            'message' => 'Vui lòng email'
        );
    } else if ($userClass->isEmailExisted($user['username'], $user['email'])) {
        $response = array(
            'status' => 0,
            'message' => 'Email đã tồn tại'
        );
    } else {
        $image = array(
                'name' => $user['avatar'],
                'tmp_name' => $user['avatar_save']
            );

        $imageType = pathinfo($image['name'], PATHINFO_EXTENSION);
        $valid_type = array('jpg', 'png', 'jpeg');
        if (!in_array(strtolower($imageType), $valid_type) and $image['tmp_name'] != '') {
            $response = array(
                'status' => 0,
                'message' => 'File upload không hợp lệ'
            );
            return $response;
        } else {
            $userClass->updateUserInfo($user);
            $userClass->updateAvatar($user['username'], $image);
            $response = array(
                'status' => 1,
                'message' => 'Cập nhập thành công'
            );
        }
    }
    return $response;
}

?>
