<?php
session_start();

if (!isset($_SESSION['logged'])) {
    header("location: logon.php");
    exit;
}

// blokada wyslania wiadomosci do samego siebie
if (isset($_GET['strangerUser']) && (($_GET['strangerUser']) == ($_SESSION['user_id']))) {
    unset($_GET['strangerUser']);
}

function __autoload($className) {
    require_once "src/" . $className . ".php";
}
require_once "src/connect.php";

$infoMessageForUser = ""; 
$conn = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['messageForStranger']) 
        && strlen(trim($_POST['messageForStranger'])) <= 25000 
        && strlen(trim($_POST['messageForStranger'])) >= 1) {

    $newMessage = Message::createMessage($_POST['messageForStranger'], date("Y-m-d H:i:s"), 
            $_SESSION['strangerUserIdForMessage'], $_SESSION['user_id']);
    if ($newMessage->saveToDb($conn)) {
        $infoMessageForUser = "Wiadomość wysłana <br/><br/>";
    } else {
        $infoMessageForUser = "Błąd wysyłania wiadomości <br/><br/>";
    }
}

if (isset($_SESSION['strangerUserIdForMessage'])) {
    unset($_SESSION['strangerUserIdForMessage']);
}
?>

<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>Dzięcioły - pokaż użytkownika </title>

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

                <br/> <span class="warning"><?= $infoMessageForUser ?></span>
                <?php
                // widok strony, gdy user wchodzi ogladac swoj profil
                if (!isset($_GET['strangerUser'])) {
                    echo "<strong>";
                    echo "Wszystkie twoje wpisy w lesie: <br/><br/>";
                    echo "</strong>";
                    $myTweets = Tweet::loadAllTweetsByUserId($conn, $_SESSION['user_id']);
                    if (count($myTweets) > 0) {
                        foreach ($myTweets as $key => $tweet) {
                            $commentsCount = Comment::countAllCommentsByTweetId($conn, $tweet->getId());
                            echo "<div class=\"tweet\">";
                            echo "Wpis o ID " . $tweet->getId() . ": ";
                            echo $tweet->getText() . "<br/>";
                            echo "Data utworzenia wpisu: " . $tweet->getCreationDate() . " <b>Komentarze"
                                . ": " . $commentsCount . "</b> &nbsp;" . "<a href=\"detail.php?"
                                . "tweetid=" . $tweet->getId() . "\">Detale wpisu</a>" . "<br/><br/>";
                            echo "</div><br/>";
                        }
                    } else {
                        echo "Nie podzieliłeś się z nikim wiadomością, może czas to zmienić? ";
                        echo "<a href='index.php'>Kliknij tutaj.</a> ";
                    }
                }

                // widok strony, gdy user wchodzi ogladac cudzy profil
                if (isset($_GET['strangerUser'])) {
                    if (!is_numeric($_GET['strangerUser'])) {
                        $conn->close();
                        $conn = null;
                        header("location: index.php");
                        exit;
                    }
                    $strangerUser = User::loadUserById($conn, (int)$_GET['strangerUser']);
                    if ($strangerUser == null) {
                        $conn->close();
                        $conn = null;
                        header("location: index.php");
                        exit;
                    }

                    echo "<strong>";
                    echo "Jesteś na stronie dzięcioła o nicku: " . $strangerUser->getUsername() . "<br/><br/>";
                    echo "</strong>";

                    $_SESSION['strangerUserIdForMessage'] = $strangerUser->getId();
                    //formularz wysylania wiadomosci do obcego uzytkownika
                    echo "<form method=\"POST\" action=\"\">";
                    echo "<textarea name=\"messageForStranger\" cols=50 placeholder=\"Tu wpisz wiadomość "
                        . "do dzięcioła (maksymalnie 25000 znaków).\" maxlength=\"25000\" id=\"newMessageOnShowUser"
                        . "\" data-max_char_input=\"25000\"></textarea><br/>";
                    echo " <input type=\"submit\" value=\"Kliknij żeby wysłać\"/>";
                    echo "</form> <br/><br/>";
                    
                    $strangerUserTweets = Tweet::loadAllTweetsByUserId($conn, $strangerUser->getId());
                    if (count($strangerUserTweets) > 0) {
                        echo "<strong>Wiadomości z lasu od użytkownika: </strong><br/><br/>";
                        foreach ($strangerUserTweets as $key => $tweet) {
                            $commentsCount = Comment::countAllCommentsByTweetId($conn, $tweet->getId());
                            echo "<div class=\"tweet\">";
                            echo "Wpis o ID " . $tweet->getId() . ": ";
                            echo $tweet->getText() . "<br/>";
                            echo "Data utworzenia wpisu: " . $tweet->getCreationDate() . " <b>Komentarze"
                                . ": " . $commentsCount . "</b> &nbsp;" . "<a href=\"detail.php?"
                                . "tweetid=" . $tweet->getId() . "&strangerUser=" . $strangerUser->getId() . "\""
                                . ">Detale wpisu</a><br/><br/>";
                            echo "</div><br/>";
                        }
                    } else {
                        echo "Użytkownik nie zostawił w lesie żadnego wpisu.";
                    }
                }
                $conn->close();
                $conn = null;
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
