<!DOCTYPE html>
<html>
<head>
    <title>Registre - EduHacks</title>
</head>
<body>
    <h2>Registre</h2>
    <form action="register_process.php" method="post">
        <input type="text" name="username" placeholder="Nom d'usuari" required><br>
        <input type="email" name="email" placeholder="Correu electrònic" required><br>
        <input type="text" name="firstName" placeholder="Nom"><br>
        <input type="text" name="lastName" placeholder="Cognom"><br>
        <input type="password" name="password" placeholder="Contrasenya" required><br>
        <input type="password" name="confirmPassword" placeholder="Confirma la contrasenya" required><br>
        <input type="submit" value="Registra't">
    </form>
</body>
</html>
