<?php
include_once 'arrays_to_rand.php';

// ptasi los - link generowany losowo
$randomSearch = $searchIn[rand(1, count($searchIn)) - 1];
$randomWord = $searchWords[rand(1, count($searchWords)) - 1];

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
    <a href="<?= $randomSearch ?><?= $randomWord ?>" target="_blank">Ptasi los</a>
    <a href="searchuser.php">Wyszukaj</a> 
    <a href="index.php">Dzięcioły</a> 
    <a id="footerlink2" href="logon.php">Logowanie</a> 
    <a id="footerlink3" href="create.php">Stwórz dziuplę</a> 
    <a href="showuser.php">Pokaż dzięcioła</a> 
    <a href="edituser.php">Edycja dziupli</a> 
    <a href="messages.php">Wiadomości<?= $unreadMessagesCount ?></a> 
    <a href="logoff.php">Wyloguj</a> 
</div>   
