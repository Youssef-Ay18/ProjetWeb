// login.js file

function validateForm() {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    if (email == "") {
        alert("Please enter your email.");
        return false;
    }
    if (password == "") {
        alert("Please enter your password.");
        return false;
    }

    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailPattern.test(email)) 
    {
        alert("Please enter a valid email address.");
        return false;
    }
    var passwordPattern = /^(?=.*\d).{4,}$/; 
    if (!passwordPattern.test(password)) {
        alert("Password must be at least 4 characters long and contain at least one number.");
        return false;
    }
    return true; 
}
