<?php
// strona wyswietlania i komentowania postu('tweeta')
session_start();

if (!isset($_SESSION['logged'])) {
    header("location: logon.php");
    exit;
}

if (!isset($_GET['tweetId']) || !is_numeric($_GET['tweetId'])) {
    header("location: index.php");
    exit;
}

function __autoload($className) {
    require_once "src/" . $className . ".php";
}
require_once "src/connect.php";

$conn = getDbConnection();
$tweetDetail = Tweet::loadTweetById($conn, $_GET['tweetId']);

if ($tweetDetail == null) {
    $conn->close();
    $conn = null;
    header("location: index.php");
    exit;
}

// sesja dla commentadded.php (wykorzystane w linku powrotu do tweeta)
$_SESSION['actualTweetId'] = $_GET['tweetId'];
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
                if (isset($_GET['tweetId']) && !isset($_GET['strangerUser']) && !isset($_GET['fromIndex'])) {
                    include 'src/load_tweet_and_comments.php';
                    echo "&nbsp;" . "<a href=\"showuser.php?strangerUser=" . $tweetDetail->getUserId() . "\">Powrót do poprzedniej strony</a>";
                    echo "<br/><br/>";
                }

                // wejscie ze strony usera obcego
                if (isset($_GET['tweetId']) && isset($_GET['strangerUser'])) {
                    if (!is_numeric($_GET['strangerUser'])) {
                        $conn->close();
                        $conn = null;
                        header("location: index.php");
                        exit;
                    }
                    include 'src/load_tweet_and_comments.php';
                    echo "&nbsp;" . "<a href=\"showuser.php?strangerUser=" . $tweetDetail->getUserId() . "\">Powrót do poprzedniej strony</a>";
                    echo "<br/><br/>";

                    unset($_GET['strangerUser']);
                }

                // wejscie ze strony glownej
                if (isset($_GET['tweetId']) && isset($_GET['fromIndex'])) {     
                    include 'src/load_tweet_and_comments.php';
                    echo "&nbsp;" . "<a href='index.php'>Powrót do poprzedniej strony</a>";
                    echo "<br/><br/>";

                    unset($_GET['fromIndex']);
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
