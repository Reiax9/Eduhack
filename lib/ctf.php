<?php

    require_once "connect.php";

    function createCTF($form){

        $currentDate = date("Y-m-d H:i:s");
        $sql = "INSERT INTO `challenge_CTF`(`title`, `description`, `score`, `flagValue`, `publicationDate`, `file`, `category`, `idUsers`)
                                    Values( :title, :descriptions, :score, :flagValue, :publicationDate, :files, :category, :idUsers)";

        $validateCTF = "INSERT INTO `user_challenge_status`(`idUsers`,`idChallenge`,`solved`) VALUE(:idUser, :idChallenge, 1)";
        
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

            //? Obtener la última ID recién creada
            $lastId = $conn->lastInsertId();

            //! Impido que el usuario pueda responder su propio CTF
            $db2 = $conn->prepare($validateCTF);
            $db2->execute([ ':idUser' => $form['idUsers'], ':idChallenge' => $lastId ]);

        } catch (PDOStatement $e) {
            echo $e->getMessage();
        }
    }

    function getCTF(){
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

    function successCTF($idUser, $idChallenge) {
        $sql = "INSERT INTO `user_challenge_status`(`idUsers`,`idChallenge`,`solved`) VALUE(:idUser, :idChallenge, 1)";
        
        try {
            $conn = null;
            $conn = getDBConnection();

            $db = $conn->prepare($sql);
            $db->execute([':idUser' => $idUser, ':idChallenge' => $idChallenge]);

        } catch (PDOStatement $e) {
            echo $e->getMessage();
        }
    }

    function resultCTF($idUser, $idChallenge) {
        $sql = "SELECT solved FROM `user_challenge_status` 
                WHERE `idUsers` = :idUser AND `idChallenge` = :idChallenge";
        
        try {
            $conn = null;
            $conn = getDBConnection();

            $db = $conn->prepare($sql);
            $db->execute([':idUser' => $idUser, ':idChallenge' => $idChallenge]);

            return $db->fetchColumn();

        } catch (PDOStatement $e) {
            echo $e->getMessage();
        }
    }

    function addScore($username, $scoreCTF) {
        $sql = "UPDATE users SET userScore = :scoreCTF WHERE username = :username";

        try {
            $conn = null;
            $conn = getDBconnection();
            
            $db = $conn->prepare($sql);
            $db->execute([ ':scoreCTF' => $scoreCTF, ':username' => $username ]);
        } catch (PDOStatement $e) {
            echo $e->getMessage();
        }
    }

    function getScore() {
        $sql = "SELECT username, userScore 
                FROM users
                ORDER BY userScore DESC
                LIMIT 5";

        try {
            $conn = null;
            $conn = getDBConnection();

            $db = $conn->query($sql);
            return $db->fetchAll();

        } catch (PDOStatement $e) {
            echo $e->getMessage();
        }
    }

    function boxScore($i, $userName, $score, $html){
        $html .= "<div class='rowScore'>";
        if ($i===1) {
            $html .= "<p><i class='fa-solid fa-crown' id='goldCrown'></i>  ".$userName."</p>";
        }elseif ($i===2) {
            $html .= "<p><i class='fa-solid fa-crown' id='silverCrown'></i>  ".$userName."</p>";
        }elseif ($i===3) {
            $html .= "<p><i class='fa-solid fa-crown' id='copperCrown'></i>  ".$userName."</p>";
        }else {
            $html .= "<p>$i".". ".$userName."</p>";
        }
        $html .= "<p class='numberScore'>".$score."</p>";
        $html .= "</div>";
        return $html;
    }


    function showCTF($html, $challenge, $category, $success){
        if (($category === $challenge['category']) or ($category === "All")) {
            $html .=    "<div class='buttonFlag'>";
            $html .=    "<form action='../web/home.php' method='post'>";
            $html .=    "<input type='hidden' name='idChallenge' value='".$challenge['idChallenge']."'>";;
            $html .=        "<button class='btn'>";
            $html .=            "<div class='bannerCTF'>";
            $html .=                "<h2>".$challenge['title']."</h2>";
            $html .=                "<p class='puntuacion'>+".$challenge['score']." pts</p>";
            $html .=            "</div>";
            $html .=            "<p>#".$challenge['category']."</p>";
            $html .=            "<p>Author: ".getUsername($challenge['idUsers'])."</p>";
            $html .=            "<p class='descripcionBoton'>Descripcion: ".$challenge['description']."</p>";
            if ($success) { 
                //! Revisar por si solo lo puede hacer una vez
                $html .=            "<i class='fa-solid fa-circle-check fa-2xl' style='color: #63E6BE;'></i>";
            }
            $html .=        "</button>";
            $html .=    "</form>";
            $html .=    "</div>";
        }
        return $html;
    }

    function boxCTF($html, $challenge, $success){
        $html .= "<div class='boxCTF'>";
        $html .=    "<form action='../web/home.php' method='post'>";
        $html .=    "<div class='bannerCTF'>";
        $html .=        "<h2>".$challenge['title']."</h2>";
        $html .=        "<p class='puntuacion'>+".$challenge['score']." pts</p>";
        $html .=    "</div>";
        $html .=    "<p>#".$challenge['category']."</p>";
        $html .=    "<p>".getUsername($challenge['idUsers'])."</p>";
        $html .=    "<p>Descripcion</p>";
        $html .=    "<p>".$challenge['description']."</p>";
        if ($challenge['file'] !== "") {
            $html .=    "<p>Additional Resource</p>";
            $html .=    '<a href="../files/' . $challenge['file'] . '" download="' . $challenge['file'] . '">'.$challenge['file'].'  <i class="fa-solid fa-download"></i></a>';
        }
        $html .=    "<p class='fechBox'>".$challenge['publicationDate']."</p>";

        if ($success) { 
            $html .=            "<i class='fa-solid fa-circle-check fa-2xl' style='color: #63E6BE;'></i>";
        }else{
            $html .=    "<input class='answerUser' type='text' name='answerUser'>";
            $html .=    "<div class='buttonCTF'>";
            $html .=        "<button class='btn btn-primary'>Check Flag!</button>";
            $html .=    "</div>";
        }
        $html .= "</div>";
        return $html;
    }
?>

