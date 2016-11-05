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
            $loadTweet->setText($row['tweet_text']);
            $loadTweet->setCreationDate($row['tweet_date']);
            
            return $loadTweet;
        } else {
            return null;
        }
    }
    

    
    /*     
        

     */
    
    
    
    
    
    
}

?>
