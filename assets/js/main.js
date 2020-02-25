//$(this).toggleClass("is-active");
window.addEventListener("DOMContentLoaded", (event) => {
    burger = document.querySelector('.hamburger');
    menu = document.querySelector('#menu');
    title = document.querySelector('#menu .title');
    nav = document.querySelector('#menu .nav-menu');

    burger.addEventListener("click", function(){
        menu.classList.toggle("burger-click");
        title.classList.toggle('burger-click');
        burger.classList.toggle("is-active");
        nav.classList.toggle("burger-click");
    })
})

