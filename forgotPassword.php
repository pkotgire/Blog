<?php
  require_once("support.php");

  $body = <<< EOBODY
  <div class="container center-align mx-auto" style="margin-top: 6em !important; text-align:center;">
    <h1>HA! Get <strong>REKT</strong> BOII!!!!!!!</h1>
    <h2>Shoulda remembered your password, <strong><em>dumbass...</em></strong></h2>
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
