<?php

    require_once "../lib/ctf.php";
    
    // if (!isset($_SESSION['user'])) {
    //     header("Location: ../index.php");
    //     exit(0);
    // }
    session_start();

    $error = '';
    
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $form = array();
        $form['title']        = isset($_POST['title'])           ? htmlspecialchars($_POST['title']) : null;
        $form['descripcion']  = isset($_POST['descripcion'])     ? htmlspecialchars($_POST['descripcion']) : null;
        $form['answer']       = isset($_POST['answer'])          ? htmlspecialchars($_POST['answer']) : null;
        $form['category']     = isset($_POST['category'])        ? htmlspecialchars($_POST['category']) : null;
        $form['score']        = isset($_POST['score'])           ? htmlspecialchars($_POST['score']) : null;
        
        if (($form['title'] !== "") and ($form['descripcion'] !== "") and ($form['answer'] !== "") and ($form['category'] !== "Selecciona una categoria*") and ($form['score'] !== "")) {
            //! Obtencion de los datos de la imagen
            if (isset($_FILES['file'])) {
                $rutaDestino  = "../files/";
                $nameImg      = $_FILES['file']['name'];
                $tempImg      = $_FILES['file']['tmp_name'];
                $form['file'] = $nameImg;
                move_uploaded_file($tempImg, $rutaDestino.$nameImg);
            }

            //? Tratamiento de la información del usuario
            $dataUser=$_SESSION['user'];
            $form['score'] = (int)$form['score'];
            $form['idUsers'] = $dataUser['idUsers'];

            createCTF($form);
            header("Location: ./home.php");
            exit(0);
        } else {
            $error="<p class='error'>No has introducido todos los campos obligatorios</p>";
        }
    }
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
    <nav id="navBar">
        <ul>
            <li><a href="./home.php?ctf=people">Home</a></li>
            <li><a href="./home.php?ctf=own">Your CTFs</a></li>
            <li><a href="./createctf.php">Add CTF</a></li>
            <li><a href="./logout.php">Logout</a></li>
        </ul>
    </nav>
    <main>
        <canvas id="cnv"></canvas>
        <div id="mainContain">
            <div id="contain">
                <h1>Crear tu CTF</h1>
                <p>Crea tu siguiente ctf para que sea un Steganography, Cryptography o Web Security.</p>
                <form method="post" enctype="multipart/form-data">
                    <label class="inputForm" for="title">Titulo*
                        <input type="text" name="title">
                    </label>
                    <label class="inputForm" for="descripcion">Descripcion*</label>
                    <textarea name="descripcion" id="descripcion" cols="30" rows="5" placeholder="Introduce el enunciado..."></textarea>
                    <label class="inputForm" for="answer">Respuesta*
                        <input type="text" name="answer">
                    </label>
                    <div class="form-floating">
                        <select class="form-select" name="category" id="categoria">
                            <option selected>Selecciona una categoria*</option>
                            <option value="Steganography">Steganography</option>
                            <option value="Cryptography">Cryptography</option>
                            <option value="Web Security">Web Security</option>
                        </select>
                        <label for="floatingSelect">Escoge categoria</label>
                    </div>
                    <label class="inputForm" for="file">Fichero
                        <input class="form-control form-control-sm" name="file" id="formFileLg" type="file">
                    </label>
                    <label for="score" class="inputForm">Puntuación*
                        <input type="number" id="score" name="score" min="1" max="10">
                    </label>
                    <button class="btn btn-primary">Enviar</button>
                    <?=isset($error) ? $error : '';?>
                </form>
            </div>
        </div>
    </main>
    <script src="../index.js"></script>
</body>
</html>