<?php
    use PHPMailer\PHPMailer\PHPMailer;
    require 'vendor/autoload.php';

    function sendMail($userMail, $title ,$textBody){

        $mail = new PHPMailer();
        $mail->IsSMTP();

        //Configuració del servidor de Correu
        //Modificar a 0 per eliminar msg error

        $mail->SMTPDebug  = 2;                                    //Enable verbose debug output                               //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->CharSet    = 'UTF-8';
        $mail->SMTPAuth   = true;                                 //Enable SMTP authentication
        $mail->Username   = 'xavier.garciam@educem.net';          //SMTP username
        $mail->Password   = 'fxks nwhc eswz vwoq';                //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          //Enable implicit TLS encryption
        $mail->Port       = 465;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Dades del correu electrònic
        $mail->SetFrom('xavier.garciam@educem.net','Xavier García');
        $mail->addCC($userMail);
        $mail->Subject = $title;
        $mail->MsgHTML($textBody);
        $mail->Body    = '';

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