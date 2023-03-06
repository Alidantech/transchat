const socket = new WebSocket('ws://localhost:8080');

socket.addEventListener('open', function (event) {
    console.log('WebSocket connection established.');
});

socket.addEventListener('message', function (event) {
    const message = event.data;//TODO: after making the data carry a json format parse it to javascript using json.parse().
    console.log('Received message:', message);
  // TODO: Update chat UI with received message, create div elements to show the new messages.
  const messagesDiv = document.querySelector(".messages");
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
            userName.innerHTML = "username";
            contentDiv.appendChild(userName);
        var phoneNumber = document.createElement("strong");
            phoneNumber.innerHTML = "~phone"
            contentDiv.appendChild(phoneNumber);
        var messageText = document.createElement("p");
            messageText.innerHTML = message;
            contentDiv.appendChild(messageText);
        var sendTime = document.createElement("em");
            sendTime.innerHTML = getCurrentTime();
            contentDiv.appendChild(sendTime);
      //put the current message into view
      conntent_and_profileDiv.scrollIntoView();
});
//get the current time stamp:
function getCurrentTime() {
    const date = new Date();
    const hours = String(date.getHours()).padStart(2, '0'); // get hours and pad with leading zero if necessary
    const minutes = String(date.getMinutes()).padStart(2, '0'); // get minutes and pad with leading zero if necessary
    const time = `${hours}:${minutes}`; // concatenate hours and minutes with a colon
    return time;
  }//console.log(getCurrentTime()); // output: "19:35" (assuming the current time is 7:35 PM)
  
  
//get the message from the user in order to send it.
function submitMessage(){
    var messagebox = document.getElementById('message-body');
    var message = messagebox.value; //TODO: make sure a user does not send a blank message. and color the send button accordingly.
      if(message.trim() === ""){
        messagebox.style.borderColor = "gray";
      }else{
        //TODO: make the user to see his message by creating a div containing the message. and the current time.
    const messagesDiv = document.querySelector(".messages");
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
        sendMessage(message);
        messagebox.value = "";
        messagebox.style.borderColor = "";
      } 
}
function sendMessage(message) {
    socket.send(message);
}

