<?php
session_start();

if (!isset($_SESSION['logged'])) {
    header("location: logon.php");
    exit;
}

function __autoload($className) {
    require_once "src/" . $className . ".php";
}
require_once "src/connect.php";

$infoMessageForUser = "";
?>

<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Dzięcioły - wyszukiwanie użytkowników </title>
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

                <form method="POST" action="">
                    <label> Wypełnij poniższe pole żeby wyszukać dzięcioła: <br/>
                        <input type="text" name="username" placeholder="Podaj nazwę - minimum jeden znak" size="50" 
                               id="usernameSearchUser" data-max_char_input="65"
                               pattern=".{1,65}"   required title="Minimalna liczba znaków to 1, maksymalna 65"/>  <br/> 
                        <input type="submit" value=" Wyszukaj! "/> <br/><br/>
                    </label>    
                </form>

                <?php
                $conn = getDbConnection();
                
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) 
                        && trim($_POST['username']) != "") {
                    $usersFound = User::loadAllUsersByUsername($conn, $_POST['username']);

                    if (empty($usersFound)) {
                        $infoMessageForUser = "Nie znaleziono żadnego użytkownika, podaj inną nazwę.";
                    } else {
                        foreach ($usersFound as $plainUser) {
                            $plainUserId = $plainUser->getId();
                            $plainUserUsername = $plainUser->getUsername();
                            echo "Id: " . $plainUserId . "&nbsp;&nbsp;<a href=\"showuser.php?stranger"
                                    . "User=$plainUserId\"> " . $plainUserUsername . "&nbsp;</a><br/><br/>";
                        }
                    }
                }
                
                $conn->close();
                $conn = null;
                ?>

                <br /> <center>
                    <h4 class="warning"><?= $infoMessageForUser ?></h4>
                </center>  

                <!-- 5x br do odsloniecia ostatniego usera (przyklejony dolny panel) -->
                <br/><br/><br/><br/><br/> 
            </div>

            <?php
            include 'src/bottom_menu_logged.php';
            ?>   

        </div>
    </body>
</html>
