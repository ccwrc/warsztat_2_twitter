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
                "sprawdzenie konstruktora na self-emptyComment");
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
    
    public function testGetCreationDate() {
        $this->assertEquals("", self::$emptyComment->getCreationDate());
    }      
    
    public function testSetUserId() {
        $this->assertFalse(self::$emptyComment->setUserId("abc"));
        self::$emptyComment->setUserId(1);
        $this->assertEquals(1, self::$emptyComment->getUserId());
    }
    
    public function testSetTweetId() {
        $this->assertFalse(self::$emptyComment->setTweetId("abc"));
        self::$emptyComment->setTweetId(2);
        $this->assertEquals(2, self::$emptyComment->getTweetId());
    }
    
    public function testSetText() {
        $this->assertFalse(self::$emptyComment->setText("bc"));
        $this->assertFalse(self::$emptyComment->setText("   ab   "));
        self::$emptyComment->setText("newTextx");
        $this->assertEquals("newTextx", self::$emptyComment->getText());
    }
    
    public function testSetCreationDate() {
        $this->assertFalse(self::$emptyComment->setCreationDate("baac"));
        $this->assertFalse(self::$emptyComment->setCreationDate("1-1-1 111:1:1"));
        self::$emptyComment->setCreationDate("2001-11-11 11:12:13");
        $this->assertEquals("2001-11-11 11:12:13", self::$emptyComment->getCreationDate());
    }  
    
    public function testLoadCommentById() {
        $this->assertNull(Comment::loadCommentById(self::$myConn, 123));
        $this->assertInstanceOf("Comment", Comment::loadCommentById(self::$myConn, 1));
        $comment = Comment::loadCommentById(self::$myConn, 2);
        $this->assertSame("comment 2", $comment->getText());
    }
    
    
    

}
