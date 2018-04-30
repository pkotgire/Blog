<?php
  require_once("support.php");
  session_start();

  // check if user has logged in
  if(!$_SESSION["loggedin"]) {
    header("Location: login.php");
  }

  // connect to database and get info on user
  $db = new DBConnection();
  $username = $_SESSION["username"];
  $user = $db->getUserInfo($username);
  $name = $user["firstname"]." ".$user["lastname"];
  if($name == " ") { $name = $username; }

  // add all blogs to a list for display
  /* replace with database access to blogs */
  $blogsList = $_SESSION['blog'];
  $allBlogs = "";
  if(!empty($blogsList)) {
    foreach ($blogsList as $blog) {
      $allBlogs .= $blog;
    }
  }
  if ($allBlogs == "") {
    $allBlogs = "<div class=\"alert alert-warning\">
                   Looks like there's nothing here....
                   Try searching for some tags or blogs to follow
                   or post your own blog.
                 </div>";
  }

  // display user homepage with blog posts
  $body = <<<EOBODY
    <div class="container center-align">
      <h3>Welcome to your Blog, &nbsp<em>$name</em></h3>
      <hr>
      <h6>
        <a href="profile.php">Update your Profile</a> or
        <a href="postBlog.php">Post Something New!</a>
      </h6>
      <!-- display blogs -->
      $allBlogs
    </div>
EOBODY;
   $page = generatePage($body, "", "home");
   echo $page;

 ?>
