<?php

require_once 'Comment.php';

function countComments(mysqli $conn, $tweetId) {
    $commentsCount = 0;
    $comments = Comment::loadAllCommentsByTweetId($conn, $tweetId);
    foreach ($comments as $comment) {
        $commentsCount++;
    }
    return $commentsCount;
}
