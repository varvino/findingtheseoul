/* Open when someone clicks on the span element */
function openNav() {
    document.querySelector(".navmenu-overlay").style.left = "0";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
    document.querySelector(".navmenu-overlay").style.left = "-100vw";
}