<?php
include_once("../php/conexao.php");
include_once("../php/session.php");

$sql = $conn->prepare("SELECT idGuia,nomeGuia,descricao,nomeArquivo,nomeAutor FROM tb_guias");
$sql->execute();
$result = $sql->get_result();
$guias = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../styles/style.css">
  <title>Guia Educacional</title>
</head>

<body>
  <header>
    <a class="link_img" href="">
      <img class="img_logo" src="../assets/Logo.png" />Fonoteka
    </a>

    <div class="opcoes_div">
      <a href="./index.php"> Home </a>
      <a href=""> Sobre nós </a>
      <a href=""> Aluno </a>
      <a href=""> Guia </a>
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

      } else {
        foreach ($guias as $index => $value) {

          $idGuia = intval($value['idGuia']);
          $sql = $conn->query("SELECT IdImagem FROM tb_guias WHERE idGuia = $idGuia");

          if ($sql) {
            $idImagem = $sql->fetch_assoc();

            if ($idImagem) {
              $idImagemValue = intval($idImagem['IdImagem']);
              $sql = $conn->query("SELECT * FROM tb_Imagens WHERE IdImagem = $idImagemValue");

              if ($sql) {
                $imagem = $sql->fetch_all(MYSQLI_ASSOC);

                echo "<li class=\"guia_item\">";
                echo !empty($imagem) ? "<img src=\"{$imagem[0]['path']}\" alt=\"\">" : "<img src=\"path/default.jpg\" alt=\"Imagem não encontrada\">";
                echo "<div>";
                echo "<h1>{$value['nomeGuia']}</h1>";
                echo "<h2>{$value['descricao']}</h2>";
                echo "</div>";
                echo "<p>@{$value['nomeAutor']}</p>";
                echo "</li>";

              } else {
                echo "Erro ao buscar imagem.";
              }
            } else {
              echo "IdImagem não encontrado.";
            }
          } else {
            echo "Erro ao buscar guia.";
          }
        }

      }
      ?>
    </section>
  </main>

  <dialog>
    <h1 id="msgCadastro"></h1>
    <button id="buClose" class="buClose">Fechar</button>
  </dialog>

  <script src="../js/index.js"></script>
</body>


<?php

include('../php/conexao.php');
include('../php/login.php');

?>

</html>