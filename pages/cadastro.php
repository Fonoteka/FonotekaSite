<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../styles/style.css" />
  <script src="../js/index.js" defer></script>
  <title>Fonoteka</title>
</head>

<body>
  <header>
    <a class="link_img" href="./index.php">
      <img class="img_logo" src="../assets/Logo.png" />Fonoteka
    </a>

    <div class="opcoes_div">
      <a href="./index.php"> Home </a>
      <a href=""> Sobre nós </a>
      <a href=""> Aluno </a>
      <a href="./guia.php"> Guia </a>
    </div>

    <div class="div_usuario">
      <img id="perfil_usuario" class="img_perfil"
        src="<?php echo !empty($_SESSION['path_img']) ? $_SESSION['path_img'] : '../assets/perfil-Icon.png' ?>" />
      <label for="perfil_usuario" class="perfil_label">
        <?php echo !empty($_SESSION['id']) ? $_SESSION['nome'] : "Usuário"; ?></label>
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

  <section class="cadastro">
    <h1 class="titulo">Cadastro</h1>

    <form class="formulario" method="post">
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
      <input type="password" name="confSenha" id="confSenha" placeholder="Confirmar Senha" required />
      <div class="div-politicas">
        <input type="checkbox" name="politicas" id="politicas" required />
        <label for="politicas">
          Li e estou de acordo com as políticas de privacidade.*
        </label>
      </div>
      <input type="submit" value="Cadastrar" />
    </form>
  </section>

  <dialog>
    <h1 id="msgCadastro"></h1>
    <button id="buClose" class="buClose">Fechar</button>
  </dialog>

  <script src="../js/index.js"></script>
</body>

</html>


<?php

include('../php/conexao.php');

if (isset($_POST['nome']) && isset($_POST['usuario']) && isset($_POST['email']) && isset($_POST['nascimento']) && isset($_POST['telefone']) && isset($_POST['genero']) && isset($_POST['senha']) && isset($_POST['confSenha']) && isset($_POST['politicas'])) {
  $nome = $_POST['nome'];
  $usuario = $_POST['usuario'];
  $email = $_POST['email'];
  $obj_nascimento = new DateTime($_POST['nascimento']);
  $nascimento = $obj_nascimento->format('Y-m-d');
  $genero = $_POST['genero'];
  $tel = $_POST['telefone'];
  $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
  $confSenha = $_POST['confSenha'];
  $politicas = $_POST['politicas'];


  $hoje = new DateTime(date('Y/m/d'));
  $diff = $hoje->diff($obj_nascimento);
  $diff = $diff->y;

  // if ($senha === $confSenha) {
  if ($diff >= 18) {
    $sql = $conn->prepare("SELECT IdMentor, Nome FROM tb_cadastro WHERE email = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
      echo ("<script>msg('Usuário já cadastrado');</script>");
    } else {
      $sql = $conn->prepare("INSERT INTO tb_cadastro(Nome, Email, Telefone, Senha, Usuario, DataNascimento, Genero, Funcao) VALUES (?, ?, ?, ?, ?, ?, ?, 0)");
      $sql->bind_param("sssssss", $nome, $email, $tel, $senha, $usuario, $nascimento, $genero);
      $sql->execute();
      $result = $sql->get_result();
      echo ("<script>msg('Usuário cadastrado');</script>");
    }
  } else {
    echo ("<script>msg('Idade minima não atendida');</script>");
  }
  // } else {
  //   echo ("<script>msg('As senhas não coincidem');</script>");
  // }

}
?>