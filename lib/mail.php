<?php

    use PHPMailer\PHPMailer\PHPMailer;
    require 'vendor/autoload.php';

    function sendMail($userMail, $title ,$textBody){

        $mail = new PHPMailer();
        $mail->IsSMTP();

        $mail->SMTPDebug  = 0;                                    
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->CharSet    = 'UTF-8';
        $mail->SMTPAuth   = true;                                 
        $mail->Username   = 'xavier.garciam@educem.net';          
        $mail->Password   = 'jmor jytv iozw icpf';                
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          
        $mail->Port       = 465;                                  

        //Dades del correu electrònic
        $mail->SetFrom('xavier.garciam@educem.net','Xavier García');
        $mail->AddEmbeddedImage("../img/banner.jpg", "my-attach", "../img/banner.jpg");
        $mail->addCC($userMail);
        $mail->Subject = $title;
        $mail->MsgHTML($textBody);
        $mail->Body    = $textBody;

        //Destinatari
        $address = $userMail;
        $mail->AddAddress($address, 'Xavier García');

        //Enviament
        $result = $mail->Send();
        if(!$result){
            echo 'Error: ' . $mail->ErrorInfo;
        }else{
            echo "Correu enviat";
        }
    }

    function mailActivate($codeUser, $mailUser){
        $html = '';
        
        $html .= "<img src='cid:my-attach' style='width:100%;'>";
        $html .= "<h1>Benvolguts a Eduhacks</h1>";
        $html .= "<p>Per poder iniciar sessió, has de verificar amb el següent enllaç</p>";
        $html .= "<a href='http://localhost/Eduhack/lib/mailCheckAccount.php?code=$codeUser&mail=$mailUser'>Active your account Now!</a>";

        return $html;
    }

    function resetPassword($codeUser, $mailUser){
        $html = '';

        $html .= "<img src='cid:my-attach' style='width:100%;'>";
        $html .= "<h2>Reset Password</h2>";
        $html .= "<p>Per poder resetejar la contrasenya, has de verificar amb el següent enllaç</p>";
        $html .= "<a href='http://localhost/proyecto/Eduhack/resetPassword.php?code=$codeUser&mail=$mailUser'>Reset Password</a>";

        return $html;
    }