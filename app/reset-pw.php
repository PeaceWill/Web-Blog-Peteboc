<?php
    include_once 'lib/session.php';
    Session::init();
    $token = isset($_GET['token']) ? $_GET['token'] : '';
    $expired = isset($_GET['e']) ? $_GET['e'] : '';
    $email = isset($_GET['email']) ? $_GET['email'] : '';
    if (!$_SESSION['auth-recover']) {
        header("location: auth-recover?token=$token&e=$expired&email=$email");
    }
    unset($_SESSION['auth-recover']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>
    <link rel="shortcut icon" href="./assets/img/logo/cropped-logo-transparent.png" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/grid.css">
    <link rel="stylesheet" href="./assets/css/recover-pw.css">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="overlay">
        <form class="form__recover box-shadow-6 font-rajdhani" action="" method="POST">
            <div class="form__reset-group">
                <label for="code">Mật khẩu mới</label>
                <input class="form__reset-input" type="password" name="password">
            </div>
            <div class="form__reset-group">
                <label for="code">Nhập lại mật khẩu</label>
                <input class="form__reset-input" type="password" name="re-password">
            </div>
            <div class="form__recover-group">
                <span class="form__recover-message"></span>
            </div>
            <input type="hidden" name="action" value="reset">
            <button class="recover__button font-rajdhani">Lấy lại mật khẩu</button>
        </form>
    </div>
</body>
<script src="./assets/js/reset-pw.js"></script>
</html>
<?php
    
?>