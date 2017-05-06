<?php
// Strona potwierdzenia dodania komentarza
session_start();

if (!isset($_SESSION['logged']) || !isset($_SESSION['actualTweetId']) 
        || !isset($_POST['newTweetComment'])) {
    header("location: logon.php");
    exit;
}

function __autoload($className) {
    require_once "src/" . $className . ".php";
}

require_once "src/connect.php";

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
                <br/><br/>
                <?php
                $conn = getDbConnection();
                $returnToTweetId = $_SESSION['actualTweetId'];

                if ($_SERVER['REQUEST_METHOD'] == 'POST' && strlen(trim($_POST['newTweetComment'])) >= 3 
                        && strlen(trim($_POST['newTweetComment'])) <= 60) {

                    $newComment = new Comment();
                    $newComment->setUserId($_SESSION['user_id'])->setTweetId($_SESSION['actualTweetId'])
                            ->setCreationDate(date("Y-m-d H:i:s"))->setText(trim($_POST['newTweetComment']));
                    if ($newComment->saveToDb($conn)) {
                        $message = "Komentarz dodany!";
                    }
                } else {
                    $message = "Dodanie komentarza nie było możliwe.";
                }

                unset($_SESSION['actualTweetId']);
                $conn->close();
                $conn = null;

                echo "<br/>";
                echo "&nbsp;" . "<a href='detail.php?tweetid=" . $returnToTweetId . "'>Powrót do strony wpisu</a>";
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
