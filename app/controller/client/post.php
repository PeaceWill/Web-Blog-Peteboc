<?php
include_once '../../lib/session.php';
Session::init();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['link'])) {
            // Get posts of user by link
            $res = getUserPostByLink($_GET['link']);
            echo json_encode($res);
        }
        else if (isset($_GET['id'])) {
            // Get post info by id
            $id = isset($_GET['id']) ? $_GET['id'] : '';
            $res = getPostById($id);
            echo json_encode($res);
        }
        else {
            // Get all post
            $res = getAllPost();
            echo json_encode($res);
        }
        break;
    case 'POST':
        if (isset($_POST['action']) and $_POST['action'] == 'update') {
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            $content = isset($_POST['content']) ? $_POST['content']: '';
            $token = isset($_POST['token']) ? $_POST['token'] : '';
            $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
            $image_save = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : '';
            $res = updatePost($id, $content, $image, $image_save, $token);
            echo json_encode($res);
        }
        else {
            $data = array();
            $receive = json_decode($_POST['data']);
            if (isset($_POST['data'])) {
                foreach ($receive as $key => $value) {
                    $data[$key] = $value;
                }
            }
            $token = isset($_POST['token']) ? $_POST['token'] : '';
            $data['image'] = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
            $data['image_type'] = isset($_FILES['image']['type']) ? $_FILES['image']['type'] : '';
            $data['image_tmp'] = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : '';
            $res = uploadPost($data, $token);
            echo json_encode($res);
        }
        break;
    case 'DELETE':
        parse_str(file_get_contents('php://input'), $delete);
        $id = isset($delete['id']) ? $delete['id'] : '';
        $res = deletePost($id);
        echo json_encode($res);
        break;
    default:
        break;
}

/**  
 *   GET ALL POST
*/

function getAllPost() {
    include_once '../../lib/session.php';
    include_once '../../model/post.php';
    $access = Session::get('user');
    $root = Session::get('root');
    $postClass = new Post();
    $response = $postClass->getAllPublicPost();
    if ($response) {
        foreach($response as $key => $value) {
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
 *  GET POSTS OF USER BY LINK
*/
function getUserPostByLink($link) {
    include_once '../../lib/session.php';
    include_once '../../model/post.php';
    $root = Session::get('root');
    $access = Session::get('user');
    $postClass = new Post();
    $response = $postClass->getUserPostByLink($link);
    if ($response) {
        foreach($response as $key => $value) {
            if (($access == $value['username']) or ($root)) {
                $response[$key]['owner'] = true;
            } else {
                $response[$key]['owner'] = false;
            }
            unset($response[$key]['username']);
        }
    }
    return $response;
}

/** 
 *  GET POST INFO BY ID
*/
function getPostById($id) {
    include_once '../../lib/session.php';
    include_once '../../model/post.php';
    $access = Session::get('user');
    $postClass = new Post();
    $response = $postClass->getPostById($id);
    if ($response['username'] === $access) {
        $response['owner'] = true;
    } else {
        $response['owner'] = false;
    }
    unset($response['username']);
    return $response;
}

/** 
 *   UPLOAD POST
*/
function uploadPost($data, $token) {
    include_once '../../lib/validate.php';
    include_once '../../lib/session.php';
    include_once '../../lib/token.php';
    include_once '../../model/post.php';
    $access = Session::get('user');
    $validate = new Validate();
    $postClass = new Post();
    if (!$access) {
        $response = array(
            'status' => 0,
            'message' => 'Vui lòng đăng nhập'
        );
        return $response;
    }
    if (!Token::authToken($token)) {
        $response = array(
            'status' => 0,
            'message' => 'Không có quyền'
        );
        return $response;
    }
    if (!empty($data['image']) and !$validate->validateImage($data['image'])) {
        $response = array(
            'status' => 0,
            'message' => 'Ảnh không hợp lệ'
        );
        return $response;
    }
    if (!isset($data['content'])) {
        $data['content'] = '';
    }
    $data['username'] = $access;
    $data['mode'] = 1;
    $res = $postClass->insertPost($data);
    if ($res) {
        include_once '../../model/log.php';
        $log = new Log();
        $log->insertUserAction($access, 'Đăng bài viết');

        $response = array(
            'status' => 1,
            'message' => 'Đăng bài viết thành công'
        );
        Token::renewToken();
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Đăng bài viết không thành'
        );
    }
    return $response;
}

/** 
 *  UPDATE POST
*/
function updatePost($id, $content, $image, $image_save, $token) {
    include_once '../../lib/session.php';
    include_once '../../lib/validate.php';
    include_once '../../lib/token.php';
    include_once '../../model/post.php';
    $access = Session::get('user');
    $validate = new Validate();
    $postClass = new Post();
    $response = array();
    $content = $validate->filter($content);
    if (!Token::authToken($token) or empty($token)) {
        $response['status'] = 0;
        $response['message'] = $token;
        return $response;
    }
    if (!$id) {
        $response['status'] = 0;
        $response['message'] = 'ID không hợp lệ';
        return $response;
    }
    if (!$postClass->isOwner($id, $access)) {
        $response['status'] = 0;
        $response['message'] = 'Bạn không có quyền truy cập <3';
        return $response;
    }
    if ($image and !$validate->validateImage($image)) {
        $response['status'] = 0;
        $response['message'] = 'File ảnh không hợp lệ';
        return $response;
    }
    if ($image) {
        if ($postClass->updatePostContent($id, $access, $content) and $postClass->updatePostImage($id, $access, $image, $image_save)){
            $response['status'] = 1;
            $response['message'] = 'Cập nhập thành công';
        } 
        else {
            $response['status'] = 0;
            $response['message'] = 'Cập nhập không thành công';
        }
    }
    else {
        if ($postClass->updatePostContent($id, $access, $content)) {
            $response['status'] = 1;
            $response['message'] = 'Cập nhập thành công';
        }
        else {
            $response['status'] = 0;
            $response['message'] = 'Cập nhập không thành công';
        }
    }
    if ($response['status'] == 1) {
        include_once '../../model/log.php';
        $log = new Log();
        $log->insertUserAction($access, 'Cập nhập bài viết');
        Token::renewToken();
    }
    return $response;
}

/** 
 *  DELETE POST
*/
function deletePost($id) {
    include_once '../../lib/session.php';
    include_once '../../model/post.php';
    $access = Session::get('user');
    $root = Session::get('root');
    $postClass = new Post();
    $response = array();

    if ($root) {
        $result = $postClass->deletePostByAdmin($id);
        if ($result) {
            include_once '../../model/comment.php';
            $comment = new Comment();
            $comment->deleteCommentOfPost($id);

            $response['status'] = 1;
            $response['message'] = 'Xóa thành công';
        }
        else {
            $response['status'] = 0;
            $response['message'] = 'Xóa thất bại';
        }
        return $response;
    }

    if (!$postClass->isOwner($id, $access)) {
        $response['status'] = 0;
        $response['message'] = 'Bạn không có quyền truy cập <3';
        return $response;
    }
    $result = $postClass->deletePost($id, $access);
    if ($result) {
        include_once '../../model/log.php';
        include_once '../../model/comment.php';
        $log = new Log();
        $comment = new Comment();
        $log->insertUserAction($access, 'Xóa bài viết');
        $comment->deleteCommentOfPost($id);

        $response['status'] = 1;
        $response['message'] = 'Xóa thành công';
    }
    else {
        $response['status'] = 0;
        $response['message'] = 'Xóa thất bại';
    }
    return $response;
}
?>