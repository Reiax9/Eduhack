<?php
    require "./DB/connect.php";
    require "./DB/users.php";

    
    session_start();

    if(isset($_COOKIE['user'])){ //! Revisar que funciona y el usuario lo redirige al mainpage
        header("Location: ./web/mainPage.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $userName = isset($_POST['user']) ? filter_input(INPUT_POST,'user',FILTER_SANITIZE_EMAIL)  : null;
        $password = isset($_POST['pass']) ? htmlspecialchars($_POST['pass'])                       : null;
        
        if ($userName && $password) { /* Introduce una condicion donde compruebe si se ha introducido usuario y contraseña */
            if(validateUser($userName, $password)){
                $_SESSION['user'] = $userName;
                header("Location: ./pagina/mainpage.php");
                exit();
            } else {
                $error="Usuario o contraseña incorrectos"; 
            } 

        } else {
            $error="Por favor, introduce un usuario y contraseña";
        }

    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
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
            <?php if (isset($error)) {
                echo "<p style='color:red;'>" . $error . "</p>";
            }?>
        </form>
    </main>
</body>
</html>