<?php

    require_once "../lib/users.php";

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
        <div id="botonUser">
            <a href="#"><i class="fa-solid fa-house"></i></a>
            <a href="#"><i class="fa-solid fa-play"></i></a>
            <a href="#"><i class="fa-solid fa-user"></i></i></a>
        </div>
    </div>
    <div id="retosctf">
        <div class="cajactf">
            
        </div>
    </div>
    <a href="logout.php">Tanca sessió</a>
</body>
</html>
