<?php

  session_start();
  
  if (!isset($_SESSION['logged']) || !isset($_SESSION['user_id'])) {
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
        <p><strong>Wszystkie twoje odebrane wiadomości: </strong></p>
        
        <?php
        $conn = getDbConnection();
        $messageIn = Message::loadAllCutMessagesByReceiverId($conn, $_SESSION['user_id']);
        
        foreach ($messageIn as $cutMessage) {
            echo "<div class=\"tweet\">"; 
            if ($cutMessage->getMessageRead() == 0) {
                echo "<span class=\"warning\">NOWA </span>";
            }
            $senderId = $cutMessage->getMessageSenderId();
            echo "Nadawca: <a href=\"showuser.php?strangeuser=$senderId\">" . User::loadUserById($conn, $cutMessage->getMessageSenderId())->getUsername() . "</a>";
            echo "<br/> Data: " . $cutMessage->getMessageCreationdate() . " <br/>";
            echo "Nagłówek wiadomości: " . $cutMessage->getMessageContent() . "<br/>";
            $messageIdForGet = $cutMessage->getMessageId();
            echo "<a href=\"messageinfo.php?messageid=$messageIdForGet&reciv=true\">Przeczytaj całość</a> ";
        //    echo "<a href=\"messageinfo.php?messageid=$messageIdForGet&recive=true&deletemessage=true\">Usuń wiadomość</a> ";
            echo " <a href=\"showuser.php?strangeuser=$senderId\">Odpowiedz</a>";
            echo " <a href=\"messagedelete.php?messageid=$messageIdForGet&reciv=true\">USUŃ</a> ";
            echo "</div><br/>";
        }
        
        $conn->close();
        $conn = null;
        ?>
        
        <p><strong>Wszystkie twoje wysłane wiadomości: </strong></p>
        
        <?php
        $conn = getDbConnection();
        $messageOut = Message::loadAllCutMessagesBySenderId($conn, $_SESSION['user_id']);
        
        foreach ($messageOut as $cutMessage) {
            echo "<div class=\"tweet\">"; 
            $receiverId = $cutMessage->getMessageReceiverId();
            echo "Odbiorca: <a href=\"showuser.php?strangeuser=$receiverId\">" . User::loadUserById($conn, $cutMessage->getMessageReceiverId())->getUsername() . "</a>";
            if ($cutMessage->getMessageRead() == 0) {
                echo "<span class=\"warning\"> (jeszcze nieprzeczytana) </span>";
            }
            echo "<br/> Data: " . $cutMessage->getMessageCreationdate() . " <br/>";
            echo "Nagłówek wiadomości: " . $cutMessage->getMessageContent() . "<br/>";
            $messageIdForGet = $cutMessage->getMessageId();
            echo "<a href=\"messageinfo.php?messageid=$messageIdForGet&send=true\">Przeczytaj całość</a> ";       
       //     echo " <a href=\"messageinfo.php?messageid=$messageIdForGet&send=true&deletemessage=true\">Usuń wiadomość</a> ";
            echo " <a href=\"showuser.php?strangeuser=$receiverId\">Wyślij kolejną</a>";
            echo " <a href=\"messagedelete.php?messageid=$messageIdForGet&send=true\">USUŃ</a> ";
            echo "</div><br/>";
        }
        
        $conn->close();
        $conn = null;
        ?>
      
      
      <br/><br/><br/><br/><br/> <!-- 5x br do odsloniecia tresci (przyklejony dolny panel)-->
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
