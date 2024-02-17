function validateForm(){
  var fname = document.getElementById("fname").value;
  var adr = document.getElementById("adr").value;
  var suburb = document.getElementById("suburb").value;
  var state = document.getElementById("state").value;
  var country = document.getElementById("country").value;
  var email = document.getElementById("email").value;

  if (fname == "" || adr == "" || suburb == "" || state == "" || country == "" || email == "") {
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