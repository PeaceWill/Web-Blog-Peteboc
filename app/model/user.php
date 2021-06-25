<?php
session_start();
class UserClass {
    private $connect;
    private $validate;
    private $user_table = USER_TABLE;
    private $user_info_table = USER_INFO_TABLE;

    public function __construct(\PDO $pdo)
    {
        $this->connect = $pdo;
        $this->validate = new Validate();
    }

    /**
     * Các hàm SELECT
     */

    // Kiểm tra đăng nhập admin
    public function login_admin($username, $password) {
        $password = hash('sha256', $password);

        $stmt = $this->connect->prepare("SELECT * FROM $this->user_table WHERE username=:username AND password=:password AND level=2");
        $stmt->execute(['username' => $username, 
                        'password' => $password]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // Kiểm tra đăng nhập
    public function login($username, $password) {
        $password = hash('sha256', $password);

        $stmt = $this->connect->prepare("SELECT * FROM $this->user_table WHERE username=:username AND password=:password LIMIT 1");
        $stmt->execute(['username' => $username,
                        'password' => $password]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // Lấy số lượng tài khoản
    public function getAllUser() {
        $stmt = $this->connect->prepare("SELECT COUNT(*) FROM $this->user_table");
        $stmt->execute();
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // Lấy số lượng tài khoản đang online
    public function getAllUserOnline() {
        $stmt = $this->connect->prepare("SELECT COUNT(*) FROM $this->user_table WHERE state = 1");
        $stmt->execute();
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // lấy thông tin theo username
    public function getUserInfo($username) {
        $stmt = $this->connect->prepare("SELECT* FROM $this->user_info_table WHERE username=:username");
        $stmt->execute(['username' => $username]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    /**
     * Các hàm INSERT
     */

    // Admin thêm tài khoản
    public function insertUserAdmin($user) {
        $username = $user['username'];
        $password = $user['password'];
        $level = $user['level'];
        $password = hash('sha256', $password);

        $stmt = $this->connect->prepare("INSERT INTO $this->user_table (username, password, level) VALUES (:username, :password, :level)");
        $stmt->execute(['username' => $username,
                        'password' => $password,
                        'level' => $level]);
        $res = $stmt->fetch();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    // User tạo tài khoản
    public function inserUser($user) {
        $username = $this->validate->filter($user['username']);
        $password = $this->validate->filter($user['password']);
        $password = hash('sha256', $password);

        $stmt = $this->connect->prepare("INSERT INTO $this->user_table (username, password, level) VALUES (:username, :password, 0)");
        $stmt->execute(['username' => $username,
                        'password' => $password]);
        $res = $stmt->fetch();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    // Thêm user info
    public function insertUserInfo($username, $data) {
        $realname = $data['realname'];
        $email = $data['realname'];
        $gender = $data['email'];
        $link = $username;
        $date_create = date('Y-m-d');

        $stmt = $this->connect->prepare("INSERT INTO $this->user_info_table (username, realname, email, link, date_create)
                                        VALUES (:username, :realname, :email, :link, :date_create)");
        $stmt->execute(['username' => $username,
                        'realname' => $realname,
                        'email' => $email,
                        'link' => $link,
                        'date_create' => $date_create]);
        $res = $stmt->fetch();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Các hàm UPDATE
     */

    //  Update trạng thái online của user
    public function updateUserStateOnline($username) {
        $stmt = $this->connect->prepare("UPDATE $this->user_table SET state=1 WHERE username=:username");
        $stmt->execute(['username' => $username]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // Update trạng thái offline của user
    public function updateUserStateOffline($username) {
        $stmt = $this->connect->prepare("UPDATE $this->user_table SET state=0 WHERE username=:username");
        $stmt->execute(['username' => $username]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // Update thông tin user
    public function updateUserInfo($username, $data) {
        $realname = $data['realname'];
        $email = $data['email'];
        $phone = $data['phone'];
        $address = $data['address'];
        $gender = $data['gender'];
        $link = $data['link'];
        $avatar = $data['avatar'];
        $avatar_link = $data['avatar_link'];
        $desc = $data['desc'];

        $stmt = $this->connect->prepare("UPDATE $this->user_table SET realname=:realname, email=:email, phone=:phone, address=:address, gender=:gender,
                                        link=:link, avatar=:avatar, description=:description WHERE username=:username");
        $stmt->execute(['realname' => $realname,
                        'email' => $email,
                        'phone' => $phone,
                        'address' => $address,
                        'gender' => $gender,
                        'link' => $link,
                        'avatar' => $avatar,
                        'descriptopn' => $desc,
                        'username' => $username]);
        $res = $stmt->fetch();
        if ($res) {
            // Lưu ảnh vào file avatar
            return $res;
        } else {
            return false;
        }
    }

    // Update mật khẩu user
    public function updateUserPassword($username, $new_password)
    {
        $stmt = $this->connect->prepare("UPDATE $this->user_info_table SET password=:new_pw WHERE username=:username");
        $stmt->execute(['new_pw' => $new_password,
                        'username' => $username]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }
}
?>