<?php

  session_start();   // strona dostepna bez zalogowania !
  
  include_once "src/User.php";
  include_once "src/Tweet.php";
  include_once "src/connect.php";
  
  $message = ""; //wiadomosc podawana po blednej probie zalogowania
  
  $conn = getDbConnection();






  $conn->close();
  $conn = null;
  
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>Dzięcioły - zaloguj </title>
	
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
      <!-- (dostępna bez zalogowania) strona logowania - logon.php
Strona ma przyjmować email użytkownika i jego hasło.
Jeżeli są poprawne, to użytkownik jest przekierowany do strony głównej, jeżeli nie –
do strony logowania, która ma wtedy wyświetlić komunikat o błędnym loginie lub haśle.
Strona logowania ma mieć też link do strony tworzenia użytkownika. -->
        <br /> <center>
        <?=$message?>
        </center>    
      
        <br />
        <center>
        <form method="POST">
            <input type="email" name="useremail" placeholder="Podaj e-mail">  
            <input type="password" name="userpassword" placeholder="I wpisz hasło">
            <input type="button" value="Wejdź do dziupli">
        </form>
        </center>
        
        <br />
        <center>
            <a href="create.php">Nie masz własnej dziupli? Kliknij tutaj żeby ją stworzyć.</a>
        </center>    
      
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
