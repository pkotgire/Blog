<?php
  require_once("support.php");
  session_start();
  $_SESSION['viewProfile'] = $_POST['username'];
  header("Location: profile.php");
?>
