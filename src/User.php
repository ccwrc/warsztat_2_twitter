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
    }

    public function setEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) <= 250) {
            $this->email = $email;
            return $this;
        }
    }

    public function setHashedPassword($password) {
        if (strlen($password) <= 65) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $this->hashedPassword = $hashedPassword;
            return $this;
        }
    }

    static public function loadUserById(mysqli $conn, $id) {
        $id = $conn->real_escape_string($id);
        $sql = "SELECT * FROM users WHERE user_id = $id";
        $result = $conn->query($sql);

        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $loadedUser = new User();
            $loadedUser->id = $row['user_id'];
            $loadedUser->username = $row['user_name'];
            $loadedUser->hashedPassword = $row['hashed_password'];
            $loadedUser->email = $row['user_email'];
            return $loadedUser;
        }
        return null;
    }

    // ponizsza funkcja nie jest jeszcze wykorzystana
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

    // ponizsza funkcja nie jest jeszcze wykorzystana
    static public function loadAllUsersByUserName(mysqli $conn, $userName) {
        $userName = $conn->real_escape_string($userName);
        $sql = "SELECT * FROM users WHERE user_name LIKE '%$userName%'";
        $ret = [];
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
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

    public function saveToDB(mysqli $conn) {
        if ($this->id == -1) {
            $statement = $conn->prepare("INSERT INTO users(user_name, hashed_password, user_email)
            VALUES (?,?,?)");
            $statement->bind_param('sss', $this->username, $this->hashedPassword, $this->email);
            if ($statement->execute()) { 
                $this->id = $statement->insert_id;
                return true;
            }
            return false;
        } else {
            $statement = $conn->prepare("UPDATE users SET user_name=?, user_email=?,
             hashed_password=? WHERE user_id=?");
            $statement->bind_param('sssi', $this->username, $this->email, $this->hashedPassword, $this->id);
            if ($statement->execute()) {
                return true;
            }
            return false;
        }
    }

    public function deleteById(mysqli $conn) {
        if ($this->id != -1) {
            $sql = "DELETE FROM users WHERE user_id=$this->id";
            $result = $conn->query($sql);
            if ($result) {
                $this->id = -1;
                return true;
            }
        }
        return false;
    }

}

