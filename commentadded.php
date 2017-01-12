<?php

  session_start();

  if (!isset($_SESSION['logged']) || !isset($_SESSION['actualTweetId']) 
      || !isset($_POST['newtweetcomment'])) {
    header("location: logon.php");
    exit;
  } 
  
  include_once "src/User.php";
  include_once "src/Tweet.php";
  include_once "src/connect.php";
  include_once 'src/Comment.php';
  include_once 'src/arrays.php';
  include_once 'src/Message.php';
  // ptasi los - link generowany losowo
  $searchMax = count($searchIn);
  $wordMax = count($searchWords);
  $randSearch = rand(1, $searchMax) - 1;
  $randWord = rand(1, $wordMax) - 1;
  $linkSearch = $searchIn[$randSearch];
  $linkWord = $searchWords[$randWord];
  
  $actualDate = date("Y-m-d H:i:s");
  $message = "";
  
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>Dzięcioły - dodawanie komentarza </title>
	
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
      <!-- Strona potwierdzenia dodania komentarza - commentadded.php -->
      
        <br/><br/>
      

     
    <?php  
    
    $conn = getDbConnection();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $commentText = $conn->real_escape_string(trim($_POST['newtweetcomment']));
        $commentText = htmlentities($commentText, ENT_QUOTES, "UTF-8");
        // dopisac warunek trim 3-60 znakow (przed 2018 w miare mozliwości)
        $newComment = new Comment();
        $newComment->setUserId($_SESSION['user_id']);
        $newComment->setTweetId($_SESSION['actualTweetId']);
        $newComment->setCreationDate($actualDate);
        $newComment->setText($commentText);
        $newComment->saveToDb($conn);
        
        $message = "Komentarz dodany!";
        unset($_SESSION['actualTweetId']);
        
    } else {
        $message = "Dodanie komentarza nie było możliwe.";
        unset($_SESSION['actualTweetId']);
    }
      
     $conn->close();
     $conn = null;
     
     echo "<br/>";
     echo "&nbsp;"."<a href='index.php'>Powrót do strony głównej</a>"; 
     echo "<br/><br/>";
    
    ?>
        
        <br /> <center>
        <h4 class="warning"><?=$message?></h4>
        </center>  
      
      </div>

      <div class ="footer">
                  <br/><br/>
                  <a href="<?=$linkSearch?><?=$linkWord?>" target="_blank">Ptasi los</a>
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
