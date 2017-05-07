<?php

require_once __DIR__ . '/../src/Message.php';

class MessageTest extends PHPUnit_Extensions_Database_TestCase {
    protected static $myConn;
    protected static $emptyMessage;

    public function getConnection() {
        $conn = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
        $conn->query("SET GLOBAL FOREIGN_KEY_CHECKS=0");
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    }

    public function getDataSet() {
        return $this->createFlatXmlDataSet(__DIR__ . '/../datasets/message.xml');
    }

    public static function setUpBeforeClass() {
        self::$myConn = new mysqli(
                $GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_NAME']
        );
        self::$emptyMessage = new Message();
    }

    public function testConstruct() {
        $message = new Message();
        $this->assertInstanceOf("Message", $message);
    }
    
    public function testGetMessageContent() {
        $this->assertEquals("", self::$emptyMessage->getMessageContent());
    }
    
    public function testGetMessageCreationdate() {
        $this->assertEquals("", self::$emptyMessage->getMessageCreationdate());
    }
    
    public function testSetMessageContent() {
        $this->assertFalse(self::$emptyMessage->setMessageContent("  "));
        self::$emptyMessage->setMessageContent("abc");
        $this->assertSame("abc", self::$emptyMessage->getMessageContent());
    }
    
    public function testSetMessageCreationDate() {
        $this->assertFalse(self::$emptyMessage->setMessageCreationDate("abc"));
        self::$emptyMessage->setMessageContent("2001-11-11 11:22:33");
        $this->assertSame("2001-11-11 11:22:33", self::$emptyMessage->getMessageContent());
    }

    public function testSetMessageRead() {
        $this->assertFalse(self::$emptyMessage->setMessageRead("abc"));
        $this->assertFalse(self::$emptyMessage->setMessageRead("1"));
        $this->assertFalse(self::$emptyMessage->setMessageRead(3));
        self::$emptyMessage->setMessageRead(1);
        $this->assertSame(1, self::$emptyMessage->getMessageRead());
    }
    
    public function testSetMessageReceiverId() {
        $this->assertFalse(self::$emptyMessage->setMessageReceiverId("abc"));
        $this->assertFalse(self::$emptyMessage->setMessageReceiverId(0));
        self::$emptyMessage->setMessageReceiverId(2);
        $this->assertSame(2, self::$emptyMessage->getMessageReceiverId());
    }
    
    public function testSetMessageReceiverVisible() {
        $this->assertFalse(self::$emptyMessage->setMessageReceiverVisible("ad"));
        $this->assertFalse(self::$emptyMessage->setMessageReceiverVisible("1"));
        $this->assertFalse(self::$emptyMessage->setMessageReceiverVisible(2));
        self::$emptyMessage->setMessageReceiverVisible(1);
        $this->assertSame(1, self::$emptyMessage->getMessageReceiverVisible());
    }
    
    public function testSetMessageSenderId() {
        $this->assertFalse(self::$emptyMessage->setMessageSenderId("abc"));
        $this->assertFalse(self::$emptyMessage->setMessageSenderId(0));
        self::$emptyMessage->setMessageSenderId(2);
        $this->assertSame(2, self::$emptyMessage->getMessageSenderId());
    }  
    
    public function testSetMessageSenderVisible() {
        $this->assertFalse(self::$emptyMessage->setMessageSenderVisible("ad"));
        $this->assertFalse(self::$emptyMessage->setMessageSenderVisible("1"));
        $this->assertFalse(self::$emptyMessage->setMessageSenderVisible(2));
        self::$emptyMessage->setMessageSenderVisible(1);
        $this->assertSame(1, self::$emptyMessage->getMessageSenderVisible());
    }    
    
    public function testCreateMessage() {
        $actualDate = date("Y-m-d H:i:s");
        $this->assertFalse(Message::createMessage("11", $actualDate, 0, 1));
        $this->assertFalse(Message::createMessage("11", $actualDate, 1, 0));
        $this->assertFalse(Message::createMessage("11", "2001-11-11 117:11", 2, 1));
        $this->assertFalse(Message::createMessage(" ", $actualDate, 3, 1));
        $this->assertInstanceOf("Message", Message::createMessage(" 2", $actualDate, 3, 91));
    }
    
    public function testLoadMessageById() {
        $this->assertInstanceOf("Message", Message::loadMessageById(self::$myConn, 1));
        $message = Message::loadMessageById(self::$myConn, 2);
        $this->assertSame("message 2 for user 3", $message->getMessageContent());
        $this->assertNull(Message::loadMessageById(self::$myConn, 133));
        $this->assertNull(Message::loadMessageById(self::$myConn, "abc"));
    }
    
    public function testLoadAllMessagesBySenderId() {
        $this->assertEmpty(Message::loadAllMessagesBySenderId(self::$myConn, 33));
        $this->assertInternalType('array', Message::loadAllMessagesBySenderId(self::$myConn, 33));
        $messages = Message::loadAllMessagesBySenderId(self::$myConn, 5);
        $this->assertInstanceOf("Message", $messages[1]); 
        $this->assertTrue(strlen($messages[1]->getMessageContent()) > 60);
        $this->assertEquals(1, $messages[1]->getMessageReceiverId()); 
    }
    
    public function testLoadAllCutMessagesBySenderId() {
        $this->assertEmpty(Message::loadAllCutMessagesBySenderId(self::$myConn, 33));
        $this->assertInternalType('array', Message::loadAllCutMessagesBySenderId(self::$myConn, 33));
        $messages = Message::loadAllCutMessagesBySenderId(self::$myConn, 5);
        $this->assertInstanceOf("Message", $messages[1]); 
        $this->assertTrue(strlen($messages[1]->getMessageContent()) == 60);
        $this->assertEquals(1, $messages[1]->getMessageReceiverId()); 
    }    
    
    public function testLoadAllMessagesByReceiverId() {
        $this->assertEmpty(Message::loadAllMessagesByReceiverId(self::$myConn, 33));
        $this->assertInternalType('array', Message::loadAllMessagesByReceiverId(self::$myConn, 33));
        $messages = Message::loadAllMessagesByReceiverId(self::$myConn, 1);
        $this->assertInstanceOf("Message", $messages[1]); 
        $this->assertTrue(strlen($messages[1]->getMessageContent()) > 60);
        $this->assertEquals(5, $messages[1]->getMessageSenderId()); 
    }   
    
    public function testLoadAllCatMessagesByReceiverId() {
        $this->assertEmpty(Message::loadAllCutMessagesByReceiverId(self::$myConn, 33));
        $this->assertInternalType('array', Message::loadAllCutMessagesByReceiverId(self::$myConn, 33));
        $messages = Message::loadAllCutMessagesByReceiverId(self::$myConn, 1);
        $this->assertInstanceOf("Message", $messages[1]); 
        $this->assertTrue(strlen($messages[1]->getMessageContent()) == 60);
        $this->assertEquals(5, $messages[1]->getMessageSenderId()); 
    }     
    
    public function testSaveToDb() {
        $actualDate = date("Y-m-d H:i:s");
        $message = Message::createMessage("abc2", $actualDate, 1, 1);
        $this->assertTrue($message->saveToDb(self::$myConn));
        $this->assertFalse(self::$emptyMessage->saveToDb(self::$myConn));
    }
    
}
