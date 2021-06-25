<?php

class Connection {
    protected $link;
    private $host = DB_SERVER;
    private $sv_user = DB_USER;
    private $sv_password = DB_PASSWORD;
    private $database = DB_DATABASE;

    public function __construct()
    {
        try {
            $dns = "mysql:host=$this->host;dbname=$this->database";
            $opt = [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $this->link = new PDO($dns, $this->sv_user, $this->sv_password, $opt);
            return $this->link;
        }
        catch (PDOException $e) {
            die('Error connect to database:'.$e->getMessage(). '</br>Line:'.$e->getLine());
        }
    }
}
?>