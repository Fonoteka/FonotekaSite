<?php
include_once("../php/conexao.php");
include_once("../php/session.php");
include_once("../php/protect.php");
protectAdm(0);

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

    <?php
    echo "<form class=\"popLogin\" action=\"../php/login.php\" method=\"POST\">";
    if (isset($_SESSION['id'])) {
      echo "<button class=\"alt_cont\">Configurações conta</button>";
      echo "<a class=\"btn_logout\" href=\"./logout.php\">Sair</a>";
    } else {
      echo "<label for=\"email\">Email:</label>";
      echo "<input type=\"email\" id=\"email\" name=\"email\" required disabled>";
      echo "<label for=\"senha\">Senha:</label>";
      echo "<input type=\"password\" id=\"senha\" name=\"senha\" required disabled>";
      echo "<a class=\"link_popLogin\" href=\"./esqSenha.php\">Esqueceu a senha?</a>";
      echo "<input class=\"alt_cont\" type=\"submit\" value=\"Acessar\">";
      echo "<a class=\"link_popLogin\" href=\"./cadastro.php\">Sem conta?</a>";
    }
    echo "</form>";
    ?>

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
          <img id="perfil_usuario" class="img_perfil"
            src="<?php echo !empty($_SESSION['path_img']) ? $_SESSION['path_img'] : '../assets/perfil-Icon.png' ?>" />
          <label for="perfil_usuario" class="perfil_label">
            <?php echo !empty($_SESSION['id']) ? $_SESSION['nome'] : "Usuário"; ?>
          </label>
        </div>
      </section>

    </nav>
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
    <?php echo $_SESSION['funcao'] ? "<a class=\"button_addGuia\" href=\"./guiaForm.php\">Adicionar Guia</a>" : "" ?>
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