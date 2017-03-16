<?php
session_start();

if (!isset($_SESSION['logged']) || !isset($_SESSION['actualTweetId']) || !isset($_POST['newtweetcomment'])) {
    header("location: logon.php");
    exit;
}

require_once "src/User.php";
require_once "src/Tweet.php";
require_once "src/connect.php";
require_once 'src/Comment.php';
require_once 'src/Message.php';

// $actualDate = date("Y-m-d H:i:s");
$message = "";
?>

<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>Dzięcioły - dodawanie komentarza </title>

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
                <!-- Strona potwierdzenia dodania komentarza - commentadded.php -->

                <br/><br/>

                <?php
                $conn = getDbConnection();

                if ($_SERVER['REQUEST_METHOD'] == 'POST' 
                        && strlen(trim($_POST['newtweetcomment'])) >= 3
                        && strlen(trim($_POST['newtweetcomment'])) <= 60) {
                    $commentText = trim($_POST['newtweetcomment']);

                    $newComment = new Comment();
                    $newComment->setUserId($_SESSION['user_id']);
                    $newComment->setTweetId($_SESSION['actualTweetId']);
                    $newComment->setCreationDate(date("Y-m-d H:i:s"));
                    $newComment->setText($commentText);
                    $newComment->saveToDb($conn);

                    $message = "Komentarz dodany!";
                    unset($_SESSION['actualTweetId']);
                } else {
                    $message = "Dodanie komentarza nie było możliwe.";
                    unset($_SESSION['actualTweetId']);
                }

                $conn->close();
                $conn = null;

                echo "<br/>";
                echo "&nbsp;" . "<a href='index.php'>Powrót do strony głównej</a>";
                echo "<br/><br/>";
                ?>

                <br /> <center>
                    <h4 class="warning"><?= $message ?></h4>
                </center>  

            </div>

            <?php
            include 'src/bottom_menu_logged.php';
            ?>   

        </div>
    </body>
</html>
