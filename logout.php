<?php 
session_start();
    // $_SESSION['user_id'] = 1;
    // $_SESSION['username'] = 'ชื่อผู้ใช้ของคุณ';
    $_SESSION['login_time'] = date('Y-m-d H:i:s');
    unset($_SESSION['user_login']);
    unset($_SESSION['admin_login']);
    header('location: index.php');

?>