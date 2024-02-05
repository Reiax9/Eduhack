<?php

    require "./connect.php";

    function validateUser($user, $pass){
        $login = false;
        $sql = "SELECT * FROM users WHERE `mail` = :user OR `username` = :user AND `passHash` = :pass"; //! Mirar más adelante

        try {
            $conn = '';
            $conn = getDBconnection();
            
            $db = $conn->prepare($sql);
            $db->execute([':user' => $user, ':pass' => $pass]);

            if ($db && $db->rowCount()>0) { $login = true; } //? Comprueba el usuario
            
        } finally {
            return $login;
        }
    }