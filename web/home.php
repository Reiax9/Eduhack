<?php

    require_once "../lib/users.php";

    session_start();

    if (!isset($_SESSION['user'])) {
        header("Location: ../index.php");
        exit(0);
    }

    $dataUser = $_SESSION['user'];
    updateTime($dataUser['username']);

    echo $_COOKIE[$dataUser['username']];

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
