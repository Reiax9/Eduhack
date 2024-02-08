<?php

    require "./DB/connect.php";

    function validateUser($user, $pass){
        $login = false;
        $sql = "SELECT * FROM users WHERE `mail` = :user OR `username` = :user AND `passHash` = :pass"; //! Mirar más adelante

        //! Hay que hashear la contraseña y compararla con el hash que hay en la base de datos.

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