<?php
    session_start();
    include_once '../../lib/session.php';
    
    if ($_SERVER['REQUEST_METHOD'] == 'GET' and isset($_GET['action']) and $_GET['action'] == 'logout') {
        Session::destroy();
    }

    $isLog = Session::checkSession('root');
    if (!$isLog) {
        header('Location:login.php');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="shortcut icon" href="../../assets/img/logo/cropped-logo-transparent.png" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/base.css">
    <link rel="stylesheet" href="../../assets/css/grid.css">
    <link rel="stylesheet" href="../../assets/css/admin-style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://cdn.tiny.cloud/1/rk7qull7onh332oziqtvr0khav5pwrbs8heqp1pp9twhrl5j/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="../../assets/js/chart.js"></script>
    <script src="../../assets/js/admin.js"></script>
</head>
<body>
    <div class="grid">
        <div class="row no-gutters">
            <!-- Sidebar -->
            <div class="sidebar c-0">
                <div class="sidebar__log__box flex-row-center">
                    <a class="link__on__logo flex-row-center" href="">
                        <img class="logo__image" src="../../assets/img/logo/cropped-logo-transparent.png" alt="">
                    </a>
                </div>
                <ul class="sidebar__menu font-rajdhani">
                    <li class="sidebar__menu__item">
                        <span class="sidebar__tab tab__page--active">
                            <i class="fas fa-home pad-right-10"></i>
                            Trang chủ
                        </span>
                        <ul class="sidebar__tab-list">
                            <li class="sidebar__tab-page">
                                <a class="sidebar__tab-link tab__page--active" href="index.php">Tổng quan</a>
                            </li>
                            <li class="sidebar__tab-page">
                                <a class="sidebar__tab-link" href="introduction.php">Giới thiệu</a>    
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar__menu__item">
                        <span class="sidebar__tab">
                            <i class="fas fa-user-alt pad-right-10"></i>
                            Tài khoản
                        </span>
                        <ul class="sidebar__tab-list">
                            <li class="sidebar__tab-page">
                                <a class="sidebar__tab-link" href="user-list.php">Danh sách</a>
                            </li>
                            <li class="sidebar__tab-page">
                                <a class="sidebar__tab-link" href="user-create.php">Thêm tài khoản</a>    
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar__menu__item">
                        <span class="sidebar__tab">
                            <i class="fas fa-feather pad-right-10"></i>
                            Bài viết
                        </span>
                        <ul class="sidebar__tab-list">
                            <li class="sidebar__tab-page">
                                <a class="sidebar__tab-link" href="post-list.php">Danh sách</a>
                            </li>
                            <li class="sidebar__tab-page">
                                <a class="sidebar__tab-link" href="post-flag.php">Bị cắm cờ</a>
                            </li>
                            <li class="sidebar__tab-page">
                                <a class="sidebar__tab-link" href="">Vi phạm</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
