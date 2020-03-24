//$(this).toggleClass("is-active");
window.addEventListener("DOMContentLoaded", (event) => {
    burger();
    currentMenu();
})

function burger(){
    burger = document.querySelector('.hamburger');
    menu = document.querySelector('#menu');
    title = document.querySelector('#menu .title');
    nav = document.querySelector('#menu .nav-menu');
    siteContent = document.querySelector('.site-content');

    burger.addEventListener("click", function(){
        menu.classList.toggle("burger-click");
        title.classList.toggle('burger-click');
        burger.classList.toggle("is-active");
        nav.classList.toggle("burger-click");
        siteContent.classList.toggle("burger-click");
    })
}

function currentMenu(){
    navLinks = document.querySelectorAll('.nav-item');
    navLinks.forEach(active);

    function active (navLink){
        navLink.onclick = function(){
            this.classList.add('active')
        }
    }
}
