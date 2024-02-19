<?php 

    require "../lib/users.php";

    session_start();

    if ($_SERVER['REQUEST_METHOD']=='POST') {
        
        $email      = isset($_POST['email'])             ? filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) : null;
        $name       = isset($_POST['username'])          ? htmlspecialchars($_POST['username']) : null;
        $firstName  = isset($_POST['firstName'])         ? htmlspecialchars($_POST['firstName']) : null;
        $lastName   = isset($_POST['lastName'])          ? htmlspecialchars($_POST['lastName']) : null;
        $pass       = isset($_POST['password'])          ? htmlspecialchars($_POST['password']) : null;
        $veriPass   = isset($_POST['confirmPassword'])   ? htmlspecialchars($_POST['confirmPassword']) : null;

        if ($email && $name && $pass && $veriPass) {
            if($pass===$veriPass) {
                registerUser($email, $name, $firstName, $lastName, $pass);
                header("Location: ../index.php");
                exit(0);
            } else { 
                $error = "La contraseña no coinciden"; 
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registre - EduHacks</title>
</head>
<body>
    <h2>Registre</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Nom d'usuari" required><br>
        <input type="email" name="email" placeholder="Correu electrònic" required><br>
        <input type="text" name="firstName" placeholder="Nom"><br>
        <input type="text" name="lastName" placeholder="Cognom"><br>
        <input type="password" name="password" placeholder="Contrasenya" required><br>
        <input type="password" name="confirmPassword" placeholder="Confirma la contrasenya" required><br>
        <input type="submit" value="Registra't">
    </form>
</body>
</html>
