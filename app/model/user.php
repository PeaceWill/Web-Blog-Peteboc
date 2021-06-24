<?php
session_start();
class User {
    private $connect;
    private $validate;
    private $user_table = USER_TABLE;

    public function __construct(\PDO $pdo)
    {
        $this->connect = $pdo;
        $this->validate = new Validate();
    }

    public function login_admin($username, $password) {
        $username = $this->validate->filter($username);
        $password = $this->validate->filter($password);
        $password = hash('sha256', $password);

        $stmt = $this->connect->prepare("SELECT * FROM $this->user_table WHERE username=:username AND password=:password AND level=2");
        $stmt->execute(['username' => $username, 
                        'password' => $password]);
        $result = $stmt->fetch();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function login($username, $password) {
        $username = $this->validate->filter($username);
        $password = $this->validate->filter($password);
        $password = hash('sha256', $password);

        $stmt = $this->connect->prepare("SELECT * FROM $this->user_table WHERE username=:username AND password=:password LIMIT 1");
        $stmt->execute(['username' => $username,
                        'password' => $password]);
        $result = $stmt->fetch();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function insertUserAdmin($user) {
        $username = isset($user['username']) ? $user['username'] : '';
        $password = isset($user['password']) ? $user['password'] : '';
        $level = isset($user['level']) ? $user['level'] : '';
        $realname = isset($user['realname']) ? $user['realname'] : '';
        $email = isset($user['email']) ? $user['email'] : '';
        $phone = isset($user['phone']) ? $user['phone'] : '';
        $address = isset($user['address']) ? $user['address'] : '';
        $gender = isset($user['gender']) ? $user['gender'] : '';
        $link = isset($user['link']) ? $user['link'] : '';
        $avatar = isset($user['avatar']) ? $user['avatar'] : '';
        $description = isset($user['description']) ? $user['description'] : '';


        $username = $this->validate->filter($username);
        $password = $this->validate->filter($password);
        $password = hash('sha256', $password);

        $stmt = $this->connect->prepare("INSERT INTO $this->user_table (username, password, level) VALUES (:username, :password, :level)");
        $stmt->execute(['username' => $username,
                        'password' => $password,
                        'level' => $level]);
        $result = $stmt->fetch();
        $response = array();
        if ($result) {
            $response['status'] = 1;
            $response['message'] = 'Thêm tài khoản thành công';
        } else {
            $response['status'] = 0;
            $response['message'] = 'Thêm tài khoản thất bại';
        }
        return $response;
    }
}
?>