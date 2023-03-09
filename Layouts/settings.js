 /*
  *SETTINGS (functions to set theme and to store sessions).
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
/**TODO: add an on(BLUR) ignore functionality*/
}

/** A FUNCTION THAT DYNAMICALLY CHANGES THE PAGES IN VIEW*/
let menu =  document.querySelector('.dashboard');
let inbox =  document.querySelector('.inbox');
let addnew =  document.querySelector('.addnew');
let groups =  document.querySelector('.groups');
let account =  document.querySelector('.account');
let about =  document.querySelector('.about-us');
function showInbox() {
    inbox.style.display = "block";
    menu.style.display = "none";
}
function showAddnew() {
    addnew.style.display = "block";
    menu.style.display = "none";
}
function showGroups() {
    groups.style.display = "block";
    menu.style.display = "none";
}
function showAccount() {
    account.style.display = "block";
    menu.style.display = "none";
}
function showAboutUs() {
    about.style.display = "block";
    menu.style.display = "none";
}
function openDashboard() {
    if(menu.style.display === "none"){
        menu.style.display = "";
        inbox.style.display = "none";
        addnew.style.display = "none";
        groups.style.display = "none";
        account.style.display = "none";
        about.style.display = "none";
    }
}