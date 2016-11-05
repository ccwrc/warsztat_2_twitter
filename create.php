<?php

  session_start();  //strona dostepna bez zalogowania !
  
  include_once "src/User.php";
  include_once "src/connect.php";

  $conn = getDbConnection();

echo date("Y-m-d H:i:s");




  $conn->close();
  $conn = null;  
  
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>Dzięcioły - stwórz własną dziuplę w lesie </title>
	
	<meta name="description" content="Prawie jak Twitter" />
	<meta name="keywords" content="dzięcioły, twitter" />
	<meta name="author" content="ccwrc">
	
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	
	<script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/app.js"></script>	
</head>

<body>
  <div class="container">
	  
	  <div class="logo">
            <img class="logoimage" id="logoimage" src="img/logo.jpg">  
            <h2>dzięcioły.pl</h2>    
	  </div>


      <div class="content">
      <!-- (dostepna bez zalogowania) Strona tworzenia użytkownika - create.php
Strona ma pobierać email i hasło.
Jeżeli takiego emaila nie ma jeszcze w systemie, to dodać go i zalogować (przekierować na stronę 
  główną).
Jeżeli taki email jest, to przekierować znowu do strony tworzenia użytkownika i wyświetlić
komunikat o zajętym adresie email. -->
   div test display
      
      
      
      </div>


      <div class ="footer">
		  <a href="index.php">Dzięcioły</a> 
		  <a href="logon.php">Logowanie</a> 
		  <a href="create.php">Stwórz dziuplę</a> 
		  <a href="showuser.php">Pokaż dzięcioła</a> 
		  <a href="edituser.php">Edycja dziupli</a> 
		  <a href="messages.php">Wiadomości</a> 
		  <a href="logoff.php">Wyloguj</a> 
      </div>     
          
  </div>
</body>
</html>
