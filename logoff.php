<?php

  session_start();
  
  if (!isset($_SESSION['logged'])) {
    header("location: logon.php");
    exit;
  }
  
  unset($_SESSION['logged']);
  unset($_SESSION['user_id']);
  unset($_SESSION['user_email']);
  
  /* po testach, ponizsze niepotrzebne
  include_once "src/User.php";
  include_once "src/Tweet.php";
  include_once "src/connect.php";
  
  $conn = getDbConnection();

  $conn->close();
  $conn = null;  */

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
	  
	  <div class="logo">
            <img class="logoimage" id="logoimage" src="img/logo.jpg">  
	  </div>


      <div class="content">
      <!-- Strona wylogowania, dodatek - logoff.php -->
        <br /><br />
        <center>
          <h3>Opuściłeś dziuplę.</h3>  
        </center> <br /><br />
        
        <center>
          <h4><a href="logon.php">Kliknij tutaj żeby przejść do strony logowania.</a></h4>
        </center>
      
      </div>

      <div class ="footer">
                  <br/><br/>
                  <a href="http://www.lesnepogotowie.pl/" target="_blank">Leśne pogotowie</a>
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
