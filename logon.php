<?php

  session_start();   // strona dostepna bez zalogowania !
  
  if (isset($_SESSION['logged'])) {
    header("location: index.php");
    exit;
  }
  
  include_once "src/User.php";
  include_once "src/Tweet.php";
  include_once "src/connect.php";
  include_once 'src/Comment.php';
  include_once 'src/arrays.php';
  
  $message = ""; //wiadomosc podawana po blednej probie zalogowania
  
  $conn = getDbConnection();
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') { //pisane w transie i dziala 
      if (isset($_POST['useremail']) && isset($_POST['userpassword'])
         && trim($_POST['useremail']) != '' && trim($_POST['userpassword']) != '') {
     
         $userEmail = strtolower(trim($_POST['useremail'])); // na wyrost, dodatkowe zabez. jest w form.
         $userPassword = trim($_POST['userpassword']); //ktore to zabezp. nie dziala przy spacjach :)
         $userEmail = $conn->real_escape_string($userEmail);
         $userPassword = $conn->real_escape_string($userPassword);
         
         $sql = "SELECT * FROM users WHERE user_email = '$userEmail'";
         $result = $conn->query($sql);
         
         if ($result->num_rows == 1) {
             foreach($result as $row) {
                 $getUserId = $row['user_id'];
                 $getHashedPassword = $row['hashed_password'];
                 $getUserEmail = $row['user_email'];
                 $getName = $row['user_name'];
             }
             if (password_verify($userPassword, $getHashedPassword)) {
                 $_SESSION['logged'] = $getName;
                 $_SESSION['user_id'] = $getUserId; 
                 $_SESSION['user_email'] = $getUserEmail;
                 header("location: index.php");
             } else {
                $message = "Błędny e-mail lub hasło, wprowadź ponownie:";
             }
         } else {
             $message = "Adres mailowy nie ma własnej dziupli";
         }
          
      } else {
          $message = "Błędny e-mail lub hasło, wprowadź ponownie:";
        }
  }

  $conn->close();
  $conn = null;
  
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>Dzięcioły - zaloguj </title>
	
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
	  </div>


      <div class="content">
      <!-- (dostępna bez zalogowania) strona logowania - logon.php
Strona ma przyjmować email użytkownika i jego hasło.
Jeżeli są poprawne, to użytkownik jest przekierowany do strony głównej, jeżeli nie –
do strony logowania, która ma wtedy wyświetlić komunikat o błędnym loginie lub haśle.
Strona logowania ma mieć też link do strony tworzenia użytkownika. -->
        <br /> <center>
        <h4 class="warning"><?=$message?></h4>
        </center>    
      
        <br />
        <center>
        <form method='POST' action=''>
            <label> <center>Podaj dane dostępu do dziupli: <br/><br/></center>
            <input type="email" name="useremail" placeholder="Podaj e-mail"
              pattern=".{5,250}"   required title="Minimalna liczba znaków to 5, maksymalna 250"/>  
            <input type="password" name="userpassword" placeholder="I wpisz hasło"
              pattern=".{3,65}"   required title="Minimalna liczba znaków to 3, maksymalna 65"/>
            <input type="submit" value="Wejdź do dziupli"/>
            </label>
        </form>
        </center>
        
        <br />
        <center>
            <h4><a href="create.php">Nie masz własnej dziupli w lesie? Kliknij tutaj żeby ją stworzyć.</a></h4>
        </center>    
        
      </div>


      <div class ="footer">
                  <br/><br/>
                  <a href="http://www.lesnepogotowie.pl/" target="_blank">Leśne pogotowie</a>
		  <a id="footerlink2" href="index.php">Dzięcioły</a> 
		  <a href="logon.php">Logowanie</a> 
		  <a href="create.php">Stwórz dziuplę</a> 
		  <a id="footerlink5" href="showuser.php">Pokaż dzięcioła</a> 
		  <a id="footerlink6" href="edituser.php">Edycja dziupli</a> 
		  <a id="footerlink7" href="messages.php">Wiadomości</a> 
		  <a id="footerlink8" href="logoff.php">Wyloguj</a> 
      </div>      
          
  </div>
</body>
</html>
