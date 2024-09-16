<?php
include_once("../php/session.php");
include_once("../php/protect.php");
protectAdm(0);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../styles/style.css" />
    <title> Adicionar Atividades </title>
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
                <?php echo !empty($_SESSION['id']) ? $_SESSION['nome'] : "Usuário"; ?></label>
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
    </header>

    <form method="POST" class="fundo">
        <div class="containerimagem">
            <img class="imagem" src="../assets/Adicionarativ.png">
            <input class="bntadd" type="submit" value="Enviar Atividade">
        </div>

        <div class="containertexto">
            <input class="titulotext" type="text" id="titulo" placeholder="Digite o nome da atividade:"
                name="atividade">
            <p class="obs"> Abaixo adicione as informações de forma curta para execução da atividade</p>
            <input class="obsadd" type="text" placeholder="Adicionar descrição" name="atividade">

        </div>

        <div class="containeradicional">
            <input class="pontos" type="number" placeholder="Quantidade de Pontos" name="pontos">
            <input class="pontos" type="number" placeholder="Nível de Autismo" name="pontos">
            <input class="pontos" type="date" placeholder="Data Inicial (Mentor)" name="pontos">
            <input class="pontos" type="datetime-local" placeholder="Data Final (Aluno)" name="pontos">
            <label class="audio"> Adicionar áudio/pdf:</label>
            <input class="audio1" type="file" placeholder="Adicionar PDF" name="pontos">


        </div>
    </form>

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