/**
 * REGISTRATION FORM VALIDATION
 */
//uses an event listener to prevent submiting the form is any of the inputs is invalid
const form = document.querySelector('#myForm');
const submitButton = document.querySelector('#submitButton');
submitButton.addEventListener('click', function(event) {
        // Prevent the default form submission
        event.preventDefault();
    // Get form inputs
    const name = document.getElementById("user-name").value;
    const phone = document.getElementById("phone-no").value;
    const password = document.getElementById("password").value;
    //create variables to store the errors
    var nameError = document.getElementById('name-error-message');
    var phoneError = document.getElementById('phone-error-message');
    var passwordError = document.getElementById('password-error-message');
    // Regular expression patterns for validation
    const namePattern = /^[a-zA-Z ]+$/;
    const phonePattern = /^\d+$/;
    const passwordPattern = /^(?=.*\d)(?=.*[a-zA-Z])(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{8,}$/;
    //check that the fields are not empty
    if (name.trim() === "" && phone.trim() === "" && password.trim() === "") {
        alert("Please fill in all fields.");
        return false;
    }  else {
        //validating the user name
        //Check the name if the name field is empty
       if (name.trim() === "") {
            nameError.innerHTML =  "Please enter your name.";
            document.getElementById('user-name').style.borderColor = "red";
            return false;
            //else check that the format of the name is valid
        }   else if (!name.match(namePattern)) {
            nameError.innerHTML = "Name should contain only letters and spaces.";
            document.getElementById('user-name').style.borderColor = "red";
            return false;
        }   else{
            //when everything is okay continue to the next step
            document.getElementById('user-name').style.borderColor = "green";
            nameError.innerHTML =  "";
        }
        //validating the phone number
        if (phone.trim() === "") {
            phoneError.innerHTML =  "Please enter your phone Number.";
            document.getElementById('phone-no').style.borderColor = "red";
            return false;
        }   else  if (!phone.match(phonePattern)) {
            phoneError.innerHTML = "Phone number should contain only numbers.";
            document.getElementById('phone-no').style.borderColor = "red";
            return false;
        }   else{
            phoneError.innerHTML =  "";
            document.getElementById('phone-no').style.borderColor = "green";
        }
        //validating the user password
        if (password.trim() === "") {
            passwordError.innerHTML = "Please enter your password.";
            document.getElementById('password').style.borderColor = "red";
            return false;
        }   else  if (!password.match(passwordPattern)) {
            document.getElementById('password').style.borderColor = "red";
            passwordError.innerHTML ="Password should contain at least one letter, one number, and one special character and be at least 8 characters long.";
            return false;
        }   else{
            passwordError.innerHTML =  "";
            document.getElementById('password').style.borderColor = "green";
        }
    }
    // If all inputs are valid, return true
    nameError.innerHTML = "";
    phoneError.innerHTML = "";
    passwordError.innerHTML = "";
    form.submit();
});
// function to enable login for a registered user.
function openAcountActionPage(){
  loginPage =  document.getElementById('login-page');
  createAccPage =  document.getElementById('register-page');
  if(loginPage.style.display === 'none' && createAccPage.style.display === 'block'){
    loginPage.style.display = "block";
    createAccPage.style.display = "none";
  }else{
    loginPage.style.display = "none";
    createAccPage.style.display = "block";
  }
}

//JQUERY code to incoporate with ajax.
//this function checks for a number that is already registered
//SERVER file== /Server_Scripts/checkPhone.php
$(document).ready(function(){

$("#phone-no").on("blur", function() {
  var number = $(this).val();
  if(number==""){
    $("#phone-error-message").text("Phone number cannot be empty!");
    disableSubmitButton();
  }else{
  $.ajax({
    url: "/Server_Scripts/checkPhone.php",
    method: "POST",
    data: { number: number },
    dataType: "json",
    success: function(response) {
      if (response.error) {
        $("#phone-error-message").text(response.error);
        disableSubmitButton();
      } else {
        $("#phone-error-message").text("");
        enableSubmitButton();
      }
    },
    error: function() {
      $("#phone-error-message").text("Error checking number. Please try again later.");
      disableSubmitButton();
    }
  });
}
});
function enableSubmitButton() {
  if ($("#phone-error-message").text() == "") {
    $("#submitButton").attr("disabled", false);
  }
}
function disableSubmitButton() {
  if( $("#submitButton").attr("disabled", false)){
    $("#submitButton").attr("disabled", true);
  }
}

});


function checkPhoneNumber(){

  //get the error message using ajax
  var phone_number = document.getElementById('phone-no').value;
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
          document.getElementById("phone-error-message").innerHTML = xhr.responseText;
      }
  };
  xhr.open("POST", "/Server_Scripts/checkPhone.php", true);
  //xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(phone_number);

}

/**
 * LOG IN FORM VALIDATION (same logic as the registration form)
 */
const loginForm = document.querySelector('#loginForm');
const loginSubmitButton = document.querySelector('#loginSubmitButton');
loginSubmitButton.addEventListener('click', function(event) {
  event.preventDefault();
  const phone = document.getElementById("login-phone-no").value;
  const password = document.getElementById("login-password").value;
  var phoneError = document.getElementById('login-phone-error-message');
  var passwordError = document.getElementById('login-password-error-message');
  const phonePattern = /^\d+$/;
  const passwordPattern = /^(?=.*\d)(?=.*[a-zA-Z])(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{8,}$/;
  if (phone.trim() === "" && password.trim() === "") {
    alert("Please fill in both phone number and password fields.");
    return false;
  } else {
    if (phone.trim() === "") {
      phoneError.innerHTML = "Please enter your phone Number.";
      document.getElementById('login-phone-no').style.borderColor = "red";
      return false;
    } else if (!phone.match(phonePattern)) {
      phoneError.innerHTML = "Phone number should contain only numbers.";
      document.getElementById('login-phone-no').style.borderColor = "red";
      return false;
    } else {
      phoneError.innerHTML = "";
      document.getElementById('login-phone-no').style.borderColor = "green";
    }
    if (password.trim() === "") {
      passwordError.innerHTML = "Please enter your password.";
      document.getElementById('login-password').style.borderColor = "red";
      return false;
    } else if (!password.match(passwordPattern)) {
      document.getElementById('login-password').style.borderColor = "red";
      passwordError.innerHTML = "Password should contain at least one letter, one number, and one special character and be at least 8 characters long.";
      return false;
    } else {
      passwordError.innerHTML = "";
      document.getElementById('login-password').style.borderColor = "green";
    }
  }
  loginForm.submit();
});
/*
*MAIN CHATPAGE (functions to set theme and to store sessions).
*/
//changing the theme
var light = true;
function changeTheme(){
    let theme_image = document.getElementById('theme-image');
    let changeStyleSheet = document.getElementById("stylesheet");
    // let theme_name = docoment.getElementById('theme');
    if(light){
        theme_image.src = '/Layouts/Files/light-img.svg';
        changeStyleSheet.href = "dark.css";
        light = false;
        // theme_name.innerHTML = "Light Mode";
    }   else {
        theme_image.src = '/Layouts/Files/dark-img.svg';
        changeStyleSheet.href = "style.css"; 
        light = true;
        //theme_name.innerHTML = "Dark Mode";
    }
}
// A function to display the floating action buttons
function actionButtons() {
    let buttons = document.getElementById('floating-buttons-container');
      if(buttons.style.display=== "none"){
        buttons.style.display= "block";
      } else {
        buttons.style.display = "none";
      }
    let button_show = document.getElementById('add-file-button');
    button_show.addEventListener("blur", () => {
    buttons.style.display = "none";
    });
}
//showing the settings fo a smaller screen and hiding it when ignored
function showSettings() {
    let settingsMenu =  document.getElementById('settings-menu');
    if(settingsMenu.style.display=== "none"){
       settingsMenu.style.display= "block";
       // document.addEventListener("click", hideDiv);
    }  else {
       settingsMenu.style.display = "none";
    }
/** adding an on ignore functionality*/
}

/**
 * THE MESSAGE SENDING PART
 */
function clearInput() {
  document.getElementById("message-body").value = "";
}

//on send
function sendMessage() {
//div that contains messages.
  var parentDiv = document.getElementById("messages");
//div that contains the whole chat part.
var messageContainerDiv = document.createElement("div");
    messageContainerDiv.className = "message-and-profile-container";
    parentDiv.appendChild(messageContainerDiv);
    messageDiv.className = "message-and-profile-container";
//div that contains the profile pic.
var profileDiv = document.createElement("div");
    profileDiv.className = "message-and-profile-container";
    messageContainerDiv.appendChild(profileDiv);
    messageDiv.className = "profile-pic";
//div that contains the message.
var message = document.getElementById("message-body").value;
var messageDiv = document.createElement("div");
var text = document.createElement("p");
var userName = document.createElement("Strong");
var phoneNumber = document.createElement("strong");
var sendTime = document.createElement("em");

    messageDiv.className = "sent";
    text.innerHTML = message;
    messageDiv.appendChild(text);
    messageContainerDiv.appendChild(messageDiv);
}


