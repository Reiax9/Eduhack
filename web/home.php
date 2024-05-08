<?php

    require_once "../lib/users.php";
    require_once "../lib/ctf.php";

    session_start();

    if (!isset($_SESSION['user'])) {
        header("Location: ../index.php");
        exit(0);
    }

    $dataUser = $_SESSION['user'];
    updateTime($dataUser['username']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Benvingut a EduHacks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/c7573246bc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/home.css">
</head>
<body>
    <div id="mainContain">
        <h2>Benvingut, <?php echo $dataUser['username'] ; ?>!</h2>
        <p>Aquesta és la pàgina d'inici.</p>
        <div id="retosctf">
            <?php
                $html = '';
                $challenges = showCTF();
                if (isset($challenges)) {
                    foreach ($challenges as $challenge) {
                        $html .= "<div class='boxCTF'>";
                        $html .=    "<div class='bannerCTF'>";
                        $html .=        "<h2>".$challenge['title']."</h2>";
                        $html .=        "<p class='puntuacion'>+".$challenge['score']." pts</p>";
                        $html .=    "</div>";
                        $html .=    "<p>#".$challenge['category']."</p>";
                        $html .=    "<p>Descripcion</p>";
                        $html .=    "<p>".$challenge['description']."</p>";
                        $html .=    "<p>".$challenge['publicationDate']."</p>";
                        $html .= '<a href="../files/' . $challenge['file'] . '" download="' . $challenge['file'] . '">algo</a>';
                        $html .=    "<div class='buttonFlag'>";
                        $html .=        "<button class='btn btn-primary'>Check Flag!</button>";
                        $html .=    "</div>";
                        $html .= "</div>";
                    }
                    echo $html;
                }
            ?>
        </div>
        <div id="botonUser">
            <a href="#"><i class="fa-solid fa-house"></i></a>
            <a href="./createctf.php"><i class="fa-solid fa-circle-plus"></i></a>
            <a href="#"><i class="fa-solid fa-user"></i></i></a>
        </div>
        <a href="logout.php">Tanca sessió</a>
    </div>
</body>
</html>