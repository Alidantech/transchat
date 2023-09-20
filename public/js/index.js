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
