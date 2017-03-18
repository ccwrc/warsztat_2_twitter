<?php
session_start();

if (!isset($_SESSION['logged'])) {
    header("location: logon.php");
    exit;
}

// blokada wyslania wiadomosci do samego siebie
if (isset($_GET['strangeuser']) && (($_GET['strangeuser']) == ($_SESSION['user_id']))) {
    unset($_GET['strangeuser']);
}

require_once "src/User.php";
require_once "src/Tweet.php";
require_once "src/connect.php";
require_once 'src/Comment.php';
require_once 'src/Message.php';

$message = ""; //komunikat informacyjny (pomyślne wysłanie wiadomosci do uzytkownika)

$conn = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['messageForStranger']) && (trim($_POST['messageForStranger']) != '') 
            && strlen(trim($_POST['messageForStranger'])) <= 25000) {
        $receiverId = $_SESSION['strangeUserIdForMessage'];
        $senderId = $_SESSION['user_id'];
        $messageForStranger = trim($_POST['messageForStranger']);

        $newMessage = new Message();
        $newMessage->setMessageContent($messageForStranger);
        $newMessage->setMessageCreationDate(date("Y-m-d H:i:s"));
        $newMessage->setMessageReceiverId($receiverId);
        $newMessage->setMessageSenderId($senderId);
        $newMessage->saveToDb($conn);

        $message = "Wiadomość wysłana <br/><br/>";
    }
}

if (isset($_SESSION['strangeUserIdForMessage'])) {
    unset($_SESSION['strangeUserIdForMessage']);
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

                <br/> <span class="warning"><?= $message ?></span>
                <?php
                // widok strony, gdy user wchodzi ogladac swoj profil
                if (!isset($_GET['strangeuser'])) {
                    $userid = $_SESSION['user_id'];

                    echo "<strong>";
                    echo "Wszystkie twoje wpisy w lesie: <br/><br/>";
                    echo "</strong>";

                    $sql = "SELECT * FROM tweet WHERE tweet_user_id = $userid";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        foreach ($result as $row) {
                            echo "<div class=\"tweet\">";
                            echo "Wpis o ID " . $row['tweet_id'] . ": ";
                            $commentsCount = Comment::countAllCommentsByTweetId($conn, $row['tweet_id']);
                            echo $row['tweet_text'] . "<br/>";
                            echo "Data utworzenia wpisu: " . $row['tweet_date'] . " <b>Komentarze"
                            . ": " . $commentsCount . "</b> &nbsp;" . "<a href=\"detail.php?"
                            . "tweetid=" . $row['tweet_id'] . "\">Detale wpisu</a>" . "<br/><br/>";
                            echo "</div><br/>";
                        }
                    } else {
                        echo "Nie podzieliłeś się z nikim wiadomością, może czas to zmienić? ";
                        echo "<a href='index.php'>Kliknij tutaj.</a> ";
                    }
                }

                // widok strony, gdy user wchodzi ogladac cudzy profil
                if (isset($_GET['strangeuser'])) {
                    if (!is_numeric($_GET['strangeuser'])) {
                        $conn->close();
                        $conn = null;
                        header("location: index.php");
                        exit;
                    }
                    $userid = $_GET['strangeuser'];

                    if (User::loadUserById($conn, $userid) == null) {
                        $conn->close();
                        $conn = null;
                        header("location: index.php");
                        exit;
                    }

                    echo "<strong>";
                    echo "Jesteś na stronie dzięcioła o nicku: " . User::loadUserById($conn, $userid)->getUsername() . "<br/><br/>";
                    echo "</strong>";

                    $_SESSION['strangeUserIdForMessage'] = $userid;
                    //formularz wysylania wiadomosci do uzytkownika
                    echo "<form method=\"POST\" action=\"\">";
                    echo "<textarea name=\"messageForStranger\" cols=50 placeholder=\"Tu wpisz wiadomość "
                    . "do dzięcioła (maksymalnie 25000 znaków).\" maxlength=\"25000\"></textarea><br/>";
                    echo " <input type=\"submit\" value=\"Kliknij żeby wysłać\"/>";
                    echo "</form> <br/><br/>";

                    $sql = "SELECT * FROM tweet WHERE tweet_user_id = $userid";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        foreach ($result as $row) {
                            echo "<div class=\"tweet\">";
                            echo "Wpis o ID " . $row['tweet_id'] . ": ";
                            $commentsCount = Comment::countAllCommentsByTweetId($conn, $row['tweet_id']);
                            echo $row['tweet_text'] . "<br/>";
                            echo "Data utworzenia wpisu: " . $row['tweet_date'] . " <b>Komentarze: " .
                            $commentsCount . "</b> &nbsp;" . "<a href=\"detail.php?tweetid="
                            . $row['tweet_id'] . "&strangeuser=" . $_GET['strangeuser'] . "\">Detale "
                            . "wpisu</a>" . "<br/><br/>";
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
