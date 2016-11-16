<?php

  session_start();  //strona dostepna bez zalogowania !
  // koment do captcha: zaznacz ptaszka, potwierdz, ze nie jestes borsukiem
  
  if (isset($_SESSION['logged'])) {
    header("location: index.php");
    exit;
  }
  
  include_once "src/User.php";
  include_once "src/Tweet.php";
  include_once "src/connect.php";
  include_once 'src/Comment.php';
  include_once 'src/arrays.php';
  // ptasi los - link generowany losowo
  $searchMax = count($searchIn);
  $wordMax = count($searchWords);
  $randSearch = rand(1, $searchMax) - 1;
  $randWord = rand(1, $wordMax) - 1;
  $linkSearch = $searchIn[$randSearch];
  $linkWord = $searchWords[$randWord];
  
  $message = ""; //wiadomosc podawana przy zajetym adresie mailowym i bledach hasla

  $conn = getDbConnection();

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['username']) && trim($_POST['username']) != ''
         && isset($_POST['useremail']) && trim($_POST['useremail']) != ''
         && isset($_POST['userpassword1']) && trim($_POST['userpassword1']) != ''
         && isset($_POST['userpassword2']) && trim($_POST['userpassword2']) != '') {
           if (trim($_POST['userpassword1']) == trim($_POST['userpassword2'])) {
               $userEmail = strtolower(trim($_POST['useremail']));
               $userPassword = trim($_POST['userpassword1']);
               $userName = trim($_POST['username']);
               $userName = htmlentities($userName, ENT_QUOTES, "UTF-8");
               
               $userEmail = $conn->real_escape_string($userEmail);
               $userPassword = $conn->real_escape_string($userPassword);
               $userName = $conn->real_escape_string($userName);
               
               $sql = "SELECT * FROM users WHERE user_email = '$userEmail'";
               $result = $conn->query($sql);
               
               if ($result->num_rows > 0) {
                   $message = "Podany adres e-mail ma już dziuplę, wybierz inny";
               } else {
                   $user = new User();
                   $user->setEmail($userEmail);
                   $user->setHashedPassword($userPassword);
                   $user->setUsername($userName);
                   $user->saveToDB($conn);
                     if ($user->saveToDB($conn) == true) {
                         $_SESSION['logged'] = $userName;
                         $_SESSION['user_email'] = $userEmail;
                         
                         $sql = "SELECT * FROM users WHERE user_email = '$userEmail'";
                         $result = $conn->query($sql);
                         foreach($result as $row) {
                             $userId = $row['user_id'];
                         }
                         $_SESSION['user_id'] = $userId;
                         
                         header("location: index.php");
                     } else {
                         $message = "Błąd połączenia z bazą, spróbuj za kilka minut";
                       }
                 }
               
           } else {
               $message = "Hasła nie są identyczne, trzeba się zdecydować, którego używać";
             }
        } else {
          $message = "Wypełnij wszystkie pola, nie rób byle jakiej dziupli.";
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
	
	<title>Dzięcioły - stwórz własną dziuplę w lesie </title>
	
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
      <!-- (dostepna bez zalogowania) Strona tworzenia użytkownika - create.php
Strona ma pobierać email i hasło.
Jeżeli takiego emaila nie ma jeszcze w systemie, to dodać go i zalogować (przekierować na stronę 
  główną).
Jeżeli taki email jest, to przekierować znowu do strony tworzenia użytkownika i wyświetlić
komunikat o zajętym adresie email. -->
        <br /> <center>
        <h4 class="warning"><?=$message?></h4>
        </center>  
        
        <form method="POST" action="">
            <label> Aby mieć dziuplę w lesie wypełnij wszystkie pola: <br/><br/>
              <input type="text" name="username" placeholder="Podaj nazwę dzięcioła" size="50"
                pattern=".{3,65}"   required title="Minimalna liczba znaków to 3, maksymalna 65"/>  <br/> 
              <input type="email" name="useremail" placeholder="Tu wpisz e-mail" size="50"
                pattern=".{5,250}"   required title="Minimalna liczba znaków to 5, maksymalna 250"/>  <br/>
              <input type="password" name="userpassword1" placeholder="I ustal hasło" size="50"
                pattern=".{3,65}"   required title="Minimalna liczba znaków to 3, maksymalna 65"/> <br/>
              <input type="password" name="userpassword2" placeholder="Dla pewności wpisz hasło ponownie" size="50"
                pattern=".{3,65}"   required title="Minimalna liczba znaków to 3, maksymalna 65"/> <br/><br/>
              <input type="submit" value=" Kliknij tutaj żeby stworzyć własną dziuplę "/>
            </label>    
        </form>
         
      
<?php

// captcha np. z google



?>
      
      
      <br/><br/><br/><br/><br/> <!-- 5x br do odsloniecia tresci (przyklejony dolny panel)-->
      </div>


      <div class ="footer">
                  <br/><br/>
                  <a href="<?=$linkSearch?><?=$linkWord?>" target="_blank">Ptasi los</a>
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
