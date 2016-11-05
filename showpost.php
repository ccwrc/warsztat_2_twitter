<?php

  session_start();
  
  include_once "src/User.php";
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
	
	<title>Dzięcioły - pokaż post </title>
	
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
      <!-- Strona wyświetlania postu - showpost.php
Ta strona ma wyświetlać: post, autora postu, wszystkie komentarze do każdego z postów.
Formularz do tworzenia nowego komentarza przypisanego do tego postu. -->
   
      
      
      
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
