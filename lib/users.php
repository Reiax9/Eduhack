<?php

    require "connect.php";

    function validateUser($user, $password){
        $login = null;
        $sql = "SELECT `passHash` FROM users WHERE `mail` = :user OR `username` = :user"; 

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
        $currentDate = date("j-m-y H:i:s"); // ! Formato año-mes-dia
        $passHash = password_hash($pass,PASSWORD_DEFAULT);

        try {
            $conn = null;
            $conn = getDBConnection();

            $db = $conn->prepare($insertSql);
            $db->execute([':email' => $email, ':username' => $name, ':pass' => $passHash,
                          ':firstName' => $firstName, ':lastName' => $lastName, ':creationDate' => $currentDate]);

        } catch (PDOStatement $e) {
            echo "ERROR: ".$e;
        }

    }        