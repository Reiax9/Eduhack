<?php

    require_once "../lib/users.php";
    require_once "../lib/ctf.php";

    session_start();

    if (!isset($_COOKIE['PHPSESSID'])) {
        header("Location: ./logout.php");
        exit(0);
    }
    
    
    $allDataUser=$_SESSION['user'];
    updateTime($allDataUser['username']);



    $html = '';
    $category = 'All';
    $chooseCTF = false;
    $idChallenge = 0;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['category'])) {

            setcookie('category', $_POST['category'], time() + 3600 * 24 * 7);
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
    }
    

    
    $challenges = getCTF();
    if (isset($challenges) and $chooseCTF === false) {

        foreach ($challenges as $challenge) {
            $html = showCTF($html, $challenge, $category);
        }

    }elseif (isset($challenges) and isset($idChallenge)) {

        foreach ($challenges as $challenge) {
            if ($challenge['idChallenge'] === $idChallenge) {
                $html = boxCTF($html, $challenge);
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
    <main>
        <div id="mainContain">
            <h2>Benvingut, <?php echo $allDataUser['username'] ; ?>!</h2>
            <p>Aquí tens els reptes per esbrinar i guanyar més punts que els altres!</p>
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
                <h3>Point</h3>
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
                    if (isset($answerUser)) {
                        if($answerUser === $challenges[$idChallenge]['flagValue']){ 
                            $html .= "<p>Correct!</p>";
                            $allScore = $allDataUser['userScore'] + $challenges[$idChallenge-1]['score'];
                            addScore($allDataUser['username'], $allScore);
                        } else {
                            $html .= "<p>Incorrect!</p>";
                        }
                    }
                    echo $html;
                ?>
    
            </div>
            <div id="botonUser">
                <a href="#"><i class="fa-solid fa-house"></i></a>
                <a href="./createctf.php"><i class="fa-solid fa-circle-plus"></i></a>
                <a href="logout.php"><i class="fa-solid fa-user"></i></i></a>
            </div>
        </div>
    </main>
    <footer></footer>
</body>
</html>