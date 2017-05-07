<?php

class User {  
    private $id;
    private $username;
    private $hashedPassword;
    private $email;

    public function __construct() {
        $this->id = -1;
        $this->username = "";
        $this->email = "";
        $this->hashedPassword = "";
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }
    
    public function getHashedPassword() {
        return $this->hashedPassword;
    }

    public function setUsername($userName) {
        if (is_string($userName) && trim(strlen($userName)) <= 65
                && trim(strlen($userName)) >= 3) {
            $userName = htmlentities(trim($userName), ENT_QUOTES, "UTF-8");
            $this->username = $userName;
            return $this;
        }
        return false;
    }

    public function setEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) <= 250) {
            $this->email = strtolower(trim($email));
            return $this;
        }
        return false;
    }

    public function setHashedPassword($password) {
        if (strlen($password) >= 3 && strlen($password) <= 65) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $this->hashedPassword = $hashedPassword;
            return $this;
        }
        return false;
    }
    
    public function countNewMessages(mysqli $conn) {
        $sql = "SELECT COUNT(message_id) AS new_messages FROM message WHERE message_receiver_id ="
                . " $this->id && message_read = 0 && message_receiver_visible = 0";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row['new_messages'];
        }
        return 0;
    }

    public function userAuthentication($enteredPassword) {
        if (password_verify($enteredPassword, $this->getHashedPassword())) {
            return true;
        }
        return false;
    }

    public static function loadUserById(mysqli $conn, $userId) {
        $statement = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $statement->bind_param('i', $userId);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $loadedUser = new User();
            $loadedUser->id = $row['user_id'];
            $loadedUser->username = $row['user_name'];
            $loadedUser->hashedPassword = $row['hashed_password'];
            $loadedUser->email = $row['user_email'];
            $statement->close();
            return $loadedUser;
        }
        $statement->close();
    }
    
    public static function loadUserByEmail(mysqli $conn, $userEmail) {
        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL) || strlen($userEmail) > 250) {
            return null;
        }
        $userEmail = strtolower($userEmail);
        $statement = $conn->prepare("SELECT * FROM users WHERE user_email = ?");
        $statement->bind_param('s', $userEmail);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $loadedUser = new User();
            $loadedUser->id = $row['user_id'];
            $loadedUser->username = $row['user_name'];
            $loadedUser->hashedPassword = $row['hashed_password'];
            $loadedUser->email = $row['user_email'];
            $statement->close();
            return $loadedUser;
        }
        $statement->close();
    }

    //funkcja nie jest jeszcze wykorzystana
    static public function loadAllUsers(mysqli $conn) {
        $sql = "SELECT * FROM users";
        $ret = [];
        $result = $conn->query($sql);

        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedUser = new User();
                $loadedUser->id = $row['user_id'];
                $loadedUser->username = $row['user_name'];
                $loadedUser->hashedPassword = $row['hashed_password'];
                $loadedUser->email = $row['user_email'];
                $ret[$loadedUser->id] = $loadedUser;
            }
        }
        return $ret;
    }
    
    // funkcja jeszcze niewykorzystana
    public static function loadAllUsersByUsername(mysqli $conn, $partOfUsername) {
        $partOfUsername = "%" . $partOfUsername . "%";
        $statement = $conn->prepare("SELECT * FROM users WHERE user_name LIKE ?");
        $statement->bind_param('s', $partOfUsername);
        $ret = [];
        if ($statement->execute()) {
            $result = $statement->get_result();
            $result->fetch_assoc();
            foreach ($result as $row) {
                $loadedUser = new User();
                $loadedUser->id = $row['user_id'];
                $loadedUser->username = $row['user_name'];
                $loadedUser->hashedPassword = $row['hashed_password'];
                $loadedUser->email = $row['user_email'];
                $ret[] = $loadedUser;
            }
        }
        $statement->close();
        return $ret;
    }

    public function saveToDB(mysqli $conn) {
        if ($this->id == -1) {
            $statement = $conn->prepare("INSERT INTO users(user_name, hashed_password, user_email)
            VALUES (?,?,?)");
            $statement->bind_param('sss', $this->username, $this->hashedPassword, $this->email);
            if ($statement->execute()) { 
                $this->id = $statement->insert_id;
                $statement->close();
                return true;
            }
            return false;
        } else {
            $statement = $conn->prepare("UPDATE users SET user_name=?, user_email=?,
             hashed_password=? WHERE user_id=?");
            $statement->bind_param('sssi', $this->username, $this->email, $this->hashedPassword, $this->id);
            if ($statement->execute()) {
                $statement->close();
                return true;
            }
            return false;
        }
    }

    public function deleteById(mysqli $conn) {
        if ($this->id != -1) {
            $sql = "DELETE FROM users WHERE user_id=$this->id";
            if ($conn->query($sql)) {
                $this->id = -1;
                return true;
            }
        }
        return false;
    }

}

