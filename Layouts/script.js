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
    document.getElementById('login-page').style.display = 'none';
    document.getElementById('chat-page').style.display = 'block';
    document.getElementById('register-page').style.display = 'none';
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
        theme_image.src = '/Files/light-img.svg';
        changeStyleSheet.href = "style.css";
        light = false;
        // theme_name.innerHTML = "Light Mode";
    }else {
        theme_image.src = '/Files/dark-img.svg';
         changeStyleSheet.href = "dark.css"; 
         light = true;
        //  theme_name.innerHTML = "Dark Mode";
    }
}