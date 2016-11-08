<?php

  session_start(); //Strona glowna wyświetlająca wszystkie Tweety
  
//  var_dump($_SESSION['logged']); - kosmetyka (komunikat) i check
//  var_dump($_SESSION['user_email']); - moze sie przyda
//  var_dump($_SESSION['user_id']); - do identyfikacji tweeta itd.  

  if (!isset($_SESSION['logged'])) {
    header("location: logon.php");
    exit;
  }
  
  include_once "src/User.php";
  include_once "src/Tweet.php";
  include_once "src/connect.php";

  $actualDate = date("Y-m-d H:i:s");
  $conn = getDbConnection();
  
  // dodawanie nowego'tweeta' name="newtweet"
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])
      && isset($_POST['newtweet']) && trim($_POST['newtweet']) != '') {
        $userId = $_SESSION['user_id'];
        $userTweet = trim($_POST['newtweet']);
        $userTweet = $conn->real_escape_string($userTweet);
        
        $newTweet = new Tweet();
        $newTweet->setUserId($userId);
        $newTweet->setText($userTweet);
        $newTweet->setCreationDate($actualDate); 
        $newTweet->saveToDb($conn);
        unset($_POST['newtweet']);
  }

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
            <div class="logged"> <?=$_SESSION['logged']?> jest w dziupli. </div>
	  </div>


      <div class="content">
      <!-- strona główna - index.php
      Strona wyświetlająca wszystkie Tweety jakie znajdują się w systemie (od najnowszego do
      najstarszego). Nad nimi ma być widoczny formularz do stworzenia nowego wpisu. -->
      <br />
      <center>
        <form method="POST" action="#">
      <?=$_SESSION['logged']?>, masz wiadomość z lasu? Wpisz ją poniżej i nie przekrocz 140 znaków, bo las zapłonie.<br/>
        <input type="text" size="100" name="newtweet"
          pattern=".{3,140}" required title="Minimalna liczba znaków to 3, maksymalna 140"> <br/>
        <input type="submit" value="Opublikuj !">
      </form>
      </center> <br/>
<?php

$conn = getDbConnection();

$allTweets = Tweet::loadAllTweets($conn);

foreach ($allTweets as $tweet) {
    $userId = $tweet->getUserId();
    $tweetId = $tweet->getId();
    
    echo "<table class='tweet'>";
    echo "<tr><td> ";
    echo "Autor: <a href=\"showuser.php?strangeuser=$userId\">" .User::loadUserById($conn, $userId)->getUsername(). "</a> ";
    echo "Data publikacji: " . $tweet->getCreationDate();
    echo "</td></tr> <tr><td>";
    echo $tweet->getText();
    echo "</td></tr>";
    echo "</table> <br/>";
}
  
    /* wersja testowa
    $sql = "SELECT * FROM tweet ORDER BY tweet_date DESC"; 
    $result = $conn->query($sql);
    
   foreach ($result as $row) { //tabela do zmiany, do całkowitej przebudowy
    echo "<table class='tweet'>";   
    echo "<tr><td>";
    echo ("Tweet ID: " . $row['tweet_id']." * ");
    echo ("Data publikacji: " . $row['tweet_date'] . "<br>");
    echo "</td></tr><tr><td>";
    echo ("Tweet: " . $row['tweet_text'] . "<br>"); 
    echo "</td></tr>";
    echo "</table> <br/>";
   } */

    $conn->close();
    $conn = null; 
?>
      <br/><br/><br/><br/><br/> <!-- beerki do odsloniecia ostatniego tweeta (przyklejony dolny panel) -->
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
