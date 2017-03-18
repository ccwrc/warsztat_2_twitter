<?php

require_once 'Comment.php';

//funkcja zbedna, nieefektywna i nieuzywana, zastapiona funkcja countAllCommentsByTweetId
// w encji Comment
//function countComments(mysqli $conn, $tweetId) {
//    $commentsCount = 0;
//    $comments = Comment::loadAllCommentsByTweetId($conn, $tweetId);
//    foreach ($comments as $comment) {
//        $commentsCount++;
//    }
//    return $commentsCount;
//}
