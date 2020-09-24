"use strict";

/* Open when someone clicks on the span element */
function openNav() {
  document.querySelector(".navmenu-overlay").style.left = "0";
}
/* Close when someone clicks on the "x" symbol inside the overlay */


function closeNav() {
  document.querySelector(".navmenu-overlay").style.left = "-100vw";
}
"use strict";

// First we get the viewport height and we multiple it by 1% to get a value for a vh unit
var vh = window.innerHeight * 0.01; // Then we set the value in the --vh custom property to the root of the document

document.documentElement.style.setProperty('--vh', "".concat(vh, "px"));