<?php
include_once 'arrays_to_rand.php';

// ptasi los - link generowany losowo
$randomSearch = $searchIn[rand(1, count($searchIn)) - 1];
$randomWord = $searchWords[rand(1, count($searchWords)) - 1];
?>

<div class ="footer">
    <br/><br/>                      <!-- ptasi los - link generowany losowo -->
    <a href="<?= $randomSearch ?><?= $randomWord ?>" target="_blank">Ptasi los</a>
    <a href="http://www.lesnepogotowie.pl/" target="_blank">Leśne pogotowie</a>
    <a id="footerlink2" href="index.php">Dzięcioły</a> 
    <a href="logon.php">Logowanie</a> 
    <a href="create.php">Stwórz dziuplę</a> 
    <a id="footerlink5" href="showuser.php">Pokaż dzięcioła</a> 
    <a id="footerlink6" href="edituser.php">Edycja dziupli</a> 
    <a id="footerlink7" href="messages.php">Wiadomości</a> 
    <a id="footerlink8" href="logoff.php">Wyloguj</a> 
</div> 