<?php
session_start();   // strona dostepna bez zalogowania, ale wydaje sie to logiczne...

if (isset($_SESSION['logged'])) {
    header("location: index.php");
    exit;
}

function __autoload($className) {
    require_once "src/" . $className . ".php";
}
require_once "src/connect.php";
require_once 'src/functions.php';

$message = ""; //wiadomosc podawana po blednej probie zalogowania

$conn = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['useremail']) && isset($_POST['userpassword']) 
            && trim($_POST['useremail']) != '' && trim($_POST['userpassword']) != '') {

        $userEmail = strtolower(trim($_POST['useremail']));
        $userPassword = trim($_POST['userpassword']);
        $userEmail = $conn->real_escape_string($userEmail);
        $userPassword = $conn->real_escape_string($userPassword);

        $sql = "SELECT * FROM users WHERE user_email = '$userEmail'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            foreach ($result as $row) {
                $getUserId = $row['user_id'];
                $getHashedPassword = $row['hashed_password'];
                $getName = $row['user_name'];
            }
            if (password_verify($userPassword, $getHashedPassword)) {
                $_SESSION['logged'] = $getName;
                $_SESSION['user_id'] = $getUserId;
                //sprawdzanie nowych wiadomosci
                if (checkNewMessages($getUserId, $conn) >= 1) {
                    $_SESSION['newPrivateMessage'] = "set";
                }
                header("location: index.php");
            } else {
                $message = "Błędne hasło, albo adres mailowy nie ma własnej dziupli";
            }
        } else {
            $message = "Błędne hasło, albo adres mailowy nie ma własnej dziupli";
        }
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

        <title>Dzięcioły - zaloguj </title>

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

                <br />
                <center>
                    <form method='POST' action=''>
                        <label> <center>Podaj dane dostępu do dziupli: <br/><br/>
                            </center>
                            <input type="email" name="useremail" placeholder="Podaj e-mail" 
                                   id="userEmailOnLogon" data-max_char_input="250"
                                   pattern=".{5,250}"   required title="Minimalna liczba znaków to 5, maksymalna 250"/>  
                            <input type="password" name="userpassword" placeholder="I wpisz hasło" 
                                   id="userPasswordOnLogon" data-max_char_input="65"
                                   pattern=".{3,65}"   required title="Minimalna liczba znaków to 3, maksymalna 65"/>
                            <input type="submit" value="Wejdź do dziupli"/>
                        </label>
                    </form>
                </center>

                <br />
                <center>
                    <h4><a href="create.php">Nie masz własnej dziupli w lesie? Kliknij tutaj żeby ją stworzyć.</a></h4>
                </center>    

            </div>

            <?php
            include 'src/bottom_menu_logoff.php';
            ?>

        </div>
    </body>
</html>
