"use strict";

const buttonSubmitRegister = document.querySelector(".button-submit-cadastro");
buttonSubmitRegister.addEventListener("click", submitRegister);

async function submitRegister() {
    let user_adm = document.querySelector("#user_adm").value;
    let email_adm = document.querySelector("#email_adm").value;
    let senha_adm = document.querySelector("#senha_adm").value;
    let confimar_senha_adm = document.querySelector("#confirmar_senha").value;

    const url = `http://localhost/WEBSITELINENSE/api/model/admController.php?operation=create&user_adm=${user_adm}&email_adm=${email_adm}&senha_adm=${senha_adm}&confirmar_senha=${confimar_senha_adm}`;

    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      }
    });

    const data = await response.json();
    console.log(data);

    // window.location.href = "http://localhost/WEBSITELINENSE/assets/login/view/loginAdm.html"
}
