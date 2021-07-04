<?php
include_once 'lib/session.php';
include_once 'lib/token.php';
Session::init();
var_dump($_SESSION['recover']);
?>