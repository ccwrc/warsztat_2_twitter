<?php
// strona wyswietlania i komentowania postu('tweeta')
session_start();

if (!isset($_SESSION['logged'])) {
    header("location: logon.php");
    exit;
}

if (!isset($_GET['tweetid']) || !is_numeric($_GET['tweetid'])) {
    header("location: index.php");
    exit;
}

function __autoload($className) {
    require_once "src/" . $className . ".php";
}
require_once "src/connect.php";

$conn = getDbConnection();
$tweetDetail = Tweet::loadTweetById($conn, $_GET['tweetid']);

if ($tweetDetail == null) {
    $conn->close();
    $conn = null;
    header("location: index.php");
    exit;
}

// sesja potrzebna do dodania komentarza - commentadded.php
$_SESSION['actualTweetId'] = $_GET['tweetid'];
?>

<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Dzięcioły - detale wpisu </title>
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
                    <form method="POST" action="commentadded.php">
                        Chcesz skomentować poniższy wpis? Do dzieła:
                        <input type="text" size="60" name="newTweetComment" 
                               id="newCommentToTweetOnDetail" data-max_char_input="60"
                               pattern=".{3,60}" required title="Minimalna liczba znaków to 3, maksymalna 60"/> <br/>
                        <input type="submit" value="Skomentuj !"/>
                    </form>
                </center> <br/>

                <?php
                // wejscie ze strony usera (na swoje konto)  
                if (isset($_GET['tweetid']) && !isset($_GET['strangerUser']) && !isset($_GET['fromindex'])) {
                    $userId = $tweetDetail->getUserId();
                    $userName = User::loadUserById($conn, $userId)->getUsername();
                    echo "<div class=\"tweetbold\">";
                    echo "ID wpisu: " . $tweetDetail->getId() . "<br/>";
                    echo "Treść wpisu: " . $tweetDetail->getText() . "<br/>";
                    echo "ID dzięcioła: " . $tweetDetail->getUserId() . "<br/>";
                    echo "Nazwa dzięcioła: " . $userName . "<br/>";
                    echo "Data utworzenia wpisu: " . $tweetDetail->getCreationDate() . "<br/><br/>";
                    echo "</div><br/>";

                    $allComments = Comment::loadAllCommentsByTweetId($conn, $_GET['tweetid']);
                    foreach ($allComments as $comment) {
                        $commentUserId = $comment->getUserId();
                        $commentUserName = User::loadUserById($conn, $commentUserId)->getUsername();
                        echo "<table class='tweet'>";
                        echo "<tr><td> ";
                        echo "Treść komentarza: " . $comment->getText();
                        echo "</td></tr> <tr><td>";
                        echo "Autor komentarza: <a href=\"showuser.php?strangerUser=$commentUserId\">" . $commentUserName . "</a> ";
                        echo "Data publikacji: " . $comment->getCreationDate();
                        echo "</td></tr>";
                        echo "</table> <br/>";
                    }

                    echo "<br/>";
                    echo "&nbsp;" . "<a href=\"showuser.php?strangerUser=" . $tweetDetail->getUserId() . "\">Powrót do poprzedniej strony</a>";
                    echo "<br/><br/>";
                }

                // wejscie ze strony usera obcego
                if (isset($_GET['tweetid']) && isset($_GET['strangerUser'])) {
                    if (!is_numeric($_GET['strangerUser'])) {
                        $conn->close();
                        $conn = null;
                        header("location: index.php");
                        exit;
                    }
                    $userId = $tweetDetail->getUserId();
                    $userName = User::loadUserById($conn, $userId)->getUsername();
                    echo "<div class=\"tweetbold\">";
                    echo "ID wpisu: " . $tweetDetail->getId() . "<br/>";
                    echo "Treść wpisu: " . $tweetDetail->getText() . "<br/>";
                    echo "ID dzięcioła: " . $tweetDetail->getUserId() . "<br/>";
                    echo "Nazwa dzięcioła: " . $userName . "<br/>";
                    echo "Data utworzenia wpisu: " . $tweetDetail->getCreationDate() . "<br/><br/>";
                    echo "</div><br/>";

                    $allComments = Comment::loadAllCommentsByTweetId($conn, $_GET['tweetid']);
                    foreach ($allComments as $comment) {
                        $commentUserId = $comment->getUserId();
                        $commentUserName = User::loadUserById($conn, $commentUserId)->getUsername();
                        echo "<table class='tweet'>";
                        echo "<tr><td> ";
                        echo "Treść komentarza: " . $comment->getText();
                        echo "</td></tr> <tr><td>";
                        echo "Autor komentarza: <a href=\"showuser.php?strangerUser=$commentUserId\">" . $commentUserName . "</a> ";
                        echo "Data publikacji: " . $comment->getCreationDate();
                        echo "</td></tr>";
                        echo "</table> <br/>";
                    }

                    echo "<br/>";
                    echo "&nbsp;" . "<a href=\"showuser.php?strangerUser=" . $tweetDetail->getUserId() . "\">Powrót do poprzedniej strony</a>";
                    echo "<br/><br/>";

                    unset($_GET['strangerUser']);
                }

                // wejscie ze strony glownej
                if (isset($_GET['tweetid']) && isset($_GET['fromindex'])) {
                    $userId = $tweetDetail->getUserId();
                    $userName = User::loadUserById($conn, $userId)->getUsername();
                    echo "<div class=\"tweetbold\">";
                    echo "ID wpisu: " . $tweetDetail->getId() . "<br/>";
                    echo "Treść wpisu: " . $tweetDetail->getText() . "<br/>";
                    echo "ID dzięcioła: " . $tweetDetail->getUserId() . "<br/>";
                    echo "Nazwa dzięcioła: " . $userName . "<br/>";
                    echo "Data utworzenia wpisu: " . $tweetDetail->getCreationDate() . "<br/><br/>";
                    echo "</div><br/>";

                    $allComments = Comment::loadAllCommentsByTweetId($conn, $_GET['tweetid']);
                    foreach ($allComments as $comment) {
                        $commentUserId = $comment->getUserId();
                        $commentUserName = User::loadUserById($conn, $commentUserId)->getUsername();
                        echo "<table class='tweet'>";
                        echo "<tr><td> ";
                        echo "Treść komentarza: " . $comment->getText();
                        echo "</td></tr> <tr><td>";
                        echo "Autor komentarza: <a href=\"showuser.php?strangerUser=$commentUserId\">" . $commentUserName . "</a> ";
                        echo "Data publikacji: " . $comment->getCreationDate();
                        echo "</td></tr>";
                        echo "</table> <br/>";
                    }

                    echo "<br/>";
                    echo "&nbsp;" . "<a href='index.php'>Powrót do poprzedniej strony</a>";
                    echo "<br/><br/>";

                    unset($_GET['fromindex']);
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
