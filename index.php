<?php
session_start(); //Strona glowna wyświetlająca wszystkie 'tweety'

if (!isset($_SESSION['logged'])) {
    header("location: logon.php");
    exit;
}

require_once "src/User.php";
require_once "src/Tweet.php";
require_once "src/connect.php";
require_once 'src/Comment.php';
require_once 'src/Message.php';

$conn = getDbConnection();

// dodawanie nowego'tweeta' 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id']) 
        && isset($_POST['newTweet']) && strlen(trim($_POST['newTweet'])) >= 3 
        && strlen(trim($_POST['newTweet'])) <= 140) {
    $userId = $_SESSION['user_id'];
    $userTweet = trim($_POST['newTweet']);

    $newTweet = new Tweet();
    $newTweet->setUserId($userId);
    $newTweet->setText($userTweet);
    $newTweet->setCreationDate(date("Y-m-d H:i:s"));
    $newTweet->saveToDb($conn);
    unset($_POST['newTweet']);
}

//info o nowych wiadomosciach po zalogowaniu
$messageInfo = "";
if (isset($_SESSION['newPrivateMessage'])) {
    $messageInfo = "<p class=\"warning\">Zajrzyj do <a href=\"messages.php\""
            . ">skrzynki odbiorczej</a>, coś tam na ciebie czeka</p>";
    unset($_SESSION['newPrivateMessage']);
}
?>

<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>Dzięcioły - index</title>

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
<?= $messageInfo ?>
                <center>
                    <form method="POST" action="#">
<?= $_SESSION['logged'] ?>, masz wiadomość z lasu? Wpisz ją poniżej i nie przekrocz 140 znaków, bo las zapłonie.<br/>
                        <input type="text" size="100" name="newTweet"
                               pattern=".{1,140}" required title="Minimalna liczba znaków to 3, maksymalna 140"/> <br/>
                        <input type="submit" value="Opublikuj !"/>
                    </form>
                </center> <br/>

<?php
$allTweets = Tweet::loadAllTweets($conn);

foreach ($allTweets as $tweet) {
    $userId = $tweet->getUserId();
    $tweetId = $tweet->tweetId;
    $commentsCount = Comment::countAllCommentsByTweetId($conn, $tweetId);

    echo "<table class='tweet'>";
    echo "<tr><td> ";
    echo "Autor: <a href=\"showuser.php?strangeuser=$userId\">" . User::loadUserById($conn, $userId)->getUsername() . "</a> ";
    echo "Data publikacji: " . $tweet->getCreationDate() . " ";
    echo "<a href=\"detail.php?tweetid=$tweetId&fromindex=true\">Skomentuj (" . $commentsCount . ")</a>";
    echo "</td></tr> <tr><td>";
    echo $tweet->getText();
    echo "</td></tr>";
    echo "</table> <br/>";
}

$conn->close();
$conn = null;
?>
                <!-- 5x br do odsloniecia ostatniego tweeta (przyklejony dolny panel) -->
                <br/><br/><br/><br/><br/> 
            </div>

<?php
include 'src/bottom_menu_logged.php';
?>   

        </div>
    </body>
</html>
