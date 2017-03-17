<?php
session_start();  //strona rejestracji uzytkownika, dostepna bez zalogowania

if (isset($_SESSION['logged'])) {
    header("location: index.php");
    exit;
}

require_once "src/User.php";
require_once "src/Tweet.php";
require_once "src/connect.php";
require_once 'src/Comment.php';
require_once 'src/Message.php';

$randCaptcha = rand(1, 10); //generowanie linka do zabezp. captcha
$message = ""; //wiadomosc podawana przy zajetym adresie mailowym i bledach hasla

$conn = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && trim($_POST['username']) != '' 
            && isset($_POST['captcha']) && ($_POST['captcha'] >= 10) 
            && ($_POST['captcha'] <= 85) && is_numeric($_POST['captcha']) 
            && isset($_POST['useremail']) && trim($_POST['useremail']) != '' 
            && isset($_POST['userpassword1']) && trim($_POST['userpassword1']) != '' 
            && isset($_POST['userpassword2']) && trim($_POST['userpassword2']) != '') {
        if (trim($_POST['userpassword1']) == trim($_POST['userpassword2'])) {
            $userEmail = strtolower(trim($_POST['useremail']));
            $userEmail = $conn->real_escape_string($userEmail);
            $userPassword = trim($_POST['userpassword1']);
            $userName = trim($_POST['username']);

            $sql = "SELECT * FROM users WHERE user_email = '$userEmail'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $message = "Podany adres e-mail ma już dziuplę, wybierz inny";
            } else {
                $user = new User();
                $user->setEmail($userEmail);
                $user->setHashedPassword($userPassword);
                $user->setUsername($userName);
                $user->saveToDB($conn); 
                if ($user->saveToDB($conn) == true) {
                    $_SESSION['logged'] = $userName;
                    $_SESSION['user_email'] = $userEmail;
                    $_SESSION['user_id'] = $user->getId();
                    header("location: index.php");
                } else {
                    $message = "Błąd połączenia z bazą, spróbuj za kilka minut";
                }
            }
        } else {
            $message = "Hasła nie są identyczne, trzeba się zdecydować, którego używać";
        }
    } else {
        $message = "Wypełnij wszystkie pola prawidłowo, nie rób byle jakiej dziupli.";
    }
}

$conn->close();
$conn = null;
?>

<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>Dzięcioły - stwórz własną dziuplę w lesie </title>

        <meta name="description" content="Prawie jak Twitter" />
        <meta name="keywords" content="dzięcioły, twitter" />
        <meta name="author" content="ccwrc">

        <link rel="stylesheet" href="css/style.css" type="text/css" />

        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/app.js"></script>	
    </head>

    <body>
        <div class="container">

            <div class="logo" id="mainBackLogo">
                <img class="logoimage" id="logoimage" src="img/logo.jpg">    
            </div>


            <div class="content">

                <br /> <center>
                    <h4 class="warning"><?= $message ?></h4>
                </center>  

                <form method="POST" action="">
                    <label> Aby mieć dziuplę w lesie wypełnij wszystkie pola: <br/><br/>
                        <input type="text" name="username" placeholder="Podaj nazwę dzięcioła" size="50"
                               pattern=".{3,65}"   required title="Minimalna liczba znaków to 3, maksymalna 65"/>  <br/> 
                        <input type="email" name="useremail" placeholder="Tu wpisz e-mail" size="50"
                               pattern=".{5,250}"   required title="Minimalna liczba znaków to 5, maksymalna 250"/>  <br/>
                        <input type="password" name="userpassword1" placeholder="I ustal hasło" size="50"
                               pattern=".{3,65}"   required title="Minimalna liczba znaków to 3, maksymalna 65"/> <br/>
                        <input type="password" name="userpassword2" placeholder="Dla pewności wpisz hasło ponownie" size="50"
                               pattern=".{3,65}"   required title="Minimalna liczba znaków to 3, maksymalna 65"/> <br/><br/>
                        Potwierdź, że nie jesteś borsukiem i przepisz drugi i 3 znak: <br/>
                        <img src="img/<?= $randCaptcha ?>.png"/><br/>
                        <input type="text" name="captcha" placeholder=
                               "Tu wpisz drugi i 3 znak z powyższego obrazka" size="50"/><br/>
                        <input type="submit" value=" Kliknij tutaj żeby stworzyć własną dziuplę "/>
                    </label>    
                </form>

                <!-- 5x br do odsloniecia tresci (przyklejony dolny panel)-->
                <br/><br/><br/><br/><br/> 
            </div>

            <?php
            include 'src/bottom_menu_logoff.php';
            ?>   

        </div>
    </body>
</html>
