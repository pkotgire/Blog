<?php
    // declare(strict_types=1);
    class DBConnection {

      private $servername = "localhost";
      private $username = "application";
      private $password = "dbpass";
      private $dbname = "blog";

      public function __construct() {
        $this->createUsersTable();
        $this->createUserHasBlogsTable();
        $this->createBlogsTable();
        $this->createTagsTable();
      }

      // Creates the 'users' table in the blog db if it does not exist
      private function createUsersTable() : void {
        $query = "create table users(guid char(32) primary key not null,
          username varchar(16) not null, email varchar(128) not null,
          password varchar(255) not null, firstName varchar(32), lastName
          varchar(32), website varchar(128), avatar longblob);";

        $this->runQuery($query);
      }

      // Creates the 'userHasBlogs' table
      private function createUserHasBlogsTable() : void {
        $query = "create table userHasBlogs(bguid char(32) primary key not
          null, uguid char(32) not null, foreign key (uguid) references users
          (guid), foreign key (bguid) references blogs (guid));";

        $this->runQuery($query);
      }

      private function createBlogsTable() : void {
        $query = "create table blogs(guid char(32) primary key not null, text
          varchar(1024), timestamp datetime not null default now());";

        $this->runQuery($query);
      }

      private function createTagsTable() : void {
        $query = "create table tags(name varchar(32) not null, bguid char(32)
          not null, primary key(name,bguid), foreign key (bguid) references
          blogs (guid));";

        $this->runQuery($query);
      }


      // Function to register a user into the 'users' databse
      // Returns a boolean based on success
      public function register($email, $username, $password) : bool {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $GUID = generate_guid();
        $query = "INSERT INTO users (GUID, username, email, password)
          VALUES ('$GUID', '$username', '$email', '$password')";
        return $this->runQuery($query);
      }

      // Function to check if login is valid
      // Returns a boolean based on success
      public function validLogin($username, $password) : bool {
        $query = "SELECT username, password FROM users WHERE username = '$username'";
        $result = $this->runQuery($query);

        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          if (password_verify($password, $row["password"])) {
            return TRUE;
          }
        }

        $result->free();
        return FALSE;
      }

      // Returns an array with user info
      public function getUserInfo($username) : array {
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = $this->runQuery($query);
        $array = ($result->num_rows > 0) ? $result->fetch_assoc() : [];
        $result->free();
        return $array;
      }

      public function userExists($username, $email) : bool {
        $query = "SELECT username FROM users WHERE username = '$username' OR email = '$email'";
        $result = $this->runQuery($query);
        $exists = $result->num_rows > 0;
        $result->free();
        return $exists;
      }

      public function updateUserInfo($username, $array) : bool {
        $query = "UPDATE users SET ";
        foreach ($array as $key=>$value) {
          $query .= "$key=";
          if (is_string($value))
            $query .= "'$value'";
          else
            $query .= $value;
          $query .= ", ";
        }
        $query = rtrim($query, ", ");
        $query .= " WHERE username = '$username';";
        return $this->runQuery($query);
      }

      // Function to run a query, returns the result
      private function runQuery($query) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $result = $conn->query($query);
        // echo $conn->error
        $conn->close();

        return $result;
      }

      private function generate_guid() : String {
          if (function_exists('com_create_guid')) {
              return com_create_guid();
          } else {
              mt_srand((double)microtime()*10000);
              $charid = strtoupper(md5(uniqid(rand(), true)));
              $hyphen = chr(45); // "-"
              $uuid = substr($charid, 0, 8).$hyphen
                  .substr($charid, 8, 4).$hyphen
                  .substr($charid,12, 4).$hyphen
                  .substr($charid,16, 4).$hyphen
                  .substr($charid,20,12);
              return $uuid;
          }
      }
    }
?>
