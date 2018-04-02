<?php
	require_once("support.php");
	session_start();

	if (isset($_POST["login"])) {
		$db = new DBConnection();
		$username = $_POST["username"];
    $password = $_POST["password"];

    if (!$db->validLogin($username, $password)){
      $errorMsg = "
				<div class=\"alert alert-warning\">
					Incorrect username or password.
				</div>";
		} else {
			$_SESSION["username"] = $username;
			$_SESSION["loggedin"] = TRUE;
			header("Location: index.php");
	 	}
	}

	$body = <<<EOBODY
			<div class="container center-align">
				<h3>Login</h3>
		    <br>
		    <form action="{$_SERVER[PHP_SELF]}" method="post">
					<!-- Username -->
					<div class="form-group row">
						<label for="username" class="col-form-label col-sm-2"><strong>Username: </strong></label>
						<input type="text" class="form-control col-sm-8" id="username" name="username" required>
					</div>

		      <!-- Password -->
		      <div class="form-group row">
		        <label for="password" class="col-form-label col-sm-2"><strong>Password: </strong></label>
		        <input type="password" class="form-control col-sm-8" id="password" name="password" required>
		      </div>
EOBODY;

	/** Error Message will appear here **/

	$buttons = <<<BUTTONS
	      <!-- Submit buttons -->
				<div class="float-right" style="padding-right:7em;">
		      <button class="btn btn-primary" type="submit" name="login">Login</button>
					<span id="or"><small> or </small></span>
					<a href="signup.php">Sign Up</a>
				</div>
	    </form>
	  </div>
BUTTONS;

	$body = $body.$errorMsg.$buttons;
	$page = generatePage($body);
	echo $page;

 ?>
