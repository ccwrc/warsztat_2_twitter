<?php

require_once __DIR__ . '/../src/User.php';

class UserTest extends PHPUnit_Extensions_Database_TestCase {
    protected static $myConn;

    public function getConnection() {
        $conn = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
        $conn->query("SET GLOBAL FOREIGN_KEY_CHECKS=0");
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    }

    public function getDataSet() {
        return $this->createFlatXmlDataSet(__DIR__ . '/../datasets/users.xml');
    }

    public static function setUpBeforeClass() {
        self::$myConn = new mysqli(
                $GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_NAME']
        );
    }

    public function testConstruct() {
        $user = new User();
        $this->assertInstanceOf("User", $user);
    }

    public function testLoadUserByIdAndGetid() {
        $user = User::loadUserById(self::$myConn, 2);
        $this->assertEquals(2, $user->getId());
    }

    public function testLoadUserByIdIfIdIsIncorrect() {
        $this->assertNull(User::loadUserById(self::$myConn, 29));
        $this->assertNull(User::loadUserById(self::$myConn, "bla"));
    }

    public function testGetUsername() {
        $user = User::loadUserById(self::$myConn, 2);
        $this->assertEquals("user2", $user->getUsername());
    }

    public function testGetEmail() {
        $user = User::loadUserById(self::$myConn, 2);
        $this->assertEquals("user2@mail.bom", $user->getEmail());
    }

    public function testSetUsername() {
        $user = User::loadUserById(self::$myConn, 3);
        $user->setUsername("user33");
        $this->assertSame("user33", $user->getUsername());
    }

    public function testSetUsernameIfUsernameIsTooLong() {
        $user = User::loadUserById(self::$myConn, 3);
        $this->assertNull($user->setUsername("u1234567890u1234567890u1234567890u"
                        . "1234567890u1234567890u1234567890u1234567890"));
    }

    public function testSetEmail() {
        $user = User::loadUserById(self::$myConn, 3);
        $this->assertNull($user->setEmail("false_mail@false"));
        $user->setEmail("true@mail.pl");
        $this->assertSame("true@mail.pl", $user->getEmail());
    }

    public function testSetHashedPassword() {
        $user = new User();
        $user->setHashedPassword("pass");
        $this->assertTrue(strlen($user->getHashedPassword()) == 60);
        $this->assertTrue(password_verify("pass", $user->getHashedPassword()));
    }

    public function testLoadUserById() {
        $this->assertNull(User::loadUserById(self::$myConn, 333));
        $this->assertNull(User::loadUserById(self::$myConn, "abc"));
        $this->assertInstanceOf("User", User::loadUserById(self::$myConn, 3));
    }

    public function testLoadAllUsers() {
        $this->assertInternalType("array", User::loadAllUsers(self::$myConn));
        $users = User::loadAllUsers(self::$myConn);
        $this->assertInstanceOf("User", $users[1]);
    }

    public function testLoadAllUsersByUserName() {
        $users = User::loadAllUsersByUserName(self::$myConn, "user");
        $this->assertInternalType("array", $users);
        $this->assertInstanceOf("User", $users[2]);
        $this->assertEmpty(User::loadAllUsersByUserName(self::$myConn, "us88er"));
    }

    public function testSaveToDb() {
        $user = new User();
        $user->setEmail("mail@pp.pp")->setHashedPassword("pass")->setUsername("newfuser");
        $this->assertTrue($user->saveToDB(self::$myConn));
        $loadedUser = User::loadUserById(self::$myConn, 1);
        $this->assertTrue($loadedUser->saveToDB(self::$myConn));
    }

    public function testDeleteUser() {
        $user = new User();
        $this->assertFalse($user->deleteById(self::$myConn));
        $user->setEmail("mail@pp.pp")->setHashedPassword("pass")->setUsername("newfuser")
                ->saveToDB(self::$myConn);
        $this->assertTrue($user->deleteById(self::$myConn));
    }

}
