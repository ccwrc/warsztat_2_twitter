<?php
session_start();

if (!isset($_SESSION['logged'])) {
    header("location: logon.php");
    exit;
}

if ((!isset($_GET['messageId'])) || (!is_numeric($_GET['messageId']))) {
    header("location: messages.php");
    exit;
}

function __autoload($className) {
    require_once "src/" . $className . ".php";
}
require_once "src/connect.php";
?>

<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Dzięcioły - detale wiadomości </title>
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
                <?php
                $conn = getDbConnection();

                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    // gdy user wchodzi jako odbiorca wiadomosci
                    if (isset($_GET['reciv']) && ($_GET['reciv'] == 'true')) {
                        $showMessage = Message::loadMessageById($conn, $_GET['messageId']);
                        if ($showMessage == null) {
                            $conn->close();
                            $conn = null;
                            header("location: messages.php");
                            exit;
                        }
                        if (($showMessage->getMessageReceiverId()) != $_SESSION['user_id']) {
                            $conn->close();
                            $conn = null;
                            header("location: messages.php");
                            exit;
                        }
                        $messageSenderId = $showMessage->getMessageSenderId();

                        echo "<div class=\"tweet\">";
                        echo "<br/>Nadawca: " . User::loadUserById($conn, $messageSenderId)->getUsername() . "<br/>";
                        echo "Odbiorca: " . User::loadUserById($conn, $_SESSION['user_id'])->getUsername() . "<br/>";
                        echo "Data i godzina wysłania wiadomości: " . $showMessage->getMessageCreationdate() . "<br/>";
                        echo "---<br/>";
                        echo "Treść wiadomości: " . $showMessage->getMessageContent() . "<br/><br/>";
                        echo "</div><br/>";

                        $showMessage->setMessageRead(1)->saveToDb($conn);
                    }

                    // gdy user wchodzi jako nadawca wiadomości
                    if (isset($_GET['send']) && ($_GET['send'] == 'true')) {
                        $showMessage = Message::loadMessageById($conn, $_GET['messageId']);
                        if ($showMessage == null) {
                            $conn->close();
                            $conn = null;
                            header("location: messages.php");
                            exit;
                        }
                        if (($showMessage->getMessageSenderId()) != $_SESSION['user_id']) {
                            $conn->close();
                            $conn = null;
                            header("location: messages.php");
                            exit;
                        }
                        $messageReceiverId = $showMessage->getMessageReceiverId();

                        echo "<div class=\"tweet\">";
                        echo "<br/>Nadawca: " . User::loadUserById($conn, $_SESSION['user_id'])->getUsername() . "<br/>";
                        echo "Odbiorca: " . User::loadUserById($conn, $messageReceiverId)->getUsername() . "<br/>";
                        echo "Data i godzina wysłania wiadomości: " . $showMessage->getMessageCreationdate() . "<br/>";
                        echo "---<br/>";
                        echo "Treść wiadomości: " . $showMessage->getMessageContent() . "<br/><br/>";
                        echo "</div><br/>";
                    }
                }

                $conn->close();
                $conn = null;
                ?>

                <a href="messages.php">Powrót do poprzedniej strony</a>

                <!-- 5x br do odsloniecia tresci (przyklejony dolny panel)-->
                <br/><br/><br/><br/><br/> 
            </div>

            <?php
            include 'src/bottom_menu_logged.php';
            ?>    

        </div>
    </body>
</html>
