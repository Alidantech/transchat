//show a list of users
function showUsers( userId, userName, phoneNumber, joinOn) {
    const usersContainer = document.querySelector(".users");
    const usersDetails = document.createElement("div");
        usersDetails.className = "users-details";
        usersContainer.appendChild(groupDetails);
        const img = document.createElement("img");
              img.src = "Files/user-img.svg";
              img.width = "35vw";
              img.height = "35vw";
              img.alt = "";
              usersDetails.appendChild(img);
        const userNameBox = document.createElement("strong");
              usersDetails.appendChild(groupNameBox);
        const phoneNumberBox = document.createElement("p");
              usersDetails.appendChild(sentAtBox);
        const joinOnBox = document.createElement("mark");
              usersDetails.appendChild(lastMessageBox);
}