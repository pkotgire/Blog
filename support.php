<?php

function generatePage($body) {
    $page = <<<EOPAGE
    <!doctype html>
    <html>
      <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="shortcut icon" type="image/png" href="img/.png"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">

        <title>Blog | CMSC389N</title>
      </head>
      <body>
        <!-- Header -->
        <header>
          <div class="text-center header">
            <h1>Blog</h1>
            </div>
        </header>

        $body

        <!--Copyright-->
        <footer class="page-footer font-small blue pt-4 mt-4">
          <div class="footer-copyright py-3 text-center">
             © 2018 Copyright:
             <a href="#"> Blog.com </a>
          </div>
        </footer>
      </body>
    </html>
EOPAGE;
  return $page;
}

?>
