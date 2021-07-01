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
        else {
            // Get all post
            $res = getAllPost();
            echo json_encode($res);
        }
        break;
    case 'POST':
        // code
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
    $postClass = new Post();
    $response = $postClass->getAllPublicPost();
    if ($response) {
        foreach($response as $key => $value) {
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

/**  
 *  GET POSTS OF USER BY LINK
*/
function getUserPostByLink($link) {
    include_once '../../model/post.php';
    $access = Session::get('user');
    $postClass = new Post();
    $response = $postClass->getUserPostByLink($link);
    if ($response) {
        foreach($response as $key => $value) {
            if ($access == $value['username']) {
                $response[$key]['owner'] = true;
            } else {
                $response[$key]['owner'] = false;
            }
            unset($response[$key]['username']);
        }
    }
    return $response;
}
?>