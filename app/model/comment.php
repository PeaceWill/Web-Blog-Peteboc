<?php
include '../lib/session.php'; // fix to call file
Session::init();

require_once 'connection.php';
require_once '../config/config.php';
class Comment extends Connection
{
    private $comment_table = COMMENT_TABLE;
    private $post_table = POST_TABLE;
    private $share_table = SHARE_TABLE;
    private $user_table = USER_TABLE;

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
        $stmt = $this->link->prepare("SELECT *, $this->user_table.realname FROM $this->comment_table
                                     INNER JOIN $this->user_table ON $this->user_table.username=$this->comment_table.username WHERE post_id=:postID");
        $stmt->execute(['postID' => $postID]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    // Get comment by share id 

    
}
?>