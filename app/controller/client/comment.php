<?php
include_once '../../lib/session.php';
Session::init();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['post_id'])) {
            $res = getCommentsByPostID($_GET['post_id']);
            echo json_encode($res);
        }
        break;
    case 'POST':
        break;
    default:
        break;
}

/** 
 *   GET COMMENTS BY POST ID
*/
function getCommentsByPostID($postID) {
    include_once '../../lib/session.php';
    include_once '../../model/comment.php';
    $access = Session::get('user');
    $commentClass = new Comment();
    $response = $commentClass->getCommentsByPostId($postID);
    if ($response) {
        foreach ($response as $key => $value) {
            if (isset($access) and $access == $value['username']) {
                $response[$key]['owner'] = true;
            } 
            else {
                $response[$key]['owner'] = false;
            }
            unset($response[$key]['username']); 
        }
        return $response;
    } 
    else {
        return false;
    }
}
?>