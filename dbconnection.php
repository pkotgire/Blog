<?php

    class DBConnection {

      private $servername = "localhost";
      private $username = "application";
      private $password = "dbpass";
      private $dbname = "blog";

      public function __construct() {
        $this->createUsersTable();
      }

      private function createUsersTable() {
        $query = "CREATE TABLE 'users' ('username' varchar(16) NOT NULL, 'email'
          varchar(100) NOT NULL, 'password' varchar(255) NOT NULL, 'firstname'
          varchar(32) NOT NULL, 'lastname' varchar(32) NOT NULL, 'birthday'
          date NOT NULL, 'website' varchar(255) NOT NULL,
          PRIMARY KEY ('username'))";
      }

      private function runQuery($query) {
        $conn = new mysqli($servername, $username, $password, $dbName);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $result = $conn->query($query);

        $conn->close();

        return $result;
      }
    }

?>
