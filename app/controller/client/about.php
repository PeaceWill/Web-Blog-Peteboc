<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include_once '../../model/about.php';
    $aboutClass = new About();
    $res = $aboutClass->getAboutContent();
    echo json_encode($res['content']);
}
?>