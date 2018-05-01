<?php
  require_once("support.php");
  session_start();
  date_default_timezone_set('EST');

  // check if user has logged in
  if(!$_SESSION["loggedin"]) {
    header("Location: login.php");
  }
  $username = $_SESSION['username'];
  $guid = $_SESSION['guid'];
  $db = new DBConnection();

  // if the user posts a new blog
  if (isset($_POST['postBlog'])) {
    // get the blog data and tags
    $blog = $_POST['newBlog'];
    $tags = trim($_POST['tags']).", ";
    // add new blog to database
    $db->createBlog($guid, $blog, $tags);
    // go back to the homepage
    header("Location: index.php");
  }

  $body = <<<EOBODY
  <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea' });</script>

  <div class="container center-align">
    <h3>New Post</h3>
    <form action="{$_SERVER['PHP_SELF']}" method="post">
      <textarea rows="12" name="newBlog">Post something new!</textarea>
      <br>
      <h6>Add some tags</h6>
      <input type="text" name="tags" class="form-control col" placeholder="funny, cute, animals, etc.">
      <br>
      <div class="float-right">
        <button class="btn btn-primary" type="submit" name="postBlog">Post</button>
      </div>

    </form>
  </div>

EOBODY;
  $page = generatePage($body, "", "postBlog");
  echo $page;

?>
