window.onsubmit = main;

function main() {
  var pass = document.getElementById("password").value;
  var user = document.getElementById("username").value;
  var email = document.getElementById("email").value;
  var x = "";

  if (pass.length == '' || pass.length <= 8) {
    x += "Passowrd is too short\n";
  } else if (pass.length > 255) {
    x += "Password is too long\n";
  }
  if (user.length > 16) {
    x += "Username is too long\n";
  }
  if (email.length > 100) {
    x += "Email is too long\n";
  }

  if (x === "") {
    alert(x);
  }

}
