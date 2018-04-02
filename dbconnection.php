<?php

    class DBConnection {

      private $servername = "localhost";
      private $username = "application";
      private $password = "dbpass";
      private $dbname = "blog";

      public function __construct() {
        $this->createUsersTable();
      }

      // Creates the 'users' table in the blog db if it does not exist
      private function createUsersTable() {
        $query = "CREATE TABLE users (username varchar(16) NOT NULL, email
          varchar(100) NOT NULL, password varchar(255) NOT NULL, firstname
          varchar(32) NOT NULL, lastname varchar(32) NOT NULL, birthday
          date, website varchar(255) NOT NULL,
          PRIMARY KEY (username));";

          $this->runQuery($query);
      }

      // Function to register a user into the 'users' databse
      // Returns a boolean based on success
      public function register($email, $username, $password) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (email, username, password)
          VALUES ('$email', '$username', '$password')";
        return $this->runQuery($query);
      }

      // Function to check if login is valid
      // Returns a boolean based on success
      public function login($username, $password) {
        $query = "SELECT username, password FROM users WHERE username = '$username'";
        $result = $this->runQuery($query);

        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          if (password_verify($password, $row["password"])) {
            return TRUE;
          }
        }

        return FALSE;
      }

      // Function to run a query, returns the result
      private function runQuery($query) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $result = $conn->query($query);

        $conn->close();

        return $result;
      }
    }

?>
