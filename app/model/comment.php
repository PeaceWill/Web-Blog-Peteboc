<?php
include_once '../../lib/session.php'; // fix to call file
Session::init();

include_once 'connection.php';
include_once '../../config/config.php';
class Comment extends Connection
{
    private $comment_table = COMMENT_TABLE;
    private $post_table = POST_TABLE;
    private $share_table = SHARE_TABLE;
    private $user_table = USER_TABLE;
    private $user_info_table = USER_INFO_TABLE;

    public function __construct()
    {
        parent::__construct();   
    }

    /** 
     *   SELECT FUNCTION
    */

    // Get comment by post id
    public function getCommentsByPostId($postID)
    {
        $stmt = $this->link->prepare("SELECT $this->comment_table.id, $this->comment_table.message, $this->comment_table.datetime, $this->user_info_table.realname ,
                                    $this->user_info_table.avatar, $this->user_info_table.link, $this->user_info_table.username FROM $this->comment_table
                                    JOIN $this->user_info_table ON $this->user_info_table.username=$this->comment_table.username WHERE post_id=:postID");
        $stmt->execute(['postID' => $postID]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($res) {
            return $res;
        } 
        else {
            return false;
        }
    }

    // Check owner's comment
    public function isOwnerComment($id, $username)
    {
        $stmt = $this->link->prepare("SELECT $this->comment_table.id FROM $this->comment_table WHERE id=:id AND username=:username");
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

    // Insert comment
    public function insertComment($post_id, $username, $message)
    {
        $stmt = $this->link->prepare("INSERT INTO $this->comment_table (post_id, username, message) VALUES (:post_id, :username, :message)");
        $stmt->execute(['post_id' => $post_id,
                        'username' => $username,
                        'message' => $message]);
        if ($stmt) {
            return true;
        }
        else {
            return false;
        }
    }

    /**  
     *   UPDATE FUNCTION
    */

    // Update comment
    public function updateComment($id, $username, $message)
    {
        $stmt = $this->link->prepare("UPDATE $this->comment_table SET message=:message WHERE id=:id AND username=:username");
        $stmt->execute(['message' => $message,
                        'id' => $id,
                        'username' => $username]);
        if ($stmt) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     *  DELETE FUNCTION 
    */

    public function deleteComment($id, $username)
    {
        $stmt = $this->link->prepare("DELETE FROM $this->comment_table WHERE id=:id AND username=:username");
        $stmt->execute(['id' => $id,
                        'username' => $username]);
        if ($stmt) {
            return true;
        }
        else {
            return false;
        }
    }

    public function deleteCommentByAdmin($id) {
        $stmt = $this->link->prepare("DELETE FROM $this->comment_table WHERE id=:id");
        $stmt->execute(['id' => $id]);
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteCommentOfPost($post_id) {
        $stmt = $this->link->prepare("DELETE FROM $this->comment_table WHERE post_id=:post_id");
        $stmt->execute(['post_id' => $post_id]);
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }
}
?>