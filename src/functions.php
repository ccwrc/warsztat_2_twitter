<?php

require_once 'Comment.php';

//TODO funkcja tragicznie nieefektywna, do poxniejszej poprawy na count sql
function countComments(mysqli $conn, $tweetId) {
    $commentsCount = 0;
    $comments = Comment::loadAllCommentsByTweetId($conn, $tweetId);
    foreach ($comments as $comment) {
        $commentsCount++;
    }
    return $commentsCount;
}
