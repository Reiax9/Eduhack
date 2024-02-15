<?php
    
    require "config.php";

    function getDBconnection($cadena_connexio=DB_CONN, $usuari=DB_USER, $passwd=DB_PASS){
        $conn = null;

        try {
            $conn = new PDO($cadena_connexio, $usuari, $passwd, 
                            array(PDO::ATTR_PERSISTENT => true));
            
        } catch (PDOException $e) {
            echo 'Error amb la BDs: ' . $e->getMessage();
        } finally {
            return $conn;
        }
    }
