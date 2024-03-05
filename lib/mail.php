<?php

    use PHPMailer\PHPMailer\PHPMailer;
    require 'vendor/autoload.php';

    function sendMail($userMail, $title ,$textBody){

        $mail = new PHPMailer();
        $mail->IsSMTP();

        $mail->SMTPDebug  = 2;                                    
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->CharSet    = 'UTF-8';
        $mail->SMTPAuth   = true;                                 
        $mail->Username   = 'xavier.garciam@educem.net';          
        $mail->Password   = 'fxks nwhc eswz vwoq';                
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          
        $mail->Port       = 465;                                  

        //Dades del correu electrònic
        $mail->SetFrom('xavier.garciam@educem.net','Xavier García');
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
        
        $html .= "<img style='display:block;margin-left: auto; margin-right: auto;' src='http://localhost/proyecto/Eduhack/img/logo.jpg' alt='Logo Eduhacks'>";
        $html .= "<h2>Benvolguts a Eduhacks</h2>";
        $html .= "<p>Per poder iniciar sessió, has de verificar amb el següent</p>";
        $html .= "<a href='http://10.0.6.130/proyecto/Eduhack/lib/mailCheckAccount.php?code=$codeUser&mail=$mailUser'>Active your account Now!</a>"; // Si no funciona, concatena

        return $html;
    }