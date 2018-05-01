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
  // $user = $db->getUserInfo($username);
  $searchTerm = trim($_GET['q']);
  $results = searchByUser($searchTerm);
  // $results = "";

  /* replace with database access to blogs */
  // add all blogs to a list for display
  if (empty($results)) {
    $results = "
      <div class=\"alert alert-info\">
        Nothing matched your search... try something else.
      </div>";
  } else {
    $results = processSearch($results);
  }

  // display user homepage with blog posts
  $body = <<<EOBODY
    <div class="container center-align">
      <h5>Displaying results for `$searchTerm`</h5>
      <hr>
      <!-- display search results -->
      $results
    </div>
EOBODY;

   $page = generatePage($body, "", "search");
   echo $page;
 ?>
