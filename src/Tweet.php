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
        if (is_numeric($userId)) {
            $this->userId = $userId;
            return $this;
        } else {
            return false;
        }
    }

    public function setText($text) {
        if ((strlen(trim($text)) >= 3) && (strlen(trim($text)) <= 140)) {
            $this->text = htmlentities($text, ENT_QUOTES, "UTF-8");
            return $this;
        } else {
            return false;
        }
    }

    public function setCreationDate($creationDate) {
        if (DateTime::createFromFormat("Y-m-d H:i:s", $creationDate)) {
            $this->creationDate = $creationDate;
            return $this;
        } else {
            return false;
        }
    }
    
    public static function loadTweetById(mysqli $conn, $id) {
        $statament = $conn->prepare("SELECT * FROM tweet WHERE tweet_id=?");
        $statament->bind_param('i', $id);
        if ($statament->execute()) {
            $result = $statament->get_result();
            $row = $result->fetch_assoc();
            $loadTweet = new Tweet();
            $loadTweet->id = $row['tweet_id'];
            $loadTweet->userId = $row['tweet_user_id'];
            $loadTweet->text = $row['tweet_text'];
            $loadTweet->creationDate = $row['tweet_date'];
            return $loadTweet;
        }
    }

    // ponizsza funkcja jeszcze niewykorzystana
    static public function loadAllTweetByUserId(mysqli $conn, $userId) {
        $userId = $conn->real_escape_string($userId);
        $sql = "SELECT * FROM tweet WHERE tweet_user_id = $userId";
        $ret = [];
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            foreach ($result as $row) {
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

    static public function loadAllTweetsLimit300(mysqli $conn) {
        $sql = "SELECT * FROM tweet ORDER BY tweet_date DESC LIMIT 300";
        $result = $conn->query($sql);
        $ret = [];

        if ($result->num_rows > 0) {
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
            $statement = $conn->prepare("INSERT INTO tweet (tweet_user_id, tweet_text, "
                    . "tweet_date) VALUES (?,?,?)");
            $statement->bind_param("iss", $this->userId, $this->text, $this->creationDate);
            if ($statement->execute()) {
                $this->id = $statement->insert_id;
                return true;
            }
        }
        return false;
    }

}

