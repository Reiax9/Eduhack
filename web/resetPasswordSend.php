<?php
    require_once "../lib/users.php";
    require_once "../lib/mail.php";

    if ($_SERVER['REQUEST_METHOD']=='POST') {
        
        $mail = isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : null;

        if (checkUser($mail)) {
            $codePassword = resetAccountPassword($mail);
            $html = resetPassword($codePassword, $mail);
            sendMail($mail, "Eduhacks Reset Password" ,$html);
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
                <p>Introduce el Correo para resetear la contraseña</p>
                <span>Correo: </span>
                <input type="text" name="mail">
                <button class="button" type="submit"><span>Send Reset Password Email</span></button>
            </form>
        </div>
    </div>
</body>
</html>