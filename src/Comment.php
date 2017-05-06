<?php

class Comment {
    private $id;
    private $userId;
    private $tweetId;
    private $text;
    private $creationDate;

    public function __construct() {
        $this->id = -1;
        $this->userId = 0;
        $this->tweetId = 0;
        $this->text = "";
        $this->creationDate = "";
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getTweetId() {
        return $this->tweetId;
    }

    public function getText() {
        return $this->text;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function setUserId($userId) {
        if (is_numeric($userId)) {
            $this->userId = (int)$userId;
            return $this;
        } 
        return false;
    }

    public function setTweetId($tweetId) {
        if (is_numeric($tweetId)) {
            $this->tweetId = (int)$tweetId;
            return $this;
        } 
        return false;
    }

    public function setText($text) {
        if ((strlen(trim($text)) >= 3) && (strlen(trim($text)) <= 60)) {
            $this->text = htmlentities(trim($text), ENT_QUOTES, "UTF-8");
            return $this;
        } 
        return false;
    }

    public function setCreationDate($creationDate) {
        if (DateTime::createFromFormat("Y-m-d H:i:s", $creationDate)) {
            $this->creationDate = $creationDate;
            return $this;
        }
        return false;
    }
    
    public static function loadCommentById(mysqli $conn, $commentId) {
        $statement = $conn->prepare("SELECT * FROM comment WHERE comment_id = ?");
        $statement->bind_param('i', $commentId);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $loadedComment = new Comment();
            $loadedComment->id = $row['comment_id'];
            $loadedComment->userId = $row['comment_user_id'];
            $loadedComment->tweetId = $row['comment_tweet_id'];
            $loadedComment->creationDate = $row['comment_creation_date'];
            $loadedComment->text = $row['comment_text'];
            $statement->close();
            return $loadedComment;
        }
        $statement->close();
    }
    
    public static function loadAllCommentsByTweetId(mysqli $conn, $tweetId) {
        $statement = $conn->prepare("SELECT * FROM comment WHERE comment_tweet_id = ? "
                . "ORDER BY comment_creation_date DESC");
        $statement->bind_param('i', $tweetId);
        $ret = [];

        if ($statement->execute()) {
            $result = $statement->get_result();
            $result->fetch_assoc();
            foreach ($result as $row) {
                $loadedComment = new Comment();
                $loadedComment->id = $row['comment_id'];
                $loadedComment->userId = $row['comment_user_id'];
                $loadedComment->tweetId = $row['comment_tweet_id'];
                $loadedComment->creationDate = $row['comment_creation_date'];
                $loadedComment->text = $row['comment_text'];
                $ret[] = $loadedComment;
            }
        }
        $statement->close();
        return $ret;
    }
    
    public static function countAllCommentsByTweetId(mysqli $conn, $tweetId) {
        $statement = $conn->prepare("SELECT COUNT(comment_tweet_id) AS count_comments "
                . "FROM comment WHERE comment_tweet_id = ?");
        $statement->bind_param('i', $tweetId);
        $statement->execute();
        $result = $statement->get_result();
        $ret = 0;

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $ret = $row['count_comments'];
        }
        return $ret;
    }

    public function saveToDb(mysqli $conn) {
        if ($this->id == -1) {
            $statement = $conn->prepare("INSERT INTO comment (comment_user_id, comment_tweet_id,"
                    . " comment_creation_date, comment_text) VALUES (?,?,?,?)");
            $statement->bind_param("iiss", $this->userId, $this->tweetId, $this->creationDate, $this->text);
            if ($statement->execute()) {
                $this->id = $statement->insert_id;
                return true;
            }
        }
        return false;
    }

}


