//show the messages of a given group once it has been selected
function showSelectedGroupMessages(){
    if(xmlphoneNumber ===sessionNumber){//when message was sent by me
        displaySentMessages(messageId, messageBody, sendTime, jsonGroupId);
    } else {//when message was sent by others
        showReceivedMessages(messageId, phoneNumber, userName, messageBody, sendTime, jsonGroupId);
    }
        //put the current message into view
}
function displaySentMessages(messageId, messageBody, sendTime, jsonGroupId) {
    const messagesContainer = document.querySelector(".messages");
    const groupContainer = document.createElement("div");
          groupContainer.className = jsonGroupId;
          messagesContainer.appendChild(groupContainer);
   var conntent_and_profileDiv = document.createElement("div");
     conntent_and_profileDiv.id = messageId;
     groupContainer.appendChild(conntent_and_profileDiv);
     //div that contains the profile pic.
     var profileDiv = document.createElement("div");
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
           conntent_and_profileDiv.appendChild(contentDiv);
         //create the elements to contain the message_body, username, phone, and send time
         var messageText = document.createElement("p");
             messageText.innerHTML = messageBody;
             contentDiv.appendChild(messageText);
         var sendTime = document.createElement("em");
             sendTime.innerHTML = xmlsendTime;
             contentDiv.appendChild(sendTime);
     conntent_and_profileDiv.className = "sent-container";
     profileDiv.className = "profile-pic";
     contentDiv.className = "sent";
     var currrenMessage = document.getElementById(messageId);
     if (currrenMessage) {
         currrenMessage.scrollIntoView();
     }
 }
 function showReceivedMessages(messageId, phoneNumber, userName, messageBody, sendTime, jsonGroupId){
    const messagesContainer = document.querySelector(".messages");
    const groupContainer = document.createElement("div");
          groupContainer.className = jsonGroupId;
          messagesContainer.appendChild(groupContainer);
     //div that contains the whole message-part.profile and content
     var conntent_and_profileDiv = document.createElement("div");
       conntent_and_profileDiv.id = messageId;
       groupContainer.appendChild(conntent_and_profileDiv);
       //div that contains the profile pic.
       var profileDiv = document.createElement("div");
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
             conntent_and_profileDiv.appendChild(contentDiv);
         //create the elements to contain the message_body, username, phone, and send time
           var userName = document.createElement("Strong");
               userName.innerHTML = userName;
               contentDiv.appendChild(userName);
           var phoneNumber = document.createElement("strong");
               phoneNumber.innerHTML = "~"+phoneNumber
               contentDiv.appendChild(phoneNumber);
           var messageText = document.createElement("p");
               messageText.innerHTML = messageBody;
               contentDiv.appendChild(messageText);
           var sendTime = document.createElement("em");
               sendTime.innerHTML = sendTime;
               contentDiv.appendChild(sendTime);
     conntent_and_profileDiv.className = "recieved-container";
     profileDiv.className = "sender-pic";
     contentDiv.className = "recieved";
     var currrenMessage = document.getElementById(messageId);
     if (currrenMessage) {
         currrenMessage.scrollIntoView();
     }
 }