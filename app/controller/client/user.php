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
            'message' => 'T??ch capchat'
        );
        return $response;
    } else {
        $secret_key = '6LcBnIEbAAAAAN7nu_ujBh7TOc8c2Fa0Imryk1Vt';
        $captcha_res = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$captcha);
        $captcha_data = json_decode($captcha_res);
        if (!$captcha_data->success) {
            $response = array(
                'status' => 0,
                'message' => 'Captcha kh??ng h???p l???'
            ); 
            return $response;
        }
    }

    if (empty($username)) {
        $response = array(
            'status' => 0,
            'message' => 'Vui l??ng nh???p t??i kho???n'
        );
    } else if (empty($password)) {
        $response = array(
            'status' => 0,
            'message' => 'Vui l??ng nh???p m???t kh???u'
        );
    } else {
        $result = $userClass->login($username, $password);
        if ($result) {
            include_once '../../lib/token.php';
            $token = Token::generateToken();
            $response = array(
                'status' => 1,
                'message' => '????ng nh???p th??nh c??ng',
            );
            include_once '../../model/log.php';
            $logClass = new Log();
            $logClass->insertUserAction($username, '????ng nh???p');
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
                'message' => 'T??i kho???n kh??ng ch??nh x??c'
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
            'message' => 'Vui l??ng ????ng nh???p'
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
        $response['message'] = 'Vui l??ng nh???p ?????y ????? th??ng tin';
    } else if (!$validate->validateUsername($data['username'])) {
        $response['status'] = 0;
        $response['message'] = 'T??n t??i kho???n ph???i ??t nh???t 6 k?? t???, kh??ng g???m k?? t??? ?????c bi???t';
    } else if (!$validate->validatePassword($data['password'])) {
        $response['status'] = 0;
        $response['message'] = 'M???t kh???u t???i thi???u 6 k?? t???';
    } else if ($data['password'] != $data['re-password']) {
        $response['status'] = 0;
        $response['message'] = 'M???t kh???u nh???p kh??ng kh???p';
    } else if (!$validate->validateEmail($data['email'])) {
        $response['status'] = 0;
        $response['message'] = 'Email kh??ng h???p l???';
    } else if ($userClass->isUsernameExisted($data['username'])) {
        $response['status'] = 0;
        $response['message'] = 'T??i kho???n ???? t???n t???i';
    } else if ($userClass->isEmailExisted($data['username'], $data['email'])) {
        $response['status'] = 0;
        $response['message'] = 'Email ???? t???n t???i';
    } else if (!$validate->validateGender($data['gender'])) {
        $response['status'] = 0;
        $response['message'] = 'Gi???i t??nh kh??ng h???p l???';
    } else {
        $data['username'] = $validate->filter($data['username']);
        $data['level'] = 0;
        $data['link'] = md5(uniqid());

        $userClass->insertUser($data);
        $userClass->insertUserInfo($data);

        include_once '../../model/log.php';
        $logClass = new Log();
        $logClass->insertUserAction($data['username'], 'T???o t??i kho???n th??nh c??ng');

        $response['status'] = 1;
        $response['message'] = 'T???o t??i kho???n th??nh c??ng <3';
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
        $response['message'] = 'Vui l??ng ????ng nh???p <3';
    } else {
        include_once '../../lib/validate.php';
        $validate = new Validate();
        if (isset($data['username']) or empty($data['realname'])) {
            $response['status'] = 0;
            $response['message'] = 'Vui l??ng nh???p h??? t??n';
            return $response;
        } else if (!isset($data['email']) or empty($data['email'])) {
            $response['status'] = 0;
            $response['message'] = 'Vui l??ng nh???p email';
            return $response;
        } else if (!$validate->validateEmail($data['email'])) {
            $response['status'] = 0;
            $response['message'] = 'Email kh??ng h???p l???';
            return $response;
        } else if ($userClass->isEmailExisted($access, $data['email'])) {
            $response['status'] = 0;
            $response['message'] = 'Email ???? t???n t???i';
            return $response;
        } else if (!isset($data['gender']) or !$validate->validateGender($data['gender'])) {
            $response['status'] = 0;
            $response['message'] = 'Vui l??ng ch???n gi???i t??nh';
            return $response;
        } else if (!isset($data['link']) or empty($data['link']) or !$validate->validateUsername($data['link'])) {
            $response['status'] = 0;
            $response['message'] = 'Link kh??ng ???????c bao g???m k?? t??? ?????c bi???t';
            return $response;
        } else if ($userClass->isLinkExisted($access, $data['link'])) {
            $response['status'] = 0;
            $response['message'] = 'Link ???? t???n t???i';
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
                    $response['message'] = 'File ???nh kh??ng h???p l???';
                } else {
                    $avatar = array(
                        'name' => $data['avatar'],
                        'tmp_name' => $data['avatar_save']
                    );
                    $userClass->updateUserInfo($data);
                    $userClass->updateAvatar($access, $avatar);
                    $log->insertUserAction($access, 'C???p nh???p th??ng tin');

                    $response['status'] = 1;
                    $response['message'] = 'C???p nh???p th??nh c??ng';
                }
            } else {
                $userClass->updateUserInfo($data);
                $log->insertUserAction($access, 'C???p nh???p th??ng tin');

                $response['status'] = 1;
                $response['message'] = 'C???p nh???p th??nh c??ng';
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
        $response['message'] = 'Kh??ng c?? quy???n';
        return $response;
    }

    if (!$access) {
        $response['status'] = 0;
        $response['message'] = 'Vui l??ng ????ng nh???p';
        return $response;
    }

    $current_pw = isset($data['current-pw']) ? $data['current-pw'] : '';
    $new_pw = isset($data['new-pw']) ? $data['new-pw'] : '';
    $confirm_pw = isset($data['comfirm-pw']) ? $data['comfirm-pw'] : '';
    if (empty($current_pw) or empty($new_pw)) {
        $response['status'] = 0;
        $response['message'] = 'Vui l??ng nh???p m???t kh???u hi???n t???i v?? m???t kh???u m???i';
        return $response;
    } else if ($new_pw != $confirm_pw) {
        $response['status'] = 0;
        $response['message'] = 'M???t kh???u nh???p l???i kh??ng kh???p';
        return $response;
    } else if (!$validate->validatePassword($new_pw)) {
        $response['status'] = 0;
        $response['message'] = 'M???t kh???u ??t nh???t 6 k?? t???';
        return $response;
    } else if (!$userClass->login($access, $current_pw)) {
        $response['status'] = 0;
        $response['message'] = 'M???t kh???u hi???n t???i kh??ng ch??nh x??c';
        return $response;
    } else {
        $isSuccess = $userClass->updateUserPassword($access, $current_pw, $new_pw);
        if ($isSuccess) {
            include_once '../../model/log.php';
            $log = new Log();
            $log->insertUserAction($access, '?????i m???t kh???u');

            $response['status'] = 1;
            $response['message'] = '?????i m???t kh???u th??nh c??ng';
            Token::renewToken();
        } else {
            $response['status'] = 0;
            $response['message'] = '?????i m???t kh???u th???t b???i';
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
        $response['message'] = 'M???t kh???u kh??ng ???????c ????? tr???ng';
        return $response;
    }
    if (!$validate->validatePassword($password)) {
        $response['status'] = 0;
        $response['message'] = 'M???t kh???u kh??ng h???p l???';
        return $response;
    }
    if (!$access) {
        $response['status'] = 0;
        $response['message'] = 'B???n kh??ng c?? quy???n truy c???p';
        return $response;
    }
    if ($userClass->resetPassword($password, $access)) {
        include_once '../../model/log.php';
        $log = new Log();
        $log->insertUserAction($access, 'Reset m???t kh???u');
        $response['status'] = 1;
        $response['message'] = 'Reset m???t kh???u th??nh c??ng';
    } else {
        $response['status'] = 0;
        $response['message'] = 'Reset m???t kh???u th???t b???i';
    }
    return $response;
}
