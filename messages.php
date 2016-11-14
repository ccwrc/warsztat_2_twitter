<?php

  session_start();
  
  if (!isset($_SESSION['logged'])) {
    header("location: logon.php");
    exit;
  }
  
  include_once "src/User.php";
  include_once "src/Tweet.php";
  include_once "src/connect.php";

  $conn = getDbConnection();




  
  
  $conn->close();
  $conn = null;

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>Dzięcioły - wiadomości </title>
	
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
            <div class="logged"> <?=$_SESSION['logged']?> jest w dziupli. </div>
	  </div>


      <div class="content">
      <!-- Strona z wiadomościami - messages.php
Użytkownik ma mieć możliwość wyświetlenia listy wiadomości, które otrzymał i wysłał.
 Wiadomości wysłane mają wyświetlać odbiorcę, datę wysłania i początek wiadomości (pierwsze 30 znaków).
 Wiadomości odebrane mają wyświetlać nadawcę, datę wysłania i początek wiadomości (pierwsze 30 znaków).
Wiadomości jeszcze nieprzeczytane powinny być jakoś oznaczone. -->
   
      
      
      
      </div>


      <div class ="footer">
                  <br/><br/>
                  <a href="http://www.lesnepogotowie.pl/" target="_blank">Leśne pogotowie</a>
		  <a href="index.php">Dzięcioły</a> 
		  <a id="footerlink2" href="logon.php">Logowanie</a> 
		  <a id="footerlink3" href="create.php">Stwórz dziuplę</a> 
		  <a href="showuser.php">Pokaż dzięcioła</a> 
		  <a href="edituser.php">Edycja dziupli</a> 
		  <a href="messages.php">Wiadomości</a> 
		  <a href="logoff.php">Wyloguj</a> 
      </div>        
          
  </div>
</body>
</html>
