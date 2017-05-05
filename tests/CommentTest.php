<?php

require_once __DIR__ . '/../src/Comment.php';

class CommentTest extends PHPUnit_Extensions_Database_TestCase {
    protected static $myConn;
    protected static $emptyComment;

    public function getConnection() {
        $conn = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
        $conn->query("SET GLOBAL FOREIGN_KEY_CHECKS=0");
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    }

    public function getDataSet() {
        return $this->createFlatXmlDataSet(__DIR__ . '/../datasets/comment.xml');
    }

    public static function setUpBeforeClass() {
        self::$myConn = new mysqli(
                $GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_NAME']
        );
        self::$emptyComment = new Comment();
    }

    public function testConstruct() {
        $this->assertInstanceOf("Comment", self::$emptyComment, 
                "spraw. konstruktora na self-emptyComment");
    }
    
    public function testGetId() {
        $this->assertEquals(-1, self::$emptyComment->getId());
    }
    
    public function testGetUserId() {
        $this->assertEquals(0, self::$emptyComment->getUserId());
    }    
    
    public function testGetTweetId() {
        $this->assertEquals(0, self::$emptyComment->getTweetId());
    }  
    
    public function testGetText() {
        $this->assertEquals("", self::$emptyComment->getText());
    }      
    
}
