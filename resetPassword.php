<?php
    
    require "./lib/users.php";

    $codigoReset = isset($_GET['code']) ? htmlspecialchars($_GET['code']) : null;
    $mail        = isset($_GET['mail']) ? htmlspecialchars($_GET['mail']) : null;
    $error       = '';

    if (!checkReset($codigoReset, $mail)) { 
        header("Location: ./index.php");
        exit(0);
    }

    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $password           = isset($_POST['password'])         ? htmlspecialchars($_POST['password'])         : null;
        $passwordVerificar  = isset($_POST['verificaPassword']) ? htmlspecialchars($_POST['verificaPassword']) : null;

        if($password === $passwordVerificar){
            $success = updatePassword($mail, $password);
            if($success){
                header("Location: ./index.php");
                exit(0);
            } else {    
                $error = "No s'ha pogut resetejar la contrasenya";
            }
        } else { 
            $error = "Les contrasenyes no coincideixen";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div id="mainContent">
        <div id="panelReset">
            <form method="post">
                <h2>Reset Password</h2>
                <p>Introdueix la contrasenya</p>
                <span>Contrasenya: </span>
                <input type="password" name="password">
                <span>Verifica contrasenya: </span>
                <input type="password" name="verificaPassword">
                <button class="button" type="submit"><span>Send Reset Password Email</span></button>
            </form>
            <?= is_null($error) ? "<p style='color: red;'>. $error .</p>" : ''; ?>
        </div>
    </div>
</body>
</html>