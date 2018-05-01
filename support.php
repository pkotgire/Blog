<?php
require_once("dbconnection.php");

function generatePage($body, $navbar="", $currentPage="") {
    $title = "WonderBlog";

    $home = "";
    $profile = "";
    $postBlog = "";
    if ($currentPage == "home") {
      $home = "active";
    } else if ($currentPage == "profile") {
      $profile = "active";
    } else if ($currentPage == "postBlog") {
      $postBlog = "active";
    }

    if ($navbar == "") {
      $navbar = <<< NAV
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary navbar-fixed-top">
        <a class="navbar-brand" href="index.php">$title</a>
          <form class="form-inline" action="searchResults.php" method="get">
            <input class="form-control mr-sm-2" type="search" placeholder="blogs" name="q">
            <button class="btn btn-outline-light" type="submit">Search</button>
          </form>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
         data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
         aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link $home" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link $profile" href="profile.php">My Profile</a></li>
            <li class="nav-item"><a class="nav-link $postBlog" href="postBlog.php">Post Blog</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">Log Out</a></li>
          </ul>
        </div>
      </nav>
NAV;
    }

    $page = <<<EOPAGE
    <!doctype html>
    <html>
      <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- favicon -->
        <link rel="shortcut icon" type="image/png" href="img/wbfavicon2.png">
        <!-- css -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">

        <!-- javascript -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <title>$title | CMSC389N</title>
      </head>
      <body>
        <!-- Header -->
        <header>
          <div class="text-center header">
            <!-- Navbar -->
            $navbar
          </div>
        </header>

        $body

        <!--Copyright-->
        <footer class="page-footer font-small blue pt-4 mt-4">
          <div class="footer-copyright py-3 text-center">
             © 2018 Copyright:
             <a href="index.php"> $title.com </a>
          </div>
        </footer>
      </body>
    </html>
EOPAGE;
  return $page;
}

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
                <small><em> Posted by: <strong>$username</strong> at $time</em></small>
              </div>";
  return $newBlog;
}

function processProfileSearch($resultList) {
  $return = "";
  foreach ($resultList as $result) {
    $return .= <<<EOBODY
        <div class=" center-align profiles">
          <img src="{$result['avatar']}">
          {$result['username']} |
          {$result['email']}
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

function phpAlert($msg) {
    echo '<script type="text/javascript">alert("'.$msg.'")</script>';
}

?>
