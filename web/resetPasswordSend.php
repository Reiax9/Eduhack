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
    <title>Eduhacks</title>
    <link rel="stylesheet" href="../css/resetPasswordSend.css">
</head>
<body>
    <canvas id="cnv"></canvas>
    <div id="mainContent">
        <div id="panelReset">
            <form method="post">
                <h2>Reset Password</h2>
                <p>Introduce el Correo para resetear la contraseña</p>
                <div class="fixInput">
                    <span>Correo:</span>
                    <input type="text" name="mail">
                </div>
                <button class="button" type="submit"><span>Enviar</span></button>
            </form>
        </div>
    </div>
    <script src="../index.js"></script>
</body>
</html>