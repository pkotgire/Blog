<?php
	require_once("support.php");

	if(isset($_POST["signup"])) {
		if ($_POST["password"] != $_POST["verifypass"]) {
			$errorMsg = "
				<div class=\"alert alert-warning\">
					Passwords do not match.
				</div>";
		 } else {
			 $email = $_POST["email"];
			 $username = $_POST["username"];
			 $password = $_POST["password"];
			 $_SESSION["username"] = $username;
			 $db = new DBConnection();
			 $db->register($email, $username, $password);
			 header("Location: index.php");
		 }

	}

	$body = <<<EOBODY
			<div class="container center-align" style="margin-bottom: 2em;">
				<h3>Sign up</h3>
		    <br>
		    <form action="{$_SERVER[PHP_SELF]}" method="post">
					<!-- Username -->
					<div class="form-group row">
						<label for="username" class="col-form-label col-sm-2"><strong>Username: </strong></label>
						<input type="text" class="form-control col-sm-8" id="username" name="username" required>
					</div>

					<!-- Email -->
					<div class="form-group row">
						<label for="email" class="col-form-label col-sm-2"><strong>Email: </strong></label>
						<input type="email" class="form-control col-sm-8" id="email" name="email" required>
					</div>

		      <!-- Password -->
		      <div class="form-group row">
		        <label for="password" class="col-form-label col-sm-2"><strong>Password: </strong></label>
		        <input type="password" class="form-control col-sm-8" id="password" name="password" required>
		      </div>

		      <div class="form-group row">
		        <label for="verifypass" class="col-form-label col-sm-2"><strong>Verify Password: </strong></label>
		        <input type="password" class="form-control col-sm-8" id="verifypass" name="verifypass" required>
		      </div>
EOBODY;
	$buttons = <<<BUTTONS
	      <!-- Submit buttons -->
	      <button class="btn btn-primary align-center" type="submit" name="signup">Sign Up</button>
				<small> or </small>
				<a href="login.php">Login</a>

	    </form>
	  </div>
BUTTONS;

	$body = $body.$errorMsg.$buttons;

	$page = generatePage($body);
	echo $page;

 ?>
