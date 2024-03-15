<?php
    
    require "./lib/users.php";

    $codigoReset = isset($_GET['code']) ? htmlspecialchars($_GET['code']) : null;
    $mail  = isset($_GET['mail']) ? htmlspecialchars($_GET['mail']) : null;

    if (checkReset($codigoReset, $mail)) { 
        updatePassword($mail, $passHash);
    }