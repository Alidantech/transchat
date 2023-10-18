/**
 * Import all the necessary modules
 */
import {ShowSettings} from './ui/settingUi.js'

/***
 * Create a functionality of displaying the settings menu when a user clicks the button.
 */
document.getElementById('settings-btn').addEventListener("click", () => {
    ShowSettings();
});
