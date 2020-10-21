"use strict";

/* ========================================================
    TABLE OF CONTENT
==========================================================
    1. VARIABLES
    2. FUNCTIONS
    3. FETCH
======================================================== */

/* ========================================================
    1. VARIABLES
======================================================== */
var url = 'https://www.instagram.com/findingtheseoul/?__a=1';
/* ========================================================
    2. FUNCTIONS
======================================================== */

function createNode(element) {
  return document.createElement(element);
}

function append(parent, el) {
  return parent.appendChild(el);
}
/* ========================================================
    3. FETCH
======================================================== */


if (location.pathname == '/') {
  fetch(url).then(function (resp) {
    return resp.json();
  }).then(function (data) {
    var gallery = document.querySelector('.instagram-gallery');
    var feed = data.graphql.user.edge_owner_to_timeline_media.edges.slice(0, 4).map(function (post) {
      var a = createNode('a'),
          img = createNode('img'),
          span = createNode('span'),
          overlay = createNode('div');
      a.href = "https://www.instagram.com/p/".concat(post.node.shortcode);
      a.target = '_blank';
      a.classList.add('instagram-gallery__item');
      img.src = post.node.display_url;
      img.classList.add('instagram-gallery__image');
      span.innerHTML = "View on Instagram";
      append(a, img);
      append(a, span);
      append(a, overlay);
      append(gallery, a);
    });
  });
}
"use strict";

// First we get the viewport height and we multiple it by 1% to get a value for a vh unit
var vh = window.innerHeight * 0.01; // Then we set the value in the --vh custom property to the root of the document

document.documentElement.style.setProperty('--vh', "".concat(vh, "px"));
"use strict";

/* Open when someone clicks on the span element */
function openNav() {
  document.querySelector(".navmenu-overlay").style.left = "0";
}
/* Close when someone clicks on the "x" symbol inside the overlay */


function closeNav() {
  document.querySelector(".navmenu-overlay").style.left = "-100vw";
}