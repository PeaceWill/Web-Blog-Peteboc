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
        $res = insertComment($post_id, $message);
        echo json_encode($res);
        break;
    case 'PUT':
        parse_str(file_get_contents('php://input'), $put);
        $id = isset($put['id']) ? $put['id'] : '';
        $message = isset($put['message']) ? $put['message'] : '';
        $res = updateComment($id, $message);
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
function insertComment($post_id, $message)
{
    include_once '../../lib/session.php';
    include_once '../../lib/validate.php';
    include_once '../../model/comment.php';
    include_once '../../model/post.php';
    $access = Session::get(('user'));
    $validate = new Validate();
    $commentClass = new Comment();
    $postClass = new Post();
    $response = array();
    if (!$access) {
        $response['status'] = 0;
        $response['message'] = 'Vui lòng đăng nhập';
        return $response;
    }
    if (!$post_id or !$postClass->isPostIdExisted($post_id)) {
        $response['status'] = 0;
        $response['message'] = 'Comment trong post không hợp lệ';
        return $response;
    }
    $message = $validate->filter($message);
    if ($commentClass->insertComment($post_id, $access, $message)) {
        include_once '../../model/log.php';
        $log = new Log();
        $log->insertUserAction($access, 'Comment trên diễn đàn');

        $response['status'] = 1;
        $response['message'] = 'Comment thành công';
    } else {
        $response['status'] = 0;
        $response['message'] = 'Comment thất bại';
    }
    return $response;
}

/** 
 *   UPDATE COMMENT
*/
function updateComment($id, $message)
{
    include_once '../../lib/session.php';
    include_once '../../lib/validate.php';
    include_once '../../model/comment.php';
    $access = Session::get('user');
    $validate = new Validate();
    $commentClass = new Comment();
    $response = array();
    if (empty($id) or empty($message)) {
        $response['status'] = 0;
        $response['message'] = 'Biểu mẫu không hợp lệ';
        return $response;
    }
    if (!$commentClass->isOwnerComment($id, $access)) {
        $response['status'] = 0;
        $response['message'] = 'Bạn không có quyền sửa comment <3';
        return $response;
    }
    $message = $validate->filter($message);
    $result = $commentClass->updateComment($id, $access, $message);
    if ($result) {
        include_once '../../model/log.php';
        $log = new Log();
        $log->insertUserAction($access, 'Chỉnh sửa comment');

        $response['status'] = 1;
        $response['message'] = 'Cập nhập comment thành công';
    }
    else {
        $response['status'] = 0;
        $response['message'] = 'Cập nhập comment thất bại';
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
            $response['message'] = 'Xóa comment thành công';
        } else {
            $response['status'] = 0;
            $response['message'] = 'Không thể xóa comment';
        }
        return $response;
    }

    if (!$commentClass->isOwnerComment($id, $access)) {
        $response['status'] = 0;
        $response['message'] = 'Bạn không có quyền truy cập <3';
        return $response;
    }
    if ($commentClass->deleteComment($id, $access)) {
        include_once '../../model/log.php';
        $log = new Log();
        $log->insertUserAction($access, 'Xóa comment');

        $response['status'] = 1;
        $response['message'] = 'Xóa comment thành công';
    } else {
        $response['status'] = 0;
        $response['message'] = 'Không thể xóa comment';
    }
    return $response;
}
?>