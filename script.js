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