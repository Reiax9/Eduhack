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
    <script src="https://kit.fontawesome.com/c7573246bc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/home.css">
</head>
<body>
    <div id="mainContain">
        <h2>Benvingut, <?php echo $dataUser['username'] ; ?>!</h2>
        <p>Aquesta és la pàgina d'inici.</p>
        <div id="retosctf">
            <div class="cajactf">
                <?php
                    $challenges = showCTF();
                    if (isset($challenges)) {
                        foreach ($challenges as $challenge) {
                            echo "----------------";
                            echo $challenge;
                            echo "----------------";
                        }
                    }

                ?>
            </div>
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