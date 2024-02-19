<?php
    require "./lib/users.php";

    
    session_start();

    if(isset($_COOKIE['user'])){ //! Revisar que funciona y el usuario lo redirige al mainpage
        header("Location: ./php/home.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD']=='POST') {

        $userName = isset($_POST['user']) ? htmlspecialchars($_POST['user']) : null;
        $password = isset($_POST['pass']) ? htmlspecialchars($_POST['pass']) : null;

        if ($userName && $password) {
            if(validateUser($userName,$password)){

                $_SESSION['user'] = $userName;
                header("Location: ./php/home.php");
                exit();

            } else { $error="Usuario o contraseña incorrectos"; } 

        } else { $error="Por favor, introduce un usuario y contraseña"; }
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
        <form method="post">
            <h1>EduHacks</h1>    
            <label for="user">EMAIL</label>
            <input type="text" name="user" value="<?=isset($userName) ? $userName : '';?>" required>
            <label for="pass">CONTRASENYA</label>
            <input type="password" name="pass" required>
            <a href="./web/home.php">Don't have an account yet? Sign Up</a>
            <button class="button" type="submit"><span>Login</span></button>
            <?php if (isset($error)) {
                echo "<p style='color:red;'>" . $error . "</p>";
            }?>
        </form>
    </main>
</body>
</html>