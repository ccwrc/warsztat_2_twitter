<?php

class Tweet {
    private $id;
    private $userId;
    private $text;
    private $creationDate;
    
    public function __construct() {
        $this->id = -1;
        $this->userId = 0;
        $this->text = "";
        $this->creationDate = "";
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getUserId() {
        return $this->userId;
    }
    
    public function getText() {
        return $this->text;
    }
    
    public function getCreationDate() {
        return $this->creationDate;
    }
    
    public function setUserId($userId) {
        $this->userId = $userId;
    }
    
    public function setText($text) {
        $this->text = $text;
    }
    
    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }
    
    static public function loadTweetById(mysqli $conn, $id) {
        $sql = "SELECT * FROM tweet WHERE tweet_id = $id";
        $result = $conn->query($sql);
        
        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            $loadTweet = new Tweet();
            $loadTweet->id = $row['tweet_id'];
            $loadTweet->userId = $row['tweet_user_id'];
            $loadTweet->text = $row['tweet_text'];
            $loadTweet->creationDate = $row['tweet_date'];
            
            return $loadTweet;
        } else {
            return null;
        }
    }
    
     static public function loadAllTweetByUserId(mysqli $conn, $userid){ //dziala. nie do konca...
        $sql = "SELECT * FROM tweet WHERE tweet_user_id = $userid";
        $ret = [];
        $result = $conn->query($sql);
        
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
    
    static public function loadAllTweets(mysqli $conn) { //do poprawy, nie dziala
        $sql = "SELECT users.user_name, tweet.tweed_id, tweet.tweet_user_id, "
                . "tweet.tweet_text, tweet.tweet_date FROM users JOIN tweet ON users.user_id="
                . "tweet.tweet_user_id ORDER BY tweet_date ASC";
        
        $ret = [];
        
        $result = $conn->query($sql);
        if ($result == true && $result->num_rows > 0) {
            foreach ($result as $row) {
                $loadTweet = new Tweet();
                $loadTweet->id = $row['tweet_id'];
                $loadTweet->userId = $row['user_id'];
                $loadTweet->username = $row['user_name'];
                $loadTweet->text = $row['tweet_text'];
                $loadTweet->creationDate = $row['tweet_date'];
                
                $ret[$loadTweet->id] = $loadTweet;
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


    
    
    
    
    
}

?>
