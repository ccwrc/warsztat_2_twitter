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
  
  $message = ""; // wiadomosc informacyjna
  $conn = getDbConnection();
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $userEmail = $_SESSION['user_email'];
      $sql = "SELECT * FROM users WHERE user_email = '$userEmail'";
      $result = $conn->query($sql);
      if ($result->num_rows == 1) {
          foreach($result as $row) {$getHashedPassword = $row['hashed_password'];}
      }
      
      // zmiana nazwy usera
      if (isset($_POST['newusername']) && isset($_POST['oldpassword']) 
         && strlen(trim($_POST['newusername'])) >= 3 && strlen(trim($_POST['newusername'])) <=65
         && password_verify($_POST['oldpassword'], $getHashedPassword)) {
           $newUserName = $_POST['newusername'];
           $newUserName = $conn->real_escape_string($newUserName);
           $newUserName = htmlentities($newUserName, ENT_QUOTES, "UTF-8");
           $userId = $_SESSION['user_id'];        
           $sql = "UPDATE users SET user_name = '$newUserName' WHERE user_id = $userId";
           $result = $conn->query($sql);
           if($result == true) {
               $message = "Nazwa dzięcioła została zmieniona (zmiana będzie widoczna po ponownym zalogowaniu)";
               unset($_POST['newusername']);
               unset($_POST['oldpassword']);
           } else {
               $message = "Błąd połączenia z bazą, zapukaj za kilka minut";
           }
      } else {
          $message = "Podałeś błędne hasło lub nazwa dzięcioła nie trzyma standardu (3-65 znaków)...";
          unset($_POST['newusername']);
      }  // koniec edycji nazwy usera
          
        // zmiana hasła usera
      if (isset($_POST['newpassword1']) && isset($_POST['newpassword2']) && isset($_POST['oldpassword']) 
         && strlen(trim($_POST['newpassword1'])) >= 3 && strlen(trim($_POST['newpassword1'])) <=65
         && ($_POST['newpassword1'] === $_POST['newpassword2'])     
         && password_verify($_POST['oldpassword'], $getHashedPassword)) {
           $newHashedPassword = password_hash($_POST['newpassword1'], PASSWORD_BCRYPT);
           $userId = $_SESSION['user_id'];        
           $sql = "UPDATE users SET hashed_password = '$newHashedPassword' WHERE user_id = $userId";
           $result = $conn->query($sql);
           if($result == true) {
               $message = "Hasło zostało zmienione";
               unset($_POST['newpassword1']);
               unset($_POST['newpassword2']);
               unset($_POST['oldpassword']);
           } else {
               $message = "Błąd połączenia z bazą, zapukaj za kilka minut";
           }
      } else {
          $message = "Podałeś błędne hasło lub długość nie trzyma standardu (3-65 znaków)...";
          unset($_POST['newpassword1']);          
          unset($_POST['newpassword2']);        
      }  // koniec zmiany hasła        
          
          
          
          
          
  }

  $conn->close();
  $conn = null;  
  
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>Dzięcioły - edycja użytkownika </title>
	
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
      <!-- Strona edycji użytkownika - edituser.php
Użytkownik ma mieć możliwość edycji informacji o sobie i zmiany hasła. Pamiętaj o tym,
że użytkownik może edytować tylko i wyłącznie swoje informacje. -->
        <br/>
        <center>
          <p>Wybierz co chcesz zrobić:</p>
        </center>
        <center>
            <a href="edituser.php?changename=true">&nbsp;Zmień nazwę dzięcioła&nbsp;</a>  
        </center> <br/>
        <center>
          <a href="edituser.php?changepassword=true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ustal 
              nowe hasło&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>  
        </center> <br/>
        <center>
          <a class="warning" href="edituser.php?deleteuser=true" size="55">&nbsp;&nbsp;
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Usuń dziuplę&nbsp;&nbsp;
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
        </center> <br/>
        
        <center>
          <p class='warning'><?=$message?></p>
        </center> <br/>
<?php
  //zmiana nazwy
  if (isset($_GET['changename'])) {
      echo "<form method=\"POST\" action=\"edituser.php\">";
      echo "<label> Podaj nową nazwę dzięcioła i hasło: <br/>";
      echo "<input type=\"text\" name=\"newusername\" placeholder=\"Tu wpisz nową nazwę (3-65 znaków)\" size=\"50\"/> <br/>";
      echo "<input type=\"password\" name=\"oldpassword\" placeholder=\"Tu wpisz swoje hasło\" size=\"50\"/> <br/>";
      echo "<input type=\"submit\" value=\"Zatwierdź\"/>";
      echo "</label>";
      echo "</form>";
     
      unset($_GET['changename']);
  }
  
  // zmiana hasla
  if (isset($_GET['changepassword'])) {
      echo "<form method=\"POST\" action=\"edituser.php\">";
      echo "<label> Podaj stare i nowe hasło: <br/>";
      echo "<input type=\"password\" name=\"oldpassword\" placeholder=\"Tu wpisz swoje stare hasło\" size=\"50\"/> <br/>";
      echo "<input type=\"password\" name=\"newpassword1\" placeholder=\"Tu wpisz swoje nowe hasło (3-65 znaków)\" size=\"50\"/> <br/>";
      echo "<input type=\"password\" name=\"newpassword2\" placeholder=\"Dla pewności powtórz nowe hasło\" size=\"50\"/> <br/>";
      echo "<input type=\"submit\" value=\"Zatwierdź\"/>";
      echo "</label>";
      echo "</form>";
      
      unset($_GET['changpassword']);
  }
  
  // usuniecie uzytkownika
  if (isset($_GET['deleteuser'])) {
      echo "<form method=\"POST\" action=\"edituser.php\">";
      echo "<label class=\"warning\"> Usunięcie dziupli jest bezpowrotne! <br/>";
      echo "<input type=\"password\" name=\"deleteuser\" placeholder=\"Dla potwierdzenia podaj hasło\" size=\"50\"/> <br/>";
      echo "<input type=\"submit\" value=\"Usuń dziuplę!\"/>";
      echo "</label>";
      echo "</form>";
      
      unset($_GET['deleteuser']);
  }

?>    
           
      <br/><br/><br/><br/><br/> <!-- 5x br do odsloniecia tresci (przyklejony dolny panel)-->
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
