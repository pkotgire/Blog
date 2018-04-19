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

        <link rel="shortcut icon" type="image/png" href="img/wbfavicon2.png">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">

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

function phpAlert($msg) {
    echo '<script type="text/javascript">alert("'.$msg.'")</script>';
}

?>
