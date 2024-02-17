function validateForm(){
  var fname = document.getElementById("fname").value;
  var adr = document.getElementById("adr").value;
  var city = document.getElementById("city").value;
  var state = document.getElementById("state").value;
  var post_code = document.getElementById("post-code").value;
  var email = document.getElementById("email").value;
  var payment = document.getElementById("payment").value;

  if (fname == "" || adr == "" || city == "" || state == "" || post_code == "" || email == "" || payment == "") {
    alert("Please fill in all required fields.");
    return false;
  }

  var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!email.match(emailPattern)) {
    alert("Please enter a valid email address.");
    return false;
  }
}

function submit_form(){
    if(validateForm()){
        return true;
    }
}

