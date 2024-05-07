<?php

    require_once "connect.php";

    function createCTF($form){

        $currentDate = date("Y-m-y H:i:s");
        $sql = "INSERT INTO `challenge_CTF`(`title`, `description`, `score`, `flagValue`, `publicationDate`, `file`, `category`, `idUsers`)
                                    Values( :title, :descriptions, :score, :flagValue, :publicationDate, :files, :category, :idUsers)";
        
        try {
            $conn = null;
            $conn = getDBconnection();
            
            $db = $conn->prepare($sql);
            $db->execute([  
                ':title'            => $form['title'], 
                ':descriptions'     => $form['descripcion'],
                ':score'            => $form['score'],
                ':flagValue'        => $form['answer'],
                ':publicationDate'  => $currentDate,
                ':files'            => $form['file'],
                ':category'         => $form['category'],
                ':idUsers'          => $form['idUsers']
            ]);
        } catch (PDOStatement $e) {
            echo $e->getMessage();
        }
    }

    function showCTF(){
        $sql = "SELECT * FROM challenge_CTF";

        try {
            $conn = null;
            $conn = getDBConnection();

            $db = $conn->query($sql);
            return $db->fetchAll();

        } catch (PDOStatement $e) {
            echo $e->getMessage();
        }
    }


?>