<?php
include_once("../php/conexao.php");
include_once("../php/session.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../styles/style.css">
  <title>Ajuda</title>
</head>

<body>
  <header>
    <a class="link_img" href="./index.php">
      <img class="img_logo" src="../assets/Logo.png" />Fonoteka
    </a>

    <div class="opcoes_div">
      <a href="./index.php"> Home </a>
      <a href="./sobrenos.php"> Sobre nós </a>
      <a href="./atividades.php"> Aluno </a>
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
      echo "<a class=\"alt_cont\" href=\"./telaPerfil.php\">Configurações conta</a>";
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
          <a href="./atividades.php"> Aluno </a>
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
    <section class="ajuda">
      <h1>Duvidas frequentes</h1>

      <li class="ajuda_item">
        <input type="checkbox" class="checkAjuda">
        <div class="ajuda_item_principal">
          <h1>O que é Fonoteka?</h1>
          <img src="../assets/seta.svg" alt="">
        </div>
        <div class="ajuda_desc">
          <a href="./sobrenos.php"> SOBRE NÓS </a>
        </div>
      </li>

      <li class="ajuda_item">
        <input type="checkbox" class="checkAjuda">
        <div class="ajuda_item_principal">
          <h1>O que é TEA?</h1>
          <img src="../assets/seta.svg" alt="">
        </div>
        <div class="ajuda_desc">
          <p> TEA é a sigla para Transtorno do Espectro Autista, para saber mais clique abaixo para saber mais por meio
            de nossos guias </p> <a href="./guia.php"> GUIAS DE TEA </a>
        </div>
      </li>
      <li class="ajuda_item">
        <input type="checkbox" class="checkAjuda">
        <div class="ajuda_item_principal">
          <h1>Como criar uma conta?</h1>
          <img src="../assets/seta.svg" alt="">
        </div>
        <div class="ajuda_desc">
          <p>Para criar uma conta basta seguir o passo a passo: </p>
          <p> -Clique em "Usuário"</p>
          <p> -Acessar o link "Sem conta?"</p>
          <p> -É necessário preencher todos os campos requeridos</p>
          <p> -Selecionar a checkbox "Li e estou de acordo com as políticas de privacidade.* "</p>
          <p> -Após isso, basta clicar em CADASTRAR e a seguir já pode logar no site Fonoteka</p>
          <a href="./cadastro.php">CRIAR CONTA</a>
        </div>
      </li>

      <li class="ajuda_item">
        <input type="checkbox" class="checkAjuda">
        <div class="ajuda_item_principal">
          <h1>Para que o site Fonoteka é útil para você?</h1>
          <img src="../assets/seta.svg" alt="">
        </div>
        <div class="ajuda_desc">
          <p> O site Fonoteka é útil para todos os públicos e principalmente para tutores e professores de crianças com
            Transtorno do Espectro Autista,</p>
          <p> por conta da grande quantidade de ferramentas e organização que auxiliam no desenvolvimento da fala de
            crianças de forma lúdica </p>
        </div>
      </li>
      <li class="ajuda_item">
        <input type="checkbox" class="checkAjuda">
        <div class="ajuda_item_principal">
          <h1>Como adicionar uma atividade?</h1>
          <img src="../assets/seta.svg" alt="">
        </div>
        <div class="ajuda_desc">
          <p>Siga o passo a passo para adicionar uma nova atividade: </p>
          <p> -Entre com sua conta Fonoteka</p>
          <p> -Na página inicial role a tela para baixo</p>
          <p> -Clique no maior botão "Nova atividade"</p>
          <p> E pronto, já está pronto para adicionar uma nova atividade </p>
          <p> </p>
        </div>
      </li>
      <li class="ajuda_item">
        <input type="checkbox" class="checkAjuda">
        <div class="ajuda_item_principal">
          <h1>Esqueci minha senha, e agora?</h1>
          <img src="../assets/seta.svg" alt="">
        </div>
        <div class="ajuda_desc">
          <p>Siga o passo a passo para recuperar sua conta Fonoteka: </p>
          <p> -Clique em "Usuário"</p>
          <p> -Acessar o link "Esqueceu a senha?"</p>
          <p> -Insira o email</p>
          <p> -Será enviada uma notificação para você pelo email cadastrado* "</p>
          <p> -Altere a senha</p>
          <p> Assim estara pronta sua nova senha</p>
          <a href="./esqSenha.php">RECUPERAR CONTA</a>
        </div>
      </li>
      <li class="ajuda_item">
        <input type="checkbox" class="checkAjuda">
        <div class="ajuda_item_principal">
          <h1>Para que serve a aba "Guia?</h1>
          <img src="../assets/seta.svg" alt="">
        </div>
        <div class="ajuda_desc">
          <p>A aba "Guia" é focada para os tutores das crianças autistas, onde podem achar informações e </p>
          <p>se interar do assunto para auxiliar de forma correta os portadores do Transtorno do Espectro Autista </p>
          <p> -Acessar o link "Esqueceu a senha?"</p>
          <p> -Insira o email</p>
          <p> -Será enviada uma notificação para você pelo email cadastrado* "</p>
          <p> -Altere a senha</p>
          <p> Assim estara pronta sua nova senha</p>
        </div>
      </li>

      <li class="ajuda_item">
        <input type="checkbox" class="checkAjuda">
        <div class="ajuda_item_principal">
          <h1>Como ver as atividades lançadas?</h1>
          <img src="../assets/seta.svg" alt="">
        </div>
        <div class="ajuda_desc">
          <p>Para achar as informações referentes as atividades lançadas e pré-estabelecidas siga o passo a passo:</p>
          <p>se interar do assunto para auxiliar de forma correta os portadores do Transtorno do Espectro Autista </p>
          <p> -Entre com sua conta Fonoteka</p>
          <p> -Na página inicial role a tela para baixo</p>
          <p> -Clique no maior botão "Ver tarefas"</p>
          <p> E pronto, você conseguirar ter acesso a todas as atividades feitas por você, pré-estabelecidas e as
            concluidas por seus alunos.</p>
        </div>
      </li>

      <li class="ajuda_item">
        <input type="checkbox" class="checkAjuda">
        <div class="ajuda_item_principal">
          <h1>Como baixo o aplicativo para os portadores de TEA?</h1>
          <img src="../assets/seta.svg" alt="">
        </div>
        <div class="ajuda_desc">
          <p> Para fazer o download de nosso aplicativo basta você ir na loja de aplicativo "Playstore" e pesquisar por
            "Fonoteka,"</p>
          <p> após esse processo, basta clicar em "Instalar" e logar com a conta da criança préviamente criada no site
          </p>
        </div>
      </li>

      <li class="ajuda_item">
        <input type="checkbox" class="checkAjuda">
        <div class="ajuda_item_principal">
          <h1>Como sair de sua conta?</h1>
          <img src="../assets/seta.svg" alt="">
        </div>
        <div class="ajuda_desc">
          <p>Para sair de sua conta basta seguir o passo a passo: </p>
          <p> -Clique no seu nome, no canto superior direito</p>
          <p> -Clique em "Sair"</p>
          <p> E pronto, você fez o logout de sua conta</p>
        </div>
      </li>


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

echo !empty($_SESSION['msgLogin']) ? $_SESSION['msgLogin'] : "";
$_SESSION['msgLogin'] = "";
?>

</html>