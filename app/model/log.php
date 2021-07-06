<?php
include_once '../../lib/session.php'; // fix to call file
Session::init();

require_once 'connection.php';
require_once '../../config/config.php';

class Log extends Connection
{
    private $log_table = LOG_TABLE;
    private $user_table = USER_TABLE;

    public function __construct()
    {
        parent::__construct();
    }

    /** 
     *  SELECT FUNCTION
     */
    public function getUserAction($username)
    {
        $stmt = $this->link->prepare("SELECT $this->log_table.id, $this->log_table.action, $this->log_table.datetime
                                     FROM $this->log_table WHERE username=:username ORDER BY datetime DESC");
        $stmt->execute(['username' => $username]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    /**  
     *  INSERT FUNCTION
     */
    public function insertUserAction($username, $action)
    {
        $stmt = $this->link->prepare("INSERT INTO $this->log_table (username, action) VALUES(:username, :action)");
        $stmt->execute(['username' => $username,
                        'action' => $action]);
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }
}
