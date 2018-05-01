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

      private function createFollowsTable() : void {
        $query = "create table follows(u1guid char(32) not null, u2guid
          char(32) not null, primary key(u1guid,u2guid), foreign key (u1guid)
          references users (guid), foreign key (u2guid) references
          users (guid));";

        $this->runQuery($query);
      }

      // Function to register a user into the 'users' databse
      // Returns a boolean based on success
      public function register($email, $username, $password) : bool {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $GUID = $this->generate_guid();
        if ($this->userExists($username, $email)) {
          return FALSE;
        }
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

      // Function that takes a username and email and checks if the user exists, only one of the parameters
      // have to be passed in
      public function userExists($username, $email) : bool {
        $query = "SELECT username FROM users WHERE username = '$username' OR email = '$email'";
        $result = $this->runQuery($query);
        $exists = $result->num_rows > 0;
        $result->free();
        return $exists;
      }

      // Function that takes a user's GUID and an array and update the users table
      public function updateUserInfo($GUID, $array) : bool {
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
        $query .= " WHERE GUID = '$GUID';";
        return $this->runQuery($query);
      }

      // Function to create a blog post
      public function createBlog($GUID, $text, $tags) {

        // Generate blog guid and insert into blog table
        $bGUID = $this->generate_guid();
        $query = "INSERT INTO blogs (GUID, text) VALUES ('$bGUID', '$text');";
        $this->runQuery($query);

        // Link the blog to the given user
        $query = "INSERT INTO userhasblogs (bguid, uguid) VALUES ('$bGUID', '$GUID');";
        echo $query . "<br>";
        $this->runQuery($query);

        // Link tags to blog
        foreach($tags as $tag) {
          $query = "INSERT INTO tags (name, bguid) VALUES ('$tag', '$bGUID')";
          $this->runQuery($query);
        }
      }

      public function getBlogs($username) : array {
        $query = "";
      }

      // Function to store and retrieve image
      public function updateAvatar($guid, $img) : bool {
        $query = "UPDATE users SET avatar = " . addslashes(file_get_contents($img)) . " WHERE guid = '$guid'";

        return $this->runQuery($query);
      }

      // Function to add followers
      public function updateFollowers($user1,$user2) : bool {
          $query = "INSERT INTO follows(u1guid,u2guid) VALUES ('$user1','$user2')";
          return $this->runQuery($query);
      }

      /*public function getGUID($username, $email) : String {
        $query = "SELECT guid FROM users WHERE username = '$username' OR email = '$email'";
        $result = $this->runQuery($query);
        $exists = $result->num_rows > 0;
        $result->free();
        return $exists;
      }*/

      // Function to run a query, returns the result
      private function runQuery($query) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $result = $conn->query($query);
        // echo $conn->error . "<br>";
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
              $uuid = substr($charid, 0, 8)
                  .substr($charid, 8, 4)
                  .substr($charid,12, 4)
                  .substr($charid,16, 4)
                  .substr($charid,20,12);
              return $uuid;
          }
      }
    }
?>
