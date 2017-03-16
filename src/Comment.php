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
            $this->userId = $userId;
        } else {
            return false;
        }
    }

    public function setTweetId($tweetId) {
        if (is_numeric($tweetId)) {
            $this->tweetId = $tweetId;
        } else {
            return false;
        }
    }

    public function setText($text) {
        if ((strlen(trim($text)) >= 3) && (strlen(trim($text)) <= 60)) {
            $this->text = htmlentities($text, ENT_QUOTES, "UTF-8");
        } else {
            return false;
        }
    }

    public function setCreationDate($creationDate) {
        if (DateTime::createFromFormat("Y-m-d H:i:s", $creationDate)) {
            $this->creationDate = $creationDate;
        } else {
            return false;
        }
    }

    static public function loadCommentById(mysqli $conn, $commentId) {
        $commentId = $conn->real_escape_string($commentId);
        $sql = "SELECT * FROM comment WHERE comment_id = $commentId";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedComment = new Comment();
            $loadedComment->id = $row['comment_id'];
            $loadedComment->userId = $row['comment_user_id'];
            $loadedComment->tweetId = $row['comment_tweet_id'];
            $loadedComment->creationDate = $row['comment_creation_date'];
            $loadedComment->text = $row['comment_text'];

            return $loadedComment;
        } else {
            return null;
        }
    }

    static public function loadAllCommentsByTweetId(mysqli $conn, $commentTweetId) {
        $commentTweetId = $conn->real_escape_string($commentTweetId);
        $sql = "SELECT * FROM comment WHERE comment_tweet_id = $commentTweetId "
                . "ORDER BY comment_creation_date DESC";
        $ret = [];
        $result = $conn->query($sql);

        if ($result == true && $result->num_rows != 0) {
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
        } else { // ponizsza opcja zbedna, niewykorzystana w aplikacji, ew. mozna wykasowac
            $sql = "UPDATE comment SET comment_user_id = $this->userId, comment_tweet_id = "
                    . "$this->tweetId, comment_creation_date = $this->creationDate, comment_text"
                    . " = '$this->text' WHERE comment_id = $this->id";
            $result = $conn->query($sql);
            if ($result == true) {
                return true;
            }
            return false;
        }
    }

}

?>
