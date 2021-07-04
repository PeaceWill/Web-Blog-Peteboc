<?php
include_once 'session.php';
Session::init();
class Token
{
    public static function generateToken()
    {
        $token = md5(uniqid(rand(), true));
        $_SESSION['token'] = $token;
        return $token;
    }

    public static function authToken($token)
    {
        if (isset($_SESSION['token'])) {
            if ($_SESSION['token'] === $token) {
                return true;
            }
        }
        return false;
    }

    public static function generateRecoverToken()
    {
        $recoverToken = base64_encode(hash('sha256', rand()));
        return $recoverToken;
    }

    public static function setRecoverTokenExpired()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $now = date('Y-m-d H:i:s');
        $timestamp = strtotime($now) + 3600;
        $expiredTime = $timestamp;
        return $expiredTime;
    }

    
}
