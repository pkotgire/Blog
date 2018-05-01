window.onsubmit = validateForm;

function validateForm() {
  var pass = document.getElementById("password").value;
  var verifypass = document.getElementById("verifypass").value;
  var user = document.getElementById("username").value;
  var email = document.getElementById("email").value;

  var invalidMessage = "";
  if (pass == '' || pass.length < 8) {
    invalidMessage += "Passowrd is too short\n";
  }
  if (pass.length > 255) {
    invalidMessage += "Password is too long\n";
  }
  if (verifypass != pass) {
    invalidMessage += "Passwords don't match\n";
  }
  if (user.length < 3 ) {
    invalidMessage += "Username is too short\n";
  }
  if (user.length > 16) {
    invalidMessage += "Username is too long\n";
  }
  if (email.length > 128) {
    invalidMessage += "Email is too long\n";
  }

  if (invalidMessage == "") {
    return true;
  } else {
    alert(invalidMessage);
    return false;
  }
}
