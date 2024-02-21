<?php

    require_once "../lib/users.php";

    session_start();

    if (!isset($_SESSION['user'])) {
        header("Location: ../index.php");
        exit();
    }

    $dataUser = $_SESSION['user'];
    updateTime($dataUser['username'])
?>
<!DOCTYPE html>
<html>
<head>
    <title>Benvingut a EduHacks</title>
</head>
<body>
    <h2>Benvingut, <?php echo $dataUser['userFirstName'] . " " . $dataUser['userLastName']; ?>!</h2>
    <p>Aquesta és la pàgina d'inici.</p>
    <a href="logout.php">Tanca sessió</a>
</body>
</html>
