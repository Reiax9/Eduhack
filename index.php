<?php
    require "./DB/connect.php";
    require "./DB/users.php";

    if(isset($_COOKIE['PHPSESSID'])){
        session_start();

        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $userName = isset($_POST['user']) ? filter_input(INPUT_POST,'user',FILTER_SANITIZE_EMAIL)  : null;
            $password = isset($_POST['pass']) ? htmlspecialchars($_POST['pass'])                       : null;
            
            if(validateUser($userName, $password)){
                $_SESSION['user'] = $userName;
                header("Location: ./pagina/mainpage.php");
                exit();
            } 

            $error = "No se ha introducido el usuario o contraseña erroneamente.";
            

        } else {
            $error = "No se ha enviado por el metodo post";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <main>
        <h1>EduHacks</h1>
        <form method="post">
            <label for="user">EMAIL</label>
            <input type="email" name="user" required>
            <label for="pass">CONTRASENYA</label>
            <input type="password" name="pass" required>
            <button class="button" type="submit"><span>Login</span></button>
        </form>
    </main>
</body>
</html>