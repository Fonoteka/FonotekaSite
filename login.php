<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="./styles/style.css">
  <title>Fonoteka</title>
</head>
</head>

<body>
  <header>
    <a class="link_img" href="">
      <img class="img_logo" src="assets/Logo.png" />Fonoteka
    </a>

    <div class="opcoes_div">
      <a href="./index.php"> Home </a>
      <a href=""> Sobre nós </a>
      <a href=""> Aluno </a>
      <a href="./guia.html"> Guia </a>
    </div>

    <img class="img_perfil" src="assets/perfil-Icon.png" />
  </header>

  <main class="main-login">
    <figure>
      <img id="imagem" src="assets/imagem.svg">
    </figure>

    <form method="post" class="login">
      <h1 class="titulo">Fazer Login</h1>
      <input type="text" name="email" placeholder="E-mail, Nome, Hash" required>
      <input type="password" name="senha" placeholder="Senha" required>
      <button>Entrar</button>
      <a href="./cadastro.php" class="login-links">Não possui conta ainda?</a>
      <a href="" class="login-links">Esqueceu a senha?</a>
    </form>
  </main>

  <dialog>
    <h1 id="msgCadastro"></h1>
    <button id="buClose" class="buClose">Fechar</button>
  </dialog>

  <script src="./js/Modal.js"></script>
</body>

</html>

<?php

include ('./php/conexao.php');

if (isset($_POST['email']) && isset($_POST['senha'])) {

  $email = $_POST['email'];
  $senha = $_POST['senha'];

  $email = $conn->real_escape_string($_POST['email']);
  $senha = $conn->real_escape_string($_POST['senha']);

  $sql = $conn->prepare("SELECT * FROM tb_cadastroMentor WHERE email=?");
  $sql->bind_param("s", $email);
  $sql->execute();
  $result = $sql->get_result();

  $user = $result->fetch_assoc();

  if ($result->num_rows == 1) {

    if (password_verify($senha, $user['Senha'])) {

      if (!isset($_SESSION)) {
        session_start();
      }

      $_SESSION['id'] = $user['IdMentor'];
      $_SESSION['nome'] = $user['Nome'];

      header("Location: index.php");
    } else {
      echo "<script>msg('SENHA INCORRETA!!')</script>";
    }

  } else {
    echo "<script>msg('EMAIL INCORRETO!!')</script>";
  }
}


?>