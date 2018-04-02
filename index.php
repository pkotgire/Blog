<?php
  require_once("support.php");
  session_start();

  // check if user has logged in
  if(!$_SESSION["loggedin"]) {
    header("Location: login.php");
  }
  $username = $_SESSION["username"];

  $body = <<<EOBODY
    <div class="container center-align">
      <h3>Welcome to your Blog, $username</h3>
      <h6>Please update your Profile</h6>
      <hr>
      <a class="btn btn-primary" href="profile.php">My Profile</a>
      <a class="btn btn-primary" href="logout.php">Log Out</a>
    </div>
EOBODY;
   $page = generatePage($body);
   echo $page;

 ?>
