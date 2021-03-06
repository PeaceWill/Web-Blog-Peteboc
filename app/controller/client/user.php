<?php
include_once '../../lib/session.php';
include_once '../../lib/token.php';
Session::init();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['action']) and $_GET['action'] == 'logout') {
            // Log out
            $res = logout();
            header('location:../../index.php');
        } else if (isset($_GET['token'])) {
            // Token
            $res = auth($_GET['token']);
            echo json_encode($res);
        } else if (isset($_GET['link'])) {
            // View user page
            $res = viewUserPage($_GET['link']);
            echo json_encode($res);
        } else if (isset($_GET['f'])) {
            $res = searchUser($_GET['f']);
            echo json_encode($res);
        } else {
            // Get user info
            $res = getInfo();
            echo json_encode($res);
        }
        break;
    case 'POST':
        if (isset($_POST['username']) and isset($_POST['password']) and isset($_POST['action']) and $_POST['action']=='login') {
            // Log in
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $captcha = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';
            $res = login($username, $password, $captcha);
            if ($res['status'] == 1) {
                $res['token'] = Token::generateToken();
            }
            echo json_encode($res);
        } else if (isset($_POST['action']) and $_POST['action'] == 'update') {
            // Update user info
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
        } else if (isset($_POST['action']) and $_POST['action'] == 'change-password') {
            // Update user password
            $data = array();
            foreach ($_POST as $key => $value) {
                $data[$key] = $value;
            }
            $res = updateUserPassword($data);
            echo json_encode($res);
        } else if (isset($_POST['action']) and $_POST['action'] == 'reset') {
            // Reset password
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $res = resetPassword($password);
            echo json_encode($res);
        } else {
            // Create user

            $data = array(
                'username' => isset($_POST['username']) ? $_POST['username'] : '',
                'password' => isset($_POST['password']) ? $_POST['password'] : '',
                're-password' => isset($_POST['re-password']) ? $_POST['re-password'] : '',
                'realname' => isset($_POST['realname']) ? $_POST['realname'] : '',
                'email' => isset($_POST['email']) ? $_POST['email'] : '',
                'gender' => isset($_POST['gender']) ? $_POST['gender'] : ''
            );

            $res = createUser($data);
            echo json_encode($res);
        }
        break;
    default:
        break;
}

/** 
 *  AUTHENTICATION TOKEN
 */
function auth($token)
{
    include_once '../../lib/token.php';
    if (Token::authToken($token)) {
        return 'true';
    } else {
        return 'false';
    }
}

/** 
 *  LOG IN
 */
function login($username, $password, $captcha)
{
    include_once '../../model/user.php';
    $userClass = new User();

    if (empty($captcha)) {
        $response = array(
            'status' => 0,
            'message' => 'Tích capchat'
        );
        return $response;
    } else {
        $secret_key = '6LcBnIEbAAAAAN7nu_ujBh7TOc8c2Fa0Imryk1Vt';
        $captcha_res = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$captcha);
        $captcha_data = json_decode($captcha_res);
        if (!$captcha_data->success) {
            $response = array(
                'status' => 0,
                'message' => 'Captcha không hợp lệ'
            ); 
            return $response;
        }
    }

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
    } else {
        $result = $userClass->login($username, $password);
        if ($result) {
            include_once '../../lib/token.php';
            $token = Token::generateToken();
            $response = array(
                'status' => 1,
                'message' => 'Đăng nhập thành công',
            );
            include_once '../../model/log.php';
            $logClass = new Log();
            $logClass->insertUserAction($username, 'Đăng nhập');
            $userClass->updateUserState($username, 1);
            $display = $userClass->getUserByUsername($username);
            if ($username === 'admin') {
                Session::set('root', $username);
            }
            Session::set('user', $username);
            Session::set('display', $display['realname']);
            Session::set('link', $display['link']);
            
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
    return Session::get('user');
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
 *  SEARCH USER
 */
function searchUser($key)
{
    include_once '../../model/user.php';
    $userClass = new User();
    $response = $userClass->searchUserName($key);
    return $response;
}

/** 
 *   VIEW USER PAGE
 */
function viewUserPage($link)
{
    include_once '../../model/user.php';
    include_once '../../model/post.php';
    $postClass = new Post();
    $userClass = new User();
    $response = $userClass->getUserByLink($link);
    if ($response) {
        $response['post_number'] = $postClass->countUserPublicPost($link);
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
    if (empty($data['username']) or empty($data['password']) or empty($data['realname']) or empty($data['email']) or empty($data['re-password'])) {
        $response['status'] = 0;
        $response['message'] = 'Vui lòng nhập đầy đủ thông tin';
    } else if (!$validate->validateUsername($data['username'])) {
        $response['status'] = 0;
        $response['message'] = 'Tên tài khoản phải ít nhất 6 ký tự, không gồm ký tự đặc biệt';
    } else if (!$validate->validatePassword($data['password'])) {
        $response['status'] = 0;
        $response['message'] = 'Mật khẩu tối thiểu 6 ký tự';
    } else if ($data['password'] != $data['re-password']) {
        $response['status'] = 0;
        $response['message'] = 'Mật khẩu nhập không khớp';
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
        $data['username'] = $validate->filter($data['username']);
        $data['level'] = 0;
        $data['link'] = md5(uniqid());

        $userClass->insertUser($data);
        $userClass->insertUserInfo($data);

        include_once '../../model/log.php';
        $logClass = new Log();
        $logClass->insertUserAction($data['username'], 'Tạo tài khoản thành công');

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
        if (isset($data['username']) or empty($data['realname'])) {
            $response['status'] = 0;
            $response['message'] = 'Vui lòng nhập họ tên';
            return $response;
        } else if (!isset($data['email']) or empty($data['email'])) {
            $response['status'] = 0;
            $response['message'] = 'Vui lòng nhập email';
            return $response;
        } else if (!$validate->validateEmail($data['email'])) {
            $response['status'] = 0;
            $response['message'] = 'Email không hợp lệ';
            return $response;
        } else if ($userClass->isEmailExisted($access, $data['email'])) {
            $response['status'] = 0;
            $response['message'] = 'Email đã tồn tại';
            return $response;
        } else if (!isset($data['gender']) or !$validate->validateGender($data['gender'])) {
            $response['status'] = 0;
            $response['message'] = 'Vui lòng chọn giới tính';
            return $response;
        } else if (!isset($data['link']) or empty($data['link']) or !$validate->validateUsername($data['link'])) {
            $response['status'] = 0;
            $response['message'] = 'Link không được bao gồm kí tự đặc biệt';
            return $response;
        } else if ($userClass->isLinkExisted($access, $data['link'])) {
            $response['status'] = 0;
            $response['message'] = 'Link đã tồn tại';
            return $response;
        } else {
            include_once '../../model/log.php';
            $log = new Log();
            $data['username'] = $access;
            if ($data['description']) {
                $data['description'] = $validate->filter($data['description']);
            }
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
                    $log->insertUserAction($access, 'Cập nhập thông tin');

                    $response['status'] = 1;
                    $response['message'] = 'Cập nhập thành công';
                }
            } else {
                $userClass->updateUserInfo($data);
                $log->insertUserAction($access, 'Cập nhập thông tin');

                $response['status'] = 1;
                $response['message'] = 'Cập nhập thành công';
            }
            Session::set('link', $data['link']);
        }
    }
    return $response;
}

/** 
 *  UPDATE USER PASSWORD
 */

function updateUserPassword($data)
{
    include_once '../../lib/session.php';
    include_once '../../lib/token.php';
    include_once '../../model/user.php';
    include_once '../../lib/validate.php';
    $userClass = new User();
    $validate = new Validate();
    $access = Session::get('user');
    $response = array();

    if (!Token::authToken($data['token'])) {
        $response['status'] = 0;
        $response['message'] = 'Không có quyền';
        return $response;
    }

    if (!$access) {
        $response['status'] = 0;
        $response['message'] = 'Vui lòng đăng nhập';
        return $response;
    }

    $current_pw = isset($data['current-pw']) ? $data['current-pw'] : '';
    $new_pw = isset($data['new-pw']) ? $data['new-pw'] : '';
    $confirm_pw = isset($data['comfirm-pw']) ? $data['comfirm-pw'] : '';
    if (empty($current_pw) or empty($new_pw)) {
        $response['status'] = 0;
        $response['message'] = 'Vui lòng nhập mật khẩu hiện tại và mật khẩu mới';
        return $response;
    } else if ($new_pw != $confirm_pw) {
        $response['status'] = 0;
        $response['message'] = 'Mật khẩu nhập lại không khớp';
        return $response;
    } else if (!$validate->validatePassword($new_pw)) {
        $response['status'] = 0;
        $response['message'] = 'Mật khẩu ít nhất 6 ký tự';
        return $response;
    } else if (!$userClass->login($access, $current_pw)) {
        $response['status'] = 0;
        $response['message'] = 'Mật khẩu hiện tại không chính xác';
        return $response;
    } else {
        $isSuccess = $userClass->updateUserPassword($access, $current_pw, $new_pw);
        if ($isSuccess) {
            include_once '../../model/log.php';
            $log = new Log();
            $log->insertUserAction($access, 'Đổi mật khẩu');

            $response['status'] = 1;
            $response['message'] = 'Đổi mật khẩu thành công';
            Token::renewToken();
        } else {
            $response['status'] = 0;
            $response['message'] = 'Đổi mật khẩu thất bại';
        }
        return $response;
    }
}

/** 
 *  RESET PASSWORD
 */
function resetPassword($password)
{
    include_once '../../lib/session.php';
    include_once '../../lib/validate.php';
    include_once '../../model/user.php';
    $access = Session::get('email');
    $validate = new Validate();
    $userClass = new User();
    $response = array();
    if (empty($password)) {
        $response['status'] = 0;
        $response['message'] = 'Mật khẩu không được để trống';
        return $response;
    }
    if (!$validate->validatePassword($password)) {
        $response['status'] = 0;
        $response['message'] = 'Mật khẩu không hợp lệ';
        return $response;
    }
    if (!$access) {
        $response['status'] = 0;
        $response['message'] = 'Bạn không có quyền truy cập';
        return $response;
    }
    if ($userClass->resetPassword($password, $access)) {
        include_once '../../model/log.php';
        $log = new Log();
        $log->insertUserAction($access, 'Reset mật khẩu');
        $response['status'] = 1;
        $response['message'] = 'Reset mật khẩu thành công';
    } else {
        $response['status'] = 0;
        $response['message'] = 'Reset mật khẩu thất bại';
    }
    return $response;
}
