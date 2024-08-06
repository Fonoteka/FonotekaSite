const msgStatus = document.getElementById("msgCadastro"); //Atribui o elemento do html para a constante
const modal = document.querySelector("dialog"); //Atribui o elemento do html para a constante
const buttonClose = document.getElementById("buClose"); //Atribui o elemento do html para a constante

function msg(texto) {
  //Função que mostra o popUp e exibe um texto
  msgStatus.innerHTML = texto;
  modal.showModal();
}

buttonClose.onclick = function () {
  ////Quando o buttonClose for clicado fechará o popUp
  modal.close();
};
