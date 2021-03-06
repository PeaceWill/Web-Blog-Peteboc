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
        $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : null;
        $message = isset($_POST['message']) ? $_POST['message'] : '';
        $token = isset($_POST['token']) ? $_POST['token'] : '';
        $res = insertComment($post_id, $message, $token);
        echo json_encode($res);
        break;
    case 'PUT':
        parse_str(file_get_contents('php://input'), $put);
        $id = isset($put['id']) ? $put['id'] : '';
        $message = isset($put['message']) ? $put['message'] : '';
        $token = isset($put['token']) ? $put['token'] : '';
        $res = updateComment($id, $message, $token);
        echo json_encode($res);
        break;
    case 'DELETE':
        parse_str(file_get_contents('php://input'), $delete);
        $id = isset($delete['id']) ? $delete['id'] : '';
        $res = deleteComment($id);
        echo json_encode($res);
        break;
    default:
        break;
}

/** 
 *   GET COMMENTS BY POST ID
*/
function getCommentsByPostID($postID) 
{
    include_once '../../lib/session.php';
    include_once '../../model/comment.php';
    $root = Session::get('root');
    $access = Session::get('user');
    $commentClass = new Comment();
    $response = $commentClass->getCommentsByPostId($postID);
    if ($response) {
        foreach ($response as $key => $value) {
            if ((isset($access) and $access == $value['username']) or ($root)) {
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

/** 
 *   INSERT COMMENT 
*/
function insertComment($post_id, $message, $token)
{
    include_once '../../lib/session.php';
    include_once '../../lib/validate.php';
    include_once '../../lib/token.php';
    include_once '../../model/comment.php';
    include_once '../../model/post.php';
    $access = Session::get(('user'));
    $validate = new Validate();
    $commentClass = new Comment();
    $postClass = new Post();
    $response = array();
    if (!Token::authToken($token)) {
        $response['status'] = 0;
        $response['message'] = 'Kh??ng c?? quy???n';
        return $response;
    }
    if (!$access) {
        $response['status'] = 0;
        $response['message'] = 'Vui l??ng ????ng nh???p';
        return $response;
    }
    if (!$post_id or !$postClass->isPostIdExisted($post_id)) {
        $response['status'] = 0;
        $response['message'] = 'Comment trong post kh??ng h???p l???';
        return $response;
    }
    $message = $validate->filter($message);
    if ($commentClass->insertComment($post_id, $access, $message)) {
        include_once '../../model/log.php';
        $log = new Log();
        $log->insertUserAction($access, 'Comment tr??n di???n ????n');

        $response['status'] = 1;
        $response['message'] = 'Comment th??nh c??ng';
        Token::renewToken();
    } else {
        $response['status'] = 0;
        $response['message'] = 'Comment th???t b???i';
    }
    return $response;
}

/** 
 *   UPDATE COMMENT
*/
function updateComment($id, $message, $token)
{
    include_once '../../lib/session.php';
    include_once '../../lib/validate.php';
    include_once '../../lib/token.php';
    include_once '../../model/comment.php';
    $access = Session::get('user');
    $validate = new Validate();
    $commentClass = new Comment();
    $response = array();
    if (!Token::authToken($token)) {
        $response['status'] = 0;
        $response['message'] = 'Kh??ng c?? quy???n';
        return $response;
    }
    if (empty($id) or empty($message)) {
        $response['status'] = 0;
        $response['message'] = 'Bi???u m???u kh??ng h???p l???';
        return $response;
    }
    if (!$commentClass->isOwnerComment($id, $access)) {
        $response['status'] = 0;
        $response['message'] = 'B???n kh??ng c?? quy???n s???a comment <3';
        return $response;
    }
    $message = $validate->filter($message);
    $result = $commentClass->updateComment($id, $access, $message);
    if ($result) {
        include_once '../../model/log.php';
        $log = new Log();
        $log->insertUserAction($access, 'Ch???nh s???a comment');

        $response['status'] = 1;
        $response['message'] = 'C???p nh???p comment th??nh c??ng';
        Token::renewToken();
    }
    else {
        $response['status'] = 0;
        $response['message'] = 'C???p nh???p comment th???t b???i';
    }
    return $response;
}

/** 
 *  DELETE COMMENT
*/
function deleteComment($id) {
    include_once '../../lib/session.php';
    include_once '../../model/comment.php';
    $root = Session::get('root');
    $access = Session::get('user');
    $commentClass = new Comment();
    $response = array();

    if ($root) {
        $result = $commentClass->deleteCommentByAdmin($id);
        if ($result) {
            $response['status'] = 1;
            $response['message'] = 'X??a comment th??nh c??ng';
        } else {
            $response['status'] = 0;
            $response['message'] = 'Kh??ng th??? x??a comment';
        }
        return $response;
    }

    if (!$commentClass->isOwnerComment($id, $access)) {
        $response['status'] = 0;
        $response['message'] = 'B???n kh??ng c?? quy???n truy c???p <3';
        return $response;
    }
    if ($commentClass->deleteComment($id, $access)) {
        include_once '../../model/log.php';
        $log = new Log();
        $log->insertUserAction($access, 'X??a comment');

        $response['status'] = 1;
        $response['message'] = 'X??a comment th??nh c??ng';
    } else {
        $response['status'] = 0;
        $response['message'] = 'Kh??ng th??? x??a comment';
    }
    return $response;
}
?>