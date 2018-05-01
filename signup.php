<?php
	require_once("support.php");
	session_start();

	$errorMsg = "";
	$email = "";
	$username = "";
	$password = "";

	// if the user has clicked signup
	if(isset($_POST["signup"])) {
		// connect to the database
		$db = new DBConnection();

		// get user info
		$email = trim($_POST["email"]);
		$username = trim($_POST["username"]);
		$password = $_POST["password"];

		// check if passwords match
		if ($password != $_POST["verifypass"]) {
			$errorMsg = "
				<div class=\"alert alert-danger\">
					Passwords do not match.
				</div>";

			// check if email is already in the database
		} else if ($db->userExists("", $email)) {
			$errorMsg = "
				<div class=\"alert alert-danger\">
					An account with this email already exists.
				</div>";

			// check if username is already in the database
		} else if ($db->userExists($username, "")) {
			$errorMsg = "
				<div class=\"alert alert-danger\">
					Sorry, that username is taken.
				</div>";
		} else {
			// add new user into the database
			if ($db->register($email, $username, $password)){
				// if succesful registration
				// store username in SESSION
				$_SESSION["username"] = $username;
				$_SESSION["guid"] = $db->getUserInfo($username)['guid'];
				$_SESSION["loggedin"] = TRUE;

				// redirect user to home page
				header("Location: index.php");
			} else {
				$errorMsg = "
					<div class=\"alert alert-danger\">
						Registration failed.
					</div>";
			}
		}
	}

	// create the registration form
	$body = <<<FORM
	<div class="container center-align">
		<h3>Sign up</h3>
	  <hr><br>
	  <form action="{$_SERVER['PHP_SELF']}" method="post">
			<!-- Username -->
			<div class="form-group row">
				<label for="username" class="col-form-label col-sm-3"><strong>Username: </strong></label>
				<input type="text" class="form-control col-sm-8" id="username" name="username" pattern="[^\s]+" value="$username" required>
			</div>

			<!-- Email -->
			<div class="form-group row">
				<label for="email" class="col-form-label col-sm-3"><strong>Email: </strong></label>
				<input type="email" class="form-control col-sm-8" id="email" name="email" value="$email" required>
			</div>

	    <!-- Password -->
	    <div class="form-group row">
	      <label for="password" class="col-form-label col-sm-3"><strong>Password: </strong></label>
	      <input type="password" class="form-control col-sm-8" id="password" name="password" value="$password" required>
	    </div>

	    <div class="form-group row">
	      <label for="verifypass" class="col-form-label col-sm-3"><strong>Verify Password: </strong></label>
	      <input type="password" class="form-control col-sm-8" id="verifypass" name="verifypass" required>
	    </div>
FORM;
	/** Error Message will appear here **/
	$buttons = <<<BUTTONS
	      <!-- Submit buttons -->
				<div class="float-right" style="padding-right:3em;">
		      <button class="btn btn-primary align-center" type="submit" name="signup">Sign Up</button>
					<span id="or"><small> or </small></span>
					<a href="login.php">Login</a>
				</div>
				<br>
				<br>
				<small class="float-right" style="padding-right:3em;">By signing up, you agree to our
					<a data-toggle="modal" href="#tnc">Terms & Conditions</a>
				</small>
	    </form>
	  </div>
		<script src="js/signup.js"></script>
BUTTONS;
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
	// terms & conditions pop-up
	$tnc = <<<MODAL
		<!-- Modal -->
		<div class="modal fade" id="tnc" tabindex="-1" role="dialog" aria-labelledby="tncLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="tncLabel">Terms and Conditions</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<em>Last updated: (4/30/18)</em>
						<br>
						Please read these Terms and Conditions carefully before using the
						WonderBlog website operated by our elite team of Computer Science majors.
						<br>
						Your access to and use of our service is conditioned on your acceptance
						of and compliance with these Terms. These Terms apply to all visitors,
						users and others who access or use our service.
						<br>
						<strong>
						By accessing or using our service you agree to be bound by these Terms.
						If you disagree with any part of the terms then you may not access our service.
						</strong>
						<br><br>
						<strong>Content</strong>
						<br>
						Our Service allows you to post, link, store, share and otherwise make
						available certain information, text, graphics, videos, or other
						material. You are responsible for the safety and security of anything
						you post.
						<br><br>
						<strong>Links To Other Web Sites</strong>
						<br>
						Our Service may contain links to third-party web sites or services
						that are not owned or controlled by WonderBlog.
						WonderBlog has no control over, and assumes no responsibility for, the
						content, privacy policies, or practices of any third party web sites
						or services. You further acknowledge and agree that WonderBlog shall
						not be responsible or liable, directly or indirectly, for any damage
						or loss caused or alleged to be caused by or in connection with use of
						or reliance on any such content, goods or services available on or
						through any such web sites or services.
						<br><br>
						<strong>Changes</strong>
						<br>
						We reserve the right, at our sole discretion, to modify or replace
						these Terms at any time. If a revision is material we will try to
						provide at least 30 days' notice prior to any new terms
						taking effect. What constitutes a material change will be determined
						at our sole discretion.
						<br><br>
						<strong>Contact Us</strong>
						<br>
						If you have any questions about these Terms, please contact us.
					</div>
				</div>
			</div>
		</div>
MODAL;

	$body = $body.$errorMsg.$buttons.$tnc;
	$page = generatePage($body, $navbar);
	echo $page;

 ?>
