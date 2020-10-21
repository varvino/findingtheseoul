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
const url = 'https://www.instagram.com/findingtheseoul/?__a=1';

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
    fetch(url)
        .then((resp) => resp.json())
        .then(function (data) {
            const gallery = document.querySelector('.instagram-gallery')

            const feed = data.graphql.user.edge_owner_to_timeline_media.edges.slice(0, 4).map(post => {
                const a = createNode('a'),
                    img = createNode('img'),
                    span = createNode('span'),
                    overlay = createNode('div')
                a.href = `https://www.instagram.com/p/${post.node.shortcode}`
                a.target = '_blank'
                a.classList.add('instagram-gallery__item')
                img.src = post.node.display_url
                img.classList.add('instagram-gallery__image')
                span.innerHTML = "View on Instagram"
                append(a, img);
                append(a, span)
                append(a, overlay)
                append(gallery, a);
            })
        })
}