<?php
  require_once("support.php");

  $body = <<< EOBODY
  <div class="container center-align mx-auto" style="margin-top: 6em !important;">
    <h4><em>Be more careful next time...</em></h4>
    <form action="{$_SERVER['PHP_SELF']}" method="post">
      <label for="email">Enter email:</label>
      <input type="email" name="email">
      <button class="btn btn-primary" type="submit" name="button">Reset Password</button>
    </form>

  </div>
EOBODY;
$navbar = <<< NAV
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		<a class="navbar-brand" href="index.php">WonderBlog</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse"
		 data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
		 aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
	</nav>
NAV;

  $page = generatePage($body,$navbar, "");
  echo $page;

?>
