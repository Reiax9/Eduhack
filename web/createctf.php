<?php


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/createctf.css">
    <title>Eduhacks</title>
</head>
<body>
    <main>
        <div id="mainContain">
            <div id="contain">
                <h1>Crear tu CTF</h1>
                <p>Crea tu siguiente ctf para que sea un Poner las categorias que tengamos</p>
                <form action="./home.php" method="post">
                    <label class="inputForm" for="titulo">Titulo<input type="text"></label>
                    <label class="inputForm" for="respuest">Respuesta
                        <input type="text">
                    </label>
                    <label class="inputForm" for="descripcion">Descripcion</label>
                    <textarea name="descripcion" id="descripcion" cols="30" rows="5" placeholder="Introduce el enunciado..."></textarea>
                    <div class="form-floating">
                        <select class="form-select" name="categoria" id="categoria">
                            <option selected>Open this select menu</option>
                            <option value="Steganography">Steganography</option>
                            <option value="Cryptography">Cryptography</option>
                            <option value="Web Security">Web Security</option>
                        </select>
                        <label for="floatingSelect">Escoge categoria</label>
                    </div>
                    <label class="inputForm" for="fichero">Fichero
                        <input class="form-control form-control-sm" id="formFileLg" type="file">
                    </label>
                    <button class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>