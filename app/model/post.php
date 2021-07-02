<?php
include_once '../../lib/session.php'; // fix to call file
Session::init();

require_once 'connection.php';
require_once '../../config/config.php';
class Post extends Connection
{
    private $post_table = POST_TABLE;
    private $share_table = SHARE_TABLE;
    private $user_table = USER_TABLE;
    private $user_info_table = USER_INFO_TABLE;

    public function __construct()
    {
        parent::__construct();
    }

    /** 
     *  SELECT FUNCTION
    */

    // Count public post of user by link
    public function countUserPublicPost($link)
    {
        $stmt = $this->link->prepare("SELECT COUNT(*) AS number FROM $this->post_table, $this->user_info_table WHERE $this->post_table.username=$this->user_info_table.username AND link=:link AND mode=1");
        $stmt->execute(['link' => $link]);
        $res = $stmt->fetch();
        if ($res['number']) {
            return $res['number'];
        } else {
            return false;
        }
    }

    // Get all public post
    public function getAllPublicPost()
    {
        $stmt = $this->link->prepare("SELECT $this->post_table.id, $this->post_table.username, $this->post_table.mode, $this->post_table.content,
                                    $this->post_table.image, $this->post_table.datetime, $this->post_table.comments, $this->post_table.shares,
                                    $this->user_info_table.realname, $this->user_info_table.avatar, $this->user_info_table.link 
                                    FROM $this->post_table JOIN $this->user_info_table ON $this->post_table.username=$this->user_info_table.username WHERE $this->post_table.mode = 1
                                    ORDER BY $this->post_table.datetime DESC");
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($res) {
            return $res;
        }
        else {
            return false;
        }
    }

    // Get posts of user by link
    public function getUserPostByLink($link)
    {
        $stmt = $this->link->prepare("SELECT $this->post_table.id, $this->post_table.mode, $this->post_table.content, $this->post_table.image,
                                    $this->post_table.comments, $this->post_table.shares, $this->post_table.datetime, $this->post_table.username,
                                    $this->user_info_table.realname, $this->user_info_table.avatar, $this->user_info_table.link
                                    FROM $this->post_table JOIN $this->user_info_table
                                    ON $this->user_info_table.username=$this->post_table.username WHERE $this->user_info_table.link=:link");
        $stmt->execute(['link' => $link]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($res) {
            return $res;
        }
        else {
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
        $stmt = $this->link->prepare("SELECT $this->post_table.id, $this->post_table.mode, $this->post_table.content, $this->post_table.image,
                                    $this->post_table.comments, $this->post_table.shares, $this->post_table.datetime, $this->post_table.username,
                                    $this->user_info_table.realname, $this->user_info_table.avatar FROM $this->post_table JOIN $this->user_info_table
                                    ON $this->user_info_table.username=$this->post_table.username WHERE id=:id");
        $stmt->execute(['id' => $id]);
        $res = $stmt->fetch();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // Check post id existed
    public function isPostIdExisted($id)
    {
        $stmt = $this->link->prepare("SELECT $this->post_table.id FROM $this->post_table WHERE id=:id");
        $stmt->execute(['id' => $id]);
        $res = $stmt->fetch();
        if ($res) {
            return true;
        }
        else {
            return false;
        }
    }

    // Check owner
    public function isOwner($id, $username)
    {
        $stmt = $this->link->prepare("SELECT $this->post_table.id FROM $this->post_table WHERE id=:id AND username=:username");
        $stmt->execute(['id' => $id,
                        'username' => $username]);
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

    // Insert post
    public function insertPost($data)
    {
        if (!empty($data['image'])) {
            $imageType = pathinfo($data['image'], PATHINFO_EXTENSION);
            $data['image'] = uniqid(strtotime(date('Y-m-d H:i:s'))).'.'.$imageType;
        }
        $stmt = $this->link->prepare("INSERT INTO $this->post_table (username, mode, content, image) 
                                        VALUES (:username, :mode, :content, :image)");
        $stmt->execute(['username' => $data['username'],
                        'mode' => $data['mode'],
                        'content' => $data['content'],
                        'image' => $data['image']]);
        if ($data['image_tmp'] != '') {
            // Lưu ảnh
            $targetFile = basename($data['image']);
            move_uploaded_file($data['image_tmp'], '../../assets/img/post/'.$targetFile);
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
        if (!empty($image)) {
            $imageType = pathinfo($image, PATHINFO_EXTENSION);
            $image = uniqid(strtotime(date('Y-m-d H:i:s'))).'.'.$imageType;
        }
        $stmt = $this->link->prepare("UPDATE $this->post_table SET image=:image WHERE id=:id AND username=:username");
        $stmt->execute(['image' => $image,
                        'id' => $id,
                        'username' => $username]);
        // Lưu ảnh 
        if ($image_save != '') {
            // Lưu ảnh
            $targetFile = basename($image);
            move_uploaded_file($image_save, '../../assets/img/post/'.$targetFile);
        }

        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    /** 
     *  DELETE FUNCTION
    */
    public function deletePost($id, $username)
    {
        $stmt = $this->link->prepare("DELETE FROM $this->post_table WHERE id=:id AND username=:username");
        $stmt->execute(['id' => $id,
                        'username' => $username]);
        if ($stmt) {
            return true;
        }
        else {
            return false;
        }
    }
}
?>