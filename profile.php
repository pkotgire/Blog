<?php
  require_once("support.php");
  session_start();

  // check if user has logged in
  if(!$_SESSION["loggedin"]) {
    header("Location: login.php");
  }
  // connect to the database
  $db = new DBConnection();

  // fetch user info from database
  $username = $_SESSION["username"];
  $user = $db->getUserInfo($username);
  $


  $body = <<<EOBODY
    <div class="container center-align">
      <table class="table table-bordered">
        <tbody>
          <tr><td><strong>Username: </strong></td><td>$username</td></tr>
          <tr><td><strong>Email: </strong></td><td>$email</td></tr>
          <tr><td><strong>First Name: </strong></td><td>$firstname</td></tr>
          <tr><td><strong>Last Name: </strong></td><td>$lastname</td></tr>
          <tr><td><strong>Birthday: </strong></td><td>$birthday</td></tr>
          <tr><td><strong>Website: </strong></td><td>$website</td></tr>
        </tbody>
      </table>
      <a class="btn btn-primary float-right" href="logout.php">Log Out</a>
    </div>
EOBODY;

  $page = generatePage($body);
  echo $page;

 ?>
