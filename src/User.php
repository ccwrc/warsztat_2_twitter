<?php

/* CREATE TABLE users ( user_id int AUTO_INCREMENT, 
 * user_name varchar(255) NOT NULL, 
 * hashed_password varchar(60) NOT NULL, 
 * user_email varchar(255) UNIQUE NOT NULL, 
 * PRIMARY KEY(user_id) ); */

class User {  // mozna zamiennie wrzucic w setery real escape string
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
    
    public function getUsername($username) {
        return $this->username;
    }
    
    public function getEmail($email) {
        return $this->email;
    }
    
    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }
    
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }
    
    public function setHashedPassword($hashedPassword) {
        $newHashedPassword = password_hash($hashedPassword, PASSWORD_BCRYPT);
        $this->hashedPassword = $newHashedPassword;
    }
    /* nowsza wersja funkcji na dole
    public function saveToDB(mysqli $conn) {
        if ($this->id == -1) { // zastosowac prepare statements
            $statement = $conn->prepare("INSERT INTO users(username, hashedPassword, email)
            VALUES (?,?,?)");
         //   $sql = "INSERT INTO users(username, hashedPassword, email)
          //  VALUES ('$this->username', '$this->hashedPassword', '$this->email')";
            $statement->bind_param('sss', $this->username, $this->hashedPassword, $this->email);
            if ($statement->execute()) { //execute wysyla zapytanie do bazy
                $this->id = $statement->insert_id;
                return true;
            }
            return false;
        }
    } */
    
    static public function loadUserById(mysqli $conn, $id){
        $sql = "SELECT * FROM users WHERE user_id=$id";
        $result = $conn->query($sql);
        
        if($result != false && $result->num_rows == 1) {
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
     
     static public function loadAllUsers(mysqli $conn){
        $sql = "SELECT * FROM users";
        $ret = [];
        $result = $conn->query($sql);
        
        if($result == true && $result->num_rows != 0){
           foreach($result as $row){
           $loadedUser = new User();
           $loadedUser->id = $row['user_id'];
           $loadedUser->username = $row['user_name'];
           $loadedUser->hashedPassword = $row['hashed_password'];
           $loadedUser->email = $row['user_email'];
           $ret[$loadedUser->id] = $loadedUser;
           }
         }
           return $ret; // if tablica jest pusta to ech na no users
    }
    
     static public function loadAllUsersByUserName(mysqli $conn, $username){
        $sql = "SELECT * FROM users WHERE user_name LIKE '%$username%'";
        $ret = [];
        $result = $conn->query($sql);
        
        if($result == true && $result->num_rows != 0){
           foreach($result as $row){
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
        if ($this->id == -1) { //  prepare statements
            $statement = $conn->prepare("INSERT INTO users(user_name, hashed_password, user_email)
            VALUES (?,?,?)");
         //   $sql = "INSERT INTO users(username, hashedPassword, email)
          //  VALUES ('$this->username', '$this->hashedPassword', '$this->email')";
            $statement->bind_param('sss', $this->username, $this->hashedPassword, $this->email);
            if ($statement->execute()) { //execute wysyla zapytanie do bazy
                $this->id = $statement->insert_id;
                return true;
            }
            return false;
        } else {
              $sql = "UPDATE users SET user_name='$this->username',
              user_email='$this->email',
              hashed_password='$this->hashedPassword'
              WHERE user_id=$this->id";
              $result = $conn->query($sql);
              if($result == true){
               return true;
              }
            return false;
        }
    }
    
    public function delete(mysqli $conn){
          if($this->id != -1){
            $sql = "DELETE FROM users WHERE user_id=$this->id";
            $result = $conn->query($sql);
              if($result == true){
                 $this->id = -1;
                 return true;
               }
            return false;
          }
       return true;
    }
    
    
}

?>
