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

    // Get comment by share id 

    
}
?>