<?php

    require_once "connect.php";

    function createCTF($form){

        $currentDate = date("Y-m-d H:i:s");
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

    function showCTF($html, $challenge, $category){
        if (($category === $challenge['category']) or ($category === "All")) {
            $html .=    "<div class='buttonFlag'>";
            $html .=    "<form action='../web/home.php' method='post'>";
            $html .=    "<input type='hidden' name='idChallenge' value='".$challenge['idChallenge']."'>";;
            $html .=        "<button>";
            $html .=            "<div class='bannerCTF'>";
            $html .=                "<h2>".$challenge['title']."</h2>";
            $html .=                "<p class='puntuacion'>+".$challenge['score']." pts</p>";
            $html .=            "</div>";
            $html .=            "<p>#".$challenge['category']."</p>";
            $html .=            "<p>Descripcion</p>";
            $html .=            "<p>".$challenge['description']."</p>";
            $html .=        "</button>";
            $html .=    "</form>";
            $html .=    "</div>";
        }
        return $html;
    }

    function boxCTF($html, $challenge){
        $html .= "<div class='boxCTF'>";
        $html .=    "<form action='../web/home.php' method='post'>";
        $html .=    "<div class='bannerCTF'>";
        $html .=        "<h2>".$challenge['title']."</h2>";
        $html .=        "<p class='puntuacion'>+".$challenge['score']." pts</p>";
        $html .=    "</div>";
        $html .=    "<p>#".$challenge['category']."</p>";
        $html .=    "<p>Descripcion</p>";
        $html .=    "<p>".$challenge['description']."</p>";
        $html .=    "<p>".$challenge['publicationDate']."</p>";
        if ($challenge['file'] !== "") {
            $html .=    "<p>Additional Resource</p>";
            $html .=    '<a href="../files/' . $challenge['file'] . '" download="' . $challenge['file'] . '">'.$challenge['file'].'  <i class="fa-solid fa-download"></i></a>';
        }
        $html .=    "<input class='answerUser' type='text' name='answerUser'>";
        $html .=    "<div class='buttonFlag'>";
        $html .=        "<button class='btn btn-primary'>Check Flag!</button>";
        $html .=    "</div>";
        $html .= "</div>"; 
        return $html;
    }
?>

