<?php

    require_once "../lib/users.php";
    require_once "../lib/ctf.php";

    session_start();

    if (!isset($_COOKIE['PHPSESSID'])) {
        header("Location: ./logout.php");
        exit(0);
    }elseif (isset($_SESSION['user'])) {
        $allDataUser=getAllDataUsers($_SESSION['user']['username']);
    }else {
        $allDataUser=getAllDataUsers($_COOKIE['loginSuccess']);
    }
    updateTime($allDataUser['username']);


    $html        = '';
    $answerUser  = '';
    $category    = 'All';
    $idChallenge = 1;
    $chooseCTF   = false;
    $successCTF  = false;
    $showOwnCTF  = false;

    if (isset($_GET['ctf'])) {
        if ($_GET['ctf']==='own') {
            $showOwnCTF = true;
            $successCTF = true;
        }elseif ($_GET['ctf']==='people') {
            $showOwnCTF=false;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['category'])) {
            
            $category = $_POST['category'];

        }elseif (isset($_POST['answerUser'])) {

            if ($_POST['answerUser'] !== "") { 
                $answerUser  = htmlspecialchars($_POST['answerUser']); 
                $chooseCTF   = true;
                $idChallenge = intval($_COOKIE['idChallenge']); 
            }
            $category = $_COOKIE['category'];

        }elseif (isset($_POST['idChallenge'])) {

            if ($_POST['idChallenge'] !== "") { 
                setcookie('idChallenge', $_POST['idChallenge'], time() + 3600 * 24 * 7);
                $idChallenge  = intval(htmlspecialchars($_POST['idChallenge'])); 
                $chooseCTF    = true;
            }
            $category = $_COOKIE['category'];
        } 
    }elseif (!isset($_COOKIE['category'])) {
        $category = 'All';
        setcookie('category', $category, time() + 3600 * 24 * 7);
    }
    

    
    $challenges = getCTF();
    if (isset($challenges) and $chooseCTF === false) {

        foreach ($challenges as $challenge) {
            $isMyChallenge = $allDataUser['idUsers'] === $challenge['idUsers'];

            if  (($showOwnCTF && $isMyChallenge) || (!$showOwnCTF && !$isMyChallenge))  {
                $checkResultCTF = resultCTF($allDataUser['idUsers'],$challenge['idChallenge']);
                $successCTF = $checkResultCTF === 1 ? true : false;
                $html = showCTF($html, $challenge, $category, $successCTF);
            }
        }

    }elseif (isset($challenges) and isset($idChallenge)) {

        foreach ($challenges as $challenge) {
            if ($challenge['idChallenge'] === $idChallenge) {
                //! Comprobar si el usuario completo el reto
                $checkResultCTF = resultCTF($allDataUser['idUsers'],$challenges[$idChallenge-1]['idChallenge']);
                $successCTF = $checkResultCTF === 1 ? true : false;
                //? Mostrar panel para responder
                $html = boxCTF($html, $challenge, $successCTF);
            }
        }
        
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/c7573246bc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/home.css">
    <title>Benvingut a EduHacks</title>
</head>
<body>
    <header></header>
    <nav id="navBar">
        <ul>
            <li><a href="./home.php?ctf=people">Home</a></li>
            <li><a href="./home.php?ctf=own">Your CTFs</a></li>
            <li><a href="./createctf.php">Add CTF</a></li>
            <li><a href="./logout.php">Logout</a></li>
            <div id="showUser">
                <p><?=$allDataUser['username']?></p>
                <i class="fa-solid fa-user"></i>
            </div>
        </ul>
    </nav>
    <main>
        <canvas id="cnv"></canvas>
        <div id="mainContain">
            <h1><img class="logo" src="../img/logo.jpg" alt="Logo eduhacks">EDUHACKS</h1>
            <form method="post">
                <div class="form-floating">
                    <select class="form-select" name="category" id="categoria">
                    <option value="All" <?php echo ($category==='All') ? "selected" : ""; ?>>All</option>
                    <option value="Steganography" <?php echo ($category==='Steganography') ? "selected" : ""; ?>>Steganography</option>
                    <option value="Cryptography" <?php echo ($category==='Cryptography') ? "selected" : ""; ?>>Cryptography</option>
                    <option value="Web Security" <?php echo ($category==='Web Security') ? "selected" : ""; ?>>Web Security</option>
                    </select>
                    <label for="floatingSelect">Escoge categoria</label>
                </div>
                <button class="btn btn-primary btn-category">Change category</button>
            </form>
            <div id="panelScore">
                <h3>Ranked</h3>
                <?php
                    $panelScore = '';
                    $score = getScore();
                    for ($i=0; $i <= 5; $i++) { 
                        if (isset($score[$i])) {
                            $panelScore=boxScore($i+1, $score[$i]['username'], $score[$i]['userScore'], $panelScore);
                        }
                    }
                    echo $panelScore;
                ?>
            </div>
            <div id="retosctf">
                <?php 

                    if($answerUser === $challenges[$idChallenge-1]['flagValue'] and isset($answerUser)){ 
                        //! Añado que el usuario ha completado correctamente la base de datos
                        successCTF($allDataUser['idUsers'],$idChallenge);

                        //? Obtengo la puntuación del usuario
                        $allScore = $allDataUser['userScore'] + $challenges[$idChallenge-1]['score'];
                        addScore($allDataUser['username'], $allScore);
                    } 
                    
                    echo $html;
                ?>
    
            </div>
            <div id="botonUser">
                <a href="./home.php?ctf=people"><i class="fa-solid fa-house"></i></a>
                <a href="./home.php?ctf=own"><i class="fa-solid fa-book"></i></a>
                <a href="./createctf.php"><i class="fa-solid fa-circle-plus"></i></a>
                <a href="logout.php"><i class="fa-solid fa-user"></i></i></a>
            </div>
        </div>
    </main>
    <footer></footer>
    <script src="../index.js"></script>
</body>
</html>