<?php

  session_start();
  
  if (!isset($_SESSION['logged'])) {
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
  
  if ((!isset($_GET['messageid'])) || (!is_numeric($_GET['messageid']))) {
    header("location: messages.php");
    exit;
  }
  
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>Dzięcioły - detale wiadomości </title>
	
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
      <!-- Stronę wiadomości - messageinfo.php
Wszystkie informacje o wiadomości: nadawca, odbiorca, treść. -->
        <br/>
        <?php
          $conn = getDbConnection();

          if ($_SERVER['REQUEST_METHOD'] == 'GET') {
             // gdy user wchodzi jako odbiorca 
             if (isset($_GET['reciv']) && ($_GET['reciv'] == 'true')) {
                 $messageReceiverId = $_SESSION['user_id'];
                 
                 $showmessage = Message::loadMessageById($conn, $_GET['messageid']);
                 if (($showmessage->getMessageReceiverId()) != $_SESSION['user_id']) {
                     header("location: messages.php");
                     exit;
                 }
                 $messageSenderId = $showmessage->getMessageSenderId();
                 
                 echo "<div class=\"tweet\">"; 
                 echo "<br/>Nadawca: " . User::loadUserById($conn, $messageSenderId)->getUsername() . "<br/>";
                 echo "Odbiorca: " . User::loadUserById($conn, $messageReceiverId)->getUsername() . "<br/>";
                 echo "Data i godzina wysłania wiadomości: " . $showmessage->getMessageCreationdate() . "<br/>";
                 echo "---<br/>";
                 echo "Treść wiadomości: " . $showmessage->getMessageContent() . "<br/><br/>";
                 echo "</div><br/>";
                 
                 $messageIdForHide =$_GET['messageid'];
                 $sql = "UPDATE message SET message_receiver_visible = 1 WHERE message_id = $messageIdForHide";
                 $result = $conn->query($sql);
                 if ($result == true) {
                     echo "<span class=\"warning\">Wiadomość usunięta ze skrzynki odbiorczej, widzisz ją po raz ostatni</span><br/><br/>";
                    // if (($showmessage->getMessageReceiverVisible() == 1) 
                    //     && ($showmessage->getMessageSenderVisible() == 1)) {
                    //     $sql = "DELETE FROM message WHERE message_id = $messageIdForHide";
                    //     $result = $conn->query($sql);
                    //     } błędna logika, zrobić to na trigger w mysql
                 }
             } 
             
             // gdy user wchodzi jako nadawca 
             if (isset($_GET['send']) && ($_GET['send'] == 'true')) {
                 $messageSenderId = $_SESSION['user_id'];
                 
                 $showmessage = Message::loadMessageById($conn, $_GET['messageid']);
                 if (($showmessage->getMessageSenderId()) != $_SESSION['user_id']) {
                     header("location: messages.php");
                     exit;
                 }
                 $messageReceiverId = $showmessage->getMessageReceiverId();
                 
                 echo "<div class=\"tweet\">"; 
                 echo "<br/>Nadawca: " . User::loadUserById($conn, $messageSenderId)->getUsername() . "<br/>";
                 echo "Odbiorca: " . User::loadUserById($conn, $messageReceiverId)->getUsername() . "<br/>";
                 echo "Data i godzina wysłania wiadomości: " . $showmessage->getMessageCreationdate() . "<br/>";
                 echo "---<br/>";
                 echo "Treść wiadomości: " . $showmessage->getMessageContent() . "<br/><br/>";
                 echo "</div><br/>";
                 
                 $messageIdForHide =$_GET['messageid'];
                 $sql = "UPDATE message SET message_sender_visible = 1 WHERE message_id = $messageIdForHide";
                 $result = $conn->query($sql);
                 if ($result == true) {
                     echo "<span class=\"warning\">Wiadomość usunięta ze skrzynki nadawczej, widzisz ją po raz ostatni</span><br/><br/>";
                    // if (($showmessage->getMessageReceiverVisible() == 1) 
                    //     && ($showmessage->getMessageSenderVisible() == 1)) {
                    //     $sql = "DELETE FROM message WHERE message_id = $messageIdForHide";
                    //     $result = $conn->query($sql);
                    //     } błędna logika, zrobić to na trigger w mysql
                 }
             } 
             
             
             
              /* do przemyślenia, do poprawy
             // gdy user wchodzi jako odbiorca z zamiarem usuniecia wiadomosci
             if (isset($_GET['reciv']) && ($_GET['reciv'] == 'true') && isset($_GET['deletemessage'])) {
                 $messageReceiverId = $_SESSION['user_id'];
                 
                 $showmessage = Message::loadMessageById($conn, $_GET['messageid']);
                 if (($showmessage->getMessageReceiverId()) != $_SESSION['user_id']) {
                     header("location: messages.php");
                     exit;
                 }
                 $messageSenderId = $showmessage->getMessageSenderId();
                 
                 echo "<div class=\"tweet\">"; 
                 echo "<br/>Nadawca: " . User::loadUserById($conn, $messageSenderId)->getUsername() . "<br/>";
                 echo "Data i godzina wysłania wiadomości: " . $showmessage->getMessageCreationdate() . "<br/>";
                 echo "---<br/>";
                 echo "Treść wiadomości: " . $showmessage->getMessageContent() . "<br/><br/>";
                 echo "</div><br/>";
                 
                 $messageIdForIsRead =$_GET['messageid'];
                 $sql = "UPDATE message SET message_read = 1 WHERE message_id = $messageIdForIsRead";
                 $result = $conn->query($sql);
                 
                 echo "<span class=\"warning\">Wiadomość usunięta</span>";
             } */
                
          }

          $conn->close();
          $conn = null;
        ?>
      
        <a href="messages.php">Powrót do poprzedniej strony</a>
      
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
