<?php
if (session_id() == '') {
    session_start();
}
require_once 'connection.php';
require_once '../../config/config.php';
class User extends Connection 
{
    private $user_table = USER_TABLE;
    private $user_info_table = USER_INFO_TABLE;
    public function __construct()
    {
        parent::__construct();
    }

    /** 
     *   SELECT FUNCTION
    */

    // Login admin
    public function login_admin($username, $password) 
    {
        $password = hash('sha256', $password);
        $stmt = $this->link->prepare("SELECT * FROM $this->user_table WHERE username=:username AND password=:password AND level=2");
        $stmt->execute(['username' => $username,
                        'password' => $password]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // Login user
    public function login($username, $password)
    {
        $password = hash('sha256', $password);
        $stmt = $this->link->prepare("SELECT * FROM $this->user_table WHERE username=:uesrname AND password=:password LIMIT 1");
        $stmt->execute(['username' => $username,
                        'password' => $password]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // Count all user 
    public function countAllUser()
    {
        $stmt = $this->link->prepare("SELECT COUNT(*) AS number FROM $this->user_table");
        $stmt->execute();
        return $stmt->fetch();
    }

    // Count online user 
    public function countOnlineUser()
    {
        $stmt = $this->link->prepare("SELECT COUNT(*) AS number FROM $this->user_table WHERE state=1");
        $stmt->execute();
        return $stmt->fetch();
    }

    // Count user create in week 
    public function countUserCreateWeek()
    {
        $stmt = $this->link->prepare("SELECT COUNT(*) AS number FROm $this->user_info_table WHERE WEEK(date_create)=WEEK(:current_date)");
        $stmt->execute(['current_date' => date('Y-m-d')]);
        return $stmt->fetch();
    }

    // Select all user info
    public function getUserAll()
    {
        $stmt = $this->link->prepare("SELECT * FROM $this->user_info_table");
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // Select user info by username
    public function getUserByUsername($username)
    {
        $stmt = $this->link->prepare("SELECT * FROM $this->user_info_table WHERE username=:username");
        $stmt->execute(['username' => $username]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // Check email existed
    public function isEmailExisted($email)
    {
        $stmt = $this->link->prepare("SELECT $this->user_info_table.email FROM $this->user_info_table WHERE email=:email");
        $stmt->execute(['email' => $email]);
        $res = $stmt->fetch();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }


    /** 
     *   INSERT FUNCTION
    */

    // Insert user
    public function insertUser($user)
    {
        $username = $user['username'];
        $password = hash('sha256', $user['password']);
        $level = $user['level'];

        $stmt = $this->link->prepare("INSERT INTO $this->user_table (username, password, level) VALUES (:username, :password, :level)");
        $stmt->execute(['username' => $username,
                        'password' => $password,
                        'level' => $level]);
    }

    // Insert user info
    public function insertUserInfo($data)
    {
        $username = $data['username'];
        $email = $data['email'];
        $realname = $data['realname'];
        $phone = $data['phone'];
        $address = $data['address'];
        $gender = $data['gender'];
        $link = $data['link'];
        $data_create = date('Y-m-d');
        $description = $data['description'];

        $stmt = $this->link->prepare("INSERT INTO $this->user_info_table (username, email, realname, phone, address, gender, link, date_create, description)
                                    VALUES (:username, :email, :realname, :phone, :address, :gender, :link, :date_create, :description)");
        $stmt->execute(['username' => $username,
                        'email' => $email,
                        'realname' => $realname,
                        'phone' => $phone,
                        'address' => $address,
                        'gender' => $gender,
                        'link' => $link,
                        'date_create' => $data_create,
                        'description' => $description]);
    }


    /** 
     *   UPDATE FUNCTIOM
    */

    // Update user info
    public function updateUserInfo($data)
    {
        $email = $data['email'];
        $realname = $data['realname'];
        $phone = $data['phone'];
        $address = $data['address'];
        $gender = $data['gender'];
        $link = $data['link'];
        $avatar = $data['avatar'];
        $description = $data['description'];

        $stmt = $this->link->prepare("UPDATE $this->user_info_table (email, realname, phone, address, gender, link, avatar, description)
                                    VALUES (:email, :realname, :phone, :address, :gender, :link, :avatar, :description)");
        $stmt->execute(['email' => $email,
                        'realname' => $realname,
                        'phone' => $phone,
                        'address' => $address,
                        'gender' => $gender,
                        'link' => $link,
                        'avatar' => $avatar,
                        'description' => $description]);
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUserState($username, $state) {
        $stmt = $this->link->prepare("UPDATE $this->user_table SET $this->user_table.state=:state WHERE $this->user_table.username=:username");
        $stmt->execute(['state' => $state,
                        'username' => $username]);
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    public function updateAvatar($username, $avatar)
    {
        $image = $username.'.jpg';
        $image_save = $avatar['tmp_name'];

        $imageType = pathinfo($image, PATHINFO_EXTENSION);
        $valid_type = array('jpg', 'png', 'jpeg');
        
        if (!in_array(strtolower($imageType), $valid_type)) {
            return false;
        } else {
            $stmt = $this->link->prepare("UPDATE $this->user_info_table SET avatar=:avatar WHERE username=:username");
            $stmt->execute(['avatar' => $image,
                            'username' => $username]);
    
            if ($image_save != '') {
                $targetFile = basename($image);
                move_uploaded_file($image_save, '../../assets/img/avatar/'.$targetFile);
            }
            return true;
        }

    }
}
?>