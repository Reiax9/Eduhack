<?php

    require_once "connect.php";

    function validateUser($user, $password){
        $login = null;
        $sql = "SELECT `passHash` FROM users WHERE `mail` = :user OR `username` = :user AND active = 1"; 
                
        try {
            $conn = null;
            $conn = getDBconnection();
            
            $db = $conn->prepare($sql);
            $db->execute([':user' => $user]);
            $row = $db->fetch();

            $login = $row && password_verify($password, $row['passHash']) ? true : false;
        } finally {
            return $login;
        }
    }

    function registerUser($email, $name, $firstName, $lastName, $pass){
        $insertSql = "INSERT INTO `users` (`mail`, `username`, `passHash`, `userScore`, `userFirstName`, `userLastName`, 
                                  `creationDate`, `activationDate`,`activationCode`,`resetPassExpiry`,
                                  `resetPassCode`, `removeDate`, `lastSignIn`, `active`)
                        VALUES (  :email, :username, :pass, 0, :firstName, :lastName, 
                                  :creationDate, NULL, :activationCode, NULL,
                                  NULL, NULL,  NULL, 0)";

        $currentDate = date("Y-m-d H:i:s"); // ! Formato año-mes-dia
        $passHash = password_hash($pass,PASSWORD_DEFAULT);
        $activationCode = hash('sha256', rand());

        try {
            $conn = null;
            $conn = getDBConnection();

            $db = $conn->prepare($insertSql);
            $db->execute([  
                ':email'            => $email, 
                ':username'         => $name,
                ':pass'             => $passHash,
                ':firstName'        => $firstName,
                ':lastName'         => $lastName,
                ':creationDate'     => $currentDate,
                ':activationCode'   => $activationCode
            ]);

        } catch (PDOStatement $e) {
            echo $e->getMessage();
        }
    }
    
    function activateCount($mail){
        $sql = "UPDATE users 
                SET active = 1, activationCode = NULL, activationDate = :currentDate
                WHERE `mail` = :mail"; 

        $currentDate = date("Y-m-d H:i:s");

        try {
            $conn = null;
            $conn = getDBConnection();

            $db = $conn->prepare($sql);
            $db->execute([':currentDate' => $currentDate, ':mail' => $mail]);
            header("Location: ../index.php");
        } catch (PDOStatement $e) {
            echo $e->getMessage();
        }
    }

//<> ====================================== DATA ============================================= 
    
    function getAllDataUsers($user){
        $sql = "SELECT * FROM users WHERE `mail` = :user OR `username` = :user AND active = 1"; 

        try {
            $conn = null;
            $conn = getDBConnection();

            $db = $conn->prepare($sql);
            $db->execute([':user' => $user]);
            return $db->fetch(); //! Envio todos los datos del usuario

        } catch (PDOStatement $e) {
            echo $e->getMessage();
        }
    }

    function getAllDataUsersDes($user){
        $sql = "SELECT * FROM users WHERE `mail` = :user OR `username` = :user"; 

        try {
            $conn = null;
            $conn = getDBConnection();

            $db = $conn->prepare($sql);
            $db->execute([':user' => $user]);
            return $db->fetch(); //! Envio todos los datos del usuario

        } catch (PDOStatement $e) {
            echo $e->getMessage();
        }
    }

    function updateTime($user){
        $sql = "UPDATE users SET lastSignIn = :lastTime WHERE `mail` = :user OR `username` = :user";
        $dataTime = date("Y-m-d H:i:s");

        try {
            $conn = null;
            $conn = getDBConnection();

            $db = $conn->prepare($sql);
            $db->execute([ ':lastTime' => $dataTime,':user' => $user]);
        } catch (PDOStatement $e) {
            echo $e->getMessage();
        }
    }

//? =================================== CHECK =============================================

    function checkUser($user){
        $exist = null;
        $sql = "SELECT * FROM users WHERE `mail` = :user OR `username` = :user";

        try {
            $conn = null;
            $conn = getDBConnection();

            $db = $conn->prepare($sql);
            $db->execute([':user' => $user]);

            $exist = $db && $db->rowCount() > 0 ? true : false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            return $exist;
        }
    }

    function checkCode($code){
        $exist = null;
        $sql = "SELECT * FROM users WHERE `activationCode` = :code";

        try {
            $conn = null;
            $conn = getDBConnection();

            $db = $conn->prepare($sql);
            $db->execute([':code' => $code]);

            $exist = $db && $db->rowCount() > 0 ? true : false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            return $exist;
        }
    }
//¿ ==================================== RESETS =========================================

    function resetAccountPassword($mail){
        $sql = "UPDATE users 
                SET resetPassCode = :resetCode, resetPassExpiry = :resetExpiry
                WHERE `mail` = :mail";

        $resetCode = hash('SHA256', rand());
        $resetExpiry = date("Y-m-d H:i:s");

        try {
            $conn = null;
            $conn = getDBConnection();

            $db = $conn->prepare($sql);
            $db->execute([
                ':resetCode'   => $resetCode,
                ':resetExpiry' => $resetExpiry,
                ':mail'        => $mail
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            return $resetCode;
        }
    }

    function checkReset($codigoReset, $mail){
        $exist = null;
        $sql = "SELECT * 
                FROM users 
                WHERE `mail` = :mail 
                AND resetPassCode = :resetCode";

        try {
            $conn = null;
            $conn = getDBconnection();

            $db = $conn->prepare($sql);
            $db->execute([
                ':mail'      => $mail,
                ':resetCode' => $codigoReset
            ]);

            $exist = $db && $db->rowCount() > 0 ? true : false;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            return $exist;
        }
    }

    function updatePassword($mail, $passHash){
        $sql = "UPDATE users 
                SET `passHash` = :passHash
                WHERE mail = :mail
                AND TIMEDIFF(NOW(), `resetPassExpiry`) <= '00:30:00'";

        $pass = password_hash($passHash,PASSWORD_DEFAULT);
        

        try {
            $conn = null;
            $conn = getDBconnection();

            $db = $conn->prepare($sql);
            $db->execute([
                ':mail'     => $mail,
                ':passHash' => $pass
            ]);

            return $db && $db->rowCount() > 0 ? true : false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }