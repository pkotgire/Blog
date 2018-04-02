<?php
  require_once("support.php");
  session_start();

  if(!$_SESSION["loggedin"]) {
    header("Location: signup.php");
  }
  $user = $_SESSION["username"];

  $body = <<<EOBODY

EOBODY;

 ?>
