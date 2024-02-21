<?php

    require "connect.php";

    function validateUser($user, $password){
        $login = null;
        $sql = "SELECT `passHash` FROM users WHERE `mail` = :user OR `username` = :user AND active = 1"; 
                
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
        $insertSql = "INSERT INTO `users` (`mail`, `username`, `passHash`, `userFirstName`, `userLastName`, 
                                  `creationDate`, `removeDate`, `lastSignIn`, `active`)
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
    
    function getAllDataUsers($user){
        $sql = "SELECT * FROM users WHERE `mail` = :user OR `username` = :user AND active = 1"; 

        try {
            $conn = null;
            $conn = getDBConnection();

            $db = $conn->prepare($sql);
            $db->execute([':user' => $user]);
            return $db->fetch(); //! Envio todos los datos del usuario

        } catch (PDOStatement $e) {
            echo "ERROR: ".$e;
        }
    }

    function updateTime($user){
        $sql = "UPDATE users SET lastSignIn = :lastTime WHERE `mail` = :user OR `username` = :user";
        $dataTime = date("j-m-y H:i:s");

        try {
            $conn = null;
            $conn = getDBConnection();

            $db = $conn->prepare($sql);
            $db->execute([ ':lastTime' => $dataTime,':user' => $user]);
        } catch (PDOStatement $e) {
            echo "ERROR: ". $e;
        }
    }

    function checkUser($user){
        $exist = null;
        $sql = "SELECT * FROM users WHERE `mail` = :user OR `username` = :user";

        try {
            $conn = null;
            $conn = getDBConnection();

            $db = $conn->prepare($sql);
            $db->execute([':user' => $user]);
            $row = $db->fetch();

            $exist = $row && $row->rowCount() ? true : false;
        } catch (PDOStatement $e) {
            echo "ERROR: ". $e;
        } finally {
            return $exist;
        }
    }