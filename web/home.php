<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Benvingut a EduHacks</title>
</head>
<body>
    <h2>Benvingut, <?php echo $_SESSION['user']; ?>!</h2>
    <p>Aquesta és la pàgina d'inici.</p>
    <a href="logout.php">Tanca sessió</a>
</body>
</html>
