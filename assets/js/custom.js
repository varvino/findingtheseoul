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

var slider = document.querySelector('.items');
var isDown = false;
var startX;
var scrollLeft;
slider.addEventListener('mousedown', function (e) {
  isDown = true;
  slider.classList.add('active');
  startX = e.pageX - slider.offsetLeft;
  scrollLeft = slider.scrollLeft;
});
slider.addEventListener('mouseleave', function () {
  isDown = false;
  slider.classList.remove('active');
});
slider.addEventListener('mouseup', function () {
  isDown = false;
  slider.classList.remove('active');
});
slider.addEventListener('mousemove', function (e) {
  if (!isDown) return;
  e.preventDefault();
  var x = e.pageX - slider.offsetLeft;
  var walk = (x - startX) * 3; //scroll-fast

  slider.scrollLeft = scrollLeft - walk;
  console.log(walk);
});
"use strict";

// First we get the viewport height and we multiple it by 1% to get a value for a vh unit
var vh = window.innerHeight * 0.01; // Then we set the value in the --vh custom property to the root of the document

document.documentElement.style.setProperty('--vh', "".concat(vh, "px"));