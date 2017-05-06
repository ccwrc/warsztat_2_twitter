<?php

require_once __DIR__ . '/../src/Tweet.php';

class TweetTest extends PHPUnit_Extensions_Database_TestCase {
    protected static $myConn;
    protected static $emptyTweet;

    public function getConnection() {
        $conn = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
        $conn->query("SET GLOBAL FOREIGN_KEY_CHECKS=0");
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    }

    public function getDataSet() {
        return $this->createFlatXmlDataSet(__DIR__ . '/../datasets/tweet.xml');
    }

    public static function setUpBeforeClass() {
        self::$myConn = new mysqli(
                $GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_NAME']
        );
        self::$emptyTweet = new Tweet();
    }

    public function testConstruct() {
        $tweet = new Tweet();
        $this->assertInstanceOf("Tweet", $tweet);
    }
    
    public function testGetId() {
        $this->assertEquals(-1, self::$emptyTweet->getId());
    }
    
    public function testGetUserId() {
        $this->assertEquals(0, self::$emptyTweet->getUserId());
    }   
    
    public function testGetText() {
        $this->assertEquals("", self::$emptyTweet->getText());
    }       
    
    public function testGetCreationDate() {
        $this->assertEquals("", self::$emptyTweet->getCreationDate());
    }   

    public function testSetUserId() {
        self::$emptyTweet->setUserId(1);
        $this->assertEquals(1, self::$emptyTweet->getUserId());
        $this->assertFalse(self::$emptyTweet->setUserId("q"));
    }
    
    public function testSetText() {
        self::$emptyTweet->setText("      new");
        $this->assertEquals("new", self::$emptyTweet->getText());
        $this->assertFalse(self::$emptyTweet->setText("q"));
    }
    
    public function testSetCreationDate() {
        self::$emptyTweet->setCreationDate("2011-01-02 2:01:33");
        $this->assertEquals("2011-01-02 2:01:33", self::$emptyTweet->getCreationDate());
        $this->assertFalse(self::$emptyTweet->setCreationDate("2011-01-0 2:1:33"));
    }    
    
    public function testLoadTweetById() {
        $tweet = Tweet::loadTweetById(self::$myConn, 1);
        $this->assertInstanceOf("Tweet", $tweet);
        $this->assertEquals("tweet 1 text tweet", $tweet->getText());
    }
    
    public function testLoadAllTweetsByUserId() {
        $tweets = Tweet::loadAllTweetsByUserId(self::$myConn, 4);
        $this->assertInternalType("array", $tweets);
        $this->assertInstanceOf("Tweet", $tweets[1]);
        $this->assertEmpty(Tweet::loadAllTweetsByUserId(self::$myConn, 49));     
    }
    
    public function testLoadAllTweetsLimit300() {
        $tweets = Tweet::loadAllTweetsLimit300(self::$myConn);
        $this->assertInternalType("array", $tweets);
        $this->assertInstanceOf("Tweet", $tweets[1]);       
    }
    
    public function testSaveToDb() {
        $tweet = new Tweet();
        $tweet->setCreationDate("2018-01-02 2:01:33")->setText("new textx")
                ->setUserId(4);
        $this->assertTrue($tweet->saveToDb(self::$myConn));
        $incorrectTweet = new Tweet();
        $incorrectTweet->setCreationDate("2018-01-02 2:01:33")->setText("new textx")
                ->setUserId(42);
        $this->assertFalse($incorrectTweet->saveToDb(self::$myConn));
    }

}
