<?php
class Session {
    public static function init() {
        if (version_compare(phpversion(), '5.4.0', '<')) {
            if (session_id() == '') {
                session_name('QkyzoasswiftzxTz');
                session_start();
            }
        } else {
            if (session_status() == PHP_SESSION_NONE) {
                session_name('QkyzoasswiftzxTz');
                session_start();
            }
        }
    }

    public static function set($key, $value) {
        return $_SESSION[$key] = $value;
    }

    public static function get($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    public static function checkLogin($key) {
        self::init();
        if (self::get($key) == true) {
            
            return true;
        } else {
            return false;
        }
    }

    public static function checkSession($key) {
        self::init();
        if (self::get($key) == false) {
            session_destroy();
            return false;
        } else {
            return true;
        }
    }


    public static function destroy() {
        session_destroy();
    }
}
?>