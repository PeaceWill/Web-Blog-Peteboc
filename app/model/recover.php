<?php
include_once '../../lib/session.php'; // fix to call file
Session::init();

require_once 'connection.php';
require_once '../../config/config.php';

class RecoverPassword extends Connection 
{
    private $reset_table = RESET_PASSWORD_TABLE;
    private $user_info_table = USER_INFO_TABLE;

    public function __construct()
    {
        parent::__construct();
    }

    /** 
     *  SELECT
     */

    // Get token and expired
    public function getToken($email)
    {
        $stmt = $this->link->prepare("SELECT $this->reset_table.token, $this->reset_table.expired 
                                    FROM $this->reset_table WHERE email=:email");
        $stmt->execute(['email' => $email]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    /** 
     *  INSERT
     */

    public function insertToken($email, $token, $expired)
    {
        $stmt = $this->link->prepare("INSERT INTO $this->reset_table (token, email, expired) 
                                    VALUES(:token, :email, :expired)");
        $stmt->execute([
            'token' => $token,
            'email' => $email,
            'expired' => $expired
        ]);
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    /** 
     * DELETE 
     */

    public function deleteToken($email)
    {
        $stmt = $this->link->prepare("DELETE FROM $this->reset_table WHERE email=:email");
        $stmt->execute(['email' => $email]);
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }
}
?>