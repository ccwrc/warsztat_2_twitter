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
	
	<title>Dzięcioły - pokaż użytkownika </title>
	
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
      <!-- Strona wyświetlania użytkownika - showuser.php
Strona ma pokazać wszystkie wpisy danego użytkownika (dodatkowo pod każdym liczbę komentarzy 
      do danego wpisu).
Na tej stronie ma być też guzik, który umożliwi nam wysłanie wiadomości do tego użytkownika. -->

      <br/>
      <?php
      
      if (!isset($_GET['strangeuser'])) {
        $conn = getDbConnection();
        $userid = $_SESSION['user_id'];
        
        echo "<strong>";
        echo "Wszystkie twoje wpisy w lesie: <br/><br/>";
        echo "</strong>";
      
        $sql = "SELECT * FROM tweet WHERE tweet_user_id = $userid";
        $result = $conn->query($sql);
      
        if($result == true && $result->num_rows != 0){
           foreach($result as $row){
             echo "Wpis o ID " . $row['tweet_id'] . ": ";
             echo $row['tweet_text'] . "<br/>";
             echo "Data utworzenia wpisu: " . $row['tweet_date'] . " " . "<a href=\"detail.php?tweetid=".$row['tweet_id']."\">Detale wpisu</a>" . "<br/><br/>";
           }
        } else {
           echo "Nie podzieliłeś się z nikim wiadomością, może czas to zmienić? ";
           echo "<a href='index.php'>Kliknij tutaj.</a> ";
          }
      
        $conn->close();
        $conn = null;
      }
      
      
      if (isset($_GET['strangeuser'])) {
        $conn = getDbConnection();
        $userid = $_GET['strangeuser'];
        
        echo "<strong>";
        echo "Jesteś na stronie dzięcioła o nicku: " . User::loadUserById($conn, $userid)->getUsername() . "<br/><br/>";
        echo "</strong>";
        
        $sql = "SELECT * FROM tweet WHERE tweet_user_id = $userid";
        $result = $conn->query($sql);
      
        if($result == true && $result->num_rows != 0){
           foreach($result as $row){
             echo "Wpis o ID " . $row['tweet_id'] . ": ";
             echo $row['tweet_text'] . "<br/>";
             echo "Data utworzenia wpisu: " . $row['tweet_date'] . " " . "<a href=\"detail.php?tweetid=".$row['tweet_id']."&strangeuser=".$_GET['strangeuser']."\">Detale wpisu</a>" . "<br/><br/>";
           }
        } else {
           echo "Użytkownik nie zostawił w lesie żadnego wpisu.";
          }
      
        $conn->close();
        $conn = null;
      }
      
      ?>
      
      
      
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
