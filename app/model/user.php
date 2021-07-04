<?php
include_once '../../lib/session.php'; // fix to call file
Session::init();

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
        } 
        else {
            return false;
        }
    }

    // Login user
    public function login($username, $password)
    {
        $password = hash('sha256', $password);
        $stmt = $this->link->prepare("SELECT * FROM $this->user_table WHERE username=:username AND password=:password AND level<>2 LIMIT 1");
        $stmt->execute(['username' => $username,
                        'password' => $password]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } 
        else {
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
        $stmt = $this->link->prepare("SELECT * FROM $this->user_info_table ORDER BY date_create DESC");
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($res) {
            return $res;
        } 
        else {
            return false;
        }
    }

    // Select user info by username
    public function getUserByUsername($username)
    {
        $stmt = $this->link->prepare("SELECT $this->user_info_table.username, $this->user_info_table.realname, $this->user_info_table.email,
                                    $this->user_info_table.phone, $this->user_info_table.address, $this->user_info_table.gender, 
                                    $this->user_info_table.link, $this->user_info_table.date_create, $this->user_info_table.avatar,
                                    $this->user_info_table.description, $this->user_table.level FROM $this->user_info_table INNER JOIN $this->user_table 
                                    ON $this->user_info_table.username=$this->user_table.username 
                                    WHERE $this->user_info_table.username=:username");
        $stmt->execute(['username' => $username]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } 
        else {
            return false;
        }
    }

    // Select user info by link
    public function getUserByLink($link)
    {
        $stmt = $this->link->prepare("SELECT $this->user_info_table.realname, $this->user_info_table.avatar, $this->user_info_table.gender,
                                    $this->user_info_table.phone, $this->user_info_table.address, $this->user_info_table.description FROM $this->user_info_table WHERE link=:link");
        $stmt->execute(['link' => $link]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        }
        else {
            return false;
        }
    }

    // Check username is existed
    public function isUsernameExisted($username) {
        $stmt = $this->link->prepare("SELECT $this->user_table.username FROM $this->user_table WHERE username=:username");
        $stmt->execute(['username' => $username]);
        $res = $stmt->fetch();
        if ($res) {
            return true;
        } 
        else {
            return false;
        }
    }

    // Check email existed
    public function isEmail($email)
    {
        $stmt = $this->link->prepare("SELECT $this->user_info_table.email FROM $this->user_info_table WHERE email=:email");
        $stmt->execute(['email' => $email]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // Check email existed
    public function isEmailExisted($username, $email)
    {
        $stmt = $this->link->prepare("SELECT $this->user_info_table.email FROM $this->user_info_table WHERE email=:email AND username<>:username LIMIT 1");
        $stmt->execute(['email' => $email,
                        'username' => $username]);
        $res = $stmt->fetch();
        if ($res) {
            return true;
        } 
        else {
            return false;
        }
    }

    // Check is link existed
    public function isLinkExisted($username, $link)
    {
        $stmt = $this->link->prepare("SELECT $this->user_info_table.link FROM $this->user_info_table WHERE link=:link AND username<>:username");
        $stmt->execute(['link' => $link,
                        'username' => $username]);
        $res = $stmt->fetch();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    // Check user account is used
    public function isOnline($username)
    {
        $stmt = $this->link->prepare("SELECT $this->user_table.username FROM $this->user_table WHERE username=:username AND state=1");
        $stmt->execute(['username' => $username]);
        $res = $stmt->fetch();
        if ($res) {
            return true;
        } 
        else {
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
        $phone = isset($data['phone']) ? $data['phone'] : '';
        $address = isset($data['address']) ? $data['address'] : '';
        $gender = $data['gender'];
        $link = $data['link'];
        $description = isset($data['description']) ? $data['description'] : '';

        $stmt = $this->link->prepare("INSERT INTO $this->user_info_table (username, email, realname, phone, address, gender, link, description)
                                    VALUES (:username, :email, :realname, :phone, :address, :gender, :link, :description)");
        $stmt->execute(['username' => $username,
                        'email' => $email,
                        'realname' => $realname,
                        'phone' => $phone,
                        'address' => $address,
                        'gender' => $gender,
                        'link' => $link,
                        'description' => $description]);
    }


    /** 
     *   UPDATE FUNCTIOM
    */

    // Update user info
    public function updateUserInfo($data)
    {
        $username = $data['username'];
        $email = $data['email'];
        $realname = $data['realname'];
        $phone = isset($data['phone']) ? $data['phone'] : '';
        $address = isset($data['address']) ? $data['address'] : '';
        $gender = $data['gender'];
        $link = $data['link'];
        $description = isset($data['description']) ? $data['description'] : '';

        $stmt = $this->link->prepare("UPDATE $this->user_info_table SET email=:email, realname=:realname, phone=:phone, address=:address, gender=:gender, link=:link, description=:description 
                                    WHERE username=:username");
        $stmt->execute(['email' => $email,
                        'realname' => $realname,
                        'phone' => $phone,
                        'address' => $address,
                        'gender' => $gender,
                        'link' => $link,
                        'description' => $description,
                        'username' => $username]);
        if ($stmt) {
            return true;
        } 
        else {
            return false;
        }
    }

    // update user state
    public function updateUserState($username, $state) {
        $stmt = $this->link->prepare("UPDATE $this->user_table SET $this->user_table.state=:state WHERE $this->user_table.username=:username");
        $stmt->execute(['state' => $state,
                        'username' => $username]);
        if ($stmt) {
            return true;
        } 
        else {
            return false;
        }
    }

    // Update user avatar
    public function updateAvatar($username, $avatar)
    {
        $type = pathinfo($avatar['name'], PATHINFO_EXTENSION);
        $image = $username.'.'.$type;
        $image_save = $avatar['tmp_name'];
    
        if ($image_save != '') {
            $stmt = $this->link->prepare("UPDATE $this->user_info_table SET avatar=:avatar WHERE username=:username");
            $stmt->execute(['avatar' => $image,
                            'username' => $username]);
    
            if ($image_save != '') {
                $targetFile = basename($image);
                move_uploaded_file($image_save, '../../assets/img/avatar/'.$targetFile);
            }
        }

        return true;
    }

    // Update user password
    public function updateUserPassword($username, $password, $new_password)
    {
        $password = hash('sha256', $password);
        $new_password = hash('sha256', $new_password);
        $stmt = $this->link->prepare("UPDATE $this->user_table SET password=:new_password WHERE username=:username AND password=:password");
        $stmt->execute(['new_password' => $new_password,
                        'username' => $username,
                        'password' => $password]);
        if ($stmt) {
            return true;
        } 
        else {
            return false;
        }
    }

    // Reset password by email
    public function resetPassword($password, $email)
    {
        $password = hash('sha256', $password);
        $stmt = $this->link->prepare("UPDATE $this->user_table, $this->user_info_table SET $this->user_table.password=:password 
                                    WHERE $this->user_info_table.username=$this->user_table.username 
                                    AND $this->user_info_table.email=:email");
        $stmt->execute(['password' => $password,
                        'email' => $email]);
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }
}
