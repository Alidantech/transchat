var sessionNumber;
//get the session number.
function getNumber(){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/server/php/getSessionNum.php');
    xhr.onload = function() {
        if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
            sessionNumber = response.phoneNumber;
        };
    }
    xhr.send();
 return sessionUserPhoneNumber;
}
getNumber();

document.addEventListener("DOMContentLoaded", function(){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {loadMessagesFunction(this);}
    xhttp.open("POST", "/server/xml/groupmessages.xml");
    xhttp.send();
    //a variable and a function to get the ssession number of the current user.
    //get the session phone number
function loadMessagesFunction(xml) {
        const xmlData = xml.responseXML;
        const groups = xmlData.getElementsByTagName("group");
              // iterate over each group
              for (let i = 0; i < groups.length; i++) {
              const groupId = groups[i].getAttribute("id");
              const mainContainer = document.querySelector(".messages");
              const container = document.createElement("div");
              container.id = "group"+groupId;
              container.className = "currentChat-container";
              container.style.display = "none";
              mainContainer.appendChild(container);
              // get all messages in the group
              const messages = groups[i].getElementsByTagName("message");
              // iterate over each message in the group
              for (let j = 0; j < messages.length; j++) {
                  const messageId = messages[j].getElementsByTagName("message_id")[0].childNodes[0].nodeValue;
                  const userName = messages[j].getElementsByTagName("user_name")[0].childNodes[0].nodeValue;
                  const phoneNumber = messages[j].getElementsByTagName("phone_number")[0].childNodes[0].nodeValue;
                  const messageBody = messages[j].getElementsByTagName("message_body")[0].childNodes[0].nodeValue;
                  const sentAt = messages[j].getElementsByTagName("sent_at")[0].childNodes[0].nodeValue;
                  if(phoneNumber === sessionNumber){//when message was sent by me
                  displaySentMessages(messageId, messageBody, sentAt, container);
                  } else {//when message was sent by others
                  showReceivedMessages(messageId, phoneNumber, userName, messageBody, sentAt, container);
                  }
              }
        }
        }
    
function displaySentMessages(messageId, xmlmessageBody, xmlsendTime, container) {
    var conntent_and_profileDiv = document.createElement("div");
    conntent_and_profileDiv.id = "m"+messageId;
    container.appendChild(conntent_and_profileDiv);
   //div that contains the profile pic.
   var profileDiv = document.createElement("div");
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
           messageText.innerHTML = xmlmessageBody;
           contentDiv.appendChild(messageText);
       var sendTime = document.createElement("em");
           sendTime.innerHTML = xmlsendTime;
           contentDiv.appendChild(sendTime);
   conntent_and_profileDiv.className = "sent-container";
   profileDiv.className = "profile-pic";
   contentDiv.className = "sent";   var currrentMessage = document.getElementById(messageId);
   if (currrentMessage) {
       currrentMessage.scrollIntoView();
   }
}
function showReceivedMessages(messageId, xmlphoneNumber, xmluserName, xmlmessageBody, xmlsendTime, container){
    var conntent_and_profileDiv = document.createElement("div");
      conntent_and_profileDiv.id = "m"+messageId;
      container.appendChild(conntent_and_profileDiv);
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
             userName.innerHTML = xmluserName;
             contentDiv.appendChild(userName);
         var phoneNumber = document.createElement("strong");
             phoneNumber.innerHTML = "~"+xmlphoneNumber;
             contentDiv.appendChild(phoneNumber);
         var messageText = document.createElement("p");
             messageText.innerHTML = xmlmessageBody;
             contentDiv.appendChild(messageText);
         var sendTime = document.createElement("em");
             sendTime.innerHTML = xmlsendTime;
             contentDiv.appendChild(sendTime);
   conntent_and_profileDiv.className = "recieved-container";
   profileDiv.className = "sender-pic";
   contentDiv.className = "recieved";
   var currrentMessage = document.getElementById(messageId);
   if (currrentMessage) {
       currrentMessage.scrollIntoView();
   }
}
});
   
   