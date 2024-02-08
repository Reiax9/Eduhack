<?php
    require "./DB/connect.php";
    require "./DB/users.php";

    
    session_start();

    if(isset($_COOKIE['user'])){ //! Revisar que funciona y el usuario lo redirige al mainpage
        header("Location: ./pagina/mainpage.php");
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
                // Rellena con tu código, esto si no se ha validado correctamente.
                $error="Usuario o contraseña incorrectos"; 
                exit();
            } 

        } else {
            // Rellena con tu código, esto si no se ha enviado ni el usuario ni la contraseña.
            $error="Por favor, introduce un usuario y contraseña";
            exit();
        }

    } else {
        echo "<p>Error: $error</p>";
        exit();
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
        //! Muestra los errores si no se ha enviado correctamente. Este lo haremos juntos
        //!
        //!          YOU CODE
        //!
        //! =============================================================================
        <form method="post">
            <label for="user">EMAIL</label>
            <input type="email" name="user" value=<?=$userName?> required>
            <label for="pass">CONTRASENYA</label>
            <input type="password" name="pass" required>
            <button class="button" type="submit"><span>Login</span></button>
        </form>
    </main>
</body>
</html>