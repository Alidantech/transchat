/**
 * THE MESSAGE SENDING PART
 */
//Get the session number from the server in order to display messages sent by the current user on the right.
var sessionPhoneNumber;
function getSessionPhoneNumber() {
  var xhr = new XMLHttpRequest();
  xhr.open('GET', '/Server_Scripts/getSessionNum.php');
  xhr.onload = function() {
    if (xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      sessionPhoneNumber = response.phoneNumber;
    }
  };
  xhr.send();
}
// Call the function when the page loads or when the user logs in
getSessionPhoneNumber();
//load the messages from the server using an ajax request  
loadDoc();
function loadDoc() {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {loadMessagesFunction(this);}
  xhttp.open("POST", "/Server_Scripts/messages.xml");
  xhttp.send();
}
//Display the messages on the page by loading the xml document returned from the server.
function loadMessagesFunction(xml) {
  const sessionNumber = sessionPhoneNumber;
  const xmlDoc = xml.responseXML;
  const messages = xmlDoc.getElementsByTagName("message");
  for (let i = 0; i < messages.length; i++) {
    const message = messages[i];
    const messageId = message.getElementsByTagName("message_id")[0].textContent;
    const xmluserName = message.getElementsByTagName("user_name")[0].textContent;
    const xmlphoneNumber = message.getElementsByTagName("phone_number")[0].textContent;
    const xmlmessageBody = message.getElementsByTagName("message_body")[0].textContent;
    const xmlsendTime = message.getElementsByTagName("send_time")[0].textContent;
    // Display the message information on a web page.
    //display messages sent by curent user differently.
    console.log(messageId);
    if(xmlphoneNumber ===sessionNumber){//when message was sent by me
      displaySentMessages(messageId,xmlmessageBody, xmlsendTime);
    } else {//when message was sent by others
      showReceivedMessages(messageId, xmlphoneNumber, xmluserName, xmlmessageBody, xmlsendTime);
    }
    //put the current message into view
    var currrenMessage = document.getElementById(messageId);
    if (currrenMessage) {
        currrenMessage.scrollIntoView();
    }
  }
}
  //on send
function displaySentMessages(messageId,xmlmessageBody, xmlsendTime) {
   //select the div that contains messages.
  const messagesDiv = document.querySelector(".messages");
  //div that contains the whole message-part.profile and content
  var conntent_and_profileDiv = document.createElement("div");
    conntent_and_profileDiv.id = messageId;
    messagesDiv.appendChild(conntent_and_profileDiv);
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
    contentDiv.className = "sent";
}
function showReceivedMessages(messageId, xmlphoneNumber, xmluserName, xmlmessageBody, xmlsendTime){
    //select the div that contains messages.
    const messagesDiv = document.querySelector(".messages");
    //div that contains the whole message-part.profile and content
    var conntent_and_profileDiv = document.createElement("div");
      conntent_and_profileDiv.id = messageId;
      messagesDiv.appendChild(conntent_and_profileDiv);
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
              phoneNumber.innerHTML = "~"+xmlphoneNumber
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
}
  
  