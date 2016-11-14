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

    static public function loadCommentById(mysqli $conn, $id) {
        $id = $conn->real_escape_string($id);
        $sql = "SELECT * FROM comment WHERE comment_id = $id";
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
    
    static public function loadAllCommentsByTweetId(mysqli $conn, $tweetId) {
        $tweetId = $conn->real_escape_string($tweetId);
        $sql = "SELECT * FROM comment WHERE comment_tweet_id = $tweetId";
        $ret = [];
        $result = $conn->query($sql);
        
        if($result == true && $result->num_rows != 0) {
            //
        }
    }

    /*      

        
        if($result == true && $result->num_rows != 0){
           foreach($result as $row){
           $loadTweet = new Tweet();
           $loadTweet->id = $row['tweet_id'];
           $loadTweet->userId = $row['tweet_user_id'];
           $loadTweet->text = $row['tweet_text'];
           $loadTweet->creationDate = $row['tweet_date'];
           $ret[$loadTweet->id] = $loadTweet;
           }
         }
           return $ret; 
    }
    
    static public function loadAllTweets(mysqli $conn) { // dziala. pierd. 4 dni nad literowka
        $sql = "SELECT * FROM tweet ORDER BY tweet_date DESC";
        $result = $conn->query($sql);
        $ret = [];
        
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadTweet = new Tweet();
                $loadTweet->tweetId = $row['tweet_id'];
                $loadTweet->userId = $row['tweet_user_id'];
                $loadTweet->text = $row['tweet_text'];
                $loadTweet->creationDate = $row['tweet_date'];
                
                $ret[$loadTweet->tweetId] = $loadTweet;
            }
        }
        return $ret;
    }
    
    public function saveToDb(mysqli $conn) {
        if ($this->id == -1) {
            $sql = "INSERT INTO tweet (tweet_user_id, tweet_text, tweet_date) VALUES "
                    . "('$this->userId', '$this->text', '$this->creationDate')";
            $result = $conn->query($sql);
            if ($result == true) {
                $this->id = $conn->insert_id;
                return true;
            } else {
                $sql = "UPDATE tweet SET tweet_user_id = $this->userId, "
                        . "tweet_text = '$this->text', tweet_date = '$this->creationDate'"
                        . "WHERE tweet_id = $this->id";
                $result = $conn->query($sql);
                if ($result) {
                    return true;
                }
            }
            return false;
        }
    }


    
    
    
  */  
    
}

?>
