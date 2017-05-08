<?php

$userId = $tweetDetail->getUserId();
$userName = User::loadUserById($conn, $userId)->getUsername();
echo "<div class=\"tweetbold\">";
echo "ID wpisu: " . $tweetDetail->getId() . "<br/>";
echo "Treść wpisu: " . $tweetDetail->getText() . "<br/>";
echo "ID dzięcioła: " . $tweetDetail->getUserId() . "<br/>";
echo "Nazwa dzięcioła: " . $userName . "<br/>";
echo "Data utworzenia wpisu: " . $tweetDetail->getCreationDate() . "<br/><br/>";
echo "</div><br/>";

$allComments = Comment::loadAllCommentsByTweetId($conn, $_GET['tweetId']);
foreach ($allComments as $comment) {
    $commentUserId = $comment->getUserId();
    $commentUserName = User::loadUserById($conn, $commentUserId)->getUsername();
    echo "<table class='tweet'>";
    echo "<tr><td> ";
    echo "Treść komentarza: " . $comment->getText();
    echo "</td></tr> <tr><td>";
    echo "Autor komentarza: <a href=\"showuser.php?strangerUser=$commentUserId\">" . $commentUserName . "</a> ";
    echo "Data publikacji: " . $comment->getCreationDate();
    echo "</td></tr>";
    echo "</table> <br/>";
}

echo "<br/>";

