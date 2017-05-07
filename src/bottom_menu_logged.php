<?php
include_once 'arrays_to_rand.php';
require_once 'Message.php';
require_once 'connect.php';

// ptasi los - link generowany losowo
$searchMax = count($searchIn);
$wordMax = count($searchWords);
$randSearch = rand(1, $searchMax) - 1;
$randWord = rand(1, $wordMax) - 1;
$linkSearch = $searchIn[$randSearch];
$linkWord = $searchWords[$randWord];

// zwykły licznik nieprzeczytanych wiadomosci
$conn = getDbConnection();
$unreadMessagesCount = "";
$loggedLoadedUser = User::loadUserById($conn, $_SESSION['user_id']);

if ($loggedLoadedUser->countNewMessages($conn) > 0) {
    $unreadMessagesCount = " [" . $loggedLoadedUser->countNewMessages($conn) . "]";
}
$conn->close();
$conn = null;
?>

<div class ="footer">
    <br/><br/>          <!-- ptasi los - link generowany losowo -->
    <a href="<?= $linkSearch ?><?= $linkWord ?>" target="_blank">Ptasi los</a>
<!--    <a href="http://www.lesnepogotowie.pl/" target="_blank">Leśne pogotowie</a>-->
    <a href="searchuser.php">Wyszukaj</a> 
    <a href="index.php">Dzięcioły</a> 
    <a id="footerlink2" href="logon.php">Logowanie</a> 
    <a id="footerlink3" href="create.php">Stwórz dziuplę</a> 
    <a href="showuser.php">Pokaż dzięcioła</a> 
    <a href="edituser.php">Edycja dziupli</a> 
    <a href="messages.php">Wiadomości<?= $unreadMessagesCount ?></a> 
    <a href="logoff.php">Wyloguj</a> 
</div>   
