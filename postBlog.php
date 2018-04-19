<?php
  require_once("support.php");
  session_start();

  // check if user has logged in
  if(!$_SESSION["loggedin"]) {
    header("Location: login.php");
  }
  $username = $_SESSION['username'];


  if (isset($_POST['postBlog'])) {
    $blog = $_POST['newBlog'];
    $tags = processTags(trim($_POST['tags']));
    $time = date("h:ia m/d/Y");
    $myarray = [];
    array_push($myarray, processBlog($blog,$tags,$time, $username));
    $_SESSION['blog'] = $myarray;
    // $_SESSION['blog'] = processBlog($blog,$tags,$time, $username);

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


  function processTags($tags='') {
    return array_unique(preg_split('/[,\s]+/', $tags));
  }

  function processBlog($blog, $tagList, $time, $username) {
    $tags = "";
    if (!empty($tagList)) {
      foreach ($tagList as $tag) {
        $tags .= "<span class=\"badge badge-pill badge-primary\">$tag</span> ";
      }
    }
    $newBlog = "<div class=\"container center-align blog\">
                  $blog
                  <br>
                  $tags
                  <br>
                  <small><em>  Created By: $username at $time</em></small>
                </div>";
    return $newBlog;
  }
?>
