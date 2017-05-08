<?php
session_start();

if (!isset($_SESSION['logged']) || !isset($_SESSION['user_id'])) {
    header("location: logon.php");
    exit;
}

function __autoload($className) {
    require_once "src/" . $className . ".php";
}
require_once "src/connect.php";

$conn = getDbConnection();
$titleMessage = "Dzięcioły - wiadomości";
$loadedUser = User::loadUserById($conn, $_SESSION['user_id']);
$numberOfNewMessages = $loadedUser->countNewMessages($conn);

if ($numberOfNewMessages == 1) {
    $titleMessage = "Jedna nowa wiadomość";
} else if ($numberOfNewMessages > 1) {
    $titleMessage = "Nowe wiadomości: " . $numberOfNewMessages;
}
?>

<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title><?=$titleMessage?></title>

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

                <p><strong>Wszystkie twoje odebrane wiadomości: </strong></p>

                <?php
                $messageIn = Message::loadAllCutMessagesByReceiverId($conn, $_SESSION['user_id']);

                foreach ($messageIn as $cutMessage) {
                    echo "<div class=\"tweet\">";
                    if ($cutMessage->getMessageRead() == 0) {
                        echo "<span class=\"warning\">NOWA </span>";
                    }
                    $senderId = $cutMessage->getMessageSenderId();
                    echo "Nadawca: <a href=\"showuser.php?strangerUser=$senderId\">" . User::loadUserById($conn, $cutMessage->getMessageSenderId())->getUsername() . "</a>";
                    echo "<br/> Data: " . $cutMessage->getMessageCreationdate() . " <br/>";
                    echo "Nagłówek wiadomości: " . $cutMessage->getMessageContent() . "<br/>";
                    $messageIdForGet = $cutMessage->getMessageId();
                    echo "<a href=\"messageinfo.php?messageid=$messageIdForGet&reciv=true\">Przeczytaj całość</a> ";
                    echo " <a href=\"showuser.php?strangerUser=$senderId\">Odpowiedz</a>";
                    echo " <a href=\"messagedelete.php?messageid=$messageIdForGet&reciv=true\">USUŃ</a> ";
                    echo "</div><br/>";
                }
                ?>

                <p><strong>Wszystkie twoje wysłane wiadomości: </strong></p>

                <?php
                $messageOut = Message::loadAllCutMessagesBySenderId($conn, $_SESSION['user_id']);

                foreach ($messageOut as $cutMessage) {
                    echo "<div class=\"tweet\">";
                    $receiverId = $cutMessage->getMessageReceiverId();
                    echo "Odbiorca: <a href=\"showuser.php?strangerUser=$receiverId\">" . User::loadUserById($conn, $cutMessage->getMessageReceiverId())->getUsername() . "</a>";
                    if ($cutMessage->getMessageRead() == 0) {
                        echo "<span class=\"warning\"> (nieprzeczytana) </span>";
                    }
                    echo "<br/> Data: " . $cutMessage->getMessageCreationdate() . " <br/>";
                    echo "Nagłówek wiadomości: " . $cutMessage->getMessageContent() . "<br/>";
                    $messageIdForGet = $cutMessage->getMessageId();
                    echo "<a href=\"messageinfo.php?messageid=$messageIdForGet&send=true\">Wyświetl</a> ";
                    echo " <a href=\"showuser.php?strangerUser=$receiverId\">Wyślij kolejną</a>";
                    echo " <a href=\"messagedelete.php?messageid=$messageIdForGet&send=true\">USUŃ</a> ";
                    echo "</div><br/>";
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
