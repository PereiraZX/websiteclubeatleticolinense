'use strict'

const buttonDarkMode = document.querySelector("#button-dark-mode");
buttonDarkMode.querySelector("#icon-light-mode").style.display = "none";

buttonDarkMode.addEventListener("click", () => {
    if (document.body.classList == "dark-mode") {
        document.body.classList.remove("dark-mode");
        buttonDarkMode.querySelector("#icon-dark-mode").style.display = "block";
        buttonDarkMode.querySelector("#icon-light-mode").style.display = "none";
    } else {
        document.body.classList.add("dark-mode");
        buttonDarkMode.querySelector("#icon-dark-mode").style.display = "none";
        buttonDarkMode.querySelector("#icon-light-mode").style.display = "block";
    }
});

const buttonMenu = document.querySelector(".navbar_button");

buttonMenu.addEventListener("click", showNavbarSide);
buttonMenu.addEventListener("touchstart", showNavbarSide);

function showNavbarSide(e) {
    if(e.type === "touchstart") e.preventDefault();

    buttonMenu.classList.toggle("active");

    let navbarSide = document.querySelector(".navbar-side");
    navbarSide.classList.toggle("active");
}

