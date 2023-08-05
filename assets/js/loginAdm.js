<<<<<<< HEAD
'use strict';
=======
"use strict";
>>>>>>> aad3b13a813a8a2b034292e5cb7f7563fe3e5664

// VER SENHA
const buttonVerSenha = document.querySelector("#button-ver-senha");
buttonVerSenha.addEventListener("click", () => {
    let inputSenha = document.querySelector("#senha");

    if(inputSenha.type === "password") {
        inputSenha.type = "text";
        buttonVerSenha.classList.replace("fa-eye-slash", "fa-eye");
    } else {
        inputSenha.type = "password";
        buttonVerSenha.classList.replace("fa-eye", "fa-eye-slash");
    }
})

// DARKMODE / LOCAL STORAGE
const buttonDarkMode = document.querySelector(".button-dark-mode");
buttonDarkMode.addEventListener("click", changeStatus);


<<<<<<< HEAD
if (localStorage.getItem('darkMode') === null){
    localStorage.setItem('darkMode', "false");
=======
if (localStorage.getItem("darkMode") === null){
    localStorage.setItem("darkMode", "false");
>>>>>>> aad3b13a813a8a2b034292e5cb7f7563fe3e5664
}

checkStatus()

function checkStatus(){
<<<<<<< HEAD
    if (localStorage.getItem('darkMode') === "true"){
=======
    if (localStorage.getItem("darkMode") === "true"){
>>>>>>> aad3b13a813a8a2b034292e5cb7f7563fe3e5664
        document.body.classList = "dark-mode";
    } else {
        document.body.classList = "";
    }
}

function changeStatus(){                                          
<<<<<<< HEAD
    if (localStorage.getItem('darkMode') === "true"){                 
        localStorage.setItem('darkMode', "false");                  
        document.body.classList = "";
    } else{
        localStorage.setItem('darkMode', "true");                  
        document.body.classList = "dark-mode";
    }
}
=======
    if (localStorage.getItem("darkMode") === "true"){                 
        localStorage.setItem("darkMode", "false");                  
        document.body.classList = "";
    } else{
        localStorage.setItem("darkMode", "true");                  
        document.body.classList = "dark-mode";
    }
}
>>>>>>> aad3b13a813a8a2b034292e5cb7f7563fe3e5664
