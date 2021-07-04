<?php
    include_once 'lib/session.php';
    Session::init();
    $session_value = Session::get('user');
    $session_display = Session::get('display');
    
?>
<!DOCTYPE html>
<html lang="en" id="top">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pê tê bốc</title>
    <link rel="shortcut icon" href="./assets/img/logo/cropped-logo-transparent.png" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/grid.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <script src="./assets/js/modal.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="./assets/js/asteroid-alert.js"></script>
</head>
<body>
    <!-- header -->
    <header class="header box-shadow-6">
        <div class="grid wide">
            <div class="row">
                <div class="nav__header">
                    <div class="logo__wrapper">
                        <a class="logo__link" href="index.php">
                            <img class="logo__image" src="./assets/img/logo/cropped-logo-transparent.png" alt="">
                        </a>
                    </div>
                    <ul class="nav__list">
                        <li class="nav__list-item">
                            <a class="nav__list-link" href="about.php">
                                Giới thiệu
                            </a>
                        </li>
                        <li class="nav__list-item">
                            <a class="nav__list-link" href="user.php?link=<?php echo Session::get('link'); ?>">
                                Tường nhà
                            </a>
                        </li>
                        <li class="nav__list-item">
                            <?php
                                if (!Session::checkSession('user')) {
                                    $html = '
                                            <span class="nav__list-link">
                                                Tài khoản
                                                <i class="far fa-user"></i>
                                            </span>
                                            <ul class="nav__user__action">
                                                <li id="open__login__modal" class="user__action-item">
                                                    <i class="fas fa-user pad-right-10"></i>
                                                    Đăng nhập 
                                                </li>
                                                <li id="open__signup__modal" class="user__action-item">
                                                    <a class="user__action-link" href="register.html">
                                                        <i class="fas fa-signature pad-right-10"></i>
                                                        Đăng ký
                                                    </a>
                                                </li>
                                            </ul>';
                                } else {
                                    $html = '
                                            <a class="nav__list-link">
                                                '.$session_display.'
                                                <i class="far fa-user"></i>
                                            </a>
                                            <!-- list user action -->
                                            <ul class="nav__user__action">
                                                <li class="user__action-item">
                                                    <a class="user__action-link" href="profile.php">
                                                        <i class="fas fa-user pad-right-10"></i>
                                                        Tài khoản 
                                                    </a>
                                                </li>
                                                <li class="user__action-item">
                                                    <a class="user__action-link" href="controller/client/user.php?action=logout">
                                                        <i class="fas fa-sign-out-alt pad-right-10"></i>
                                                        Đăng xuất
                                                    </a>
                                                </li>
                                            </ul>';
                                }
                                echo $html;
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <!-- modal -->
    <div class="modal">
        <div class="modal__overlay">
            <div class="modal__body">
                <div class="modal__form__heading">
                    <div class="form__heading__box active__form" id="log__form">
                        Đăng nhập
                    </div>
                </div>
                <form id="form__modal-log" class="modal__form">
                    <div class="form-group">
                        <label>
                            Tên tài khoản
                        </label>
                        <input class="form-input" required type="text" name="username">
                    </div>
                    <div class="form-group">
                        <label>
                            Mật khẩu
                        </label>
                        <input class="form-input" required type="password" name="password">
                    </div>
                    <div class="form-group">
                        <span class="modal__error__message" id="modal__error__message-login"></span>
                    </div>
                    <div class="form-group">
                        <button id="log__button" class="modal__form__submit-button">Đăng nhập</button>
                    </div>

                    <div class="form-group forgot__pass">
                            <a href="recover-pw.html">Bạn quên mật khẩu ?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        catchEventLog();
        login();
    </script>