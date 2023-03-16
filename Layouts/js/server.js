//get the session phone number
var sessionUserPhoneNumber;
function getSessionPhoneNumber() {
  var xhr = new XMLHttpRequest();
  xhr.open('GET', '/server/php/getSessionNum.php');
  xhr.onload = function() {
    if (xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      sessionUserPhoneNumber = response.phoneNumber;
    }
  };
  xhr.send();
 return sessionUserPhoneNumber;
}
getSessionPhoneNumber();
//connect to the websocket
const socket = new WebSocket('ws://localhost:8080');
socket.addEventListener('open', function (event) {
    console.log('WebSocket connection established.');
});

  socket.addEventListener('message', function (event) {
    const message = JSON.parse(event.data);
    //Booleans to handle a blocked message.
    const blocked = message.blocked;
    if(blocked){
      //show a you are blocked message.
      const information = message.info;
      showWarning(information);

    }else {//if user is not blocked proceed to next step
          //when a message meets all the expected terms of use
          var userName = message.username;
          var groupId = message.group_id;
          const GoodMessage = message.good_message;
          if(GoodMessage){
            var messageText = message.message;
            showReceivedMessages(userName, phoneNumber, messageText, groupId)
          }
          //when a message voilates terms of use.     
          const BadMessage = message.bad_message;
          if(BadMessage){
              const hasBeenBlocked = message.has_been_blocked;
              const youWereBlocked = message.you_were_blocked;
              const cantBeDisplayed = message.cant_be_displayed;
              const warn = message.warning;
              var information = message.message;
              if(hasBeenBlocked){
                showGroupUpdates(information, userName, groupId);
              }
              if(youWereBlocked){
                showPersonUpdates(information, groupId);
              }
              if(cantBeDisplayed){
                showReceivedMessages(userName, phoneNumber, messageText, groupId)
              }
              if(warn){
                warningsNum = message.warnings;
                showWarning(information, parseInt(warningsNum), groupId);
              }
          }
    }
    console.log('Received message:', message);
});

//get the current time stamp:
function getCurrentTime() {
    const date = new Date();
    const hours = String(date.getHours()).padStart(2, '0'); 
    const minutes = String(date.getMinutes()).padStart(2, '0'); 
    const time = `${hours}:${minutes}`; 
    return time;
  }
function submitMessage(){
    var messagebox = document.getElementById('message-body');
    var groupId = messagebox.className;
    var message = messagebox.value;
    var phoneNumber = getSessionPhoneNumber();
    console.log("your phone number is : "+ sessionUserPhoneNumber);
      if(message.trim() === ""){
        messagebox.style.borderColor = "gray";
      }else{
        sendMessage(phoneNumber, groupId, message);
        messagebox.value = "";
        messagebox.style.borderColor = "";
      } 
}
function sendMessage(phoneNumber,groupId, message) {
  var data = {
      phone_number: phoneNumber,
      message: message,
      group_id: groupId
  };
  showSentMessages(message, groupId);
  var messageData = JSON.stringify(data);
  socket.send(messageData);
}


function showReceivedMessages(jsonuserName, jsonphoneNumber, jsonmessageText, groupId){
  const messagesDiv = document.getElementById("group"+groupId);
  //div that contains the whole message-part.profile and content
  var conntent_and_profileDiv = document.createElement("div");
    messagesDiv.appendChild(conntent_and_profileDiv);
    conntent_and_profileDiv.className = "recieved-container";
    //div that contains the profile pic.
    var profileDiv = document.createElement("div");
        profileDiv.className = "sender-pic";
        conntent_and_profileDiv.appendChild(profileDiv);
      //create an element to contain the profile pic.
      var profilePhoto = document.createElement("img");
            profilePhoto.width = "";
            profilePhoto.height = "";
            profilePhoto.src = "Files/user-img.svg";
            profilePhoto.alt = "";
            profileDiv.appendChild(profilePhoto);
      //div that contains the message.
      var contentDiv = document.createElement("div");
          contentDiv.className = "recieved";
          conntent_and_profileDiv.appendChild(contentDiv);
      //create the elements to contain the message_body, username, phone, and send time
        var userName = document.createElement("Strong");
            userName.innerHTML = jsonuserName;
            contentDiv.appendChild(userName);
        var phoneNumber = document.createElement("strong");
            phoneNumber.innerHTML = "~"+jsonphoneNumber;
            contentDiv.appendChild(phoneNumber);
        var messageText = document.createElement("p");
            messageText.innerHTML = jsonmessageText;
            contentDiv.appendChild(messageText);
        var sendTime = document.createElement("em");
            sendTime.innerHTML = getCurrentTime();
            contentDiv.appendChild(sendTime);
      //put the current message into view
  conntent_and_profileDiv.scrollIntoView();
  console.log(GoodMessage);
}
function showSentMessages(message, groupId){
  console.log(groupId);
  const messagesDiv = document.getElementById("group"+groupId);
  //div that contains the whole message-part.profile and content
  var conntent_and_profileDiv = document.createElement("div");
    messagesDiv.appendChild(conntent_and_profileDiv);
    conntent_and_profileDiv.className = "sent-container";
    //div that contains the profile pic.
    var profileDiv = document.createElement("div");
        profileDiv.className = "profile-pic";
        conntent_and_profileDiv.appendChild(profileDiv);
      //create an element to contain the profile pic.
      var profilePhoto = document.createElement("img");
            profilePhoto.width = "";
            profilePhoto.height = "";
            profilePhoto.src = "Files/user-img.svg";
            profilePhoto.alt = "";
            profileDiv.appendChild(profilePhoto);
      //div that contains the message.
      var contentDiv = document.createElement("div");
          contentDiv.className = "sent";
          conntent_and_profileDiv.appendChild(contentDiv);
      //create the elements to contain the message_body, username, phone, and send time
        var messageText = document.createElement("p");
            messageText.innerHTML = message;
            contentDiv.appendChild(messageText);
        var sendTime = document.createElement("em");
            sendTime.innerHTML = getCurrentTime();
            contentDiv.appendChild(sendTime);
      //put the current message into view
  conntent_and_profileDiv.scrollIntoView();
}
function showWarning(information, groupId){
  const messagesDiv = document.getElementById("group"+groupId);
  //div that contains the whole message-part.profile and content
  var conntent_and_profileDiv = document.createElement("div");
    messagesDiv.appendChild(conntent_and_profileDiv);
    conntent_and_profileDiv.className = "warning-message-container";
      var contentDiv = document.createElement("div");
          contentDiv.className = "warning";
          conntent_and_profileDiv.appendChild(contentDiv);
      //create the elements to contain the message_body, username, phone, and send time
        var messageText = document.createElement("p");
            messageText.innerHTML = information;
            contentDiv.appendChild(messageText);
      //put the current message into view
      conntent_and_profileDiv.scrollIntoView();
}
//display the icoming updates for everyone.
function showGroupUpdates(information, userName, groupId){
  const messagesDiv = document.getElementById("group"+groupId);
        var warningDiv = document.createElement("div");
            warningDiv.className = "warning-message-container";
            messagesDiv.appendChild(warningDiv);
            var warnigText = document.createElement("p");
                warnigText.innerHTML = userName + ": "+ information;
                warningDiv.appendChild(warnigText);
    warningDiv.scrollIntoView();
}
//display the personal updates.
function showPersonUpdates(information, groupId){
  const messagesDiv = document.getElementById("group"+groupId);
        var warningDiv = document.createElement("div");
            warningDiv.className = "warning-message-container";
            messagesDiv.appendChild(warningDiv);
            var warnigText = document.createElement("p");
                warnigText.innerHTML = information;
                warningDiv.appendChild(warnigText);
    warningDiv.scrollIntoView();
}