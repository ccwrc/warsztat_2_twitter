<?php

  session_start(); //Strona glowna wyświetlająca wszystkie Tweety
  /* wykasowac koment po zrobieniu logowania
  if (!isset($_SESSION['logged'])) {
    header("location: logon.php");
    exit;
  } */
  
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
	  
	  <div class="logo">
            <img class="logoimage" id="logoimage" src="img/logo.jpg">  
	  </div>


      <div class="content">
      <!-- strona główna - index.php
      Strona wyświetlająca wszystkie Tweety jakie znajdują się w systemie (od najnowszego do
      najstarszego). Nad nimi ma być widoczny formularz do stworzenia nowego wpisu. -->
      <br />
      <center>
        <form method="POST" action="#">
      <?=$_SESSION['logged']?>, masz wiadomość z lasu? Wpisz ją poniżej i nie przekrocz 140 znaków, bo las zapłonie.<br>
        <input type="text" maxlength="140" size="100" name="newtweet"> <br />
        <input type="submit" value="Opublikuj !">
      </form>
      </center> <br/>
<?php
// wersja testowa, do poprawy i w tabele
    $conn = getDbConnection();
    
    $sql = "SELECT * FROM tweet ORDER BY tweet_date DESC LIMIT 60"; // dodalem limit zeby to jakos wygladalo
    $result = $conn->query($sql);
    
   foreach ($result as $row) {
    echo ("Tweet ID: " . $row['tweet_id']." * ");
    echo ("Data publikacji: " . $row['tweet_date'] . "<br>");
    echo ("Tweet: " . $row['tweet_text'] . "<br><br>"); 
   }

  
    $conn->close();
    $conn = null; 
?>
      
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
