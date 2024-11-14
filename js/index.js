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
  if (msgP) {
    msgP.innerHTML = texto;
  }
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
  if (msgStatus) {
    msgStatus.innerHTML = texto;
    modal.showModal();
  }
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

const btnAddGuia = document.querySelector(".button_addGuia");
const pGuia = document.querySelector(".guiaP");

window.addEventListener("resize", () => {
  if (window.screen.width > 830 && nav) {
    nav.classList.remove("visible");
  }

  if (window.screen.width < 830 && perfil_usuario) {
    popLogin.classList.remove("visible");
  }

  if (btnAddGuia) {
    let windowWidth = window.screen.width * 0.05;
    let btnWidth = parseFloat(pGuia.offsetWidth + windowWidth);
    btnAddGuia.style.width = btnWidth + "px";
  }
});

if (menuHamburguer && nav) {
  menuHamburguer.addEventListener("click", () => {
    nav.classList.toggle("visible");
    popLogin.classList.remove("visible");
  });
}

if (perfil_usuario_menu) {
  perfil_usuario_menu.addEventListener("click", () => {
    popLogin.classList.toggle("visible");
    nav.classList.remove("visible");
    if (popLogin.classList.contains("visible")) {
      email.removeAttribute("disabled");
      senha.removeAttribute("disabled");
    } else {
      email.setAttribute("disabled", "true");
      senha.setAttribute("disabled", "true");
    }
  });
}

const listAjuda = document.querySelectorAll("li");

if (listAjuda) {
  listAjuda.forEach((guia) => {
    guia.addEventListener("click", (event) => {
      const checkBox = event.currentTarget.querySelector(".checkAjuda");
      if (checkBox) {
        checkBox.checked = !checkBox.checked;
      }
    });
  });
}

function loading(state) {
  const loading = document.querySelector(".loader");
  if (state == true) {
    loading.classList.remove("loader-hidden");
  } else {
    loading.classList.add("loader-hidden");
  }
}
