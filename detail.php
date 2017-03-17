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

require_once "src/User.php";
require_once "src/Tweet.php";
require_once "src/connect.php";
require_once 'src/Comment.php';
require_once 'src/Message.php';

$conn = getDbConnection();
$tweetDetail = Tweet::loadTweetById($conn, $_GET['tweetid']);

if ($tweetDetail == null) {
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
                        <input type="text" size="60" name="newtweetcomment"
                               pattern=".{3,60}" required title="Minimalna liczba znaków to 3, maksymalna 60"/> <br/>
                        <input type="submit" value="Skomentuj !"/>
                    </form>
                </center> <br/>

                <?php
                // wejscie ze strony usera (na swoje konto)  
                if (isset($_GET['tweetid']) && !isset($_GET['strangeuser']) && !isset($_GET['fromindex'])) {
                    $userId = $tweetDetail->getUserId();

                    echo "<div class=\"tweetbold\">";
                    echo "ID wpisu: " . $tweetDetail->getId() . "<br/>";
                    echo "Treść wpisu: " . $tweetDetail->getText() . "<br/>";
                    echo "ID dzięcioła: " . $tweetDetail->getUserId() . "<br/>";
                    echo "Nazwa dzięcioła: " . User::loadUserById($conn, $userId)->getUsername() . "<br/>";
                    echo "Data utworzenia wpisu: " . $tweetDetail->getCreationDate() . "<br/><br/>";
                    echo "</div><br/>";

                    $allComments = Comment::loadAllCommentsByTweetId($conn, $_GET['tweetid']);
                    foreach ($allComments as $comment) {
                        $commentUserId = $comment->getUserId();
                        echo "<table class='tweet'>";
                        echo "<tr><td> ";
                        echo "Treść komentarza: " . $comment->getText();
                        echo "</td></tr> <tr><td>";
                        echo "Autor komentarza: <a href=\"showuser.php?strangeuser=$commentUserId\">" . User::loadUserById($conn, $commentUserId)->getUsername() . "</a> ";
                        echo "Data publikacji: " . $comment->getCreationDate();
                        echo "</td></tr>";
                        echo "</table> <br/>";
                    }

                    echo "<br/>";
                    echo "&nbsp;" . "<a href='showuser.php'>Powrót do poprzedniej strony</a>";
                    echo "<br/><br/>";
                }

                // wejscie ze strony usera obcego
                if (isset($_GET['tweetid']) && isset($_GET['strangeuser'])) {
                    if (!is_numeric($_GET['strangeuser'])) {
                        header("location: index.php");
                        exit;
                    }
                    $userId = $tweetDetail->getUserId();

                    echo "<div class=\"tweetbold\">";
                    echo "ID wpisu: " . $tweetDetail->getId() . "<br/>";
                    echo "Treść wpisu: " . $tweetDetail->getText() . "<br/>";
                    echo "ID dzięcioła: " . $tweetDetail->getUserId() . "<br/>";
                    echo "Nazwa dzięcioła: " . User::loadUserById($conn, $userId)->getUsername() . "<br/>";
                    echo "Data utworzenia wpisu: " . $tweetDetail->getCreationDate() . "<br/><br/>";
                    echo "</div><br/>";

                    $allComments = Comment::loadAllCommentsByTweetId($conn, $_GET['tweetid']);
                    foreach ($allComments as $comment) {
                        $commentUserId = $comment->getUserId();
                        echo "<table class='tweet'>";
                        echo "<tr><td> ";
                        echo "Treść komentarza: " . $comment->getText();
                        echo "</td></tr> <tr><td>";
                        echo "Autor komentarza: <a href=\"showuser.php?strangeuser=$commentUserId\">" . User::loadUserById($conn, $commentUserId)->getUsername() . "</a> ";
                        echo "Data publikacji: " . $comment->getCreationDate();
                        echo "</td></tr>";
                        echo "</table> <br/>";
                    }

                    echo "<br/>";
                    echo "&nbsp;" . "<a href=\"showuser.php?strangeuser=" . $tweetDetail->getUserId() . "\">Powrót do poprzedniej strony</a>";
                    echo "<br/><br/>";

                    unset($_GET['strangeuser']);
                }

                // wejscie ze strony glownej
                if (isset($_GET['tweetid']) && isset($_GET['fromindex'])) {
                    $userId = $tweetDetail->getUserId();

                    echo "<div class=\"tweetbold\">";
                    echo "ID wpisu: " . $tweetDetail->getId() . "<br/>";
                    echo "Treść wpisu: " . $tweetDetail->getText() . "<br/>";
                    echo "ID dzięcioła: " . $tweetDetail->getUserId() . "<br/>";
                    echo "Nazwa dzięcioła: " . User::loadUserById($conn, $userId)->getUsername() . "<br/>";
                    echo "Data utworzenia wpisu: " . $tweetDetail->getCreationDate() . "<br/><br/>";
                    echo "</div><br/>";

                    $allComments = Comment::loadAllCommentsByTweetId($conn, $_GET['tweetid']);
                    foreach ($allComments as $comment) {
                        $commentUserId = $comment->getUserId();
                        echo "<table class='tweet'>";
                        echo "<tr><td> ";
                        echo "Treść komentarza: " . $comment->getText();
                        echo "</td></tr> <tr><td>";
                        echo "Autor komentarza: <a href=\"showuser.php?strangeuser=$commentUserId\">" . User::loadUserById($conn, $commentUserId)->getUsername() . "</a> ";
                        echo "Data publikacji: " . $comment->getCreationDate();
                        echo "</td></tr>";
                        echo "</table> <br/>";
                    }

                    echo "<br/>";
                    echo "&nbsp;" . "<a href='index.php'>Powrót do poprzedniej strony</a>";
                    echo "<br/><br/>";

                    unset($_GET['fromindex']);
                }


                // wejscie ze strony biezacej, czyli dodanie nowego komentarza
                if (isset($_GET['tweetid']) && isset($_GET['newtweetcomment'])) {
                    $userId = $tweetDetail->getUserId();

                    $newComment = new Comment();
                    $newComment->setUserId($_SESSION['user_id']);
                    $newComment->setTweetId($_GET['tweetid']);
                    $newComment->setCreationDate(date("Y-m-d H:i:s"));
                    $newComment->setText($_GET['newtweetcomment']);
                    $newComment->saveToDb($conn);

                    echo "<div class=\"tweetbold\">";
                    echo "ID wpisu: " . $tweetDetail->getId() . "<br/>";
                    echo "Treść wpisu: " . $tweetDetail->getText() . "<br/>";
                    echo "ID dzięcioła: " . $tweetDetail->getUserId() . "<br/>";
                    echo "Nazwa dzięcioła: " . User::loadUserById($conn, $userId)->getUsername() . "<br/>";
                    echo "Data utworzenia wpisu: " . $tweetDetail->getCreationDate() . "<br/><br/>";
                    echo "</div><br/>";

                    $allComments = Comment::loadAllCommentsByTweetId($conn, $_GET['tweetid']);
                    foreach ($allComments as $comment) {
                        $commentUserId = $comment->getUserId();
                        echo "<table class='tweet'>";
                        echo "<tr><td> ";
                        echo "Treść komentarza: " . $comment->getText();
                        echo "</td></tr> <tr><td>";
                        echo "Autor komentarza: <a href=\"showuser.php?strangeuser=$commentUserId\">" . User::loadUserById($conn, $commentUserId)->getUsername() . "</a> ";
                        echo "Data publikacji: " . $comment->getCreationDate();
                        echo "</td></tr>";
                        echo "</table> <br/>";
                    }

                    echo "<br/>";
                    echo "&nbsp;" . "<a href='index.php'>Komentarz dodany, wróć do strony głównej</a>";
                    echo "<br/><br/>";

                    unset($_GET['newtweetcomment']);
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
