<?php
session_start();

if (!isset($_SESSION['logged'])) {
    header("location: logon.php");
    exit;
}

if ((!isset($_GET['messageid'])) || (!is_numeric($_GET['messageid']))) {
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
                        $messageReceiverId = $_SESSION['user_id'];

                        $showmessage = Message::loadMessageById($conn, $_GET['messageid']);
                        if ($showmessage == null) {
                            $conn->close();
                            $conn = null;
                            header("location: messages.php");
                            exit;
                        }
                        if (($showmessage->getMessageReceiverId()) != $_SESSION['user_id']) {
                            $conn->close();
                            $conn = null;
                            header("location: messages.php");
                            exit;
                        }
                        $messageSenderId = $showmessage->getMessageSenderId();

                        echo "<div class=\"tweet\">";
                        echo "<br/>Nadawca: " . User::loadUserById($conn, $messageSenderId)->getUsername() . "<br/>";
                        echo "Odbiorca: " . User::loadUserById($conn, $messageReceiverId)->getUsername() . "<br/>";
                        echo "Data i godzina wysłania wiadomości: " . $showmessage->getMessageCreationdate() . "<br/>";
                        echo "---<br/>";
                        echo "Treść wiadomości: " . $showmessage->getMessageContent() . "<br/><br/>";
                        echo "</div><br/>";

                        $messageIdForHide = $_GET['messageid'];
                        $sql = "UPDATE message SET message_receiver_visible = 1 WHERE message_id = $messageIdForHide";
                        $result = $conn->query($sql);
                        if ($result == true) {
                            echo "<span class=\"warning\">Wiadomość usunięta ze skrzynki odbiorczej, widzisz ją po raz ostatni</span><br/><br/>";
                        }
                    }

                    // gdy user wchodzi jako nadawca wiadomosci
                    if (isset($_GET['send']) && ($_GET['send'] == 'true')) {
                        $messageSenderId = $_SESSION['user_id'];

                        $showmessage = Message::loadMessageById($conn, $_GET['messageid']);
                        if ($showmessage == null) {
                            $conn->close();
                            $conn = null;
                            header("location: messages.php");
                            exit;
                        }
                        if (($showmessage->getMessageSenderId()) != $_SESSION['user_id']) {
                            $conn->close();
                            $conn = null;
                            header("location: messages.php");
                            exit;
                        }
                        $messageReceiverId = $showmessage->getMessageReceiverId();

                        echo "<div class=\"tweet\">";
                        echo "<br/>Nadawca: " . User::loadUserById($conn, $messageSenderId)->getUsername() . "<br/>";
                        echo "Odbiorca: " . User::loadUserById($conn, $messageReceiverId)->getUsername() . "<br/>";
                        echo "Data i godzina wysłania wiadomości: " . $showmessage->getMessageCreationdate() . "<br/>";
                        echo "---<br/>";
                        echo "Treść wiadomości: " . $showmessage->getMessageContent() . "<br/><br/>";
                        echo "</div><br/>";

                        $messageIdForHide = $_GET['messageid'];
                        $sql = "UPDATE message SET message_sender_visible = 1 WHERE message_id = $messageIdForHide";
                        $result = $conn->query($sql);
                        if ($result == true) {
                            echo "<span class=\"warning\">Wiadomość usunięta ze skrzynki nadawczej, widzisz ją po raz ostatni</span><br/><br/>";
                        }
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
