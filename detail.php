<?php

  session_start();

  if (!isset($_SESSION['logged'])) {
    header("location: logon.php");
    exit;
  } 
  
  if (!isset($_GET['tweetid'])) {
    header("location: index.php");
    exit;
  } 
  
  include_once "src/User.php";
  include_once "src/Tweet.php";
  include_once "src/connect.php";

  // $conn = getDbConnection();



  // $conn->close();
  // $conn = null;
  
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
	  
	  <div class="logo">
            <img class="logoimage" id="logoimage" src="img/logo.jpg">  
            <div class="logged"> <?=$_SESSION['logged']?> jest w dziupli. </div>
	  </div>


      <div class="content">
      <!-- detale wpisu, dodatek - detail.php  -->

      <br/><br/>
     
    <?php
      
      $conn = getDbConnection();
      $id = $_GET['tweetid']; 
      $tweetDetail = Tweet::loadTweetById($conn, $id);

      echo "ID wpisu: " . $tweetDetail->getId() . "<br/>";
      echo "Treść wpisu: " . $tweetDetail->getText() . "<br/>";
      echo "ID dzięcioła: " . $tweetDetail->getUserId() . "<br/>";
      echo "Data utworzenia wpisu: " . $tweetDetail->getCreationDate() . "<br/>";
      
     $conn->close();
     $conn = null;
      
    ?>
      
      <br/>
      &nbsp; <a href="showuser.php">Powrót do poprzedniej strony</a> 
      <br/><br/>
      
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
