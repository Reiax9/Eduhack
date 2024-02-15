<?php

    require "./lib/connect.php";

    function validateUser($user, $password){
        $login = null;
        $sql = "SELECT `passHash` FROM users WHERE `mail` = :user OR `username` = :user"; //! Mirar más adelante

        try {
            $conn = null;
            $conn = getDBconnection();
            
            $db = $conn->prepare($sql);
            $db->execute([':user' => $user]);
            $row = $db->fetch();

            $login = $row && password_verify($password, $row['passHash']) ? true : false; //? Retorna si es correcto el login
        } finally {
            return $login;
        }
    }