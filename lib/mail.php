<?php

function mailActivate($codeUser, $mailUser){
    $html = '';
    
    $html .= "<img src='../img/logo.jpg' alt='Logo Eduhacks'>";
    $html .= "<h2>Benvolguts a Eduhacks</h2>";
    $html .= "<p>Per poder iniciar sessió, has de verificar amb el següent</p>";
    $html .= "<a href='https://eduhacks/lib/mailCheckAccount.php?code=$codeUser&mail=$mailUser'>Clicar enlace para activar tu cuenta.</a>"; // Si no funciona, concatena

    return $html;
}
