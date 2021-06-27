<?php
include '../lib/session.php'; // fix to call file
Session::init();

require_once 'connection.php';
require_once '../config/config.php';
class Post extends Connection
{
    private $post_table = POST_TABLE;
    private $user_table = USER_TABLE;
    private $share_table = SHARE_TABLE;

    public function __construct()
    {
        parent::__construct();
    }

    /** 
     *  SELECT FUNCTION
    */

    // Count public post of user
    public function countUserPublicPost($username)
    {
        $stmt = $this->link->prepare("SELECT COUNT(*) FROM $this->post_table WHERE username=:username AND mode=1");
        $stmt->execute(['username' => $username]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // Get all public post
    public function getAllPublicPost()
    {
        $stmt = $this->link->prepare("SELECT * FROM $this->post_table WHERE mode=1");
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // Get all post of user
    public function getAllPostByUsername($username)
    {
        $stmt = $this->link->prepare("SELECT * FROM $this->post_table WHERE username=:username");
        $stmt->execute(['username' => $username]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // Get all public post of user
    public function getPublicPostByUsername($username)
    {
        $stmt = $this->link->prepare("SELECT * FROM $this->post_table WHERE username=:username AND mode=1");
        $stmt->execute(['username' => $username]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // Get post info by id
    public function getPostById($id)
    {
        $stmt = $this->link->prepare("SELECT * FROM $this->post_table WHERE id=:id");
        $stmt->execute(['id' => $id]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    /** 
     *   INSERT FUNCTION
    */

    // Insert post
    public function insertPost($data)
    {
        $stmt = $this->link->prepare("INSERT INTO $this->post_table (username, mode, content, datetime, image) 
                                        VALUES (:username, :mode, :content, :datetime, :image)");
        $stmt->execute(['username' => $data['username'],
                        'mode' => $data['mode'],
                        'content' => $data['content'],
                        'datetime' => date('Y-m-d H:i:s'),
                        'image' => $data['image']]);
        if ($data['image_save'] != '') {
            // Lưu ảnh
        }
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    /** 
     *   UPDATE FUNCTION
    */

    // Update post mode
    public function updatePostMode($id, $username, $mode)
    {
        $stmt = $this->link->prepare("UPDATE $this->post_table SET mode=:mode WHERE id=:id AND username=:username");
        $stmt->execute(['mode' => $mode,
                        'id' => $id,
                        'username' => $username]);
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    // Update post content
    public function updatePostContent($id, $username, $content)
    {
        $stmt = $this->link->prepare("UPDATE $this->post_table SET content=:content WHERE id=:id AND username=:username");
        $stmt->execute(['content' => $content,
                        'id' => $id,
                        'username' => $username]);
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    // Update post image
    public function updatePostImage($id, $username, $image, $image_save)
    {
        $stmt = $this->link->prepare("UPDATE $this->post_table SET image=:image WHERE id=:id AND username=:username");
        $stmt->execute(['image' => $image,
                        'id' => $id,
                        'username' => $username]);
        // Lưu ảnh 

        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }
}
?>