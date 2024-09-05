<?php
include_once("../php/session.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/style.css">
  <title>Fonoteka</title>
</head>
</head>

<body>
  <header>
    <a class="link_img" href="./index.php">
      <img class="img_logo" src="../assets/Logo.png" />Fonoteka
    </a>

    <div class="opcoes_div">
      <a href="./index.php"> Home </a>
      <a href="./sobrenos.php"> Sobre nós </a>
      <a href=""> Aluno </a>
      <a href="./guia.php"> Guia </a>
    </div>

    <div class="div_usuario">
      <img id="perfil_usuario" class="img_perfil"
        src="<?php echo !empty($_SESSION['path_img']) ? $_SESSION['path_img'] : '../assets/perfil-Icon.png' ?>" />
      <label for="perfil_usuario" class="perfil_label">
        <?php echo !empty($_SESSION['id']) ? $_SESSION['nome'] : "Usuário"; ?>
      </label>
    </div>

    <form class="popLogin" method="POST">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required disabled>
      <label for="senha">Senha:</label>
      <input type="password" id="senha" name="senha" required disabled>
      <a class="link_popLogin" href="./esqSenha.php">Esqueceu a senha?</a>
      <input type="submit" value="Acessar">
      <a class="link_popLogin" href="./cadastro.php">Sem conta?</a>
      <a class="btn_logout" href="./logout.php">Sair</a>
    </form>
  </header>

  <div id="total">
    <div id="esquerda">

      <div id="titulo">
        <p id="sobrenos">Sobre nós</p>
      </div>

      <div id="geral">
        <img id="fotoescola" src="../assets/etec.png">
        <div id="geral2">
          <p id="iniciativa">Iniciativa</p>
          <p id="texto">Trabalho para
            conclusão de curso
            (Desenvolvimento de
            Sistemas 2024)</p>
        </div>
      </div>

      <div id="geral">
        <img id="fotoescola2" src="../assets/autismo.png">
        <div id="geral2">
          <p id="iniciativa">Foco</p>
          <p id="texto">Somos focados em
            auxiliar crianças com
            Transtorno do Espectro
            Autista (TEA),</p>
        </div>
      </div>

    </div>
    <div id="direita">
      <img id="logo" src="../assets/Logo.png">
    </div>
  </div>

</body>

<dialog>
  <h1 id="msgCadastro"></h1>
  <button id="buClose" class="buClose">Fechar</button>
</dialog>

<script src="../js/index.js"></script>

<?php

include('../php/conexao.php');
include('../php/login.php');

?>

</html>