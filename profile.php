<?php
  require_once("support.php");
  session_start();

  // check if user has logged in
  if(!$_SESSION["loggedin"]) {
    header("Location: login.php");
  }
  // connect to the database
  $db = new DBConnection();
  // get username
  $username = $_SESSION["username"];
  $user = $db->getUserInfo($username);
  $guid = $user['guid'];

  // if the user cancels their edit
  if(isset($_POST["cancel"])){
    unset($_POST["edit"]);
  }
  $firstname = "";
  $lastname = "";
  $website = "";

  // if user submits their edit
  if(isset($_POST["update"])){
    // get updated user info
		// $email = trim($_POST["email"]);
    // $username = trim($_POST["username"]);
    // $password = $_POST["password"];
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $website = trim($_POST["website"]);

    $avatar = ($_FILES["avatar"]["name"]);
    $avatarData = ($_FILES["avatar"]["tmp_name"]);
    $imageType = ($_FILES["avatar"]["type"]);

    $updatedUser = array("firstname"=>$firstname, "lastname"=>$lastname,
                  "website"=>$website, "avatar"=>$avatarData);
    // update user info in database
    $db->updateUserInfo($guid, $updatedUser);

  }
  // fetch user info from database
  $user = $db->getUserInfo($username);
  $email = $user["email"];
  $fname = $user["firstName"];
  $lname = $user["lastName"];
  $website = $user["website"];
  $avatar = $user["avatar"];

  // get following users from database
  // $followingUsers = $user["following"];
  $followingUsers = implode(", ",['<a href="index.php">tom</a>', 'bill', 'ted','tom']);

  // create form for user to update info
  if (isset($_POST["edit"])){
    $body = <<<FORM
    <div class="container center-align">
      <form action="{$_SERVER['PHP_SELF']}" method="post" enctype="multipart/form-data">
        <!-- Username -->
        <div class="form-group row">
          <label for="username" class="col-form-label col-sm-3"><strong>Username: </strong></label>
          <input type="text" class="form-control col-sm-8" id="username" name="username" pattern="[^\s]+" value="$username" disabled>
        </div>

        <!-- Email -->
        <div class="form-group row">
          <label for="email" class="col-form-label col-sm-3"><strong>Email: </strong></label>
          <input type="email" class="form-control col-sm-8" id="email" name="email" value="$email" disabled>
        </div>

        <!-- Avatar -->
        <div class="form-group row">
          <label for="avatar" class="col-form-label col-sm-3"><strong>Avatar: </strong></label>
          <input type="file" class="form-control col-sm-8" id="avatar" name="avatar" value="$avatar">
        </div>

        <!-- Firstname -->
        <div class="form-group row">
          <label for="firstname" class="col-form-label col-sm-3"><strong>First Name: </strong></label>
          <input type="text" class="form-control col-sm-8" id="firstname" name="firstname" value="$fname">
        </div>
        <!-- Lastname -->
        <div class="form-group row">
          <label for="lastname" class="col-form-label col-sm-3"><strong>Last Name: </strong></label>
          <input type="text" class="form-control col-sm-8" id="lastname" name="lastname" value="$lname">
        </div>

        <!-- Website -->
        <div class="form-group row">
          <label for="website" class="col-form-label col-sm-3"><strong>Website: </strong></label>
          <input type="url" class="form-control col-sm-8" id="website" name="website" value="$website">
        </div>

        <br>
          <hr>
          <h6><em> Change your Password: </em></h6>
          <br>

        <!-- // TODO: Old Password -->
        <!-- Password -->
        <div class="form-group row">
          <label for="password" class="col-form-label col-sm-3"><strong>Password: </strong></label>
          <input type="password" class="form-control col-sm-8" id="password" name="password">
        </div>
        <div class="form-group row">
          <label for="verifypass" class="col-form-label col-sm-3"><strong>Verify Password: </strong></label>
          <input type="password" class="form-control col-sm-8" id="verifypass" name="verifypass">
        </div>

        <!-- Submit buttons -->
        <div class="float-right" style="padding-right:3em;">
          <button class="btn btn-primary align-center" type="submit" name="update">Update Profile</button>
          <button class="btn btn-primary align-center" type="submit" name="cancel">Cancel</button>
        </div>
      </form>
    </div>
FORM;

  // display user info
  } else {
    $body = <<<EOBODY
      <div class="container center-align">
        <table class="table table-hover">
          <tbody>
            <tr><td><strong>Username: </strong></td><td>{$username}</td></tr>
            <tr><td><strong>Avatar: </strong></td><td><img src="data:image/jpeg;base64,{$avatar}"/></td></tr>
            <tr><td><strong>Email: </strong></td><td>{$email}</td></tr>
            <tr><td><strong>Name: </strong></td><td>{$fname} {$lname}</td></tr>
            <tr><td><strong>Website: </strong></td><td>{$website}</td></tr>
            <tr><td><strong>Following: </strong></td><td>{$followingUsers}</td></tr>
          </tbody>
        </table>
        <div class="float-right style="padding-right:7em;">
          <form action="{$_SERVER['PHP_SELF']}" method="post">
            <button class="btn btn-primary align-center" type="submit" name="edit">Edit Profile</button>
          </form>
        </div>
        <br>
EOBODY;
      // replace with database info
      $blogsList = $_SESSION['blog'];
      $allBlogs = "";
      if(!empty($blogsList)) {
        foreach ($blogsList as $blog) {
          $allBlogs .= $blog;
        }
      }
      if ($allBlogs == "") {
        $allBlogs = "<br><div class=\"alert alert-warning\">
                       Looks like there's nothing here....
                     </div>";
      }
      $body .= <<< EOBODY
        <h3>Posts</h3>
          $allBlogs
        </div>
EOBODY;
  }

  $page = generatePage($body, "", "profile");
  echo $page;

 ?>
