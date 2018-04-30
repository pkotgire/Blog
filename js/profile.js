window.onsubmit = main;

function main() {
  var first = document.getElementById("firstname").value;
  var last = document.getElementById("lastname").value;
  var website = document.getElementById("website").value;

  var x = "";

  if (first.length > 32) {
    x += "Firstname is too long\n";
  }
  if (last.length > 32) {
    x += "Lastname is too long\n";
  }
  if (website.length > 255) {
    x += "Website name is too long\n";
  }

  if (x === "") {
    alert(x);
  }
}