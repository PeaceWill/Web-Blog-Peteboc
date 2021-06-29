<?php
    if (session_id() == '') {
        session_start();
    }
    include_once '../../lib/session.php';
    $isLog = Session::checkSession('root');
    if ($isLog) {
        header('Location: index.php');
    } else {
        include_once '../../model/user.php';
        $userClass = new User();
        if (isset($_POST['username']) and isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            if (empty($username) or empty($password)) {
                $error = 'Vui lòng nhập tài khoản và mật khẩu';
            } else {
                $res = $userClass->login_admin($_POST['username'], $_POST['password']);
                if ($res) {
                    $userClass->updateUserState($res['username'], 1);
                    Session::set('root', $res['username']);
                    header('location: index.php');
                } else {
                    $error = 'Tài khoản không chính xác';
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="shortcut icon" href="../../assets/img/logo/cropped-logo-transparent.png" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/base.css">
    <link rel="stylesheet" href="../../assets/css/grid.css">
    <link rel="stylesheet" href="../../assets/css/admin-style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500&display=swap" rel="stylesheet">
<body>
    <div class="admin__login-overlay">
        <form class="form__admin-login box-shadow-6 font-rajdhani" action="" method="POST">
            <div class="form__admin-group">
                <label for="admin-username">Username</label>
                <input class="form__admin-input font-rajdhani" type="text" name="username">
            </div>
            <div class="form__admin-group">
                <label for="admin-password">Password</label>
                <input class="form__admin-input font-rajdhani" type="password" name="password">
            </div>
            <div class="form__admin-group">
                <span id="form__message-error"><?php if (isset($error)) echo $error; ?></span>
            </div>
            <div class="flex-row-center" style="width: 100%;">
                <button id="admin__login" class="submit-button--smooth">Login</button>
            </div>
        </form>
    </div>
</body>
</html>