//get the session phone number
let sessionUserPhoneNumber;
function getSessionPhoneNumber() {
  var xhr = new XMLHttpRequest();
  xhr.open('GET', '/Server_Scripts/getSessionNum.php');
  xhr.onload = function() {
    if (xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      sessionUserPhoneNumber = response.phoneNumber;
      console.log("Phone number: " + sessionUserPhoneNumber);
    }
  };
  xhr.send();
}
getSessionPhoneNumber();

//connect to the websocket
const socket = new WebSocket('ws://localhost:8080?phone_number='+sessionUserPhoneNumber);

socket.addEventListener('open', function (event) {
    console.log('WebSocket connection established.');
});

let jsongoodMessage;

socket.addEventListener('message', function (event) {
    const message = JSON.parse(event.data);
    //TODO: after making the data carry a json format parse it to javascript using json.parse().
    console.log('Received message:', message);
    var jsonuserName = message.user_name;
    var jsonphoneNumber = message.phone_number;
    var jsonmessageText = message.message;
    jsongoodMessage = message.good_message;
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
    
      console.log(jsongoodMessage);
   
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
        sendMessage(sessionUserPhoneNumber, message);
        //TODO: make the user to see his message by creating a div containing the message. and the current time.
        //show a warning message if the message contains bad words.
        if(jsongoodMessage){//message is good..
          console.log(jsongoodMessage);
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
        }else {//show a warnig message
          const messagesDiv = document.querySelector(".messages");
              //div that contains the whole message-part.profile and content
              var conntent_and_profileDiv = document.createElement("div");
                messagesDiv.appendChild(conntent_and_profileDiv);
                conntent_and_profileDiv.className = "update-container";
                  var contentDiv = document.createElement("div");
                      contentDiv.className = "warning";
                      conntent_and_profileDiv.appendChild(contentDiv);
                  //create the elements to contain the message_body, username, phone, and send time
                    var messageText = document.createElement("p");
                        messageText.innerHTML = "using bad language might get you removed!!";
                        contentDiv.appendChild(messageText);
                  //put the current message into view
                  conntent_and_profileDiv.scrollIntoView();
        }
        messagebox.value = "";
        messagebox.style.borderColor = "";
      } 
}

function sendMessage(phoneNumber, message) {
  var data = {
      phone_number: phoneNumber,
      message: message
  };
  var messageData = JSON.stringify(data);
  socket.send(messageData);
}


