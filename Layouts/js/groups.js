// this is to query database for data about the groups.

function loadDoc() {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {loadGroups(this);}
  xhttp.open("POST", "/Server_Scripts/groups.xml");
  xhttp.send();
}
function loadGroups(xml) {
      const xmlDoc = xml.responseXML;
      const groups = xmlDoc.getElementsByTagName("GROUPS");
      for (let i = 0; i < groups.length; i++) {
        const group = groups[i];
        const groupId = group.getElementsByTagName("group_id")[0].textContent;
        const groupName = group.getElementsByTagName("group_name")[0].textContent;
        const senderName = group.getElementsByTagName("sender_name")[0].textContent;
        const lastMessage = group.getElementsByTagName("message_body")[0].textContent;
        const sentAt = group.getElementsByTagName("send_at")[0].textContent;
        //DISPLAY THE GROUPS.
        showGroups(groupId, groupName,senderName, lastMessage, sentAt);
        console.log("happened")
      }
      
}
// 1. loading all the groups created showing their name and last sent message.
function showGroups( groupId, groupName, senderName, lastMessage, sentAt) {

    console.log(groupId)
    const groupsContainer = document.querySelector(".groups");
    const groupDetails = document.createElement("div");
        groupDetails.className = "group-details";
        groupDetails.id = groupId;
        groupsContainer.appendChild(groupDetails);
        const img = document.createElement("img");
              img.src = "Files/user-img.svg";
              img.width = "35vw";
              img.height = "35vw";
              img.alt = "";
              groupDetails.appendChild(img);
        const groupNameBox = document.createElement("strong");
              groupDetails.appendChild(groupNameBox);
              groupNameBox.innerHTML = groupName;
        const sentAtBox = document.createElement("mark");
              groupDetails.appendChild(sentAtBox);
              sentAtBox.innerHTML = sentAt;
        const lastMessageBox = document.createElement("p");
              groupDetails.appendChild(lastMessageBox);
              lastMessageBox.innerHTML = senderName + ": " + lastMessage;
}

 