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
  $searchTerm = trim($_GET['q']);
  $results = $db->searchByUser($searchTerm);
  $results2 = $db->searchByTag($searchTerm);

  // add all blogs to a list for display
  if (empty($results)) {
    $results = "
      <div class=\"alert alert-info\">
        Nothing matched your search... try something else.
      </div>";
  } else {
    $results = processProfileSearch($results, $db);
  }
  if (empty($results2)) {
    $blogsSearched  = "
      <div class=\"alert alert-info\">
        Nothing matched your search... try something else.
      </div>";
  } else {
    $blogsSearched = "";
    if(!empty($results2)) {
      foreach ($results2 as $blog) {
        $tagList = processTags($blog['tags']);
        $username = $db->getUsername($blog['uguid']);
        $blogsSearched .= processBlog($blog['text'], $tagList, $blog['timestamp'], $username);
      }
    }
  }

  // display user homepage with blog posts
  $body = <<<EOBODY
    <div class="container center-align">
      <h5>User Profiles matching `$searchTerm`</h5>
      <hr>
      <!-- display search results -->
      $results
      <br><br>
      <h5>Blog Posts matching `$searchTerm`</h5>
      <hr>
      $blogsSearched
    </div>
EOBODY;

   $page = generatePage($body, "", "search");
   echo $page;


   function processProfileSearch($resultList, $db) {
     $return = "";
     foreach ($resultList as $result) {
       $return .= <<<EOBODY
           <div class=" center-align profiles">
             <img id="searchAvatar" src="data:image/jpeg;base64,
             {$db->retrieveAvatar($result['guid'])}">
             &nbsp
             {$result['username']} |
             <em>{$result['email']}</em>
             <br><br>
             <form action="processViewProfile.php" method="post">
               <input type="hidden" name="username" value="{$result['username']}">
               <button class="btn btn-secondary" type="submit" name="viewProfile">View Profile</button>
             </form>
           </div><hr>
EOBODY;
     }
     return $return;
   }
 ?>
