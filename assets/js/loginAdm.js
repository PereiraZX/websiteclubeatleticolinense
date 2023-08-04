'use strict';

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


if (localStorage.getItem('darkMode') === null){
    localStorage.setItem('darkMode', "false");
}

checkStatus()

function checkStatus(){
    if (localStorage.getItem('darkMode') === "true"){
        document.body.classList = "dark-mode";
    } else {
        document.body.classList = "";
    }
}

function changeStatus(){                                          
    if (localStorage.getItem('darkMode') === "true"){                 
        localStorage.setItem('darkMode', "false");                  
        document.body.classList = "";
    } else{
        localStorage.setItem('darkMode', "true");                  
        document.body.classList = "dark-mode";
    }
}