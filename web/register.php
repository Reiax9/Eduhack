<?php 

    require "../lib/users.php";

    session_start();

    if ($_SERVER['REQUEST_METHOD']=='POST') {
        
        $email     = isset($_POST['email'])           ? filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) : null;
        $name      = isset($_POST['username'])        ? htmlspecialchars($_POST['username']) : null;
        $firstName = isset($_POST['firstName'])       ? htmlspecialchars($_POST['firstName']) : null;
        $lastName  = isset($_POST['lastName'])        ? htmlspecialchars($_POST['lastName']) : null;
        $pass      = isset($_POST['password'])        ? htmlspecialchars($_POST['password']) : null;
        $veriPass  = isset($_POST['confirmPassword']) ? htmlspecialchars($_POST['confirmPassword']) : null;

        if ($email && $name && $pass && $veriPass) {
            $error = "";
            $passwordMatch=$userMatch=$emailMatch=false;

            //! Si no existe, me da un false y permite crear el usuario
            checkUser($email) ? $error = "El correo {$email} ya esta en uso." : $emailMatch=true;
            checkUser($name)  ? $error = "El usuario {$name} ya esta en uso." : $userMatch=true;

            $pass===$veriPass ? $passwordMatch=true : $error = "La contraseña no coinciden.";

            if ($passwordMatch && $emailMatch && $userMatch) {
                registerUser($email, $name, $firstName, $lastName, $pass);
                $_SERVER['register']=true;
                header("Location: ../index.php");
                exit(0);
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registre - EduHacks</title>
</head>
<body>
    <h2>Registre</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Nom d'usuari" required><br>
        <input type="email" name="email" placeholder="Correu electrònic" required><br>
        <input type="text" name="firstName" placeholder="Nom"><br>
        <input type="text" name="lastName" placeholder="Cognom"><br>
        <input type="password" name="password" placeholder="Contrasenya" required><br>
        <input type="password" name="confirmPassword" placeholder="Confirma la contrasenya" required><br>
        <input type="submit" value="Registra't">
        <?= isset($error) ? "<p style='color:red;'>".$error."</p>": '';?>
    </form>
</body>
</html>
