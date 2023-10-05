/* 
* Add a scroll animation to the header
*/
const headers = document.getElementsByTagName("header");

if (headers.length > 0) {
   const header = headers[0];

   const headerPosition = header.offsetTop;

   // Function to handle the scroll event
   function handleScroll() {

      const scrollPosition = window.pageYOffset;

      if (scrollPosition > headerPosition) {
         header.classList.add("scrolled");
      } else {
         header.classList.remove("scrolled");
      }
   }

   // Attach the handleScroll function to the scroll event
   window.addEventListener("scroll", handleScroll);
}


// // Add an effect to display the menu for small devices
//       const menuBtn = document.getElementById("menu-btn");
//       const navBar = document.getElementById("nav-bar");

//       menuBtn.addEventListener("click", function(){
//             if (navBar.style.display === "none") {
//                   navBar.style.display = "flex";
//                   navBar.style.animation = "navBarAnimate 1s 1";
//                   navBar.className = "toggled-nav ctr-column";
                  
//             } else {
//                   navBar.className = "";
//                   navBar.style.animation = "navBarRm 1s 1";
//                   navBar.style.display = "none";
//             }
            
//       });


// toggle the side bar in chat page

  const sideMenuBtn = document.getElementById("side-menu-btn");
      const sideBar = document.getElementById("side-bar");

      sideMenuBtn.addEventListener("click", function(){
            if (sideBar.style.display === "none") {
                  sideBar.style.display = "grid";
            } else {
                  sideBar.style.display = "none";
            }
      });