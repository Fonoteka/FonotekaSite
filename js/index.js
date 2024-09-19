const msgStatus = document.getElementById("msgCadastro");
const modal = document.querySelector("dialog");
const buttonClose = document.getElementById("buClose");

const perfil_usuario = document.querySelector(".div_usuario");
const perfil_usuario_menu = document.querySelector(".menu_div_usuario");
const popLogin = document.querySelector(".popLogin");
const email = document.querySelector("#email");
const senha = document.querySelector("#senha");

const msgP = document.querySelector("#msg");

function msgTexto(texto) {
  msgP.innerHTML = texto;
}

if (perfil_usuario) {
  perfil_usuario.addEventListener("click", () => {
    popLogin.classList.toggle("visible");
    if (popLogin.classList.contains("visible")) {
      email.removeAttribute("disabled");
      senha.removeAttribute("disabled");
    } else {
      email.setAttribute("disabled", "true");
      senha.setAttribute("disabled", "true");
    }
  });
}

function msgPop(texto) {
  msgStatus.innerHTML = texto;
  modal.showModal();
}

if (buttonClose) {
  buttonClose.onclick = function () {
    modal.close();
  };
}

const inpSenha = document.querySelector("#senha");
const inpConf = document.querySelector("#confSenha");
const txtConf = document.querySelector(".p_conf");

if (inpSenha && inpConf) {
  inpConf.addEventListener("input", (e) => {
    if (inpConf.value !== inpSenha.value) {
      txtConf.classList.add("naoCoincidem");
    } else {
      txtConf.classList.remove("naoCoincidem");
    }
  });

  inpSenha.addEventListener("input", (e) => {
    if (inpConf.value !== inpSenha.value) {
      txtConf.classList.add("naoCoincidem");
    } else {
      txtConf.classList.remove("naoCoincidem");
    }
  });
}

const menuHamburguer = document.querySelector(".menu_hamburguer");
const nav = document.querySelector("nav");


window.addEventListener("resize", () => {
  if(window.screen.width > 830){
    nav.classList.remove("visible");
  }
});

if(menuHamburguer && nav){
  menuHamburguer.addEventListener('click', () => {
    nav.classList.toggle("visible")
    popLogin.classList.remove("visible");
  })
}

if(perfil_usuario_menu){
  perfil_usuario_menu.addEventListener('click', () => {
    popLogin.classList.toggle("visible");
    nav.classList.remove("visible");
    if (popLogin.classList.contains("visible")) {
      email.removeAttribute("disabled");
      senha.removeAttribute("disabled");
    } else {
      email.setAttribute("disabled", "true");
      senha.setAttribute("disabled", "true");
    }
  })
}
