<?php
    session_start();
    session_destroy();
    unset($_COOKIE['loginSuccess']);
    setcookie('loginSuccess', '', time() - 3600, '/Eduhack');
    header("Location: ../index.php");
    exit(0);
?>