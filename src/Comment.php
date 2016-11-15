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
            return FALSE;
        }
    }
    
    public function setTweetId($tweetId) {
        if (is_numeric($tweetId)) {
            $this->tweetId = $tweetId;
        } else {
            return FALSE;
        }
    }
    
    public function setText($text) {
        if ((strlen(trim($text)) >= 3) && (strlen(trim($text)) <= 60)) {
            $this->text = trim($text);
        } else {
            return FALSE;
        }
    }
    
    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    static public function loadCommentById(mysqli $conn, $idc) {
        $idc = $conn->real_escape_string($idc);
        $sql = "SELECT * FROM comment WHERE comment_id = $idc";
        $result = $conn->query($sql);
        
        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            $loadedComment = new Comment();
            $loadedComment->id = $row['comment_id'];
            $loadedComment->userId = $row['comment_user_id'];
            $loadedComment->tweetId = $row['comment_tweet_id'];
            $loadedComment->creationDate = $row['comment_creation_date'];
            $loadedComment->text = $row['comment_text'];
            
            return $loadedComment;
        } else {
            return NULL;
        }
    }
    
    static public function loadAllCommentsByTweetId(mysqli $conn, $ctweetId) {
        $ctweetId = $conn->real_escape_string($ctweetId);
        $sql = "SELECT * FROM comment WHERE comment_tweet_id = $ctweetId";
        $ret = [];
        $result = $conn->query($sql);
        
        if($result == true && $result->num_rows != 0) {
            foreach($result as $row) {
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
            $sql = "INSERT INTO comment (comment_user_id, comment_tweet_id, comment_creation_date, comment_text) VALUES ('$this->userId', '$this->tweetId', '$this->creationDate', '$this->text')";
            $result = $conn->query($sql);
            if ($result == true) {
                $this->id = $conn->insert_id;
                return true;
            }
        } else {
            $sql = "UPDATE comment SET comment_user_id = $this->userId, "
                    . "comment_tweet_id = $this->tweetId, "
                    . "comment_creation_date = $this->creationDate, "
                    . "comment_text = '$this->text' WHERE comment_id = $this->id";
            $result = $conn->query($sql);
            if ($result == true) {
                return true;
            }
            return false;
        }
    }
 
    
}

?>
