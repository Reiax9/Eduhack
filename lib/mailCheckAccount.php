<?php
    
    require "./users.php";

    $codigoActivate = isset($_GET['code']) ? htmlspecialchars($_GET['code']) : null;
    $mailActivate   = isset($_GET['mail']) ? htmlspecialchars($_GET['mail']) : null;

    if (checkCode($codigoActivate) && checkUser($mailActivate)) { 
        activateCount($mailActivate);
    }