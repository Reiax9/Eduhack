<?php
// Dades de connexió a la base de dades
$servername = "localhost";  // Nom de l'amfitrió
$username = "usuari";       // Nom d'usuari
$password = "contrasenya";  // Contrasenya
$dbname = "eduhacks";       // Nom de la base de dades

try {
    // Establir connexió amb PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Establir el mode d'error a excepcions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mostrar missatge d'èxit
    echo "Connexió amb èxit";
} catch(PDOException $e) {
    // Capturar errors de connexió
    echo "Error de connexió: " . $e->getMessage();
}

// Tanca la connexió
$conn = null;
?>
