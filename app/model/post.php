<?php
session_start();

class PostClass 
{
    private $connect;
    private $user_table = USER_TABLE;
    private $user_info_table = USER_INFO_TABLE;
    private $post_table = POST_TABLE;

    public function __construct(\PDO $pdo)
    {
        $this->connect = $pdo;
    }

    /**
     *  Các hàm SELECT
    */

    // Lấy số lượng post
    public function countAllPost() 
    {
        $stmt = $this->connect->prepare("SELECT (*) AS number FROM $this->post_table");
        $stmt->execute();
        $res = $stmt->fetch();
        if ($res) {
            return $res; 
        } else {
            return false;
        }
    }

    // Lấy số lượng post trong tuần
    public function coutPostInWeek() 
    {
        $cuurent_date = new DateTime('now');
        $week = $cuurent_date->format('W');
        $stmt = $this->connect->prepare("SELECT * FROM $this->post_table WHERE WEEK(datetime)=:week");
        $stmt->execute(['week' => $week]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // Lấy số lượng post của user
    public function countPostByUser($username) 
    {
        $stmt = $this->connect->prepare("SELECT COUNT(*) AS number FROM $this->post_table WHERE $this->post_table.username=:username");
        $stmt->execute(['username' => $username]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // Lấy danh sách post của user
    public function getPostByUsername($username)
    {
        $stmt = $this->connect->prepare("SELECT * FROM $this->post_table WHERE $this->post_table.username=:username");
        $stmt->execute(['username' => $username]);
        $res = $stmt->fetchAll(PDO::FETCH_COLUMN);
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // Lấy thông tin post theo id
    public function getPostById($id) 
    {
        $stmt = $this->connect->prepare("SELECT * FROM $this->post_table WHERE $this->post_table.id=:id");
        $stmt->execute(['id' => $id]);
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

    // Thêm 1 post
    public function insertPost($username, $post_data)
    {
        $mode = $post_data['mode'];
        $content = $post_data['content'];
        $datetime = date('Y-m-d H:i:s');
        $image = $post_data['image'];
        $image_link = $post_data['image_link'];

        $stmt = $this->connect->prepare("INSERT INTO $this->post_table (username, mode, content, datetime, image,) 
                                        VALUE (:username, :mode, :content, :datetime, :image)");
        $stmt->execute(['username' => $username,
                        'mode' => $mode,
                        'content' => $content,
                        'datetime' => $datetime,
                        'image' => $image]);
        $res = $stmt->fetch();
        if ($res) {
            // Lưu ảnh vào file
            return $res;
        } else {
            return false;
        }
    }

    /**
    *  Các hàm UPDATE
    */

    // Update 1 post
    public function updatePost($username, $id, $data) 
    {
        $mode = $data['mode'];
        $content = $data['content'];
        $image = $data['image'];
        $image_link = $data['image_link'];

        $stmt = $this->connect->prepare("UPDATE $this->post_table SET mode=:mode, content=:content, image=:image 
                                        WHERE $this->post_table.username=:username AND $this->post_table.id=:id");
        $stmt->execute(['mode' => $mode,
                        'content' => $content,
                        'image' => $image,
                        'username' => $username,
                        'id' => $id]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    /**
    *  Các hàm DELETE 
    */

    // Delete 1 post
    public function deletePost($username, $id)
    {
        $stmt = $this->connect->prepare("DELETE FROM $this->post_table WHERE $this->post_table.id=:id AND $this->post_table.username=:username");
        $stmt->execute(['id' => $id,
                        'username' => $username]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }
}
