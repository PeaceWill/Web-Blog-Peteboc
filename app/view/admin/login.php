<?php
    if (session_id() == '') {
        session_start($_COOKIE['PHPSESSID']);
    }
    include_once '../../lib/session.php';
    $isLog = Session::checkSession('root');
    if ($isLog) {
        header('Location: index.php');
    }
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['username']) and isset($_GET['password'])) {
            include_once '../../config/config.php';
            include_once '../../lib/database.php';
            include_once '../../lib/validate.php';
            include_once '../../model/user.php';
            $userClass = new UserClass($pdo);

            $adminLog = $userClass->login_admin($_GET['username'], $_GET['password']);
            if (!$adminLog) {
                $error = 'Tài khoản không chính xác';
            } else {
                Session::set('root', true);
                header('Location:index.php');
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
</head>
<body>
    <div class="admin__login-overlay">
        <form class="form__admin-login box-shadow-6 font-rajdhani" action="" method="GET">
            <div class="form__admin-group">
                <label for="admin-username">Username</label>
                <input class="form__admin-input font-rajdhani" type="text" name="username">
            </div>
            <div class="form__admin-group">
                <label for="admin-password">Password</label>
                <input class="form__admin-input font-rajdhani" type="password" name="password">
            </div>
            <div class="form__admin-group">
                <span id="form__message-error"><?php if(isset($error)) echo $error; ?></span>
            </div>
            <div class="flex-row-center" style="width: 100%;">
                <button id="admin__login" class="submit-button--smooth">Login</button>
            </div>
        </form>
    </div>
</body>
</html>