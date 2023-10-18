/**
 * Create the ui dom elelments for all the settings on the page
 */

function ShowSettings(){
            // Create the parent div with the class "nav-heading ctr-row"
      const navHeading = document.createElement("div");
      navHeading.classList.add("nav-heading", "ctr-row");

      // Create the first child div with the class "ctr-row-start"
      const ctrRowStart = document.createElement("div");
      ctrRowStart.classList.add("ctr-row-start");

      // Create the <h1> element and set its text content to "Chats"
      const h1Element = document.createElement("h1");
      h1Element.textContent = "Chats";

      // Append the <h1> element to the "ctr-row-start" div
      ctrRowStart.appendChild(h1Element);

      // Create the second child div with the class "ctr-items"
      const ctrItems = document.createElement("div");
      ctrItems.classList.add("ctr-items");

      // Create the button element with an <i> element inside it
      const buttonElement = document.createElement("button");
      const iElement = document.createElement("i");
      iElement.classList.add("fas", "fa-sort");
      buttonElement.appendChild(iElement);

      // Create the <span> element with the class "sorted-by" and set its text content to "Newest"
      const spanElement = document.createElement("span");
      spanElement.classList.add("sorted-by");
      spanElement.textContent = "Newest";

      // Append the button and <span> elements to the "ctr-items" div
      ctrItems.appendChild(buttonElement);
      ctrItems.appendChild(spanElement);

      // Append the "ctr-row-start" and "ctr-items" divs to the "nav-heading" div
      navHeading.appendChild(ctrRowStart);
      navHeading.appendChild(ctrItems);

      // Append the "nav-heading" div to the document's body or any other parent element
      document.body.appendChild(navHeading);

}

export {ShowSettings};