<?php
session_start();

if (!isset($_SESSION['logged'])) {
    header("location: logon.php");
    exit;
}

session_unset();
?>

<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>Dzięcioły - wyloguj </title>

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
            </div>

            <div class="content">
                <br /><br />
                <center>
                    <h3>Opuściłeś dziuplę, zostały tylko pióra.</h3>  
                </center> <br /><br />

                <center>
                    <h4><a href="logon.php">Kliknij tutaj żeby przejść do strony logowania.</a></h4>
                </center>
            </div>

            <?php
            include 'src/bottom_menu_logoff.php';
            ?>      

        </div>
    </body>
</html>
