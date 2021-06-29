<?php
include_once 'session.php';
Session::init();
class Token {
    public static function generateToken() {
        $token = md5(uniqid(rand(), true));
        $_SESSION['token'] = $token;
        return $token;
    }

    public static function authToken($token) {
        if (isset($_SESSION['token'])) {
            if ($_SESSION['token'] === $token) {
                return true;
            }
        }
        return false;
    }
}
