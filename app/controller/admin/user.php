<?php
require_once '../../model/user.php';
require_once '../../lib/session.php';
Session::init();
$userClass = new User();
$access = Session::get('root');
if ($access) {
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
    echo 'B???n c???n ????ng nh???p admin ????? truy c???p th??ng tin n??y <3';
}

function createUser($user) 
{
    include_once '../../model/user.php';
    $userClass = new User();
    if (empty($user['username'])) {
        $response = array(
            'status' => 0,
            'message' => 'Vui l??ng nh???p t??n t??i kho???n'
        );
        return $response;
    } else if (empty($user['password'])) {
        $response = array(
            'status' => 0,
            'message' => 'Vui l??ng nh???p t??n m???t kh???u'
        );
        return $response;
    } else if (empty($user['email'])) {
        $response = array(
            'status' => 0,
            'message' => 'Vui l??ng nh???p t??n t??i kho???n'
        );
        return $response;
    } else if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
        $response = array(
            'status' => 0,
            'message' => 'Email kh??ng h???p l???'
        );
        return $response;
    } else if (empty($user['realname'])) {
        $response = array(
            'status' => 0,
            'message' => 'Vui l??ng nh???p t??n h??? t??n'
        );
        return $response;
    } else {
        if ($userClass->isUsernameExisted($user['username'])) {
            $response = array(
                'status' => 0,
                'message' => 'T??i kho???n ???? t???n t???i'
            );
            return $response;
        } else if ($userClass->isEmailExisted($user['username'], $user['email'])) {
            $response = array(
                'status' => 0,
                'message' => 'Email ???? t???n t???i'
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
                    'message' => 'File upload kh??ng h???p l???'
                );
                return $response;
            } else {
                $userClass->insertUser($user);
                $userClass->insertUserInfo($user);
                $userClass->updateAvatar($user['username'], $image);
                $response = array(
                    'status' => 1,
                    'message' => 'Th??m t??i kho???n th??nh c??ng'
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
            'message' => 'Vui l??ng s??? d???ng 1 t??i kho???n'
        );
    } else if (empty($user['realname'])) {
        $response = array(
            'status' => 0,
            'message' => 'Vui l??ng nh???p h??? t??n'
        );
    } else if (empty($user['email'])) {
        $response = array(
            'status' => 0,
            'message' => 'Vui l??ng email'
        );
    } else if ($userClass->isEmailExisted($user['username'], $user['email'])) {
        $response = array(
            'status' => 0,
            'message' => 'Email ???? t???n t???i'
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
                'message' => 'File upload kh??ng h???p l???'
            );
            return $response;
        } else {
            $userClass->updateUserInfo($user);
            $userClass->updateAvatar($user['username'], $image);
            $response = array(
                'status' => 1,
                'message' => 'C???p nh???p th??nh c??ng'
            );
        }
    }
    return $response;
}

?>
