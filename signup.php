<?php
	require_once("support.php");
	session_start();

	$errorMsg = "";
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
		    <br>
		    <form action="{$_SERVER['PHP_SELF']}" method="post">
					<!-- Username -->
					<div class="form-group row">
						<label for="username" class="col-form-label col-sm-2"><strong>Username: </strong></label>
						<input type="text" class="form-control col-sm-8" id="username" name="username" pattern="[^\s]+" value="$username" required>
					</div>

					<!-- Email -->
					<div class="form-group row">
						<label for="email" class="col-form-label col-sm-2"><strong>Email: </strong></label>
						<input type="email" class="form-control col-sm-8" id="email" name="email" value="$email" required>
					</div>

		      <!-- Password -->
		      <div class="form-group row">
		        <label for="password" class="col-form-label col-sm-2"><strong>Password: </strong></label>
		        <input type="password" class="form-control col-sm-8" id="password" name="password" value="$password" required>
		      </div>

		      <div class="form-group row">
		        <label for="verifypass" class="col-form-label col-sm-2"><strong>Verify Password: </strong></label>
		        <input type="password" class="form-control col-sm-8" id="verifypass" name="verifypass" required>
		      </div>
FORM;

	/** Error Message will appear here **/

	$buttons = <<<BUTTONS
	      <!-- Submit buttons -->
				<div class="float-right" style="padding-right:7em;">
		      <button class="btn btn-primary align-center" type="submit" name="signup">Sign Up</button>
					<span id="or"><small> or </small></span>
					<a href="login.php">Login</a>
				</div>
	    </form>
	  </div>
BUTTONS;

	$body = $body.$errorMsg.$buttons;
	$page = generatePage($body);
	echo $page;

 ?>
