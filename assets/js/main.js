//$(this).toggleClass("is-active");

window.addEventListener("DOMContentLoaded", (event) => {
    burger();
    currentMenu();
});

function burger(){
    let burger = document.querySelector('.hamburger');
    let menu = document.querySelector('#menu');
    let title = document.querySelector('#menu .title');
    let nav = document.querySelector('#menu .nav-menu');
    let siteContent = document.querySelector('.site-content');

    burger.addEventListener("click", function(){
        menu.classList.toggle("burger-click");
        title.classList.toggle('burger-click');
        burger.classList.toggle("is-active");
        nav.classList.toggle("burger-click");
        siteContent.classList.toggle("burger-click");
    })
}

function currentMenu(){
    let navLinks = document.querySelectorAll('.nav-item');
    navLinks.forEach(active);

    function active (navLink){
        navLink.onclick = function(){
            this.classList.add('active')
        }
    }
}

