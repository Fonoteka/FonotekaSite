<?php
include_once("../php/session.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../styles/style.css" />
  <title>Fonoteka</title>
</head>

<body>
  <header>
    <a class="link_img" href="./index.php">
      <img class="img_logo" src="../assets/Logo.png" />Fonotéka
    </a>

    <div class="opcoes_div">
      <a href="./index.php"> Home </a>
      <a href="./sobrenos.php"> Sobre nós </a>
      <a href=""> Aluno </a>
      <a href="./guia.php"> Guia </a>
    </div>

    <div class="div_usuario">
      <img id="perfil_usuario" class="img_perfil" src="../assets/perfil-Icon.png" />
      <label for="perfil_usuario" class="perfil_label">Usuário</label>
    </div>


    <img class="menu_hamburguer" src="../assets/menu.png" alt="">
    <nav>

      <section>
        <div class="menu_opcoes_div">
          <a href="./index.php"> Home </a>
          <a href="./sobrenos.php"> Sobre nós </a>
          <a href=""> Aluno </a>
          <a href="./guia.php"> Guia </a>
        </div>
        <hr>
        <div class="menu_div_usuario">
          <img id="perfil_usuario" class="img_perfil" src="../assets/perfil-Icon.png" />
          <label for="perfil_usuario" class="perfil_label">Usuário</label>
        </div>
      </section>

    </nav>
  </header>

  <section class="cadastro">
    <h1 class="titulo">Cadastro</h1>

    <form class="formulario" action="../php/cadastro.php" method="post">
      <input type="text" name="nome" placeholder="Nome" required />
      <input type="text" name="usuario" placeholder="Usuário" required />
      <input type="email" name="email" placeholder="E-mail" required />
      <input type="date" name="nascimento" placeholder="Data de Nascimento" required />
      <input type="tel" name="telefone" placeholder="Telefone" required />
      <select name="genero">
        <option value="">Selecione o genero</option>
        <option value="homem">Homem</option>
        <option value="mulher">Mulher</option>
        <option value="mulher">Não-binário</option>
        <option value="mulher">Prefiro não dizer</option>
      </select>
      <input type="password" name="senha" id="senha" placeholder="Senha" required />
      <div class="div_pConf">
        <input type="password" name="confSenha" id="confSenha" placeholder="Confirmar Senha" required />
        <p class="p_conf">Senha não coincidem</p>
      </div>
      <div class="div-politicas">
        <input type="checkbox" name="politicas" id="politicas" required />
        <label for="politicas">
          Li e estou de acordo com as políticas de privacidade.*
        </label>
      </div>
      <input type="submit" value="Cadastrar" name="SendNovoUsuario" />
    </form>
  </section>

  <dialog>
    <h1 id="msgCadastro"></h1>
    <button id="buClose" class="buClose">Fechar</button>
  </dialog>

  <script src="../js/index.js"></script>
</body>

<?php

echo !empty($_SESSION['msgCadastro']) ? $_SESSION['msgCadastro'] : "";
$_SESSION['msgCadastro'] = "";

?>

</html>