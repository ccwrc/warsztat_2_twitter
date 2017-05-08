<?php
session_start();  //strona rejestracji uzytkownika, dostepna bez zalogowania

if (isset($_SESSION['logged'])) {
    header("location: index.php");
    exit;
}

function __autoload($className) {
    require_once "src/" . $className . ".php";
}
require_once "src/connect.php";

$infoMessageForUser = ""; 
$conn = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && trim($_POST['username']) != '' && isset($_POST['captcha']) 
            && ($_POST['captcha'] >= 10) && ($_POST['captcha'] <= 85) && isset($_POST['userEmail']) 
            && trim($_POST['userEmail']) != '' && isset($_POST['userPassword1']) 
            && trim($_POST['userPassword1']) != '' && isset($_POST['userPassword2']) 
            && trim($_POST['userPassword2']) != '') {
        if (trim($_POST['userPassword1']) == trim($_POST['userPassword2'])) {
            if (User::loadUserByEmail($conn, $_POST['userEmail']) !== null) {
                $infoMessageForUser = "Podany adres e-mail ma już dziuplę, wybierz inny";
            } else {
                $newUser = new User();
                $newUser->setEmail($_POST['userEmail'])->setHashedPassword($_POST['userPassword1'])
                        ->setUsername($_POST['username']);
                if ($newUser->saveToDB($conn) == true) {
                    $_SESSION['logged'] = $newUser->getUsername();
                    $_SESSION['user_id'] = $newUser->getId();
                    header("location: index.php");
                    $conn->close();
                    $conn = null;
                    exit;
                } else {
                    $infoMessageForUser = "Błąd połączenia z bazą, spróbuj za kilka minut";
                }
            }
        } else {
            $infoMessageForUser = "Hasła nie są identyczne, trzeba się zdecydować, którego używać";
        }
    } else {
        $infoMessageForUser = "Wypełnij wszystkie pola prawidłowo, nie rób byle jakiej dziupli.";
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
                    <h4 class="warning"><?= $infoMessageForUser ?></h4>
                </center>  

                <form method="POST" action="">
                    <label> Aby mieć dziuplę w lesie wypełnij wszystkie pola: <br/><br/>
                        <input type="text" name="username" placeholder="Podaj nazwę dzięcioła" size="50" 
                               id="usernameCreateUser" data-max_char_input="65"
                               pattern=".{3,65}"   required title="Minimalna liczba znaków to 3, maksymalna 65"/>  <br/> 
                        <input type="email" name="userEmail" placeholder="Tu wpisz e-mail" size="50" 
                               id="userEmailCreateUser" data-max_char_input="250"
                               pattern=".{5,250}"   required title="Minimalna liczba znaków to 5, maksymalna 250"/>  <br/>
                        <input type="password" name="userPassword1" placeholder="I ustal hasło" size="50" 
                               id="userPassword1CreateUser" data-max_char_input="65"
                               pattern=".{3,65}"   required title="Minimalna liczba znaków to 3, maksymalna 65"/> <br/>
                        <input type="password" name="userPassword2" placeholder="Dla pewności wpisz hasło ponownie" size="50" 
                               id="userPassword2CreateUser" data-max_char_input="65"
                               pattern=".{3,65}"   required title="Minimalna liczba znaków to 3, maksymalna 65"/> <br/><br/>
                        Potwierdź, że nie jesteś borsukiem i przepisz drugi i 3 znak: <br/>
                        <img src="img/<?= rand(1, 10) ?>.png"/><br/>
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
