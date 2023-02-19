// A function to display the floating action buttons
function actionButtons() {
  let buttons = document.getElementById('floating-buttons-container');
    if(buttons.style.display=== "none"){
        buttons.style.display= "block";
    }else {
        buttons.style.display = "none";
    }
    let button_show = document.getElementById('add-file-button');
   button_show.addEventListener("blur", () => {
       buttons.style.display = "none";
    });
}
// function to open the chat page for a registered user
function registeredSuccessifully(){
    // document.getElementById('login-page').style.display = 'none';
    // document.getElementById('chat-page').style.display = 'block';
    // document.getElementById('register-page').style.display = 'none';
}

//showing the settings fo a smaller screen and hiding it when ignored
function showSettings() {
  let settingsMenu =  document.getElementById('settings-menu');
  if(settingsMenu.style.display=== "none"){
    settingsMenu.style.display= "block";
   // document.addEventListener("click", hideDiv);

}else {
    settingsMenu.style.display = "none";
}
/** adding an on ignore functionality*/
}


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
    }else {
        theme_image.src = '/Layouts/Files/dark-img.svg';
         changeStyleSheet.href = "style.css"; 
         light = true;
        //  theme_name.innerHTML = "Dark Mode";
    }
}

//function to validate the user inputs
function validateForm() {
    // Get form inputs
    const name = document.getElementById("user-name").value;
    const phone = document.getElementById("phone-no").value;
    const password = document.getElementById("password").value;
    var nameError = document.getElementById('name-error-message');
    var phoneError = document.getElementById('phone-error-message');
    var passwordError = document.getElementById('password-error-message');
    // Regular expression patterns for validation
    const namePattern = /^[a-zA-Z ]+$/;
    const phonePattern = /^\d+$/;
    const passwordPattern = /^(?=.*\d)(?=.*[a-zA-Z])(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{8,}$/;
    //check that the fields are not empty
    if (name.trim() === "") {
        nameError.innerHTML =  "Please enter your name.";
            return false;
        }
        if (phone.trim() === "") {
        phoneError.innerHTML =  "Please enter your phone Number.";
            return false;
        }
        if (password.trim() === "") {
        passwordError.innerHTML = "Please enter your password.";
            return false;
        }
    // Validate name
    if (!name.match(namePattern)) {
        nameError.innerHTML = "Name should contain only letters and spaces.";
        return false;
    }

    // Validate phone number
    if (!phone.match(phonePattern)) {
       phoneError.innerHTML = "Phone number should contain only numbers.";
        return false;
    }

    // Validate password
    if (!password.match(passwordPattern)) {
        passwordError.innerHTML ="Password should contain at least one letter, one number, and one special character and be at least 8 characters long.";
        return false;
    }

    // If all inputs are valid, return true
    nameError.innerHTML = "";
    phoneError.innerHTML = "";
    passwordError.innerHTML = "";
    return true;
}