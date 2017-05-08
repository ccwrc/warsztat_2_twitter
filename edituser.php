<?php
// zmiana nazwy / hasla / usuniecie konta
session_start();

if (!isset($_SESSION['logged']) || !isset($_SESSION['user_id'])) {
    header("location: logon.php");
    exit;
}

function __autoload($className) {
    require_once "src/" . $className . ".php";
}

require_once "src/connect.php";

$message = ""; // wiadomosc informacyjna
$conn = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loadedUser = User::loadUserById($conn, $_SESSION['user_id']);

    // zmiana nazwy usera
    if (isset($_POST['newUsername']) && isset($_POST['oldPassword']) 
            && (strlen(trim($_POST['newUsername']))) >= 3 
            && (strlen(trim($_POST['newUsername']))) <= 65 
            && ($loadedUser->userAuthentication($_POST['oldPassword']))) {
        $loadedUser->setUsername($_POST['newUsername']);
        if ($loadedUser->saveToDB($conn)) {
            $_SESSION['logged'] = $loadedUser->getUsername();
            $message = "Nazwa dzięcioła została zmieniona";
            unset($_POST['newUsername']);
            unset($_POST['oldPassword']);
        } else {
            $message = "Błąd połączenia z bazą, zapukaj za kilka minut";
        }
    } else if (isset($_POST['newUsername']) && isset($_POST['oldPassword']) 
            && (strlen(trim($_POST['newUsername']))) >= 3 
            && (strlen(trim($_POST['newUsername'])))) {
        $message = "Błędne hasło";
    }

    // zmiana hasła usera
    if (isset($_POST['newPassword1']) && isset($_POST['newPassword2']) 
            && isset($_POST['oldPassword']) && (strlen(trim($_POST['newPassword1'])) >= 3) 
            && (strlen(trim($_POST['newPassword1'])) <= 65) 
            && ($_POST['newPassword1'] === $_POST['newPassword2']) 
            && ($loadedUser->userAuthentication($_POST['oldPassword']))) {
        $loadedUser->setHashedPassword($_POST['newPassword1']);
        if ($loadedUser->saveToDB($conn)) {
            $message = "Hasło zostało zmienione";
            unset($_POST['newPassword1']);
            unset($_POST['newPassword2']);
            unset($_POST['oldPassword']);
        } else {
            $message = "Błąd połączenia z bazą, zapukaj za kilka minut";
        }
    } else if (isset($_POST['newPassword1']) && isset($_POST['newPassword2']) 
            && isset($_POST['oldPassword']) && (strlen(trim($_POST['newPassword1'])) >= 3) 
            && (strlen(trim($_POST['newPassword1'])) <= 65)) {
        $message = "Błędne hasło";
    }

    // usuniecie usera
    if (isset($_POST['deleteUserPassword']) 
            && ($loadedUser->userAuthentication($_POST['deleteUserPassword']))) {
        if ($loadedUser->deleteById($conn)) {
            unset($_POST);
            $conn->close();
            $conn = null;
            session_unset();
            header("location: logon.php");
            exit;
        } else {
            $message = "Błąd połączenia z bazą, zapukaj za kilka minut";
        }
    } else if (isset($_POST['deleteUserPassword'])) {
        $message = "Błędne hasło";
    }

    unset($_POST['deleteuUserPassword']);
    unset($_POST['newUsername']);
    unset($_POST['newPassword1']);
    unset($_POST['newPassword2']);
    unset($_POST['oldPassword']);
}

$conn->close();
$conn = null;
?>

<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Dzięcioły - edycja użytkownika </title>
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
                <div class="logged"> <?= $_SESSION['logged'] ?> jest w dziupli. </div>
            </div>

            <div class="content">
                <br/>
                <center>
                    <p>Wybierz co chcesz zrobić:</p>
                </center>
                <center>
                    <a href="edituser.php?changename=true">&nbsp;Zmień nazwę dzięcioła&nbsp;</a>  
                </center> <br/>
                <center>
                    <a href="edituser.php?changepassword=true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ustal 
                        nowe hasło&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>  
                </center> <br/>
                <center>
                    <a class="warning" href="edituser.php?deleteuser=true" size="55">&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Usuń dziuplę&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                </center> <br/>

                <center>
                    <p class='warning'><?= $message ?></p>
                </center> <br/>
<?php
//zmiana nazwy
if (isset($_GET['changename']) && ($_GET['changename'] === 'true')) {

    echo "<form method=\"POST\" action=\"edituser.php\">";
    echo "<label> Podaj nową nazwę dzięcioła i hasło: <br/>";
    echo "<input type=\"text\" name=\"newUsername\" placeholder=\"Tu wpisz nową nazwę (3-65 znaków"
    . ")\" size=\"50\" id=\"newUsernameOnEditUser\" data-max_char_input=\"65\"/> <br/>";
    echo "<input type=\"password\" name=\"oldPassword\" placeholder=\"Tu wpisz swoje hasło\" siz"
    . "e=\"50\" id=\"oldPasswordOnEditUser\" data-max_char_input=\"65\"/> <br/>";
    echo "<input type=\"submit\" value=\"Zatwierdź\"/>";
    echo "</label>";
    echo "</form>";
}

// zmiana hasla
if (isset($_GET['changepassword']) && ($_GET['changepassword'] === 'true')) {

    echo "<form method=\"POST\" action=\"edituser.php\">";
    echo "<label> Podaj stare i nowe hasło: <br/>";
    echo "<input type=\"password\" name=\"oldPassword\" placeholder=\"Tu wpisz swoje stare "
    . "hasło\" size=\"50\" id=\"oldPassword2onEditUser\" data-max_char_input=\"65\"/> <br/>";
    echo "<input type=\"password\" name=\"newPassword1\" placeholder=\"Tu wpisz swoje nowe "
    . "hasło (3-65 znaków)\" size=\"50\" id=\"newPassword1onEditUser\" data-max_char_input=\"65\"/> <br/>";
    echo "<input type=\"password\" name=\"newPassword2\" placeholder=\"Dla pewności powtórz nowe "
    . "hasło\" size=\"50\" id=\"newPassword2onEditUser\" data-max_char_input=\"65\"/> <br/>";
    echo "<input type=\"submit\" value=\"Zatwierdź\"/>";
    echo "</label>";
    echo "</form>";
}

// usuniecie usera
if (isset($_GET['deleteuser']) && ($_GET['deleteuser'] === 'true')) {

    echo "<form method=\"POST\" action=\"edituser.php\">";
    echo "<label class=\"warning\"> Usunięcie dziupli jest bezpowrotne! <br/>";
    echo "<input type=\"password\" name=\"deleteUserPassword\" placeholder=\"Dla potwierdzenia podaj "
    . "hasło\" size=\"50\" id=\"oldPassword3onEditUser\" data-max_char_input=\"65\"/> <br/>";
    echo "<input type=\"submit\" value=\"Usuń dziuplę!\"/>";
    echo "</label>";
    echo "</form>";
}
?>    
                <!-- 5x br do odsloniecia tresci (przyklejony dolny panel)-->
                <br/><br/><br/><br/><br/> 
            </div>

                <?php
                include 'src/bottom_menu_logged.php';
                ?>      

        </div>
    </body>
</html>
