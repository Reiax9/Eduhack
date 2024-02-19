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

    function registerUser($email, $name, $firstName, $lastName, $pass){
        $insertSql = "INSERT INTO `users` (`mail`, `username`, `passHash`, `userFirstName`, `userLastName`, `creationDate`, `removeDate`, `lastSignIn`, `active`)
                      VALUES (:email, :username, :pass, :firstName, :lastName, :creationDate, NULL, NULL, 1)";
        $fechaActual = date(j-m-y);

        try {
            $conn = null;
            $conn = getDBConnection();

            $db = $conn->prepare($insertSql);
            $db->execute([':email' => $email, ]);
        } catch (PDOStatment $e) {
            echo "ERROR: ".$e;
        }

    }        