<?php

    require "./lib/users.php";

    session_start();

    if ($_SERVER['REQUEST_METHOD']=='POST') {
        
        $userName = isset($_POST['user']) ? htmlspecialchars($_POST['user']) : null;
        $password = isset($_POST['pass']) ? htmlspecialchars($_POST['pass']) : null;
        
        if ($userName && $password) {
            if(validateUser($userName,$password)){
                session_start();
                $_SESSION['user'] = getAllDataUsers($userName);
                setcookie("loginSuccess","Cookie de usuario " . $_SESSION['user']['username'],time() + 3600*24);
                header("Location: ./web/home.php");
                exit(0);
            } 
        }
        // Si falla al logear, no indicar mucha información
        $error="Por favor, introduce un usuario y contraseña correctamente"; 

    } else if (isset($_SESSION['register_success']) && $_SESSION['register_success'] === true) {
        $successRegister = "Register successful";
        unset($_SESSION['register_success']);
    } else if(isset($_COOKIE['loginSuccess'])){
        header("Location: ./web/home.php");
        exit(0);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index.css">
    <title>Login</title>
</head>
<body>
    <main>
        <form method="post">
            <div id="logo">
                <img  src="../Eduhack/img/logo.jpg" alt="logo">
            </div>
            <label for="user">EMAIL</label>
            <input type="text" name="user" value="<?=isset($userName) ? $userName : '';?>" required>
            <label for="pass">CONTRASENYA</label>
            <input type="password" name="pass" required>
            <a href="./web/register.php">Don't have an account yet? Sign Up</a>
            <button class="button" type="submit"><span>Login</span></button>
            <?php if (isset($error)) { echo "<p style='color:red;'>" . $error . "</p>"; }?>
            <!-- Comprobar que funcione -->
            <?php if (isset($successRegister)) { echo "<p id='registerSuccess'>" . $successRegister . "</p>"; }?> 
        </form>
    </main>
</body>
</html>