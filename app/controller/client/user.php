<?php
include_once '../../lib/session.php';
Session::init();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['username']) and isset($_GET['password'])) {
            // Log in
            $username = isset($_GET['username']) ? $_GET['username'] : '';
            $password = isset($_GET['password']) ? $_GET['password'] : '';
            $res = login($username, $password);
            echo json_encode($res);
        } else if (isset($_GET['action']) and $_GET['action'] == 'logout') {
            // Log out
            logout();
        }
        else {
            // Get user info
            $res = getInfo();
            echo json_encode($res);
        }
        break;
    case 'POST':
        if (isset($_POST['action']) and $_POST['action'] == 'update') {
            // Update user
            $data = array();
            if (isset($_POST['data'])) {
                $receive = json_decode($_POST['data']);
                foreach ($receive as $key => $value) {
                    $data[$key] = $value;
                }
            }
            $data['avatar'] = isset($_FILES['avatar']['name']) ? $_FILES['avatar']['name'] : '';
            $data['avatar_save'] = isset($_FILES['avatar']['tmp_name']) ? $_FILES['avatar']['tmp_name'] : '';
            $res = updateUser($data);
            echo json_encode($res);
        } else {
            // Create user
            $data = array(
                'username' => isset($_POST['username']) ? $_POST['username'] : '',
                'password' => isset($_POST['password']) ? $_POST['password'] : '',
                'realname' => isset($_POST['realname']) ? $_POST['realname'] : '',
                'email' => isset($_POST['email']) ? $_POST['email'] : '',
                'gender' => isset($_POST['gender']) ? $_POST['gender'] : ''
            );
            $res = createUser($data);
            echo json_encode($res);
        }
        break;
    case 'PUT':
        break;
    default:
        break;
}

/** 
 *  LOG IN
*/
function login($username, $password) 
{
    include_once '../../model/user.php';
    $userClass = new User();

    if (empty($username)) {
        $response = array(
            'status' => 0,
            'message' => 'Vui lòng nhập tài khoản'
        );
    } else if (empty($password)) {
        $response = array(
            'status' => 0,
            'message' => 'Vui lòng nhập mật khẩu'
        );
    } else if ($userClass->isOnline($username)) {
        $response = array(
            'status' => 0,
            'message' => 'Tài khoản đang được xử dụng'
        );
    } else {
        $result = $userClass->login($username, $password);
        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Đăng nhập thành công'
            );
            $userClass->updateUserState($username, 1);
            Session::set('user', $username);
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Tài khoản không chính xác'
            );
        }
    }
    return $response;
}

/** 
 *  LOG OUT
*/
function logout() 
{
    include_once '../../model/user.php';
    $userClass = new User();
    $username = Session::get('user');
    $userClass->updateUserState($username, 0);
    Session::destroy();
}

/** 
 *  GET USER INFO
*/
function getInfo() 
{
    include_once '../../model/user.php';
    $userClass = new User();
    $access = Session::get('user');
    if (!$access) {
        $response = array(
            'status' => 0,
            'message' => 'Vui lòng đăng nhập'
        );
    } else {
        $response = $userClass->getUserByUsername($access);
    }
    return $response;
}

/** 
 *  INSERT USER
*/
function createUser($data)
{
    include_once '../../model/user.php';
    include_once '../../lib/validate.php';
    $userClass = new User();
    $validate = new Validate();
    $response = array();
    if (empty($data['username']) or empty($data['password']) or empty($data['realname']) or empty($data['email']) or empty($data['gender'])) {
        $response['status'] = 0;
        $response['message'] = 'Vui lòng nhập đầy đủ thông tin';
    } else if (!$validate->validateEmail($data['email'])) {
        $response['status'] = 0;
        $response['message'] = 'Email không hợp lệ';
    } else if ($userClass->isUsernameExisted($data['username'])) {
        $response['status'] = 0;
        $response['message'] = 'Tài khoản đã tồn tại';
    } else if ($userClass->isEmailExisted($data['username'], $data['email'])) {
        $response['status'] = 0;
        $response['message'] = 'Email đã tồn tại';
    } else if (!$validate->validateGender($data['gender'])) {
        $response['status'] = 0;
        $response['message'] = 'Giới tính không hợp lệ';
    } else {
        $data['level'] = 0;
        $userClass->insertUser($data);
        $userClass->insertUserInfo($data);

        $response['status'] = 1;
        $response['message'] = 'Tạo tài khoản thành công <3';
    }
    return $response;
}

/** 
 *  UPDATE USER
*/
function updateUser($data) 
{
    include_once '../../model/user.php';
    $userClass = new User();
    $access = Session::get('user');
    $response = array();
    if (!$access) {
        $response['status'] = 0;
        $response['message'] = 'Vui lòng đăng nhập <3';
    } else {
        include_once '../../lib/validate.php';
        $validate = new Validate();
        if (empty($data['realname'])) {
            $response['status'] = 0;
            $response['message'] = 'Vui lòng nhập họ tên';
        } else if (empty($data['email'])) {
            $response['status'] = 0;
            $response['message'] = 'Vui lòng nhập email';
        } else if (!$validate->validateEmail($data['email'])) {
            $response['status'] = 0;
            $response['message'] = 'Email không hợp lệ';
        } else if ($userClass->isEmailExisted($access ,$data['email'])) {
            $response['status'] = 0;
            $response['message'] = 'Email đã tồn tại';
        } else if (empty($data['gender'])) {
            $response['status'] = 0;
            $response['message'] = 'Vui lòng chọn giới tính';
        } else {
            $data['username'] = $access;
            if (!empty($data['avatar']) and !empty($data['avatar_save'])) {
                if (!$validate->validateImage($data['avatar'])) {
                    $response['status'] = 0;
                    $response['message'] = 'File ảnh không hợp lệ';
                } else {
                    $avatar = array(
                        'name' => $data['avatar'],
                        'tmp_name' => $data['avatar_save']
                    );
                    $userClass->updateUserInfo($data);
                    $userClass->updateAvatar($access, $avatar);

                    $response['status'] = 1;
                    $response['message'] = 'Cập nhập thành công';
                }
            } else {
                $userClass->updateUserInfo($data);

                $response['status'] = 1;
                $response['message'] = 'Cập nhập thành công';
            }
        }
    }
    return $response;
}
?>