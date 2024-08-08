<?php
include_once ("./php/conexao.php");
include_once ("./php/session.php");

$sql = $conn->prepare("SELECT nomeGuia,descricao,nomeArquivo,nomeAutor FROM tb_guias");
$sql->execute();
$result = $sql->get_result();
$guias = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/style.css">
  <title>Guia Educacional</title>
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
      <a href=""> Guia </a>
    </div>

    <div class="div_usuario">
      <img id="perfil_usuario" class="img_perfil" src="assets/perfil-Icon.png" />
      <label for="perfil_usuario"
        class="perfil_label"><?php echo !empty($_SESSION['id']) ? $_SESSION['nome'] : "Usuário"; ?>
      </label>
    </div>

    <form class="popLogin" method="POST">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required disabled>
      <label for="senha">Senha:</label>
      <input type="password" id="senha" name="senha" required disabled>
      <input type="submit" value="Acessar">
    </form>
  </header>

  <main>
    <section class="guia">
      <?php
      if ($result->num_rows == 0) {
        echo "<div class=\"error\">";
        echo "<p class=\"error_menssage\">INFELIZMENTE NÃO POSSUIMOS NENHUM GUIA EDUCACIONAL DISPONIVEL NO MOMENTO</p>";
        echo "<a href=\"./index.php\">Voltar à tela principal</a>";
        echo "</div>";
        //Fazer um popUp bonitão avisando que estamos com problema na abas guias
      } else {
        foreach ($guias as $key => $value) {
          echo "<li class=\"guia_item\">";
          echo "<img src=\"./assets/tela-preta.png\" alt=\"\">";
          echo "<div>";
          echo "<h1>{$value['nomeGuia']}</h1>";
          echo "<h2>{$value['descricao']}</h2>";
          echo "</div>";
          echo "<p>@{$value['nomeAutor']}</p>";
          echo "</li>";
        }
      }
      ?>
    </section>
  </main>

  <dialog>
    <h1 id="msgCadastro"></h1>
    <button id="buClose" class="buClose">Fechar</button>
  </dialog>

  <script src="./js/Modal.js"></script>
  <script src="./js/popLogin.js"></script>
</body>


<?php

include ('./php/conexao.php');

if (!empty($_POST['email']) && !empty($_POST['senha'])) {

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

    } else {
      echo "<script>msg('SENHA INCORRETA!!')</script>";
    }

  } else {
    echo "<script>msg('EMAIL INCORRETO!!')</script>";
  }
}

?>

</html>