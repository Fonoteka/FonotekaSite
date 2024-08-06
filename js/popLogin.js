const perfil_usuario = document.querySelector("#perfil_usuario");
const popLogin = document.querySelector(".popLogin");
const email = document.querySelector("#email");
const senha = document.querySelector("#senha");

perfil_usuario.addEventListener("click", () => {
  popLogin.classList.toggle("visible");
  if(popLogin.classList.contains("visible")){
    email.removeAttribute('disabled');
    senha.removeAttribute('disabled');
  } else{
    email.setAttribute('disabled', 'true');
    senha.setAttribute('disabled', 'true');
  }
});
