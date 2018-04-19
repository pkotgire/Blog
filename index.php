<?php
  require_once("support.php");
  session_start();

  // check if user has logged in
  if(!$_SESSION["loggedin"]) {
    header("Location: login.php");
  }
  $db = new DBConnection();
  $username = $_SESSION["username"];
  $user = $db->getUserInfo($username);
  $name = $user["firstname"]." ".$user["lastname"];
  if($name == " ") { $name = $username; }

  $blog = $_SESSION['blog'];
  // $timestamp = $_SESSION['time'];
  // $tagList = $_SESSION['tags'];
  // $blogList = "";
  // $tags = "";
  // $blogs = "";
  //
  // if (!empty($tagList)) {
  //   foreach ($tagList as $tag) {
  //     $tags .= "<span class=\"badge badge-pill badge-primary\">$tag</span> ";
  //   }
  // }
  // <div class="container center-align blog">
  //   $blog1
  //   <br>
  //   $tags
  //   <br>
  //   <small><em>  Created By: $username at $timestamp</em></small>
  // </div>

  $body = <<<EOBODY
    <div class="container center-align">
      <h3>Welcome to your Blog, $name</h3>
      <hr>
      <h6>Please update your Profile</h6>
      <br>
      $blog
    </div>
EOBODY;
   $page = generatePage($body, "", "home");
   echo $page;

 ?>
